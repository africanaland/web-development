@extends('admin.layouts.app')

@php
    $page_name = "Bookings"
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
                @if (!$hostLogin)
                    @include('admin.layouts.search')
                @endif
                        @if(count($aRows))
                        <table class="table table-bordered table-striped js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Host Name</th>
                                    <th>Property type</th>
                                    <th>Booking dates</th>
                                    <th>Guest name</th>
                                    <th>Payment Status</th>
                                    <th>Booking status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <td scope="row">{{ $aRow->id }}</td>
                                    <td>{{$aRow->user['country_name']['name']}} </td>
                                    <td>{{$aRow->user['city_name']['name']}} </td>
                                    <td>{{$aRow->property['host_detail']['fname']}} {{$aRow->property['host_detail']['lname']}}</td>
                                    <td>{{$aRow->property['property_type']}}</td>
                                    <td>
                                        {{ date("d/m/Y",strtotime($aRow->checkin)) }} - {{ date("d/m/Y",strtotime($aRow->checkout)) }}
                                    </td>
                                    <td>{{$aRow->user['fname']}} {{$aRow->user['lname']}}</td>
                                    <td>{!! $aRow->payment_status.",<br>".$aRow->payment_method !!}</td>
                                    <td>@if($aRow->status == 1) Pending @elseif($aRow->status == 0) Reject @else Confirm @endif</td>
                                    <td class="text-center">
                                            <a href="{{ route('viewbooking', $aRow->id)}}"><i class="zmdi zmdi-eye text-secondary"></i></a>
                                        @if ($aRow->bookingStatus == 0)
                                            <div class="badge badge-warning">User cancel</div>
                                        @else
                                        @if($aRow->status == 1)
                                            <a href="{{ route( 'updateBooking',['id'=> $aRow->id,'value'=>2] )}}" title="Approve Booking"><i class="zmdi zmdi-thumb-up text-success"></i></a>
                                            <a href="{{ route('updateBooking',['id'=> $aRow->id,'value'=>0])}}" title="Reject Booking"><i class="zmdi zmdi-thumb-down text-danger"></i></a>
                                        @elseif($aRow->status == 2)
                                            <a href="{{ route('updateBooking',['id'=> $aRow->id,'value'=>0])}}" title="Reject Booking"><i class="zmdi zmdi-thumb-down text-danger"></i></a>
                                        @elseif($aRow->status == 0)
                                            <a href="{{ route( 'updateBooking',['id'=> $aRow->id,'value'=>2] )}}" title="Approve Booking"><i class="zmdi zmdi-thumb-up text-success"></i></a>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                 @endforeach
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
