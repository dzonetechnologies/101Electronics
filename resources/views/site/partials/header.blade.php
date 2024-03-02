<style media="screen">
    .ltn__main-menu li ul li {
        border-top: none;
    }
    .announcement-color {
        color: #ffffff;
       
    }
    .design{

        hover:border-bottom 1px solid #CA2645;

    }
    .bg-custom-secondary{
           background-color :  #C71836;
       }
     

    @media (min-width: 991px) {
        .mega-menu.column-4 > li, .mega-menu.column-5 > li, .mega-menu.column-6 > li, .mega-menu.column-7 > li, .mega-menu.column-8 > li, .mega-menu.column-9 > li, .mega-menu.column-10 > li, .mega-menu.column-11 > li, .mega-menu.column-12 > li {
            min-width: 14% !important;
        }

        .w-30 {
            width: 30% !important
        }

        .w-15 {
            width: 15% !important
        }

        .bottomBarSetting {
            background-color: #ffffff; 
            
        }
        .announcement-color {
            color: #ffffff;
        }
       .bg-custom-secondary{
           background-color :  #C71836;
       }
        
        
    }
</style>
<section class="bg-custom-secondary text-white fs-13 d-none d-md-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <span class="announcement-color">
                  {{$GeneralSettings[0]->announcement}}
                </span>
                
                <a href="{{route('B2BRoute')}}" class="float-end">B2B</a>
                <a href="{{route('CareRepairRoute')}}" class="mr-3 float-end">Care & Repair</a>
                <a href="{{route('clearanceSale')}}" class="mr-3 float-end">Clearance Sale</a>
                <a href="{{route('DiscountVoucherRoute')}}" class="mr-3 float-end">Discount Vouchers</a>
                <a href="{{route('AboutUsRoute')}}" class="mr-3 float-end">About Us</a>
              
            </div>
        </div>
    </div>
</section>
<!--For Mobile-->
<section class="bg-custom-secondary text-black fs-13 d-md-none">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12" style="margin-bottom:-7px;">
                <marquee scrollamount="3" onMouseOver="this.stop();" onMouseOut="this.start();">
                    <span style="text-align: center;" class="announcement-color">
                    {{$GeneralSettings[0]->announcement}}
                    </span>
                </marquee>
            </div>
        </div>
    </div>
</section>

