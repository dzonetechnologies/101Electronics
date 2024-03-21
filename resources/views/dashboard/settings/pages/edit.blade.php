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
                                            <label class="w-100" for="meta_title">Meta
                                                Title</label>
                                            <input type="text" class="form-control" name="meta_title"
                                                      id="meta_title" value="{{ $PageDetails[0]->meta_title }}" placeholder="Enter Meta Title">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="w-100" for="meta_description">Meta
                                                Description</label>
                                            <textarea class="form-control" name="meta_description"
                                                      id="meta_description" rows="8" placeholder="Enter Meta Description">{{ $PageDetails[0]->meta_description }}</textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="w-100" for="page_link">Page Link</label>
                                            <input type="text" class="form-control" name="page_link"
                                                   id="page_link" value="{{ $PageDetails[0]->page_link }}" placeholder="Enter Page Link">
                                        </div>
                                        @if(!empty($PageDetails[0]->desc))
                                        <div class="col-12 mb-3">
                                              <label class="w-100" for="product_short_description">Page
                                                  Description</label>
                                              <textarea name="page_description"
                                                        id="product_short_description" rows="8"
                                                        cols="80">{{$PageDetails[0]->desc}}</textarea>
                                        </div>
                                        @endif
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
