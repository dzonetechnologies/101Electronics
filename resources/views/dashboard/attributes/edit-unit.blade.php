@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="edit-unit-page">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Units - Edit</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('unit');
                                ?>
                                <button type="button" class="btn btn-primary float-right"
                                    data-toggle="tooltip" title="Back"
                                    onclick="window.location.href='{{$Url}}';">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('unit.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="offset-md-1 col-md-10">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                          <div class="repeater-custom-show-hide">
                                              <div data-repeater-list="units">
                                                  @if(count($Units) > 0)
                                                    @foreach($Units as $unit)
                                                    <div data-repeater-item="" style="" class="mb-2">
                                                        <div class="row">
                                                           <div class="col-12">
                                                               <div class="card">
                                                                  <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3 mt-3">
                                                                            <label class="w-100">Name</label>
                                                                            <input type="text" name="unit_name" value="{{$unit->name}}" class="form-control"
                                                                                   placeholder="Unit" autocomplete="off" />
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <span data-repeater-delete=""
                                                                                  class="btn btn-outline-danger btn-sm float-right deleteColorBtn">
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
                                                                          <label class="w-100">Name</label>
                                                                          <input type="text" name="unit_name" class="form-control"
                                                                                 placeholder="Unit" autocomplete="off" />
                                                                      </div>
                                                                      <div class="col-md-12">
                                                                          <span data-repeater-delete=""
                                                                                class="btn btn-outline-danger btn-sm float-right deleteUnitBtn">
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
