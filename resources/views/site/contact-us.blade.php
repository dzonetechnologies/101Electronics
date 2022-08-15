@extends('site.layouts.app')
@section('content')
<style media="screen">
.contactUsFormSetting{
  margin-bottom: 6rem;
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
                <!-- Contact Us Details -->
                <div class="col-md-12">
                    <h3 class="text-center">Contact Us</h3>
                </div>
                <div class="col-md-12">
                  <!-- FEATURE AREA START ( Feature - 6) -->
                  <div class="ltn__feature-area pt-20 pb-20 mb-20---">
                      <div class="container">
                          <div class="row ltn__custom-gutter--- justify-content-center">
                              <div class="col-lg-4 col-sm-6 col-12">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white  box-shadow-1">
                                      <div class="ltn__feature-icon">
                                          <span><i class="flaticon-phone-call text-custom-primary"></i></span>
                                      </div>
                                      <div class="ltn__feature-info">
                                          <h3><a href="tel:0325-101-101-9">Call Us</a></h3>
                                          <p>0325-101-101-9</p>
                                          <br>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-4 col-sm-6 col-12">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white  box-shadow-1 active">
                                      <div class="ltn__feature-icon">
                                          <span><i class="icon-mail text-custom-primary"></i></span>
                                      </div>
                                      <div class="ltn__feature-info">
                                          <h3><a href="mailto:info@101electronics.com">Email</a></h3>
                                          <p>info@101electronics.com</p>
                                          <br>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-4 col-sm-6 col-12">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white  box-shadow-1 active">
                                      <div class="ltn__feature-icon">
                                          <span><i class="flaticon-pin text-custom-primary"></i></span>
                                      </div>
                                      <div class="ltn__feature-info">
                                          <h3><a href="">Find Us</a></h3>
                                          <p>925C-Molana Shoukat Ali Road Lahore, Punjab. Pakistan</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- FEATURE AREA END -->
                </div>
                <div class="col-md-12">
                    <h3 class="text-center">Leave us a Little info, and we'll be in touch.</h3>
                </div>
                <div class="col-md-12 contactUsFormSetting">
                  <!-- CONTACT MESSAGE AREA START -->
                  <div class="ltn__contact-message-area mb-120 mb--100">
                      <div class="container">
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="ltn__form-box contact-form-box box-shadow white-bg">
                                      <h4 class="title-2">Get In Touch</h4>
                                      <form id="contact-form" action="{{ url('contact_email') }}" method="post">
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
                                                      <input type="text" name="phone" placeholder="Enter phone number" required>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="input-item input-item-subject ltn__custom-icon">
                                                      <input type="text" name="subject" placeholder="Enter subject" required>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="input-item input-item-textarea ltn__custom-icon">
                                              <textarea name="message" placeholder="Enter message" required></textarea>
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
                  <!-- CONTACT MESSAGE AREA END -->
                </div>
            </div>
        </div>
    </section>
@endsection
