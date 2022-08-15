<!DOCTYPE html>
<html lang="en">
<head>
    {{--<link rel="stylesheet" href="{{public_path('public/assets/css/invoicestyle.css')}}" type="text/css"/>--}}

    <meta charset="utf-8">
    <title>Order Invoice</title>
    <style>
        body {
            font-family: "Roboto, sans-serif";
        }

        .primaryColor {
            color: #fc4440;
        }

        .primaryFontFamily {
            font-family: "Roboto, sans-serif";
        }

        .titleSetting {
            font-size: 1.1em;
            text-align: right;
        }

        .regardsSetting {
            font-size: 1.1em;
            text-align: left;
            margin-left: -10px;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 18px;
            border-collapse: collapse;
            border-spacing: 2px;
        }

        th {
            font-weight: 400;
            font-size: 16px;
            color: white;
            text-align: inherit;
        }

        td {
            font-size: 14px;
        }

        thead {
            background-color: grey;
        }

        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
            padding: 11px 8px 8px 8px;
            color: #000000;
            font-weight: 500;
            font-size: 14px;
        }

        .table-bordered tbody td {
            padding: 11px 8px 8px 8px;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .table td, .table th {
            padding: 0.3rem;
        }

        /*Bootstrap*/
        .row {
            display: flex;
            flex-wrap: nowrap;
            /*margin-right: -0.75rem;
            margin-left: -0.75rem;*/
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-danger {
            color: #ff3366 !important;
        }

        /*Margins Classes*/
        .m-0 {
            margin: 0 !important; }

        .mt-0,
        .my-0 {
            margin-top: 0 !important; }

        .mr-0,
        .mx-0 {
            margin-right: 0 !important; }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important; }

        .ml-0,
        .mx-0 {
            margin-left: 0 !important; }

        .m-1 {
            margin: 0.25rem !important; }

        .mt-1,
        .my-1 {
            margin-top: 0.25rem !important; }

        .mr-1,
        .mx-1 {
            margin-right: 0.25rem !important; }

        .mb-1,
        .my-1 {
            margin-bottom: 0.25rem !important; }

        .ml-1,
        .mx-1 {
            margin-left: 0.25rem !important; }

        .m-2 {
            margin: 0.5rem !important; }

        .mt-2,
        .my-2 {
            margin-top: 0.5rem !important; }

        .mr-2,
        .mx-2 {
            margin-right: 0.5rem !important; }

        .mb-2,
        .my-2 {
            margin-bottom: 0.5rem !important; }

        .ml-2, .btn-toolbar .btn-group + .btn-group, .btn-toolbar .fc .fc-toolbar.fc-header-toolbar .fc-left .fc-button-group + .btn-group, .fc .fc-toolbar.fc-header-toolbar .fc-left .btn-toolbar .fc-button-group + .btn-group, .btn-toolbar .fc .fc-toolbar.fc-header-toolbar .fc-right .fc-button-group + .btn-group, .fc .fc-toolbar.fc-header-toolbar .fc-right .btn-toolbar .fc-button-group + .btn-group, .btn-toolbar .fc .fc-toolbar.fc-header-toolbar .fc-left .btn-group + .fc-button-group, .fc .fc-toolbar.fc-header-toolbar .fc-left .btn-toolbar .btn-group + .fc-button-group, .btn-toolbar .fc .fc-toolbar.fc-header-toolbar .fc-left .fc-button-group + .fc-button-group, .fc .fc-toolbar.fc-header-toolbar .fc-left .btn-toolbar .fc-button-group + .fc-button-group, .fc .fc-toolbar.fc-header-toolbar .fc-right .btn-toolbar .fc-left .fc-button-group + .fc-button-group, .btn-toolbar .fc .fc-toolbar.fc-header-toolbar .fc-right .btn-group + .fc-button-group, .fc .fc-toolbar.fc-header-toolbar .fc-right .btn-toolbar .btn-group + .fc-button-group, .fc .fc-toolbar.fc-header-toolbar .fc-left .btn-toolbar .fc-right .fc-button-group + .fc-button-group, .btn-toolbar .fc .fc-toolbar.fc-header-toolbar .fc-right .fc-button-group + .fc-button-group, .fc .fc-toolbar.fc-header-toolbar .fc-right .btn-toolbar .fc-button-group + .fc-button-group,
        .mx-2 {
            margin-left: 0.5rem !important; }

        .m-3 {
            margin: 1rem !important; }

        .mt-3, .dataTables_wrapper div.dataTables_paginate ul.pagination,
        .my-3 {
            margin-top: 1rem !important; }

        .mr-3,
        .mx-3 {
            margin-right: 1rem !important; }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important; }

        .ml-3,
        .mx-3 {
            margin-left: 1rem !important; }

        .m-4 {
            margin: 1.5rem !important; }

        .mt-4,
        .my-4 {
            margin-top: 1.5rem !important; }

        .mr-4,
        .mx-4 {
            margin-right: 1.5rem !important; }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important; }

        .ml-4,
        .mx-4 {
            margin-left: 1.5rem !important; }

        .m-5 {
            margin: 3rem !important; }

        .mt-5,
        .my-5 {
            margin-top: 3rem !important; }

        .mr-5,
        .mx-5 {
            margin-right: 3rem !important; }

        .mb-5,
        .my-5 {
            margin-bottom: 3rem !important; }

        .ml-5,
        .mx-5 {
            margin-left: 3rem !important; }

        /*Padding Classes*/
        .p-0 {
            padding: 0 !important; }

        .pt-0,
        .py-0 {
            padding-top: 0 !important; }

        .pr-0,
        .px-0 {
            padding-right: 0 !important; }

        .pb-0,
        .py-0 {
            padding-bottom: 0 !important; }

        .pl-0,
        .px-0 {
            padding-left: 0 !important; }

        .p-1 {
            padding: 0.25rem !important; }

        .pt-1,
        .py-1 {
            padding-top: 0.25rem !important; }

        .pr-1,
        .px-1 {
            padding-right: 0.25rem !important; }

        .pb-1,
        .py-1 {
            padding-bottom: 0.25rem !important; }

        .pl-1,
        .px-1 {
            padding-left: 0.25rem !important; }

        .p-2 {
            padding: 0.5rem !important; }

        .pt-2,
        .py-2 {
            padding-top: 0.5rem !important; }

        .pr-2,
        .px-2 {
            padding-right: 0.5rem !important; }

        .pb-2,
        .py-2 {
            padding-bottom: 0.5rem !important; }

        .pl-2,
        .px-2 {
            padding-left: 0.5rem !important; }

        .p-3 {
            padding: 1rem !important; }

        .pt-3,
        .py-3 {
            padding-top: 1rem !important; }

        .pr-3,
        .px-3 {
            padding-right: 1rem !important; }

        .pb-3,
        .py-3 {
            padding-bottom: 1rem !important; }

        .pl-3,
        .px-3 {
            padding-left: 1rem !important; }

        .p-4 {
            padding: 1.5rem !important; }

        .pt-4,
        .py-4 {
            padding-top: 1.5rem !important; }

        .pr-4,
        .px-4 {
            padding-right: 1.5rem !important; }

        .pb-4,
        .py-4 {
            padding-bottom: 1.5rem !important; }

        .pl-4,
        .px-4 {
            padding-left: 1.5rem !important; }

        .p-5 {
            padding: 3rem !important; }

        .pt-5,
        .py-5 {
            padding-top: 3rem !important; }

        .pr-5,
        .px-5 {
            padding-right: 3rem !important; }

        .pb-5,
        .py-5 {
            padding-bottom: 3rem !important; }

        .pl-5,
        .px-5 {
            padding-left: 3rem !important; }

        /*Footer*/
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
</head>
<body class="bg-white">

