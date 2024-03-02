@extends('dashboard.layouts.app')
@section('content')
    <style media="screen">
        .buttonStyling {
            font-size: 16px !important;
        }
    </style>
    <div class="page-content" id="settings-pages">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">GeneralSettings - Page Banners</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <a href="{{route('settings.banners.edit', [1])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 buttonStyling">Stores
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [2])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Return & Cancellations
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [3])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Ways
                                            to Pay
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [4])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Delivery/Installation
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [5])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Price
                                            Promise
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [6])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Installment Guide
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [7])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Privacy and Cookies Policy
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [8])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Terms
                                            and Conditions
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [9])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Orders & Collect
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [10])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Discount Voucher
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [11])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">About
                                            Us
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [12])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Contact Us
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [13])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Care
                                            & Repair
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [14])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Cart
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [15])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Checkout
                                        </button>
                                    </a>
                                    <!--<a href="{{route('settings.banners.edit', [17])}}">-->
                                    <!--    <button type="button" name="button"-->
                                    <!--            class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">-->
                                    <!--        Installation Guide-->
                                    <!--    </button>-->
                                    <!--</a>-->
                                    <a href="{{route('settings.banners.edit', [16])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Track Order
                                        </button>
                                    </a>
                                     <a href="{{route('settings.banners.edit', [19])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            See all deals
                                        </button>
                                    </a>
                                    <a href="{{route('settings.banners.edit', [20])}}">
                                        <button type="button" name="button"
                                                class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">
                                            Clearance Sale
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection