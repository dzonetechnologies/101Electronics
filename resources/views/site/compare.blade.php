@extends('site.layouts.app')
@section('content')
    <style media="screen">
        /*.product-category-square {
            padding: 0 5px;
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
            border: 1px solid #e2e2e2;
            margin: auto;
        }
        .product-card-difference {
            !*padding-left: 2.5px;*!
            !*padding-right: 2.5px;*!
            padding-left: 0;
            padding-right: 0;
        }
        .product-category-square-rating {
            right: 0.5rem;
        }

        .product-category-square-discount {
            left: 0;
        }*/

        .quick-contact {
            background-color: #ffffff;
            -webkit-box-shadow: 0 0 20px 3px rgb(0 0 0 / 5%);
            box-shadow: 0 0 20px 3px rgb(0 0 0 / 5%);
            padding: 12px;
        }

        input:checked + .slider-sm:before {
            background-color: white;
            bottom: 4px;
            content: "";
            height: 10px;
            left: 4px;
            position: absolute;
            transition: .4s;
            width: 10px;
        }

        input:checked + .slider-sm {
            background-color: #C71738;
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
                        @foreach($SubCategories as $i => $sub)
                            <div class="m-auto mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="fs-14">{{$sub->title}}</span>
                                    <label class="switch-sm" for="checkboxSubCat{{$i}}" style="margin-left: auto;">
                                        <input type="radio" name="subCatFilter" id="checkboxSubCat{{$i}}"
                                               onchange="LoadSubSubCategory();ApplySubCategoryRunTimeFilters();"
                                               value="{{$sub->id}}" <?php if ($SelectedSubCategory != '') {
                                            if (intval($SelectedSubCategory) == $sub->id) {
                                                echo 'checked';
                                                $subcategoryslug = $sub->slug;
                                            } else {
                                                echo '';
                                            }
                                        } else {
                                            echo 'checked';
                                            $subcategoryslug = $sub->slug;
                                        } ?> />
                                        <div class="slider-sm round"></div>
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
                        <div class="m-auto mb-2">
                            <div class="d-flex align-items-center">
                                <span class="fs-14">All</span>
                                <label class="switch-sm" for="checkboxSubSubCat" style="margin-left: auto;">
                                    <input type="checkbox" id="checkboxSubSubCat" class="checkboxForSubSubCategory"
                                           name="subSubCatFilter[]"
                                           onchange="CheckForAllSubSubCategory(this.checked);ApplyRunTimeFilters();"
                                           value="0" <?php
                                        $SubSubCategoryCheck = true;
                                        if ($SelectedSubSubCategory == '') {
                                            $SubSubCategoryCheck = false;
                                            echo 'checked';
                                        } ?>
                                    />
                                    <div class="slider-sm round"></div>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="TotalSubSubCategoryCount" value="0">
                        <div class="w-100" id="subSubCategoryDiv">
                            @if($__SubSubCategories != null)
                                @foreach($__SubSubCategories as $index => $subSubCat)
                                    <div class="m-auto mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="fs-14">{{$subSubCat->title}}</span>
                                            <label class="switch-sm" for="subSubCatFilter{{$index}}"
                                                   style="margin-left: auto;">
                                                <input type="checkbox" class="checkboxForSubSubCategory"
                                                       name="subSubCatFilter[]" id="subSubCatFilter{{$index}}"
                                                       value="{{$subSubCat->id}}"
                                                       onchange="document.getElementById('checkboxSubSubCat').checked = false; AllSubSubCategoryChecker();ApplyRunTimeFilters();" <?php if ($SubSubCategoryCheck) {
                                                    if (in_array($subSubCat->id, explode(',', $SelectedSubSubCategory))) {
                                                        echo 'checked';
                                                    }
                                                } else {
                                                    echo 'checked';
                                                } ?> />
                                                <div class="slider-sm round"></div>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="quick-contact mb-3">
                        <p class="fs-large fw-600 text-custom-primary mb-2">
                            Brands
                        </p>
                        <hr class="mt-0 mb-2 opacity-75">
                        <?php
                        $_Brands = array();
                        if ($SelectedBrands != '') {
                            $_Brands = json_decode(base64_decode($SelectedBrands));
                        }
                        ?>
                        <div class="m-auto mb-2">
                            <div class="d-flex align-items-center">
                                <span class="fs-14">All ({{\App\Helpers\SiteHelper::GetProductsCountByBrand()}})</span>
                                <label class="switch-sm" for="checkboxBrands" style="margin-left: auto;">
                                    <input type="checkbox" id="checkboxBrands" class="checkboxForBrands"
                                           name="CheckboxBrands[]" value="0"
                                           <?php if ($SelectedBrands != '') {
                                               if (sizeof($_Brands) == 0) {
                                                   echo 'checked';
                                               } else {
                                                   echo '';
                                               }
                                           } else {
                                               echo 'checked';
                                           } ?> onchange="CheckForAllBrands(this.checked);ApplyRunTimeFilters();"/>
                                    <div class="slider-sm round"></div>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" id="TotalBrandsCount" value="{{sizeof($Brands)}}">
                        @foreach($Brands as $i => $brand)
                            <div class="m-auto mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="fs-14">{{$brand->title}} ({{\App\Helpers\SiteHelper::GetProductsCountByBrand($brand->id)}})</span>
                                    <label class="switch-sm" for="checkboxBrands{{$i}}" style="margin-left: auto;">
                                        <input type="checkbox" class="checkboxForBrands" name="CheckboxBrands[]"
                                               id="checkboxBrands{{$i}}" value="{{$brand->id}}"
                                               <?php if ($SelectedBrands != '') {
                                                   if (in_array($brand->id, $_Brands) > 0) {
                                                       echo 'checked';
                                                   } else {
                                                       echo '';
                                                   }
                                               } else {
                                                   echo 'checked';
                                               } ?> onchange="document.getElementById('checkboxBrands').checked = false; AllBrandsChecker();ApplyRunTimeFilters();"/>
                                        <div class="slider-sm round"></div>
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
                                       value="<?php if ($StartPrice == 0) {
                                           echo '1';
                                       } else {
                                           echo $StartPrice;
                                       } ?>" onkeypress="CheckNumberInputForQty(this, event, this.value);"/>
                            </div>
                            <div class="col-2 text-center d-flex align-items-center"><span class="w-100">-</span></div>
                            <div class="col-4">
                                <input type="text" class="form-control product-quantity-input mb-0 p-1" name="endRange"
                                       id="endRange" placeholder="To" onkeyup="ApplyRunTimeFilters();"
                                       value="<?php if ($EndPrice == 0) {
                                           echo '1000000';
                                       } else {
                                           echo $EndPrice;
                                       } ?>" onkeypress="CheckNumberInputForQty(this, event, this.value);"/>
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
                                <a href="{{url('/'. $Category[0]->slug .'/'. $subcategoryslug .'/'. $sub_subcategory->slug)}}" class="float-end">
                                    <label for="" class="form-check-label text-custom-primary cursor-pointer fs-14 float-right">
                                        See all deals <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </label>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="products-category-slider ltn__product-gallery-slider-compare slick-arrow-1">
                                <?php
                                $Products = array();
                                if ($StartPrice != 0 && $EndPrice != 0) {
                                    $Products = Illuminate\Support\Facades\DB::table('products')
                                        ->where('deleted_at', '=', null)
                                        ->where('category', '=', $Category[0]->id)
                                        ->where('sub_subcategory', '=', $sub_subcategory->id)
                                        ->where(function ($query) use ($_Brands, $SelectedSubCategory) {
                                            if (sizeof($_Brands) > 0) {
                                                $query->whereIn('products.brand', $_Brands);
                                            }
                                            if (intval($SelectedSubCategory) != 0) {
                                                $query->where('products.sub_category', $SelectedSubCategory);
                                            }
                                        })
                                        ->whereRaw(\Illuminate\Support\Facades\DB::raw('total_price >= ? AND total_price <= ?'), array($StartPrice, $EndPrice))
                                        ->orderBy('order_no', 'ASC')
                                        ->get();
                                } else {
                                    $Products = Illuminate\Support\Facades\DB::table('products')
                                        ->where('deleted_at', null)
                                        ->where('category', $Category[0]->id)
                                        ->where('sub_subcategory', $sub_subcategory->id)
                                        ->where(function ($query) use ($_Brands, $SelectedSubCategory) {
                                            if (sizeof($_Brands) > 0) {
                                                $query->whereIn('products.brand', $_Brands);
                                            }
                                            if (intval($SelectedSubCategory) != 0) {
                                                $query->where('products.sub_category', $SelectedSubCategory);
                                            }
                                        })
                                        ->orderBy('order_no', 'ASC')
                                        ->get();
                                }
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
