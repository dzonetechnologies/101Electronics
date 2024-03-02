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
                                $Url = route('settings.banners');
                                ?>
                                <button type="button" class="btn btn-primary float-right"
                                        data-toggle="tooltip" title="Back"
                                        onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                    $PageBannerImage = asset('public/assets/images/placeholder.jpg');
                    if ($PageDetails[0]->banner_img != "") {
                        $PageBannerImage = asset('public/storage/page-banners/' . $PageDetails[0]->banner_img);
                    }
                    ?>
                    <div class="card-body">
                        <form action="{{ route('settings.banners.update') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{$PageId}}">
                            <input type="hidden" name="oldPageBannerImage" value="{{$PageDetails[0]->banner_img}}">
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
                                        <div class="offset-md-1 col-md-10">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="logo" class="mb-1">Desktop Banner</label>
                                                    <div class="upload_image_box">
                                                        <img src="{{$PageBannerImage}}"
                                                             alt="Page Banner Image"
                                                             id="previewImg"
                                                             style="width: 100%;
                                                             max-height: 100%;
                                                             object-fit: cover;"/>
                                                        <input type="file"
                                                               style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100px; height: 100px; cursor: pointer;'
                                                               name="banner"
                                                               id="logo"
                                                               accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG,.webp,.WEBP"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--Mobile Banner--}}
                                    <?php
                                    $PageBannerImageMobile = asset('public/assets/images/placeholder.jpg');
                                    if ($PageDetails[0]->banner_img_mobile != "") {
                                        $PageBannerImageMobile = asset('public/storage/page-banners/' . $PageDetails[0]->banner_img_mobile);
                                    }
                                    ?>
                                    <input type="hidden" name="page_id" value="{{$PageId}}">
                                    <input type="hidden" name="oldPageBannerImageMobile"
                                           value="{{$PageDetails[0]->banner_img_mobile}}">
                                    <div class="row">
                                        <div class="offset-md-1 col-md-10">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="logo_mob" class="mb-1">Mobile Banner</label>
                                                    <div class="upload_image_box">
                                                        <img src="{{$PageBannerImageMobile}}"
                                                             alt="Page Banner Image"
                                                             id="previewImgmobile"
                                                             style="width: 100%;
                                                                     max-height: 100%;
                                                                     object-fit: cover;"/>
                                                        <input type="file"
                                                               style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100px; height: 100px; cursor: pointer;'
                                                               name="banner_mobile"
                                                               id="logo_mob"
                                                               accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG,.webp,.WEBP"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center">
                                                    <button class="btn btn-outline-success" type="submit">Save</button>
                                                </div>
                                            </div>
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