<header class="ltn__header-area ltn__header-5 ltn__header-transparent--- gradient-color-4---">
    <div class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white">
        <div class="container-fluid">
            {{--Desktop Header--}}
            <?php
            $GeneralSettings = \Illuminate\Support\Facades\DB::table('general_settings')->get();
            $Logo = $GeneralSettings[0]->logo;
            $WishList = \App\Helpers\SiteHelper::GetUserList();
            $CartController = new \App\Http\Controllers\CartController();
            $CartCount = $CartController->CartCount(request());
            ?>
            <div class="row mb-2 d-none d-md-flex">
                <div class="col col-md-2">
                    <div class="site-logo-wrap">
                        <div class="site-logo">
                            <a href="{{route('HomeRoute')}}">
                                <img src="{{asset('public/storage/logo/' . $Logo)}}"
                                     alt="Logo" style="width: 172px; max-width: 172px;"></a>
                        </div>
                    </div>
                </div>
                <div class="col col-md-10 header-menu-column">
                    <div class="header-menu">
                        <div class="row">
                            <div class="col-6 pr-0">
                                <i class="fa fa-search absolute-search-icon"></i>
                                <input type="text" class="form-control search-bar border-radium-5 mb-0"
                                       placeholder="Search for products....."
                                       id="search-bar-input"
                                       onclick="ShowSearchSuggestions();"
                                       onkeyup="ShowSearchSuggestions();"
                                       style="box-shadow: 0 0 5px 0 rgb(0 0 0 / 50%);"/>

                                {{--Suggestion Box--}}
                                <div class="suggestions" style="display: none;" onclick="ShowSearchSuggestions();">
                                    <ul class="container mb-0" role="listbox" id="search-results">

                                    </ul>
                                </div>
                                {{--Suggestion Box--}}
                            </div>
                            <div class="col-6 pl-0 upper-menu">
                                <nav>
                                    <div class="ltn__main-menu">
                                        <ul class="float-end">
                                            <li class="menu-icon"><a href="javascript:void(0);"
                                                                     onclick="AddToWishlist('Please login first to view your list.', '');"><i
                                                            class="fa fa-heart text-custom-primary"></i> <span
                                                            id="headerWishListCount"><?php if (sizeof($WishList) > 0) {
                                                            echo "<sup>" . sizeof($WishList) . "</sup>";
                                                        } ?></span> Wishlist</a>
                                            </li>
                                            <li class="menu-icon"><a href="#ltn__utilize-cart-menu"
                                                                     class="ltn__utilize-toggle"><i
                                                            class="fa fa-shopping-cart text-custom-primary"></i> <span
                                                            id="headerCartCount"><?php if ($CartCount > 0) {
                                                            echo "<sup>" . $CartCount . "</sup>";
                                                        } ?></span>
                                                    Cart</a></li>
                                            <li class="menu-icon"><a href="{{route('StoresRoute')}}"><i
                                                            class="fa fa-map-marker-alt text-custom-primary"></i> Stores</a>
                                            </li>
                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                <li class="menu-icon"><a href="{{route('home.account')}}"><i
                                                                class="fa fa-user text-custom-primary"></i>
                                                        <span>My Account</span></a></li>
                                                <li class="menu-icon"><a><i
                                                                class="fas fa-sign-out-alt  text-custom-primary"></i><a
                                                                href="javascript:void(0);"
                                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span>Logout</span>

                                                            <form id="logout-form" action="{{ route('logout') }}"
                                                                  method="POST"
                                                                  class="d-none">
                                                                @csrf
                                                            </form>
                                                        </a>
                                                </li>
                                            @else
                                                <li class="menu-icon"><a href="{{route('login')}}"><i
                                                                class="fa fa-user text-custom-primary"></i>
                                                        <span>Sign In</span></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col ltn__header-options"></div>
            </div>
        </div>

        @php
            $Categories = Illuminate\Support\Facades\DB::table('categories')->where('deleted_at', null)->orderBy('order_no', 'ASC')->get();
        @endphp
        <div class="container">
            <div class="row d-none d-md-flex mb-2">
                <div class="col col-md-12 header-menu-column">
                    <div class="header-menu">
                        <div class="row">
                            <div class="col-12 upper-menu">
                                <nav>
                                    <div class="__menu ltn__main-menu">
                                        <ul class="text-center" >
                                            @foreach($Categories as $category)
                                                <?php
                                                $__SubCategories = \Illuminate\Support\Facades\DB::table('subcategories')
                                                    ->where('category', '=', $category->id)
                                                    ->where('deleted_at', '=', null)
                                                    ->orderBy('order_no', 'ASC')
                                                    ->get();
                                                ?>
                                                @if($category->title == "IOT Devices")
                                                    <li class="menu-icon MenuCategoryLink ">
                                                        <a href="{{route('CheckSlugRoute', ['slug' => $category->slug])}}"
                                                           class="text-custom-primary design">{{$category->title}} <?php if (sizeof($__SubCategories) > 0) {
                                                            } ?>
                                                        </a>
                                                        @if(sizeof($__SubCategories) > 0)
                                                            <ul>
                                                                @foreach($__SubCategories as $subCategory)
                                                                    <?php
                                                                    $SubSubcategorySql = "SELECT * FROM sub_subcategories WHERE ((FIND_IN_SET(:subCategoryId, subcategory) > 0) AND category = :categoryId) AND ISNULL(deleted_at) ORDER BY order_no ASC;";
                                                                    $__SubSubCategories = \Illuminate\Support\Facades\DB::select(DB::raw($SubSubcategorySql), array($subCategory->id, $category->id));
                                                                    ?>
                                                                    <li>
                                                                        <a href="{{route('CheckSlugRoute', ['slug' => $subCategory->slug])}}">{{$subCategory->title}} <?php if (sizeof($__SubSubCategories) > 0) {
                                                                                // echo '<i class="fas fa-angle-right"></i>';
                                                                            } ?>
                                                                        </a><i class="fa fa-angle-right float-right" aria-hidden="true"></i>
                                                                        @if(sizeof($__SubSubCategories) > 0)
                                                                            <ul>
                                                                                @foreach($__SubSubCategories as $subSubCategory)
                                                                                    <li>
                                                                                        <a href="{{url('/'. $category->slug .'/'. $subCategory->slug .'/'. $subSubCategory->slug)}}">{{$subSubCategory->title}}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @else
                                                    <li class="menu-icon MenuCategoryLink ">
                                                        <a class="design" href="{{route('CheckSlugRoute', ['slug' => $category->slug])}}">{{$category->title}} <?php if (sizeof($__SubCategories) > 0) {
                                                          //
                                                        } ?>
                                                        </a>
                                                        @if(sizeof($__SubCategories) > 0)
                                                            <ul>
                                                                @foreach($__SubCategories as $subCategory)
                                                                    <?php
                                                                    $SubSubcategorySql = "SELECT * FROM sub_subcategories WHERE ((FIND_IN_SET(:subCategoryId, subcategory) > 0) AND category = :categoryId) AND ISNULL(deleted_at) ORDER BY order_no ASC;";
                                                                    $__SubSubCategories = \Illuminate\Support\Facades\DB::select(DB::raw($SubSubcategorySql), array($subCategory->id, $category->id));
                                                                    ?>
                                                                    <li>
                                                                        <a href="{{route('CheckSlugRoute', ['slug' => $subCategory->slug])}}">{{$subCategory->title}}
                                                                            <?php if (sizeof($__SubSubCategories) > 0) {
                                                                                // echo '<i class="fas fa-angle-right"></i>';
                                                                            } ?>
                                                                        </a><i class="fa fa-angle-right float-right" aria-hidden="true"></i>
                                                                        @if(sizeof($__SubSubCategories) > 0)
                                                                            <ul>
                                                                                @foreach($__SubSubCategories as $subSubCategory)
                                                                                    <li>
                                                                                        <a href="{{url('/'. $category->slug .'/'. $subCategory->slug .'/'. $subSubCategory->slug)}}">{{$subSubCategory->title}}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col ltn__header-options"></div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row d-none d-md-block pt-2 pb-3 bottomBarSetting">
                <marquee scrollamount="5" onMouseOver="this.stop();" onMouseOut="this.start();">
                    <div class="col-md-12 d-flex text-custom-primary">
                        <div class="w-30 d-flex align-items-center">
                            <img src="{{asset('public/assets/images/header/camera.png')}}" alt="CAMERA"
                                 class="img-fluid"
                                 style="width: 32px; margin-right: 10px;"/>
                            <div style="line-height: 1.3; font-size: 11px;" class="w-75 text-start">
                                ShopLive 10AM - 10PM, video call an expert to help you shop
                            </div>
                        </div>

                        <div class="w-30 d-flex align-items-center">
                            <img src="{{asset('public/assets/images/header/van.png')}}" alt="VAN" class="img-fluid"
                                 style="width: 32px; margin-right: 10px;"/>
                            <div style="line-height: 1.3; font-size: 11px;" class="w-75 text-start">
                                Shipping charges will be confirmed by our representative on call at order confirmation. For transactions over Rs. 100,000, 
                                we will require CNIC of the customer for consumer safety. Due to currency devaluation, price may change without any prior notice.
                            </div>
                        </div>

                     <!--   <div class="w-25 d-flex align-items-center">
                            <img src="{{asset('public/assets/images/header/Try It (1).png')}}" alt="PRIZE" class="img-fluid"
                                 style="width: 24px; margin-right: 10px;"/>
                            <div style="line-height: 1.3; font-size: 11px;" class="w-75 text-start">
                                 1 Month free replacement Warranty (BOSCH) 
                            </div>
                        </div>

                        <div class="w-15 d-flex align-items-center">
                            <img src="{{asset('public/assets/images/header/referral-code.png')}}" alt="referral-code"
                                 class="img-fluid" style="width: 32px; margin-right: 10px;"/>
                            <div style="line-height: 1.3; font-size: 11px;" class="w-75 text-start">
                                OReferral Code
                            </div> 
                        </div> -->
                    </div>
                </marquee>
                <div class="col ltn__header-options"></div>
            </div>
            {{--Desktop Header--}}

            {{--Mobile Header--}}
            <div class="row ltn__no-gutter d-flex d-md-none" > {{--style="margin-top: -28px;"--}}
                <div class="col-4">
                    <div class="site-logo-wrap pl-2">
                        <div class="site-logo">
                            <a href="{{url('/')}}">
                                <img src="{{asset('public/storage/logo/' . $Logo)}}" alt="Logo"
                                     style="width: 120px; max-width: 120px;">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-8"> {{-- ltn__header-options ltn__header-options-2 mb-sm-20--}}
                <!-- Mobile Menu Button -->
                    <div class="container-fluid">
                        <div class="row ltn__no-gutter" style="font-size:10px;">
                            <div class="col-4"></div>
                            <div class="col-2 text-center">
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <a href="{{route('home.account')}}">
                                        <i class="fa fa-user text-custom-primary"></i>
                                        <br>
                                        <span>Account</span>
                                    </a>
                                @else
                                    <a href="{{route('login')}}">
                                        <i class="fa fa-user text-custom-primary"></i>
                                        <br>
                                        <span>Sign In</span>
                                    </a>
                                @endif

                            </div>
                            <div class="col-2 text-center">
                                <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                                    <i class="fa fa-shopping-cart text-custom-primary"></i> <span
                                            id="headerCartCountM"><?php if ($CartCount > 0) {
                                            echo "<sup>" . $CartCount . "</sup>";
                                        } ?>
                                    </span>
                                    <br>
                                    <span>Cart</span>
                                </a>
                            </div>
                            <div class="col-2 text-center">
                                <a href="javascript:void(0);"
                                   onclick="AddToWishlist('Please login first to view your list.', '');"><i
                                            class="fa fa-heart text-custom-primary"></i> <span
                                            id="headerWishListCountM"><?php if (sizeof($WishList) > 0) {
                                            echo "<sup>" . sizeof($WishList) . "</sup>";
                                        } ?></span>
                                    <br>
                                    <span>Wishlist</span>
                                </a>
                            </div>
                            <div class="col-2 text-center">
                                <div class="mobile-menu-toggle d-xl-none">
                                    <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
                                        <svg viewBox="0 0 800 600">
                                            <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                                  id="top"></path>
                                            <path d="M300,320 L540,320" id="middle"></path>
                                            <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                                  id="bottom"
                                                  transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="col-12 pl-2 pr-2"> {{--style="margin-bottom:12px;margin-top:-30px;padding-left:15px;padding-right:26px;"--}}
                    <i class="fa fa-search absolute-search-icon mr-2 mt-0"></i>
                    <input type="text" class="form-control search-bar border-radium-5 mb-0"
                           placeholder="Search for products....."
                           id="search-bar-input-m"
                           onclick="ShowSearchSuggestionsM();"
                           onkeyup="ShowSearchSuggestionsM();"
                           style="box-shadow: 0 0 5px 0 rgb(0 0 0 / 50%);" />
                    {{--Suggestion Box--}}
                    <div class="suggestions-m" style="display: none;" onclick="ShowSearchSuggestionsM();">
                        <ul class="container mb-0" role="listbox" id="search-results-m">

                        </ul>
                    </div>
                    {{--Suggestion Box--}}
                </div>

                <marquee class="mt-1 mb-1" scrollamount="4" onMouseOver="this.stop();" onMouseOut="this.start();">
                    <div class="col-12 d-flex text-custom-primary">
                        <div class="w-30 d-flex align-items-center">
                            <img src="{{asset('public/assets/images/header/camera.png')}}" alt="CAMERA"
                                 class="img-fluid"
                                 style="width: 20px; margin-right:10px; "/>
                            <div style="line-height: 1.1; font-size: 9px; margin-right: 35px;" class="w-75 text-start">
                                ShopLive 10AM - 10PM, video call an expert to help you shop &nbsp;
                            </div>
                        </div>
                        <div class="w-30 d-flex align-items-center">
                            <img src="{{asset('public/assets/images/header/van.png')}}" alt="VAN" class="img-fluid"
                                 style="width: 20px; margin-right:10px; "/>
                            <div style="line-height: 1.3; font-size: 9px;  margin-right:35px;" class="w-75 ">
                                Shipping charges will be confirmed by our representative on call at order confirmation. For transactions over Rs. 100,000, 
                                we will require CNIC of the customer for consumer safety. Due to currency devaluation, price may change without any prior notice.
                            </div>
                        </div>
                      <!--  <div class="w-30 d-flex align-items-center">
                            <img src="{{asset('public/assets/images/header/prize.png')}}" alt="PRIZE" class="img-fluid"
                                 style="width: 20px; margin-right: 10px; "/>
                            <div style="line-height: 1.3; font-size: 9px;margin-right:35px;" class="w-75 ">
                                1 Month free replacement Warranty (BOSCH)
                            </div>
                        </div>
                        <div class="w-30 d-flex align-items-center">
                            <img src="{{asset('public/assets/images/header/referral-code.png')}}" alt="referral-code"
                                 class="img-fluid" style="width: 20px; margin-right: 10px;"/>
                            <div style="line-height: 1.3; font-size: 9px; margin-right:35px;" class="w-75 text-start">
                                Referral Code
                            </div>
                        </div> -->
                    </div>
                </marquee>
            </div>

            {{--Mobile Header--}}
        </div>
    </div>
