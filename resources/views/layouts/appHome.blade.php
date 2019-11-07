<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') : {{ config('app.name', 'Laravel') }}</title>
<!-- <script src="{{ asset('public/js/app.js') }}" defer></script> -->
<!-- Styles -->
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/editor.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/intlTelInput.min.css') }}" rel="stylesheet">
<style>
</style>
@stack('add-css')
<script>
	var makefavoriteurl = '{{ route("makefavorite") }}';
	var getcityurl = '{{ route("getcity") }}';
	var getpropertytypeurl = '{{ route("getpropertytype") }}';
</script>
</head>
@php
$isHome = false;
if (Route::getCurrentRoute()->uri() == '/')
{
    $isHome = true;
}
@endphp
<body>
<input type="hidden" name="" id="site_csrf_token" value="{{ csrf_token() }}">
<div class="wrapper @if($isHome) homeWrapper @endif">
    @include('layouts.header')
    @yield('pagebanner')
    <main class="mainWrapper">
        @include('layouts.message')
        @yield('content')
        @include('layouts.footer')
    </main>
</div>
@include('layouts.modal')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('public/js/intlTelInput.min.js') }}"></script>
@stack('after-scripts')
<script src="{{ asset('public/js/functions.js') }}"></script>
</body>
</html>
