@extends('site.layouts.app')
@section('content')
<style media="screen">
.WhyChooseUs{
  border-radius: 10px
}
.team-avatar-rounded{
  border-radius: 50%;
  width: 100px;
  height: auto;
}
.facebookIcon{
  color: #0b7aea;
}
.linkedinIcon{
  color: #0b66c2;
}
.instagramIcon{
  color: #be4371;
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
                    <h2 class="text-center">Welcome To 101 Electronics</h2>
                    <p style="text-align:justify;">
                    {!! $AboutUsDetails[0]->welcome_text  !!}
                    </p>
                </div>
                <div class="col-md-12">
                  <!-- OUR VISION AND OUR MISSION - START -->
                  <div class="ltn__feature-area pt-20 pb-20 mb-20---">
                      <div class="container">
                          <div class="row ltn__custom-gutter--- justify-content-center">
                              <div class="col-lg-6 col-sm-6 col-12" style="display:flex;">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white box-shadow-1">
                                      <div class="ltn__feature-icon">
                                          <span><i class="fa fa-eye text-custom-primary"></i></span>
                                      </div>
                                      <div class="ltn__feature-info" >
                                          <h4>Our Vision</h4>
                                          <p style="text-align:justify;">{!! $AboutUsDetails[0]->vision  !!}</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6 col-sm-6 col-12" style="display:flex;" >
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white box-shadow-1">
                                      <div class="ltn__feature-icon">
                                          <span><i class="fa fa-bullseye text-custom-primary"></i></span>
                                      </div>
                                      <div class="ltn__feature-info" >
                                          <h4>Our Mission</h4>
                                          <p style="text-align:justify;">{!! $AboutUsDetails[0]->mission  !!} </p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- OUR VISION AND OUR MISSION - END -->
                </div>
                <!-- WHY CHOOSE US - START -->
                <div class="col-md-12">
                    <h3 class="text-center">Why Choose 101 Electronics </h3>
                    <!--<p class="text-center">We belive in values</p>-->
                </div>
                <div class="col-md-12">
                  <div class="ltn__feature-area pt-20 pb-20 mb-20---">
                      <div class="container">
                          <div class="row ltn__custom-gutter--- justify-content-center">
                              <div class="col-lg-4 col-sm-6 col-12" style="display:flex;">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white box-shadow-1 WhyChooseUs">
                                      <div class="ltn__feature-info">
                                          <h4>Our Values</h4>
                                          <p style="text-align:justify;">{!! $AboutUsDetails[0]->values  !!}
                                          </p>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-lg-4 col-sm-6 col-12" style="display:flex;">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white box-shadow-1 WhyChooseUs">
                                      <div class="ltn__feature-info">
                                          <h4>Our Way Of Work</h4>
                                          <p style="text-align:justify;">
                                              {!! $AboutUsDetails[0]->way_of_work  !!}
                                          </p>
                                          <br>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-lg-4 col-sm-6 col-12" style="display:flex;">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white box-shadow-1 WhyChooseUs">
                                      <div class="ltn__feature-info">
                                          <h4>Pricing Promise</h4>
                                          <p style="text-align:justify;">{!! $AboutUsDetails[0]->pricing_promise  !!}
                                          </p>
                                          <br>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-lg-4 col-sm-6 col-12" style="display:flex;">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white box-shadow-1 WhyChooseUs">
                                      <div class="ltn__feature-info">
                                          <h4>Technical Experts</h4>
                                          <p style="text-align:justify;">{!! $AboutUsDetails[0]->technical_experts  !!}
                                          </p>
                                          <br>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-lg-4 col-sm-6 col-12" style="display:flex;">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white box-shadow-1 WhyChooseUs">
                                      <div class="ltn__feature-info">
                                          <h4>Client Support</h4>
                                          <p style="text-align:justify;">{!! $AboutUsDetails[0]->client_support  !!}
                                          </p>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-lg-4 col-sm-6 col-12" style="display:flex;">
                                  <div class="ltn__feature-item ltn__feature-item-6 text-center bg-white box-shadow-1 WhyChooseUs">
                                      <div class="ltn__feature-info">
                                        <h4>Order Notifications</h4>
                                        <p style="text-align:justify;"> {!! $AboutUsDetails[0]->order_notification  !!}.
                                        </p>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>
                </div>
                <!-- WHY CHOOSE US - END -->

                <!-- OUR TEAM - START -->
                <!--<div class="col-md-12">-->
                <!--    <h3 class="text-center">OUR TEAM</h3>-->
                <!--</div>-->
                <!--<div class="col-md-12">-->
                <!--    <div class="row">-->
                        <!-- MEMBER 1 -->
                <!--        <div class="col-lg-3 col-sm-6 col-12">-->
                <!--            <div class="text-center">-->
                <!--              <img src="{{asset('public/storage/team/member1.jpg')}}" class="team-avatar-rounded img-fluid" alt="Team Member Profile Picture">-->
                <!--            </div>-->
                <!--            <div>-->
                <!--              <h6 class="pt-3 mb-2">NABEEL SALEH</h6>-->
                <!--              <p class="mb-3">SALES TEAM LEAD</p>-->
                <!--            </div>-->
                <!--            <div class="ml-2">-->
                <!--              <a href="#"><i class="fab fa-facebook facebookIcon pr-3"></i></a>-->
                <!--              <a href="#"><i class="fab fa-linkedin linkedinIcon pr-3"></i></a>-->
                <!--              <a href="#"><i class="fab fa-instagram instagramIcon"></i></a>-->
                <!--            </div>-->
                <!--            <div>-->
                <!--              <p class="mt-2">Add team member description here. Remove the text if not necessary.</p>-->
                <!--            </div>-->
                <!--        </div>-->
                        <!-- MEMBER 1 -->

                        <!-- MEMBER 2 -->
                <!--        <div class="col-lg-3 col-sm-6 col-12">-->
                <!--            <div class="text-center">-->
                <!--              <img src="{{asset('public/storage/team/member1.jpg')}}" class="team-avatar-rounded img-fluid" alt="Team Member Profile Picture">-->
                <!--            </div>-->
                <!--            <div>-->
                <!--              <h6 class="pt-3 mb-2">AMMMAD HASSAN</h6>-->
                <!--              <p class="mb-3">MARKETING MANAGER</p>-->
                <!--            </div>-->
                <!--            <div class="ml-2">-->
                <!--              <a href="#"><i class="fab fa-facebook facebookIcon pr-3"></i></a>-->
                <!--              <a href="#"><i class="fab fa-linkedin linkedinIcon pr-3"></i></a>-->
                <!--              <a href="#"><i class="fab fa-instagram instagramIcon"></i></a>-->
                <!--            </div>-->
                <!--            <div>-->
                <!--              <p class="mt-2">Add team member description here. Remove the text if not necessary.</p>-->
                <!--            </div>-->
                <!--        </div>-->
                        <!-- MEMBER 2 -->

                        <!-- MEMBER 3 -->
                <!--        <div class="col-lg-3 col-sm-6 col-12">-->
                <!--            <div class="text-center">-->
                <!--              <img src="{{asset('public/storage/team/member1.jpg')}}" class="team-avatar-rounded img-fluid" alt="Team Member Profile Picture">-->
                <!--            </div>-->
                <!--            <div>-->
                <!--              <h6 class="pt-3 mb-2">MUHAMMAD FAIZAN</h6>-->
                <!--              <p class="mb-3">GRAPHIC DESIGNER</p>-->
                <!--            </div>-->
                <!--            <div class="ml-2">-->
                <!--              <a href="#"><i class="fab fa-facebook facebookIcon pr-3"></i></a>-->
                <!--              <a href="#"><i class="fab fa-linkedin linkedinIcon pr-3"></i></a>-->
                <!--              <a href="#"><i class="fab fa-instagram instagramIcon"></i></a>-->
                <!--            </div>-->
                <!--            <div>-->
                <!--              <p class="mt-2">Add team member description here. Remove the text if not necessary.</p>-->
                <!--            </div>-->
                <!--        </div>-->
                        <!-- MEMBER 3 -->

                        <!-- MEMBER 4 -->
                <!--        <div class="col-lg-3 col-sm-6 col-12">-->
                <!--            <div class="text-center">-->
                <!--              <img src="{{asset('public/storage/team/member1.jpg')}}" class="team-avatar-rounded img-fluid" alt="Team Member Profile Picture">-->
                <!--            </div>-->
                <!--            <div>-->
                <!--              <h6 class="pt-3 mb-2">ADEEL AMIR</h6>-->
                <!--              <p class="mb-3">TECHNICAL HEAD</p>-->
                <!--            </div>-->
                <!--            <div class="ml-2">-->
                <!--              <a href="#"><i class="fab fa-facebook facebookIcon pr-3"></i></a>-->
                <!--              <a href="#"><i class="fab fa-linkedin linkedinIcon pr-3"></i></a>-->
                <!--              <a href="#"><i class="fab fa-instagram instagramIcon"></i></a>-->
                <!--            </div>-->
                <!--            <div>-->
                <!--              <p class="mt-2">Add team member description here. Remove the text if not necessary.</p>-->
                <!--            </div>-->
                <!--        </div>-->
                        <!-- MEMBER 4 -->
                <!--    </div>-->
                <!--</div>-->
                <!-- OUR TEAM - END -->
            </div>
        </div>
    </section>
@endsection