</header>
<!-- HEADER AREA END -->

<!-- Utilize Mobile Menu Start -->
<div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">
        <div class="ltn__utilize-menu-head" style=" margin-top: -10px;margin-bottom:0px;">
            <div class="site-logo">
                <a href="{{url('/')}}"><img
                            src="{{asset('public/storage/logo/' . $Logo)}}" alt="Logo"
                            style="width: 130px; max-width: 130px;margin-top:10px;"></a>
            </div>
            <button class="ltn__utilize-close">×</button>
        </div>
        <div class="ltn__utilize-menu ">
            <ul>
                @php
                    $Categories = Illuminate\Support\Facades\DB::table('categories')->where('deleted_at', null)->orderBy('order_no', 'ASC')->get();
                @endphp

                @foreach($Categories as $category)
                    <?php
                    $__SubCategories = \Illuminate\Support\Facades\DB::table('subcategories')
                        ->where('category', '=', $category->id)
                        ->where('deleted_at', '=', null)
                        ->orderBy('order_no', 'ASC')
                        ->get();
                    ?>
                    <li>
                        <span class="menu-expand"></span><a href="{{route('CheckSlugRoute', ['slug' => $category->slug])}}">{{$category->title}}</a>
                        @if(sizeof($__SubCategories) > 0)
                            <ul class="sub-menu" style="display: none;">
                                @foreach($__SubCategories as $subCategory)
                                    <?php
                                    $SubSubcategorySql = "SELECT * FROM sub_subcategories WHERE ((FIND_IN_SET(:subCategoryId, subcategory) > 0) AND category = :categoryId) AND ISNULL(deleted_at) ORDER BY order_no ASC ;";
                                    $__SubSubCategories = \Illuminate\Support\Facades\DB::select(DB::raw($SubSubcategorySql), array($subCategory->id, $category->id));
                                    ?>
                                    <li>
                                        <a href="{{route('CheckSlugRoute', ['slug' => $subCategory->slug])}}"><b>{{$subCategory->title}}</b></a>
                                    </li>
                                    @if(sizeof($__SubSubCategories) > 0)
                                        @foreach($__SubSubCategories as $subSubCategory)
                                            <li>
                                                <a href="{{url('/'. $category->slug .'/'. $subCategory->slug .'/'. $subSubCategory->slug)}}">{{$subSubCategory->title}}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                     <li class="menu-icon">
                    <a href="{{route('B2BRoute')}}">B2b</a>
                </li>

                <li class="menu-icon">
                    <a href="{{route('clearanceSale')}}">Clearance Sale</a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::check())
                    <li class="menu-icon"><a style="font-size:13px;" class="mob_btn text-black"
                                             href="javascript:void(0);"
                                             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            Logout
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- Utilize Mobile Menu End -->

