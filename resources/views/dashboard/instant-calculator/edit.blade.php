@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="instant-calculator-add">
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Instant Calculator - Edit</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('instantcalculator');
                                ?>
                                <button type="button" class="btn btn-primary float-right"
                                        onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('instantcalculator.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="offset-md-3 col-md-6">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="repeater-custom-show-hide">
                                                <div data-repeater-list="installement_months">
                                                    @if(sizeof($InstantCalculator) > 0)
                                                        @foreach($InstantCalculator as $calculator)
                                                            <div data-repeater-item="" style="" class="mb-2">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-3 mt-3">
                                                                                        <label class="w-100">Month</label>
                                                                                        <input type="number" name="month"
                                                                                               class="form-control"
                                                                                               value="{{$calculator->month}}"
                                                                                               min="0" required
                                                                                               autocomplete="off"/>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                    <span data-repeater-delete=""
                                                                                          class="btn btn-outline-danger btn-sm float-right deletePayeeBtn">
                                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp;
                                                                                        Delete
                                                                                    </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div data-repeater-item="" style="" class="mb-2">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-3 mt-3">
                                                                                    <label class="w-100">Month</label>
                                                                                    <input type="number" name="month"
                                                                                           class="form-control"
                                                                                           min="0" required
                                                                                           autocomplete="off"/>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <span data-repeater-delete=""
                                                                                          class="btn btn-outline-danger btn-sm float-right deletePayeeBtn">
                                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp;
                                                                                        Delete
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
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

                                        <div class="col-12 text-center">
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
    </div>
@endsection