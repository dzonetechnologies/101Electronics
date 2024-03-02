@extends('dashboard.layouts.app')
@section('content')
    <div class="page-content" id="product-brands">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Quote Requests - View</h4>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <?php
                                $Url = route('quote-request');
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Name</label>
                                            <input type="text" name="name" value="{{$QuoteRequestDetails[0]->name}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="mb-1">Email</label>
                                            <input type="email" name="email" value="{{$QuoteRequestDetails[0]->email}}"
                                                   class="form-control" readonly>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Phone</label>
                                            <input type="text" name="phone" value="{{$QuoteRequestDetails[0]->phone}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="mb-1">City</label>
                                            <input type="email" name="email" value="{{$QuoteRequestDetails[0]->city}}"
                                                   class="form-control" readonly>
                                        </div>
                                        {{--<div class="col-6 mb-3">
                                            <label  class="mb-1">Product</label>
                                            <input type="text" name="phone" value="{{$QuoteRequestDetails[0]->product}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>--}}
                                        {{--<div class="col-6 mb-3">
                                            <label  class="mb-1">Category</label>
                                            <input type="text" name="phone" value="{{$QuoteRequestDetails[0]->sub_sub_title}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Model No</label>
                                            <input type="text" name="phone" value=""
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>--}}
                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Time Frame</label>
                                            <input type="text" name="phone" value="{{$QuoteRequestDetails[0]->time_frame}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label  class="mb-1">Quantity</label>
                                            <input type="text" name="phone" value="{{$QuoteRequestDetails[0]->quantity}}"
                                                   class="form-control" maxlength="100" readonly required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="mb-1">Comment</label>
                                            <textarea readonly name="reason" class="form-control"  cols="30" rows="10">{{$QuoteRequestDetails[0]->comments}}</textarea>
                                        </div>
                                        @if($QuoteRequestDetails[0]->status == '0')
                                            <div class="row offset-3">
                                                <div class="col-6 mb-3">
                                                    <button  id="approve||{{$QuoteRequestDetails[0]->id}}" onclick="returnQuoteRequest(this.id,1);" data-toggle="tooltip" title="Approve Request" type="button" class="btn btn-success">Approve</button>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <button id="cancel||{{$QuoteRequestDetails[0]->id}}" onclick="returnQuoteRequest(this.id,2);" data-toggle="tooltip" title="Cancel Request" type="button" class="btn btn-danger">Cancel</button>
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

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-3 mb-md-0">Products</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ProductIds = $QuoteRequestDetails[0]->product;
                                        $Products = \Illuminate\Support\Facades\DB::table('products')
                                                ->whereIn('id', explode(',', $ProductIds))
                                                ->where('deleted_at', '=', null)
                                                ->get();
                                        foreach ($Products as $index => $product) {
                                            echo '<tr>';
                                            echo '<td>' . ($index + 1) . '</td>';
                                            echo '<td>' . $product->name . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.quote-request.actionModal');
@endsection
