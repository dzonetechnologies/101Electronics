<?php

namespace App\Http\Controllers;

use App\Helpers\SiteHelper;
use App\Models\Customers;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Mail\NotifyMail;

class CheckoutController extends Controller
{
    public function __construct()
    {
        //
    }

    function index()
    {
        $CartController = new CartController();
        $CartCount = $CartController->CartCount(request());
        if($CartCount == 0){
            return redirect()->route('CartRoute');
        }
        $PageDetails = DB::table('general_pages')
            ->where('id', 15)
            ->get();
        $CustomerInformation = array();
        if(Auth::check()){
            $CustomerInformation = DB::table('customers')
                ->where('user_id', '=', Auth::id())
                ->get();
        }
        return view('site.checkout', compact('PageDetails', 'CustomerInformation'));
    }

    function LoadCheckoutPageHtml(Request $request){
        $CartItems = (array) json_decode(request()->cookie('one_o_one_shopping_cart'));
        $CartCount = sizeof($CartItems);
        $CartSubTotal = 0;
        $GST = 0;
        $ProductDiscount = 0;
        $Shipping = 0;
        $Installation = 0;
        $TotalQuantity = 0;
        $B2BDiscountPercent = \Illuminate\Support\Facades\DB::table('general_settings')
            ->where('id', '=', 1)
            ->get()[0]->b2b_discount;
        if($B2BDiscountPercent == '') {
            $B2BDiscountPercent = 0;
        } else {
            $B2BDiscountPercent = floatval($B2BDiscountPercent);
        }
        $B2BDiscount = 0;
        $Html = "";
        if ($CartCount != 0) {
            foreach ($CartItems as $index => $cartItem) {
                $Html .= '
                        <tr>
                            <td>' . $cartItem->name . ' <strong>x ' . $cartItem->quantity . '</strong></td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format(floatval($cartItem->total_price) * floatval($cartItem->quantity), SiteHelper::$Decimals) . '</td>
                        </tr>';
                $CartSubTotal += floatval($cartItem->unit_price) * floatval($cartItem->quantity);
                $GST += SiteHelper::CalculateGSTCost($cartItem->tax_price, $cartItem->quantity);
                $ProductDiscount += SiteHelper::CalculateDiscountCost($cartItem->discount_price, $cartItem->quantity);
                $Installation += SiteHelper::CalculateInstallationCost($cartItem->installation_price, $cartItem->quantity);
                $TotalQuantity += floatval($cartItem->quantity);
            }
            $Shipping += SiteHelper::CalculateShippingCost($TotalQuantity);
            if($TotalQuantity >= 5) {
                $_SubAmount = $CartSubTotal - $ProductDiscount;
                $B2BDiscount = round(($_SubAmount * $B2BDiscountPercent) / 100, 2);
            }
            $Html .= '
                        <tr>
                            <td>Sub Total</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($CartSubTotal, SiteHelper::$Decimals) . '</td>
                        </tr>
                        <tr>
                            <td>GST 17% Included</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($GST, SiteHelper::$Decimals) . '</td>
                        </tr>
                        <tr>
                            <td>Discount Amount</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($ProductDiscount, SiteHelper::$Decimals) . '</td>
                        </tr>';
        if($B2BDiscount != 0) {
            $Html .= '  <tr>
                            <td>B2B Discount Amount</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($B2BDiscount, SiteHelper::$Decimals) . '</td>
                        </tr>';
        }
            $Html .= '  <tr>
                            <td>Shipping</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($Shipping, SiteHelper::$Decimals) . '</td>
                        </tr>
                        <tr>
                            <td>Installation Fee</td>
                            <td>' . SiteHelper::$Currency . ' ' . number_format($Installation, SiteHelper::$Decimals) . '</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="mb-0" name="cart-coupon"
                                    id="discountCodeInput"
                                    placeholder="Coupon code">
                            </td>
                            <td>
                                <button type="submit" class="theme-btn-2 btn btn-effect-2" onclick="ApplyDiscountCode(this);">
                                    Apply Coupon
                                </button>
                            </td>
                        </tr>
                        <tr id="discountAmountTr" style="display: none;">
                            <td>Discount Amount</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Order Total</strong></td>
                            <td><strong id="orderTotalDisplay">' . SiteHelper::$Currency . ' ' . number_format((($CartSubTotal + $Shipping + $Installation) - $ProductDiscount), SiteHelper::$Decimals) . '</strong></td>
                        </tr>
                        <tr style="border-top: none; background-color: transparent;">
                            <td style="border-bottom: none;">&nbsp;</td>
                            <td style="border-bottom: none;">
                                <button class="theme-btn-2 btn btn-effect-2 text-uppercase w-100 mt-0"
                                    type="button" onclick="PlaceOrder(this);">Place order
                                </button>
                            </td>
                        </tr>
                        <input type="hidden" name="orderSubTotal" id="orderSubTotal" value="' . $CartSubTotal . '" />
                        <input type="hidden" name="orderGSTTotal" id="orderGSTTotal" value="' . $GST . '" />
                        <input type="hidden" name="orderDiscountTotal" id="orderDiscountTotal" value="' . $ProductDiscount . '" />
                        <input type="hidden" name="orderShipping" id="orderShipping" value="' . $Shipping . '" />
                        <input type="hidden" name="orderInstallation" id="orderInstallation" value="' . $Installation . '" />
                        <input type="hidden" name="voucherAmount" id="voucherAmount" value="0" />
                        <input type="hidden" name="b2bDiscount" id="b2bDiscount" value="' . $B2BDiscount . '" />
                        <input type="hidden" name="orderTotal" id="orderTotal" value="' . (($CartSubTotal + $Shipping + $Installation) - $ProductDiscount - $B2BDiscount) . '" />';
        }
        echo json_encode(base64_encode($Html));
        exit();
    }

