@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="products">
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

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Customer Information</h4>
                            </div>
                            <div class="ml-auto">
                                <?php
                                $BackUrl = route('orders');
                                $DownloadUrl = asset('public/storage/invoices') . '/' . $Order[0]->invoice_pdf;
                                ?>
                                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-title="Delete" id="deleteOrderBtn_{{$Order[0]->id}}" onclick="DeleteOrder(this.id);"><i class="fas fa-trash"></i></button>
                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-title="PDF" onclick="window.open('{{$DownloadUrl}}', '_blank');"><i class="fas fa-file-pdf"></i></button>
                                    <button type="button" class="btn {{$StatusBtn}} text-white" id="orderStatusBtn_{{$Order[0]->id}}" data-toggle="tooltip" data-title="Update Status" onclick="UpdateOrderStatus(this.id);"><i class="fas fa-pencil-alt"></i></button>
                                    <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-title="Back" onclick="window.location.href='{{$BackUrl}}';"><i class="fas fa-arrow-left"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <tbody>
                                        <tr>
                                            <td class="w-25">First Name</td>
                                            <td class="w-25"><b>{{$Customer[0]->first_name}}</b></td>
                                            <td class="w-25">Last Name</td>
                                            <td class="w-25"><b>{{$Customer[0]->last_name}}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Phone</td>
                                            <td class="w-25"><b>{{$Customer[0]->phone}}</b></td>
                                            <td class="w-25">Email</td>
                                            <td class="w-25"><b>{{$Customer[0]->email}}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Company</td>
                                            <td class="w-25"><b>{{$Customer[0]->company}}</b></td>
                                            <td class="w-25">Company Address</td>
                                            <td class="w-25"><b>{{$Customer[0]->company_address}}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Billing Address</td>
                                            <td class="w-25"><b>{!! wordwrap($Customer[0]->billing_address, 40, '<br>') !!}</b></td>
                                            <td class="w-25">Billing City</td>
                                            <td class="w-25"><b>{!! wordwrap($Customer[0]->billing_city, 40, '<br>') !!}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Billing State</td>
                                            <td class="w-25"><b>{!! wordwrap($Customer[0]->billing_state, 40, '<br>') !!}</b></td>
                                            <td class="w-25">Billing ZipCode</td>
                                            <td class="w-25"><b>{!! wordwrap($Customer[0]->billing_zipcode, 40, '<br>') !!}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Shipping Address</td>
                                            <td class="w-25"><b>{!! wordwrap($Customer[0]->shipping_address, 40, '<br>') !!}</b></td>
                                            <td class="w-25">Shipping City</td>
                                            <td class="w-25"><b>{!! wordwrap($Customer[0]->shipping_city, 40, '<br>') !!}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Shipping State</td>
                                            <td class="w-25"><b>{!! wordwrap($Customer[0]->shipping_state, 40, '<br>') !!}</b></td>
                                            <td class="w-25">Shipping ZipCode</td>
                                            <td class="w-25"><b>{!! wordwrap($Customer[0]->shipping_zipcode, 40, '<br>') !!}</b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Order Details</h4>
                            </div>
                            <div class="ml-auto">
                                {!! $Status !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <tbody>
                                        <tr>
                                            <td class="w-25">Invoice #</td>
                                            <td class="w-25"><b>{{$Order[0]->invoice_no}}</b></td>
                                            <td class="w-25">Payment Type</td>
                                            <td class="w-25"><b>{{$Order[0]->payment_gateway}}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Discount Code</td>
                                            <td class="w-25"><b>{{$Order[0]->discount_code}}</b></td>
                                            <td class="w-25">Sub Total</td>
                                            <td class="w-25"><b>{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->sub_total, \App\Helpers\SiteHelper::$Decimals)}}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Discount Amount</td>
                                            <td class="w-25"><b>{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->discount, \App\Helpers\SiteHelper::$Decimals)}}</b></td>
                                            <td class="w-25">B2B Discount Amount</td>
                                            <td class="w-25"><b>{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->b2b_discount, \App\Helpers\SiteHelper::$Decimals)}}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Shipping</td>
                                            <td class="w-25"><b>{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->shipping, \App\Helpers\SiteHelper::$Decimals)}}</b></td>
                                            <td class="w-25">Installation</td>
                                            <td class="w-25"><b>{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->installation, \App\Helpers\SiteHelper::$Decimals)}}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Voucher Amount</td>
                                            <td class="w-25"><b>{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->voucher_amount, \App\Helpers\SiteHelper::$Decimals)}}</b></td>
                                            <td class="w-25">Order Total</td>
                                            <td class="w-25"><b>{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($Order[0]->order_total, \App\Helpers\SiteHelper::$Decimals)}}</b></td>
                                        </tr>

                                        <tr>
                                            <td class="w-25">Notes</td>
                                            <td class="w-75" colspan="3">{!! wordwrap($Order[0]->order_notes, 130, '<br>') !!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Product Details</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;">S/N</th>
                                            <th style="width: 45%;">Product</th>
                                            <th style="width: 45%;">Code</th>
                                            <th style="width: 5%;">Qty</th>
                                            <th style="width: 15%;">Unit Price</th>
                                            <th style="width: 15%;">Discount</th>
                                            <th style="width: 15%;">Total Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($OrderDetails as $index => $item)
                                            <tr>
                                                <td style="width: 5%;">{{$index + 1}}</td>
                                                <td style="width: 45%;">{{$item->ProductName}}</td>
                                                \<td style="width: 45%;">{{$item->ProductCode}}</td>
                                                <td style="width: 5%;">{{$item->quantity}}</td>
                                                <td style="width: 15%;">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format(floatval($item->total_price) + floatval($item->discount_price), \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                <td style="width: 15%;">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($item->discount_price, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                                <td style="width: 15%;">{{\App\Helpers\SiteHelper::$Currency . ' ' . number_format($item->total_price, \App\Helpers\SiteHelper::$Decimals)}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.orders.updateStatus')
    @include('dashboard.orders.delete')
@endsection