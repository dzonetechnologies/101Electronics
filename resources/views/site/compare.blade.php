@extends('site.layouts.app')
@section('content')
    <style type="text/css">
        input:checked + .slider-sm {
            background-color: #C71738;
        }

        input:checked + .slider-sm:before {
            background-color: white;
        }
    </style>
    <input type="hidden" id="UrlSlug" value="{{$slug}}">
    {{--Category With Products--}}
    <?php $subcategoryslug = "all"; ?>
    <section class="mb-4 mt-4">
        <div class="container-fluid">
            <div class="row">
                <!--<div class="col-md-1"></div>-->
                <div class="col-12 col-md-4 col-lg-3 col-xxl-2 mb-2">
                    <div class="quick-contact mb-3">
                        <p class="fs-large fw-600 text-custom-primary mb-2">
                            Sub Category
                        </p>
                        <hr class="mt-0 mb-2 opacity-75">
                        @foreach($Category[0]->subCategories as $i => $sub)
                            <div class="row align-items-center line-height-1-3 mb-2">
                                <div class="col-8">
                                    <div class="fs-13">{{$sub->title}}</div>
                                </div>
                                <div class="col-4 text-end">
                                    <label class="switch-sm" for="checkboxSubCat{{$i}}">
                                        <input type="radio" name="subCatFilter" id="checkboxSubCat{{$i}}"
                                               onchange="LoadSubSubCategory(); ApplySubCategoryRunTimeFilters();"
                                               value="{{$sub->id}}" @if($i == 0) checked @endif />
                                        <span class="slider-sm round"></span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="quick-contact mb-3">
                        <p class="fs-large fw-600 text-custom-primary mb-2">
                            Sub SubCategory
                        </p>
                        <hr class="mt-0 mb-2 opacity-75">
                        <div class="row align-items-center line-height-1-3 mb-2">
                            <div class="col-8">
                                <div class="fs-13">All</div>
                            </div>
                            <div class="col-4 text-end">
                                <label class="switch-sm" for="checkboxSubSubCat">
                                    <input type="checkbox" id="checkboxSubSubCat" class="checkboxForSubSubCategory"
                                           name="subSubCatFilter[]"
                                           onchange="CheckForAllSubSubCategory(this.checked); ApplyRunTimeFilters();"
                                           value="0" checked />
                                    <span class="slider-sm round"></span>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="TotalSubSubCategoryCount" value="0">
                        <div class="w-100" id="subSubCategoryDiv">
                            @foreach($SubSubCategories as $index => $subSubCat)
                                <div class="row align-items-center line-height-1-3 mb-2">
                                    <div class="col-8">
                                        <div class="fs-13">{{$subSubCat->title}}</div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <label class="switch-sm" for="subSubCatFilter{{$index}}">
                                            <input type="checkbox" class="checkboxForSubSubCategory"
                                                   name="subSubCatFilter[]" id="subSubCatFilter{{$index}}"
                                                   value="{{$subSubCat->id}}"
                                                   onchange="document.getElementById('checkboxSubSubCat').checked = false; AllSubSubCategoryChecker();ApplyRunTimeFilters();" checked />
                                            <span class="slider-sm round"></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="quick-contact mb-3">
                        <p class="fs-large fw-600 text-custom-primary mb-2">
                            Brands
                        </p>
                        <hr class="mt-0 mb-2 opacity-75">
                        <div class="row align-items-center line-height-1-3 mb-2">
                            <div class="col-8">
                                <div class="fs-13">All ({{\App\Helpers\SiteHelper::GetProductsCountByBrand()}})</div>
                            </div>
                            <div class="col-4 text-end">
                                <label class="switch-sm" for="checkboxBrands">
                                    <input type="checkbox" id="checkboxBrands" class="checkboxForBrands"
                                           name="CheckboxBrands[]" value="0"
                                           onchange="CheckForAllBrands(this.checked);ApplyRunTimeFilters();" checked />
                                    <span class="slider-sm round"></span>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="TotalBrandsCount" value="{{sizeof($Brands)}}">
                        @foreach($Brands as $i => $brand)
                            <div class="row align-items-center line-height-1-3 mb-2">
                                <div class="col-8">
                                    <div class="fs-13">{{$brand->title}} ({{\App\Helpers\SiteHelper::GetProductsCountByBrand($brand->id)}})</div>
                                </div>
                                <div class="col-4 text-end">
                                    <label class="switch-sm" for="checkboxBrands{{$i}}">
                                        <input type="checkbox" class="checkboxForBrands" name="CheckboxBrands[]"
                                               id="checkboxBrands{{$i}}" value="{{$brand->id}}"
                                               onchange="document.getElementById('checkboxBrands').checked = false; AllBrandsChecker();ApplyRunTimeFilters();" checked />
                                        <span class="slider-sm round"></span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="quick-contact mb-3">
                        <p class="fs-large fw-600 text-custom-primary mb-2">
                            Price Range ({{\App\Helpers\SiteHelper::$Currency}})
                        </p>
                        <hr class="mt-0 mb-2 opacity-75">
                        <div class="row ltn__no-gutter mb-2">
                            <div class="col-1"></div>
                            <div class="col-4">
                                <input type="text" class="form-control product-quantity-input mb-0 p-1"
                                       name="startRange"
                                       id="startRange" placeholder="From" onkeyup="ApplyRunTimeFilters();"
                                       value="{{$StartPrice}}" onkeypress="CheckNumberInputForQty(this, event, this.value);"/>
                            </div>
                            <div class="col-2 text-center d-flex align-items-center"><span class="w-100">-</span></div>
                            <div class="col-4">
                                <input type="text" class="form-control product-quantity-input mb-0 p-1" name="endRange"
                                       id="endRange" placeholder="To" onkeyup="ApplyRunTimeFilters();"
                                       value="{{$EndPrice}}" onkeypress="CheckNumberInputForQty(this, event, this.value);"/>
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </div>
                    {{--<button class="btn btn-custom-primary w-100 fs-13 mt-2" type="button" onclick="ApplyFilters();">
                        <i class="fas fa-check"></i>&nbsp;
                        Apply
                    </button>--}}
                </div>
                <div class="col-12 col-md-8 col-lg-9 col-xxl-10" id="RecordSections">
                    @foreach($SubSubCategories as $index => $sub_subcategory)
                        <div class="row line-height-1-3 mb-2">
                            <div class="col-7 col-sm-8">
                                <h2 class="section-title text-custom-primary fs-15 mb-2">
                                    {{$sub_subcategory->title}}
                                </h2>
                            </div>
                            <div class="col-5 col-sm-4">
                                <a href="{{ route('home.slug', ['slug1' => $Category[0]->slug, 'slug2' => $sub_subcategory->SubCatSlug, 'slug3' => $sub_subcategory->slug2]) }}" class="float-end"> {{-- url('/'. $Category[0]->slug .'/'. $subcategoryslug .'/'. $sub_subcategory->slug) --}}
                                    <label for="" class="form-check-label text-custom-primary cursor-pointer fs-14 float-right">
                                        See all deals <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </label>
                                </a>
                            </div>
                            {{-- Products --}}
                            <div class="col-12">
                                <div class="products-category-slider ltn__product-gallery-slider-compare slick-arrow-1">
                                    <?php
                                    $Products = array();
                                    $Products = Illuminate\Support\Facades\DB::table('products')
                                        ->where('deleted_at', '=', null)
                                        ->where('category', '=', $Category[0]->id)
                                        ->where('sub_subcategory', '=', $sub_subcategory->id)
                                        ->where(function ($query) use ($SubCategoryId) {
                                            if (intval($SubCategoryId) != 0) {
                                                $query->where('products.sub_category', $SubCategoryId);
                                            }
                                        })
                                        ->whereRaw(\Illuminate\Support\Facades\DB::raw('total_price >= ? AND total_price <= ?'), array($StartPrice, $EndPrice))
                                        ->orderBy('order_no', 'ASC')
                                        ->get();
                                    $List = \App\Helpers\SiteHelper::GetUserList();
                                    $ComparePage = true;
                                    ?>
                                    @foreach($Products as $index1 => $product)
                                        {!! \App\Helpers\SiteHelper::GetProductTemplate($product, $index, $index1, $List) !!}
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