    function ApplyDiscountCode(Request $request){
        $CodeCheck = DB::table('discount_vouchers')
            ->where('deleted_at', '=', null)
            ->where('status', '=', 1)
            ->where('max_limit', '>', DB::raw('code_usage'))
            ->where('min_shopping_price', '<=', $request->post('OrderTotal'))
            ->where('discount_code', '=', $request->post('Code'))
            ->whereRaw('? BETWEEN start_date AND end_date', array(Carbon::now()->format('Y-m-d')))
            ->get();
        $ChangeInAmount = 0;
        $ResponseArray = array();
        if(sizeof($CodeCheck) > 0){
            $ChangeInAmount = $CodeCheck[0]->voucher_price;
            $UpdateUsage = DB::table('discount_vouchers')
                ->where('id', '=', $CodeCheck[0]->id)
                ->update([
                    'code_usage' => intval($CodeCheck[0]->code_usage) + 1,
                    'updated_at' => Carbon::now()
                ]);
            $ResponseArray['message'] = 'Discount Code Applied';
            $ResponseArray['amountChange'] = $ChangeInAmount;
            $ResponseArray['currency'] = SiteHelper::$Currency;
        } else {
            $ResponseArray['message'] = 'Invalid Discount Code';
            $ResponseArray['amountChange'] = $ChangeInAmount;
            $ResponseArray['currency'] = SiteHelper::$Currency;
        }
        echo json_encode($ResponseArray);
        exit();
    }

