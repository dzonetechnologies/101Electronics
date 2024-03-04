@if(isset($ComparePage))
    @foreach($Products as $index1 => $product)
        <div class="col-md-3 mt-2 mb-2 product-card-difference">
            <a href="{{route('CheckSlugRoute', ['slug' => $product->slug])}}">
                <div class="product-category-square text-center">
                    @if($product->rating != null && $product->rating != 0)
                        <span class="product-category-square-rating">
                            <i class="fa fa-star text-warning"></i>&nbsp;{{$product->rating}}
                        </span>
                    @endif
                    @if(floatval($product->discount) != 0)
                        <span class="product-category-square-discount bg-custom-primary text-white">
                            {{$product->discount}}% OFF
                        </span>
                    @endif
                    <div class="product-category-square-img">
                        <img src="{{asset('public/storage/products/' . $product->primary_img)}}"
                             alt="Phones"
                             class="img-fluid"/>
                    </div>
                    <p class="mb-2 px-2 fs-13 fw-500 primary-color">
                        {{$product->name}}
                    </p>
                    <p class="mb-2 px-2 text-black fs-13 fw-500">
                        {{$product->code}}
                    </p>
                    <div class="product-description">
                        {!! $product->short_description !!}
                    </div>
                    <div class="mx-2 fs-12">
                        <p class="text-start mb-0">
                            @if($product->quantity > 0)
                                <i class="fa fa-circle text-success"></i>&nbsp;In stock
                            @else
                                <i class="fa fa-circle text-danger"></i>&nbsp;Stock out
                            @endif
                            <span class="text-end text-black fw-500 float-end">
                                {!! \App\Helpers\SiteHelper::CalculatePrice($product->total_price) !!}
                            </span>
                        </p>
                        @if(floatval($product->discount) != 0)
                            <p class="my-1 fs-11 text-decoration-line-through text-end">{!! \App\Helpers\SiteHelper::CalculatePrice($product->total_price_without_discount) !!}</p>
                        @else
                            <p class="my-1 fs-11 text-end">&nbsp;</p>
                        @endif
                    </div>
                    <div class="product-category-square-bottom" onclick="return event.preventDefault();">
                        <div class="row fs-12">
                            <div class="col-6 text-center py-2 product-category-square-btn border-right"
                                 id="addToCartDiv_{{$index}}{{$index1}}" style="display: none; cursor: not-allowed;">
                                Adding...
                            </div>
                            <div class="col-6 text-center py-2 product-category-square-btn border-right cursor-pointer"
                                 onclick="AddToCart(this, '{{$product->id}}', '{{$index}}{{$index1}}');">
                                Add to cart
                            </div>
                            <div class="col-6 text-center py-2 product-category-square-btn cursor-pointer <?php if (in_array($product->id, $List)) {
                                echo 'bg-custom-primary text-white';
                            } ?>"
                                 onclick="AddToWishlist('Please login first to add product in your list.', '{{$product->id}}', this);">
                                <?php if (in_array($product->id, $List)) {
                                    echo 'Wishlisted';
                                } else {
                                    echo 'Wishlist';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<div class="product-category-square text-center">
                    @if($product->rating != null && $product->rating != 0)
                        <span class="product-category-square-rating">
                            <i class="fa fa-star text-warning"></i>&nbsp;{{$product->rating}}
                        </span>
                    @endif
                    @if(floatval($product->discount) != 0)
                        <span class="product-category-square-discount bg-custom-primary text-white">
                            {{$product->discount}}% OFF
                        </span>
                    @endif
                    <span class="product-category-square-img mt-3 mb-3">
                        <img src="{{asset('public/storage/products/' . $product->primary_img)}}"
                             alt="Product Image"
                             class="img-fluid"/>
                    </span>
                    <p class="mb-2 pt-2 pl-1 pr-1 fs-13 fw-500 primary-color productNameLineHeight mt-4">
                        {{$product->name}}
                    </p>
                    <p class="mb-2 pt-2 pl-1 pr-1 text-black fs-13 fw-500"
                       style="line-height: 1.3;">
                        {{$product->code}}
                    </p>
                    <p class="mb-1 pt-2 text-black fs-14">
                        {!! $product->compare_description !!}
                    </p>
                    <table class="mt-1 mb-1 w-100 fs-12">
                        <tr>
                            <td style="width: 40%;font-size:11px;">
                                @if($product->quantity > 0)
                                    <i class="fa fa-circle text-success"></i>&nbsp;In
                                    stock
                                @else
                                    <i class="fa fa-circle text-danger"></i>&nbsp;Stock
                                    out
                                @endif
                            </td>
                            <td class="text-end text-black fw-500" style="width: 60%;">
                                @if(floatval($product->discount) != 0)
                                    {!! \App\Helpers\SiteHelper::CalculatePrice($product->unit_price, $product->discount) !!}
                                @else
                                    {!! \App\Helpers\SiteHelper::CalculatePrice($product->unit_price, $product->discount) !!}
                                @endif
                            </td>
                        </tr>
                    </table>
                    @if(floatval($product->discount) != 0)
                        <p class="mb-2 mt-1 fs-11 text-end">
                            <span class="text-decoration-line-through">{!! \App\Helpers\SiteHelper::CalculatePrice($product->unit_price, 0) !!}</span>
                        </p>
                    @else
                        <p class="mb-2 mt-1 fs-11 text-end">&nbsp;</p>
                    @endif
                    <div class="product-category-square-bottom" onclick="return event.preventDefault();">
                        <div class="row fs-12">
                            <div class="col-6 text-center px-1 py-2 product-category-square-btn border-right"
                                 id="addToCartDiv_{{$index}}{{$index1}}" style="display: none; cursor: not-allowed;">
                                Adding...
                            </div>
                            <div class="col-6 text-center px-1 py-2 product-category-square-btn border-right cursor-pointer"
                                 onclick="AddToCart(this, '{{$product->id}}', '{{$index}}{{$index1}}');">
                                Add to cart
                            </div>
                            <div class="col-6 text-center px-1 py-2 product-category-square-btn cursor-pointer <?php if (in_array($product->id, $List)) {
                                echo 'bg-custom-primary text-white';
                            } ?>"
                                 onclick="AddToWishlist('Please login first to add product in your list.', '{{$product->id}}', this);">
                                <?php if (in_array($product->id, $List)) {
                                    echo 'Wishlisted';
                                } else {
                                    echo 'Wishlist';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>--}}
            </a>
        </div>
    @endforeach
