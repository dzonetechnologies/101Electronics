@extends('dashboard.layouts.app')
@section('content')
    <style media="screen">
        .select2-container {
            box-sizing: border-box;
            display: block;
            margin: 0;
            position: relative;
            vertical-align: middle;
        }

        .checkBoxLabel {
            padding-top: 2px;
        }

        .form-check .form-check-label {
            min-height: 18px;
            display: block;
            margin-left: 0rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* Toggle radion button - Start */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        /* Toggle radio button - End */
    </style>
    <div class="page-content" id="product-add">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Product - Create</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('product');
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
                        <div class="row">
                            <div class="col-12 mb-0" id="alertDiv" style="display: none;" >
                                <div class="alert alert-danger" id="formValidationAlert" data-dismiss-toggle="X" >
                                </div>
                            </div>
                        </div>
                        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data"
                              name="addProductForm" id="addProductForm">
                            @csrf
                            <input type="hidden" name="slug" id="slug">
                            <!-- Start of Tabs Row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs nav-tabs-bottom" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="general-tab"
                                               data-toggle="tab" href="#general" role="tab" aria-controls="general"
                                               aria-selected="true">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="primary-desc-tab" data-toggle="tab"
                                               href="#description" role="tab" aria-controls="description"
                                               aria-selected="false">Description</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="primary-image-tab" data-toggle="tab"
                                               href="#primary-image" role="tab" aria-controls="primary-image"
                                               aria-selected="false">Image</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="video-tab" data-toggle="tab"
                                               href="#video" role="tab" aria-controls="video"
                                               aria-selected="false">Video</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="meta-details-tab" data-toggle="tab"
                                               href="#meta-details" role="tab" aria-controls="meta-details"
                                               aria-selected="false">Meta Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="customer-choice-tab" data-toggle="tab"
                                               href="#customer-choice" role="tab" aria-controls="customer-choice"
                                               aria-selected="false">Customer Choice</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="price-tab" data-toggle="tab"
                                               href="#price" role="tab" aria-controls="price"
                                               aria-selected="false">Price</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="shipping-info-tab" data-toggle="tab"
                                               href="#shipping-info" role="tab" aria-controls="shipping-info"
                                               aria-selected="false">Shipping Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="delivery-return-tab" data-toggle="tab"
                                               href="#delivery-return" role="tab" aria-controls="delivery-return"
                                               aria-selected="false">Delivery & Return</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="tab-content pt-0" id="myTabContent">
                                        <!-- General Tab -->
                                        <div class="tab-pane fade show active" id="general" role="tabpanel"
                                             aria-labelledby="general-tab">
                                            <div class="row pb-2">
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_name">Product Name</label>
                                                    <input type="text" name="product_name" id="product_name"
                                                           class="form-control" placeholder="Product Name"
                                                           onchange="CheckForDuplicateTitle(this.value, 'products');"
                                                           onblur="CheckForDuplicateTitle(this.value, 'products');"
                                                           required/>
                                                    <div class="errorHandling pt-2" id="titleError"></div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_code">Product Code</label>
                                                    <input max="100" type="text" name="product_code" id="product_code"
                                                           class="form-control" placeholder="Product Code"
                                                           required/>
                                                    <div class="errorHandling pt-2" id="titleError"></div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="category">Category</label>
                                                    <select class="form-control select2" name="category" id="category"
                                                            onchange="GetProductSubcategoriesFromCategories(this.value);" required>
                                                        <option value="">Select</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="subcategory">Sub Category</label>
                                                    <select class="form-control select2" name="subcategory"
                                                            id="subcategory"
                                                            onchange="GetProductSubSubcategoriesFromSubCategory(this.value);"
                                                            required>
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="sub-subcategory">Sub-SubCategory</label>
                                                    <select class="form-control select2" name="sub-subcategory"
                                                            id="sub-subcategory"
                                                            onchange="LoadSubSubCategoryBrand(this.value);" required>
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="brand">Brand</label>
                                                    <select class="form-control select2" name="brand" id="brand"
                                                            required>
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_clearance_sale">Clearance
                                                        Sale</label>
                                                    <select class="form-control select2" name="product_clearance_sale"
                                                            id="product_clearance_sale" required>
                                                        <option value="" disabled>Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0" selected>No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_rating">Product Rating</label>
                                                    <input type="number" name="product_rating" id="product_rating"
                                                           class="form-control" placeholder="5 star" min="0"
                                                           step="any"/>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_review">Product Reviews</label>
                                                    <input type="number" name="product_review" id="product_review"
                                                           class="form-control" placeholder="No. of reviews" min="0"
                                                           step="any"/>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline pt-0">
                                                        <input class="form-check-input" type="checkbox"
                                                               id="product_installment_calculator"
                                                               name="product_installment_calculator" value="1" checked>
                                                        <label class="form-check-label"
                                                               for="product_installment_calculator">Installment
                                                            Calculator</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description Tab -->
                                        <div class="tab-pane fade" id="description" role="tabpanel"
                                             aria-labelledby="description-tab">
                                            <div class="row">
                                                <!-- Short Image -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="w-100" for="product_short_description">Short
                                                        Description</label>
                                                    <textarea name="product_short_description"
                                                              id="product_short_description" rows="8"
                                                              cols="80"></textarea>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="w-100" for="product_compare_description">Compare
                                                        Description</label>
                                                    <textarea name="product_compare_description"
                                                              id="product_compare_description" rows="8"
                                                              cols="80"></textarea>
                                                </div>
                                                <!-- Long Image -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="w-100" for="product_description">Long
                                                        Description</label>
                                                    <textarea name="product_description" id="product_description"
                                                              rows="8" cols="80"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Primary Image Tab -->
                                        <div class="tab-pane fade" id="primary-image" role="tabpanel"
                                             aria-labelledby="primary-image-tab">
                                            <!-- Primary Image -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="mb-2">Primary Image</h5>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row" id="primaryImage"></div>
                                                </div>
                                            </div>

                                            <!-- Gallery Image -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="mb-2">Gallery</h5>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row" id="galleryImages"></div>
                                                </div>
                                            </div>

                                            <!-- Size and Packaging Image -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="mb-2">Size and Packaging Details</h5>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row" id="size_packaging_Images"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Video Tab -->
                                        <div class="tab-pane fade" id="video" role="tabpanel"
                                             aria-labelledby="video-tab">
                                            <div class="row pb-2">
                                                <div class="col-md-6 mb-3">
                                                    <label class="w-100" for="product_video_link">Video Link</label>
                                                    <input type="text" name="product_video_link" id="product_video_link"
                                                           class="form-control" placeholder="https://www.youtube.com/"/>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="w-100" for="product_video_file">Video</label>
                                                    <input type="file" name="product_video_file" id="product_video_file"
                                                           class="form-control" accept="video/*"/>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Meta Details Tab -->
                                        <div class="tab-pane fade" id="meta-details" role="tabpanel"
                                             aria-labelledby="meta-details-tab">
                                            <div class="row pb-2">
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_meta_title">Meta Title</label>
                                                    <input type="text" name="product_meta_title" id="product_meta_title"
                                                           class="form-control" placeholder="Title"/>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="w-100" for="product_meta_desc">Meta
                                                        Description</label>
                                                    <input type="text" name="product_meta_desc" id="product_meta_desc"
                                                           class="form-control" placeholder="Description"/>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_meta_tags">Meta Tags</label>
                                                    <input type="text" name="product_meta_tags" id="product_meta_tags"
                                                           class="form-control" placeholder=""/>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="mb-2">Meta Image</label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row" id="metaImage"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Customer Choice Tab -->
                                        <div class="tab-pane fade" id="customer-choice" role="tabpanel"
                                             aria-labelledby="customer-choice-tab">
                                            <div class="row pb-2">

                                                <!-- Color Variants -->
                                                <div class="col-md-12">
                                                    <h4>Colors</h4>
                                                </div>

                                                {{--<div class="col-md-3 mt-4 mb-3">
                                                    <label class="w-100" for="product_color">Color Variants</label>
                                                    <select class="form-control select2" name="product_color[]"
                                                            id="product_color" multiple>
                                                        <option value="" disabled>Select</option>
                                                        @foreach ($colors as $key => $value)
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-9"></div>--}}

                                                <div class="col-md-6 mt-4 mb-3">
                                                    <div class="repeater-custom-show-hide">
                                                        <div data-repeater-list="productColors">
                                                            <div data-repeater-item="" style="" class="mb-2">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-6 mb-3 mt-3">
                                                                                        <label class="w-100" for="product_color">Color Variant</label>
                                                                                        <select class="form-control select2" name="product_color"
                                                                                                id="product_color">
                                                                                            <option value="" selected disabled>Select</option>
                                                                                            @foreach ($colors as $key => $value)
                                                                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6 mb-3 mt-3">
                                                                                        <label class="w-100">Image</label>
                                                                                        <input type="file"
                                                                                               name="product_color_image"
                                                                                               class="form-control"
                                                                                               accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG,.webp,.WEBP" />
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <span data-repeater-delete=""
                                                                                              class="btn btn-outline-danger btn-sm float-right deletePayeeBtn">
                                                                                            <span class="far fa-trash-alt mr-1"></span>&nbsp;
                                                                                            Delete
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <div class="col-sm-12">
                                                                <span data-repeater-create=""
                                                                      class="btn btn-outline-success btn-sm float-right">
                                                                    <span class="fa fa-plus"></span>&nbsp;
                                                                    Add
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Size -->
                                                <div class="col-md-12 mt-2">
                                                    <h4>Size</h4>
                                                </div>

                                                <div class="col-md-6 mt-4 mb-3">
                                                    <div class="repeater-custom-show-hide">
                                                        <div data-repeater-list="sizes">
                                                            <div data-repeater-item="" style="" class="mb-2">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-3 mb-3 mt-3">
                                                                                        <label class="w-100">Unit</label>
                                                                                        <select class="form-control select2"
                                                                                                name="size_unit">
                                                                                            <option value="" disabled>
                                                                                                Select
                                                                                            </option>
                                                                                            @foreach($units as $unit)
                                                                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3 mt-3">
                                                                                        <label class="w-100">Height</label>
                                                                                        <input type="number"
                                                                                               name="size_height"
                                                                                               step="any"
                                                                                               class="form-control"
                                                                                               placeholder="Height"
                                                                                               autocomplete="off"/>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3 mt-3">
                                                                                        <label class="w-100">Width</label>
                                                                                        <input type="number"
                                                                                               name="size_width"
                                                                                               step="any"
                                                                                               class="form-control"
                                                                                               placeholder="Width"
                                                                                               autocomplete="off"/>
                                                                                    </div>
                                                                                    <div class="col-md-3 mb-3 mt-3">
                                                                                        <label class="w-100">Depth</label>
                                                                                        <input type="number"
                                                                                               name="size_depth"
                                                                                               step="any"
                                                                                               class="form-control"
                                                                                               placeholder="Depth"
                                                                                               autocomplete="off"/>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <span data-repeater-delete=""
                                                                                              class="btn btn-outline-danger btn-sm float-right deletePayeeBtn">
                                                                                            <span class="far fa-trash-alt mr-1"></span>&nbsp;
                                                                                            Delete
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <div class="col-sm-12">
                                                                <span data-repeater-create=""
                                                                      class="btn btn-outline-success btn-sm float-right">
                                                                    <span class="fa fa-plus"></span>&nbsp;
                                                                    Add
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                        </div>

                                        <!-- Price Tab -->
                                        <div class="tab-pane fade" id="price" role="tabpanel"
                                             aria-labelledby="price-tab">
                                            <div class="row pb-2">
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_purchase_price">Purchase
                                                        Price</label>
                                                    <input type="number" name="product_purchase_price"
                                                           id="product_purchase_price"
                                                           onkeyup="CalculateSalePrice();CalculateAfterDiscountPrice();"
                                                           onblur="CalculateSalePrice();CalculateAfterDiscountPrice();"
                                                           class="form-control" placeholder="Price" step="any"
                                                           required/>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_tax">Tax %</label>
                                                    <input type="number" name="product_tax" id="product_tax"
                                                           onkeyup="CalculateSalePrice();CalculateAfterDiscountPrice();"
                                                           onblur="CalculateSalePrice();CalculateAfterDiscountPrice();"
                                                           class="form-control" placeholder="Tax" step="any" value="0"/>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_unit_price">Sale Price</label>
                                                    <input type="number" name="product_unit_price"
                                                           id="product_unit_price"
                                                           class="form-control" placeholder="Price" step="any"
                                                           disabled/>
                                                </div>
                                                <div class="col-md-3 mb-3" id="_percentageDiscountBlock">
                                                    <label class="w-100" for="product_discount">Discount %</label>
                                                    <input type="number" name="product_discount" id="product_discount"
                                                           onkeyup="CalculateAfterDiscountPrice();"
                                                           onblur="CalculateAfterDiscountPrice();"
                                                           class="form-control" placeholder="%" step="any" value="0"/>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_price_after_discount">After Discount</label>
                                                    <input type="number" name="product_price_after_discount" id="product_price_after_discount"
                                                           class="form-control" placeholder="Price" step="any"
                                                           disabled/>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_quantity">Quantity</label>
                                                    <input type="number" name="product_quantity" id="product_quantity"
                                                           class="form-control" placeholder="No. of products" step="any"
                                                           required/>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Shipping Info Tab -->
                                        <div class="tab-pane fade" id="shipping-info" role="tabpanel"
                                             aria-labelledby="shipping-info-tab">
                                            <div class="row pb-2">
                                                <div class="col-md-2 mb-3">
                                                    <label class="w-100" for="free_shipping">Free Shipping</label>
                                                    <label class="switch">
                                                        <input type="checkbox" name="product_shipping_type"
                                                               id="product_shipping_type" checked>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-3 mb-3" id="_shippingFlatRateBlock"
                                                     style="display:none;">
                                                    <label class="w-100" for="product_flat_rate_shipping">Shipping Flat
                                                        Rate</label>
                                                    <input type="number" name="product_flat_rate_shipping"
                                                           id="product_flat_rate_shipping"
                                                           class="form-control" placeholder="Price" step="any"/>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delivery & Return Tab -->
                                        <div class="tab-pane fade" id="delivery-return" role="tabpanel"
                                             aria-labelledby="delivery-return-tab">
                                            <div class="row pb-2">
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_fast_delivery">Fast Delivery in 24
                                                        Hours</label>
                                                    <select class="form-control select2" name="product_fast_delivery"
                                                            id="product_fast_delivery" required>
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_normal_delivery">Normal Delivery 2
                                                        to 3 Days</label>
                                                    <select class="form-control select2" name="product_normal_delivery"
                                                            id="product_normal_delivery" required>
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_free_installation">Free Installation</label>
                                                    <select class="form-control select2" name="product_free_installation"
                                                            id="product_free_installation" required onchange="checkInstallation();">
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3" id="_installationPriceBlock" style="display:none;">
                                                    <label class="w-100" for="installation_price">Installation Price</label>
                                                    <input type="number" name="installation_price"
                                                           id="installation_price" class="form-control"
                                                           placeholder="Price" step="any"/>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="w-100" for="product_pdf_specification">PDF
                                                        Specification</label>
                                                    <input type="file" name="product_pdf_specification"
                                                           id="product_pdf_specification"
                                                           class="form-control" accept=".pdf"/>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Save button -->
                                <div class="col-md-12 text-center mt-4">
                                    <button class="btn btn-primary w-10"  type="button"  id="saveProducts">Save</button>
                                </div>

                            </div>
                            <!-- End of Tabs Row -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('sample-scripts')
    <script type="text/javascript"
            src="{{ asset('public/js/spartan-multi-image-picker/spartan-multi-image-picker-min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#primaryImage").spartanMultiImagePicker({
                fieldName: 'primaryPicture[]',
                maxCount: 1,
                allowedExt: 'png|jpg|jpeg|gif|webp',
                rowHeight: '200px',
                groupClassName: 'col-md-3 col-sm-3 col-xs-6',
                maxFileSize: '2048000',
                dropFileLabel: "Drop Here",
                onAddRow: function (index) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    alert('Please only input png or jpg type file')
                },
                onSizeErr: function (index, file) {
                    alert('File size too big');
                }
            });

            $("#galleryImages").spartanMultiImagePicker({
                fieldName: 'galleryPictures[]',
                maxCount: 50,
                allowedExt: 'png|jpg|jpeg|gif|webp',
                rowHeight: '200px',
                groupClassName: 'col-md-3 col-sm-3 col-xs-6',
                maxFileSize: '2048000',
                dropFileLabel: "Drop Here",
                onAddRow: function (index) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {
                    /*console.log(index);*/
                },
                onExtensionErr: function (index, file) {
                    alert('Please only input png or jpg type file')
                },
                onSizeErr: function (index, file) {
                    alert('File size too big');
                }
            });

            $("#size_packaging_Images").spartanMultiImagePicker({
                fieldName: 'sizePackagingPicture[]',
                maxCount: 1,
                allowedExt: 'png|jpg|jpeg|gif|webp',
                rowHeight: '200px',
                groupClassName: 'col-md-3 col-sm-3 col-xs-6',
                maxFileSize: '2048000',
                dropFileLabel: "Drop Here",
                onAddRow: function (index) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    alert('Please only input png or jpg type file')
                },
                onSizeErr: function (index, file) {
                    alert('File size too big');
                }
            });

            $('.remove-files').on('click', function () {
                $(this).parents(".col-md-4").remove();
            });

            $("#metaImage").spartanMultiImagePicker({
                fieldName: 'metaPicture[]',
                maxCount: 1,
                allowedExt: 'png|jpg|jpeg|gif|webp',
                rowHeight: '200px',
                groupClassName: 'col-md-12 col-sm-12 col-xs-6',
                maxFileSize: '2048000',
                dropFileLabel: "Drop Here",
                onAddRow: function (index) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    alert('Please only input png or jpg type file')
                },
                onSizeErr: function (index, file) {
                    alert('File size too big');
                }
            });
        });
    </script>
@endsection
