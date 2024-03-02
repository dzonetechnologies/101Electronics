@extends('site.layouts.app')
@section('content')
<style media="screen">
.pageDescription > p{
  margin-bottom: 0em;
  font-size: 14px;
}
@media only screen and (max-width: 767px) {
    .w-h{
        width: 35%;
    }

}
@media only screen and (min-width: 992px) {
    .w-h{
        width: 25%;
    }
}
</style>
    <section>
        <div class="container">
            <div class="row mt-4 mb-5">
                <!-- Banner image -->
                @if(isset($PageDetails[0]->banner_img))
                <div class="col-md-12 mb-5 d-none d-md-block">
                  <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img)}}" width="100%" height="150" alt="Return & Cancellation Banner Image">
                </div>
                @endif
                @if(isset($PageDetails[0]->banner_img_mobile))
                    <div class="col-md-12 mb-5 d-md-none">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img_mobile)}}" width="100%" height="150" alt="Return & Cancellation Banner Image">
                    </div>
            @endif
                <!-- Content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-0 d-flex align-items-center fs-13 text-custom-primary">
                            <div class="w-h py-3 cursor-pointer text-center card-header-tabs-active" id="tab1">
                                Return & Cancellations
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="tab1Content">
                                <div class="row">
                                    <div class="col-12 mb-0">
                                        @if(session()->has('success-message'))
                                            <div class="alert alert-success">
                                                {!! session('success-message') !!}
                                            </div>
                                        @elseif(session()->has('error-message'))
                                            <div class="alert alert-danger">
                                                {!! session('error-message') !!}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 text-black text-left mt-3">
                                        <div class="pageDescription">
                                          {!! $PageDetails[0]->desc !!}
                                        </div>
                                    </div>
                                </div>
                                <h4 class="title-2" style="margin-top: 20px">Enter Details</h4>
                                <form id="contact-form" action="{{route('returnForm') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-item input-item-name ltn__custom-icon">
                                                <input type="text" name="name" placeholder="Enter your name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-email ltn__custom-icon">
                                                <input type="email" name="email" placeholder="Enter email address" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-phone ltn__custom-icon">
                                                <input type="text"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  name="phone" placeholder="Enter phone number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-subject ltn__custom-icon">
                                                <input type="text"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  name="order_no" placeholder="Enter Order No" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-item input-item-subject ltn__custom-icon">
                                                <input type="text"  onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  name="serial_no" placeholder="Enter Product Serial No" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-item input-item-textarea ltn__custom-icon">
                                        <textarea name="reason" placeholder="Enter Reason" required></textarea>
                                    </div>
                                    <!-- <p><label class="input-info-save mb-0"><input type="checkbox" name="agree"> Save my name, email, and website in this browser for the next time I comment.</label></p> -->
                                    <div class="btn-wrapper mt-0">
                                        <!-- <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit">Submit</button> -->
                                        <button class="btn btn-custom-primary text-uppercase fs-13" type="submit" >
                                            <i class="fas fa-paper-plane"></i>&nbsp;
                                            Submit
                                        </button>
                                    </div>
                                    <p class="form-messege mb-0 mt-20"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
