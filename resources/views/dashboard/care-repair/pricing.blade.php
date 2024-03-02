@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="settings-form">
        <div class="row">
            <div class="offset-md-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Pricing - Edit</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('CareRepair.pricing.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                <div class="offset-md-1 col-md-10">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label  class="mb-1">Description</label>
                                            <textarea name="pricing_description" id="pricing_description"
                                                      rows="100" cols="80">{{$PricingDetails[0]->description}}</textarea>
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