@extends('site.layouts.app')
@section('content')
    <section class="mt-5 mb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php
                        $Image = "";
                        if($Status == 'success'){
                            $Image = asset('public/assets/images/checked.png');
                        } else {
                            $Image = asset('public/assets/images/failed.png');
                        }
                    ?>
                    <img src="{{$Image}}" alt="Order Image" class="img-fluid" style="width: 150px;" />
                </div>
                <div class="col-md-12 mt-3 text-center text-dark fs-large">
                    You Order has been completed. You order no is <b>{{$InvoiceNo}}</b>. <br>For order tracking, please visit this page <a href="{{route('track.order')}}" class="text-custom-primary">track order</a>.
                </div>
            </div>
        </div>
    </section>
@endsection