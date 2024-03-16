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
                        <a href="{{route('CheckSlugRoute', ['slug' => $brand->slug])}}">
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
                        <a href="{{route('CheckSlugRoute', ['slug' => $brand->slug])}}">
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
                                <a href="{{route('CheckSlugRoute', ['slug' => $category->slug])}}">
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


    {{--Promotion Section--}}
    <section class="mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 mb-5 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        Promotions
                    </span>
                </div>

                @php
                    $PromotionsSliders = Illuminate\Support\Facades\DB::table('promotions')->where('deleted_at', null)->where('type', 'Slider')->orderBy('id', 'ASC')->get();
                    $Timer = Illuminate\Support\Facades\DB::table('promotions')->where('deleted_at', null)->where('type', 'Timer')->first();
                    $Banner = Illuminate\Support\Facades\DB::table('promotions')->where('deleted_at', null)->where('type', 'Banner')->limit(2)->get();
                @endphp
                <style>
                    .timer-card {
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: cover;
                        height: 280px;
                        width: auto;
                        border-radius: 10px;
                    }

                    .banner-card-1 {
                        height: 155px;
                        width: auto;
                        border-radius: 10px;
                        background-color: #00B8F5;
                    }

                    .banner-card-2 {
                        height: 155px;
                        width: auto;
                        border-radius: 10px;
                        background-color: #FABB30;
                    }

                    .banner-btn {
                        background-color: white;
                        border-radius: 5px;
                        padding: 4px 10px;
                        font-size: 12px;
                    }

                    .timer {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    .timer-div {
                        height: 63px;
                        width: 200px !important;
                        border-radius: 10px;
                        background-color: #f0f0f0;
                    }

                    .timer p {
                        margin: 0;
                        font-size: 0.8rem;
                    }

                    .counter {
                        margin-top: -5px !important;
                    }

                    .counter-text {
                        margin-top: -10px !important;
                    }

                    .timer-btn {
                        border-radius: 5px;
                    }
                     .carousel-img {
                         height: 450px;
                         object-fit: cover;
                         border-radius: 10px;
                     }
                </style>
                <div class="col-md-6">
                            <div class="main-slider">
                                {{-- Slide --}}
                                @foreach($PromotionsSliders as $Promotion)
                                        <a href="{{$Promotion->link}}">
                                            <img src="{{asset('public/storage/promotions/' . $Promotion->image)}}" class="carousel-img">
                                        </a>
                                @endforeach
                            </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="card timer-card shadow-none border-0"
                                 style=" background-image: url({{ asset('public/storage/promotions') . '/' . $Timer->image }})">
                                <div class="card-body row d-flex align-items-center">
                                    <div class="col-12 col-lg-6 text-start">
                                        <h2 class="text-white fw-600 mb-3">{{ $Timer->title }}</h2>
                                        <div class="timer mt-3">
                                            <div class="timer-div text-center">
                                                <p class="fs-2 text-dark counter" id="days">00</p>
                                                <p class="m-0 counter-text">Days</p>
                                            </div>
                                            <div class="timer-div text-center ml-3">
                                                <p class="fs-2 text-dark counter" id="hours">00</p>
                                                <p class="m-0 counter-text">Hr</p>
                                            </div>
                                            <div class="timer-div text-center ml-3">
                                                <p class="fs-2 text-dark counter" id="minutes">00</p>
                                                <p class="m-0 counter-text">Min</p>
                                            </div>
                                            <div class="timer-div text-center ml-3">
                                                <p class="fs-2 text-dark counter" id="seconds">00</p>
                                                <p class="m-0 counter-text">Sc</p>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary timer-btn mt-4"
                                                onclick="window.location.href='{{ $Timer->link }}';">Buy Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Set the end date and time (YYYY-MM-DD HH:MM:SS format)
                        const endDate = '{{ $Timer->end_date_time }}';

                        function countdown() {
                            const endDateTime = new Date(endDate).getTime();
                            const now = new Date().getTime();
                            const distance = endDateTime - now;

                            if (distance < 0) {
                                clearInterval(timerInterval);
                                document.getElementById('days').innerHTML = '00';
                                document.getElementById('hours').innerHTML = '00';
                                document.getElementById('minutes').innerHTML = '00';
                                document.getElementById('seconds').innerHTML = '00';
                                return;
                            }

                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            document.getElementById('days').innerHTML = days.toString().padStart(2, '0');
                            document.getElementById('hours').innerHTML = hours.toString().padStart(2, '0');
                            document.getElementById('minutes').innerHTML = minutes.toString().padStart(2, '0');
                            document.getElementById('seconds').innerHTML = seconds.toString().padStart(2, '0');
                        }

                        // Update the countdown every second
                        const timerInterval = setInterval(countdown, 1000);

                        // Initial call to display the timer immediately
                        countdown();
                    </script>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card banner-card-1 shadow-none border-0">
                                <div class="card-body row d-flex justify-content-center">
                                    <div class="col-12 col-lg-8">
                                        <h5 class="text-white fw-600 mb-2">{{ $Banner[0]->title }}</h5>
                                        <p class="text-white fs-13 mb-2 lh-sm">
                                            {{ $Banner[0]->description }}
                                        </p>
                                        <button class="banner-btn"
                                                onclick="window.location.href='{{ $Banner[0]->link }}';">View Details
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <img src="{{ asset('public/storage/promotions') . '/' . $Banner[0]->image }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card banner-card-2 shadow-none border-0">
                                <div class="card-body row d-flex">
                                    <div class="col-12 col-lg-8">
                                        <h5 class="text-white fw-600 mb-2">{{ $Banner[1]->title }}</h5>
                                        <p class="text-white fs-13 mb-2 lh-sm">
                                            {{ $Banner[1]->description }}
                                        </p>
                                        <button class="banner-btn"
                                                onclick="window.location.href='{{ $Banner[1]->link }}';">View Details
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <img src="{{ asset('public/storage/promotions') . '/' . $Banner[1]->image }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--Promotion Section--}}

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
        $CompareUrl = route('CompareRoute', ['slug' => $category->slug]) . '?sub=' . $SubCategoryId . '&subSub=&range=1_1000000&brands=';
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
                        <a href="{{route('CheckSlugRoute', ['slug' => $category->slug]) }}">
                            <label for="" class="form-check-label text-custom-primary cursor-pointer fs-14 float-right">
                                See all deals <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </label>
                        </a>
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
