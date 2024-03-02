@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="settings-pages-edit-form">
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">GeneralSettings - Page ({{$PageDetails[0]->page_name}})</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('settings.pages');
                                ?>
                                <button type="button" class="btn btn-primary float-right"
                                        data-toggle="tooltip" title="Back"
                                        onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settings.pages.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{$PageId}}">
                            <div class="row">
                                <div class="offset-md-1 col-md-10">
                                    @if(session()->has('success-message'))
                                        <div class="alert alert-success">
                                            {!! session('success-message') !!}
                                        </div>
                                    @elseif(session()->has('error-message'))
                                        <div class="alert alert-danger">
                                            {!! session('error-message') !!}
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                              <label class="w-100" for="product_short_description">Page
                                                  Description</label>
                                              <textarea name="page_description"
                                                        id="product_short_description" rows="8"
                                                        cols="80">{{$PageDetails[0]->desc}}</textarea>
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
