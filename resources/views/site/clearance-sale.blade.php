@extends('site.layouts.app')
@section('content')
    <?php $Products = array(); ?>
    <section class="mb-5">
        <div class="container">
            <div class="row">
                @if(isset($PageDetails[0]->banner_img))
                    <div class="col-md-12 mb-5 d-none d-md-block">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img)}}" width="100%" height="150" alt="Price Promise Banner Image">
                    </div>
                @endif
                @if(isset($PageDetails[0]->banner_img_mobile))
                    <div class="col-md-12 mb-5 d-md-none">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img_mobile)}}" width="100%" height="150" alt="Price Promise Banner Image">
                    </div>
                @endif
                <div class="col-12 col-md-12 mb-5 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        <h2 class="form-title">Clearance Sale</h2>
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
            <!-- Product - Start -->
            @include('site.partials.product-template')
            <!-- Product - End -->
            </div>
        </div>
    </section>
@endsection
