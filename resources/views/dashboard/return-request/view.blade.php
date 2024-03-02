@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="product-brands">
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Return Requests - View</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('return-request');
                                ?>
                                <button type="button" class="btn btn-primary float-right" onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="slug" id="slug">
                            <div class="row">
                                <div class="offset-md-2 col-md-8">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Name</label>
                                            <input type="text" name="name" value="{{$RequestDetails[0]->name}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="mb-1">Email</label>
                                            <input type="email" name="email" value="{{$RequestDetails[0]->email}}"
                                                   class="form-control" readonly>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Phone</label>
                                            <input type="text" name="phone" value="{{$RequestDetails[0]->phone}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="mb-1">Order No</label>
                                            <input type="email" name="email" value="{{$RequestDetails[0]->order_no}}"
                                                   class="form-control" readonly>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label  class="mb-1">Serial No</label>
                                            <input type="text" name="phone" value="{{$RequestDetails[0]->serial_no}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="mb-1">Reason</label>
                                            <textarea readonly name="reason" class="form-control"  cols="30" rows="10">{{$RequestDetails[0]->reason}}</textarea>
                                        </div>
                                        @if($RequestDetails[0]->status == '0')
                                        <div class="row offset-3">
                                            <div class="col-6 mb-3">
                                                <button  id="approve||{{$RequestDetails[0]->id}}" onclick="returnRequest(this.id,1);" data-toggle="tooltip" title="Approve Request" type="button" class="btn btn-success">Approve</button>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <button id="cancel||{{$RequestDetails[0]->id}}" onclick="returnRequest(this.id,2);" data-toggle="tooltip" title="Cancel Request" type="button" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.return-request.actionModal');
@endsection
