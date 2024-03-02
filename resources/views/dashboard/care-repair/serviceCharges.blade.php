@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="settings-form">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Delivery & Collection - Edit</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('CareRepair.serviceCharges.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                <div class=" col-md-12">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label  class="mb-1" style="font-size: 17px">Delivery and Collection</label>
                                            <textarea name="delivery_collection" id="delivery_collection"
                                                      rows="100" cols="80">{{$ServiceDetails[0]->delivery_collection}}</textarea>
                                        </div>
                                        <div class="col-12 mb-3" style="overflow-x: auto;">
                                            <table class="table" style="table-layout: fixed;">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Description</th>
                                                    <th scope="col" style="text-align: center">PKR</th>
                                                    <th scope="col" style="text-align: center">USD</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Warranty</td>
                                                    <td><input type="text" class="form-control" name="warranty_pkr" value="{{$ServiceDetails[0]->warranty_pkr}}"></td>
                                                    <td><input type="text" class="form-control" name="warranty_usd" value="{{$ServiceDetails[0]->warranty_usd}}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Non-Warranty</td>
                                                    <td><input type="text" class="form-control" name="nonwarranty_pkr" value="{{$ServiceDetails[0]->nonwarranty_pkr}}"></td>
                                                    <td><input type="text" class="form-control" name="nonwarranty_usd" value="{{$ServiceDetails[0]->nonwarranty_usd}}" ></td>
                                                </tr>
                                                <tr>
                                                    <td>Pick-up<br>charges</td>
                                                    <td><input type="text" class="form-control" name="pickup_pkr" value="{{$ServiceDetails[0]->pickup_pkr}}" ></td>
                                                    <td><input type="text" class="form-control" name="pickup_usd" value="{{$ServiceDetails[0]->pickup_usd}}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Home<br>Checkup</td>
                                                    <td><input type="text" class="form-control" name="checkup_pkr" value="{{$ServiceDetails[0]->checkup_pkr}}"></td>
                                                    <td><input type="text" class="form-control" name="checkup_usd" value="{{$ServiceDetails[0]->checkup_usd}}"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-12 mb-3" style="overflow-x: auto;">
                                            <label style="font-size: 17px"  class="mb-1">Product Damage</label>
                                            <table class="table" style="table-layout: fixed;">
                                                <tbody>
                                                    <tr>
                                                        <td>Installation<br>Problem Rate:</td>
                                                        <td><input type="text" class="form-control" name="installation_problem" value="{{$ServiceDetails[0]->installation_problem}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Digital Display<br>Problem Rate:</td>
                                                        <td><input type="text" class="form-control" name="display_problem" value="{{$ServiceDetails[0]->display_problem}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hardware Problem<br>Rate:</td>
                                                        <td><input type="text" class="form-control" name="hardware_problem" value="{{$ServiceDetails[0]->hardware_problem}}" ></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product Breakdown<br>Rate:</td>
                                                        <td><input type="text" class="form-control" name="product_breakdown" value="{{$ServiceDetails[0]->product_breakdown}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Unknown Error<br>Occur Rate:</td>
                                                        <td><input type="text" class="form-control" name="error_occur" value="{{$ServiceDetails[0]->error_occur}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Not Working<br>At All Rate:</td>
                                                        <td><input type="text" class="form-control" name="not_working" value="{{$ServiceDetails[0]->not_working}}"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class=" col-12">
                                            <label style="font-size: 17px"  class="mb-1">Parts & Design</label>
                                            <div class="repeater-custom-show-hide">
                                                <div data-repeater-list="parts_design">
                                                    @foreach($DeliveryParts as $index => $parts)
                                                        <div data-repeater-item="" style="" class="mb-3">
                                                            <div class="row">
                                                                <input type="hidden" value="{{$parts->id}}" name="id">
                                                                <div class="col-12 col-md-12 col-lg-6">
                                                                    <div class="row">
                                                                        <div class="col-12 mb-3 mt-3">
                                                                            <input class="form-control" type="text" name="parts_design"      value="{{$parts->title}}">
                                                                        </div>
                                                                        <div class="col-12 offset-md-6 col-md-6">
                                                                            <span data-repeater-delete=""
                                                                                  class="btn btn-outline-danger btn-sm float-right">
                                                                                <span class="far fa-trash-alt mr-1"></span>&nbsp;
                                                                                Delete
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-12 col-md-12 col-lg-6">
                                                        <span data-repeater-create=""
                                                              class="btn btn-outline-success float-right btn-sm">
                                                            <span class="fa fa-plus"></span>&nbsp;
                                                            Add
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3 text-center">
                                            <button class="btn btn-outline-success" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{--Card 2--}}
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="margin-top: 20px">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Service Rate List - Edit</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('CareRepair.rateList.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class=" col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="repeater-custom-show-hide">
                                                <div data-repeater-list="rate_list">
                                                    @foreach($RateListDetails as $index => $list)
                                                        <div data-repeater-item="" style="" class="mb-3">
                                                            <div class="row">
                                                                <input type="hidden" value="{{$list->id}}" name="id">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-md-3 mb-3 mt-3">
                                                                            <label>Description</label>
                                                                            <input type="text"
                                                                                   name="description"
                                                                                   class="form-control" value="{{$list->description}}" />
                                                                        </div>
                                                                        <div class="col-md-3 mb-3 mt-3">
                                                                            <label>TV</label>
                                                                            <input type="text"
                                                                                   name="tv"
                                                                                   class="form-control" value="{{$list->tv}}" />
                                                                        </div>
                                                                        <div class="col-md-3 mb-3 mt-3">
                                                                            <label>AC</label>
                                                                            <input type="text"
                                                                                   name="ac"
                                                                                   class="form-control" value="{{$list->ac}}" />
                                                                        </div>
                                                                        <div class="col-md-3 mb-3 mt-3">
                                                                            <label>WM</label>
                                                                            <input type="text"
                                                                                   name="wm"
                                                                                   class="form-control" value="{{$list->wm}}" />
                                                                        </div>
                                                                        <div class="col-md-3 mb-3 mt-3">
                                                                            <label>RFF</label>
                                                                            <input type="text"
                                                                                   name="rff"
                                                                                   class="form-control" value="{{$list->rff}}" />
                                                                        </div>
                                                                        <div class="col-md-3 mb-3 mt-3">
                                                                            <label>DW</label>
                                                                            <input type="text"
                                                                                   name="dw"
                                                                                   class="form-control" value="{{$list->dw}}" />
                                                                        </div>
                                                                        <div class="col-md-3 mb-3 mt-3">
                                                                            <label>Others</label>
                                                                            <input type="text"
                                                                                   name="others"
                                                                                   class="form-control" value="{{$list->others}}" />
                                                                        </div>
                                                                        <div class=" offset-6 col-md-6">
                                                                            <span data-repeater-delete=""
                                                                                  class="btn btn-outline-danger btn-sm float-right">
                                                                                <span class="far fa-trash-alt mr-1"></span>&nbsp;
                                                                                Delete
                                                                            </span>
                                                                         </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-sm-12">
                                                        <span data-repeater-create=""
                                                              class="btn btn-outline-success btn-sm float-right">
                                                            <span class="fa fa-plus"></span>&nbsp;
                                                            Add
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-outline-success" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection