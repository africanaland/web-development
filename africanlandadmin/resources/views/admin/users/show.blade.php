@extends('admin.layouts.app')

@php
    $page_name = "View Details"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);"> {{ $page_name }}</a></li>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2> {{ $page_name }}</h2>
            </div>
            <div class="body table-responsive">
                @if(count((array)$aRow))
                <table class="table m-b-0">
                    <tbody>
                        <tr><th>Id</th><td style="border-top: none;">#{{$aRow->id}}</td></tr>
                        <tr><th>Role</th><td>{{$aRow->role['name']}}</td></tr>
                        <tr><th>Username</th><td>{{$aRow->username}}</td></tr>
                        <tr><th>Name</th><td>{{$aRow->fname}} {{$aRow->lname}}</td></tr>
                        <tr><th>Image</th><td><img src="{{  App\Helpers\CustomHelper::displayImage($aRow->image) }}" height="30px" width="30px" ></td></tr>
                        <tr><th>Country</th><td>{{$aRow->country_name['name']}}</td></tr>
                        <tr><th>City</th><td>{{$aRow->city_name['name']}}</td></tr>
                        <tr><th>Mobile</th><td>{{$aRow->mobile}}</td></tr>
                        <tr><th>Registration Date</th><td>{{ date("d-m-Y",strtotime($aRow->created_at)) }}</td></tr>
                        <tr><th>Address</th><td>{{$aRow->address}}</td></tr>
                    </tbody>
                </table>
                @else
                No data found
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