<!-- Utilize Cart Menu Start -->
<div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">
        <div class="ltn__utilize-menu-head">
            <span class="ltn__utilize-menu-title fs-x-large text-black">Cart</span>
            <button class="ltn__utilize-close">×</button>
        </div>

        @php
            $CartController = new \App\Http\Controllers\CartController();
            $CartCount = $CartController->CartCount(request());
            $CartItems = $CartController->GetCartItems(request());
            $CartSubTotal = 0;
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

        <div id="cartSideModal">
            @if($CartCount == 0)
                <div class="row">
                    <div class="col-md-12 text-dark mb-1" style="font-size:18px;text-align:center;">
                        <h3 style="color:#C71738;">Your cart is currently empty.</h3>
                    </div>
                    <div class="col-md-12 text-center text-dark mb-4" style="font-size: 18px;">
                        Continue shopping
                    </div>

                    @php
                        $Categories = Illuminate\Support\Facades\DB::table('categories')->where('deleted_at', null)->orderBy('order_no', 'ASC')->get();
                    @endphp
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($Categories as $category)
                                <div class="col-md-6 mb-4">
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
                </div>
            @else
                <div class="mini-cart-product-area ltn__scrollbar">
                    @foreach($CartItems as $index => $cartItem)
                        <div class="mini-cart-item clearfix">
                            <div class="mini-cart-img">
                                <a href="javascript:void(0);"><img
                                            src="{{asset('public/storage/products') . '/' . $cartItem->primary_img}}"
                                            alt="Image"></a>
                                <span class="mini-cart-item-delete" onclick="RemoveFromCart('{{$index}}');"><i
                                            class="icon-cancel"></i></span>
                            </div>
                            <div class="mini-cart-info">
                                <h6><a href="javascript:void(0);">{{$cartItem->name}}</a></h6>
                                <span class="mini-cart-quantity">{{$cartItem->quantity}} x {{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($cartItem->total_price, \App\Helpers\SiteHelper::$Decimals)}}</span>
                            </div>
                        </div>
                        @php
                            $CartSubTotal += floatval($cartItem->total_price) * floatval($cartItem->quantity);
                            $TotalQuantity += floatval($cartItem->quantity);
                        @endphp
                    @endforeach
                    @php
                        if($TotalQuantity >= 5) {
                            $B2BDiscount = round(($CartSubTotal * $B2BDiscountPercent) / 100, 2);
                        }
                        $CartSubTotal -= $B2BDiscount;
                    @endphp
                </div>
                <div class="mini-cart-footer">
                    <div class="mini-cart-sub-total">
                        <h5>Subtotal: <span
                                    class="text-custom-primary">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($CartSubTotal, \App\Helpers\SiteHelper::$Decimals)}}</span>
                        </h5>
                    </div>
                    <div class="btn-wrapper d-none d-md-block">
                        <a style="margin-left: 30px;" href="{{route('CartRoute')}}"
                           class="theme-btn-2 btn btn-effect-2">View Cart</a>&nbsp;&nbsp;
                        <a href="{{route('CheckoutRoute')}}" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                    </div>
                    <!--Mobile cart buttons-->
                    <div class="btn-wrapper d-md-none">
                        <a style="font-size:9px;" href="{{route('CartRoute')}}" class="theme-btn-2 btn btn-effect-2">View
                            Cart</a>
                        <a style="font-size:9px;" href="{{route('CheckoutRoute')}}"
                           class="theme-btn-2 btn btn-effect-2">Checkout</a>
                    </div>
                    <p>Shop with trust!</p>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Utilize Cart Menu End -->

<div class="ltn__utilize-overlay"></div>
