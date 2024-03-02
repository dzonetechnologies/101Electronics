@extends('site.layouts.app')
@section('content')
    <!-- Fetch Sliders Data -->

    @php
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'home' )->where('screen', 'Desktop' )->orderBy('order_no', 'ASC')->get();
    @endphp
    <section class="mb-0 d-none d-md-block" id="homePage">
        <div class="container-fluid">
            <div class="row main-slider">
                {{-- Slide --}}
                @foreach($Sliders as $slider)
                    @if($slider->type == "image")
                        <a href="{{$slider->link}}">
                            <div class="col-md-12"
                                 style="background: url('{{asset('public/storage/sliders/' . $slider->slide)}}') no-repeat center center; background-size: cover;padding-left: 0px; padding-right: 0px;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <div class="mt-5 mb-5" style="padding-top: 270px;">

                                            </div>
                                        </div>
                                        <div class="col-md-8"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
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
    <section class="mb-0 d-md-none" id="homePage">
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
                    <div class="row products-category-slider ltn__category-slider slick-arrow-1">
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

    {{--Category With Products--}}
    @foreach($Categories as $i => $category)
        <section class="mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="row ltn__no-gutter">
                            <div class="col-9 col-md-10">
                                <h2 class="section-title text-custom-primary mb-0 fs-large w-100 pl-2 pl-md-0">
                                    {{$category->homepage_selling_tagline}} {{$category->title}}
                                    <?php
                                    $SubCategoryId = 0;
                                    $GetFirstSubCategory = DB::table('subcategories')
                                        ->where('category', '=', $category->id)
                                        ->where('deleted_at', '=', null)
                                        ->orderBy('order_no', 'ASC')
                                        ->get();
                                    if (count($GetFirstSubCategory) > 0) {
                                        $SubCategoryId = $GetFirstSubCategory[0]->id;
                                    }
                                    $CompareUrl = route('CompareRoute', ['slug' => $category->slug]) . '?sub='. $SubCategoryId .'&subSub=&range=1_1000000&brands=';
                                    ?>
                                    <input type="checkbox" id="compare{{$i}}" name="compare{{$i}}"
                                           class="form-check-input compareCheckBox"
                                           onclick="window.location.href='{{$CompareUrl}}';" autocomplete='off'>
                                    <label for="compare{{$i}}" class="form-check-label small pt-1">Compare</label>
                                </h2>
                            </div>
                            <div class="col-3 col-md-2">
                                <a href="{{route('CheckSlugRoute', ['slug' => $category->slug]) }}">
                                    <label for=""
                                           class="form-check-label text-custom-primary cursor-pointer small pt-1 float-right pr-2 pr-md-0">See
                                        all deals <i class="fa fa-arrow-right" aria-hidden="true"></i></label>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row products-category-slider ltn__category-products-slider slick-arrow-1">
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
                        <!-- Product - Start -->
                        @include('site.partials.product-template')
                        <!-- Product - End -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    {{--Category With Products--}}
    

@endsection

