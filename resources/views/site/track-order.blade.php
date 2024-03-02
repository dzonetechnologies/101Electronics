@extends('site.layouts.app')
@section('content')
    <section class="mb-5">
        <div class="container">
            <div class="row mt-4 mb-5">
                <!-- Banner image -->
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center text-custom-primary"><u>Track Order</u></h3>
                </div>

                <div class="offset-md-3 col-md-6 mt-4">
                    <div class="input-group">
                        <input type="text" class="form-control border-custom-primary mb-0" name="trackOrder" id="trackOrder" placeholder="Invoice No" onkeyup="if(event.keyCode === 13) { SearchOrderForTracking(); }">
                        <div class="input-group-append">
                            <button class="btn btn-custom-primary" type="button" onclick="SearchOrderForTracking();">Search</button>
                        </div>
                    </div>
                </div>

                <div class="offset-md-2 col-md-8 mt-5" id="trackOrderPage" style="display: none;"></div>
            </div>
        </div>
    </section>
@endsection
