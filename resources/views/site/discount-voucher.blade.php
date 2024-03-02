@extends('site.layouts.app')
@section('content')
<style media="screen">
.pageDescription > p{
  margin-bottom: 0em;
  font-size: 14px;
}
@media only screen and (max-width: 767px) {
    .w-h{
        width: 39%;
        margin-left: 10px;
    }

    .fs {
        font-size: 15px;
    }
    .quiz-img {
        height: 150px;
        /*margin-left: 25%;*/
    }
    .discount-quiz {
        color: #C71837;
    }

    .ml-15 {
        margin-left: 20%;
    }

    .m-l-20 {
        margin-left: 20px;
    }

}
@media only screen and (min-width: 992px) {
    .w-h{
        width: 25%;

    }

    .quiz-img {
        height: 200px;
        /*margin-left: 40%;*/
    }

    .ml-15 {
        margin-left: 35%;
    }

    .discount-quiz {
        color: #C71837;
    }

    .fs {
        font-size: 20px;
    }

    .m-l-20 {
        margin-left: 20px;
    }
}
</style>
    <section>
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
                <!-- Content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-0 d-flex align-items-center fs-13 text-custom-primary">
                            <div class="w-h py-3 cursor-pointer text-center card-header-tabs-active" id="tab1">
                                Discount Vouchers
                            </div>
                        </div>
                        <p class="m-l-20 mt-4"><strong><i class="fa fa-question-circle fa-1x" aria-hidden="true"></i> Get Your Instant Discount By Submit Answers</strong></p>
                        @php
                            $TotalQuestions = Illuminate\Support\Facades\DB::table('discount_questions')
                                ->where('deleted_at', null)
                                ->count();
                        @endphp
                        <input type="hidden" name="total_questions" id="total_questions" value="{{$TotalQuestions}}">
                        <div id="quiz_div">
                            @foreach($DiscountQuestions as $index => $value)
                                <div class="col-md-12 mb-2">
                                    <p class="mb-1"><strong>{{$index+1}}) {{$value->question}}</strong></p>
                                </div>
                                <div class="col-md-12">
                                        <input type="hidden" name="answer" id="answer_{{$index}}" value="{{$value->answer}}">

                                    <input type="radio" name="choice_{{$index}}" id="_choice_1_{{$index}}" value="1" style="margin-left: -6px;">
                                        <label for="_choice_1_{{$index}}"> {{$value->choice1}}</label><br>
                                    <input type="radio"  name="choice_{{$index}}" id="_choice_2_{{$index}}" value="2">
                                        <label for="_choice_2_{{$index}}"> {{$value->choice2}}</label><br>
                                    <input type="radio"  name="choice_{{$index}}" id="_choice_3_{{$index}}" value="3">
                                        <label for="_choice_3_{{$index}}"> {{$value->choice3}}</label><br>
                                    <input type="radio"  name="choice_{{$index}}" id="_choice_4_{{$index}}" value="4">
                                        <label for="_choice_4_{{$index}}"> {{$value->choice4}}</label><br>
                                </div>
                            @endforeach
                        </div>
                        {{--Success Message--}}
                        <div  id="message" class="text-center" style="display: none">
                            <img src="{{asset('public/assets/images/quiz/win.jpeg')}}"
                                 class="img-fluid quiz-img" />
                            <p class="mt-3 mb-0 fs"><strong>Congratulations! You won the quiz</strong></p>
                            <p class="discount-quiz fs">Discount code: <strong id="discount_code"></strong></p>
                        </div>
                        {{--Lose Message--}}
                        <div  id="message_lose" class="text-center" style="display: none">
                            <img src="{{asset('public/assets/images/quiz/lost.jpeg')}}"
                                 class="img-fluid quiz-img" />
                            <p class="mt-3 mb-0 discount-quiz fs"><strong onclick="window.location.reload()">Your answers are incorrect. Try Again.</strong></p>
                        </div>
                        <div class="col-md-12 text-center mt-3 mb-3">
                            <button id="submit_btn"  class="btn btn-custom-primary-b2b fs-15" onclick="quizCalculation()">Submit</button>
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
                                        Discount Voucher Guides
                                    </div>--}}
                                    <div class="col-md-12 text-black text-left mt-3">
                                        <div class="pageDescription">
                                          {!! $PageDetails[0]->desc !!}
                                          @foreach($DiscountVouchers as $voucher)
                                          <div class="mini-cart-item clearfix">
                                              <div class="mini-cart-info">
                                                  <h6>{{$voucher->title}}</h6>
                                                  <div class="voucherDesc">
                                                    {!! $voucher->desc !!}
                                                  </div>
                                              </div>
                                          </div>
                                          @endforeach
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
