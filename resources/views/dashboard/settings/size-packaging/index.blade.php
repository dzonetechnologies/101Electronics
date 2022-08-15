@extends('dashboard.layouts.app')
@section('content')
<style media="screen">
  .buttonStyling{
    font-size: 16px !important;
    margin-bottom: 5px;
  }
</style>
    <div class="page-content" id="size_packaging_categories">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Size and Packaging - Categories</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                              <div class="col-md-12 text-center">
                                @foreach($Categories as $category)
                                <a href="{{route('settings.size-packaging.edit', [$category->id])}}">
                                  <button type="button" name="button" class="btn btn-secondary btn-lg w-50 pt-2 pb-2 buttonStyling">{{$category->title}}</button>
                                </a>
                                <br>
                                @endforeach
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
