<!-- FOOTER AREA START -->
<footer class="ltn__footer-area text-black ">
    <div class="footer-top-area plr--5">
        <div class="container d-none d-md-block">
            <div class="row ltn__no-gutter ">
                <div class="col-xl-2 col-md-4 col-sm-4 col-12 d-none d-md-block">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">Help & Services</h4>
                        <div class="footer-menu">
                            <ul class="fs-14">
                                <li>
                                    <a href="{{route('ContactUsRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 1.png')}}"
                                             alt="Footer Icon 1" class="img-fluid"/>
                                        Contact Us
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('OrdersCollectRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 2.png')}}"
                                             alt="Footer Icon 2" class="img-fluid"/>
                                        &nbsp;&nbsp;&nbsp;
                                        Orders & Collect
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('StoresRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 3.png')}}"
                                             alt="Footer Icon 3" class="img-fluid"/>
                                        &nbsp;
                                        Stores
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-4 col-12 d-none d-md-block">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">&nbsp;</h4>
                        <div class="footer-menu">
                            <ul class="fs-14">
                                <li>
                                    <a href="{{route('track.order')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 6.png')}}"
                                             alt="Footer Icon 6" class="img-fluid"/>
                                        &nbsp;
                                        Track your Order
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('ReturnCancellationsRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 5.png')}}"
                                             alt="Footer Icon 5" class="img-fluid"/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        Return & Cancellations
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('WaysToPayRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 4.png')}}"
                                             alt="Footer Icon 4" class="img-fluid"/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        Ways to Pay
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-4 col-12 d-none d-md-block">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">&nbsp;</h4>
                        <div class="footer-menu">
                            <ul class="fs-14">
                                <li>
                                    <a href="{{route('DeliveryOptionsRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 7.png')}}"
                                             alt="Footer Icon 7" class="img-fluid"/>
                                        &nbsp;
                                        Delivery/Installation
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('PricePromiseRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 8.png')}}"
                                             alt="Footer Icon 8" class="img-fluid"/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Price promise
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('CareRepairRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 9.png')}}"
                                             alt="Footer Icon 9" class="img-fluid"/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Care & Repair
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('InstallmentGuideRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 9.png')}}"
                                             alt="Footer Icon 9" class="img-fluid"/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Installment Guide
                                    </a>
                                </li>
                                {{--<li>
                                    <a href="{{route('InstallationGuideRoute')}}">
                                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 9.png')}}"
                                             alt="Footer Icon 9" class="img-fluid"/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Installation Guide
                                    </a>
                                </li>--}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12 col-sm-12 col-12 fs-15">
                    <div class="footer-custom-section">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <p class="text-black mb-0" style="line-height: 1.3;">
                                    For advice before you buy, video call with one
                                    of our expert
                                </p>
                                <a href="javascript:void(0);" class="text-custom-primary">Shoplive <i
                                            class="fa fa-angle-right"></i></a>
                            </div>
                            <div class="col-6 mb-2">
                                <p class="text-black mb-0" style="line-height: 1.3;">
                                    Follow us on social media platforms
                                    to stay tuned
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="text-black mb-0" style="line-height: 1.3;">
                                    Subscribe to our youtube channels for
                                    best upcoming products
                                </p>
                                <a href="javascript:void(0);" class="text-custom-primary">101 Electronics <i
                                            class="fa fa-angle-right"></i></a>
                            </div>
                            <div class="col-6">
                                <p class="text-black mb-2" style="line-height: 1.3;">
                                    Secure Payment Method
                                </p>
                                @php
                                    $SecurePayments = array();
                                    $GeneralSettings = Illuminate\Support\Facades\DB::table('general_settings')
                                                ->where('id', 1)
                                                ->get();
                                    if ($GeneralSettings[0]->secure_payment != "")
                                    {
                                        $SecurePayments = explode(',' , $GeneralSettings[0]->secure_payment);
                                    }
                                @endphp
                                @if(sizeof($SecurePayments) > 0)
                                    @foreach($SecurePayments as $image)
                                        <img src="{{asset('public/storage/payment-methods/' . $image)}}"
                                             class="img-fluid cursor-pointer app_download_button"
                                             style="width:70px;height:40px;"/>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4 mb-2">
                    <div class="ltn__copyright-design clearfix text-center fs-15">
                        <p class="text-black mb-2 d-none d-md-block"><a href="{{route('PrivacyPolicyRoute')}}"><span
                                        class="red-hover-affect cursor-pointer">Privacy & Cookies Policy</span></a>
                            | <a href="{{route('TermsConditionsRoute')}}"><span
                                        class="red-hover-affect cursor-pointer">Terms & Conditions</span></a> |
                            <span><a href="https://www.facebook.com/101electronics.pk/"><img
                                            src="{{asset('public/assets/images/footer/Facebook.png')}}" alt=""
                                            class="img-fluid" style="width: 24px; margin-right: 5px;"></a><a
                                        href="https://instagram.com/101electronics.pk?igshid=YmMyMTA2M2Y="><img
                                            src="{{asset('public/assets/images/footer/Instagram.png')}}" alt=""
                                            class="img-fluid" style="width: 24px; margin-right: 5px;"></a><a
                                        href="https://twitter.com/101electronicsP?t=Yxjq6E0ng16tlAp5eZ5Gkw&s=08"><img
                                            src="{{asset('public/assets/images/footer/Twitter.png')}}" alt=""
                                            class="img-fluid" style="width: 24px; margin-right: 5px;"></a><a
                                        href="https://youtube.com/channel/UChH8q2bdJJGDj1o9Mp47M-A"><img
                                            src="{{asset('public/assets/images/footer/Youtube.png')}}" alt=""
                                            class="img-fluid" style="width: 24px; margin-right: 5px;"></a><a
                                        href="https://pin.it/CqRuohG"><img
                                            src="{{asset('public/assets/images/footer/Pinterest.png')}}" alt=""
                                            class="img-fluid" style="width: 24px;"></a></span>
                        </p>
                        <p class="text-black mb-0">All Copyrights are reserved for 101 Electronics | <span
                                    class="current-year"></span>
                            {{--| Developed by--}}
                            {{--<a href="http://metasolutions.com.pk/" target="_blank"--}}
                               {{--class="text-custom-primary fw-600">Meta Solutions</a>--}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{--Mobile - Footer--}}
        <div class="container d-md-none">
            <h5 class="footer-title" style="font-size:15px;">Help & Services</h5>
            <div class="row">
                <div class="col-4 text-center">
                    <a href="{{route('ContactUsRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 1.png')}}"
                             alt="Footer Icon 1" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;"> Contact Us
                        </p>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{route('track.order')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 6.png')}}"
                             alt="Footer Icon 6" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;"> Track your Order</p>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{route('DeliveryOptionsRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 7.png')}}"
                             alt="Footer Icon 7" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;"> Delivery/Installation</p>
                    </a>
                </div>

                <div class="col-4 text-center">
                    <a href="{{route('OrdersCollectRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 2.png')}}"
                             alt="Footer Icon 2" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;"> Orders & Collect</p>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{route('ReturnCancellationsRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 5.png')}}"
                             alt="Footer Icon 5" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;">Return & Cancellations</p>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{route('PricePromiseRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 8.png')}}"
                             alt="Footer Icon 8" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;"> Price promise</p>
                    </a>
                </div>

                <div class="col-4 text-center">
                    <a href="{{route('StoresRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 3.png')}}"
                             alt="Footer Icon 3" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;"> Stores</p>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{route('WaysToPayRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 4.png')}}"
                             alt="Footer Icon 4" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;"> Ways to Pay</p>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{route('CareRepairRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 9.png')}}"
                             alt="Footer Icon 9" class="img-fluid"/>
                        <br>
                        <p style="font-size:9px;">Care & Repair</p>
                    </a>
                </div>

                <div class=" col-4 text-center">
                    <a href="{{route('InstallmentGuideRoute')}}">
                        <img src="{{asset('public/assets/images/footer/links/Footer Icon 9.png')}}"
                             alt="Footer Icon 9" class="img-fluid" style="margin-left:20px;"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <p style="font-size:9px;">Installment Guide
                    </a>
                </div>
                <div class=" col-4 text-center">
                    <a href="{{route('AboutUsRoute')}}">
                        <i class="fa fa-user" aria-hidden="true" style="color:#DB9CA8;font-size: 18px"></i>
                        <p style="font-size:9px;">About Us
                    </a>
                </div>
                <div class=" col-4 text-center">
                    <a href="{{route('B2BRoute')}}">
                        <i class="fa fa-briefcase fa-1x" aria-hidden="true" style="color:#DB9CA8;font-size: 18px"></i>
                        <p style="font-size:9px;">B2B
                    </a>
                </div>
                <div class=" col-4 text-center">
                    <a href="{{route('clearanceSale')}}">
                        <i class="fa fa-bullhorn" aria-hidden="true" style="color:#DB9CA8;font-size: 18px"></i>
                        <p style="font-size:9px;">Clearance Sale
                    </a>
                </div>
                <div class=" col-4 text-center">
                    <a href="{{route('DiscountVoucherRoute')}}">
                        <i class="fa fa-envelope-open" aria-hidden="true" style="color:#DB9CA8;font-size: 18px"></i>
                        <p style="font-size:9px;">Discount Voucher
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="{{route('TermsConditionsRoute')}}">
                        <i class="fa fa-file" aria-hidden="true" style="color:#DB9CA8;font-size: 18px"></i>
                        <p style="font-size:9px;">Terms & Conditions</p>
                    </a>
                </div>
                <div class="col-4 text-center">
                </div>
                <div class="col-4 text-center">
                    <a href="{{route('PrivacyPolicyRoute')}}">
                        <i class="fa fa-user-secret" aria-hidden="true" style="color:#DB9CA8;font-size: 18px"></i>
                        <p style="font-size:9px;">Privacy & Policy</p>
                    </a>
                </div>

                <div class="col-12">
                    <div class="footer-custom-section">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <p class="text-black mb-0" style="line-height: 1.3;">
                                    For advice before you buy, video call with one
                                    of our expert
                                </p>
                                <a href="javascript:void(0);" class="text-custom-primary">Shoplive <i
                                            class="fa fa-angle-right"></i></a>
                            </div>
                            <div class="col-6 mb-2">
                                <p class="text-black mb-0" style="line-height: 1.3;">
                                    Follow us on social media platforms
                                    to stay tuned
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="text-black mb-0" style="line-height: 1.3;">
                                    Subscribe to our youtube channels for
                                    best upcoming products
                                </p>
                                <a href="javascript:void(0);" class="text-custom-primary">101 Electronics <i
                                            class="fa fa-angle-right"></i></a>
                            </div>
                            <div class="col-6">
                                <p class="text-black mb-2" style="line-height: 1.3;">
                                    Secure Payment Method
                                </p>
                                @php
                                    $SecurePayments = array();
                                    $GeneralSettings = Illuminate\Support\Facades\DB::table('general_settings')
                                                ->where('id', 1)
                                                ->get();
                                    if ($GeneralSettings[0]->secure_payment != "")
                                    {
                                        $SecurePayments = explode(',' , $GeneralSettings[0]->secure_payment);
                                    }
                                @endphp
                                @if(sizeof($SecurePayments) > 0)
                                    @foreach($SecurePayments as $image)
                                        <img src="{{asset('public/storage/payment-methods/' . $image)}}"
                                             class="img-fluid cursor-pointer app_download_button"
                                             style="width:40px;height:40px;"/>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3 mb-2">
                    <div class="ltn__copyright-design clearfix text-center fs-15">
                        <p class="text-black mb-2">
                            <a href="{{route('PrivacyPolicyRoute')}}">
                                <span class="red-hover-affect cursor-pointer">Privacy & Cookies Policy</span>
                            </a> | <a href="{{route('TermsConditionsRoute')}}" class="mb-2">
                                <span class="red-hover-affect cursor-pointer">Terms & Conditions</span>
                            </a>
                        </p>
                        <div class="mb-2">
                            <a href="https://www.facebook.com/101electronics.pk/"><img
                                        src="{{asset('public/assets/images/footer/Facebook.png')}}" alt=""
                                        class="img-fluid" style="width: 24px; margin-right: 5px;"></a><a
                                    href="https://instagram.com/101electronics.pk?igshid=YmMyMTA2M2Y="><img
                                        src="{{asset('public/assets/images/footer/Instagram.png')}}" alt=""
                                        class="img-fluid" style="width: 24px; margin-right: 5px;"></a><a
                                    href="https://twitter.com/101electronicsP?t=Yxjq6E0ng16tlAp5eZ5Gkw&s=08"><img
                                        src="{{asset('public/assets/images/footer/Twitter.png')}}" alt=""
                                        class="img-fluid" style="width: 24px; margin-right: 5px;"></a><a
                                    href="https://youtube.com/channel/UChH8q2bdJJGDj1o9Mp47M-A"><img
                                        src="{{asset('public/assets/images/footer/Youtube.png')}}" alt=""
                                        class="img-fluid" style="width: 24px; margin-right: 5px;"></a><a
                                    href="https://pin.it/CqRuohG"><img
                                        src="{{asset('public/assets/images/footer/Pinterest.png')}}" alt=""
                                        class="img-fluid" style="width: 24px;"></a>
                        </div>
                        <p class="text-black">All Copyrights are reserved for 101 Electronics | <span
                                    class="current-year"></span>
                            {{--| Developed by--}}
                            {{--<a href="http://metasolutions.com.pk/" target="_blank"--}}
                               {{--class="text-custom-primary fw-600">Meta Solutions</a>--}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER AREA END -->