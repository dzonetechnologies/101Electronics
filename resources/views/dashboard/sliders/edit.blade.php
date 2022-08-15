@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="edit-slider-page">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                   <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Sliders - Edit</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('sliders');
                                ?>
                                <button type="button" class="btn btn-primary float-right" onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('slider.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{$Slider[0]->id}}">
                            <input type="hidden" name="oldSlideType" id="oldSlideType" value="{{$Slider[0]->type}}">
                            <input type="hidden" name="oldSlide" id="oldSlide" value="{{$Slider[0]->slide}}">

                            <div class="row">
                                <div class="offset-md-2 col-md-8">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="type" class="mb-1">link</label>
                                            <input class="form-control" type="text" name="link" id="link" value="{{$Slider[0]->link}}">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="type" class="mb-1">Slider Type</label>
                                            <select class="form-control select2" name="type" id="type" onchange="checkSliderType(this.value);">
                                                <option value="">Select</option>
                                                <option value="image" <?php if($Slider[0]->type == "image"){echo "selected";} ?>>Image</option>
                                                <option value="video" <?php if($Slider[0]->type == "video"){echo "selected";} ?>>Video</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3" id="SliderImageBlock" <?php if($Slider[0]->type != "image"){echo "style='display:none;'";} ?>>
                                            <label for="logo" class="mb-1">Image</label>
                                            <div class="upload_image_box">
                                                @if($Slider[0]->type == "image")
                                                <img src="{{asset('public/storage/sliders') . '/' . $Slider[0]->slide}}"
                                                     alt="Slider Image"
                                                     id="previewImg"
                                                     style="width: 100%;
                                                     max-height: 100%;
                                                     object-fit: cover;" />
                                                @else
                                                <img src="{{asset('public/assets/images/placeholder.jpg')}}"
                                                     alt="Slider Image"
                                                     id="previewImg"
                                                     style="width: 100%;
                                                     max-height: 100%;
                                                     object-fit: cover;" />
                                                @endif
                                                <input type="file"
                                                       style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100%; height: 100%; cursor: pointer;'
                                                       name="slider_image"
                                                       id="logo"
                                                       accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG"/>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3" id="SliderVideoBlock" <?php if($Slider[0]->type != "video"){echo "style='display:none;'";} ?>>
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
