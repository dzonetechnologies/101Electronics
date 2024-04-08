@extends('site.layouts.app')
@section('content')
    {{--Reviews--}}
    <link rel="stylesheet" href="{{asset('public/assets/css/reviews.css')}}">
    <style media="screen">
        .pdfGuideSetting {
            font-size: 18px;
            padding-top: 5px;
        }

        .guideModel > p {
            margin-bottom: 0em;
        }

        .mini-cart-product-area {
            max-height: calc(100% - (50px));
        }

        .voucherDesc > p {
            margin-bottom: 0em;
            font-size: 13px;
        }

        .discountVoucherModel > p {
            margin-bottom: 0em;
            font-size: 13px;
        }

        .discountVoucherHeadSetting {
            padding-bottom: 0px;
            border-bottom: none;
        }

        .discountVoucherDescSetting {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .f-13 {
            font-size: 13px;
        }

        .f-15 {
            font-size: 15px;
        }

        .f-20 {
            font-size: 20px;
        }

        .f-8 {
            font-size: 8px;
        }

        .f-10 {
            font-size: 10px;
        }

        .f-6 {
            font-size: 6px;
        }

        .f-3 {
            font-size: 3px;
        }

        .product_img_circle_mob {
            cursor: pointer;
            border-radius: 100%;
            display: flex;
            align-items: center;
            width: 42px;
            height: 45px;
            margin-left: -25px;
            overflow: hidden;
            border: 1px solid #E6E6E6;
        }

        .product-images-circle-img-mob {
            max-height: 40px;
            max-width: 30px;

        }

        .mt_price {
            margin-top: 10px;

        }

        .mt-section {
            margin-top: 20px;

        }

        .mt_btn {
            margin-top: -17px;
        }

        .mt_discount {
            margin-top: -10px;
        }

        .mt-install {
            margin-top: -3px;
        }

        .m-l {
            margin-left: -20px;
        }

        .m-l-r {
            margin-left: -12px;
        }

        .ml {
            margin-left: 15px;
        }

        .mr {
            margin-right: 20px;
        }

        .mt {
            margin-left: -15px;
        }

        .btn_padding {
            padding: 5px 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .q_btn {
            padding: 3px;
        }

        .padd {
            padding: 0px;
        }

        .text_padd {
            padding: 0px -20px 0px;
            border: 1px solid #C71738;
            padding: 5px;
            border-radius: 5px;
        }

        /*img {
            margin-left: 6px;
        }*/

        .logo {
            max-width: 110px;
            margin-left: -1px;
        }

        .b-logo {
            max-width: 90px;
            margin-left: -1px;
        }

        .title-color {
            color: #C71837;
        }

        .social-btn-sp #social-links {
            margin: 0 auto;
            max-width: 200px;
            margin-left: -18px;
        }

        .social-btn-sp #social-links ul li a:hover {
            color: black;
        }

        .social-btn-sp #social-links ul li {
            display: inline-block;
        }

        .social-btn-sp #social-links ul li a {
            padding: 9px;
            border: 1px solid #C71836;
            margin: 2px;
            font-size: 19px;
            color: #C71836;
        }

        progress {
            height: 15px;
        }

        progress::-webkit-progress-bar {
            background-color: #f1f1f1;
        }

        progress::-webkit-progress-value {
            background-color: #ffb33e;
        }

        .customer-review-star {
            font-size: 1rem;
            color: #ffb33e;
        }

        @media only screen and (min-width: 992px) {

            .quiz-img {
                height: 150px;
                margin-left: 60px;
            }

            .ml-15 {
                margin-left: 15px;
            }

            .discount-quiz {
                color: #C71837;
            }

            .ml-25 {
                margin-left: 25px;
            }

            .fs {
                font-size: 20px;
            }
        }

        @media only screen and (max-width: 767px) {

            .fs {
                font-size: 15px;
            }

            .quiz-img {
                height: 150px;
                margin-left: 30px;
            }

            .discount-quiz {
                color: #C71837;
            }
        }
    </style>
    <?php
    /*$Reviews = \Illuminate\Support\Facades\DB::table('customer_reviews')
        ->join('customers', 'customer_reviews.user_id', '=', 'customers.user_id')
        ->where('customer_reviews.deleted_at', '=', null)
        ->where('customer_reviews.product_id', '=', $Product[0]->id)
        ->select('customer_reviews.*', 'customers.first_name', 'customers.last_name')
        ->orderBy('id', 'DESC')
        ->get();
    $ReviewsCounts = \Illuminate\Support\Facades\DB::table('customer_reviews')
        ->where('customer_reviews.deleted_at', '=', null)
        ->where('customer_reviews.product_id', '=', $Product[0]->id)
        ->selectRaw("COUNT(*) AS TotalReviews, (SELECT COUNT(*) FROM customer_reviews WHERE deleted_at IS NULL AND product_id = ? AND rating = 5) AS FiveStarCount, (SELECT COUNT(*) FROM customer_reviews WHERE deleted_at IS NULL AND product_id = ? AND rating = 4) AS FourStarCount, (SELECT COUNT(*) FROM customer_reviews WHERE deleted_at IS NULL AND product_id = ? AND rating = 3) AS ThreeStarCount, (SELECT COUNT(*) FROM customer_reviews WHERE deleted_at IS NULL AND product_id = ? AND rating = 2) AS TwoStarCount, (SELECT COUNT(*) FROM customer_reviews WHERE deleted_at IS NULL AND product_id = ? AND rating = 1) AS OneStarCount", array($Product[0]->id, $Product[0]->id, $Product[0]->id, $Product[0]->id, $Product[0]->id))
        ->get();*/
    $ReviewsData = \App\Helpers\SiteHelper::GetAverageRating($Product[0]->id);
    $Reviews = $ReviewsData['reviews'];
    ?>
    <input type="hidden" name="hiddenProductId" id="hiddenProductId" value="{{$Product[0]->id}}">
    <input type="hidden" name="hiddenUnitPrice" id="hiddenUnitPrice" value="{{$Product[0]->unit_price}}">
    <input type="hidden" name="hiddenTaxRate" id="hiddenTaxRate" value="{{$Product[0]->tax}}">
    <input type="hidden" name="hiddenDiscount" id="hiddenDiscount" value="{{$Product[0]->discount}}">
    <input type="hidden" name="hiddenCurrency" id="hiddenCurrency"
           value="{!! \App\Helpers\SiteHelper::$Currency !!}">
    <input type="hidden" name="hiddenTotalQuantity" id="hiddenTotalQuantity" value="1">
    <input type="hidden" name="hiddenTotalPriceWithoutDiscounted" id="hiddenTotalPriceWithoutDiscounted"
           value="{{$Product[0]->total_price_without_discount}}">
    <input type="hidden" name="hiddenTotalPrice" id="hiddenTotalPrice" value="{{$Product[0]->total_price}}">

    <section id="product-details-page">
        <div class="container">
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

            <div class="row my-3">
                <div class="col-md-12 col-lg-6">
                    <div class="text-black fs-20 fw-bold">
                        {{$Product[0]->name}}
                        @if(floatval($Product[0]->discount) != 0)
                            <span class="badge product-badge-price bg-danger ml-1">{{$Product[0]->discount}}% OFF</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <div class="product-gallery-container">
                            <img src="" alt="PRODUCT DETAILS 1" class="img-fluid" id="colorImageDisplay"
                                 style="display: none;"/>
                            <img src="{{asset('public/storage/products') . '/' . $ProductGalleryImages[0]->gallery}}"
                                 id="product-image-container" alt="PRODUCT DETAILS 1" class="img-fluid" />
                            <video src="" id="product-video-container" style="width: 100%; height: 100%; display: none;"
                                   controls></video>
                            <iframe src="" id="product-video-iframe" title="Video Player" frameborder="0"
                                    style="width: 100%; height: 100%; display: none;"></iframe>
                        </div>
                        <div class="row ltn__no-gutter justify-content-center">
                            <div class="col-9">
                                <div class="mt-3 ltn__product-gallery-slider">
                                    @foreach($ProductGalleryImages as $index => $item)
                                        <div class="product-images-circle">
                                            <img src="{{asset('public/storage/products') . '/' . $item->gallery}}"
                                                 alt="Gallery Image" class="img-fluid" id="galleryImage||{{$index}}"
                                                 onclick="ChangeGalleryImage(this, this.id);"/>
                                        </div>
                                    @endforeach
                                    @if($Product[0]->video_link != '')
                                        <div class="product-images-circle">
                                            <img src="{{asset('public/storage/products/video.jpg')}}" alt="Video"
                                                 data-link="{{$Product[0]->video_link}}" class="img-fluid"
                                                 onclick="DisplayIframe(this, 'product-video-iframe');">
                                        </div>
                                    @endif
                                    @if($Product[0]->video_file != '')
                                        <div class="product-images-circle">
                                            <img src="{{asset('public/storage/products/video.jpg')}}" alt="Gallery Image"
                                                 data-link="{{asset('public/storage/products' . '/' . $Product[0]->video_file)}}"
                                                 class="img-fluid" onclick="DisplayVideoTag(this, 'product-video-container');">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 mt-3 mt-lg-0">
                    <p class="text-black fs-16 mb-2">
                        {!! $Product[0]->code !!}
                    </p>
                    <div class="row align-items-end mb-2">
                        <div class="col-6">
                            <img src="{{asset('public/storage/brands'). '/' . $Product[0]->BrandImage}}" alt="Brand Logo" class="logo"/>
                        </div>
                        <div class="col-6">
                            <p class="fs-14 mb-0 text-end">
                                <a href="#ltn__utilize-discount-voucher-menu" class="ltn__utilize-toggle">Discount Vouchers <i
                                        class="fas fa-gift text-custom-primary cursor-pointer"></i></a>
                            </p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <p class="text-black fs-16 mb-0">
                                Key Features
                            </p>
                        </div>
                        <div class="col-8">
                            <p class="mb-0 fs-14 fw-500 text-end">
                                @if($ReviewsData['total_rating'] != 0)
                                    <i class="fa fa-star text-warning"></i>
                                    <b>{{$ReviewsData['avg_rating']}}</b>
                                    <small>({{$ReviewsData['total_rating']}})</small>
                                    &nbsp;
                                    |
                                    &nbsp;
                                @endif
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <span class="text-custom-primary text-decoration-underline cursor-pointer" onclick="postReview()">
                                    Write a review
                                    </span>
                                @elseif(\Illuminate\Support\Facades\Auth::check() == "")
                                    <span class="text-custom-primary text-decoration-underline cursor-pointer" onclick="window.location.href='{{url('login')}}';">
                                        Login to write a review
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="product-features-card mb-3">
                        {!! $Product[0]->short_description !!}
                        <hr class="my-3">
                        <div class="row align-items-center">
                            <div class="col-8 features-buttons">
                                <a href="javascript:void(0);" onclick="toggleReturnCancellations();"><span
                                        class=" mr-1 px-2 py-1 border-radium-5 text-custom-primary border-custom-primary cursor-pointer">Return & Cancellations</span></a>
                                <br >
                                <a href="javascript:void(0);" onclick="toggleDeliveryOptions();"><span
                                        class="px-2 py-1 border-radium-5 text-custom-primary border-custom-primary cursor-pointer">Delivery Options</span></a>
                            </div>
                            <div class="ps-1 col-4">
                                <div class="text-end mb-1">
                                    <a href="javascript:void(0);" class="fs-12 text-custom-primary fw-600 mb-0 cursor-pointer">
                                        SEE ALL SPECS <i class="fas fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        @if($Product[0]->installment_calculator == 1)
                            <div class="col-6">
                                <p class="fs-14 mb-2">
                                    <a href="#ltn__utilize-installment-guide-menu" class="ltn__utilize-toggle">Installment Guide
                                        <i class="fas fa-info-circle text-custom-primary cursor-pointer"></i></a>
                                </p>
                                <div class="fs-13 mb-2">
                                    <?php
                                    $Months = \Illuminate\Support\Facades\DB::table('instant_calculators')
                                        ->get();
                                    ?>
                                    @foreach($Months as $index => $item)
                                        <span class="installment-plan-option px-2 py-1">{{$item->month}}</span>
                                    @endforeach
                                    <span> /Month</span>
                                </div>
                                <input type="text" class="form-control installment-plan-option-input mb-0" name="installment"
                                       id="installment" placeholder="PKR">
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="product-detail-delivery">
                                <p class="mb-0 fs-13 fw-600 text-black">
                                    @if($Product[0]->free_shipping == 0)
                                        <i class="fas fa-check text-success"></i>&nbsp;
                                        Free Shipping
                                    @else
                                        Shipping: {{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Product[0]->shipping_flat_rate)}}
                                    @endif
                                </p>
                                <p class="mb-0 fs-13 text-black mb-0">
                                    @if($Product[0]->zero_free_installation == 1)
                                        <i class="fas fa-check text-success"></i>&nbsp;
                                        Free Installation
                                    @else
                                        Installation: {{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Product[0]->installation_price)}}
                                    @endif
                                </p>
                                <p class="mb-0 fs-13 text-black">
                                    @if($Product[0]->fast_24hour_delivery == 1)
                                        <i class="fas fa-check text-success"></i>&nbsp;
                                        Fast free delivery
                                    @else
                                        <i class="fas fa-check text-success"></i>&nbsp;
                                        Normal Delivery
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <p class="fs-large fw-500 text-black mb-1 line-height-1-3" id="productPriceDisplay">
                                {!! \App\Helpers\SiteHelper::CalculatePrice($Product[0]->total_price) !!}
                            </p>
                            @if(floatval($Product[0]->discount) != 0)
                                <p class="mb-2 fs-13 line-height-1-3">
                                    <span class="text-decoration-line-through" id="productOrgPriceDisplay">
                                        {!! \App\Helpers\SiteHelper::CalculatePrice($Product[0]->total_price_without_discount) !!}
                                    </span>
                                </p>
                            @endif
                            <div class="mb-2">
                                <table>
                                    <tr>
                                        <td> {{-- style="width: 15%;" --}}
                                            <div class="product-quantity-btn fs-12 me-2"
                                                onclick="ReduceQty(document.getElementById('quantity'), 1);">
                                                <i class="fas fa-minus"></i>
                                            </div>
                                        </td>
                                        {{--<td style="width: 5%;"></td>--}}
                                        <td> {{-- style="width: 60%" --}}
                                            <input type="text" class="form-control product-quantity-input mb-0" name="quantity"
                                                   id="quantity" placeholder="Quantity" value="1"
                                                   onkeypress="CheckNumberInputForQty(this, event, this.value);"
                                                   onblur="CalculatePrice();"/>
                                        </td>
                                        {{--<td style="width: 5%;"></td>--}}
                                        <td> {{-- style="width: 15%;" --}}
                                            <div class="product-quantity-btn fs-12 ms-2" {{-- px-2 py-2 --}}
                                                  onclick="IncreaseQty(document.getElementById('quantity'), 1);">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <button class="btn btn-custom-primary fs-13 w-100 mb-2" type="button"
                                        onclick="AddToCartProductDetails(this);">
                                    <i class="fas fa-shopping-cart"></i>&nbsp;
                                    Add to Cart
                                </button>
                                <button class="btn btn-custom-primary fs-13 w-100" type="button"
                                        onclick="AddToCartProductDetails(this, true);">
                                    <i class="fas fa-cart-arrow-down"></i>&nbsp;
                                    Buy Now
                                </button>
                            </div>
                            <div class="pdf-list-buttons">
                                @if($Product[0]->pdf_specification != "")
                                    <a href="{{asset('public/storage/products/' . $Product[0]->pdf_specification)}}" download>
                                        <i class="fas fa-file-pdf text-custom-primary pdfGuideSetting"></i> PDF Guide
                                    </a>
                                    &nbsp;&nbsp;
                                @endif
                                @php
                                    $WishList = \App\Helpers\SiteHelper::GetUserList();
                                @endphp
                                    <br >
                                @if(in_array($Product[0]->id, $WishList))
                                    <a href="javascript:void(0);" class="text-custom-primary"
                                       onclick="AddToWishlistProductDetails('Please login first to add product in your list.', '{{$Product[0]->id}}', this);">
                                        <i class="fas fa-heart text-custom-primary pdfGuideSetting"></i> Wishlisted
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="text-custom-primary"
                                       onclick="AddToWishlistProductDetails('Please login first to add product in your list.', '{{$Product[0]->id}}', this);">
                                        <i class="far fa-heart text-custom-primary pdfGuideSetting"></i> Wishlist
                                    </a>
                                @endif
                                <br>
                                <div class="social-btn-sp">
                                    {!! $shareButtons !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Reviews --}}
            <div class="row mb-3">
                <div class="col-md-5 col-lg-4">
                    <h5 class="mb-1">Customer Reviews ({{$ReviewsData['total_rating']}})</h5>
                    <p class="mb-0">
                        <i class="fa fa-star customer-review-star"></i>
                        <i class="fa fa-star customer-review-star"></i>
                        <i class="fa fa-star customer-review-star"></i>
                        <i class="fa fa-star customer-review-star"></i>
                        <i class="fa fa-star customer-review-star"></i>
                    </p>
                    <p class="mb-1"><strong>{{$ReviewsData['avg_rating']}} out of 5</strong></p>
                    <div class="row">
                        <div class="col-3">5 Star</div>
                        <div class="col-6 pl-0 pr-0">
                            <progress class="w-100" value="{{$ReviewsData['5_star_total']}}" max="100"
                                      style="border-radius: 0;">{{$ReviewsData['5_star_total']}}%
                            </progress>
                        </div>
                        <div class="col-3 fs-14 ps-2">({{$ReviewsData['5_star']}})</div>
                    </div>
                    <div class="row">
                        <div class="col-3">4 Star</div>
                        <div class="col-6 pl-0 pr-0">
                            <progress class="w-100" value="{{$ReviewsData['4_star_total']}}" max="100"
                                      style="border-radius: 0;">{{$ReviewsData['4_star_total']}}%
                            </progress>
                        </div>
                        <div class="col-3 fs-14 ps-2">({{$ReviewsData['4_star']}})</div>
                    </div>
                    <div class="row">
                        <div class="col-3">3 Star</div>
                        <div class="col-6 pl-0 pr-0">
                            <progress class="w-100" value="{{$ReviewsData['3_star_total']}}" max="100"
                                      style="border-radius: 0;">{{$ReviewsData['3_star_total']}}%
                            </progress>
                        </div>
                        <div class="col-3 fs-14 ps-2">({{$ReviewsData['3_star']}})</div>
                    </div>
                    <div class="row">
                        <div class="col-3">2 Star</div>
                        <div class="col-6 pl-0 pr-0">
                            <progress class="w-100" value="{{$ReviewsData['2_star_total']}}" max="100"
                                      style="border-radius: 0;">{{$ReviewsData['2_star_total']}}%
                            </progress>
                        </div>
                        <div class="col-3 fs-14 ps-2">({{$ReviewsData['2_star']}})</div>
                    </div>
                    <div class="row">
                        <div class="col-3">1 Star</div>
                        <div class="col-6 pl-0 pr-0">
                            <progress class="w-100" value="{{$ReviewsData['1_star_total']}}" max="100"
                                      style="border-radius: 0;">{{$ReviewsData['1_star_total']}}%
                            </progress>
                        </div>
                        <div class="col-3 fs-14 ps-2">({{$ReviewsData['1_star']}})</div>
                    </div>
                    <h6 class="mb-1 mt-4">Review this product</h6>
                    <p class="mb-2">Share your thoughts with other customers</p>
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <button class="btn btn-outline-review" style="border-radius:15px;width:60%" onclick="postReview()">
                            Write a customer review
                        </button>
                    @elseif(\Illuminate\Support\Facades\Auth::check() == "")
                        <h5><strong>Please login to post a review</strong></h5>
                    @endif
                </div>
                <div class="col-md-7 col-lg-8">
                    @foreach($Reviews as $index => $review)
                        @if($index == 10)
                            @break
                        @endif
                        <div class="review-item mt-2">
                            <div class="reviewer-details">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="mb-0">
                                            <i class="fa fa-star" style="font-size: 1rem;color:#ffb33e;"></i>
                                            <i style="color:#ffb33e;">{{$review->rating}}</i>
                                        </span>
                                        <span class="text-body-2 time"
                                              style="margin-left: 10px">{{\Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                                    </div>
                                    <div class="col-md-12">
                                        <h5 class="mb-0 mt-0">{{$review->first_name . ' ' . $review->last_name}}
                                            <small class="review-rating" style="font-size: 0.850rem;">
                                                @if(\Illuminate\Support\Facades\Auth::check())
                                                    @if(\Illuminate\Support\Facades\Auth::id() == 1)
                                                        <span class="ml-2 cursor-pointer"
                                                              onclick="DeleteReview('{{$review->id}}');"><i
                                                                    class="fas fa-trash"></i></span>
                                                    @endif
                                                @endif
                                            </small>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="review-description">
                                <p class="text-body-2 mb-2 mt-2">
                                    {{$review->message}}
                                </p>
                                <p style="font-size: 14px">
                                    @if($review->recommendation == "1")
                                        <strong>Recommends this product:</strong>
                                        <i class="fa fa-check" aria-hidden="true"
                                           style="margin-left:4px;margin-right: 4px"></i>
                                        <strong>Yes</strong>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- Product Reviews --}}

            {{-- Related Products --}}
            <div class="row mt-3 mb-3">
                <div class="col-md-12">
                    <p class="text-custom-primary fs-large fw-600 mb-0">
                        Related Products
                    </p>
                </div>

                <div class="col-md-12">
                    @php
                        $Products = Illuminate\Support\Facades\DB::table('products')
                            ->where('deleted_at', null)
                            ->where('sub_subcategory', $Product[0]->sub_subcategory)
                            ->where('id', '<>', $Product[0]->id)
                            ->orderByRaw('RAND()')
                            ->limit(10)
                            ->get();
                        $List = \App\Helpers\SiteHelper::GetUserList();
                        $index = 0;
                    @endphp
                    <div class="products-category-slider ltn__category-products-slider slick-arrow-1">
                        @foreach($Products as $index1 => $product)
                            {!! \App\Helpers\SiteHelper::GetProductTemplate($product, $index, $index1, $List) !!}
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- Related Products --}}

            {{-- *** Colors *** --}}
            {{--@if(sizeof($ProductColors) > 0)
                <p class="text-custom-primary fw-600 fs-large mb-0">
                    Colors:
                </p>
                <div class="mb-2">
                    <?php
                    foreach ($ProductColors as $index => $productColor) {
                        $AssetUrl = asset('public/storage/products/') . '/' . $productColor->color_image;
                        echo '<span class="mr-1 cursor-pointer" data-toggle="tooltip" title="' . $productColor->ColorName . '" style="background-color: ' . $productColor->ColorCode . '; border-radius: 100%; padding: 2px;" onclick="ShowProductColorImage(\'' . $AssetUrl . '\');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                    }
                    ?>
                </div>
            @endif--}}
            {{-- *** Colors *** --}}

            {{-- *** Product Dscription *** --}}
            {{--<div class="row mt-3">
                <div class="col-md-12 product-description-div mb-3">
                    <p class="text-custom-primary fs-large mb-2">
                        Brief product description
                    </p>
                    {!! $Product[0]->description !!}
                </div>
            </div>--}}
            {{-- *** Product Dscription *** --}}

            {{-- *** Packaging Details *** --}}
            {{--<div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-dark fs-15 fw-500 mb-0">
                                Size and Packaging Details
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-8 col-md-7 pr-0">
                                            @if(sizeof($ProductSizes) > 0)
                                                <p class="text-custom-primary fs-12 mb-0"
                                                   id="unit{{$ProductSizes[0]->UnitName}}DepthWidth"
                                                   style="display: none;">
                                                    <span><b>Depth:</b>&nbsp;&nbsp;{{$ProductSizes[0]->depth . ' ' . $ProductSizes[0]->UnitName}}</span><span
                                                            class="ml-5"><b>Width:</b>&nbsp;&nbsp;{{$ProductSizes[0]->width . ' ' . $ProductSizes[0]->UnitName}}</span>
                                                </p>
                                            @endif
                                            @if(sizeof($ProductSizes) > 1)
                                                <p class="text-custom-primary fs-12 mb-0"
                                                   id="unit{{$ProductSizes[1]->UnitName}}DepthWidth"
                                                   style="display: none;">
                                                    <span><b>Depth:</b>&nbsp;&nbsp;{{$ProductSizes[1]->depth . ' ' . $ProductSizes[1]->UnitName}}</span><span
                                                            class="ml-5"><b>Width:</b>&nbsp;&nbsp;{{$ProductSizes[1]->width . ' ' . $ProductSizes[1]->UnitName}}</span>
                                                </p>
                                            @endif
                                            @if(sizeof($SizePackagingDetails) > 0 && $SizePackagingDetails[0]->image != "")
                                                <img
                                                        src="{{asset('public/storage/size-packaging/' . $SizePackagingDetails[0]->image)}}"
                                                        alt="PRODUCT DETAILS 2" class="img-fluid"
                                                        style="max-width:267px;"/>
                                            @else
                                                <img src="{{asset('public/storage/size-packaging/placeholder.jpg')}}"
                                                     alt="PRODUCT DETAILS 2" class="img-fluid"
                                                     style="max-width:267px;"/>
                                            @endif
                                        </div>
                                        <div class="col-4 col-md-5 pl-0">
                                            <div class="d-flex align-items-center h-100 text-custom-primary fs-12">
                                                @if(sizeof($ProductSizes) > 0)
                                                    <span id="unit{{$ProductSizes[0]->UnitName}}Height"
                                                          style="display: none;"><b>Height:</b><br>{{$ProductSizes[0]->height . ' ' . $ProductSizes[0]->UnitName}}</span>
                                                @endif
                                                @if(sizeof($ProductSizes) > 1)
                                                    <span id="unit{{$ProductSizes[1]->UnitName}}Height"
                                                          style="display: none;"><b>Height:</b><br>{{$ProductSizes[1]->height . ' ' . $ProductSizes[1]->UnitName}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-3 text-center d-flex align-items-center mt-3">
                                            <div class="m-auto">
                                                <div class="d-flex align-items-center">
                                                    <span class="mr-2">Millimeters</span>
                                                    <label class="switch" for="checkbox">
                                                        <input type="checkbox" id="checkbox"
                                                               onchange="ChangeProductSizeUnits(this, this.checked);"/>
                                                        <div class="slider round"></div>
                                                    </label>
                                                    <span class="ml-2">Inches</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    @if($Product[0]->size_packaging_img != "")
                                        <img
                                                src="{{asset('public/storage/products/'. $Product[0]->size_packaging_img)}}"
                                                alt="PRODUCT SIZE AND PACKAGING IMAGE" class="img-fluid"
                                                style="max-width:500px;max-height:1000px;"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
            {{-- *** Packaging Details *** --}}
        </div>
    </section>

    <!-- Utilize Discount Voucher Right Sidebar Start -->
    <div id="ltn__utilize-discount-voucher-menu" class="ltn__utilize ltn__utilize-cart-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">
            <div class="ltn__utilize-menu-head discountVoucherHeadSetting">
                <span class="ltn__utilize-menu-title"><i class="fas fa-gift"></i> Discount Vouchers</span>
                <button class="ltn__utilize-close">×</button>
            </div>
            <div class="mini-cart-product-area ltn__scrollbar">
                <p><strong><i class="fa fa-question-circle fa-1x" aria-hidden="true"></i> Get Your Instant Discount By
                        Submit Answers</strong></p>
                @php
                    $TotalQuestions = Illuminate\Support\Facades\DB::table('discount_questions')
                        ->where('deleted_at', null)
                        ->count();
                @endphp
                <input type="hidden" name="total_questions" id="total_questions" value="{{$TotalQuestions}}">
                <div id="quiz_div">
                    @foreach($DiscountQuestions as $index => $value)

                        <div class="col-md-12 mb-2">
                            <p class="mb-1"><strong>{{$index+1}}) {{$value->question}}</strong></p>
                        </div>
                        <div class="col-md-12">
                              <input type="hidden" name="answer" id="answer_{{$index}}" value="{{$value->answer}}">

                            <input type="radio" name="choice_{{$index}}" value="1" style="margin-left: -7px;">
                              <label> {{$value->choice1}}</label><br>
                            <input type="radio" name="choice_{{$index}}" value="2">
                              <label> {{$value->choice2}}</label><br>
                            <input type="radio" name="choice_{{$index}}" value="3">
                              <label> {{$value->choice3}}</label><br>
                            <input type="radio" name="choice_{{$index}}" value="4">
                              <label> {{$value->choice4}}</label><br>
                        </div>
                    @endforeach
                </div>
                {{--Success Message--}}
                <div class="ml-15" id="message" style="display: none">
                    <img src="{{asset('public/assets/images/quiz/win.jpeg')}}"
                         class="img-fluid quiz-img align-items-center"/>
                    <p class="mt-3 mb-0 fs"><strong>Congratulations! You won the quiz</strong></p>
                    <p class="discount-quiz ml-25 fs">Discount code: <strong id="discount_code"></strong></p>
                </div>
                {{--Lose Message--}}
                <div class="ml-27" id="message_lose" style="display: none">
                    <img src="{{asset('public/assets/images/quiz/lost.jpeg')}}"
                         class="img-fluid quiz-img align-items-center"/>
                    <p class="mt-3 mb-0  discount-quiz fs"><strong onclick="window.location.reload()">Sorry! Your
                            answers are incorrect. Try Again.</strong></p>
                </div>
                <div class="col-md-12 text-center mt-3 mb-3">
                    <button id="submit_btn" class="btn btn-custom-primary-b2b fs-15" onclick="quizCalculation()">
                        Submit
                    </button>
                </div>
                <div class="mini-cart-item clearfix discountVoucherDescSetting">
                    <div class="discountVoucherModel">
                        @foreach($GeneralPages as $page)
                            @if($page->id == 10)
                                {!! $page->desc !!}
                            @endif
                        @endforeach
                    </div>
                </div>
                @foreach($DiscountVouchers as $voucher)
                    <div class="mini-cart-item clearfix">
                        <div class="mini-cart-info">
                            <h6>{{$voucher->title}}</h6>
                            <div class="voucherDesc">
                                {!! $voucher->desc !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Utilize Discount Voucher Right Sidebar End -->

    <!-- Utilize Installment Guide Right Sidebar End -->
    <div id="ltn__utilize-installment-guide-menu" class="ltn__utilize ltn__utilize-cart-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">
            <div class="ltn__utilize-menu-head discountVoucherHeadSetting">
                <span class="ltn__utilize-menu-title"><i class="fas fa-gift"></i> Installment Guide</span>
                <button class="ltn__utilize-close">×</button>
            </div>
            <div class="mini-cart-product-area ltn__scrollbar">
                <div class="mini-cart-item clearfix discountVoucherDescSetting">
                    <div class="discountVoucherModel">
                        @foreach($GeneralPages as $page)
                            @if($page->id == 6)
                                {!! $page->desc !!}
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Utilize Installment Guide Right Sidebar End -->

    @include('site.includes.submitReviewModal');
    @include('site.includes.deliveryOptionsModal')
    @include('site.includes.returnCancellationsModal')
@endsection
