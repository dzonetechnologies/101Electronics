@extends('dashboard.layouts.app')
@section('content')
<style media="screen">
  .buttonStyling{
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
                                <h4 class="mb-3 mb-md-0">GeneralSettings - Pages</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                              <div class="col-md-12 text-center">
                                <a href="{{route('settings.pages.edit', [21])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 buttonStyling">Home Page</button></a>
                                <a href="{{route('settings.pages.edit', [11])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">About Us</button></a>
                                <a href="{{route('settings.pages.edit', [12])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Contact Us</button></a>
                                <a href="{{route('settings.pages.edit', [20])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Clearance Sale</button></a>
                                <a href="{{route('settings.pages.edit', [13])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Care & Repair</button></a>
                                <a href="{{route('settings.pages.edit', [22])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">B2B</button></a>
                                <a href="{{route('settings.pages.edit', [23])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">B2B Small Appliances </button></a>
                                <a href="{{route('settings.pages.edit', [24])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">B2B Large Appliances</button></a>
                                <a href="{{route('settings.pages.edit', [25])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">B2B Commercial Appliances</button></a>
                                <a href="{{route('settings.pages.edit', [9])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Orders & Collect</button></a>
                                <a href="{{route('settings.pages.edit', [16])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Track Order</button></a>
                                <a href="{{route('settings.pages.edit', [2])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Return & Cancellations</button></a>
                                  <a href="{{route('settings.pages.edit', [3])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Ways to Pay</button></a>
                                  <a href="{{route('settings.pages.edit', [4])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Delivery/Installation</button></a>
                                  <a href="{{route('settings.pages.edit', [5])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Price Promise</button></a>
                                  <a href="{{route('settings.pages.edit', [6])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Installment Guide</button></a>
                                  <a href="{{route('settings.pages.edit', [7])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Privacy and Cookies Policy</button></a>
                                  <a href="{{route('settings.pages.edit', [8])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Terms and Conditions</button></a>
                                  <a href="{{route('settings.pages.edit', [10])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Discount Voucher</button></a>
                                  <a href="{{route('settings.pages.edit', [26])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Wishlist</button></a>
                                  <a href="{{route('settings.pages.edit', [14])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Cart</button></a>
                                  <a href="{{route('settings.pages.edit', [15])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Checkout</button></a>
                                  <a href="{{route('settings.pages.edit', [1])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Stores</button></a>
                                  <a href="{{route('settings.pages.edit', [35])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Sign Up</button></a>
                                  <a href="{{route('settings.pages.edit', [36])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Sign In</button></a>
                                <a href="{{route('settings.pages.edit', [27])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Compare LED TV In Pakistan TV</button></a>
                                <a href="{{route('settings.pages.edit', [28])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Compare Air Conditioner</button></a>
                                <a href="{{route('settings.pages.edit', [29])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Compare Fully Automatic Washing Machine</button></a>
                                <a href="{{route('settings.pages.edit', [30])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Compare Refrigerator</button></a>
                                <a href="{{route('settings.pages.edit', [31])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Compare Dishwasher</button></a>
                                <a href="{{route('settings.pages.edit', [32])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Compare Kitchen Appliances</button></a>
                                <a href="{{route('settings.pages.edit', [33])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Compare Home Small Domestic Appliances</button></a>
                                <a href="{{route('settings.pages.edit', [34])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Compare Coffee Machine</button></a>
                                {{--<a href="{{route('settings.pages.edit', [17])}}"><button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 mt-2 buttonStyling">Installation Guide</button></a>--}}
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
