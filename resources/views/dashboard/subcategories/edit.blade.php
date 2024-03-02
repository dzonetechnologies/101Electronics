@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="product-subcategories">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">SubCategory - Edit</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('subcategories');
                                ?>
                                <button type="button" class="btn btn-primary float-right"
                                        onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subcategories.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{$SubCategory[0]->id}}">
                            <input type="hidden" name="slug" id="slug" value="{{$SubCategory[0]->slug}}">
                            <div class="row">
                                <div class="offset-md-2 col-md-8">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="title" class="mb-1">Title</label>
                                            <input type="text" placeholder="Title" id="title"
                                                   name="title" class="form-control" value="{{$SubCategory[0]->title}}"
                                                   onchange="EditCheckForDuplicateTitle(this.value, 'subcategories');"
                                                   maxlength="100" required>
                                            <div class="errorHandling pt-2" id="titleError"></div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="metaTitle" class="mb-1">Meta Title</label>
                                            <input type="text" placeholder="Meta Title" id="metaTitle" name="metaTitle"
                                                   class="form-control" value="{{$SubCategory[0]->meta_title}}"
                                                   maxlength="100" required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="description" class="mb-1">Meta Description</label>
                                            <textarea type="text" id="description" name="description"
                                                      class="form-control" rows="5"
                                                      maxlength="1000">{{$SubCategory[0]->description}}</textarea>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="category" class="mb-1">Category</label>
                                            <select id="category" name="category" class="form-control select2"
                                                    onchange="LoadCategoryBrand(this.value);" required>
                                                <option value="">Select</option>
                                                @foreach($Categories as $index => $category)
                                                    @if($category->id == $SubCategory[0]->category)
                                                        <option value="{{$category->id}}"
                                                                selected>{{$category->title}}</option>
                                                    @else
                                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        @php
                                            $CategoryBrands = explode(",",$CategoryDetails[0]->brand);
                                            $SubCategoryBrands = explode(",",$SubCategory[0]->brand);
                                        @endphp

                                        <div class="col-12 mb-3">
                                            <label for="brand" class="mb-1">Brands</label>
                                            <select class="form-control select2" name="brand[]" id="brand" multiple
                                                    required>
                                                <option value="" disabled>Select Brand</option>
                                                @foreach ($brands as $key => $value)
                                                    @if(in_array($value->id,$CategoryBrands))
                                                        <option value="{{$value->id}}" <?php if (in_array($value->id, $SubCategoryBrands)) {
                                                            echo "selected";
                                                        } ?>>{{$value->title}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
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