    function StockCheckAndCalculateOrder(Request $request){
        $CartController = new CartController();
        $CartItems = $CartController->GetCartItems($request);
        $Response = array();
        $CartSubTotal = 0;
        $ProductDiscount = 0;
        $Installation = 0;
        $TotalQuantity = 0;
        $CreateAccount = $request->post('CreateAccount');
        $Email = $request->post('Email');

        $B2BDiscountPercent = DB::table('general_settings')
            ->where('id', '=', 1)
            ->get()[0]->b2b_discount;
        if($B2BDiscountPercent == '') {
            $B2BDiscountPercent = 0;
        } else {
            $B2BDiscountPercent = floatval($B2BDiscountPercent);
        }
        $B2BDiscount = 0;

        /*Check for Unique Email for creating a new Account*/
        if($CreateAccount == 'true'){
            $UserCheck = DB::table('users')
                ->where('email', '=', $Email)
                ->count();
            if($UserCheck > 0){
                $Response['Status'] = false;
                $Response['Message'] = 'Email already taken!';
                echo json_encode($Response);
                exit();
            }
        }

        foreach ($CartItems as $index => $item){
            $productDetails = Product::findOrFail($index);
            if(!isset($productDetails->name)){
                $Response['Status'] = false;
                $Response['Message'] = 'Invalid product in cart';
                break;
            }
            if(floatval($productDetails->quantity) >= floatval($item->quantity)){
                /*Product in Stock*/
                /*Perform Calculations*/
                $CartSubTotal += floatval($item->unit_price) * floatval($item->quantity);
                $ProductDiscount += SiteHelper::CalculateDiscountCost($item->discount_price, $item->quantity);
                $Installation += SiteHelper::CalculateInstallationCost($item->installation_price, $item->quantity);
                $TotalQuantity += floatval($item->quantity);
                $Response['Status'] = true;
                $Response['Message'] = 'Success';
            } else {
                /*Product out of Stock*/
                $Response['Status'] = false;
                $Response['Message'] = $productDetails->name . ' out of stock';
                break;
            }
        }
        $ShippingCost = SiteHelper::CalculateShippingCost($TotalQuantity);
        if($TotalQuantity >= 5) {
            $_SubAmount = $CartSubTotal - $ProductDiscount;
            $B2BDiscount = round(($_SubAmount * $B2BDiscountPercent) / 100, 2);
        }
        $OrderTotal = floatval($CartSubTotal) + floatval($ShippingCost) + floatval($Installation);
        $ChangeInAmount = 0;
        /*Discount Code*/
        $VoucherAmount = 0;
        if($request->post('Code') != ''){
            $CodeCheck = DB::table('discount_vouchers')
                ->where('deleted_at', '=', null)
                ->where('status', '=', 1)
                ->where('max_limit', '>', DB::raw('code_usage'))
                ->where('min_shopping_price', '<=', $OrderTotal)
                ->where('discount_code', '=', $request->post('Code'))
                ->whereRaw('? BETWEEN start_date AND end_date', array(Carbon::now()->format('Y-m-d')))
                ->get();
            if(sizeof($CodeCheck) > 0){
                $ChangeInAmount = $CodeCheck[0]->voucher_price;
            }
        }

        $Response['CartSubTotal'] = $CartSubTotal;
        $Response['Shipping'] = $ShippingCost;
        $Response['Installation'] = $Installation;
        $Response['VoucherAmount'] = $ChangeInAmount;
        $Response['OrderTotal'] = $OrderTotal - ($ProductDiscount + $B2BDiscount + floatval($ChangeInAmount));
        echo json_encode($Response);
        exit();
    }

    function GenerateOrderNo(){
        $Order = DB::table('orders')
            ->max('id');
        if($Order == ''){
            return str_pad('1', 7, '0', STR_PAD_LEFT);
        } else {
            return str_pad(intval($Order) + 1, 7, '0', STR_PAD_LEFT);
        }
    }

