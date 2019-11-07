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
                        @if(!empty($aRow->user))
                        <tr><th>Name</th><td>{{$aRow->user['fname']}}</td></tr>
                        <tr><th>email</th><td>{{$aRow->user['email']}}</td></tr>
                        @endif
                        <tr><th>Title</th><td>{{$aRow->title}}</td></tr>
                        <tr><th>Message</th><td>{{$aRow->detail}}</td></tr>
                        @if($aRow->castDate)
                        <tr><th>Broadcast At</th><td>{{ date("d/M/Y",strtotime($aRow->castDate)) }}</td></tr>
                        @endif
                        @if($aRow->r_id != 0)
                        <tr><th>Created At</th><td>{{ date("d/M/Y",strtotime($aRow->created_at)) }}</td></tr>
                        @endif
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
