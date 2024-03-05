@extends('site.layouts.app')
@section('content')
    <?php $Products = []; ?>
    <section class="mb-5">
        <div class="container">
            <div class="row justify-content-center">
                @if(isset($PageDetails[0]->banner_img))
                    <div class="col-12 mb-5 d-none d-md-block">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img)}}" width="100%"
                             height="150" alt="Price Promise Banner Image">
                    </div>
                @endif
                @if(isset($PageDetails[0]->banner_img_mobile))
                    <div class="col-12 mb-5 d-md-none">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img_mobile)}}"
                             width="100%" height="150" alt="Price Promise Banner Image">
                    </div>
                @endif
                <div class="col-12 col-md-12 mb-4 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        {{$SubSubCategoryName}}
                    </span>
                </div>
                {{-- Products --}}
                @if($subcategoryslug != "all")
                    @php
                        $Products = Illuminate\Support\Facades\DB::table('products')
                                    ->where('deleted_at', null)
                                    ->where('category', $Category[0]->id)
                                    ->where('sub_category', $SubCategories[0]->id)
                                    ->where('sub_subcategory', $SubSubCategoryId)
                                    ->orderBy('order_no', 'ASC')
                                    ->get();
                        $List = \App\Helpers\SiteHelper::GetUserList();
                        $index = 0;
                    @endphp
                @else
                    @php
                        $Products = Illuminate\Support\Facades\DB::table('products')
                                    ->where('deleted_at', null)
                                    ->where('category', $Category[0]->id)
                                    ->where('sub_subcategory', $SubSubCategoryId)
                                    ->orderBy('order_no', 'ASC')
                                    ->get();
                        $List = \App\Helpers\SiteHelper::GetUserList();
                        $index = 0;
                    @endphp
                @endif
                @foreach($Products as $index1 => $product)
                    {!! \App\Helpers\SiteHelper::GetProductTemplate($product, $index, $index1, $List) !!}
                @endforeach
            </div>
        </div>
    </section>
    <script type="text/javascript">
        let ProductCard = document.getElementsByClassName("product-card-difference");
        if (typeof ProductCard !== "undefined") {
            for (let i = 0; i < ProductCard.length; i++) {
                ProductCard[i].classList.add("col-8");
                ProductCard[i].classList.add("col-sm-4");
                ProductCard[i].classList.add("col-md-4");
                ProductCard[i].classList.add("col-lg-3");
                ProductCard[i].classList.add("col-xl-2");
            }
        }
    </script>
@endsection
