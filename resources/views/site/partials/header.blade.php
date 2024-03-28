<style media="screen">
    .ltn__main-menu li ul li {
        border-top: none;
    }

    .announcement-color {
        color: #ffffff;

    }

    .design:hover {
        border-bottom: 1px solid #CA2645;
    }

    .bg-custom-secondary {
        background-color: #C71836;
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

        .bg-custom-secondary {
            background-color: #C71836;
        }
    }
</style>

<?php
$GeneralSettings = \Illuminate\Support\Facades\DB::table('general_settings')->get();
$Logo = $GeneralSettings[0]->logo;
$WishList = \App\Helpers\SiteHelper::GetUserList();
$CartController = new \App\Http\Controllers\CartController();
$CartCount = $CartController->CartCount(request());
$Categories = Illuminate\Support\Facades\DB::table('categories')->where('deleted_at', null)->orderBy('order_no', 'ASC')->get();
?>

{{-- For Mobile --}}
<section class="bg-custom-secondary text-black fs-13 d-lg-none">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 py-1 line-height-1-3"> {{-- style="margin-bottom:-7px;" --}}
                <marquee scrollamount="3" onMouseOver="this.stop();" onMouseOut="this.start();">
                    <span class="text-center announcement-color"> {{-- style="text-align: center;" --}}
                        {{$GeneralSettings[0]->announcement}}
                    </span>
                </marquee>
            </div>
        </div>
    </div>
