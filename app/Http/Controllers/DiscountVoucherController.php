<?php

namespace App\Http\Controllers;

use App\Models\DiscountVoucher;
use App\Helpers\SiteHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DiscountVoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('dashboard.discount-vouchers.index');
    }

    function create()
    {
        return view('dashboard.discount-vouchers.add');
    }

    function getLastOrderNo()
    {
        $DiscountVoucher = DB::table('discount_vouchers')
            ->where('deleted_at', '=', null)
            ->max('order_no');
        return $DiscountVoucher + 1;
    }

    function store(Request $request)
    {
        DB::beginTransaction();
        $Affected = DiscountVoucher::create([
            'order_no' => $this->getLastOrderNo(),
            'title' => $request->post('name'),
            'discount_code' => $request->post('discount_code'),
            'voucher_price' => $request->post('voucher_price'),
            'min_shopping_price' => $request->post('min_shopping_amount'),
            'max_limit' => $request->post('limit'),
            'start_date' => $request->post('start_date'),
            'end_date' => $request->post('end_date'),
            'status' => 1,
            'desc' => $request->post('description'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('discountvouchers')->with('success-message', 'Discount voucher created successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('discountvouchers')->with('error-message', 'An unhandled error occurred.');
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
            $fetch_data = DB::table('discount_vouchers')
                ->where('deleted_at', '=', null)
                ->orderBy($columnName, $columnSortOrder)
                ->orderBy('discount_vouchers.id', 'DESC')
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('discount_vouchers')
                ->where('deleted_at', '=', null)
                ->orderBy($columnName, $columnSortOrder)
                ->orderBy('discount_vouchers.id', 'DESC')
                ->count();
        } else {
            $fetch_data = DB::table('discount_vouchers')
                ->where('deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('discount_vouchers.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('discount_vouchers.discount_code', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('discount_vouchers.voucher_price', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('discount_vouchers.min_shopping_price', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('discount_vouchers.max_limit', 'LIKE', '%' . $searchTerm . '%');
                })
                ->orderBy('discount_vouchers.id', 'DESC')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('discount_vouchers')
                ->where('deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('discount_vouchers.title', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('discount_vouchers.discount_code', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('discount_vouchers.voucher_price', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('discount_vouchers.min_shopping_price', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('discount_vouchers.max_limit', 'LIKE', '%' . $searchTerm . '%');
                })
                ->orderBy('discount_vouchers.id', 'DESC')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $Status = "";
            $sub_array = array();
            $sub_array['order_no'] = $item->order_no;
            $sub_array['id'] = $SrNo;
            if (strlen($item->title) > 20){
                $sub_array['title'] = substr($item->title, 0, 20) . '...';
            } else {
                $sub_array['title'] = $item->title;
            }
            $sub_array['discount_code'] = $item->discount_code;
            $sub_array['voucher_price'] = SiteHelper::GetCurrency() . " " . number_format($item->voucher_price, 2);
            $sub_array['min_shopping_price'] = SiteHelper::GetCurrency() . " " . number_format($item->min_shopping_price, 2);
            $sub_array['limit'] = $item->max_limit;
            if ($item->status == 1) {
                $Status = '<label class="switch">
                              <input type="checkbox" name="voucher_status" id="voucherstatus_'. $item->id .'" checked onchange="UpdateVoucherStatus(this.id);">
                              <span class="slider round"></span>
                          </label>';
            } else {
                $Status = '<label class="switch">
                              <input type="checkbox" name="voucher_status" id="voucherstatus_'. $item->id .'" onchange="UpdateVoucherStatus(this.id);">
                              <span class="slider round"></span>
                          </label>';
            }
            $sub_array['status'] = $Status;
            $Action = "<span>";
            $EditUrl = route('discountvouchers.edit', array($item->id));
            $Id = $item->id;
            $OrderNo = $item->order_no;
            $Parameters = "this, '$Id', '$OrderNo'";
            $Action .= '<a href="javascript:void(0);" class="mr-2" onclick="VoucherOrderUp(' . $Parameters . ');"><i class="fa fa-arrow-up"></i></a><a href="javascript:void(0);" class="mr-2" onclick="VoucherOrderDown(' . $Parameters . ');"><i class="fa fa-arrow-down"></i></a><a href="' . $EditUrl . '"><i class="fa fa-pen text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DeleteVoucher(\'' . $item->id . '\', \'' . base64_encode($item->title) . '\');"><i class="fa fa-trash text-color-red"></i></a>';
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

    function edit($voucherId)
    {
        $DiscountVoucher = DB::table('discount_vouchers')
            ->where('id', '=', $voucherId)
            ->get();
        return view('dashboard.discount-vouchers.edit', compact('DiscountVoucher'));
    }

    function update(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('discount_vouchers')
            ->where('id', '=', $request->post('id'))
            ->update([
                'title' => $request->post('name'),
                'discount_code' => $request->post('discount_code'),
                'voucher_price' => $request->post('voucher_price'),
                'min_shopping_price' => $request->post('min_shopping_amount'),
                'max_limit' => $request->post('limit'),
                'start_date' => $request->post('start_date'),
                'end_date' => $request->post('end_date'),
                'status' => 1,
                'desc' => $request->post('description'),
                'updated_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('discountvouchers')->with('success-message', 'Discount voucher updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('discountvouchers')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function delete(Request $request)
    {
        DB::beginTransaction();
        $Affected = DB::table('discount_vouchers')
            ->where('id', '=', $request->post('id'))
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);

        if ($Affected) {
            DB::commit();
            return redirect()->route('discountvouchers')->with('success-message', 'Discount voucher deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('discountvouchers')->with('error-message', 'An unhandled error occurred.');
        }
    }

    function orderUp(Request $request)
    {
        $PreviousRecord = DB::table('discount_vouchers')
            ->where('order_no', '<', $request->post('order_no'))
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'DESC')
            ->limit(1)
            ->get();
        if(sizeof($PreviousRecord) > 0){
            $PreviousOrderNo = $PreviousRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('discount_vouchers')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $PreviousOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('discount_vouchers')
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
        $NextRecord = DB::table('discount_vouchers')
            ->where('order_no', '>', $request->post('order_no'))
            ->orderBy('order_no','ASC')
            ->limit(1)
            ->get();
        if(sizeof($NextRecord) > 0){
            $NextOrderNo = $NextRecord[0]->order_no;
            DB::beginTransaction();
            $Affected1 = DB::table('discount_vouchers')
                ->where('id', '=', $request->post('id'))
                ->update([
                    'order_no' => $NextOrderNo,
                    'updated_at' => Carbon::now()
                ]);
            $Affected2 = DB::table('discount_vouchers')
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

    function updateVoucherStatus(Request $request)
    {
        DB::beginTransaction();
        $Affected1 = DB::table('discount_vouchers')
            ->where('id', '=', $request->post('id'))
            ->update([
                'status' => $request->post('status'),
                'updated_at' => Carbon::now()
            ]);
        DB::commit();
        echo 'Success';
    }
}
