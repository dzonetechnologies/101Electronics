@extends('site.layouts.app')
@section('content')
    {{--Shop by Category Section--}}
    <?php $subcategoryslug = "all"; ?>
    <section class="mb-4 mt-4 d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center" style="line-height: 3;">
                    @if($SubCategoryId == "")
                        <?php $subcategoryslug = "all"; ?>
                        <a href="{{route('CheckSlugRoute', ['slug' => $Category[0]->slug])}}"
                           class="activeSubCategoryBlock">
                            ALL
                        </a>
                    @else
                        <a href="{{route('CheckSlugRoute', ['slug' => $Category[0]->slug])}}" class="subCategoryBlock">
                            ALL
                        </a>
                    @endif

                    @foreach($SubCategories as $subcategory)
                        @if($SubCategoryId != "" && $SubCategoryId == $subcategory->id)
                            <?php $subcategoryslug = $subcategory->slug; ?>
                            <a href="{{route('CheckSlugRoute', ['slug' => $subcategory->slug])}}"
                               class="activeSubCategoryBlock">
                                {{$subcategory->title}}
                            </a>
                        @else
                            <a href="{{route('CheckSlugRoute', ['slug' => $subcategory->slug])}}"
                               class="subCategoryBlock">
                                {{$subcategory->title}}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!--For Mobile-->
    <section class="mb-4 mt-4 d-md-none">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center" style="line-height: 3;">
                    @if($SubCategoryId == "")
                        <?php $subcategoryslug = "all"; ?>
                        <a href="{{route('CheckSlugRoute', ['slug' => $Category[0]->slug])}}"
                           class="activeSubCategoryBlock">
                            ALL
                        </a>
                    @else
                        <a href="{{route('CheckSlugRoute', ['slug' => $Category[0]->slug])}}" class="subCategoryBlock">
                            ALL
                        </a>
                    @endif

                    @foreach($SubCategories as $subcategory)
                        @if($SubCategoryId != "" && $SubCategoryId == $subcategory->id)
                            <?php $subcategoryslug = $subcategory->slug; ?>
                            <a href="{{route('CheckSlugRoute', ['slug' => $subcategory->slug])}}"
                               class="activeSubCategoryBlock">
                                {{$subcategory->title}}
                            </a>
                        @else
                            <a href="{{route('CheckSlugRoute', ['slug' => $subcategory->slug])}}"
                               class="subCategoryBlock">
                                {{$subcategory->title}}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{--Shop by Category Section--}}

    {{--Category With Products--}}
    @foreach($SubSubCategories as $i => $sub_subcategory)
        <?php
        $FirstSubCategoryId = 0;
        if ($SubCategoryId == "") {
            $GetFirstSubCategory = \Illuminate\Support\Facades\DB::table('subcategories')
                ->where('category', '=', $Category[0]->id)
                ->where('deleted_at', '=', null)
                ->orderBy('order_no', 'ASC')
                ->get();
            if (count($GetFirstSubCategory) > 0) {
                $FirstSubCategoryId = $GetFirstSubCategory[0]->id;
            }
        } else {
            $FirstSubCategoryId = $SubCategoryId;
        }
        $CompareUrl = route('CompareRoute', ['slug' => $Category[0]->slug]) . '?sub=' . $FirstSubCategoryId . '&subSub=&range=1_1000000&brands=';
        $Products = [];
        ?>
        <section class="mb-5">
            <div class="container">
                <div class="row line-height-1-3 mb-2">
                    <div class="col-7 col-sm-8">
                        <h2 class="section-title text-custom-primary fs-15 mb-2">
                            {{$Category[0]->categorypage_selling_tagline}} {{$sub_subcategory->title}}
                        </h2>
                    </div>
                    <div class="col-5 col-sm-4">
                        <a href="{{ url('/'. $Category[0]->slug .'/'. $subcategoryslug .'/'. $sub_subcategory->slug) }}">
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
                            @if($subcategoryslug != "all" && $SubCategoryId != "")
                                @php
                                    $Products = Illuminate\Support\Facades\DB::table('products')
                                                ->where('deleted_at', null)
                                                ->where('category', $Category[0]->id)
                                                ->where('sub_category', $SubCategoryId)
                                                ->where('sub_subcategory', $sub_subcategory->id)
                                                ->orderBy('order_no', 'ASC')
                                                ->get();
                                    $List = \App\Helpers\SiteHelper::GetUserList();
                                    $index = $i;
                                @endphp
                            @else
                                @php
                                    $Products = Illuminate\Support\Facades\DB::table('products')
                                                ->where('deleted_at', null)
                                                ->where('category', $Category[0]->id)
                                                ->where('sub_subcategory', $sub_subcategory->id)
                                                ->orderBy('order_no', 'ASC')
                                                ->get();
                                    $List = \App\Helpers\SiteHelper::GetUserList();
                                    $index = $i;
                                @endphp
                            @endif
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
