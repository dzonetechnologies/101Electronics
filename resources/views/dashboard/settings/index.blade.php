@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="settings-form">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Settings - Edit</h4>
                            </div>
                        </div>
                    </div>
                    <?php
                    $Logo = asset('public/storage/logo/' . $GeneralSettings[0]->logo);
                    ?>
                    <div class="card-body">
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="oldLogo" value="{{$GeneralSettings[0]->logo}}">
                            <div class="row">
                                <div class="offset-md-1 col-md-10">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="logo" class="mb-1">Logo</label>
                                            <div class="upload_image_box">
                                                <img src="{{$Logo}}"
                                                     alt="Logo Image"
                                                     id="previewImg"
                                                     style="width: 100%;
                                                     max-height: 100%;
                                                     object-fit: cover;" />
                                                <input type="file"
                                                       style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100%; height: 100%; cursor: pointer;'
                                                       name="logo_image"
                                                       id="logo"
                                                       accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG,.webp,.WEBP" />
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="facebook_pixel" class="mb-1">FaceBook Pixel</label>
                                            <textarea class="form-control" name="facebook_pixel" id="facebook_pixel" rows="8" cols="80">{{$GeneralSettings[0]->facebook_pixel}}</textarea>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="google_analytics" class="mb-1">Google Analytics</label>
                                            <textarea class="form-control" name="google_analytics" id="google_analytics" rows="8" cols="80">{{$GeneralSettings[0]->google_analytics}}</textarea>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="announcement" class="mb-1">Announcement</label>
                                            <textarea class="form-control" name="announcement" id="announcement" rows="8" cols="80">{{$GeneralSettings[0]->announcement}}</textarea>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="homepage_selling_tagline" class="mb-1">Homepage Selling Tagline</label>
                                            <input type="text" class="form-control" name="homepage_selling_tagline" id="homepage_selling_tagline" value="{{$GeneralSettings[0]->homepage_selling_tagline}}" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="brandpage_selling_tagline" class="mb-1">Brand Page Selling Tagline</label>
                                            <input type="text" class="form-control" name="brandpage_selling_tagline" id="brandpage_selling_tagline" value="{{$GeneralSettings[0]->brandpage_selling_tagline}}" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="categorypage_selling_tagline" class="mb-1">Category Page Selling Tagline</label>
                                            <input type="text" class="form-control" name="categorypage_selling_tagline" id="categorypage_selling_tagline" value="{{$GeneralSettings[0]->categorypage_selling_tagline}}" />
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="shipping_quantity" class="mb-1">Shipping Quantity</label>
                                            <input type="text" class="form-control" name="shipping_quantity" id="shipping_quantity" value="{{$GeneralSettings[0]->shipping_quantity}}" maxlength="100" />
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="shipping_cost" class="mb-1">Shipping Cost</label>
                                            <input type="text" class="form-control" name="shipping_cost" id="shipping_cost" value="{{$GeneralSettings[0]->shipping_cost}}" maxlength="100" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="securePayment" class="mb-1">Secured Payment Method</label>
                                            <input type="hidden" class="form-control" name="oldsecurePayment" id="securePayment" value="{{$GeneralSettings[0]->secure_payment}}" multiple/>
                                            <input type="file" class="form-control" name="securePayment[]" id="securePayment" multiple/>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="securePayment" class="mb-1">B2B</label>
                                            <input type="hidden" class="form-control" name="b2b" id="b2b" value="{{$GeneralSettings[0]->b2b}}" multiple/>
                                            <input type="file" class="form-control"
                                                   name="b2bFile" id="b2bFile"
                                                   accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG,.webp,.WEBP" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="b2b_discount" class="mb-1">B2B Discount</label>
                                            <input type="number" class="form-control" name="b2b_discount"
                                                   min="5"
                                                   max="35"
                                                   id="b2b_discount" value="{{$GeneralSettings[0]->b2b_discount}}"
                                                   onkeypress="return (event.charCode !== 8 && event.charCode === 0 || (event.charCode >= 48 && event.charCode <= 57))" />
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