{{--Header--}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6" style="float:left;">
            <img style="height:85px;"
                 {{--src="{{asset('public/storage/logo/') . '/' . $logo}}"--}}
                 src="{{asset('public/assets/images/logo1.png')}}"
                 alt="" />
        </div>
        <div class="col-md-6" style="float: right; font-size: 12px;">
            <p class="text-right mb-0">Address: 925C-Molana Shoukat Ali Road</p>
            <p class="text-right mb-0">Lahore, Punjab. Pakistan</p>
            <p class="text-right mb-0">SNTN/PNTN # : 40413212-6</p>
            <p class="text-right mb-0">STRN/PNTN # : 40423312-6</p>
            <p class="text-right mb-0">Contact : 0325-101-101-9</p>
        </div>
    </div>
</div>
{{--Header--}}

<div class="text-center" style="background: grey; margin-top: 130px; padding: 13px 0 7px 0;">
    <b>Sales Invoice</b>
</div>

<div class="row" style="margin-top: 25px;">
    <div class="col-md-6" style="float: left; font-size: 14px; font-weight: 500;">
        <p class="mb-2">Billing Address:</p>
        <p class="mb-2">{{$Customer[0]->first_name . ' ' . $Customer[0]->last_name}}</p>
        <p class="mb-2">{{$Customer[0]->phone}}</p>
        <p class="mb-2">{{$Customer[0]->billing_address}}</p>
        <p class="mb-2">{{$Customer[0]->billing_city}}, {{$Customer[0]->billing_state}} {{$Customer[0]->billing_zipcode}}</p>
        <p class="mb-2">{{$Country}}</p>
    </div>
    <div class="col-md-6" style="float: right; font-size: 14px; font-weight: 500;">
        <p class="mb-2">Invoice No. {{$Order[0]->invoice_no}}</p>
        <p class="mb-2">Invoice Date: {{\Carbon\Carbon::parse($Order[0]->created_at)->format('d-F-Y, h:i a')}}</p>
    </div>
</div>

<div style=" width: 100%; margin-top: 170px; font-size: 13px;">
    Type of Supply : {{$Order[0]->payment_gateway}}
</div>

<div style="width: 100%; margin-top: 25px;">
    <table class="table table-bordered">
        <thead style="text-align: center;">
        <tr>
            <th style="width: 5%;">S/N</th>
            <th style="width: 30%;">Product</th>
            <th style="width: 15%;">Code</th>
            <th style="width: 5%;">Qty</th>
            <th style="width: 15%;">Unit Price</th>
            <th style="width: 15%;">Discount</th>
            <th style="width: 15%;">Total Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $DiscountAmount = 0;
        $SubTotal = 0;
        ?>
        @foreach($OrderDetails as $index => $item)
            <tr>
                <td style="width: 5%;" class="text-center">{{$index + 1}}</td>
                <td style="width: 30%;">{{$item->ProductName}}</td>
                <td style="width: 15%;">{{$item->ProductCode}}</td>
                <td style="width: 5%;" class="text-center">{{$item->quantity}}</td>
                <td style="width: 15%;" class="text-center">{{number_format(floatval($item->total_price) + floatval($item->discount_price), \App\Helpers\SiteHelper::$Decimals)}}</td>
                <td style="width: 15%;" class="text-center">{{number_format($item->discount_price, \App\Helpers\SiteHelper::$Decimals)}}</td>
                <td style="width: 15%;" class="text-center">{{number_format($item->total_price, \App\Helpers\SiteHelper::$Decimals)}}</td>
            </tr>
            <?php
            $DiscountAmount += floatval($item->discount_price);
            $SubTotal += floatval($item->total_price) + floatval($item->discount_price);
            ?>
        @endforeach
        <?php
        $DiscountAmount += floatval($Order[0]->voucher_amount);
        ?>
        </tbody>
    </table>
</div>

<div style="margin-top: 25px;" class="row">
    <div class="col-md-6" style="float: left;"></div>
    <div class="col-md-6" style="float: right; font-weight: 500; width: 45%;">
        <table class="table">
            <tbody>
            <tr>
                <td style="width: 40%;">Sub Total</td>
                <td style="width: 60%;" class="text-right">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($SubTotal, \App\Helpers\SiteHelper::$Decimals)}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">GST 17% Included</td>
                <td style="width: 60%;" class="text-right">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->gst, \App\Helpers\SiteHelper::$Decimals)}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">Discount Amount</td>
                <td style="width: 60%;" class="text-right text-danger">- {{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($DiscountAmount, \App\Helpers\SiteHelper::$Decimals)}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">B2B Discount</td>
                <td style="width: 60%;" class="text-right text-danger">- {{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->b2b_discount, \App\Helpers\SiteHelper::$Decimals)}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">Shipping</td>
                <td style="width: 60%;" class="text-right">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->shipping, \App\Helpers\SiteHelper::$Decimals)}}</td>
            </tr>
            <tr>
                <td style="width: 40%;">Installation</td>
                <td style="width: 60%;" class="text-right">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->installation, \App\Helpers\SiteHelper::$Decimals)}}</td>
            </tr>
            <tr>
                <td style="width: 100%;" colspan="2">
                    <hr class="mt-0 mb-1">
                </td>
            </tr>
            <tr>
                <td style="width: 40%;">Total</td>
                <td style="width: 60%;" class="text-right">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->order_total, \App\Helpers\SiteHelper::$Decimals)}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 170px; width: 100%; font-size: 12px;">
    *This is system generated report, it does not required any seal or signatures.
</div>

{{--Footer--}}
<div class="footer text-center">
    <p style="font-size: 13px; font-weight: lighter;">Follow Us</p>
    <p class="text-black mb-3"><span><img src="{{asset('public/assets/images/footer/Facebook.png')}}" alt="" class="img-fluid" style="width: 24px; margin-right: 5px;"><img src="{{asset('public/assets/images/footer/Instagram.png')}}" alt="" class="img-fluid" style="width: 24px; margin-right: 5px;"><img src="{{asset('public/assets/images/footer/Twitter.png')}}" alt="" class="img-fluid" style="width: 24px; margin-right: 5px;"><img src="{{asset('public/assets/images/footer/Tiktok.png')}}" alt="" class="img-fluid" style="width: 24px; margin-right: 5px;"><img src="{{asset('public/assets/images/footer/Youtube.png')}}" alt="" class="img-fluid" style="width: 24px; margin-right: 5px;"><img src="{{asset('public/assets/images/footer/Pinterest.png')}}" alt="" class="img-fluid" style="width: 24px;"></span></p>
</div>
{{--Footer--}}
</body>
</html>
