@extends('site.layouts.app')
@section('content')
    @php
        $CartController = new \App\Http\Controllers\CartController();
        $CartCount = $CartController->CartCount(request());
        $CartItems = $CartController->GetCartItems(request());
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
    @endphp

    <section>
        <div class="container">
            <div class="row mt-4 mb-5">
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

                <div class="col-md-12">
                    <h3 class="text-center text-custom-primary mb-0"><u>Checkout</u></h3>
                </div>
                <div class="col-md-12 mt-4">
                    <!-- WISHLIST AREA START -->
                    <div class="ltn__checkout-area mb-105">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ltn__checkout-inner">
                                        @if(!\Illuminate\Support\Facades\Auth::check())
                                            <div class="ltn__checkout-single-content ltn__returning-customer-wrap">
                                                <h5 class="d-none d-md-block">
                                                    Already have an account?&nbsp;
                                                    <a class="text-custom-primary " href="#ltn__returning-customer-login"
                                                       data-bs-toggle="collapse">Click here to login</a>
                                                    <span class="float-right">
                                                        <a href="{{route('HomeRoute')}}" class="text-custom-primary d-none d-md-block">
                                                            Continue Shopping <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    </span>
                                                </h5>
                                                <!--For mobile-->
                                                <h5 class="d-md-none">
                                                    Already have an account?&nbsp;<br>
                                                    <a style="font-size:12px;" class="text-custom-primary " href="#ltn__returning-customer-login"
                                                       data-bs-toggle="collapse">Click here to login
                                                    </a>&nbsp;&nbsp;&nbsp;
                                                    <a  style="font-size:12px;" href="{{route('HomeRoute')}}" class="text-custom-primary">
                                                            Continue Shopping <i class="fas fa-arrow-right"></i>
                                                    </a>

                                                </h5>
                                                <div id="ltn__returning-customer-login"
                                                     class="collapse ltn__checkout-single-content-info @error('email') show @enderror">
                                                    <div class="ltn_coupon-code-form ltn__form-box">
                                                        <p>Please login your account.</p>
                                                        <form method="POST" action="{{ route('login') }}" id="login-form">
                                                            @csrf
                                                            <input type="hidden" name="pageType" value="Checkout"/>
                                                            <input type="hidden" name="g-recaptcha-response" id="response">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    @error('email')
                                                                    <div class="alert alert-danger p-2 fs-13">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                    @error('password')
                                                                    <div class="alert alert-danger p-2 fs-13">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                    @if(session()->has('message'))
                                                                        <div class="alert alert-danger p-2 fs-13">
                                                                            {{ session('message') }}
                                                                        </div>
                                                                    @elseif(session()->has('error'))
                                                                        <div class="alert alert-danger p-2 fs-13">
                                                                            {{ session('error') }}
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="input-item input-item-email ltn__custom-icon">
                                                                        <input type="email" name="email"
                                                                               placeholder="Email ID"
                                                                               value="{{ old('email') }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-item input-item-password ltn__custom-icon">
                                                                        <input type="password" name="password"
                                                                               placeholder="Password" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button class="theme-btn-2 btn btn-effect-2 text-uppercase"
                                                                    type="button" onclick="getLogin();">
                                                                Login
                                                            </button>
                                                            <label class="input-info-save mb-0">
                                                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                                &nbsp;Remember me
                                                            </label>
                                                            <p class="mt-30"><a href="javascript:void(0);">Lost your
                                                                    password?</a></p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="ltn__checkout-single-content mt-3">
                                            <h4 class="title-2">Shipping Details</h4>
                                            <div class="ltn__checkout-single-content-info">
                                                <form action="#" id="order_form">
                                                    <input type="hidden" name="g-recaptcha-response" id="order_token">
                                                    <h6>Personal Information</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-item input-item-name ltn__custom-icon">
                                                                <input type="text" name="ltn__first_name"
                                                                       id="ltn__first_name"
                                                                       maxlength="100"
                                                                       autocomplete="off"
                                                                       value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->first_name; } ?>"
                                                                       placeholder="First name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-item input-item-name ltn__custom-icon">
                                                                <input type="text" name="ltn__last_name"
                                                                       id="ltn__last_name"
                                                                       maxlength="100"
                                                                       autocomplete="off"
                                                                       value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->last_name; } ?>"
                                                                       placeholder="Last name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-item input-item-email ltn__custom-icon">
                                                                <input type="email" name="ltn__email"
                                                                       id="ltn__email"
                                                                       maxlength="100"
                                                                       autocomplete="off"
                                                                       value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->email; } ?>"
                                                                       <?php if(sizeof($CustomerInformation) > 0) { echo 'readonly'; } ?>
                                                                       placeholder="Email Address" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-item input-item-phone ltn__custom-icon">
                                                                <input type="text" name="ltn__phone"
                                                                       id="ltn__phone"
                                                                       onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                                                       maxlength="100"
                                                                       autocomplete="off"
                                                                       value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->phone; } ?>"
                                                                       placeholder="Phone Number" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-item input-item-website ltn__custom-icon">
                                                                <input type="text" name="ltn__company"
                                                                       id="ltn__company"
                                                                       maxlength="100"
                                                                       autocomplete="off"
                                                                       value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->company; } ?>"
                                                                       placeholder="Company name (optional)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-item input-item-website ltn__custom-icon">
                                                                <input type="text" name="ltn__company_address"
                                                                       id="ltn__company_address"
                                                                       maxlength="100"
                                                                       autocomplete="off"
                                                                       value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->company_address; } ?>"
                                                                       placeholder="Company address (optional)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        {{--Billing Address--}}
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <h6>Billing Address</h6>
                                                                    <div class="input-item">
                                                                        <input type="text"
                                                                               maxlength="200"
                                                                               name="ltn__billing_address"
                                                                               id="ltn__billing_address"
                                                                               autocomplete="off"
                                                                               value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->billing_address; } ?>"
                                                                               placeholder="House number and street name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <h6>Town / City</h6>
                                                                    <div class="input-item">
                                                                        <input type="text" name="ltn__billing_city" id="ltn__billing_city" placeholder="City" autocomplete="off" maxlength="100" value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->billing_city; } ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <h6>State / Province</h6>
                                                                    <div class="input-item">
                                                                        <input type="text" placeholder="State" id="ltn__billing_state" name="ltn__billing_state" autocomplete="off" maxlength="100" value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->billing_state; } ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <h6>Zip / PostCode</h6>
                                                                    <div class="input-item">
                                                                        <input type="text" placeholder="Zip" id="ltn__billing_zipcode" name="ltn__billing_zipcode" autocomplete="off" maxlength="100" value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->billing_zipcode; } ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--Shipping Address--}}
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <h6>
                                                                        Shipping Address
                                                                        <span class="float-end fw-500">
                                                                            <label for="checkboxCopyAddress">
                                                                                <input type="checkbox" id="checkboxCopyAddress" onchange="CopyBillingAddress();"> Same as Billing
                                                                            </label>
                                                                        </span>
                                                                    </h6>
                                                                    <div class="input-item">
                                                                        <input type="text"
                                                                               maxlength="200"
                                                                               name="ltn__shipping_address"
                                                                               id="ltn__shipping_address"
                                                                               autocomplete="off"
                                                                               value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->shipping_address; } ?>"
                                                                               placeholder="House number and street name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <h6>Town / City</h6>
                                                                    <div class="input-item">
                                                                        <input type="text" name="ltn__shipping_city" id="ltn__shipping_city" placeholder="City" autocomplete="off" maxlength="100" value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->shipping_city; } ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <h6>State / Province</h6>
                                                                    <div class="input-item">
                                                                        <input type="text" placeholder="State" id="ltn__shipping_state" name="ltn__shipping_state" autocomplete="off" maxlength="100" value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->shipping_state; } ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6">
                                                                    <h6>Zip / PostCode</h6>
                                                                    <div class="input-item">
                                                                        <input type="text" placeholder="Zip" id="ltn__shipping_zipcode" name="ltn__shipping_zipcode" autocomplete="off" maxlength="100" value="<?php if(sizeof($CustomerInformation) > 0) { echo $CustomerInformation[0]->shipping_zipcode; } ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <p>
                                                        <label class="input-info-save mb-0">
                                                            <input type="checkbox"
                                                                   id="createAccount"
                                                                   value="1"
                                                                   <?php if(sizeof($CustomerInformation) > 0) { echo 'disabled'; } ?>
                                                                   name="createAccount"> Create an account?
                                                        </label>
                                                    </p>
                                                    <h6>Order Notes (optional)</h6>
                                                    <div class="input-item input-item-textarea ltn__custom-icon">
                                                        <textarea name="ltn__message"
                                                                  id="ltn__message"
                                                                  maxlength="1000"
                                                                  autocomplete="off"
                                                                  placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                <div style="margin-bottom:-60px;" class="d-md-none">
                                </div>
                                    <div class="ltn__checkout-payment-method mt-50">
                                        <h4 class="title-2">Payment Method</h4>
                                        <div id="checkout_accordion_1">
                                            <input type="hidden" name="paymentGateWay" id="paymentGateWay" value="COD">
                                            <!-- card -->
                                            <div class="card">
                                                <h5 class="collapsed ltn__card-title" data-bs-toggle="collapse"
                                                    data-bs-target="#faq-item-2-1" aria-expanded="false" onclick="ChangePaymentGateway('Check Payments');">
                                                    Check payments
                                                </h5>
                                                <div id="faq-item-2-1" class="collapse"
                                                     data-bs-parent="#checkout_accordion_1">
                                                    <div class="card-body">
                                                        <p>Please send a check to Store Name, Store Street, Store Town,
                                                            Store State / County, Store Postcode.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- card -->
                                            <div class="card">
                                                <h5 class="ltn__card-title" data-bs-toggle="collapse"
                                                    data-bs-target="#faq-item-2-2" aria-expanded="true" onclick="ChangePaymentGateway('COD');">
                                                    Cash on delivery
                                                </h5>
                                                <div id="faq-item-2-2" class="collapse show"
                                                     data-bs-parent="#checkout_accordion_1">
                                                    <div class="card-body">
                                                        <p>Pay with cash upon delivery.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- card -->
                                            <!-- <div class="card">
                                                <h5 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-3" aria-expanded="false" >
                                                    PayPal <img src="img/icons/payment-3.png" alt="#">
                                                </h5>
                                                <div id="faq-item-2-3" class="collapse" data-bs-parent="#checkout_accordion_1">
                                                    <div class="card-body">
                                                        <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="ltn__payment-note mt-30 mb-30">
                                            <p>Your personal data will be used to process your order, support your
                                                experience throughout this website, and for other purposes described in
                                                our privacy policy.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                     <div style="margin-bottom:-60px;" class="d-md-none">
                                </div>
                                    <div class="shoping-cart-total mt-50">
                                        <h4 class="title-2">Order Summary</h4>
                                        <table class="table">
                                            <tbody id="checkoutPageHtml">
                                            @foreach($CartItems as $index => $cartItem)
                                                <tr>
                                                    <td>{{$cartItem->name}} <strong>x {{$cartItem->quantity}}</strong></td>
                                                    <td>{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format(floatval($cartItem->total_price) * floatval($cartItem->quantity), \App\Helpers\SiteHelper::$Decimals)}}</td>
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

                                            {{-- B2B Discount Calculation--}}
                                            <?php
                                            if($TotalQuantity >= 5) {
                                                $_SubAmount = $CartSubTotal - $ProductDiscount;
                                                $B2BDiscount = round(($_SubAmount * $B2BDiscountPercent) / 100, 2);
                                            }
                                            ?>
                                            {{-- B2B Discount Calculation--}}

                                            <tr>
                                                <td>Sub Total</td>
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
                                                <td>{{\App\Helpers\SiteHelper::$Currency}} {{number_format($Shipping, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Installation Fee</td>
                                                <td>{{\App\Helpers\SiteHelper::$Currency}} {{number_format($Installation, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" class="mb-0" name="cart-coupon"
                                                           id="discountCodeInput"
                                                           placeholder="Coupon code">
                                                </td>
                                                <td>
                                                    <button type="submit" class="theme-btn-2 btn btn-effect-2 d-none d-md-block" onclick="ApplyDiscountCode(this);">
                                                        Apply Coupon
                                                    </button>
                                                    <button style="font-size:8px;" type="submit" class="theme-btn-2 btn btn-effect-2 d-md-none" onclick="ApplyDiscountCode(this);">
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
                                                <td><strong id="orderTotalDisplay">{{\App\Helpers\SiteHelper::$Currency}} {{number_format((($CartSubTotal + $Shipping + $Installation) - $ProductDiscount - $B2BDiscount), \App\Helpers\SiteHelper::$Decimals)}}</strong></td>
                                            </tr>
                                            <tr style="border-top: none; background-color: transparent;">
                                                <td style="border-bottom: none;">&nbsp;</td>
                                                <td style="border-bottom: none;">
                                                    <button class="theme-btn-2 btn btn-effect-2 text-uppercase w-100 mt-0 d-none d-md-block"
                                                            type="button" onclick="PlaceOrder(this);">Place order
                                                    </button>
                                                    <button style="font-size:8px;" class="theme-btn-2 btn btn-effect-2 text-uppercase w-100 mt-0 d-md-none"
                                                            type="button" onclick="PlaceOrder(this);">Place order
                                                    </button>
                                                </td>
                                            </tr>
                                            <input type="hidden" name="orderSubTotal" id="orderSubTotal" value="{{$CartSubTotal}}" />
                                            <input type="hidden" name="orderGSTTotal" id="orderGSTTotal" value="{{$GST}}" />
                                            <input type="hidden" name="orderDiscountTotal" id="orderDiscountTotal" value="{{$ProductDiscount}}" />
                                            <input type="hidden" name="orderShipping" id="orderShipping" value="{{$Shipping}}" />
                                            <input type="hidden" name="orderInstallation" id="orderInstallation" value="{{$Installation}}" />
                                            <input type="hidden" name="voucherAmount" id="voucherAmount" value="0" />
                                            <input type="hidden" name="b2bDiscount" id="b2bDiscount" value="{{$B2BDiscount}}" />
                                            <input type="hidden" name="orderTotal" id="orderTotal" value="{{(($CartSubTotal + $Shipping + $Installation) - $ProductDiscount - $B2BDiscount)}}" />
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- WISHLIST AREA START -->
                    <div style="margin-bottom:-120px;" class="d-md-none">

                    </div>
                </div>
            </div>
        </div>
    </section>
     <!--Recaptcha Desktop-->
    {{--<script src="https://www.google.com/recaptcha/api.js"></script>--}}
    <script src="https://www.google.com/recaptcha/api.js?render=6LcUceMfAAAAACPs5b7QopMRLfY2CeRZI37yIf94"></script>
    <script>
        function getLogin()
        {
            grecaptcha.ready(function(){
                grecaptcha.execute('6LcUceMfAAAAACPs5b7QopMRLfY2CeRZI37yIf94',{ action: "submit" }).then(function(token){
                  if(token){
                      document.getElementById('response').value=token;
                      $("#login-form").submit();
                  }
                })
            });
        }
    </script>
@endsection