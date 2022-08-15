<?php

namespace App\Http\Controllers;

use App\Models\InstantCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('dashboard.instant-calculator.index');
    }

    function create()
    {
        return view('dashboard.instant-calculator.add');
    }

    function store(Request $request)
    {
        DB::beginTransaction();
        DB::table('instant_calculators')->delete();
        foreach ($request->post('installement_months') as $index => $month) {
          $Affected = InstantCalculator::create([
              'month' => $month['month'],
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
          ]);
        }

        if ($Affected) {
            DB::commit();
            return redirect()->route('instantcalculator')->with('success-message', 'Instant calculator created successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('instantcalculator')->with('error-message', 'An unhandled error occurred.');
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
            $fetch_data = DB::table('instant_calculators')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('instant_calculators')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('instant_calculators')
                ->where('month', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('instant_calculators')
                ->where('month', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $sub_array = array();
            $sub_array['id'] = $SrNo;
            $sub_array['month'] = $item->month . " Months";
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

    function edit()
    {
        $InstantCalculator = DB::table('instant_calculators')->get();
        return view('dashboard.instant-calculator.edit', compact('InstantCalculator'));
    }

    function update(Request $request)
    {
        DB::beginTransaction();
        DB::table('instant_calculators')->delete();
        foreach ($request->post('installement_months') as $index => $month) {
          $Affected = InstantCalculator::create([
              'month' => $month['month'],
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
          ]);
        }

        if ($Affected) {
            DB::commit();
            return redirect()->route('instantcalculator')->with('success-message', 'Instant calculator updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('instantcalculator')->with('error-message', 'An unhandled error occurred.');
        }
    }
}
