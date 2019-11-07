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
                @if(count($aRow->toArray()))                       
                <table class="table m-b-0">
                    <tbody>
                        <tr><th>Id</th><td style="border-top: none;">#{{$aRow->id}}</td></tr>
                        <tr><th>Membership</th><td>{{ $aRow->membership['name'] }}</td></tr>
        
                        <tr><th>Name</th><td>{{$aRow->name}}</td></tr>                      
                        <tr><th>Start Date</th><td>{{ date("d-m-Y",strtotime($aRow->start_date)) }}</td></tr>
                        <tr><th>End Date</th><td>{{ date("d-m-Y",strtotime($aRow->end_date)) }}</td></tr>                        
                        <tr><th>Created At</th><td>{{ date("d-m-Y",strtotime($aRow->created_at)) }}</td></tr>
                        <tr><th>Description</th><td><div class="cke_wrapper">{!!html_entity_decode($aRow->description)!!}       </div> </td></tr>
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
