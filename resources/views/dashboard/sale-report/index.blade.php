@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12 mb-3">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @elseif(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            {{--Filter - Start--}}

            <input type="hidden" name="startDateFilter" id="startDateFilter" value="" />
            <input type="hidden" name="endDateFilter" id="endDateFilter" value="" />
            <input type="hidden" name="orderStatusFilter" id="orderStatusFilter" value="" />
            <input type="hidden" name="productFilter" id="productFilter" value="" />

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            Filter
                        </h6>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="report_start_date">Start Date</label>
                                <input type="date" name="report_start_date" id="report_start_date"
                                       class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="report_end_date">End Date</label>
                                <input type="date" name="report_end_date" id="report_end_date"
                                       class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="report_order_status">Order Status</label>
                                <select class="form-control select2" name="report_order_status"
                                        id="report_order_status">
                                    <option value="">Select</option>
                                    <option value="0">Pending</option>
                                    <option value="1">In Progress</option>
                                    <option value="2">Delivered</option>
                                    <option value="3">Completed</option>
                                    <option value="4">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="report_product">Product</label>
                                <select class="form-control select2" name="report_product" id="report_product">
                                    <option value="">Select</option>
                                    @foreach($Products as $index => $value)
                                        <option value="{{$value->id}}">{{$value->name}} - {{$value->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button type="button" name="button" class="btn btn-primary float-right mt-3 ml-2"
                                        onclick="FilterSaleReport();">Filter
                                </button>
                                <button type="button" name="button" class="btn btn-primary float-right mt-3"
                                        onclick="FilterSaleReportExcel();">Export Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--Filter - End--}}

            {{--Sale Report Analytics - Start--}}
            <div class="col-md-12">
                <div class="row flex-grow">
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <i class="fas fa-shopping-bag" style="font-size: 28px;color: #cd324e;"></i>
                                    </div>
                                    <div class="col-12 pt-4 pb-3">
                                        <h6 class="card-title mb-0">Total Orders</h6>
                                    </div>
                                    <div class="col-12">
                                        <h4 class="mb-2 mt-2" id="total_orders">{{$TotalOrders}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <i class="fas fa-money-bill-wave" style="font-size: 28px;color: #cd324e;"></i>
                                    </div>
                                    <div class="col-12 pt-4 pb-3">
                                        <h6 class="card-title mb-0">Total Sale</h6>
                                    </div>
                                    <div class="col-12">
                                        <h4 class="mb-2 mt-2" id="total_sale">PKR {{number_format(round($TotalSale), 0)}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <i class="fas fa-money-bill" style="font-size: 28px;color: #cd324e;"></i>
                                    </div>
                                    <div class="col-12 pt-4 pb-3">
                                        <h6 class="card-title mb-0">Total GST</h6>
                                    </div>
                                    <div class="col-12">
                                        <h4 class="mb-2 mt-2" id="total_gst">PKR {{number_format(round($TotalGST), 0)}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <i class="fas fa-money-check-alt" style="font-size: 28px;color: #cd324e;"></i>
                                    </div>
                                    <div class="col-12 pt-4 pb-3">
                                        <h6 class="card-title mb-0">Total Discount</h6>
                                    </div>
                                    <div class="col-12">
                                        <h4 class="mb-2 mt-2" id="total_discount">PKR {{number_format(round($TotalDiscount), 0)}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <i class="fas fa-luggage-cart" style="font-size: 28px;color: #cd324e;"></i>
                                    </div>
                                    <div class="col-12 pt-4 pb-3">
                                        <h6 class="card-title mb-0">Total Products Qty Sold</h6>
                                    </div>
                                    <div class="col-12">
                                        <h4 class="mb-2 mt-2" id="total_products_qty">{{$TotalProductsQty}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--Sale Report Analytics - End--}}
        </div>
    </div>
@endsection