@extends('site.layouts.app')
@section('content')
    <!-- Fetch Sliders Data -->
    @php
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'home' )->where('screen', 'Desktop' )->orderBy('order_no', 'ASC')->get();
    @endphp
    <section class="mb-0 d-none d-lg-block" id="homePage">
        <div class="container-fluid">
            <div class="row ltn__no-gutter main-slider">
                {{-- Slide --}}
                @foreach($Sliders as $slider)
                    @if($slider->type == "image")
                        <div class="col-lg-12 px-0 slider-image">
                            <a href="{{$slider->link}}">
                                <img src="{{asset('public/storage/sliders/' . $slider->slide)}}" class="img-fluid"
                                     alt="Slider Img">
                                {{--<div class="col-lg-12"
                                     style="background: url('{{asset('public/storage/sliders/' . $slider->slide)}}') no-repeat center center; background-size: contain; padding-left: 0; padding-right: 0; "> --}}{{-- width: 100%; height: 270px; --}}{{--
                                    <div class="row">
                                        <div class="col-lg-12 d-flex align-items-center">
                                            <div class="mt-5 mb-5" style="padding-top: 270px;"></div>
                                        </div>
                                    </div>
                                </div>--}}
                            </a>
                        </div>
                    @elseif($slider->type == "video")
                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                            <video width="100%" height="360" autoplay controls muted>
                                <source src="{{asset('public/storage/sliders/' . $slider->slide)}}" type="video/mp4">
                                <source src="{{asset('public/storage/sliders/' . $slider->slide)}}" type="video/ogg">
                                Your browser does not support HTML video.
                            </video>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!--For Mobile-->
    @php
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'home')->where('screen', 'Mobile' )->orderBy('order_no', 'ASC')->get();
    @endphp
    <section class="mb-0 d-lg-none" id="homePage">
        <div class="container-fluid">
            <div class="row main-slider">
                {{-- Slide --}}
                @foreach($Sliders as $slider)
                    @if($slider->type == "image")
                        <a href="{{$slider->link}}">
                            <img src="{{asset('public/storage/sliders/' . $slider->slide)}}"/>
                        </a>
                    @elseif($slider->type == "video")
                        <div class="col-12" style="padding-left: 0px; padding-right: 0px;">
                            <video width="100%" height="360" autoplay controls muted>
                                <source src="{{asset('public/storage/sliders/' . $slider->slide)}}" type="video/mp4">
                                <source src="{{asset('public/storage/sliders/' . $slider->slide)}}" type="video/ogg">
                                Your browser does not support HTML video.
                            </video>
                        </div>
                    @endif

                @endforeach
            </div>
        </div>
    </section>
    {{--Slider Section--}}

    {{--Brands Section--}}
    <section class="mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 mt-3 mb-5 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        Imported Brands
                    </span>
                </div>

                @php
                    $ImportedBrands = Illuminate\Support\Facades\DB::table('brands')->where('deleted_at',null)->where('type',0)->orderBy('order_no', 'ASC')->get();
                @endphp

                @foreach($ImportedBrands as $brand)
                    <div class="col-6 col-md-3 mb-3 ">
                        <a href="{{ route('home.slug', ['slug1' => $brand->slug2]) }}"> {{-- route('CheckSlugRoute', ['slug' => $brand->slug]) --}}
                            <div class="brand-layout">
                                <div class="brand-layout-img">
                                    <img src="{{asset('public/storage/brands/' . $brand->image)}}"
                                         alt="Imported Brand Logo" class="img-fluid"/>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                <div class="col-12 col-md-12 mb-5 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        Chinese Brands
                    </span>
                </div>

                @php
                    $ChineseBrands = Illuminate\Support\Facades\DB::table('brands')->where('deleted_at',null)->where('type',1)->orderBy('order_no', 'ASC')->get();
                @endphp

                @foreach($ChineseBrands as $brand)
                    <div class="col-6 col-md-3 mb-3">
                        <a href="{{ route('home.slug', ['slug1' => $brand->slug2]) }}"> {{-- route('CheckSlugRoute', ['slug' => $brand->slug]) --}}
                            <div class="brand-layout">
                                <div class="brand-layout-img">
                                    <img src="{{asset('public/storage/brands/' . $brand->image)}}" alt="Chinese Brand"
                                         class="img-fluid"/>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{--Brands Section--}}

    {{--Promotion Section--}}
    @if(\App\Helpers\SiteHelper::CheckPromotionVisibility('Promotion'))
        <section class="mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12 mb-5 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        101 Promotions
                    </span>
                    </div>
                    @php
                        $PromotionsSliders = Illuminate\Support\Facades\DB::table('promotions')->where('deleted_at', null)->where('type', 'Slider')->orderBy('id', 'ASC')->get();
                        $Timer = Illuminate\Support\Facades\DB::table('promotions')->where('deleted_at', null)->where('type', 'Timer')->first();
                        $Banner = Illuminate\Support\Facades\DB::table('promotions')->where('deleted_at', null)->where('type', 'Banner')->limit(2)->get();
                    @endphp
                    {{-- Slider --}}
                    <div class="col-12 col-lg-6 pe-lg-0"> {{-- padding-right-lg --}}
                        <div class="main-slider promotion-slider">
                            {{-- Promotion Slider --}}
                            @foreach($PromotionsSliders as $promotion)
                                <div class="promotion-slide">
                                    <div class="carousel-img">
                                        <img src="{{asset('public/storage/promotions/' . $promotion->image)}}"
                                             alt="Promotion Image"
                                             class="img-fluid">
                                    </div>
                                    <div class="promotion-slider-overlay">
                                        <h2 class="">{{ $promotion->title }}</h2> {{-- promotion-slider-title fw-600 --}}
                                        <p class="">{{ $promotion->description }}</p> {{-- promotion-slider-description mb-2 --}}
                                        <div class="text-center">
                                            <a class="btn promotion-btn" href="{{ $promotion->link }}"
                                               target="_blank">
                                                Shop Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- Slider --}}

                    <div class="col-12 col-lg-6"> {{-- padding-left-lg --}}
                        <input type="hidden" id="end_date_time" name="end_date_time"
                               value="{{ $Timer->end_date_time }}">
                        <div class="row">
                            {{-- Timer Card --}}
                            <div class="col-12 mb-3">
                                <div class="card timer-card-main shadow-none border-0">
                                    <div class="row align-items-center timer-main p-3">
                                        <div class="col-7 col-md-6 col-lg-6 pr-1">
                                            <h2 class="text-white fw-600 bold">{{ $Timer->title }}</h2>
                                            <div class="d-flex align-items-center">
                                                <div class="card timer-counter-main">
                                                    <p class="" id="days">00</p> {{-- fs-3 text-dark counter --}}
                                                    <p class="">Days</p> {{-- fs-14 counter-text --}}
                                                </div>
                                                <div class="card timer-counter-main"> {{-- ml-2 --}}
                                                    <p class="" id="hours">00</p> {{-- fs-3 text-dark counter --}}
                                                    <p class="">Hr</p> {{-- m-0 fs-14 counter-text --}}
                                                </div>
                                                <div class="card timer-counter-main"> {{-- ml-2 --}}
                                                    <p class="" id="minutes">00</p> {{-- fs-3 text-dark counter --}}
                                                    <p class="">Min</p> {{-- m-0 fs-14 counter-text --}}
                                                </div>
                                                <div class="card timer-counter-main"> {{-- ml-2 --}}
                                                    <p class="" id="seconds">00</p> {{-- fs-3 text-dark counter --}}
                                                    <p class="">Sec</p> {{-- m-0 fs-14 counter-text --}}
                                                </div>
                                            </div>
                                            <div> {{-- class="mt-2" --}}
                                                <a class="btn text-white timer-btn" href="{{ $Timer->link }}"
                                                   target="_blank">
                                                    Buy Now
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-6 col-lg-6 pl-1">
                                            <div class="timer-image">
                                                <img src="{{ asset('public/storage/promotions') . '/' . $Timer->image }}"
                                                     alt="Timer Card Image" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Timer Card --}}

                            {{-- Custom Cards --}}
                            <div class="col-12">
                                <div class="row">
                                    {{-- Custom Card 1 --}}
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-3 mb-sm-0"> {{--  banner-padding-right --}}
                                        <div class="card custom-banner-card banner-card-bg-1 shadow-none border-0">
                                            <div class="row p-3"> {{-- card-body --}}
                                                <div class="col-8 col-lg-8 pr-1">
                                                    <h5 class="">{{ $Banner[0]->title }}</h5> {{-- text-white fw-600 mb-2 --}}
                                                    <p class=""> {{-- text-white --}}
                                                        {{ $Banner[0]->description }}
                                                    </p>
                                                    <a class="btn banner-btn" href="{{ $Banner[0]->link }}"
                                                       target="_blank">
                                                        View Details
                                                    </a>
                                                </div>
                                                <div class="col-4 col-lg-4 pl-1">
                                                    <div class="banner-image">
                                                        <img src="{{ asset('public/storage/promotions') . '/' . $Banner[0]->image }}"
                                                             class="img-fluid" alt="Promotion Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Custom Card 1 --}}

                                    {{-- Custom Card 2 --}}
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 ps-sm-0"> {{-- banner-padding-left --}}
                                        <div class="card custom-banner-card banner-card-bg-2 shadow-none border-0">
                                            <div class="row p-3"> {{-- card-body --}}
                                                <div class="col-8 col-lg-8 pr-1">
                                                    <h5 class="">{{ $Banner[1]->title }}</h5> {{-- text-white fw-600 mb-2 --}}
                                                    <p class=""> {{-- text-white --}}
                                                        {{ $Banner[1]->description }}
                                                    </p>
                                                    <a class="btn banner-btn" href="{{ $Banner[1]->link }}"
                                                       target="_blank">
                                                        View Details
                                                    </a>
                                                </div>
                                                <div class="col-4 col-lg-4 pl-1">
                                                    <div class="banner-image">
                                                        <img src="{{ asset('public/storage/promotions') . '/' . $Banner[1]->image }}"
                                                             class="img-fluid" alt="Promotion Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Custom Card 2 --}}
                                </div>
                            </div>
                            {{-- Custom Cards --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{--Promotion Section--}}

    {{--Shop by Category Section--}}
    <section class="mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 mb-5 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        Shop by Category
                    </span>
                </div>

                @php
                    $Categories = Illuminate\Support\Facades\DB::table('categories')->where('deleted_at', null)->orderBy('order_no', 'ASC')->get();
                @endphp
                <div class="col-md-12">
                    <div class="products-category-slider ltn__category-slider slick-arrow-1">
                        @foreach($Categories as $category)
                            <div class="col-4 col-md-2">
                                <a href="{{ route('home.slug', ['slug1' => $category->slug2]) }}"> {{-- route('CheckSlugRoute', ['slug' => $category->slug]) --}}
                                    <span class="product-category-circle">
                                        <span class="product-category-circle-img">
                                            <img src="{{asset('public/storage/categories/' . $category->icon)}}"
                                                 alt="Category Icon" class="img-fluid"/>
                                        </span>
                                    </span>
                                    <p class="mt-2 mb-0 text-black text-center fs-13 line-height-1-3">{{$category->title}}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--Shop by Category Section--}}

    {{--Pay Latter Section--}}
    @if(\App\Helpers\SiteHelper::CheckPromotionVisibility('Pay Latter'))
        <section class="mb-5">
            <div class="container">
                @php
                    $PayLatter = Illuminate\Support\Facades\DB::table('promotions')->where('deleted_at', null)->where('type', 'Pay Latter')->orderBy('id', 'ASC')->limit(4)->get();
                @endphp
                <div class="row">
                    @foreach($PayLatter as $value)
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card pay-latter-card shadow-none border-0">
                                <a href="{{ $value->link }}" target="_blank">
                                    <div class="pay-latter-image">
                                        <img src="{{asset('public/storage/promotions/' . $value->image)}}"
                                             class="img-fluid">
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    {{--Pay Latter Section--}}

    {{--Category With Products--}}
    @foreach($Categories as $i => $category)
        <?php
        $SubCategoryId = 0;
        $GetFirstSubCategory = \Illuminate\Support\Facades\DB::table('subcategories')
            ->where('category', '=', $category->id)
            ->where('deleted_at', '=', null)
            ->orderBy('order_no', 'ASC')
            ->get();
        if (count($GetFirstSubCategory) > 0) {
            $SubCategoryId = $GetFirstSubCategory[0]->id;
        }
        $CompareUrl = route('CompareRoute', ['slug' => $category->slug2]); /*  . '?sub=' . $SubCategoryId . '&subSub=&range=1_1000000&brands=' */
        ?>
        <section class="mb-5">
            <div class="container">
                <div class="row line-height-1-3 mb-2">
                    <div class="col-7 col-sm-8">
                        <h2 class="section-title text-custom-primary fs-15 mb-2">
                            {{$category->homepage_selling_tagline}} {{$category->title}}
                        </h2>
                    </div>
                    <div class="col-5 col-sm-4">
                        <a href="{{ route('home.slug', ['slug1' => $category->slug2]) }}">
                            <label for="" class="form-check-label text-custom-primary cursor-pointer fs-14 float-right">
                                See all deals <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </label>
                        </a> {{-- route('CheckSlugRoute', ['slug' => $category->slug]) --}}
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="compare{{$i}}" name="compare{{$i}}"
                                   class="form-check-input compareCheckBox mt-0 mr-2"
                                   onclick="window.location.href='{{$CompareUrl}}';" autocomplete='off'>
                            <label for="compare{{$i}}" class="form-check-label fs-15">Compare</label>
                        </div>
                    </div>
                    {{--Products--}}
                    <div class="col-12">
                        <div class="products-category-slider ltn__category-products-slider slick-arrow-1">
                            @php
                                $Products = Illuminate\Support\Facades\DB::table('products')
                                            ->where('category', $category->id)
                                            ->where('homepage_status', 1)
                                            ->where('deleted_at', null)
                                            ->orderBy('order_no', 'ASC')
                                            ->get();
                                $List = \App\Helpers\SiteHelper::GetUserList();
                                $index = $i;
                            @endphp
                            @foreach($Products as $index1 => $product)
                                {!! \App\Helpers\SiteHelper::GetProductTemplate($product, $index, $index1, $List) !!}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
    {{--Category With Products--}}
@endsection
