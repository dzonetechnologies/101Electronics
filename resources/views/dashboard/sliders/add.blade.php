@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="product-brands">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Sliders - Create</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('sliders');
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
                        <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="offset-md-1 col-md-10">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="type" class="mb-1">Slider Page</label>
                                            <select class="form-control select2" name="page" id="page" onchange="checkSliderPage(this.value);">
                                                <option value="">Select</option>
                                                <option value="home">Home</option>
                                                <option value="brands">Brands</option>
                                                <option value="b2b">b2b</option>
                                            </select>
                                        </div>
                                         <div class="col-12 mb-3">
                                            <label for="type" class="mb-1">Screen</label>
                                            <select class="form-control select2" name="screen" id="screen">
                                                <option value="">Select</option>
                                                <option value="Desktop">Desktop</option>
                                                <option value="Mobile">Mobile</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3" id="BrandsBlock" style="display:none;">
                                            <label for="type" class="mb-1">Brand</label>
                                            <select class="form-control" name="brand" id="brand">
                                                <option value="">Select</option>
                                                <?php
                                                  foreach ($Brands as $key => $brand) {
                                                    echo "<option value='". $brand->id ."'>". $brand->title ."</option>";
                                                  }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="type" class="mb-1">Slider Type</label>
                                            <select class="form-control select2" name="type" id="type" onchange="checkSliderType(this.value);" required>
                                                <option value="">Select</option>
                                                <option value="image">Image</option>
                                                <option value="video">Video</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="type" class="mb-1">Link</label>
                                            <input type="text" class="form-control" name="link" id="link">
                                        </div>

                                        <div class="col-12 mb-3" id="SliderImageBlock" style="display:none;">
                                            <label for="logo" class="mb-1">Image</label>
                                            <div class="upload_image_box">
                                                <img src="{{asset('public/assets/images/placeholder.jpg')}}"
                                                     alt="Slider Image"
                                                     id="previewImg"
                                                     style="width: 100%;
                                                     max-height: 100%;
                                                     object-fit: cover;" />
                                                <input type="file"
                                                       style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100%; height: 100%; cursor: pointer;'
                                                       name="slider_image"
                                                       id="logo"
                                                       accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG,.webp,.WEBP" />
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3" id="SliderVideoBlock" style="display:none;">
                                            <label for="slider_video" class="mb-1">Video</label>
                                            <input type="file"
                                                    class="form-control"
                                                   name="slider_video"
                                                   id="slider_video"
                                                   accept="video/*"/>
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
