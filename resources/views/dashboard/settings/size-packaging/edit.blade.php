@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="settings-form">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Size and Packaging - Edit</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('settings.SizePackagingRoute');
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
                    $SizePackagingImage = asset('public/storage/size-packaging/placeholder.jpg');

                    if ($SizePackagingDetails[0]->image != "") {
                        $SizePackagingImage = asset('public/storage/size-packaging/' . $SizePackagingDetails[0]->image);
                    }
                    ?>
                    <div class="card-body">
                        <form action="{{ route('settings.size-packaging.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="oldSizePackagingImage" value="{{$SizePackagingDetails[0]->image}}">
                            <input type="hidden" name="category_id" value="{{$CategoryId}}">
                            <div class="row">
                                <div class="offset-md-1 col-md-10">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="logo" class="mb-1">Size and Packaging</label>
                                            <div class="upload_image_box">
                                                <?php if ($SizePackagingImage != ""): ?>

                                                    <img src="{{$SizePackagingImage}}"
                                                     alt="Size and Packaging Image"
                                                     id="previewImg"
                                                     style="width: 100%;
                                                     max-height: 100%;
                                                     object-fit: cover;" />
                                                     
                                                <?php endif ?>
                                                
                                                <input type="file"
                                                       style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100px; height: 100px; cursor: pointer;'
                                                       name="size_packaging_image"
                                                       id="logo"
                                                       accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG,.webp,.WEBP" />
                                            </div>
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
