@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="settings-form">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Care & Repair - FAQ'S</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('CareRepair.faq.update')}}" method="POST" enctype="multipart/form-data">
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
                                <div class="col-md-12">
                                    <div class="repeater-custom-show-hide">
                                        <div data-repeater-list="faq">
                                            @if(sizeof($FaqDetails) > 0)
                                                @foreach($FaqDetails as $index => $faq)
                                                    <div data-repeater-item="">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="mb-1">Question</label>
                                                                            <input class="form-control"
                                                                                   value="{{$faq->question}}"
                                                                                   type="text" name="question"
                                                                                   id="question">
                                                                            <br>
                                                                            <label for="facebook_pixel" class="mb-1">Answer</label>
                                                                            <textarea class="form-control" name="answer"
                                                                                      id="answer" rows="8"
                                                                                      cols="80">{{$faq->answer}}</textarea>
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
                                                @endforeach
                                            @else
                                                <div data-repeater-item="">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="mb-1">Question</label>
                                                                        <input class="form-control"
                                                                               type="text" name="question"
                                                                               id="question">
                                                                        <br>
                                                                        <label for="facebook_pixel"
                                                                               class="mb-1">Answer</label>
                                                                        <textarea class="form-control"
                                                                                  name="answer" id="answer"
                                                                                  rows="8"
                                                                                  cols="80"></textarea>
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
                                            @endif
                                        </div>
                                        {{--End of data repeater list--}}
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
                                <div class="col-12 text-center mt-5">
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