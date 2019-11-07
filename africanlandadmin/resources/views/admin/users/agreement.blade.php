<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>Agreement: {{ config('app.name', 'Laravel') }}</title>
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

</head>
<body class="theme-black menu_dark">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{{ asset('public/admin/images/logo.svg') }}" width="48" height="48" alt=""></div>
        <p>Please wait...</p>        
    </div>
</div>


<!-- Main Content -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark px-2">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="#"><img src="{{ asset('public/admin/images/logo.svg') }}" width="48" height="48" alt=""></a>

    <!-- Links -->
    <ul class="ml-auto  navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">SignOut</a>
        </li>
        <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
        </form>                  
    </ul>
</nav>
<br>
<br>
<br>
<section class="my-5">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-6 shadow-lg col-md-5 col-sm-12 mx-auto">
                    <div class="py-4 px-3">
                        <h2 class="text-center mb-2">{{"Welcome to ".config('app.name', 'Laravel')}}</h2>
                        @if($aRow)
                        @php
                            $agreement = json_decode($aRow->details);
                        @endphp
                            <h3 class="text-center mb-4 mt-0">{{ucfirst($aRow->type)}}</h3>
                            @foreach ($agreement as $key => $item)
                                <h5 class="text-center">Page {{++$key}}</h5>
                                @if($item)
                                    <div class="text-justify mb-sm-5 mb-2">{!! $item !!}</div>
                                @endif
                            @endforeach
                            @if (in_array($aUser->agreement,[1,2]))
                            <p class="mt-5 text-center m-0">{{"Thank you for connecting with us"}}</p>                        
                            <p class="text-center m-0">{{ "Your account activate soon" }}</p>                        
                            @else
                            {!! Form::open(['action'=>'HomeController@agreement','method'=>'post']) !!}
                            <div class="d-flex">
                                <div class="col-sm-6 text-right"><button value="1" name="btn" class="rounded-0 btn btn-success">Accept</button></div>
                                <div class="col-sm-6"><button  value="0" name="btn" class="rounded-0 btn btn-danger">Declien</button></div>
                            </div>
                            {!! Form::close() !!}
                        @endif
                        @else
                            <h2 class="text-center mb-4 mt-0">Your Agreement Not Update Please contact to admin</h2>
                            <h6 class="mt-3">Call Us : {{App\Setting::getSetting('site_phone')}}</h6>
                            <h6 class="mt-0">Email : {{App\Setting::getSetting('site_email')}}</h6>
                        @endif

                    </div>

                </div>
            </div>
        </div>
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
