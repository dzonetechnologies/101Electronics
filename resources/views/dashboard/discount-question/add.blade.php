@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="discount-vouchers-add">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Discount Question</h4>
                            </div>
                            {{--<div class="d-flex align-items-center flex-wrap text-nowrap">--}}
                                {{--<button type="button" class="btn btn-primary float-right" onclick="window.location.href='{{route('discount.question')}}';">--}}
                                    {{--<i class="fas fa-arrow-circle-left"></i>--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('discountQuestion.store') }}" method="POST" enctype="multipart/form-data">
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
                                <div class="col-md-12 mb-3 mt-1">
                                    <div class="repeater-custom-show-hide">
                                        <div data-repeater-list="questions">
                                            @foreach($DiscountData as $index => $discountQuestion)
                                            <div data-repeater-item="" style="" class="mb-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="" class="add_quiz_question_label">Question {{$index + 1}}</label>
                                                                            <input type="text"
                                                                                   name="add_quiz_question"
                                                                                   class="form-control"
                                                                                   autocomplete="off"
                                                                                   value="{{$discountQuestion->question}}"
                                                                                   required/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Choice 1</label>
                                                                            <input type="text"
                                                                                   name="add_quiz_choice1"
                                                                                   class="form-control"
                                                                                   autocomplete="off"
                                                                                   value="{{$discountQuestion->choice1}}"
                                                                                   required/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Choice 2</label>
                                                                            <input type="text"
                                                                                   name="add_quiz_choice2"
                                                                                   class="form-control"
                                                                                   autocomplete="off"
                                                                                   value="{{$discountQuestion->choice2}}"
                                                                                   required/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Choice 3</label>
                                                                            <input type="text"
                                                                                   name="add_quiz_choice3"
                                                                                   class="form-control"
                                                                                   autocomplete="off"
                                                                                   value="{{$discountQuestion->choice3}}"
                                                                                   required/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Choice 4</label>
                                                                            <input type="text"
                                                                                   name="add_quiz_choice4"
                                                                                   class="form-control"
                                                                                   autocomplete="off"
                                                                                   value="{{$discountQuestion->choice4}}"
                                                                                   required/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="">Answer</label>
                                                                            <select name="add_quiz_answer"
                                                                                    class="form-control"
                                                                                    required>
                                                                                @if($discountQuestion->answer == 1)
                                                                                    <option value="" disabled="disabled">Select Answer</option>
                                                                                    <option value="1" selected>Choice 1</option>
                                                                                    <option value="2">Choice 2</option>
                                                                                    <option value="3">Choice 3</option>
                                                                                    <option value="4">Choice 4</option>
                                                                                @elseif($discountQuestion->answer == 2)
                                                                                    <option value="" disabled="disabled">Select Answer</option>
                                                                                    <option value="1">Choice 1</option>
                                                                                    <option value="2" selected>Choice 2</option>
                                                                                    <option value="3">Choice 3</option>
                                                                                    <option value="4">Choice 4</option>
                                                                                @elseif($discountQuestion->answer == 3)
                                                                                    <option value="" disabled="disabled">Select Answer</option>
                                                                                    <option value="1">Choice 1</option>
                                                                                    <option value="2">Choice 2</option>
                                                                                    <option value="3" selected>Choice 3</option>
                                                                                    <option value="4">Choice 4</option>
                                                                                @elseif($discountQuestion->answer == 4)
                                                                                    <option value="" disabled="disabled">Select Answer</option>
                                                                                    <option value="1">Choice 1</option>
                                                                                    <option value="2">Choice 2</option>
                                                                                    <option value="3">Choice 3</option>
                                                                                    <option value="4" selected>Choice 4</option>
                                                                                @endif
                                                                            </select>
                                                                        </div>
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
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right mt-1">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
