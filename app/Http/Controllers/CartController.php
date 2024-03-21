<?php

namespace App\Http\Controllers;

use App\Helpers\SiteHelper;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    var $CartTimeout = 15;
    public function __construct()
    {
        //
    }

    function index()
    {
        $PageDetails = DB::table('general_pages')
            ->where('id', 14)
            ->get();
        $Title = !empty($PageDetails) ? $PageDetails[0]->meta_title : env('APP_NAME');
        $Description = !empty($PageDetails) ? $PageDetails[0]->meta_description : env('META_DESCRIPTION');
        return view('site.cart', compact('PageDetails','Title','Description'));
    }

    public function addToCart(Request $request)
    {
        $ProductId = $request->post('Product');
        $Quantity = 1;
        if($request->has('Quantity')){
            $Quantity = intval($request->post('Quantity'));
        }
        $product = Product::findOrFail($ProductId);
        if(!isset($product->name)){
            echo 'An unhandled error occurred!';
            exit();
        }

        $cart = array();
        if(request()->cookie('one_o_one_shopping_cart') != ''){
            $cart = (array) json_decode(request()->cookie('one_o_one_shopping_cart'));
        }

        if(isset($cart[$ProductId])) {
            foreach ($cart as $index => $item){
                if($index == $ProductId){
                    if(floatval($product->quantity) >= $item->quantity + 1){
                        $item->quantity = $item->quantity + $Quantity;
                        break;
                    } else {
                        echo 'Product out of stock!';
                        exit();
                    }
                }
            }
        } else {
            $cart[$ProductId] = [
                "name" => $product->name,
                "quantity" => $Quantity,
                "unit_price" => $product->unit_price,
                "tax" => $product->tax,
                "tax_price" => $product->tax_price,
                "discount" => $product->discount,
                "discount_price" => $product->discount_price,
                "total_price_without_discount" => $product->total_price_without_discount,
                "total_price" => $product->total_price,
                "shipping_flat_rate" => $product->shipping_flat_rate,
                "installation_price" => $product->installation_price == ''? 0 : $product->installation_price,
                "primary_img" => $product->primary_img
            ];
        }

        $cart = json_encode($cart);
        $minutes = $this->CartTimeout;
        $response = new \Illuminate\Http\Response('Product added to cart');
        $response->withCookie(cookie('one_o_one_shopping_cart', $cart, $minutes));
        return $response;
    }

    function removeFromCart(Request $request){
        $ProductId = $request->post('Product');
        $cart = array();
        if(request()->cookie('one_o_one_shopping_cart') != ''){
            $cart = (array) json_decode(request()->cookie('one_o_one_shopping_cart'));
        }

        if(isset($cart[$ProductId])) {
            unset($cart[$ProductId]);
        }
        $cart = json_encode($cart);
        $minutes = $this->CartTimeout;
        $response = new \Illuminate\Http\Response('Product removed from cart');
        $response->withCookie(cookie('one_o_one_shopping_cart', $cart, $minutes));
        return $response;
    }

    function LoadCartModalHtml(Request $request){
        $CartItems = (array) json_decode(request()->cookie('one_o_one_shopping_cart'));
        $CartSubTotal = 0;
        $CartCount = sizeof($CartItems);
        $TotalQuantity = 0;

        $B2BDiscountPercent = DB::table('general_settings')
            ->where('id', '=', 1)
            ->get()[0]->b2b_discount;
        if($B2BDiscountPercent == '') {
            $B2BDiscountPercent = 0;
        } else {
            $B2BDiscountPercent = floatval($B2BDiscountPercent);
        }
        $B2BDiscount = 0;

        $Html = "";
        if($CartCount == 0){
            $Categories = DB::table('categories')->where('deleted_at', null)->orderBy('order_no', 'ASC')->get();
            $Html .= '
                <div class="row">
                    <div class="col-md-12 text-dark mb-1" style="font-size: 18px;">
                        Your cart is currently empty.
                    </div>
                    <div class="col-md-12 mb-3 fs-13">
                        When you add items they\'ll appear here.
                    </div>

                    <div class="col-md-12 text-center text-dark mb-4" style="font-size: 18px;">
                        Continue shopping
                    </div>

                    <div class="col-md-12">
                        <div class="row">';
            foreach ($Categories as $category) {
                $Html .= '
                            <div class="col-md-6 mb-4">
                                <a href="' . route('CheckSlugRoute', ['slug' => $category->slug]) . '">
                                    <span class="product-category-circle">
                                        <span class="product-category-circle-img">
                                            <img src="' . asset('public/storage/categories/' . $category->icon) . '"
                                                 alt="Category Icon" class="img-fluid"/>
                                        </span>
                                    </span>
                                    <p class="mt-2 mb-0 text-black text-center">' . $category->title . '</p>
                                </a>
                            </div>';
            }
            $Html .= '  </div>
                    </div>
                </div>';
        } else {
            $Html .= '<div class="mini-cart-product-area ltn__scrollbar">';
            foreach ($CartItems as $index => $cartItem) {
                $Html .= '<div class="mini-cart-item clearfix">
                            <div class="mini-cart-img">
                                <a href="javascript:void(0);"><img src="' . asset('public/storage/products') . '/' . $cartItem->primary_img . '" alt="Image"></a>
                                <span class="mini-cart-item-delete" onclick="RemoveFromCart(\'' . $index . '\');"><i class="icon-cancel"></i></span>
                            </div>
                            <div class="mini-cart-info">
                                <h6><a href="javascript:void(0);">' . $cartItem->name . '</a></h6>
                                <span class="mini-cart-quantity">' . $cartItem->quantity . ' x ' .SiteHelper::$Currency . ' ' . number_format($cartItem->total_price, SiteHelper::$Decimals) . '</span>
                            </div>
                          </div>';
                $CartSubTotal += floatval($cartItem->total_price) * floatval($cartItem->quantity);
                $TotalQuantity += floatval($cartItem->quantity);
            }
            if($TotalQuantity >= 5) {
                $B2BDiscount = round(($CartSubTotal * $B2BDiscountPercent) / 100, 2);
            }
            $CartSubTotal -= $B2BDiscount;
            $Html .= '</div>';
            $Html .= '<div class="mini-cart-footer">
                        <div class="mini-cart-sub-total">
                            <h5>Subtotal: <span class="text-custom-primary">' . SiteHelper::$Currency . ' ' .  number_format($CartSubTotal, SiteHelper::$Decimals) . '</span></h5>
                        </div>
                        <div class="btn-wrapper">
                            <a href="' . route('CartRoute') . '" class="theme-btn-2 btn btn-effect-2">View Cart</a>
                            <a href="' . route('CheckoutRoute') . '" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                        </div>
                        <p>Shop with trust!</p>
                      </div>';
        }
        echo json_encode(base64_encode($Html));
        exit();
    }

    function LoadCartPageHtml(Request $request){
        $CartItems = (array) json_decode(request()->cookie('one_o_one_shopping_cart'));
        $CartCount = sizeof($CartItems);
        $CartSubTotal = 0;
        $GST = 0;
        $ProductDiscount = 0;
        $Shipping = 0;
        $Installation = 0;
        $TotalQuantity = 0;

        $B2BDiscountPercent = DB::table('general_settings')
            ->where('id', '=', 1)
            ->get()[0]->b2b_discount;
        if($B2BDiscountPercent == '') {
            $B2BDiscountPercent = 0;
        } else {
            $B2BDiscountPercent = floatval($B2BDiscountPercent);
        }
        $B2BDiscount = 0;

        $Html = "";
        if($CartCount == 0){
            $Html .= '<div class="col-md-12 text-center text-dark mb-1" style="font-size: 24px;">
                        Your cart is currently empty.
                      </div>
                      <div class="col-md-12 text-center mb-3">
                        When you add items they\'ll appear here.
                      </div>
                      <div class="col-md-12 text-center text-dark mt-4 mb-4" style="font-size: 20px;">
                        Continue shopping
                      </div>';
            $Categories = DB::table('categories')->where('deleted_at', null)->orderBy('order_no', 'ASC')->get();
            $Html .= '<div class="col-md-12">
                        <div class="row">';
            foreach ($Categories as $category) {
                $Html .= '<div class="col-md-3 mb-4">
                            <a href="' . route('CheckSlugRoute', ['slug' => $category->slug]) . '">
                                <span class="product-category-circle">
                                    <span class="product-category-circle-img">
                                        <img src="' . asset('public/storage/categories/' . $category->icon) . '"
                                            alt="Category Icon" class="img-fluid"/>
                                    </span>
                                </span>
                                <p class="mt-2 mb-0 text-black text-center">' . $category->title . '</p>
                            </a>
                          </div>';
            }
            $Html .= '</div>
                    </div>';
        } else {
            $Html .= '
                    <div class="col-md-12">
                        <h3 class="text-center text-custom-primary"><u>Cart Details</u></h3>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="liton__shoping-cart-area mb-120">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="shoping-cart-inner">';

            $useragent=$_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            {
                $Html .= ''.
                    '<div class="table-responsive">';
            }
            else
            {
                $Html .= ''.
                    '<div class="shoping-cart-table table-responsive">';
            }
            $Html .= ''.
                                                '<table class="table">
                                                    <tbody id="cartTableBody">';
                                                    foreach($CartItems as $index => $cartItem){
                                                        $Html .= '<p>
                                                            <td class="cart-product-remove" onclick="RemoveFromCart(\'' . $index . '\');"><p class="mt-30">x</p></td>
                                                            <td class="cart-product-image">
                                                                <a href="javascript:void(0);">
                                                                    <img src="' . asset('public/storage/products') . '/' . $cartItem->primary_img . '"
                                                                         alt="#">
                                                                </a>
                                                            </td>
                                                            <td class="cart-product-info">
                                                                <h6 class="m-15"><a href="javascript:void(0);">' . $cartItem->name . '</a></h6>
                                                            </td>
                                                            <td class="cart-product-price"><h5 class="mt-30">' . SiteHelper::$Currency . ' ' . number_format($cartItem->total_price, SiteHelper::$Decimals) . '</td>
                                           
                                                                <td class="cart-product-quantity">
                                                                <p class="mt-30" >
                                                                    <div class="cart-plus-minus">
                                                                        <div class="dec qtybutton" id="qtyDec_' . $index . '">-</div>
                                                                        <input type="text" value="' . $cartItem->quantity . '" name="qtybutton"
                                                                               class="cart-plus-minus-box">
                                                                        <div class="inc qtybutton" id="qtyAsc_' . $index . '">+</div>
                                                                    </div>
                                                                    </p>
                                                                </td>
                                                               
                                                            <td class="cart-product-subtotal"><h5 class="mt-30">' . SiteHelper::$Currency . ' ' . number_format(floatval($cartItem->total_price) * floatval($cartItem->quantity), SiteHelper::$Decimals) . '</h5></td>
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
                                                    $Html .= '</tbody>
                                                </table>
                                            </div>
                                            <div class="shoping-cart-total mt-50">
                                                <h4>Order Summary</h4>
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td>Cart Subtotal</td>
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
                                                        $Html .= '<tr>
                                                        <td>B2B Discount Amount</td>
                                                            <td>' . SiteHelper::$Currency . ' ' . number_format($B2BDiscount, SiteHelper::$Decimals) . '</td>
                                                        </tr>';
                                                    }
                                                    $Html .= '<tr>
                                                        <td>Shipping</td>
                                                        <td>' . SiteHelper::$Currency . ' ' . number_format(SiteHelper::CalculateShippingCost($TotalQuantity), SiteHelper::$Decimals) . '</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Installation Fee</td>
                                                        <td>' . SiteHelper::$Currency . ' ' . number_format($Installation, SiteHelper::$Decimals) . '</td>
                                                    </tr>
                                                    <!--<tr>
                                                        <td><input type="text" class="mb-0" name="cart-coupon"
                                                                   placeholder="Coupon code"></td>
                                                        <td>
                                                            <button type="submit" class="theme-btn-2 btn btn-effect-2">Apply
                                                                Coupon
                                                            </button>
                                                        </td>
                                                    </tr>-->
                                                    <tr>
                                                        <td><strong>Order Total</strong></td>
                                                        <td><strong>' . SiteHelper::$Currency . ' ' . number_format((($CartSubTotal + $Shipping + $Installation) - $ProductDiscount - $B2BDiscount), SiteHelper::$Decimals) . '</strong></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div class="btn-wrapper text-right">
                                                </div>
                                                <div class="w-100 mt-2">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="' . route('CheckoutRoute') . '"
                                                               class="theme-btn-2 btn btn-effect-2 w-100">Proceed to checkout</a>
                                                        </div>
                                                        <div class="col-6">
                                                            <button class="theme-btn-2 btn btn-effect-2 w-100" type="button" onclick="window.location.href=\'' . route('HomeRoute') . '\';">Continue Shopping <i class="fas fa-arrow-right"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        echo json_encode(base64_encode($Html));
        exit();
    }

    function CartQuantityUpdate(Request $request){
        $Product = $request->post('Product');
        $productDetails = Product::findOrFail($Product);
        if(!isset($productDetails->name)){
            echo 'An unhandled error occurred!';
            exit();
        }
        $Quantity = $request->post('Quantity');
        $cart = array();
        if(request()->cookie('one_o_one_shopping_cart') != ''){
            $cart = (array) json_decode(request()->cookie('one_o_one_shopping_cart'));
        }

        if(isset($cart[$Product])) {
            foreach ($cart as $index => $item){
                if($index == $Product){
                    if(floatval($productDetails->quantity) >= floatval($Quantity)){
                        $item->quantity = $Quantity;
                        break;
                    } else {
                        echo 'Product out of stock!';
                        exit();
                    }
                }
            }
        }

        $cart = json_encode($cart);
        $minutes = $this->CartTimeout;
        $response = new \Illuminate\Http\Response('Product quantity updated');
        $response->withCookie(cookie('one_o_one_shopping_cart', $cart, $minutes));
        return $response;
    }

    function CartCount(Request $request){
        $Cart = (array) json_decode(request()->cookie('one_o_one_shopping_cart'));
        return sizeof($Cart);
    }

    function GetCartItems(Request $request){
        $CartItems = (array) json_decode(request()->cookie('one_o_one_shopping_cart'));
        return $CartItems;
    }
    function EmptyCart(){
        $response = new \Illuminate\Http\Response('Cart cleared');
        $response->withCookie(cookie('one_o_one_shopping_cart', '', 0));
        return $response;
    }

    function readCart(){
        echo \request()->cookie('one_o_one_shopping_cart');
        exit();
    }
}
