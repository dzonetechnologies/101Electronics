@extends('site.layouts.app')
@section('content')
    <link rel="stylesheet" href="{{asset('public/assets/css/vertical-progressbar.css')}}"/>
    <style>
        .select2-container .select2-selection--single {
            height: 35px !important;
            border: 1px solid var(--border-color-9) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 33px !important;
            font-size: 13px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 4px !important;
        }

        .select2-results__option {
            margin-top: 0;
            padding: 5px !important;
            font-size: 13px;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid var(--border-color-9) !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            /*min-height: 25px !important;*/
            font-size: 13px;
        }

        @media (min-width: 992px) {
            .btn-centre {
            }
        }

        @media (max-width: 767px) {
            .btn-centre {
                text-align: center;
            }
        }
    </style>

    {{--Slider Section--}}
    @php
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'b2b' )->where('screen', 'Desktop' )->orderBy('order_no', 'ASC')->get();
    @endphp
    <section class="mb-0 d-none d-md-block">
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
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'b2b')->where('screen', 'Mobile' )->orderBy('order_no', 'ASC')->get();
    @endphp
    <section class="mb-0 d-md-none">
        <div class="container-fluid">
            <div class="row main-slider">
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

    @php
        $B2BTree = \Illuminate\Support\Facades\DB::table('b2b_trees')
            ->get();
        $__Categories = '';
        $__SubCategories = '';
        $__SubSubCategories = '';
    @endphp

    <div class="container mt-5 mb-5"
         style="background: url('{{asset('public/assets/images/b2b.png')}}'); background-position: center 50px; background-size: contain; background-repeat: no-repeat;">
        <div class="row">
            @foreach($B2BTree as $index => $b2bTree)
                @php
                    $Categories = $b2bTree->categories != ''? explode(',', $b2bTree->categories) : array();
                    $SubCategories = $b2bTree->sub_categories != ''? explode(',', $b2bTree->sub_categories) : array();
                    $SubSubCategories = $b2bTree->sub_sub_categories != ''? explode(',', $b2bTree->sub_sub_categories) : array();
                    $DealsPageUrl = route('B2BRoute.deals', array($b2bTree->tree_type));
                    $CategoriesSlug = \Illuminate\Support\Facades\DB::table('categories')
                            ->where('deleted_at')
                            ->get();

                    if($index == 0) {
                        $__Categories = $b2bTree->categories != ''? $b2bTree->categories : '';
                        $__SubCategories = $b2bTree->sub_categories != ''? $b2bTree->sub_categories : '';
                        $__SubSubCategories = $b2bTree->sub_sub_categories != ''? $b2bTree->sub_sub_categories : '';
                    } else {
                        $__Categories .= $b2bTree->categories != ''? ($__Categories != ''? ',' : '') . $b2bTree->categories : '';
                        $__SubCategories .= $b2bTree->sub_categories != ''? ($__SubCategories != ''? ',' : '') . $b2bTree->sub_categories : '';
                        $__SubSubCategories .= $b2bTree->sub_sub_categories != ''? ($__SubSubCategories != ''? ',' : '') . $b2bTree->sub_sub_categories : '';
                    }
                @endphp
                <div class="col-md-4 ">
                    <a class="btn btn-custom-primary-b2b fs-15 fw-600 w-75 d-none d-md-block btn-centre "
                       href="{{$DealsPageUrl}}">
                        {{ \App\Helpers\SiteHelper::GetTreeTitleFromType($b2bTree->tree_type) }}
                    </a>
                    {{--Mobile Btn--}}
                    <div class="container btn-centre">
                        <a class="btn btn-custom-primary-b2b fs-15 fw-600 w-40 d-md-none" href="{{$DealsPageUrl}}">
                            {{ \App\Helpers\SiteHelper::GetTreeTitleFromType($b2bTree->tree_type) }}
                        </a>
                    </div>
                    {{--Mobile Btn End--}}
                    <div class="mt-4">
                        <ul class="StepProgress mb-0 mb-4 mt-4">
                            @foreach($Categories as $category)
                                <li class="StepProgress-item is-done cursor-pointer mt-0 mb-2"
                                    onclick="window.location.href='{{route('home.slug', ['slug1' => \App\Helpers\SiteHelper::GetCategoryFromId($category)[0]->slug])}}';"> {{--is-active--}}
                                    <strong>{{\App\Helpers\SiteHelper::GetCategoryFromId($category)[0]->title}}</strong>
                                </li>
                            @endforeach
                            @foreach($SubCategories as $subCategory)
                                <li class="StepProgress-item is-done cursor-pointer mt-0 mb-2"
                                    onclick="window.location.href='{{$DealsPageUrl}}';"> {{--is-active--}}
                                    <strong>{{\App\Helpers\SiteHelper::GetSubCategoryFromId($subCategory)[0]->title}}</strong>
                                </li>
                            @endforeach
                            @foreach($SubSubCategories as $subSubCategory)
                                <li class="StepProgress-item is-done cursor-pointer mt-0 mb-2"
                                    onclick="window.location.href='{{$DealsPageUrl}}';"> {{--is-active--}}
                                    <strong>{{\App\Helpers\SiteHelper::GetSubSubCategoryFromId($subSubCategory)[0]->title}}</strong>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{--Category With Products--}}
    @foreach($B2BTree as $index => $b2bTree)
        @php
            $Categories = $b2bTree->categories != ''? explode(',', $b2bTree->categories) : array();
            $SubCategories = $b2bTree->sub_categories != ''? explode(',', $b2bTree->sub_categories) : array();
            $SubSubCategories = $b2bTree->sub_sub_categories != ''? explode(',', $b2bTree->sub_sub_categories) : array();
        @endphp
        <section class="mb-5">
            <div class="container">
                <div class="row line-height-1-3 mb-2">
                    <div class="col-7 col-sm-8">
                        <h2 class="section-title text-custom-primary fs-15 mb-2">
                            @if($index == 0)
                                Find the best large appliance.
                            @elseif($index == 1)
                                Quickly find your best product.
                            @elseif($index == 2)
                                Find the Best Built-In Appliances at  Discounts.
                            @endif
                        </h2>
                    </div>
                    <div class="col-5 col-sm-4">
                        <a href="{{ route('B2BRoute.deals', array($b2bTree->tree_type)) }}">
                            <label for="" class="form-check-label text-custom-primary cursor-pointer fs-14 float-right">
                                See all deals <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </label>
                        </a>
                    </div>
                    {{--Products--}}
                    <div class="col-12">
                        @php
                            $Products = Illuminate\Support\Facades\DB::table('products')
                                ->where('deleted_at', null)
                                ->where(function ($query) use ($Categories, $SubCategories, $SubSubCategories) {
                                    $query->orWhereIn('products.category', $Categories);
                                    $query->orWhereIn('products.sub_category', $SubCategories);
                                    $query->orWhereIn('products.sub_subcategory', $SubSubCategories);
                                })
                                ->inRandomOrder()
                                ->limit(10)
                                ->get();
                            $List = \App\Helpers\SiteHelper::GetUserList();
                        @endphp
                        <div class="products-category-slider ltn__category-products-slider slick-arrow-1">
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

    <?php
    $Products = Illuminate\Support\Facades\DB::table('products')
        ->where('deleted_at', '=', null)
        ->where(function ($query) use ($__Categories, $__SubCategories, $__SubSubCategories) {
            $query->orWhereIn('products.category', explode(',', $__Categories));
            $query->orWhereIn('products.sub_category', explode(',', $__SubCategories));
            $query->orWhereIn('products.sub_subcategory', explode(',', $__SubSubCategories));
        })
        ->orderBy('order_no', 'ASC')
        ->get();
    ?>

    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-0">
                                @if(session()->has('success-message'))
                                    <div class="alert alert-success">
                                        {!! session('success-message') !!}
                                    </div>
                                @elseif(session()->has('error-message'))
                                    <div class="alert alert-danger">
                                        {!! session('error-message') !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <span class="form-title fw-600 fs-20">Get a Quote</span><span class="form-title fs-13"> (please fill this form)</span>
                        <form action="{{route('b2bForm') }}" method="post">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-title fw-500" for="name">Name:</label>
                                    <input type="text" class="form-control mb-2"
                                           name="name" id="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-title fw-500" for="email">Email:</label>
                                    <input type="email" class="form-control mb-2"
                                           name="email" id="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-title fw-500" for="phone">Phone:</label>
                                    <input type="text"
                                           onkeypress="return (event.charCode !== 8 && event.charCode === 0 || (event.charCode >= 48 && event.charCode <= 57))"
                                           class="form-control mb-2"
                                           name="phone" id="phone" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-title fw-500" for="city">City:</label>
                                    <input type="text" class="form-control mb-2"
                                           name="city" id="city" required>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="form-title fw-500" for="products">Products</label>
                                    <select class="form-control niceSelect-select2" name="products[]" id="products"
                                            multiple required>
                                        <option value="" disabled="disabled">Select</option>
                                        @foreach($Products as $index => $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="form-title fw-500" for="time_frame">Time Frame</label>
                                    <select class="form-control" name="time_frame" id="time_frame" required>
                                        <option value="">Select</option>
                                        <option value="15 days - 30 days">15 days - 30 days</option>
                                        <option value="30 days - 60 days">30 days - 60 days</option>
                                        <option value="60 days - 90 days">60 days - 90 days</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-title fw-500" for="quantity">Quantity:</label>
                                    <input type="text"
                                           onkeypress="return (event.charCode !== 8 && event.charCode === 0 || (event.charCode >= 48 && event.charCode <= 57))"
                                           class="form-control mb-2"
                                           name="quantity" id="quantity" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-title fw-500" for="comments">Comments</label>
                                    <textarea class="form-control" name="comments" id="comments" rows="5" cols="80"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="btn-wrapper mt-0">
                                <button class="btn btn-custom-primary text-uppercase fs-13" type="submit">
                                    <i class="fas fa-paper-plane"></i>&nbsp;
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center d-none d-md-block">
                <div class="m-auto">
                    @php
                        $GeneralSettings = Illuminate\Support\Facades\DB::table('general_settings')
                            ->where('id', 1)
                            ->get();
                    @endphp
                    @if($GeneralSettings[0]->b2b != '')
                        <img src="{{asset('public/storage/b2b') . '/' . $GeneralSettings[0]->b2b}}" class="img-fluid"
                             style="width: 400px;"/>
                    @else
                        <img src="{{asset('public/storage/logo/b2b.png')}}" class="img-fluid"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
