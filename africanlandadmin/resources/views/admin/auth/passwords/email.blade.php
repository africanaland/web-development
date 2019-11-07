<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>{{ config('app.name', 'Laravel') }}</title>
<link href="{{ asset('public/admin/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('public/admin/css/main.css') }}">    
<link rel="stylesheet" href="{{ asset('public/admin/css/color_skins.css') }}">
</head>
<body class="theme-black">
<div class="authentication">
    <div class="container">
        <div class="col-md-12 content-center">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card-plain">
                        <div class="header">
                            <h5>Reset password</h5>
                        </div>
                        @include('admin.layouts.message')
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail Address</label>
                                <div class="">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
                                </div>
                                <a class="btn-link text-size14" href="{{ route('login') }}">
                                    {{ __('Login') }}
                                </a>
        
                            </div>
                        </form>

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
