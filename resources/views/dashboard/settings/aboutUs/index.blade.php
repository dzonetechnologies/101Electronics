@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="settings-form">
        <div class="row">
            <div class="offset-md-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">About Us - Edit</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('settings.AboutUs.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="offset-md-1 col-md-10">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label  class="mb-1">Welcome To 101 Electronics</label>
                                            <textarea name="welcome_text" id="welcome_text"
                                                      rows="100" cols="80">{{$AboutUsDetails[0]->welcome_text}}</textarea>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Our Vision</label>
                                            <textarea name="vision_text" id="vision_text"
                                                      rows="8" cols="80">{{$AboutUsDetails[0]->vision}}</textarea>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Our Mission</label>
                                            <textarea class="form-control" name="mission_text" id="mission_text" rows="8" cols="80">{{$AboutUsDetails[0]->mission}}</textarea>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Our Values</label>
                                            <textarea class="form-control" name="values_text" id="values_text" rows="8" cols="80">{{$AboutUsDetails[0]->values}}</textarea>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Our Way Of Work</label>
                                            <textarea class="form-control" name="wayOfwork_text" id="wayOfwork_text" rows="8" cols="80">{{$AboutUsDetails[0]->way_of_work}}</textarea>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Pricing Promise</label>
                                            <textarea class="form-control" name="pricing_promise" id="pricing_promise" rows="8" cols="80">{{$AboutUsDetails[0]->pricing_promise}}</textarea>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Technical Experts</label>
                                            <textarea class="form-control" name="technical_experts" id="technical_experts" rows="8" cols="80">{{$AboutUsDetails[0]->technical_experts}}</textarea>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Client Support</label>
                                            <textarea class="form-control" name="client_support" id="client_support" rows="8" cols="80">{{$AboutUsDetails[0]->client_support}}</textarea>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Order Notification</label>
                                            <textarea class="form-control" name="order_notification" id="order_notification" rows="8" cols="80">{{$AboutUsDetails[0]->order_notification}}</textarea>
                                        </div>

                                        <div class="col-12 text-center">
                                            <button class="btn btn-outline-success" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection