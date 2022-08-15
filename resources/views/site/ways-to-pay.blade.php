@extends('site.layouts.app')
@section('content')
<style media="screen">
.pageDescription > p{
  margin-bottom: 0em;
  font-size: 14px;
}
</style>
    <section>
        <div class="container">
            <div class="row mt-4 mb-5">
                <!-- Banner image -->
                @if(isset($PageDetails[0]->banner_img))
                <div class="col-md-12 mb-5 d-none d-md-block">
                  <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img)}}" width="100%" height="150" alt="Way to Pay Banner Image">
                </div>
                @endif
                @if(isset($PageDetails[0]->banner_img_mobile))
                    <div class="col-md-12 mb-5 d-md-none">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img_mobile)}}" width="100%" height="150" alt="Way to Pay Banner Image">
                    </div>
                @endif
                <!-- Content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-0 d-flex align-items-center fs-13 text-custom-primary">
                            <div class="w-25 py-3 cursor-pointer text-center card-header-tabs-active" id="tab1">
                                Ways To Pay
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="tab1Content">
                                <div class="row">
                                    {{--<div class="col-md-12 text-custom-primary text-center fs-11">
                                        Explore these pages
                                    </div>
                                    <div class="col-md-12 text-center fs-14 mb-3">
                                        <a href="{{route('CareRepairRoute')}}"><span class="text-custom-primary">What's Care & Repair</span></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{route('CareRepairRoute')}}"><span class="text-custom-primary">What's Included</span></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{route('TermsConditionsRoute')}}"><span class="text-custom-primary">Terms & Conditions</span></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{route('CareRepairRoute')}}"><span class="text-custom-primary">Why Care & Repair FAQs</span></a>
                                    </div>
                                    <div class="col-md-12 text-black text-center fs-large">
                                        Ways To Pay Guides
                                    </div>--}}
                                    <div class="col-md-12 text-black text-left mt-3">
                                        <div class="pageDescription">
                                          {!! $PageDetails[0]->desc !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