</section>
{{-- For Desktop --}}
<section class="bg-custom-secondary text-white fs-13 d-none d-lg-block">
    <div class="container-fluid py-1">
        <div class="row mx-2">
            <div class="col-lg-12">
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
{{-- Main Header --}}
<header class="ltn__header-area ltn__header-5 ltn__header-transparent--- gradient-color-4---">
    <div class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white">
        {{-- For Mobile --}}
        <div class="container-fluid d-lg-none">
            <div class="row mt-2">
                {{-- Logo --}}
                <div class="col col-4 col-md-3 pe-0">
                    {{--<div class="site-logo-wrap pl-2">
                        <div class="site-logo">
                            <a href="{{url('/')}}">
                                <img src="{{asset('public/storage/logo/' . $Logo)}}" alt="Logo"
                                     class="img-fluid"> --}}{{-- style="width: 120px; max-width: 120px;" --}}{{--
                            </a>
                        </div>
                    </div>--}}
                    <a href="{{url('/')}}">
                        <div class="header-logo-sm">
                            <img src="{{asset('public/storage/logo/' . $Logo)}}" alt="Logo"
                                 class="img-fluid"> {{-- style="width: 120px; max-width: 120px;" --}}
                        </div>
                    </a>
                </div>
                {{-- Links --}}
                <div class="col col-8 col-md-9 ps-0">
                    <div class="row ltn__no-gutter align-items-center justify-content-end fs-12">
                        <div class="col-2 col-md-1 me-1 me-sm-0 text-center">
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
                        <div class="col-2 col-md-1 me-1 me-sm-0 text-center">
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
                        <div class="col-2 col-md-1 me-1 me-sm-0 text-center">
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
                        <div class="col-2 col-md-1 line-height-1-3 text-center" id="mobile-menu-toggle-btn">
                            <div class="mobile-menu-toggle">
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
                {{-- Search Bar --}}
                <div class="col-12 mt-2">
                    <i class="fa fa-search absolute-search-icon mr-2 mt-0"></i>
                    <input type="text" class="form-control search-bar border-radium-5 mb-0"
                           placeholder="Search for products....."
                           id="search-bar-input-m"
                           onclick="ShowSearchSuggestionsM();"
                           onkeyup="ShowSearchSuggestionsM();"
                           style="box-shadow: 0 0 5px 0 rgb(0 0 0 / 50%);">
                    {{--Suggestion Box--}}
                    <div class="suggestions-m" style="display: none;" onclick="ShowSearchSuggestionsM();">
                        <ul class="container mb-0" role="listbox" id="search-results-m"></ul>
                    </div>
                    {{--Suggestion Box--}}
                </div>
                {{-- Marquee Slider --}}
                <div class="col-12 my-2">
                    <marquee class="text-custom-primary" scrollamount="4" onMouseOver="this.stop();"
                             onMouseOut="this.start();" id="header-marquee-sm">
                        <div class="d-flex align-items-center line-height-1-3 fs-10">
                            {{-- Item 1 --}}
                            <img src="{{asset('public/assets/images/header/camera.png')}}" alt="CAMERA"
                                 class="img-fluid" style="width: 20px;">
                            <div class="ms-2 me-3">
                                ShopLive 10AM - 10PM, video call an expert to help you shop &nbsp;
                            </div>
                            {{-- Item 2 --}}
                            <img src="{{asset('public/assets/images/header/van.png')}}" alt="VAN"
                                 class="img-fluid" style="width: 20px;">
                            <div class="ms-2 me-3">
                                Shipping charges will be confirmed by our representative on call at order confirmation.
                                For transactions over Rs. 100,000, we will require CNIC of the customer for consumer
                                safety. Due to currency devaluation,
                                price may change without any prior notice.
                            </div>
                            {{-- Item 3 --}}
                            {{--<img src="{{asset('public/assets/images/header/prize.png')}}" alt="VAN"
                                 class="img-fluid" style="width: 20px;">
                            <div class="ms-2 me-3">
                                1 Month free replacement Warranty (BOSCH)
                            </div>--}}
                            {{-- Item 4 --}}
                            {{--<img src="{{asset('public/assets/images/header/referral-code.png')}}" alt="VAN"
                                 class="img-fluid" style="width: 20px;">
                            <div class="ms-2 me-3">
                                Referral Code
                            </div>--}}
                        </div>
                    </marquee>
                </div>
            </div>
        </div>
        {{-- For Desktop --}}
        <div class="container-fluid d-none d-lg-block">
            <div class="row mx-2 mt-2">
                {{-- Logo --}}
                <div class="col col-lg-2">
                    <a href="{{url('/')}}">
                        <div class="header-logo-lg">
                            <img src="{{asset('public/storage/logo/' . $Logo)}}" alt="Logo"
                                 class="img-fluid">
                        </div>
                    </a>
                </div>

                {{-- Search & Links --}}
                <div class="col col-lg-10 header-menu-column">
                    <div class="header-menu">
                        <div class="row align-items-center">
                            {{-- Search --}}
                            <div class="col-6 pr-0">
                                <i class="fa fa-search absolute-search-icon"></i>
                                <input type="text" class="form-control search-bar border-radium-5 mb-0"
                                       placeholder="Search for products....."
                                       id="search-bar-input"
                                       onclick="ShowSearchSuggestions();"
                                       onkeyup="ShowSearchSuggestions();"
                                       style="box-shadow: 0 0 5px 0 rgb(0 0 0 / 50%);">
                                {{--Suggestion Box--}}
                                <div class="suggestions" style="display: none;" onclick="ShowSearchSuggestions();">
                                    <ul class="container mb-0" role="listbox" id="search-results"></ul>
                                </div>
                                {{--Suggestion Box--}}
                            </div>
                            {{-- Links --}}
                            <div class="col-6 pl-0 upper-menu">
                                <nav>
                                    <div class="ltn__main-menu">
                                        <ul class="float-end">
                                            <li class="menu-icon">
                                                <a href="javascript:void(0);"
                                                   onclick="AddToWishlist('Please login first to view your list.', '');">
                                                    <i class="fa fa-heart text-custom-primary"></i> <span
                                                            id="headerWishListCount"><?php if (sizeof($WishList) > 0) {
                                                            echo "<sup>" . sizeof($WishList) . "</sup>";
                                                        } ?></span> Wishlist
                                                </a>
                                            </li>
                                            <li class="menu-icon">
                                                <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                                                    <i class="fa fa-shopping-cart text-custom-primary"></i> <span
                                                            id="headerCartCount"><?php if ($CartCount > 0) {
                                                            echo "<sup>" . $CartCount . "</sup>";
                                                        } ?></span>
                                                    Cart
                                                </a>
                                            </li>
                                            <li class="menu-icon">
                                                <a href="{{route('StoresRoute')}}">
                                                    <i class="fa fa-map-marker-alt text-custom-primary"></i> Stores
                                                </a>
                                            </li>
                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                <li class="menu-icon">
                                                    <a href="{{route('home.account')}}">
                                                        <i class="fa fa-user text-custom-primary"></i>
                                                        <span>My Account</span>
                                                    </a>
                                                </li>
                                                <li class="menu-icon">
                                                    <a href="{{ route('user.logout') }}">
                                                        <i class="fas fa-sign-out-alt text-custom-primary"></i>
                                                        <span>Logout</span>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="menu-icon">
                                                    <a href="{{route('login')}}">
                                                        <i class="fa fa-user text-custom-primary"></i>
                                                        <span>Sign In</span>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Categories Links --}}
                <div class="col col-12 mt-2 header-menu-column">
                    <div class="header-menu">
                        <div class="row">
                            <div class="col-12 upper-menu">
                                <nav>
                                    <div class="__menu ltn__main-menu">
                                        <ul class="text-center">
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
                                                        <a href="{{ route('home.slug', ['slug1' => $category->slug2]) }}"
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
                                                                        <a href="{{ route('home.slug', ['slug1' => $category->slug, 'slug2' => $subCategory->slug2]) }}">{{$subCategory->title}} <?php if (sizeof($__SubSubCategories) > 0) {
                                                                                // echo '<i class="fas fa-angle-right"></i>';
                                                                            } ?>
                                                                        </a><i class="fa fa-angle-right float-right"
                                                                               aria-hidden="true"></i>
                                                                        @if(sizeof($__SubSubCategories) > 0)
                                                                            <ul>
                                                                                @foreach($__SubSubCategories as $subSubCategory)
                                                                                    <li>
                                                                                        <a href="{{ route('home.slug', ['slug1' => $category->slug, 'slug2' => $subCategory->slug, 'slug3' => $subSubCategory->slug2]) }}">{{$subSubCategory->title}}</a>
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
                                                        <a class="design"
                                                           href="{{ route('home.slug', ['slug1' => $category->slug2]) }}">{{$category->title}} <?php if (sizeof($__SubCategories) > 0) { /* route('CheckSlugRoute', ['slug' => $category->slug]) */
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
                                                                        <a href="{{ route('home.slug', ['slug1' => $category->slug, 'slug2' => $subCategory->slug2]) }}">{{$subCategory->title}} {{-- route('CheckSlugRoute', ['slug' => $subCategory->slug]) --}}
                                                                            <?php if (sizeof($__SubSubCategories) > 0) {
                                                                                // echo '<i class="fas fa-angle-right"></i>';
                                                                            } ?>
                                                                        </a><i class="fa fa-angle-right float-right"
                                                                               aria-hidden="true"></i>
                                                                        @if(sizeof($__SubSubCategories) > 0)
                                                                            <ul>
                                                                                @foreach($__SubSubCategories as $subSubCategory)
                                                                                    <li>
                                                                                        <a href="{{ route('home.slug', ['slug1' => $category->slug, 'slug2' => $subCategory->slug, 'slug3' => $subSubCategory->slug2]) }}">{{$subSubCategory->title}}</a> {{-- url('/'. $category->slug .'/'. $subCategory->slug .'/'. $subSubCategory->slug) --}}
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
                {{-- Marquee Slider --}}
                <div class="col-12 my-2">
                    <marquee class="text-custom-primary" scrollamount="4" onMouseOver="this.stop();"
                             onMouseOut="this.start();" id="header-marquee-lg">
                        <div class="d-flex align-items-center line-height-1-3 fs-13">
                            {{-- Item 1 --}}
                            <img src="{{asset('public/assets/images/header/camera.png')}}" alt="CAMERA"
                                 class="img-fluid" style="width: 20px;">
                            <div class="ms-2 me-4">
                                ShopLive 10AM - 10PM, video call an expert to help you shop &nbsp;
                            </div>
                            {{-- Item 2 --}}
                            <img src="{{asset('public/assets/images/header/van.png')}}" alt="VAN"
                                 class="img-fluid" style="width: 20px;">
                            <div class="ms-2 me-4">
                                Shipping charges will be confirmed by our representative on call at order confirmation.
                                For transactions over Rs. 100,000, we will require CNIC of the customer for consumer
                                safety. Due to currency devaluation,
                                price may change without any prior notice.
                            </div>
                            {{-- Item 3 --}}
                            {{--<img src="{{asset('public/assets/images/header/prize.png')}}" alt="VAN"
                                 class="img-fluid" style="width: 20px;">
                            <div class="ms-2 me-3">
                                1 Month free replacement Warranty (BOSCH)
                            </div>--}}
                            {{-- Item 4 --}}
                            {{--<img src="{{asset('public/assets/images/header/referral-code.png')}}" alt="VAN"
                                 class="img-fluid" style="width: 20px;">
                            <div class="ms-2 me-3">
                                Referral Code
                            </div>--}}
                        </div>
                    </marquee>
                </div>
                <div class="col ltn__header-options"></div>
            </div>
        </div>
    </div>
</header>

<!-- Utilize Mobile Menu Start -->
<div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">
        <div class="ltn__utilize-menu-head" style=" margin-top: -10px; margin-bottom:0;">
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
                        <span class="menu-expand"></span><a
                                href="{{ route('home.slug', ['slug1' => $category->slug2]) }}">{{$category->title}}</a>
                        @if(sizeof($__SubCategories) > 0)
                            <ul class="sub-menu" style="display: none;">
                                @foreach($__SubCategories as $subCategory)
                                    <?php
                                    $SubSubcategorySql = "SELECT * FROM sub_subcategories WHERE ((FIND_IN_SET(:subCategoryId, subcategory) > 0) AND category = :categoryId) AND ISNULL(deleted_at) ORDER BY order_no ASC ;";
                                    $__SubSubCategories = \Illuminate\Support\Facades\DB::select(DB::raw($SubSubcategorySql), array($subCategory->id, $category->id));
                                    ?>
                                    <li>
                                        <a href="{{ route('home.slug', ['slug1' => $category->slug, 'slug2' => $subCategory->slug2])  }}"><b>{{$subCategory->title}}</b></a>
                                    </li>
                                    @if(sizeof($__SubSubCategories) > 0)
                                        @foreach($__SubSubCategories as $subSubCategory)
                                            <li>
                                                <a href="{{ route('home.slug', ['slug1' => $category->slug, 'slug2' => $subCategory->slug, 'slug3' => $subSubCategory->slug2]) }}">{{$subSubCategory->title}}</a>
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
                                    <a href="{{ route('home.slug', ['slug1' => $category->slug2]) }}">
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
