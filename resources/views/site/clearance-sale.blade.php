@extends('site.layouts.app')
@section('content')
    <section class="mb-5">
        <div class="container">
            <div class="row justify-content-center ">
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
                <div class="col-12 col-12 mb-4 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        Clearance Sale
                    </span>
                </div>
                @php
                    $Products = Illuminate\Support\Facades\DB::table('products')
                              ->where('deleted_at', null)
                              ->where('clearance_sale', 1)
                              ->orderBy('order_no', 'ASC')
                              ->get();
                  $List = \App\Helpers\SiteHelper::GetUserList();
                  $index = 0;
                @endphp
                @foreach($Products as $index1 => $product)
                    {!! \App\Helpers\SiteHelper::GetProductTemplate($product, $index, $index1, $List) !!}
                @endforeach
            </div>
        </div>
    </section>
@endsection
