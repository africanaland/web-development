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
                        <tr><th width="180px;">Id</th><td style="border-top: none;">#{{$aRow->id}}</td></tr>
                        <tr><th>Host type</th><td>{{$aRow->role['name']}}</td></tr>
                        <tr><th>Name</th><td> {{$aRow->fname}} {{$aRow->lname }}</td></tr>
                        <tr><th>Email</th><td> {{$aRow->email}}</td></tr>
                        <tr><th>Mobile</th><td>{{ $aRow->mobile }}</td></tr>
                        <tr><th>Country</th>
                            <td>
                                @if (!empty($aRow->country_name['name']))
                                    {{$aRow->country_name['name']}}
                                @else
                                    {{$aRow->country2}}
                                @endif
                            </td>
                        </tr>
                        <tr><th>City</th>
                            <td>
                                @if (!empty($aRow->city_name['name']))
                                    {{$aRow->city_name['name']}}
                                @else
                                    {{$aRow->city2}}
                                @endif
                            </td>
                        </tr>
                        <tr><th>Property Name</th><td>{{ ucfirst($aRow->company_name) }}</td></tr>
                        <tr><th>Property Type</th><td>{{ $aRow->property_type }}</td></tr>
                        <tr><th>Services</th><td>{{ $aRow->get_services_name($aRow->services) }} @if($aRow->service_other) ,{{ $aRow->service_other }} @endif</td></tr>
                        <tr><th>Status</th><td>@if($aRow->status == 1) Replied @else Pending @endif</td></tr>
                        <tr><th>Request Date</th><td>{{ date("d-m-Y",strtotime($aRow->created_at)) }}</td></tr>
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


