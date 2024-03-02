@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="product-subcategories">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">SubCategory - Create</h4>
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
                        <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="slug" id="slug">
                            <div class="row">
                                <div class="offset-md-2 col-md-8">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="title" class="mb-1">Title</label>
                                            <input type="text" placeholder="Title" id="title"
                                                   name="title" class="form-control" maxlength="100"
                                                   onkeyup="CheckForDuplicateTitle(this.value, 'subcategories');"
                                                   onblur="CheckForDuplicateTitle(this.value, 'subcategories');"
                                                   required>
                                            <div class="errorHandling pt-2" id="titleError"></div>
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
                                            <label for="category" class="mb-1">Category</label>
                                            <select id="category" name="category" class="form-control select2"
                                                    onchange="LoadCategoryBrand(this.value);" required>
                                                <option value="" selected>Select</option>
                                                @foreach($Categories as $index => $category)
                                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3" id="_brandBlock" style="display:none;">
                                            <label for="brand" class="mb-1">Brands</label>
                                            <select class="form-control select2" name="brand[]" id="brand" multiple
                                                    required>

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
