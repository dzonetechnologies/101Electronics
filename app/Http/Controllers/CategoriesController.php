<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Brands;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('dashboard.categories.index');
    }

    function create()
    {
        // get list of brands
        $brands = Brands::all();
        return view('dashboard.categories.add', compact('brands'));
    }

    function getLastOrderNo()
    {
        $Category = DB::table('categories')
            ->where('deleted_at', '=', null)
            ->max('order_no');
        return $Category + 1;
    }

    function store(Request $request)
    {
        $FileName ="";
        if ($request->has('logo')) {
            $FileName = 'Category-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('logo')->extension();
            $request->file('logo')->storeAs('public/categories', $FileName);
        }
        DB::beginTransaction();
        $Affected = Categories::create([
            'order_no' => $this->getLastOrderNo(),
            'title' => $request->post('title'),
            'meta_title' => $request->post('metaTitle'),
            'description' => $request->post('description'),
            'homepage_selling_tagline' => $request->post('homepage_selling_tagline'),
            'brandpage_selling_tagline' => $request->post('brandpage_selling_tagline'),
            'categorypage_selling_tagline' => $request->post('categorypage_selling_tagline'),
            'icon' => $FileName,
            'brand' => implode(",",$request->post('brand')),
            'slug' => $request->post('slug'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('categories')->with('success-message', 'Category created successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('categories')->with('error-message', 'An unhandled error occurred.');
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
            $fetch_data = DB::table('categories')
                ->where('deleted_at', '=', null)
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('categories')
                ->where('deleted_at', '=', null)
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('categories')
                ->where('deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('meta_title', 'LIKE', '%' . $searchTerm . '%');
                })
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('categories')
                ->where('deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('meta_title', 'LIKE', '%' . $searchTerm . '%');
                })
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
            $Url = asset('public/storage/categories/' . $item->icon);
            $sub_array = array();
            $sub_array['order_no'] = $item->order_no;
            $sub_array['id'] = $SrNo;
            $sub_array['title'] = $item->title;
            $sub_array['meta_title'] = $item->meta_title;
            $sub_array['homepage_selling_tagline'] = $item->homepage_selling_tagline;
            $sub_array['brandpage_selling_tagline'] = $item->brandpage_selling_tagline;
            $sub_array['categorypage_selling_tagline'] = $item->categorypage_selling_tagline;
            $sub_array['logo'] = '<span><img src="' . $Url . '" alt="Category Image" class="img-fluid" style="width: 120px;" /></span>';
            $sub_array['brand'] = $Brands;
            $Action = "<span>";
            $EditUrl = route('categories.edit', array($item->id));
            $Id = $item->id;
            $OrderNo = $item->order_no;
            $Parameters = "this, '$Id', '$OrderNo'";
            $Action .= '<a href="javascript:void(0);" class="mr-2" onclick="CategoryOrderUp(' . $Parameters . ');"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0);" class="mr-2" onclick="CategoryOrderDown(' . $Parameters . ');"><i class="fa fa-arrow-down"></i></a><a href="' . $EditUrl . '"><i class="fa fa-pen text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DeleteCategory(\'' . $item->id . '\', \'' . base64_encode($item->title) . '\');"><i class="fa fa-trash text-color-red"></i></a>';
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

    function edit($CategoryId)
    {
        $brands = Brands::all();
        $Category = DB::table('categories')
            ->where('id', '=', $CategoryId)
            ->get();
        return view('dashboard.categories.edit', compact('Category', 'brands'));
    }

    function update(Request $request)
    {
        $FileName = $request->post('oldLogo');
        if ($request->has('logo')) {
            $Path = public_path('storage/categories') . '/' . $FileName;
            
            if (file_exists($Path)) {
            unlink($Path);
            }
            
            $FileName = 'Category-' . Carbon::now()->format('Y-m-d H-i-s');
            $FileName = $FileName . '.' . $request->file('logo')->extension();
            $request->file('logo')->storeAs('public/categories', $FileName);
        }
        DB::beginTransaction();
        $Affected = DB::table('categories')
            ->where('id', '=', $request->post('id'))
            ->update([
                'title' => $request->post('title'),
                'meta_title' => $request->post('metaTitle'),
                'description' => $request->post('description'),
                'homepage_selling_tagline' => $request->post('homepage_selling_tagline'),
                'brandpage_selling_tagline' => $request->post('brandpage_selling_tagline'),
                'categorypage_selling_tagline' => $request->post('categorypage_selling_tagline'),
                'icon' => $FileName,
                'brand' => implode(",",$request->post('brand')),
                'slug' => $request->post('slug'),
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('categories')->with('success-message', 'Category updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('categories')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function delete(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('categories')
            ->where('id', '=', $request->post('id'))
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('categories')->with('success-message', 'Category deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('categories')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function orderUp(Request $request)
    {
        $PreviousRecord = DB::table('categories')
            ->where('order_no', '<', $request->post('order_no'))
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'DESC')
            ->limit(1)
            ->get();
        if(sizeof($PreviousRecord) > 0){
            $PreviousOrderNo = $PreviousRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('categories')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $PreviousOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('categories')
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
        $NextRecord = DB::table('categories')
            ->where('order_no', '>', $request->post('order_no'))
            ->orderBy('order_no','ASC')
            ->limit(1)
            ->get();
        if(sizeof($NextRecord) > 0){
            $NextOrderNo = $NextRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('categories')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $NextOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('categories')
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
