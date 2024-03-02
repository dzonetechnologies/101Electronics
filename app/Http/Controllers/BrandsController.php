<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('dashboard.brands.index');
    }

    function create()
    {
        return view('dashboard.brands.add');
    }

    function getLastOrderNo()
    {
        $Brand = DB::table('brands')
            ->where('deleted_at', '=', null)
            ->max('order_no');
        return $Brand + 1;
    }

    function store(Request $request)
    {
        $FileName = "";
        if ($request->has('logo')) {
            $FileName = 'Brand-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('logo')->extension();
            $request->file('logo')->storeAs('public/brands', $FileName);
        }
        DB::beginTransaction();
        $Affected = Brands::create([
            'order_no' => $this->getLastOrderNo(),
            'title' => $request->post('name'),
            'image' => $FileName,
            'b2b' => $request->post('b2b'),
            'slug' => $request->post('slug'),
            'type' => $request->post('type'),
            'meta_title' => $request->post('metaTitle'),
            'description' => $request->post('description'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('brands')->with('success-message', 'Brand created successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('brands')->with('error-message', 'An unhandled error occurred.');
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
            $fetch_data = DB::table('brands')
                ->where('deleted_at', '=', null)
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('brands')
                ->where('deleted_at', '=', null)
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('brands')
                ->where('deleted_at', '=', null)
                ->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('brands')
                ->where('deleted_at', '=', null)
                ->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $Url = asset('public/storage/brands/' . $item->image);
            $sub_array = array();
            $sub_array['order_no'] = $item->order_no;
            $sub_array['id'] = $SrNo;
            $sub_array['title'] = $item->title;
            if ($item->b2b == 1) {
                $sub_array['b2b'] = "Yes";
            } else {
                $sub_array['b2b'] = "No";
            }
            if ($item->type == 0) {
                $sub_array['type'] = "Imported";
            } else {
                $sub_array['type'] = "Chinese";
            }
            $sub_array['logo'] = '<span><img src="' . $Url . '" alt="Brand Image" class="img-fluid" style="width: 120px;" /></span>';
            $Action = "<span>";
            $EditUrl = route('brands.edit', array($item->id));
            $Id = $item->id;
            $OrderNo = $item->order_no;
            $Parameters = "this, '$Id', '$OrderNo'";
            $Action .= '<a href="javascript:void(0);" class="mr-2" onclick="BrandOrderUp(' . $Parameters . ');"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0);" class="mr-2" onclick="BrandOrderDown(' . $Parameters . ');"><i class="fa fa-arrow-down"></i></a><a href="' . $EditUrl . '"><i class="fa fa-pen text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DeleteBrand(\'' . $item->id . '\', \'' . base64_encode($item->title) . '\');"><i class="fa fa-trash text-color-red"></i></a>';
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

    function edit($brandId)
    {
        $Brand = DB::table('brands')
            ->where('id', '=', $brandId)
            ->get();
        return view('dashboard.brands.edit', compact('Brand'));
    }

    function update(Request $request)
    {
        $FileName = $request->post('oldLogo');
        if ($request->has('logo')) {
            $Path = public_path('storage/brands') . '/' . $FileName;
            
            if (file_exists($Path)) {
               unlink($Path);
            }
            
            $FileName ="";
            $FileName = 'Brand-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('logo')->extension();
            $request->file('logo')->storeAs('public/brands', $FileName);
        }
        DB::beginTransaction();
        $Affected = DB::table('brands')
            ->where('id', '=', $request->post('id'))
            ->update([
                'title' => $request->post('name'),
                'image' => $FileName,
                'b2b' => $request->post('b2b'),
                'slug' => $request->post('slug'),
                'type' => $request->post('type'),
                'meta_title' => $request->post('metaTitle'),
                'description' => $request->post('description'),
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('brands')->with('success-message', 'Brand updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('brands')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function delete(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('brands')
            ->where('id', '=', $request->post('id'))
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('brands')->with('success-message', 'Brand deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('brands')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function orderUp(Request $request)
    {
        $PreviousRecord = DB::table('brands')
            ->where('order_no', '<', $request->post('order_no'))
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'DESC')
            ->limit(1)
            ->get();
        if(sizeof($PreviousRecord) > 0){
            $PreviousOrderNo = $PreviousRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('brands')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $PreviousOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('brands')
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
        $NextRecord = DB::table('brands')
            ->where('order_no', '>', $request->post('order_no'))
            ->orderBy('order_no','ASC')
            ->limit(1)
            ->get();
        if(sizeof($NextRecord) > 0){
            $NextOrderNo = $NextRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('brands')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $NextOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('brands')
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

    function loadCategoryBrand(Request $request)
    {
        $List = "<option value='' disabled>Select Brand</option>";
        $Brands = DB::table('brands')
            ->where('deleted_at', null)
            ->get();

        $CategoryDetails = DB::table('categories')
            ->where('id', $request['categoryId'])
            ->where('deleted_at', null)
            ->get();

        $CategoryBrand = explode(",",$CategoryDetails[0]->brand);

        foreach ($Brands as $key => $value) {
            if (in_array($value->id, $CategoryBrand)) {
                $List .= "".
                "<option value='". $value->id ."'>". $value->title ."</option>";
            }
        }

        echo json_encode($List);
    }

    function loadSubCategoryBrand(Request $request)
    {
        $List = "<option value='' disabled>Select Brand</option>";
        $Brands = DB::table('brands')
            ->where('deleted_at', null)
            ->get();

        $SubCategoryDetails = DB::table('subcategories')
            ->where('id', $request['subCategoryId'])
            ->where('deleted_at', null)
            ->get();

        $SubCategoryBrand = explode(",",$SubCategoryDetails[0]->brand);

        foreach ($Brands as $key => $value) {
            if (in_array($value->id, $SubCategoryBrand)) {
                $List .= "".
                "<option value='". $value->id ."'>". $value->title ."</option>";
            }
        }

        echo json_encode($List);
    }

    function loadMultipleSubCategoryBrand(Request $request)
    {
        $List = "<option value='' disabled>Select Brand</option>";
        $BrandsArray = array();
        $Brands = DB::table('brands')
            ->where('deleted_at', null)
            ->get();

        $SubCategories = json_decode($request['subCategories']);
        foreach ($SubCategories as $key => $value) {
            $SubCategoryDetails = DB::table('subcategories')
                ->where('id', $value)
                ->where('deleted_at', null)
                ->get();

            $SubCategoryBrand = explode(",",$SubCategoryDetails[0]->brand);

            foreach ($Brands as $key => $value) {
                if (in_array($value->id, $SubCategoryBrand)) {
                    if (!in_array($value->id, $BrandsArray)) {
                      array_push($BrandsArray, $value->id);
                      $List .= "".
                      "<option value='". $value->id ."'>". $value->title ."</option>";
                    }
                }
            }
        }

        echo json_encode($List);
    }

    function loadSubSubCategoryBrand(Request $request)
    {
        $List = "<option value=''>Select</option>";
        $Brands = DB::table('brands')
            ->where('deleted_at', null)
            ->get();

        $SubSubCategoryDetails = DB::table('sub_subcategories')
            ->where('id', $request['subSubCategoryId'])
            ->where('deleted_at', null)
            ->get();

        $SubSubCategoryBrand = explode(",",$SubSubCategoryDetails[0]->brand);
        foreach ($Brands as $key => $value) {
            if (in_array($value->id, $SubSubCategoryBrand)) {
                $List .= "".
                "<option value='". $value->id ."'>". $value->title ."</option>";
            }
        }
        echo json_encode($List);
    }

    function titleDuplicationCheck(Request $request){
        $TableName = $request['tableName'];
        if ($TableName == "products") {
            if($request->has('Id')){
                $Id = $request->post('Id');
                $Tag = DB::table($TableName)
                    ->where($TableName.'.id', '<>', $Id)
                    ->where($TableName.'.name', '=', $request->post('Value'))
                    ->where($TableName.'.deleted_at', '=', null)
                    ->count();
                if($Tag > 0){
                    echo 'Failed';
                } else {
                    echo 'Success';
                }
            } else {
                $Tag = DB::table($TableName)
                    ->where($TableName.'.name', '=', $request->post('Value'))
                    ->where($TableName.'.deleted_at', '=', null)
                    ->count();
                if($Tag > 0){
                    echo 'Failed';
                } else {
                    echo 'Success';
                }
            }
        } else {
            if($request->has('Id')){
                $Id = $request->post('Id');
                $Tag = DB::table($TableName)
                    ->where($TableName.'.id', '<>', $Id)
                    ->where($TableName.'.title', '=', $request->post('Value'))
                    ->where($TableName.'.deleted_at', '=', null)
                    ->count();
                if($Tag > 0){
                    echo 'Failed';
                } else {
                    echo 'Success';
                }
            } else {
                $Tag = DB::table($TableName)
                    ->where($TableName.'.title', '=', $request->post('Value'))
                    ->where($TableName.'.deleted_at', '=', null)
                    ->count();
                if($Tag > 0){
                    echo 'Failed';
                } else {
                    echo 'Success';
                }
            }
        }
        exit();
    }
}