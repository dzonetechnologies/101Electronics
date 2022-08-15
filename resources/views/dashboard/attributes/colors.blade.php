@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="instant-calculator">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Colors</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                    $Url = route('color.edit');
                                ?>
                                <button type="button" class="btn btn-primary float-right"
                                        data-toggle="tooltip" title="Edit"
                                        onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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

                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="colorTable">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%;">Sr. No.</th>
                                            <th style="width: 45%;">Color Name</th>
                                            <th style="width: 45%;">Color Code</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
