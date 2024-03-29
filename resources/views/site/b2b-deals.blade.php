@extends('site.layouts.app')
@section('content')
    {{--Slider Section--}}
    @php
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'b2b' )->where('screen', 'Desktop' )->orderBy('order_no', 'ASC')->get();
    @endphp
    <section class="mb-0 d-none d-md-block">
        <div class="container-fluid">
            <div class="row main-slider">
                {{-- Slide --}}
                @foreach($Sliders as $slider)
                    @if($slider->type == "image")
                        <div class="col-md-12"
                             style="background: url('{{asset('public/storage/sliders/' . $slider->slide)}}') no-repeat center center; background-size: cover;padding-left: 0px; padding-right: 0px;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <div class="mt-5 mb-5" style="padding-top: 270px;"></div>
                                    </div>
                                    <div class="col-md-8"></div>
                                </div>
                            </div>
                        </div>
                    @elseif($slider->type == "video")
                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                            <video width="100%" height="360" autoplay controls muted>
                                <source src="{{asset('public/storage/sliders/' . $slider->slide)}}" type="video/mp4">
                                <source src="{{asset('public/storage/sliders/' . $slider->slide)}}" type="video/ogg">
                                Your browser does not support HTML video.
                            </video>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!--For Mobile-->
    @php
        $Sliders = Illuminate\Support\Facades\DB::table('sliders')->where('page', 'b2b')->where('screen', 'Mobile' )->orderBy('order_no', 'ASC')->get();
    @endphp
    <section class="mb-0 d-md-none">
        <div class="container-fluid">
            <div class="row main-slider">
                @foreach($Sliders as $slider)
                    @if($slider->type == "image")
                        <img src="{{asset('public/storage/sliders/' . $slider->slide)}}"/>
                    @elseif($slider->type == "video")
                        <div class="col-12" style="padding-left: 0px; padding-right: 0px;">
                            <video width="100%" height="360" autoplay controls muted>
                                <source src="{{asset('public/storage/sliders/' . $slider->slide)}}" type="video/mp4">
                                <source src="{{asset('public/storage/sliders/' . $slider->slide)}}" type="video/ogg">
                                Your browser does not support HTML video.
                            </video>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    {{--Slider Section--}}

    <section class="mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 mb-4 text-center">
                    <span class="section-title text-custom-primary text-center mb-0 heading-underline">
                        {{ucwords($Type)}} Appliances
                    </span>
                </div>
                {{-- Products --}}
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
