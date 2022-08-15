<?php

namespace App\Http\Controllers;

use App\Models\Subcategories;
use App\Models\Brands;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('dashboard.subcategories.index');
    }

    function create()
    {
        $Categories = DB::table('categories')
            ->where('deleted_at', '=', null)
            ->get();
        return view('dashboard.subcategories.add', compact('Categories'));
    }

    function getLastOrderNo()
    {
        $SubCategory = DB::table('subcategories')
            ->where('deleted_at', '=', null)
            ->max('order_no');
        return $SubCategory + 1;
    }

    function store(Request $request)
    {
        DB::beginTransaction();
        $Affected = Subcategories::create([
            'order_no' => $this->getLastOrderNo(),
            'title' => $request->post('title'),
            'meta_title' => $request->post('metaTitle'),
            'category' => $request->post('category'),
            'description' => $request->post('description'),
            'brand' => implode(",",$request->post('brand')),
            'slug' => $request->post('slug'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('subcategories')->with('success-message', 'SubCategory created successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('subcategories')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function load(Request $request)
    {
        $limit = $request->post('length');
        $start = $request->post('start');
        $searchTerm = $request->post('search')['value'];

        $columnIndex = $request->post('order')[0]['column']; // Column index
        $columnName = $request->post('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->post('order')[0]['dir']; // asc or desc

        $fetch_data = null;
        $recordsTotal = null;
        $recordsFiltered = null;
        if ($searchTerm == '') {
            $fetch_data = DB::table('subcategories')
                ->join('categories', 'subcategories.category', '=', 'categories.id')
                ->where('subcategories.deleted_at', '=', null)
                ->select('subcategories.*', 'categories.title AS CategoryTitle')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('subcategories')
                ->join('categories', 'subcategories.category', '=', 'categories.id')
                ->where('subcategories.deleted_at', '=', null)
                ->select('subcategories.*', 'categories.title AS CategoryTitle')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('subcategories')
                ->join('categories', 'subcategories.category', '=', 'categories.id')
                ->where('subcategories.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('subcategories.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('subcategories.meta_title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('categories.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('categories.meta_title', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('subcategories.*', 'categories.title AS CategoryTitle')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('subcategories')
                ->join('categories', 'subcategories.category', '=', 'categories.id')
                ->where('subcategories.deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('subcategories.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('subcategories.meta_title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('categories.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('categories.meta_title', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('subcategories.*', 'categories.title AS CategoryTitle')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $brands = DB::table('brands')->where('deleted_at', '=', null)->get();
        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $category_brands = explode(",", $item->brand);
            $Brands = '<span>';
            foreach ($category_brands as $key => $value) {
                foreach ($brands as $key => $brand) {
                    if ($value == $brand->id) {
                        $Brands .= $brand->title . "<br><br>";
                    }
                }
            }
            $Brands .= '</span>';
            $sub_array = array();
            $sub_array['order_no'] = $item->order_no;
            $sub_array['id'] = $SrNo;
            $sub_array['title'] = $item->title;
            $sub_array['meta_title'] = $item->meta_title;
            $sub_array['category'] = $item->CategoryTitle;
            $sub_array['brand'] = $Brands;
            $Action = "<span>";
            $EditUrl = route('subcategories.edit', array($item->id));
            $Id = $item->id;
            $OrderNo = $item->order_no;
            $Parameters = "this, '$Id', '$OrderNo'";
            $Action .= '<a href="javascript:void(0);" class="mr-2" onclick="SubCategoryOrderUp(' . $Parameters . ');"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0);" class="mr-2" onclick="SubCategoryOrderDown(' . $Parameters . ');"><i class="fa fa-arrow-down"></i></a><a href="' . $EditUrl . '"><i class="fa fa-pen text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DeleteSubCategory(\'' . $item->id . '\', \'' . base64_encode($item->title) . '\');"><i class="fa fa-trash text-color-red"></i></a>';
            $Action .= "<span>";
            $sub_array['action'] = $Action;
            $SrNo++;
            $data[] = $sub_array;
        }

        $json_data = array(
            "draw" => intval($request->post('draw')),
            "iTotalRecords" => $recordsTotal,
            "iTotalDisplayRecords" => $recordsFiltered,
            "aaData" => $data
        );

        echo json_encode($json_data);
    }

    function edit($SubCategoryId)
    {
        $Categories = DB::table('categories')
            ->where('deleted_at', '=', null)
            ->get();
        $SubCategory = DB::table('subcategories')
            ->where('id', '=', $SubCategoryId)
            ->get();
        $CategoryDetails = DB::table('categories')
            ->where('id', '=', $SubCategory[0]->category)
            ->get();
        $brands = Brands::all();
        return view('dashboard.subcategories.edit', compact('SubCategory', 'Categories', 'CategoryDetails', 'brands'));
    }

    function update(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('subcategories')
            ->where('id', '=', $request->post('id'))
            ->update([
                'title' => $request->post('title'),
                'meta_title' => $request->post('metaTitle'),
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'brand' => implode(",",$request->post('brand')),
                'slug' => $request->post('slug'),
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('subcategories')->with('success-message', 'SubCategory updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('subcategories')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function delete(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('subcategories')
            ->where('id', '=', $request->post('id'))
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('subcategories')->with('success-message', 'SubCategory deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('subcategories')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function orderUp(Request $request)
    {
        $PreviousRecord = DB::table('subcategories')
            ->where('order_no', '<', $request->post('order_no'))
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'DESC')
            ->limit(1)
            ->get();
        if(sizeof($PreviousRecord) > 0){
            $PreviousOrderNo = $PreviousRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('subcategories')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $PreviousOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('subcategories')
                ->where('id', '=', $PreviousRecord[0]->id)
                ->update([
                    'order_no' => $request->post('order_no'),
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
            echo 'Success';
        } else {
            echo 'Success';
        }
        exit();
    }

    function orderDown(Request $request)
    {
        $NextRecord = DB::table('subcategories')
            ->where('order_no', '>', $request->post('order_no'))
            ->orderBy('order_no','ASC')
            ->limit(1)
            ->get();
        if(sizeof($NextRecord) > 0){
            $NextOrderNo = $NextRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('subcategories')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $NextOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('subcategories')
                ->where('id', '=', $NextRecord[0]->id)
                ->update([
                    'order_no' => $request->post('order_no'),
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
            echo 'Success';
        } else{
            echo 'Success';
        }
        exit();
    }
}
