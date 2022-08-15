@extends('site.layouts.app')
@section('content')
    <style>
        @media screen and (max-width:768px){
            h6{
                font-size: 9px;
            }
            h5{
                font-size: 12px;
                font-weight: 500;
            }
            .cart-plus-minus {

                height: 55px;
                height: 35px;
                /* line-height: 56px; */
                line-height: 29px;
                /* width: 140px; */
                width: 89px;
                text-align: center;
            }
            .table>:not(caption)>*>* {
                padding: 30px 7px 24px 14px;
                background-color: var(--bs-table-bg);
                border-bottom-width: 1px;
                box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
            }
            .mt-30{
                margin-top:30px;
            }
            .m-15{
                margin-top:15px;
            }
        }


    </style>
    @php
        $B2BDiscountPercent = \Illuminate\Support\Facades\DB::table('general_settings')
            ->where('id', '=', 1)
            ->get()[0]->b2b_discount;
        if($B2BDiscountPercent == '') {
            $B2BDiscountPercent = 0;
        } else {
            $B2BDiscountPercent = floatval($B2BDiscountPercent);
        }
        $CartController = new \App\Http\Controllers\CartController();
        $CartCount = $CartController->CartCount(request());
        $CartItems = $CartController->GetCartItems(request());
        $CartSubTotal = 0;
        $GST = 0;
        $ProductDiscount = 0;
        $B2BDiscount = 0;
        $Shipping = 0;
        $Installation = 0;
        $TotalQuantity = 0;
    @endphp

    <section>
        <div class="container">
            <div class="row mt-4">
                <!-- Banner image -->
                @if(isset($PageDetails[0]->banner_img))
                    <div class="col-md-12 mb-5 d-none d-md-block">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img)}}" width="100%" height="150" alt="Price Promise Banner Image">
                    </div>
                @endif
                @if(isset($PageDetails[0]->banner_img_mobile))
                    <div class="col-md-12 mb-5 d-md-none">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img_mobile)}}" width="100%" height="150" alt="Price Promise Banner Image">
                    </div>
                @endif
            </div>

            <div class="row mb-5" id="cartPageHtml">
                @if($CartCount == 0)
                    <div class="col-md-12 text-center text-dark mb-1" style="font-size: 24px;">
                        Your cart is currently empty.
                    </div>
                    <div class="col-md-12 text-center mb-3">
                        When you add items they'll appear here.
                    </div>

                    <div class="col-md-12 text-center text-dark mt-4 mb-4" style="font-size: 20px;">
                        Continue shopping
                    </div>

                    @php
                        $Categories = Illuminate\Support\Facades\DB::table('categories')->where('deleted_at', null)->orderBy('order_no', 'ASC')->get();
                    @endphp
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($Categories as $category)
                                <div class="col-md-3 mb-4">
                                    <a href="{{route('CheckSlugRoute', ['slug' => $category->slug])}}">
                                        <span class="product-category-circle">
                                            <span class="product-category-circle-img">
                                                <img src="{{asset('public/storage/categories/' . $category->icon)}}"
                                                 alt="Category Icon" class="img-fluid"/>
                                            </span>
                                        </span>
                                        <p class="mt-2 mb-0 text-black text-center">{{$category->title}}</p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <h3 class="text-center text-custom-primary"><u>Cart Details</u></h3>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="liton__shoping-cart-area mb-120">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="shoping-cart-inner">
                                            <?php
                                            $useragent=$_SERVER['HTTP_USER_AGENT'];
                                            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
                                            {
                                                //Mobile View - Start
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table space">
                                                    <tbody id="cartTableBody">
                                                    @foreach($CartItems as $index => $cartItem)
                                                        <tr>
                                                            <td  class="cart-product-remove" onclick="RemoveFromCart('{{$index}}');"><p class="mt-30">x</p></td>
                                                            <td class="cart-product-image">
                                                                <a href="javascript:void(0);">
                                                                    <img src="{{asset('public/storage/products') . '/' . $cartItem->primary_img}}"
                                                                         alt="#">
                                                                </a>
                                                            </td>
                                                            <td class="cart-product-info">
                                                                <h6 class="m-15"><a href="javascript:void(0);">{{$cartItem->name}}</a></h6>
                                                            </td>
                                                            <td><h5 style="margin-top: 30px;">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($cartItem->total_price, \App\Helpers\SiteHelper::$Decimals)}}</h5></td>
                                                            <td class="cart-product-quantity" >
                                                                <p class="mt-30" >
                                                                <div class="cart-plus-minus">
                                                                    <div class="dec qtybutton" id="qtyDec_{{$index}}">-</div>
                                                                    <input type="text" value="{{$cartItem->quantity}}" name="qtybutton"
                                                                           class="cart-plus-minus-box">
                                                                    <div class="inc qtybutton" id="qtyAsc_{{$index}}">+</div>
                                                                </div>
                                                                </p>
                                                            </td>
                                                            <td><h5 class="mt-30">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format(floatval($cartItem->total_price) * floatval($cartItem->quantity), \App\Helpers\SiteHelper::$Decimals)}}</h5></td>
                                                        </tr>
                                                        @php
                                                            $CartSubTotal += floatval($cartItem->unit_price) * floatval($cartItem->quantity);
                                                            $GST += \App\Helpers\SiteHelper::CalculateGSTCost($cartItem->tax_price, $cartItem->quantity);
                                                            $ProductDiscount += \App\Helpers\SiteHelper::CalculateDiscountCost($cartItem->discount_price, $cartItem->quantity);
                                                            $Installation += \App\Helpers\SiteHelper::CalculateInstallationCost($cartItem->installation_price, $cartItem->quantity);
                                                            $TotalQuantity += floatval($cartItem->quantity);
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        $Shipping = \App\Helpers\SiteHelper::CalculateShippingCost($TotalQuantity);
                                                    @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                            }
                                            else {
                                                //Desktop View - Start
                                            ?>
                                            <div class="shoping-cart-table table-responsive">
                                                <table class="table">
                                                    <tbody id="cartTableBody">
                                                    @foreach($CartItems as $index => $cartItem)
                                                        <tr>
                                                            <td class="cart-product-remove" onclick="RemoveFromCart('{{$index}}');">x</td>
                                                            <td class="cart-product-image">
                                                                <a href="javascript:void(0);">
                                                                    <img src="{{asset('public/storage/products') . '/' . $cartItem->primary_img}}"
                                                                         alt="#">
                                                                </a>
                                                            </td>
                                                            <td class="cart-product-info">
                                                                <h6><a href="javascript:void(0);">{{$cartItem->name}}</a></h6>
                                                            </td>
                                                            <td class="cart-product-price">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($cartItem->total_price, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                            <td class="cart-product-quantity">
                                                                <div class="cart-plus-minus">
                                                                    <div class="dec qtybutton" id="qtyDec_{{$index}}">-</div>
                                                                    <input type="text" value="{{$cartItem->quantity}}" name="qtybutton"
                                                                           class="cart-plus-minus-box">
                                                                    <div class="inc qtybutton" id="qtyAsc_{{$index}}">+</div>
                                                                </div>
                                                            </td>
                                                            <td class="cart-product-subtotal">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format(floatval($cartItem->total_price) * floatval($cartItem->quantity), \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                        </tr>
                                                        @php
                                                            $CartSubTotal += floatval($cartItem->unit_price) * floatval($cartItem->quantity);
                                                            $GST += \App\Helpers\SiteHelper::CalculateGSTCost($cartItem->tax_price, $cartItem->quantity);
                                                            $ProductDiscount += \App\Helpers\SiteHelper::CalculateDiscountCost($cartItem->discount_price, $cartItem->quantity);
                                                            $Installation += \App\Helpers\SiteHelper::CalculateInstallationCost($cartItem->installation_price, $cartItem->quantity);
                                                            $TotalQuantity += floatval($cartItem->quantity);
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        $Shipping = \App\Helpers\SiteHelper::CalculateShippingCost($TotalQuantity);
                                                    @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                             <?php
                                            }
                                            ?>

                                            {{-- B2B Discount Calculation--}}
                                             <?php
                                                if($TotalQuantity >= 5) {
                                                    $_SubAmount = $CartSubTotal - $ProductDiscount;
                                                    $B2BDiscount = round(($_SubAmount * $B2BDiscountPercent) / 100, 2);
                                                }
                                             ?>
                                            {{-- B2B Discount Calculation--}}

                                            {{--End mobile section--}}
                                            <div class="shoping-cart-total mt-50">
                                                <h4>Order Summary</h4>
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td>Cart Subtotal</td>
                                                        <td>{{\App\Helpers\SiteHelper::$Currency}} {{number_format($CartSubTotal, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>GST 17% Included</td>
                                                        <td>{{\App\Helpers\SiteHelper::$Currency}} {{number_format($GST, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Discount Amount</td>
                                                        <td>{{\App\Helpers\SiteHelper::$Currency}} {{number_format($ProductDiscount, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                    </tr>
                                                    @if($B2BDiscount != 0)
                                                        <tr>
                                                            <td>B2B Discount Amount</td>
                                                            <td>{{\App\Helpers\SiteHelper::$Currency}} {{number_format($B2BDiscount, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Shipping</td>
                                                        <td>{{\App\Helpers\SiteHelper::$Currency}} {{number_format(\App\Helpers\SiteHelper::CalculateShippingCost($TotalQuantity), \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Installation Fee</td>
                                                        <td>{{\App\Helpers\SiteHelper::$Currency}} {{number_format($Installation, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Order Total</strong></td>
                                                        <td><strong>{{\App\Helpers\SiteHelper::$Currency}} {{number_format((($CartSubTotal + $Shipping + $Installation) - $ProductDiscount - $B2BDiscount), \App\Helpers\SiteHelper::$Decimals)}}</strong></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div class="btn-wrapper text-right">
                                                </div>
                                                <div class="w-100 mt-2">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="{{route('CheckoutRoute')}}"
                                                               class="theme-btn-2 btn btn-effect-2 w-100 d-none d-md-block">Proceed to checkout</a>
                                                               <!--For mobile-->
                                                               <a style="font-size:9px;" href="{{route('CheckoutRoute')}}"
                                                               class="theme-btn-2 btn btn-effect-2 w-100 d-md-none">Proceed to checkout</a>
                                                        </div>
                                                        <div class="col-6">
                                                            <button class="theme-btn-2 btn btn-effect-2 w-100 d-none d-md-block" type="button" onclick="window.location.href='{{route('HomeRoute')}}';">Continue Shopping <i class="fas fa-arrow-right"></i></button>
                                                            <!--for mobile-->
                                                            <button style="font-size:9px;" class="theme-btn-2 btn btn-effect-2 w-100 d-md-none" type="button" onclick="window.location.href='{{route('HomeRoute')}}';">Continue Shopping <i class="fas fa-arrow-right"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div style="margin-bottom:-130px;" class="d-md-none"></div>
    </section>
@endsection
