<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php if(isset($Title)) { echo $Title; } else { echo config('app.name', 'Laravel'); } ?></title>
    {{--<meta name="robots" content="noindex, follow" />--}}
    <meta name="description" content="<?php if(isset($Description)) { echo $Description; } else { echo env('META_DESCRIPTION'); } ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Google Site Verification-->
    <meta name="google-site-verification" content="Ywrakd0TgZKp0SOQgNrHBYY5XL3oebM8E-Kdv79ZBOY" />

    {{--Fonts--}}
    {{--<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="{{asset('public/assets/images/favicon.png')}}" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="{{asset('public/assets/css/font-icons.css')}}">
    <!-- plugins css -->
    <link rel="stylesheet" href="{{asset('public/assets/css/plugins.css')}}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
    <!-- Custom css -->
    <link rel="stylesheet" href="{{asset('public/assets/css/custom.css')}}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{asset('public/assets/css/responsive.css')}}">
    {{--Font Awesome Icons--}}
    <link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/fontawesome-free/css/all.min.css')}}" type="text/css">
    <!-- Switch -->
    <link rel="stylesheet" href="{{asset('public/assets/css/switch.css')}}">
    {{--Snackbar--}}
    <link rel="stylesheet" href="{{asset('public/assets/css/snackbar.css')}}">
    {{--Datatable--}}
    <link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/datatables/dataTables.bootstrap4.css')}}" type="text/css">

    <?php
      $GeneralSettings = Illuminate\Support\Facades\DB::table('general_settings')->get();
    ?>
    <!-- Facebook Pixels -->
    @if($GeneralSettings[0]->facebook_pixel != "")
      {!! $GeneralSettings[0]->facebook_pixel !!}
    @endif
    <!-- Google Analytics -->
    @if($GeneralSettings[0]->google_analytics != "")
      {!! $GeneralSettings[0]->google_analytics !!}
    @endif

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BCKGFMG964"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-BCKGFMG964');
    </script>
</head>

<body onclick="HideSearchSuggestions();">
<!-- Body main wrapper start -->
<div class="body-wrapper">
    {{--Header--}}
    @include('site.partials.header')

    {{--Page Content--}}
    @yield('content')

    {{--Footer--}}
    @include('site.partials.footer2')

    {{--Modal Windows--}}
    @include('site.includes.addToWishListModal')
</div>
<!-- Body main wrapper end -->

<!-- preloader area start -->
<div class="preloader d-none" id="preloader">
    <div class="preloader-inner">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>
</div>
<!-- preloader area end -->

{{--Snackbar--}}
<div id="snackbar"></div>
{{--Snackbar--}}
<!--Div where the WhatsApp will be rendered-->
    <div style="margin-bottom: 80px; z-index: 999;" id="WAButton"></div>
<!-- All JS Plugins -->
<script src="{{asset('public/assets/js/plugins.js')}}"></script>
<!-- Main JS -->
<script src="{{asset('public/assets/js/main.js')}}"></script>
{{--Datatable--}}
<script src="{{asset('public/dashboard-assets/vendors/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('public/dashboard-assets/vendors/datatables/dataTables.bootstrap4.js')}}"></script>
{{--Select2--}}
<link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/select2/select2.min.css')}}" type="text/css">
<script src="{{asset('public/dashboard-assets/vendors/select2/select2.min.js')}}"></script>
{{--Elevate Zoom--}}
<script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>
<!--Floating WhatsApp css-->
<link rel="stylesheet" href="{{asset('public/assets/css/floating-wpp.min.css')}}">
<!--Floating WhatsApp javascript-->
<script type="text/javascript" src="{{asset('public/assets/js/floating-wpp.min.js')}}"></script>

<!-- AJAX Setup -->
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@include('site.partials.scripts')
@if(Session::has('contact-success'))
    <script type="text/javascript">
        ShowToast('Your query has been submitted', 5000);
    </script>
@endif

</body>
</html>
