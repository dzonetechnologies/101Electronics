<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Profiler\Profile;

class PromotionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('dashboard.promotions.index');
    }

    function create()
    {
        return view('dashboard.promotions.add');
    }

    function store(Request $request)
    {
        $FileName = "";
        if ($request->has('logo')) {
            $FileName = 'Promotion-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('logo')->extension();
            $request->file('logo')->storeAs('public/promotions', $FileName);
        }
        DB::beginTransaction();
        $Affected = Promotion::create([
            'type' => 'Slider',
            'title' => $request->post('title'),
            'description' => $request->post('description'),
            'link' => $request->post('link'),
            'image' => $FileName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('promotions')->with('success-message', 'Promotions created successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('promotions')->with('error-message', 'An unhandled error occurred.');
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
            $fetch_data = DB::table('promotions')
                ->where('deleted_at', '=', null)
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('promotions')
                ->where('deleted_at', '=', null)
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('promotions')
                ->where('deleted_at', '=', null)
                ->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('promotions')
                ->where('deleted_at', '=', null)
                ->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $Url = asset('public/storage/promotions/' . $item->image);
            $sub_array = array();
            $sub_array['id'] = $SrNo;
            $sub_array['type'] = $item->type;
            $sub_array['title'] = $item->title;
            $sub_array['logo'] = '<span><img src="' . $Url . '" alt="Brand Image" class="img-fluid" style="width: 120px;" /></span>';
            $Action = "<span>";
            $EditUrl = route('promotions.edit', array($item->id));
            $Action .= '<a href="' . $EditUrl . '"><i class="fa fa-pen text-color-green"></i></a>';
            if ($item->type == 'Slider'){
                $Action .= '<a href="javascript:void(0);" class="ml-2" onclick="DeletePromotion(\'' . $item->id . '\', \'' . base64_encode($item->title) . '\');"><i class="fa fa-trash text-color-red"></i></a>';
            }
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
        $Promotion = DB::table('promotions')
            ->where('id', '=', $brandId)
            ->first();
        return view('dashboard.promotions.edit', compact('Promotion'));
    }

    function update(Request $request)
    {
        $FileName = $request->post('oldLogo');
        if ($request->has('logo')) {
            $Path = public_path('storage/promotions') . '/' . $FileName;

            if (file_exists($Path)) {
                unlink($Path);
            }

            $FileName ="";
            $FileName = 'Promotion-' . Carbon::now()->format('Ymd-His') . '.' . $request->file('logo')->extension();
            $request->file('logo')->storeAs('public/promotions', $FileName);
        }
        DB::beginTransaction();
        $Affected = DB::table('promotions')
            ->where('id', '=', $request->post('id'))
            ->update([
                'title' => $request->post('title'),
                'description' => $request->post('type') != 'Timer' ? $request->post('description') : null,
                'link' => $request->post('link'),
                'end_date_time' => $request->post('type') == 'Timer' ?$request->post('end_date_time') : null,
                'image' => $FileName,
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('promotions')->with('success-message', 'Promotions updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('promotions')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function delete(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('promotions')
            ->where('id', '=', $request->post('id'))
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('promotions')->with('success-message', 'Promotion deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('promotions')->with('error-message', 'An unhandled error occurred.');
        }
    }
}