@elseif(isset($AccountPage))
    @foreach($Products as $index1 => $product)
        <div class="col-6 col-md-3 mb-3 product-card-difference">
            <a href="{{route('CheckSlugRoute', ['slug' => $product->slug])}}">
                <div class="product-category-square text-center">
                    @if($product->rating != null && $product->rating != 0)
                        <span class="product-category-square-rating">
                            <i class="fa fa-star text-warning"></i>&nbsp;{{$product->rating}}
                        </span>
                    @endif
                    <span class="product-category-square-img mt-2 mb-2">
                        <img src="{{asset('public/storage/products/' . $product->primary_img)}}"
                             alt="Phones"
                             class="img-fluid"/>
                    </span>
                    @if(floatval($product->discount) != 0)
                        <span class="product-category-square-discount bg-custom-primary text-white">
                            {{$product->discount}}% OFF
                        </span>
                    @endif
                    <p class="mb-2 pt-2 pl-1 pr-1 text-black fs-13 fw-500 primary-color productNameLineHeight">
                        {{$product->name}}
                    </p>
                    <p class="mb-2 pt-2 pl-1 pr-1 text-black fs-13 fw-500 productNameLineHeight">
                        {{$product->code}}
                    </p>
                    <p class="mb-1 pt-2 text-black fs-14">
                        {!! $product->short_description !!}
                    </p>
                    <table class="mt-1 mb-1 w-100 fs-12">
                        <tr>
                            <td style="width: 40%;">
                                @if($product->quantity > 0)
                                    <i class="fa fa-circle text-success"></i>&nbsp;In stock
                                @else
                                    <i class="fa fa-circle text-danger"></i>&nbsp;Stock out
                                @endif
                            </td>
                            <td class="text-end text-black fw-500" style="width: 60%;">
                                {!! \App\Helpers\SiteHelper::CalculatePrice($product->total_price) !!}
                            </td>
                        </tr>
                    </table>
                    @if(floatval($product->discount) != 0)
                        <p class="mb-2 mt-1 fs-11 text-end">
                            <span class="text-decoration-line-through">{!! \App\Helpers\SiteHelper::CalculatePrice($product->total_price_without_discount) !!}</span>
                        </p>
                    @else
                        <p class="mb-2 mt-1 fs-11 text-end">&nbsp;</p>
                    @endif
                    <div class="product-category-square-bottom" onclick="return event.preventDefault();">
                        <div class="row fs-12">
                            <div class="col-6 text-center px-1 py-2 product-category-square-btn border-right"
                                 id="addToCartDiv_{{$index}}{{$index1}}" style="display: none; cursor: not-allowed;">
                                Adding...
                            </div>
                            <div class="col-6 text-center px-1 py-2 product-category-square-btn border-right cursor-pointer"
                                 onclick="AddToCart(this, '{{$product->id}}', '{{$index}}{{$index1}}');">
                                Add to cart
                            </div>
                            <div class="col-6 text-center px-1 py-2 product-category-square-btn cursor-pointer bg-custom-primary text-white"
                                 onclick="AddToWishlist('Please login first to add product in your list.', '{{$product->id}}', this);">
                                Wishlisted
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else
    @foreach($Products as $index1 => $product)
        <div class="product-card-difference my-3">
            <a href="{{route('CheckSlugRoute', ['slug' => $product->slug])}}">
                <div class="product-category-square text-center">
                    @if($product->rating != null && $product->rating != 0)
                        <span class="product-category-square-rating">
                            <i class="fa fa-star text-warning"></i>&nbsp;{{$product->rating}}
                        </span>
                    @endif
                    @if(floatval($product->discount) != 0)
                        <span class="product-category-square-discount bg-custom-primary text-white">
                            {{$product->discount}}% OFF
                        </span>
                    @endif
                    <div class="product-category-square-img">
                        <img src="{{asset('public/storage/products/' . $product->primary_img)}}"
                             alt="Phones"
                             class="img-fluid"/>
                    </div>
                    <p class="mb-2 px-2 fs-13 fw-500 primary-color">
                        {{$product->name}}
                    </p>
                    <p class="mb-2 px-2 text-black fs-13 fw-500">
                        {{$product->code}}
                    </p>
                    <div class="product-description">
                        {!! $product->short_description !!}
                    </div>
                    <div class="mx-2 fs-12">
                        <p class="text-start mb-0">
                            @if($product->quantity > 0)
                                <i class="fa fa-circle text-success"></i>&nbsp;In stock
                            @else
                                <i class="fa fa-circle text-danger"></i>&nbsp;Stock out
                            @endif
                            <span class="text-end text-black fw-500 float-end">
                                {!! \App\Helpers\SiteHelper::CalculatePrice($product->total_price) !!}
                            </span>
                        </p>
                        @if(floatval($product->discount) != 0)
                            <p class="my-1 fs-11 text-decoration-line-through text-end">{!! \App\Helpers\SiteHelper::CalculatePrice($product->total_price_without_discount) !!}</p>
                        @else
                            <p class="my-1 fs-11 text-end">&nbsp;</p>
                        @endif
                    </div>
                    <div class="product-category-square-bottom" onclick="return event.preventDefault();">
                        <div class="row fs-12">
                            <div class="col-6 text-center py-2 product-category-square-btn border-right"
                                 id="addToCartDiv_{{$index}}{{$index1}}" style="display: none; cursor: not-allowed;">
                                Adding...
                            </div>
                            <div class="col-6 text-center py-2 product-category-square-btn border-right cursor-pointer"
                                 onclick="AddToCart(this, '{{$product->id}}', '{{$index}}{{$index1}}');">
                                Add to cart
                            </div>
                            <div class="col-6 text-center py-2 product-category-square-btn cursor-pointer <?php if (in_array($product->id, $List)) {
                                echo 'bg-custom-primary text-white';
                            } ?>"
                                 onclick="AddToWishlist('Please login first to add product in your list.', '{{$product->id}}', this);">
                                <?php if (in_array($product->id, $List)) {
                                    echo 'Wishlisted';
                                } else {
                                    echo 'Wishlist';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif
