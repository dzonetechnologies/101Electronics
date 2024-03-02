@extends('site.layouts.app')
@section('content')
    <!-- Fetch Sliders Data -->
    @php
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'brands')->where('screen', 'Desktop' )->where('brand', $Brand[0]->id)->orderBy('order_no', 'ASC')->get();
    @endphp
    <section class="mb-0 d-none d-md-block">
        <div class="container-fluid">
            <div class="row main-slider">
                {{-- Slide --}}
                @foreach($Sliders as $slider)
                    @if($slider->type == "image")
                        <a href="{{$slider->link}}">
                            <div class="col-md-12 p-0">
                                <img src="{{asset('public/storage/sliders/' . $slider->slide)}}" class="img-fluid"
                                     alt="Brands Slider Image">
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
    <!--For mobile-->
    @php
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'brands')->where('screen', 'Mobile' )->where('brand', $Brand[0]->id)->orderBy('order_no', 'ASC')->get();
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

    {{--Shop by Category Section--}}
    <section class="mb-5 mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 mb-5 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        Shop by Category
                    </span>
                </div>
                <div class="col-md-12">
                    <div class="row products-category-slider ltn__category-slider slick-arrow-1">
                        @foreach($Categories as $category)
                            <div class="col-md-2">
                                <a href="{{route('CheckSlugRoute', ['slug' => $category->slug])}}">
                                    <span class="product-category-circle">
                                        <span class="product-category-circle-img">
                                            <img src="{{asset('public/storage/categories/' . $category->icon)}}"
                                                 alt="Brand Category Image" class="img-fluid"/>
                                        </span>
                                    </span>
                                    <p class="mt-2 mb-0 text-black text-center">{{$category->title}}</p>
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
                                    {{$category->brandpage_selling_tagline}} {{$category->title}}
                                    &nbsp;
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
                                <a href="{{route('DealsRoute', ['slug' => $category->slug])}}">
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
                            $Products = Illuminate\Support\Facades\DB::table('products')->where('deleted_at', null)
                                        ->where('brand', $Brand[0]->id)
                                        ->where('category', $category->id)
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
