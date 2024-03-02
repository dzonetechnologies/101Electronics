@extends('site.layouts.app')
@section('content')
    <style>
        .account-tabs a:hover {
            color: {{\App\Helpers\SiteHelper::settings()['PrimaryColor']}};
        }

        .account-tabs a.active {
            background-color: {{\App\Helpers\SiteHelper::settings()['PrimaryColor']}}  !important;
        }
    </style>

    <!-- BREADCRUMB AREA START -->
    <div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image "> {{--  data-bs-bg="{{asset('public/assets/img/bg/14.jpg')}}"--}}
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner">
                        <h1 class="page-title">My Account</h1>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="{{route('HomeRoute')}}"><span class="text-custom-primary"><i
                                                    class="fas fa-home"></i></span> Website</a></li>
                                <li class="text-custom-primary">My Account</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->

    <input type="hidden" id="customer_id" value="{{$CustomerInformation[0]->id}}">
    <input type="hidden" id="billing_address" value="{{$CustomerInformation[0]->billing_address}}">
    <input type="hidden" id="billing_city" value="{{$CustomerInformation[0]->billing_city}}">
    <input type="hidden" id="billing_state" value="{{$CustomerInformation[0]->billing_state}}">
    <input type="hidden" id="billing_zipcode" value="{{$CustomerInformation[0]->billing_zipcode}}">
    <input type="hidden" id="shipping_address" value="{{$CustomerInformation[0]->shipping_address}}">
    <input type="hidden" id="shipping_city" value="{{$CustomerInformation[0]->shipping_city}}">
    <input type="hidden" id="shipping_state" value="{{$CustomerInformation[0]->shipping_state}}">
    <input type="hidden" id="shipping_zipcode" value="{{$CustomerInformation[0]->shipping_zipcode}}">

    <!-- WISHLIST AREA START -->
    <div class="liton__wishlist-area pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- PRODUCT TAB AREA START -->
                    <div class="ltn__product-tab-area">
                        <div class="container">
                            <div class="row">
                                @if(\Illuminate\Support\Facades\Session::has('success'))
                                    <div class="col-lg-12">
                                        <div class="alert alert-success">
                                            {!! \Illuminate\Support\Facades\Session::get('success') !!}
                                        </div>
                                    </div>
                                @endif
                                @if(\Illuminate\Support\Facades\Session::has('error'))
                                    <div class="col-lg-12">
                                        <div class="alert alert-danger">
                                            {!! \Illuminate\Support\Facades\Session::get('error') !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-lg-4">
                                    <div class="ltn__tab-menu-list mb-50">
                                        <div class="nav account-tabs">
                                            <a <?php if (!$List) {
                                                echo 'class="active show"';
                                            } ?> data-bs-toggle="tab" href="#liton_tab_1_1">Dashboard <i
                                                        class="fas fa-home"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_2">Orders <i
                                                        class="fas fa-file-alt"></i></a>
                                            <a <?php if ($List) {
                                                echo 'class="active show"';
                                            } ?> data-bs-toggle="tab" href="#liton_tab_1_3">Wishlist <i
                                                        class="far fa-heart"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_4">Address <i
                                                        class="fas fa-map-marker-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_1_5">Account Details <i
                                                        class="fas fa-user"></i></a>
                                            <a href="javascript:void(0);"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout
                                                <i class="fas fa-sign-out-alt"></i></a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="tab-content">
                                        <div class="tab-pane fade <?php if (!$List) {
                                            echo 'active show';
                                        } ?>" id="liton_tab_1_1">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>Hello <strong>{{$CustomerInformation[0]->first_name . ' ' . $CustomerInformation[0]->last_name}}!</strong></p>
                                                <p>From your account dashboard you can view your
                                                    <span>recent orders</span>, manage your <span>billing and shipping addresses</span>,
                                                    and <span>edit your password and account details</span>.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_1_2">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="table-responsive">
                                                    <table class="table table-striped w-100" id="accountOrdersTable">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Invoice #</th>
                                                            <th>Date</th>
                                                            <th>Order Total</th>
                                                            <th>Notes</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade <?php if ($List) {
                                            echo 'active show';
                                        } ?>" id="liton_tab_1_3">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="row">
                                                @php
                                                    $Products = Illuminate\Support\Facades\DB::table('products')
                                                                ->join('wish_lists', 'products.id', '=', 'wish_lists.product_id')
                                                                ->where('products.deleted_at', '=', null)
                                                                ->where('wish_lists.user_id', '=', $CustomerInformation[0]->user_id)
                                                                ->select('products.*')
                                                                ->orderBy('rating', 'DESC')
                                                                ->get();
                                                    $AccountPage = true;
                                                    $index = 0;
                                                @endphp
                                                <!-- Product - Start -->
                                                @include('site.partials.product-template')
                                                <!-- Product - End -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_1_4">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>The following addresses will be used on the checkout page by
                                                    default.</p>
                                                <div class="row">
                                                    <div class="col-md-6 col-12 learts-mb-30">
                                                        <h4>Billing Address
                                                            <small class="badge-custom-danger cursor-pointer" onclick="EditAddress('Billing');">edit</small>
                                                        </h4>
                                                        <address>
                                                            <p class="mb-2"><strong>{{$CustomerInformation[0]->first_name . ' ' . $CustomerInformation[0]->last_name}}</strong></p>
                                                            <?php
                                                            $Address = "";
                                                            if($CustomerInformation[0]->billing_address != ''){
                                                                $Address .= $CustomerInformation[0]->billing_address . '<br>';
                                                            }
                                                            if($CustomerInformation[0]->billing_city != ''){
                                                                $Address .= $CustomerInformation[0]->billing_city;
                                                            }
                                                            if($CustomerInformation[0]->billing_state != ''){
                                                                $Address .= ', ' . $CustomerInformation[0]->billing_state . ' ';
                                                            }
                                                            $Address .= $CustomerInformation[0]->billing_zipcode;
                                                            if($Address != ''){
                                                                echo '<p class="mb-2">' . $Address . '</p>';
                                                            }
                                                            ?>
                                                            <p class="mb-0">Mobile: <b>{{$CustomerInformation[0]->phone}}</b></p>
                                                        </address>
                                                    </div>
                                                    <div class="col-md-6 col-12 learts-mb-30">
                                                        <h4>Shipping Address
                                                            <small class="badge-custom-danger cursor-pointer" onclick="EditAddress('Shipping');">edit</small>
                                                        </h4>
                                                        <address>
                                                            <p class="mb-2"><strong>{{$CustomerInformation[0]->first_name . ' ' . $CustomerInformation[0]->last_name}}</strong></p>
                                                            <?php
                                                            $Address = "";
                                                            if($CustomerInformation[0]->shipping_address != ''){
                                                                $Address .= $CustomerInformation[0]->shipping_address . '<br>';
                                                            }
                                                            if($CustomerInformation[0]->shipping_city != ''){
                                                                $Address .= $CustomerInformation[0]->shipping_city;
                                                            }
                                                            if($CustomerInformation[0]->shipping_state != ''){
                                                                $Address .= ', ' . $CustomerInformation[0]->shipping_state . ' ';
                                                            }
                                                            $Address .= $CustomerInformation[0]->shipping_zipcode;
                                                            if($Address != ""){
                                                                echo '<p class="mb-2">' . $Address . '</p>';
                                                            }
                                                            ?>
                                                            <p class="mb-0">Mobile: <b>{{$CustomerInformation[0]->phone}}</b></p>
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_1_5">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>The following addresses will be used on the checkout page by
                                                    default.</p>
                                                <div class="ltn__form-box">
                                                    <form action="{{route('home.account.details.update')}}" method="post" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="row mb-50">
                                                            <div class="col-md-6">
                                                                <label for="ltn__first_name">First name:</label>
                                                                <input type="text" id="ltn__first_name" name="ltn__first_name" value="{{$CustomerInformation[0]->first_name}}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="ltn__last_name">Last name:</label>
                                                                <input type="text" id="ltn__last_name" name="ltn__last_name" value="{{$CustomerInformation[0]->last_name}}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Display Email:</label>
                                                                <input type="email" name="ltn__email"
                                                                       placeholder="example@example.com" value="{{$CustomerInformation[0]->email}}" readonly>
                                                            </div>
                                                        </div>
                                                        <fieldset>
                                                            <legend>Password change</legend>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Current password (leave blank to leave
                                                                        unchanged):</label>
                                                                    <input type="password" name="ltn__old_password">
                                                                    <label>New password (leave blank to leave
                                                                        unchanged):</label>
                                                                    <input type="password" name="ltn__new_password">
                                                                    <label>Confirm new password:</label>
                                                                    <input type="password" name="ltn__confirm_password">
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="btn-wrapper">
                                                            <button type="submit"
                                                                    class="theme-btn-2 btn btn-effect-2 text-uppercase">
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PRODUCT TAB AREA END -->
                </div>
            </div>
        </div>
    </div>
    <!-- WISHLIST AREA START -->

    @include('site.includes.editAddressModal')
@endsection