<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('dashboard.sliders.index');
    }

    function create()
    {
        // Brands Name
        $Brands = DB::table('brands')
                  ->where('deleted_at', null)
                  ->get();
        return view('dashboard.sliders.add', compact('Brands'));
    }

    function getLastOrderNo()
    {
        $Slider = DB::table('sliders')
            ->max('order_no');
        return $Slider + 1;
    }

    function store(Request $request)
    {
        $SliderPage = $request['page'];
        $SliderBrand = null;
        if ($SliderPage == "brands") {
          $SliderBrand = $request['brand'];
        }
        $SliderType = $request['type'];
        $FileName ="";
        if ($SliderType == "image") {
          if ($request->has('slider_image')) {
              $FileName = 'Slider-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('slider_image')->extension();
              $request->file('slider_image')->storeAs('public/sliders', $FileName);
          }
        } elseif ($SliderType == "video") {
          if ($request->has('slider_video')) {
              $FileName = $FileName . '.' . $request->file('slider_video')->extension();
              $request->file('slider_video')->storeAs('public/sliders', $FileName);
          }
        }

        DB::beginTransaction();
        $Affected = Slider::create([
            'order_no' => $this->getLastOrderNo(),
            'slide' => $FileName,
            'type' => $SliderType,
            'page' => $request['page'],
            'screen' => $request['screen'],
            'link' => $request['link'],
            'brand' => $SliderBrand,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('sliders')->with('success-message', 'Slider created successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('sliders')->with('error-message', 'An unhandled error occurred.');
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
            $fetch_data = DB::table('sliders')
                ->leftJoin('brands', 'sliders.brand', '=', 'brands.id')
                ->select('sliders.*', 'brands.title')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('sliders')
                ->leftJoin('brands', 'sliders.brand', '=', 'brands.id')
                ->select('sliders.*', 'brands.title')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('sliders')
                ->leftJoin('brands', 'sliders.brand', '=', 'brands.id')
                ->select('sliders.*', 'brands.title')
                ->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('sliders')
                ->leftJoin('brands', 'sliders.brand', '=', 'brands.id')
                ->select('sliders.*', 'brands.title')
                ->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $Url = asset('public/storage/sliders/' . $item->slide);
            $sub_array = array();
            $sub_array['order_no'] = $item->order_no;
            $sub_array['id'] = $SrNo;
            if ($item->type == "image") {
              $sub_array['slider'] = '<span><img src="' . $Url . '" alt="Brand Image" class="img-fluid" style="width: 100%; height:200px;" /></span>';
            } elseif ($item->type == "video") {
              $sub_array['slider'] = '<span>
                                        <video width="100%" height="200" controls>
                                          <source src="'. $Url .'" type="video/mp4">
                                          <source src="'. $Url .'" type="video/ogg">
                                          Your browser does not support HTML video.
                                        </video>
                                      </span>';
            }
            $sub_array['page'] = ucwords($item->page);
            $sub_array['screen'] = ucwords($item->screen);
            $sub_array['brand'] = ucwords($item->title);
            $Action = "<span>";
            $EditUrl = route('slider.edit', array($item->id));
            $Id = $item->id;
            $OrderNo = $item->order_no;
            $Parameters = "this, '$Id', '$OrderNo'";
            $Action .= '<a href="javascript:void(0);" class="mr-2" onclick="SliderOrderUp(' . $Parameters . ');"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0);" class="mr-2" onclick="SliderOrderDown(' . $Parameters . ');"><i class="fa fa-arrow-down"></i></a><a href="' . $EditUrl . '"><i class="fa fa-pen text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DeleteSlider(\'' . $item->id . '\');"><i class="fa fa-trash text-color-red"></i></a>';
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

    function edit($sliderId)
    {
        $Slider = DB::table('sliders')
            ->where('id', '=', $sliderId)
            ->get();
        return view('dashboard.sliders.edit', compact('Slider'));
    }

    function update(Request $request)
    {
        $FileName = $request->post('oldSlide');
        $SliderType = $request->post('oldSlideType');
        if ($request->has('slider_image')) {
            $SliderType = $request->post('type');
            $Path = public_path('storage/sliders') . '/' . $FileName;
            
            if (file_exists($Path)) {

                 unlink($Path);
            }
         
            $FileName = "";
            $FileName = 'Slider-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('slider_image')->extension();
            $request->file('slider_image')->storeAs('public/sliders', $FileName);
        } elseif ($request->has('slider_video')) {
            $SliderType = $request->post('type');
            $Path = public_path('storage/sliders') . '/' . $FileName;
            unlink($Path);
            $FileName ="";
            $FileName = 'Slider-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('slider_video')->extension();
            $request->file('slider_video')->storeAs('public/sliders', $FileName);
        }

        DB::beginTransaction();
        $Affected = DB::table('sliders')
            ->where('id', '=', $request->post('id'))
            ->update([
                'link' => $request['link'],
                'type' => $SliderType,
                'slide' => $FileName,
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('sliders')->with('success-message', 'Slider updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('sliders')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function delete(Request $request)
    {
        $SliderId = $request->post('id');
        $Slider = DB::table('sliders')->where('id', $SliderId)->get();
        if (count($Slider) > 0) {
            $Path = public_path('storage/sliders') . '/' . $Slider[0]->slide;
            unlink($Path);
        }
        DB::beginTransaction();
        $Affected = DB::table('sliders')
            ->where('id', '=', $request->post('id'))
            ->delete();

        if ($Affected) {
            DB::commit();
            return redirect()->route('sliders')->with('success-message', 'Slider deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('sliders')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function orderUp(Request $request)
    {
        $PreviousRecord = DB::table('sliders')
            ->where('order_no', '<', $request->post('order_no'))
            ->orderBy('order_no', 'DESC')
            ->limit(1)
            ->get();
        if(sizeof($PreviousRecord) > 0){
            $PreviousOrderNo = $PreviousRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('sliders')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $PreviousOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('sliders')
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
        $NextRecord = DB::table('sliders')
            ->where('order_no', '>', $request->post('order_no'))
            ->orderBy('order_no','ASC')
            ->limit(1)
            ->get();
        if(sizeof($NextRecord) > 0){
            $NextOrderNo = $NextRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('sliders')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $NextOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('sliders')
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
