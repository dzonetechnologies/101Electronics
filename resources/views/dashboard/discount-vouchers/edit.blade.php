@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="discount-vouchers-add">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Discount Voucher - Edit</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('discountvouchers');
                                ?>
                                <button type="button" class="btn btn-primary float-right" onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('discountvouchers.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="voucherId" value="{{$DiscountVoucher[0]->id}}" />
                            <div class="row">
                                <div class="offset-md-1 col-md-10">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="name" class="mb-1">Title</label>
                                            <input type="text" placeholder="Title" id="name"
                                                   name="name" class="form-control" maxlength="100"
                                                   value="{{$DiscountVoucher[0]->title}}" required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="discount_code" class="mb-1">Discount Code</label>
                                            <input type="text" placeholder="Code" id="discount_code"
                                                   name="discount_code" class="form-control" maxlength="100"
                                                   value="{{$DiscountVoucher[0]->discount_code}}" required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="voucher_price" class="mb-1">Voucher Price</label>
                                            <input type="number" placeholder="Amount" id="voucher_price"
                                                   name="voucher_price" class="form-control" min="0"
                                                   value="{{$DiscountVoucher[0]->voucher_price}}" required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="min_shopping_amount" class="mb-1">Minimum Shopping</label>
                                            <input type="number" placeholder="Amount" id="min_shopping_amount"
                                                   name="min_shopping_amount" class="form-control" min="0"
                                                   value="{{$DiscountVoucher[0]->min_shopping_price}}" required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="limit" class="mb-1">Voucher Limit</label>
                                            <input type="number" placeholder="Limit" id="limit"
                                                   name="limit" class="form-control" min="0"
                                                   value="{{$DiscountVoucher[0]->max_limit}}" required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="start_date" class="mb-1">Start Date</label>
                                            <input type="date" placeholder="Price" id="start_date"
                                                   name="start_date" class="form-control"
                                                   value="{{$DiscountVoucher[0]->start_date}}" required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="end_date" class="mb-1">End Date</label>
                                            <input type="date" placeholder="Price" id="end_date"
                                                   name="end_date" class="form-control"
                                                   value="{{$DiscountVoucher[0]->end_date}}" required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="description" class="mb-1">Description</label>
                                            <textarea type="text" id="product_short_description" name="description"
                                                      class="form-control" rows="5" maxlength="1000">{{$DiscountVoucher[0]->desc}}</textarea>
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
