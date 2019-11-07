<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') : {{ config('app.name', 'Laravel') }}</title>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
</head>
<body>
<input type="hidden" name="" id="site_csrf_token" value="{{ csrf_token() }}">
<div class="wrapper popupWrapper">
    <main class="mainWrapper py-4">
        @include('layouts.message')
        @yield('content')
    </main>
</div>
<script src="https://code.jquery.com/jquery-3.4.0.min.js"
integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
crossorigin="anonymous"></script>
<script src="{{ asset('public/js/functions.js') }}"></script>
</body>
</html>
