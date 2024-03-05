@extends('site.layouts.app')
@section('content')
    <section class="mb-5">
        <div class="container">
            <div class="row justify-content-center mt-4 mb-5">
                <!-- Banner image -->
                @if(isset($PageDetails[0]->banner_img))
                    <div class="col-12">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img)}}" width="100%"
                             height="150" alt="See all deals Banner Image">
                    </div>
                @endif
                <div class="col-12 mb-4 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        {{$Category[0]->title}}
                    </span>
                </div>
                {{-- Products --}}
                @php
                    $List = \App\Helpers\SiteHelper::GetUserList();
                    $index = 0
                @endphp
                @foreach($Products as $index1 => $product)
                    {!! \App\Helpers\SiteHelper::GetProductTemplate($product, $index, $index1, $List) !!}
                @endforeach
            </div>
        </div>
    </section>
    <script type="text/javascript">
        let ProductCard = document.getElementsByClassName("product-card-difference");
        if(typeof ProductCard !== "undefined") {
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
