@extends('site.layouts.app')
@section('content')
    <style>

        .clr{

        }
        a:focus {
            color: #C71837;
        }

        li{
            list-style-type: none;
        }
    </style>
    <section>
        <div class="container">
            <div class="row mt-4 mb-5">
                <!-- Banner image -->
                @if(isset($PageDetails[0]->banner_img))
                    <div class="col-md-12 mb-5 d-none d-md-block">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img)}}" width="100%"
                             height="150" alt="Price Promise Banner Image">
                    </div>
                @endif
                @if(isset($PageDetails[0]->banner_img_mobile))
                    <div class="col-md-12 mb-5 d-md-none">
                        <img src="{{asset('public/storage/page-banners/' . $PageDetails[0]->banner_img_mobile)}}"
                             width="100%" height="150" alt="Price Promise Banner Image">
                    </div>
            @endif
            <!-- Content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-0 d-flex align-items-center fs-13 text-custom-primary">
                            <div class="w-25 py-3 cursor-pointer text-center card-header-tabs-active" id="tab1"
                                 onclick="ChangeTab('tab1', 'tab1Content');">
                                Care & Repair
                            </div>
                            <div class="w-25 py-3 cursor-pointer text-center" id="tab2"
                                 onclick="ChangeTab('tab2', 'tab2Content');">
                                Pricing
                            </div>
                            <div class="w-25 py-3 cursor-pointer text-center" id="tab3"
                                 onclick="ChangeTab('tab3', 'tab3Content');">
                                Offers
                            </div>
                            <div class="w-25 py-3 cursor-pointer text-center" id="tab4"
                                 onclick="ChangeTab('tab4', 'tab4Content');">
                                FAQs
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="tab1Content">
                                <div class="row">
                                    <div class="col-md-12 text-custom-primary text-center fs-11">
                                        Explore these pages
                                    </div>
                                    <div class="col-md-12 text-center fs-14 mb-3">
                                        <a href="{{route('CareRepairRoute')}}"><span class="text-custom-primary">What's Care & Repair</span></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a
                                                href="{{route('TermsConditionsRoute')}}"><span
                                                    class="text-custom-primary">Terms & Conditions</span></a>
                                    </div>
                                </div>

                                <div class="row">
                                    <p>
                                        {!! $CareRepair[0]->description  !!}
                                    </p>

                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-3 mb-2">
                                        <div class="icon-card">
                                            <span>
                                                <i class="fas fa-hands-helping"></i>
                                            </span>
                                            <div class="d-flex align-items-center h-100">
                                                <div class="m-auto w-75">
                                                    <p class="mb-0 fs-14 text-center text-black line-height-1-3">
                                                        {!! $CareRepair[0]->get_care_repair  !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <div class="icon-card">
                                            <span>
                                                <i class="fa fa-arrow-left"></i>
                                                <i class="fa fa-arrow-right"></i>
                                            </span>
                                            <div class="d-flex align-items-center h-100">
                                                <div class="m-auto w-75">
                                                    <p class="mb-0 fs-14 text-center text-black line-height-1-3">
                                                        {!! $CareRepair[0]->inspection  !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <div class="icon-card">
                                            <span>
                                                <i class="fas fa-clock"></i>
                                            </span>
                                            <div class="d-flex align-items-center h-100">
                                                <div class="m-auto w-75">
                                                    <p class="mb-0 fs-14 text-center text-black line-height-1-3">
                                                        {!! $CareRepair[0]->day_fix  !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <div class="icon-card">
                                            <span>
                                                <i class="fas fa-money-bill"></i>
                                            </span>
                                            <div class="d-flex align-items-center h-100">
                                                <div class="m-auto w-75">
                                                    <p class="mb-0 fs-14 text-left text-black line-height-1-3">
                                                        {!! $CareRepair[0]->visit_charges  !!}

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="tab2Content" style="display: none;">
                                <p>
                                    {!! $PricingDetail[0]->description !!}
                                </p>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p style="text-align: center;font-size: 15px;background-color: gainsboro;color: black">
                                            Delivery & Collection</p>
                                        <h6 style="font-size: 13px;text-align: center;font-weight:400">{!! $DeliveryDetails[0]->delivery_collection !!}</h6>
                                        <table class="table ">
                                            <thead>
                                            <tr>
                                                <th style="font-size:13px">Description</th>
                                                <th style="font-size:13px">PKR</th>
                                                <th style="font-size:13px">USD</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="font-size:12px">Warranty</td>
                                                <td style="font-size:12px">
                                                    @if($DeliveryDetails[0]->warranty_pkr == '')
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @else
                                                        {{$DeliveryDetails[0]->warranty_pkr}}</td>
                                                @endif
                                                <td style="font-size:12px">
                                                    @if($DeliveryDetails[0]->warranty_usd == '')
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @else
                                                        {{$DeliveryDetails[0]->warranty_usd}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td style="font-size:12px">Non-Warranty</td>
                                                <td style="font-size:12px">
                                                    @if($DeliveryDetails[0]->nonwarranty_pkr == '')
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @else
                                                        {{$DeliveryDetails[0]->nonwarranty_pkr}}</td>
                                                @endif
                                                <td style="font-size:12px">
                                                    @if($DeliveryDetails[0]->nonwarranty_usd == '')
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @else
                                                        {{$DeliveryDetails[0]->nonwarranty_usd}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td style="font-size:12px">Pick-up charges</td>
                                                <td style="font-size:12px">
                                                    @if($DeliveryDetails[0]->pickup_pkr== '')
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @else
                                                        {{$DeliveryDetails[0]->pickup_pkr}}</td>
                                                @endif
                                                <td style="font-size:12px">
                                                    @if($DeliveryDetails[0]->pickup_usd== '')
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @else
                                                        {{$DeliveryDetails[0]->pickup_usd}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td style="font-size:12px">Home Checkup</td>
                                                <td style="font-size:12px">
                                                    @if($DeliveryDetails[0]->checkup_pkr == "")
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @else
                                                        {{$DeliveryDetails[0]->checkup_pkr}}</td>
                                                @endif
                                                <td style="font-size:12px">
                                                    @if($DeliveryDetails[0]->checkup_usd == "")
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @else
                                                        {{$DeliveryDetails[0]->checkup_usd}}</td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <p style="text-align: center;font-size: 15px;background-color: gainsboro;color: black">
                                            Product Damage</p>
                                        <p style="text-align: center;font-size: 13px;">Installation Problem</p>
                                        <p style="text-align: center;font-size: 12px;background-color: gainsboro;margin-top:-11px">
                                            Rate:&nbsp;{{$DeliveryDetails[0]->installation_problem}}</p>
                                        <p style="text-align: center;font-size: 13px;">Digital Display Problem</p>
                                        <p style="text-align: center;font-size: 12px;background-color: gainsboro;margin-top:-11px">
                                            Rate:&nbsp;{{$DeliveryDetails[0]->display_problem}}</p>
                                        <p style="text-align: center;font-size: 13px;">Hardware Problem</p>
                                        <p style="text-align: center;font-size: 12px;background-color: gainsboro;margin-top:-11px">
                                            Rate:&nbsp;{{$DeliveryDetails[0]->hardware_problem}}</p>
                                        <p style="text-align: center;font-size: 13px;">Product Breakdown</p>
                                        <p style="text-align: center;font-size: 12px;background-color: gainsboro;margin-top:-11px">
                                            Rate:&nbsp;{{$DeliveryDetails[0]->product_breakdown}}</p>
                                        <p style="text-align: center;font-size: 13px;">Unknown Error Occur</p>
                                        <p style="text-align: center;font-size: 12px;margin-top: -20px;background-color: gainsboro;margin-top:-11px">
                                            Rate:&nbsp;{{$DeliveryDetails[0]->error_occur}}</p>
                                        <p style="text-align: center;font-size: 13px;">Not Working At All</p>
                                        <p style="text-align: center;font-size: 12px;margin-top: -20px;background-color: gainsboro;margin-top:-11px">
                                            Rate:&nbsp;{{$DeliveryDetails[0]->not_working}}</p>
                                    </div>

                                    <div class="col-md-2 ">
                                        <p style="text-align: center;font-size: 15px;background-color:gainsboro;color: black">
                                            Parts & Design
                                        </p>
                                        <li style="text-align:center;margin-bottom: 10px">
                                            <input type="hidden" value="all" id="title">
                                            <a href="javascript:void(0);" onclick="CareRepairTableLoad(this);" data-type="all" style="font-size:14px;">
                                                All
                                            </a>
                                        </li>
                                        @foreach($DeliveryParts as  $index => $parts)
                                        <li style="text-align:center;margin-bottom: 10px">
                                            <input type="hidden" value="{{$parts->title}}" id="title">
                                            <a href="javascript:void(0);" onclick="CareRepairTableLoad(this);" data-type="{{$parts->title}}" style="font-size:14px;">
                                                {{$parts->title}}
                                            </a>
                                        </li>
                                       @endforeach
                                    </div>
                                    <div class="col-md-6" id="serviceRateListDiv1" style="overflow-x: auto;">
                                        <p style="text-align: center;font-size: 15px;background-color: gainsboro; color: black; ">
                                            Service Rate List
                                        </p>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th style="font-size:13px">Description</th>
                                                <th style="font-size:13px;">TV</th>
                                                <th style="font-size:13px">AC</th>
                                                <th style="font-size:13px">WM</th>
                                                <th style="font-size:13px">REF</th>
                                                <th style="font-size:13px">DW</th>
                                                <th style="font-size:13px">OTHERS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($RateList as $list)
                                                <tr>
                                                    <td style="font-size:12px">{{$list->description}}</td>
                                                    <td style="font-size:12px;">
                                                        @if($list->tv =="")
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        @else
                                                            {{$list->tv}}</td>
                                                    @endif
                                                    <td style="font-size:12px">
                                                        @if($list->ac =="")
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        @else
                                                            {{$list->ac}}</td>
                                                    @endif
                                                    <td style="font-size:12px">
                                                        @if($list->wm =="")
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        @else
                                                            {{$list->wm}}</td>
                                                    @endif
                                                    <td style="font-size:12px">
                                                        @if($list->rff =="")
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        @else
                                                            {{$list->rff}}</td>
                                                    @endif
                                                    <td style="font-size:12px">
                                                        @if($list->dw =="")
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        @else
                                                            {{$list->dw}}</td>
                                                    @endif
                                                    <td style="font-size:12px">
                                                        @if($list->others =="")
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        @else
                                                            {{$list->others}}</td>
                                                    @endif

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6" id="serviceRateListDiv2" style="display: none; overflow-x: auto;"></div>
                                </div>
                            </div>

                            <div id="tab3Content" style="display: none;">
                                {!! $OfferDetail[0]->description  !!}
                            </div>

                            <div id="tab4Content" style="display: none;">
                                @foreach($FaqDetails as $faq)
                                    <p style="margin-bottom: 0.9em">
                                        <strong>{{$faq->question}}</strong>
                                    </p>
                                    <p style="margin-bottom: 0.9em">
                                        {{$faq->answer}}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