    function SaveOrder(Request $request){
        $FirstName = $request->post('FirstName');
        $LastName = $request->post('LastName');
        $Email = $request->post('Email');
        $Phone = $request->post('Phone');
        $Company = $request->post('Company');
        $CompanyAddress = $request->post('CompanyAddress');

        /*Billing Address*/
        $BAddress = $request->post('BAddress');
        $BCity = $request->post('BCity');
        $BState = $request->post('BState');
        $BZipcode = $request->post('BZipcode');
        /*Shipping Address*/
        $SAddress = $request->post('SAddress');
        $SCity = $request->post('SCity');
        $SState = $request->post('SState');
        $SZipcode = $request->post('SZipcode');

        $Notes = $request->post('Notes');
        $PaymentGateWay = $request->post('PaymentGateWay');
        $CreateAccount = $request->post('CreateAccount');
        $Code = $request->post('Code');
        $OrderSubTotal = $request->post('OrderSubTotal');
        $OrderGSTTotal = $request->post('OrderGSTTotal');
        $OrderDiscountTotal = $request->post('OrderDiscountTotal');
        $OrderShipping = $request->post('OrderShipping');
        $OrderInstallation = $request->post('OrderInstallation');
        $VoucherAmount = $request->post('VoucherAmount');
        $OrderTotal = $request->post('OrderTotal');
        $OrderNo = $this->GenerateOrderNo();

        DB::beginTransaction();
        $UserId = 0;
        $Password = mt_rand(10000000, 99999999);
        $Affected = null;
        $Affected2 = null;
        $CustomerId = 0;
        if(Auth::check()){
            /*Logged in user*/
            $CustomerId = DB::table('customers')
                ->where('user_id', '=', Auth::id())
                ->get()[0]->id;
            $Affected2 = DB::table('customers')
                ->where('id', '=', $CustomerId)
                ->update([
                    'first_name' => $FirstName,
                    'last_name' => $LastName,
                    'phone' => $Phone,
                    'company' => $Company,
                    'company_address' => $CompanyAddress,
                    'billing_address' => $BAddress,
                    'billing_city' => $BCity,
                    'billing_state' => $BState,
                    'billing_zipcode' => $BZipcode,
                    'shipping_address' => $SAddress,
                    'shipping_city' => $SCity,
                    'shipping_state' => $SState,
                    'shipping_zipcode' => $SZipcode,
                    'updated_at' => Carbon::now()
                ]);
        } else {
            /*New user*/
            if($CreateAccount == 'true'){
                // Users Table Entry
                $Affected = User::create([
                    'name' => $FirstName . ' ' . $LastName,
                    'email' => $Email,
                    'password' => Hash::make($Password),
                    'role_id' => 2,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $UserId = $Affected->id;
            }

            $Affected2 = Customers::create([
                'user_id' => $UserId,
                'first_name' => $FirstName,
                'last_name' => $LastName,
                'phone' => $Phone,
                'email' => $Email,
                'company' => $Company,
                'company_address' => $CompanyAddress,
                'billing_address' => $BAddress,
                'billing_city' => $BCity,
                'billing_state' => $BState,
                'billing_zipcode' => $BZipcode,
                'shipping_address' => $SAddress,
                'shipping_city' => $SCity,
                'shipping_state' => $SState,
                'shipping_zipcode' => $SZipcode,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $CustomerId = $Affected2->id;
        }

        $Affected3 = Orders::create([
            'invoice_no' => $OrderNo,
            'customer_id' => $CustomerId,
            'payment_gateway' => $PaymentGateWay,
            'discount_code' => $Code,
            'sub_total' => $OrderSubTotal,
            'gst' => $OrderGSTTotal,
            'discount' => $OrderDiscountTotal,
            'b2b_discount' => $request['OrderB2BDiscount'],
            'shipping' => $OrderShipping,
            'installation' => $OrderInstallation,
            'voucher_amount' => $VoucherAmount,
            'order_total' => $OrderTotal,
            'order_notes' => $Notes,
            'order_status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $OrderId = $Affected3->id;
        $CartController = new CartController();
        $CartItems = $CartController->GetCartItems($request);
        $Response = array();
        $Affected4 = null;

        foreach ($CartItems as $index => $item){
            $productDetails = Product::findOrFail($index);
            if(!isset($productDetails->name)){
                $Response['Status'] = false;
                $Response['Message'] = 'Invalid product in cart';
                echo json_encode($Response);
                exit();
            }
            /*Order Details Entry*/
            $Affected4 = OrderDetails::create([
                'order_id' => $OrderId,
                'product_id' => $index,
                'quantity' => $item->quantity,
                'unit_price' => $productDetails->unit_price,
                'tax' => $productDetails->tax,
                'discount' => $productDetails->discount,
                'discount_price' => abs(floatval($item->total_price_without_discount) - floatval($item->total_price)) * floatval($item->quantity),
                'total_price' => floatval($item->total_price) * floatval($item->quantity),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        if($Affected2 && $Affected3 && $Affected4){
            $FileName = "101 Invoice-" . $OrderNo . ".pdf";
            $this->GeneratePdf($OrderNo, $FileName);
            DB::table('orders')
                ->where('id', '=', $OrderId)
                ->update([
                    'invoice_pdf' => $FileName,
                    'updated_at' => Carbon::now()
                ]);
            DB::commit();
            $Response['Status'] = true;
            $Response['OrderId'] = $OrderNo;
            $Response['Message'] = 'Success';
            $__response = new \Illuminate\Http\Response(json_encode($Response));
            $__response->withCookie(cookie('one_o_one_shopping_cart', '', 0));
             //send order confirmation email
             $this->orderconfirmation($OrderId,$Email);
            return $__response;
        } else {
            DB::rollBack();
            $Response['Status'] = false;
            $Response['OrderId'] = null;
            $Response['Message'] = 'An unhandled error occurred';
            $__response = new \Illuminate\Http\Response(json_encode($Response));
            $__response->withCookie(cookie('one_o_one_shopping_cart', '', 0));
            return $__response;
        }
    }

    function orderconfirmation($OrderId,$Email){

        $Customer  = DB::table('orders')
                        ->join('customers', 'orders.customer_id', '=', 'customers.id')
                        ->where('orders.id', '=', $OrderId)
                        ->select('customers.*', 'orders.invoice_no')
                        ->get();
        $product   = DB::table('order_details')
                      ->join('products','order_details.product_id', '=', 'products.id')
                      ->where('order_details.order_id', '=' , $OrderId)
                     ->select('order_details.*' , 'products.name','products.primary_img', 'products.code')
                     ->get();
        $orders    = DB::table('orders')->where('id', '=', $OrderId)->get();
        $status_des='Order Confirmation';
        $sub_text='Hey, we’ve got your order! Your world is about to look a whole lot better. We’ll drop you another email when your order ships.';
        $data = [
                    'heading'=>$status_des,
                    'sub_head' =>$sub_text,
                    'status' =>0,
                    'customer_info' =>$Customer,
                    'product_info' => $product,
                    'order_info' => $orders
                ];

        // Order email send to customer
        try{
            Mail::to($Customer[0]->email)->send(new NotifyMail($data));
        }
        catch (\Exception $e) {
            // mail exception
        }
    }

    function OrderComplete(){
        $InvoiceNo = "";
        $Status = "";
        if(isset($_GET['order_no']) && isset($_GET['status'])){
            $InvoiceNo = base64_decode($_GET['order_no']);
            $Status = base64_decode($_GET['status']);
        } else {
            return redirect()->route('HomeRoute');
        }

        return view('site.order-complete', compact('InvoiceNo', 'Status'));
    }

    function GeneratePdf($InvoiceNo, $FileName){
        $GeneralSettings = DB::table('general_settings')->get();
        $Order = DB::table('orders')
            ->where('invoice_no', '=', $InvoiceNo)
            ->get();
        $OrderDetails = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_details.order_id', '=', $Order[0]->id)
            ->select('order_details.*', 'products.name AS ProductName','products.code AS ProductCode')
            ->get();
        $Customer = DB::table('customers')
            ->where('id', '=', $Order[0]->customer_id)
            ->get();
        $data['logo'] = $GeneralSettings[0]->logo;
        $data['Order'] = $Order;
        $data['OrderDetails'] = $OrderDetails;
        $data['Customer'] = $Customer;
        $data['Country'] = 'Pakistan';
        $pdf = PDF::loadView('pdf.invoice-pdf', $data);
        Storage::put('public/invoices/' . $FileName, $pdf->output());
        return true;
    }
}
