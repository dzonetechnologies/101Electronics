@extends('dashboard.layouts.app')
@section('content')
    <style>
        .btn-div {
            margin-top: 30px;
        }

        .repeater-btn {
            padding: 9px;
        }
    </style>
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Product - Edit Details</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('product');
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
                        <form action="{{route('product.details.update')}}" method="post" enctype="multipart/form-data"
                              name="editProductForm">
                            @csrf
                            <input type="hidden" name="product_id" id="id" value="{{ $ProductId }}">
                            <div class="row spec-summary-section">
                                <div class="col-md-12">
                                    <h5 class="mb-2">SECTION I - SPEC SUMMARY</h5>
                                    <div class="repeater-custom-show-hide">
                                        <div data-repeater-list="spec_summaries">
                                            @if(!empty($spec_summaries))
                                                @foreach($spec_summaries as $index => $summary)
                                                    <div data-repeater-item="" style="" class="">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-5">
                                                                        <label for="title">Title</label>
                                                                        <input type="text" placeholder="Enter Title"
                                                                               name="spec_summaries[{{ $index }}][title]"
                                                                               class="form-control"
                                                                               value="{{ $summary->title }}">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label for="value">Value</label>
                                                                        <input type="text" placeholder="Enter Value"
                                                                               name="spec_summaries[{{ $index }}][value]"
                                                                               class="form-control"
                                                                               value="{{ $summary->value }}">
                                                                    </div>
                                                                    <div class="col-md-2 btn-div">
                                                                        <span data-repeater-delete=""
                                                                              class="btn btn-outline-danger btn-sm repeater-btn">
                                                                            <span class="far fa-trash-alt mr-1"></span>&nbsp; Delete
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div data-repeater-item="" style="" class="">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-md-5">
                                                                    <label for="title">Title</label>
                                                                    <input type="text"
                                                                           placeholder="Enter Title"
                                                                           name="title"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="value">Value</label>
                                                                    <input type="text"
                                                                           placeholder="Enter Value"
                                                                           name="value"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="col-md-2 btn-div">
                                                                    <span data-repeater-delete=""
                                                                          class="btn btn-outline-danger btn-sm repeater-btn">
                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp; Delete
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-sm-12 add-row-btn">
                                                <span data-repeater-create=""
                                                      class="btn btn-outline-success btn-sm float-right repeater-btn">
                                                    <span class="fa fa-plus"></span>&nbsp; Add
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row capacity-section">
                                <div class="col-md-12">
                                    <h5 class="mb-2">SECTION II</h5>
                                    <input type="text" class="form-control mb-3" name="section_heading" id="section_heading" value="{{$SectionHeading}}" placeholder="Section Heading">
                                    <div class="repeater-custom-show-hide">
                                        <div data-repeater-list="capacities">
                                            @if(!empty($capacities))
                                                @foreach($capacities as $index => $capacity)
                                                    <div data-repeater-item="" style="" class="">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-5">
                                                                        <label for="title">Title</label>
                                                                        <input type="text" placeholder="Enter Title"
                                                                               name="capacities[{{ $index }}][title]"
                                                                               class="form-control"
                                                                               value="{{ $capacity->title }}">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label for="value">Value</label>
                                                                        <input type="text" placeholder="Enter Value"
                                                                               name="capacities[{{ $index }}][value]"
                                                                               class="form-control"
                                                                               value="{{ $capacity->value }}">
                                                                    </div>
                                                                    <div class="col-md-2 btn-div">
                                                                    <span data-repeater-delete=""
                                                                          class="btn btn-outline-danger btn-sm repeater-btn">
                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp; Delete
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div data-repeater-item="" style="" class="">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-md-5">
                                                                    <label for="title">Title</label>
                                                                    <input type="text"
                                                                           placeholder="Enter Title"
                                                                           name="title"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="value">Value</label>
                                                                    <input type="text"
                                                                           placeholder="Enter Value"
                                                                           name="value"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="col-md-2 btn-div">
                                                                    <span data-repeater-delete=""
                                                                          class="btn btn-outline-danger btn-sm repeater-btn">
                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp; Delete
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-sm-12 add-row-btn">
                                                <span data-repeater-create=""
                                                      class="btn btn-outline-success btn-sm float-right repeater-btn">
                                                    <span class="fa fa-plus"></span>&nbsp; Add
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row dimension-section">
                                <div class="col-md-12">
                                    <h5 class="mb-2">SECTION III - DIMENSION</h5>
                                    <div class="repeater-custom-show-hide">
                                        <div data-repeater-list="dimensions">
                                            @if(!empty($dimensions))
                                                @foreach($dimensions as $index => $dimension)
                                                    <div data-repeater-item="" style="" class="">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-5">
                                                                        <label for="title">Title</label>
                                                                        <input type="text" placeholder="Enter Title"
                                                                               name="dimensions[{{ $index }}][title]"
                                                                               class="form-control"
                                                                               value="{{ $dimension->title }}">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label for="value">Value</label>
                                                                        <input type="text" placeholder="Enter Value"
                                                                               name="dimensions[{{ $index }}][value]"
                                                                               class="form-control"
                                                                               value="{{ $dimension->value }}">
                                                                    </div>
                                                                    <div class="col-md-2 btn-div">
                                                                    <span data-repeater-delete=""
                                                                          class="btn btn-outline-danger btn-sm repeater-btn">
                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp; Delete
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div data-repeater-item="" style="" class="">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-md-5">
                                                                    <label for="title">Title</label>
                                                                    <input type="text"
                                                                           placeholder="Enter Title"
                                                                           name="title"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="value">Value</label>
                                                                    <input type="text"
                                                                           placeholder="Enter Value"
                                                                           name="value"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="col-md-2 btn-div">
                                                                    <span data-repeater-delete=""
                                                                          class="btn btn-outline-danger btn-sm repeater-btn">
                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp; Delete
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-sm-12 add-row-btn">
                                                <span data-repeater-create=""
                                                      class="btn btn-outline-success btn-sm float-right repeater-btn">
                                                    <span class="fa fa-plus"></span>&nbsp; Add
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row general-feature-section">
                                <div class="col-md-12">
                                    <h5 class="mb-2">SECTION IV - GENERAL FEATURE</h5>
                                    <div class="repeater-custom-show-hide">
                                        <div data-repeater-list="general_features">
                                            @if(!empty($general_features))
                                                @foreach($general_features as $index => $general_feature)
                                                    <div data-repeater-item="" style="" class="">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-5">
                                                                        <label for="title">Title</label>
                                                                        <input type="text"
                                                                               placeholder="Enter Title"
                                                                               name="general_features[{{ $index }}][title]"
                                                                               class="form-control"
                                                                               value="{{ $general_feature->title }}">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label for="value">Value</label>
                                                                        <input type="text"
                                                                               placeholder="Enter Value"
                                                                               name="general_features[{{ $index }}][value]"
                                                                               class="form-control"
                                                                               value="{{ $general_feature->value }}">
                                                                    </div>
                                                                    <div class="col-md-2 btn-div">
                                                                    <span data-repeater-delete=""
                                                                          class="btn btn-outline-danger btn-sm repeater-btn">
                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp; Delete
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div data-repeater-item="" style="" class="">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-md-5">
                                                                    <label for="title">Title</label>
                                                                    <input type="text"
                                                                           placeholder="Enter Title"
                                                                           name="title"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="value">Value</label>
                                                                    <input type="text"
                                                                           placeholder="Enter Value"
                                                                           name="value"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="col-md-2 btn-div">
                                                                    <span data-repeater-delete=""
                                                                          class="btn btn-outline-danger btn-sm repeater-btn">
                                                                        <span class="far fa-trash-alt mr-1"></span>&nbsp; Delete
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-sm-12 add-row-btn">
                                                <span data-repeater-create=""
                                                      class="btn btn-outline-success btn-sm float-right repeater-btn">
                                                    <span class="fa fa-plus"></span>&nbsp; Add
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Save button -->
                            <div class="col-md-12 text-center mt-4">
                                <button class="btn btn-primary w-10" type="submit" id="saveProducts">Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
