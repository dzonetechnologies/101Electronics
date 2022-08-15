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
        width: 57px;
        height: 30px;
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
        height: 23px;
        width: 23px;
        left: 5px;
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
    <div class="page-content" id="discount-vouchers">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Discount Vouchers</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                    $Url = route('discountvouchers.add');
                                ?>
                                <button type="button" class="btn btn-primary float-right"
                                        data-toggle="tooltip" title="Create Discount Voucher"
                                        onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-0">
                                @if(session()->has('success-message'))
                                    <div class="alert alert-success">
                                        {!! session('success-message') !!}
                                    </div>
                                @elseif(session()->has('error-message'))
                                    <div class="alert alert-danger">
                                        {!! session('error-message') !!}
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="discountVoucherTable">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;">Order No</th>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 15%;">Title</th>
                                            <th style="width: 15%;">Discount Code</th>
                                            <th style="width: 15%;">Voucher Price</th>
                                            <th style="width: 15%;">Minimum Shopping</th>
                                            <th style="width: 10%;">Remaning Limit</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 10%;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.discount-vouchers.delete')
@endsection
