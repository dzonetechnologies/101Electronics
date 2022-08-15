@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="product-categories">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Category - Edit</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('categories');
                                ?>
                                <button type="button" class="btn btn-primary float-right"
                                        onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{$Category[0]->id}}">
                            <input type="hidden" name="oldLogo" id="oldLogo" value="{{$Category[0]->icon}}">
                            <input type="hidden" name="slug" id="slug" value="{{$Category[0]->slug}}">

                            <div class="row">
                                <div class="offset-md-2 col-md-8">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="title" class="mb-1">Title</label>
                                            <input type="text" placeholder="Title" id="title"
                                                   name="title" class="form-control" value="{{$Category[0]->title}}"
                                                   onchange="EditCheckForDuplicateTitle(this.value, 'categories');"
                                                   maxlength="100" required>
                                            <div class="errorHandling pt-2" id="titleError"></div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="metaTitle" class="mb-1">Meta Title</label>
                                            <input type="text" placeholder="Meta Title" id="metaTitle" name="metaTitle"
                                                   class="form-control" value="{{$Category[0]->meta_title}}"
                                                   maxlength="100" required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="description" class="mb-1">Meta Description</label>
                                            <textarea type="text" id="description" name="description"
                                                      class="form-control" rows="5"
                                                      maxlength="1000">{{$Category[0]->description}}</textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="homepage_selling_tagline" class="mb-1">Homepage Selling Tagline</label>
                                            <input type="text" class="form-control" name="homepage_selling_tagline" id="homepage_selling_tagline" value="{{$Category[0]->homepage_selling_tagline}}" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="brandpage_selling_tagline" class="mb-1">Brand Page Selling Tagline</label>
                                            <input type="text" class="form-control" name="brandpage_selling_tagline" id="brandpage_selling_tagline" value="{{$Category[0]->brandpage_selling_tagline}}" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="categorypage_selling_tagline" class="mb-1">Category Page Selling Tagline</label>
                                            <input type="text" class="form-control" name="categorypage_selling_tagline" id="categorypage_selling_tagline" value="{{$Category[0]->categorypage_selling_tagline}}"/>
                                        </div>

                                        @php
                                            $CategoryBrands = explode(",",$Category[0]->brand);
                                        @endphp

                                        <div class="col-12 mb-3">
                                            <label for="brand" class="mb-1">Brands</label>
                                            <select class="form-control select2" name="brand[]" id="brand" multiple
                                                    required>
                                                <option value="" disabled>Select Brand</option>
                                                @foreach ($brands as $key => $value)
                                                    <option value="{{$value->id}}" <?php if (in_array($value->id, $CategoryBrands)) {
                                                        echo "selected";
                                                    } ?>>{{$value->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="logo" class="mb-1">Icon</label>
                                            <div class="upload_image_box">
                                                <img src="{{asset('public/storage/categories') . '/' . $Category[0]->icon}}"
                                                     alt="Category Logo"
                                                     id="previewImg"
                                                     style="width: 100%;
                                                     max-height: 100%;
                                                     object-fit: cover;"/>
                                                <input type="file"
                                                       style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100%; height: 100%; cursor: pointer;'
                                                       name="logo"
                                                       id="logo"
                                                       accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG"/>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center">
                                            <button class="btn btn-outline-success" type="submit" id="saveProducts">
                                                Save
                                            </button>
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