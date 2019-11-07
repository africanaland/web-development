<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>@yield('title') : {{ config('app.name', 'Laravel') }}</title>
<!-- Favicon-->
<link rel="icon" href="{{url('/')}}/favicon.ico" type="image/x-icon">
<link href="{{ asset('public/admin/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('public/admin/css/main.css') }}">    
<link rel="stylesheet" href="{{ asset('public/admin/css/color_skins.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/plugins/bootstrap-select/css/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/css/editor.css') }}">
@stack('add-css')
@inject( 'UserClass','App\User')

</head>
<body class="theme-black menu_dark">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{{ asset('public/admin/images/logo.svg') }}" width="48" height="48" alt=""></div>
        <p>Please wait...</p>        
    </div>
</div>

@include('admin.layouts.left')
@include('admin.layouts.right')


<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Admin Panel</h2>
                     <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="{{url('home')}}"><i class="zmdi zmdi-home"></i></a></li>
                        @yield('breadcrumb')              
                    </ul>
                </div>
            </div>
        </div>
         @include('admin.layouts.message')
         @yield('content')        
    </div>
</section>
<!-- Jquery Core Js --> 
<script src="{{ asset('public/admin/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('public/admin/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('public/admin/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('public/admin/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<script src="{{ asset('public/admin/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('public/admin/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('public/admin/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/admin/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('public/admin/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/admin/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>

<script src="{{ asset('public/admin/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/admin/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('public/admin/js/pages/tables/jquery-datatable.js') }}"></script>
@stack('after-scripts')
<script src="{{ asset('public/js/functions.js') }}"></script>
</body>
</html>
