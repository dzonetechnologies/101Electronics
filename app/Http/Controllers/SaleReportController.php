<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SaleReportController extends Controller
{
    public function index()
    {
        $TotalOrders = 0;
        $TotalSale = 0;
        $TotalGST = 0;
        $TotalDiscount = 0;
        $TotalProductsQty = 0;

        $Products = DB::table('products')
            ->where('deleted_at', null)
            ->get();
        $Orders = DB::table('orders')
            ->where('deleted_at', null)
            ->get();
        $OrderDetails = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('orders.deleted_at', '=', null)
            ->select('order_details.*')
            ->get();

        $TotalOrders = count($Orders);

        foreach ($Orders as $index => $value) {
            $TotalSale += $value->order_total;
            $TotalGST += $value->gst;
            $TotalDiscount += $value->discount;
        }

        foreach ($OrderDetails as $orderDetail) {
            $TotalProductsQty += floatval($orderDetail->quantity);
        }

        return view('dashboard.sale-report.index', compact('Products', 'TotalOrders', 'TotalSale', 'TotalGST', 'TotalDiscount', 'TotalProductsQty'));
    }

    public function FilterSaleReport(Request $request)
    {
        $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        $Status = $request['Status'];
        $Product = $request['Product'];
        $TotalProductsQty = 0;

        $Orders = DB::table('orders')
            ->join("order_details", 'orders.id', '=', 'order_details.order_id')
            ->where('orders.deleted_at', '=', null)
            ->where(function ($query) use ($StartDate, $EndDate, $Status, $Product) {
                if ($StartDate != "" && $EndDate != "") {
                    $query->whereBetween('orders.created_at', [Carbon::parse($StartDate)->format("Y-m-d"), Carbon::parse($EndDate)->addDays(1)->format("Y-m-d")]);
                }
                if ($Status != "") {
                    $query->where('orders.order_status', $Status);
                }
                if ($Product != "") {
                    $query->where('order_details.product_id', $Product);
                }
            })
            ->select('orders.*')
            ->distinct('orders.id')
            ->get();

        $OrdersDetails = DB::table('orders')
            ->join("order_details", 'orders.id', '=', 'order_details.order_id')
            ->where('orders.deleted_at', '=', null)
            ->where(function ($query) use ($StartDate, $EndDate, $Status, $Product) {
                if ($StartDate != "" && $EndDate != "") {
                    $query->whereBetween('orders.created_at', [Carbon::parse($StartDate)->format("Y-m-d"), Carbon::parse($EndDate)->addDays(1)->format("Y-m-d")]);
                }
                if ($Status != "") {
                    $query->where('orders.order_status', $Status);
                }
                if ($Product != "") {
                    $query->where('order_details.product_id', $Product);
                }
            })
            ->select('order_details.*')
            ->get();

        $TotalOrders = 0;
        $TotalSale = 0;
        $TotalGST = 0;
        $TotalDiscount = 0;
        $Order_id = "";

        $TotalOrders = count($Orders);
        foreach ($Orders as $index => $value) {
            $Order_id = $value->id;
            $TotalSale += $value->order_total;
            $TotalDiscount += $value->discount;
            $TotalGST += $value->gst;
        }

        foreach ($OrdersDetails as $orderDetail) {
            $TotalProductsQty += floatval($orderDetail->quantity);
        }

        $data = array();
        $data['total_orders_id'] = $Order_id;
        $data['total_orders'] = $TotalOrders;
        $data['total_sale'] = "PKR " . number_format(round($TotalSale), 0);
        $data['total_gst'] = "PKR " . number_format(round($TotalGST), 0);
        $data['total_discount'] = "PKR " . number_format(round($TotalDiscount), 0);
        $data['total_products_qty'] = $TotalProductsQty;
        return json_encode($data);
    }

    public function ExportExcelSaleReport($StartDate, $EndDate, $Status, $Product)
    {
        $StartDate = base64_decode($StartDate);
        $EndDate = base64_decode($EndDate);
        $Status = base64_decode($Status);
        $Product = base64_decode($Product);

        return Excel::download(new OrdersExport($StartDate, $EndDate, $Status, $Product), 'orders.xlsx');
    }
}