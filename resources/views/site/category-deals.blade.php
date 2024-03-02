@extends('site.layouts.app')
@section('content')
    <section class="mb-5">
        <div class="container">
            <div class="row mt-4 mb-5">
                <!-- Banner image -->
                @if(isset($PageDetails[0]->banner_img))
                    <div class="col-md-12">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img)}}" width="100%"
                             height="150" alt="See all deals Banner Image">
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12 col-md-12 mb-5 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        {{$Category[0]->title}}
                    </span>
                </div>
            @php
                $List = \App\Helpers\SiteHelper::GetUserList();
                $index = 0
            @endphp
            <!-- Product - Start -->
            @include('site.partials.product-template')
            <!-- Product - End -->
            </div>
        </div>
    </section>
@endsection
