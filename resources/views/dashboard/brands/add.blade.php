@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="product-brands">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Brands - Create</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('brands');
                                ?>
                                <button type="button" class="btn btn-primary float-right" onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="slug" id="slug">
                            <div class="row">
                                <div class="offset-md-2 col-md-8">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="name" class="mb-1">Title</label>
                                            <input type="text" placeholder="Title" id="name"
                                                   name="name" class="form-control" maxlength="100"
                                                   onkeyup="CheckForDuplicateTitle(this.value, 'brands');"
                                                   onblur="CheckForDuplicateTitle(this.value, 'brands');"
                                                   required>
                                            <div class="errorHandling pt-2" id="titleError"></div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="b2b" class="mb-1">Type</label>
                                            <select class="form-control select2" name="type" id="type">
                                              <option value="" selected disabled>Select</option>
                                              <option value="0">Imported</option>
                                              <option value="1">Chinese</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="b2b" class="mb-1">B2B</label>
                                            <select class="form-control select2" name="b2b" id="b2b">
                                              <option value="" disabled>Select</option>
                                              <option value="1">Yes</option>
                                              <option value="0" selected>No</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="metaTitle" class="mb-1">Meta Title</label>
                                            <input type="text" placeholder="Meta Title" id="metaTitle" name="metaTitle"
                                                   class="form-control" maxlength="100" required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="description" class="mb-1">Meta Description</label>
                                            <textarea type="text" id="description" name="description"
                                                      class="form-control" rows="5" maxlength="1000"></textarea>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="logo" class="mb-1">Logo</label>
                                            <div class="upload_image_box">
                                                <img src="{{asset('public/assets/images/placeholder.jpg')}}"
                                                     alt="Brand Logo"
                                                     id="previewImg"
                                                     style="width: 100%;
                                                     max-height: 100%;
                                                     object-fit: cover;" />
                                                <input type="file"
                                                       style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100%; height: 100%; cursor: pointer;'
                                                       name="logo"
                                                       id="logo"
                                                       accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG"
                                                       required/>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center">
                                            <button class="btn btn-outline-success" type="submit" id="saveProducts">Save</button>
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
