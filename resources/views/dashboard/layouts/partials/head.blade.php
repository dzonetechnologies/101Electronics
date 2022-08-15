<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ config('app.name', 'Laravel') }}</title>
<!-- core:css -->
<link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/core/core.css')}}" type="text/css">
<!-- endinject -->
<!-- plugin css for this page -->
<link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"
      type="text/css">
<!-- end plugin css for this page -->
<!-- inject:css -->
<link rel="stylesheet" href="{{asset('public/dashboard-assets/fonts/feather-font/css/iconfont.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/flag-icon-css/css/flag-icon.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/flag-icon-css/css/flag-icon.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/fontawesome-free/css/all.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/select2/select2.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('public/dashboard-assets/vendors/datatables/dataTables.bootstrap4.css')}}" type="text/css">
<!-- endinject -->
<!-- Layout styles -->
<link rel="stylesheet" href="{{asset('public/dashboard-assets/css/style.css')}}" type="text/css">
<!-- End layout styles -->
<link rel="shortcut icon" href="{{asset('public/assets/images/favicon.png')}}" type="img/png">
{{--Custom--}}
<link rel="stylesheet" href="{{asset('public/dashboard-assets/css/custom.css')}}" type="text/css">
{{-- CK EDITOR 5 --}}
<script src="{{asset('public/js/ckeditor5-build-classic/ckeditor.js')}}"></script>
<script src="{{asset('public/js/ckfinder/ckfinder.js')}}"></script>
