@extends('dashboard.layouts.app')

@section('content')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
            </div>
        </div>

         <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow">
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Brands</h6>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5 mt-3">
                                        <h3 class="mb-2">{{$BrandsCount}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Categories</h6>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5 mt-3">
                                        <h3 class="mb-2">{{$CategoriesCount}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Products</h6>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5 mt-3">
                                        <h3 class="mb-2">{{$ProductsCount}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Orders</h6>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5 mt-3">
                                        <h3 class="mb-2">{{$OrdersCount}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>
@endsection
