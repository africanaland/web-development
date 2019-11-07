<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>{{ config('app.name', 'Laravel') }}</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="{{ asset('public/admin/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('public/admin/css/main.css') }}">    
<link rel="stylesheet" href="{{ asset('public/admin/css/color_skins.css') }}">
</head>
<body class="theme-black">
<div class="authentication">
    <div class="container">
        <div class="col-md-12 content-center">
            <div class="row">
                {{-- <div class="col-lg-6 col-md-12">
                    <div class="company_detail">
                        <h4 class="logo">{{ config('app.name', 'Laravel') }}</h4>
                        <h3>Admin Dashboard</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>                       
                        
                    </div>                    
                </div>--}}
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card-plain">
                        <div class="header">
                            <h5>Log in</h5>
                        </div>
                        @include('admin.layouts.message')
                        @section('content')
                        @endsection
                         <form class="form-horizontal" role="form" method="POST" action="{{ route('adminlogin') }}">
                            {{ csrf_field() }}
                            <div class="input-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required autofocus placeholder="Email">                                 
                                <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                                 @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="input-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>                                
                                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                                 @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                            </div>                   

                       
                        <div class="footer">
                            <button type="submit" class="btn btn-primary btn-round btn-block">Login </button> 
                            @if (Route::has('password.request'))
                            <a class="btn-link text-size14" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                         </form>
                        <!-- <a class="link" href="{{ route('password.request') }}">                                   Forgot Your Password?                                   </a>
                                     -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Jquery Core Js -->
<script src="{{ asset('public/admin/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('public/admin/bundles/vendorscripts.bundle.js') }}"></script> 
</body>
</html>


                       


                         