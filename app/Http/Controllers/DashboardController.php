<?php

namespace App\Http\Controllers;

use App\Helpers\SiteHelper;
use App\Models\DiscountQuestion;
use App\Models\ReturnRequests;
use Aws\Firehose\Exception\FirehoseException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\NotifyMail;
class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    function index()
    {
        $BrandsCount = DB::table('brands')
            ->where('deleted_at',null)
            ->count();
        $CategoriesCount = DB::table('categories')
            ->where('deleted_at',null)
            ->count();
        $ProductsCount = DB::table('products')
            ->where('deleted_at',null)
            ->count();
        $OrdersCount = DB::table('orders')
            ->where('deleted_at',null)
            ->count();
        return view('dashboard.index',compact('BrandsCount','CategoriesCount','ProductsCount','OrdersCount'));
    }

    function accountPage(){
        $List = false;
        if(isset($_GET['list'])){
            $List = true;
        }
        $CustomerInformation = DB::table('customers')
            ->where('user_id', '=', Auth::id())
            ->get();
        return view('site.account', compact('List', 'CustomerInformation'));
    }

    function updateAddress(Request $request){
        DB::beginTransaction();
        $Html = "<b>Message!</b> " . ucwords($request->post('address_type')) . " address information updated";
        DB::table('customers')
            ->where('user_id', '=', Auth::id())
            ->update([
                $request->post('address_type') . '_address' => $request->post('address'),
                $request->post('address_type') . '_city' => $request->post('city'),
                $request->post('address_type') . '_state' => $request->post('state'),
                $request->post('address_type') . '_zipcode' => $request->post('zipcode'),
            ]);
        DB::commit();
        return redirect()->route('home.account')->with('success', $Html);
    }

    function updateDetails(Request $request){
        DB::beginTransaction();
        DB::table('customers')
            ->where('user_id', '=', Auth::id())
            ->update([
                'first_name' => $request->post('ltn__first_name'),
                'last_name' => $request->post('ltn__last_name'),
            ]);

        $Html = "<b>Message!</b> Account details updated";
        $Status = true;
        if($request->post('ltn__old_password') != '' || $request->post('ltn__new_password') != ''){
            if (Hash::check($request->post('ltn__old_password'), Auth::user()->password)) {
                if(($request->post('ltn__new_password') == $request->post('ltn__confirm_password')) && !empty($request->post('ltn__new_password'))){
                    $NewPassword = Hash::make($request->post('ltn__new_password'));
                    DB::table('users')
                        ->where('id', '=', Auth::id())
                        ->update([
                            'password' => $NewPassword
                        ]);
                } else {
                    $Html = "<b>Error!</b> New password and confirm password does not match.";
                    $Status = false;
                }
            } else {
                $Html = "<b>Error!</b> Old password is incorrect.";
                $Status = false;
            }
        }
        if($Status){
            DB::commit();
            return redirect()->route('home.account')->with('success', $Html);
        } else {
            DB::rollBack();
            return redirect()->route('home.account')->with('error', $Html);
        }
    }

    function loadOrders(Request $request)
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
            $fetch_data = DB::table('orders')
                ->where('deleted_at', '=', null)
                ->where('customer_id', '=', $request->post('CustomerId'))
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('orders')
                ->where('deleted_at', '=', null)
                ->where('customer_id', '=', $request->post('CustomerId'))
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('orders')
                ->where('deleted_at', '=', null)
                ->where('customer_id', '=', $request->post('CustomerId'))
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('orders')
                ->where('deleted_at', '=', null)
                ->where('customer_id', '=', $request->post('CustomerId'))
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $Status = "";
            if($item->order_status == 0){
                $Status = '<span class="badge-custom-warning">Pending</span>';
            } elseif($item->order_status == 1){
                $Status = '<span class="badge-custom-info">In progress</span>';
            } elseif($item->order_status == 2){
                $Status = '<span class="badge-custom-primary">Delivered</span>';
            } elseif($item->order_status == 3){
                $Status = '<span class="badge-custom-success">Completed</span>';
            } elseif($item->order_status == 4){
                $Status = '<span class="badge-custom-danger">Cancelled</span>';
            }
            $sub_array = array();
            $sub_array['id'] = $SrNo;
            $sub_array['invoice_no'] = $item->invoice_no;
            $sub_array['created_at'] = Carbon::parse($item->created_at)->format('d-M-Y');
            $sub_array['order_total'] = SiteHelper::$Currency . ' ' . number_format($item->order_total, SiteHelper::$Decimals);
            $sub_array['order_notes'] = wordwrap($item->order_notes, '10', '<br>');
            $sub_array['order_status'] = $Status;
            $DownloadUrl = asset('public/storage/invoices') . '/' . $item->invoice_pdf;
            $sub_array['action'] = '<span><a href="' . $DownloadUrl . '" download="' . $item->invoice_pdf . '"><i class="fas fa-file-pdf cursor-pointer text-custom-primary"></i></a></span>';
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

    /*Admin Orders*/
    function adminOrders(){
        return view('dashboard.orders.index');
    }

    function adminOrdersLoad(Request $request){
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
            $fetch_data = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.deleted_at', '=', null)
                ->select('orders.*', 'customers.first_name', 'customers.last_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.deleted_at', '=', null)
                ->select('orders.*', 'customers.first_name', 'customers.last_name')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.deleted_at', '=', null)
                ->select('orders.*', 'customers.first_name', 'customers.last_name')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.deleted_at', '=', null)
                ->select('orders.*', 'customers.first_name', 'customers.last_name')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $Status = "";
            if($item->order_status == 0){
                $Status = '<span class="badge badge-warning text-white cursor-pointer" id="orderStatus_' . $item->id . '" onclick="UpdateOrderStatus(this.id);">Pending</span>';
            } elseif($item->order_status == 1){
                $Status = '<span class="badge badge-info text-white cursor-pointer" id="orderStatus_' . $item->id . '" onclick="UpdateOrderStatus(this.id);">In progress</span>';
            } elseif($item->order_status == 2){
                $Status = '<span class="badge badge-primary text-white cursor-pointer" id="orderStatus_' . $item->id . '" onclick="UpdateOrderStatus(this.id);">Delivered</span>';
            } elseif($item->order_status == 3){
                $Status = '<span class="badge badge-success text-white cursor-pointer" id="orderStatus_' . $item->id . '" onclick="UpdateOrderStatus(this.id);">Completed</span>';
            } elseif($item->order_status == 4){
                $Status = '<span class="badge badge-danger text-white cursor-pointer" id="orderStatus_' . $item->id . '" onclick="UpdateOrderStatus(this.id);">Cancelled</span>';
            }
            $sub_array = array();
            $sub_array['id'] = $SrNo;
            $sub_array['invoice_no'] = $item->invoice_no;
            $sub_array['first_name'] = $item->first_name . ' ' . $item->last_name;
            $sub_array['created_at'] = Carbon::parse($item->created_at)->format('d-M-Y');
            $sub_array['order_total'] = SiteHelper::$Currency . ' ' . number_format($item->order_total, SiteHelper::$Decimals);
            $sub_array['order_notes'] = wordwrap(Str::limit($item->order_notes, 75), 25, '<br>');
            $sub_array['order_status'] = $Status;
            $DownloadUrl = asset('public/storage/invoices') . '/' . $item->invoice_pdf;
            $DetailsUrl = route('orders.details', array(base64_encode($item->id)));
            $sub_array['action'] = '<span><a href="' . $DownloadUrl . '" download="' . $item->invoice_pdf . '"><i class="fas fa-file-pdf cursor-pointer text-custom-primary"></i></a><a href="' . $DetailsUrl . '" class="ml-2"><i class="fas fa-eye"></i></a><a href="javascript:void(0);" onclick="DeleteOrder(this.id);" id="deleteOrder_' . $item->id . '" class="ml-2"><i class="fas fa-trash"></i></a></span>';
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

    function adminOrderUpdateStatus(Request $request)
    {
        $OrderId = $request->post('OrderId');
        $Status = $request->post('Status');

        if ($Status == '0') {
            $status_des='Order Confirmation';

        }elseif ($Status == '1') {
            $status_des='Order is in Process';
            $sub_text='We’ve got your order! and it is in processing position. We’ll drop you another email when your order ships.';
        }elseif ($Status == '2') {
            $status_des='Your Order has been Delivered';
            $sub_text='We want to let you know that our order has been delivered! please contact us if their is wrong with your order. Thank you for shopping with 101 Electronics';
        }elseif ($Status == '3') {
            $status_des='Your Order’s been Shipped';
            $sub_text='Great news---your order is on its way! You can check your shipment details or track your order by clicking on the button below';
        }elseif ($Status == '4') {
            $status_des='Your Order has been Cancelled';
            $sub_text='Sorry to bearer of bad news, but your order  was cancelled. you can check the reason by clicking the button bellow:';
        }
        $Customer =DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('orders.id', '=', $OrderId)
            ->select('customers.*', 'orders.invoice_no')
            ->get();
        $product =DB::table('order_details')
            ->join('products','order_details.product_id', '=', 'products.id')
            ->where('order_details.order_id', '=' , $OrderId)
            ->select('order_details.*' , 'products.name','products.primary_img','products.code')
            ->get();
        $orders =DB::table('orders')->where('id', '=', $OrderId)->get();
        $data = [
            'heading'=>$status_des,
            'sub_head' =>$sub_text,
            'status' =>$Status,
            'customer_info' =>$Customer,
            'product_info' => $product,
            'order_info' => $orders
        ];
        try {
            if ($Status !== '') {
                Mail::to($Customer[0]->email)->send(new NotifyMail($data, "Order status updated"));
            }
        }
        catch (\Exception $e) {
            //code to handle the exception
        }

        DB::beginTransaction();
        DB::table('orders')
            ->where('id', '=', $OrderId)
            ->update([
                'order_status' => $Status
            ]);
        DB::commit();
        return redirect()->route('orders');
    }

    function adminOrderDetails($Id)
    {
        $Id = base64_decode($Id);
        $Order = DB::table('orders')
            ->where('id', '=', $Id)
            ->get();
        if(sizeof($Order) == 0){
            return redirect()->route('orders');
        }
        $OrderDetails = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_id', '=', $Order[0]->id)
            ->select('order_details.*', 'products.name AS ProductName', 'products.code AS ProductCode')
            ->get();
        $Customer = DB::table('customers')
            ->where('id', '=', $Order[0]->customer_id)
            ->get();
        $Status = '';
        $StatusBtn = '';
        if($Order[0]->order_status == 0){
            $Status = '<span class="badge badge-warning text-white cursor-pointer" id="orderStatus_' . $Order[0]->id . '" onclick="UpdateOrderStatus(this.id);">Pending</span>';
            $StatusBtn = 'btn-warning';
        } elseif($Order[0]->order_status == 1){
            $Status = '<span class="badge badge-info text-white cursor-pointer" id="orderStatus_' . $Order[0]->id . '" onclick="UpdateOrderStatus(this.id);">In progress</span>';
            $StatusBtn = 'btn-info';
        } elseif($Order[0]->order_status == 2){
            $Status = '<span class="badge badge-primary text-white cursor-pointer" id="orderStatus_' . $Order[0]->id . '" onclick="UpdateOrderStatus(this.id);">Delivered</span>';
            $StatusBtn = 'btn-primary';
        } elseif($Order[0]->order_status == 3){
            $Status = '<span class="badge badge-success text-white cursor-pointer" id="orderStatus_' . $Order[0]->id . '" onclick="UpdateOrderStatus(this.id);">Completed</span>';
            $StatusBtn = 'btn-success';
        } elseif($Order[0]->order_status == 4){
            $Status = '<span class="badge badge-danger text-white cursor-pointer" id="orderStatus_' . $Order[0]->id . '" onclick="UpdateOrderStatus(this.id);">Cancelled</span>';
            $StatusBtn = 'btn-danger';
        }
        return view('dashboard.orders.details', compact('Id', 'Order', 'OrderDetails', 'Customer', 'Status', 'StatusBtn'));
    }

    function adminOrderDelete(Request $request){
        $OrderId = $request->post('id');
        DB::table('orders')
            ->where('id', '=', $OrderId)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]);
        return redirect()->route('orders')->with('success-message', 'Order deleted successfully');
    }

    public function ReturnRequest(){
        return view('dashboard.return-request.index');
    }

    public function ReturnRequestLoad(Request $request)
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
    $id = Auth::id();

    if ($searchTerm == '') {
        $fetch_data = DB::table('return_requests')
            ->where('deleted_at', '=', null)
            ->select('return_requests.*')
            ->orderBy($columnName, $columnSortOrder)
            ->offset($start)
            ->limit($limit)
            ->get();

        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('return_requests')
            ->where('deleted_at', '=', null)
            ->select('return_requests.*')
            ->orderBy($columnName, $columnSortOrder)
            ->count();
    } else {
        $fetch_data = DB::table('return_requests')
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($searchTerm) {
                $query->orWhere('return_requests.name', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('return_requests.email', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('return_requests.order_no', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('return_requests.serial_no', 'LIKE', '%' . $searchTerm . '%');
            })
            ->select('return_requests.*')
            ->orderBy($columnName, $columnSortOrder)
            ->offset($start)
            ->limit($limit)
            ->get();
        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('return_requests')
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($searchTerm) {
                $query->orWhere('return_requests.name', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('return_requests.email', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('return_requests.order_no', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('return_requests.serial_no', 'LIKE', '%' . $searchTerm . '%');
            })
            ->select('return_requests.*')
            ->orderBy($columnName, $columnSortOrder)
            ->count();
    }

    $data = array();
    $SrNo = $start + 1;
    foreach ($fetch_data as $row => $item) {
        $sub_array = array();
        $sub_array['id'] = $SrNo;
        $sub_array['name'] = $item->name;
        $sub_array['email'] = $item->email;
        $sub_array['phone'] = $item->phone;
        $sub_array['order_no'] = $item->order_no;
        $sub_array['serial_no'] = $item->serial_no;
        $ViewUrl = route('request.view', array($item->id));

        if ($item->status == '0'){
            $sub_array['status'] = '<button    type="button" class="badge btn-warning text-white">Pending</button>';
        } elseif ($item->status == '1'){
            $sub_array['status'] = '<button  type="button" class="badge btn-success text-white">Approved</button>';
        }elseif ($item->status == '2'){
            $sub_array['status'] = '<button   type="button" class="badge btn-danger text-white">Cancelled</button>';
        }
        $sub_array['action'] =  '<a href="' . $ViewUrl . '"><i class="fas fa-eye text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DeleteRequest(\'' . $item->id . '\'); "><i class="fa fa-trash text-color-red"></i></a>';
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
    function viewRequest($RequestId)
    {
        $RequestDetails = DB::table('return_requests')
            ->where('deleted_at', null)
            ->where('id',$RequestId)
            ->get();
        return view('dashboard.return-request.view', compact('RequestDetails'));
    }

    public function requestAction(Request $request){

        $id = $request['id'];
        $statusValue = $request['request_status'];
        $AdminReason = $request['admin_reason'];
        DB::beginTransaction();
        $Affected = DB::table('return_requests')
            ->where('id',$id)
            ->update([
                'status' => $statusValue,
                'admin_reason' => $AdminReason,
                'updated_at' => Carbon::now(),
            ]);

        $RequestDetails = DB::table('return_requests')->where('deleted_at',null)->where('id',$id)->get();
        if ($statusValue == '1') {
            $status_des='Your Return Request Has Been Approved';
        }elseif ($statusValue == '2') {
            $status_des='Your Return Request Has Been Cancelled';
        }
        $email = $RequestDetails[0]->email;
        try {
            $data = [
                'heading' => $status_des,
                'name' => $RequestDetails[0]->name,
                'email' => $RequestDetails[0]->email,
                'phone' =>$RequestDetails[0]->phone,
                'order_no' => $RequestDetails[0]->order_no,
                'serial_no' => $RequestDetails[0]->serial_no,
                'reason' => $RequestDetails[0]->reason,

            ];
            Mail::send('email.returnRequest', $data, function($message) use ($email) {
                $message->to($email)->subject('Return Request');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        }
        catch (exception $e) {
            //code to handle the exception
        }

        if ($Affected) {
            DB::commit();
            return redirect()->route('return-request')->with('success-message', 'Request updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('return-request')->with('error-message', 'An unhandled error occurred.');
        }

    }

    public function returnRequestDelete(Request $request){
        $id = $request['id'];
        DB::beginTransaction();
        $Affected = DB::table('return_requests')
            ->where('id',$id)
            ->update([
                'deleted_at' => carbon::now(),
            ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('return-request')->with('success-message', 'Request deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('return-request')->with('error-message', 'An unhandled error occurred.');
        }
    }

   //Profile
    public function profileIndex(){
        return view('dashboard.profile.index');
    }

    function UpdateAccount(Request $request)
    {
        $UserId = Auth::id();
        $Password = $request->post('newPassword');
        DB::beginTransaction();
        DB::table('users')->where('id', '=', $UserId)->update([
            'password' => bcrypt($Password),
            'updated_at' => Carbon::now()
        ]);
        DB::commit();

        return redirect()->back()->with('message', 'User Password has been updated successfully.');
    }

    //Quote-Request
    public function QuoteRequest(){
        return view('dashboard.quote-request.index');
    }
    public function QuoteRequestLoad(Request $request)
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
        $id = Auth::id();

        if ($searchTerm == '') {
            $fetch_data = DB::table('b2b_requests')
                ->where('deleted_at', '=', null)
                ->select('b2b_requests.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();

            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('b2b_requests')
                ->where('deleted_at', '=', null)
                ->select('b2b_requests.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        } else {
            $fetch_data = DB::table('b2b_requests')
                ->where('deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('b2b_requests.name', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('b2b_requests.email', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('b2b_requests.city', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('b2b_requests.*')
                ->orderBy($columnName, $columnSortOrder)
                ->offset($start)
                ->limit($limit)
                ->get();
            $recordsTotal = sizeof($fetch_data);
            $recordsFiltered = DB::table('b2b_requests')
                ->where('deleted_at', '=', null)
                ->where(function ($query) use ($searchTerm) {
                    $query->orWhere('b2b_requests.name', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('b2b_requests.email', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('b2b_requests.city', 'LIKE', '%' . $searchTerm . '%');
                })
                ->select('b2b_requests.*')
                ->orderBy($columnName, $columnSortOrder)
                ->count();
        }

        $data = array();
        $SrNo = $start + 1;
        foreach ($fetch_data as $row => $item) {
            $sub_array = array();
            $sub_array['id'] = $SrNo;
            $sub_array['name'] = $item->name;
            $sub_array['email'] = $item->email;
            $sub_array['phone'] = $item->phone;
            $sub_array['city'] = $item->city;
            $ViewUrl = route('quote.view', array($item->id));

            if ($item->status == '0'){
                $sub_array['status'] = '<button    type="button" class="badge btn-warning text-white">Pending</button>';
            } elseif ($item->status == '1'){
                $sub_array['status'] = '<button  type="button" class="badge btn-success text-white">Approved</button>';
            }elseif ($item->status == '2'){
                $sub_array['status'] = '<button   type="button" class="badge btn-danger text-white">Cancelled</button>';
            }
            $sub_array['action'] =  '<a href="' . $ViewUrl . '"><i class="fas fa-eye text-color-green"></i></a><a href="javascript:void(0);" class="ml-2" onclick="DeleteQuoteRequest(\'' . $item->id . '\'); "><i class="fa fa-trash text-color-red"></i></a>';
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

    function viewQuoteRequest($QuoteId)
    {
        $QuoteRequestDetails = DB::table('b2b_requests')
            ->where('b2b_requests.deleted_at', null)
            ->where('b2b_requests.id',$QuoteId)
            ->select('b2b_requests.*')
            ->get();
        return view('dashboard.quote-request.view', compact('QuoteRequestDetails'));
    }
    public function quoteRequestDelete (Request $request){
        $id = $request['id'];
        DB::beginTransaction();
        $Affected = DB::table('b2b_requests')
            ->where('id',$id)
            ->update([
                'deleted_at' => carbon::now(),
            ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('quote-request')->with('success-message', 'Request deleted successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('quote-request')->with('error-message', 'An unhandled error occurred.');
        }
    }
    public function quoteRequestAction(Request $request){

        $id = $request['id'];
        $statusValue = $request['quote_request_status'];
        DB::beginTransaction();
        $Affected = DB::table('b2b_requests')
            ->where('id',$id)
            ->update([
                'status' => $statusValue,
                'updated_at' => Carbon::now(),
            ]);
        if ($Affected) {
            DB::commit();
            return redirect()->route('quote-request')->with('success-message', 'Quote Request updated successfully.');
        } else {
            DB::rollBack();
            return redirect()->route('quote-request')->with('error-message', 'An unhandled error occurred.');
        }

    }

    //Discount Questions
    public function discountQuestioncreate(){
        $DiscountData = DB::table('discount_questions')->get();
       return view('dashboard.discount-question.add',compact('DiscountData'));
    }

    public function discountQuestionstore(Request $request)
    {
        DB::table('discount_questions')
            ->delete();
        $Affected = null;
        foreach ($request->post('questions') as $question) {
            $Affected = DiscountQuestion::create([
                'question' => $question['add_quiz_question'],
                'choice1' => $question['add_quiz_choice1'],
                'choice2' => $question['add_quiz_choice2'],
                'choice3' => $question['add_quiz_choice3'],
                'choice4' => $question['add_quiz_choice4'],
                'answer' => $question['add_quiz_answer'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        if ($Affected) {
            DB::commit();
            return redirect(route('discountQuestion.add'))->with('message', 'Discount Question has been added  successfully');
        } else {
            DB::rollback();
            return redirect(route('discountQuestion.add'))->with('error', 'Error! An unhandled exception occurred');
        }
    }

    public function discountCode(){
        $Code = DB::select(DB::raw("SELECT discount_code FROM discount_vouchers WHERE deleted_at IS NULL AND code_usage < max_limit ORDER BY id DESC  LIMIT 1"));
        echo json_encode($Code);
    }

    function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('HomeRoute');
    }
}
