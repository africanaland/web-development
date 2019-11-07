@extends('admin.layouts.app')

@php
    $page_name = "Booking Details"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);"> {{ $page_name }}</a></li>
@endsection
@inject('serviveObj','App\Service')
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
                        <tr><th width="150px;">Id</th><td style="border-top: none;">#{{$aRow->id}}</td></tr>

                        <tr><th>Country</th><td>{{$aRow->property['country_name']['name']}}</td></tr>
                        <tr><th>City</th><td>{{$aRow->property['city_name']['name']}}</td></tr>
                        <tr><th>Host Name</th><td>{{$aRow->property['host_detail']['fname']}} {{$aRow->property['host_detail']['lname']}}</td></tr>
                        <tr><th>Property type</th><td>{{$aRow->property['property_type']}}</td></tr>
                        <tr><th>Property location</th><td>{{$aRow->property['address']}}</td></tr>
                        <tr><th>Booking Creation Date</th><td>{{ date("d-m-Y",strtotime($aRow->created_at)) }}</td></tr>
                        <tr><th>Booking Dates</th><td>{{ date("d/m/Y",strtotime($aRow->checkin)) }} - {{ date("d/m/Y",strtotime($aRow->checkout)) }}</td></tr>
                        <tr><th>Guest Name</th><td>{{$aRow->user['fname']}} {{$aRow->user['lname']}}</td></tr>
                        <tr><th>User Name</th><td>{{$aRow->user['username']}}</td></tr>
                        <tr><th>Mobile</th><td>{{$aRow->user['mobile']}}</td></tr>
                        <tr><th>Email</th><td>{{$aRow->user['email']}}</td></tr>
                        <tr><th>Services</th>
                            <td>
                                @php
                                if (!empty($aRow->services)) {
                                    $serviceArray = array();
                                    $text = '';
                                    $service = json_decode($aRow->services);
                                    foreach ($service as $key => $value) {
                                        $serviceDetail = $serviveObj->getData($value->id, array('name'));
                                        if(isset($serviceDetail->name) && $serviceDetail->name)
                                            $text .= '<div class="badge badge-secondary bg-primary text-white ml-2">'.$serviceDetail->name." ";
                                        if(isset($value->hrs) && $value->hrs && isset($serviceDetail->name))
                                            $text .= '<div class="badge badge-secondary bg-dark text-white m-0">'.$value->hrs." per Hour. </div>";
                                        $text .= "</div>";
                                    }
                                    echo $text;
                                }
                                @endphp
                            </td>
                        </tr>
                        <tr><th>Total Amount</th><td>$ {{$aRow->paid_amount}}</td></tr>
                        @if ($aRow->bookingStatus == 0)
                        <tr><th>Payment Status</th><td > <span class="badge badge-warning">User cancel</span></td></tr>
                        @endif
                        <tr><th>Booking Status</th>
                            <td>
                                @if($aRow->status == 1) Pending
                                @elseif($aRow->status == 2) Confirmed
                                @elseif($aRow->status == 0) Rejected
                                @endif
                            </td>
                        </tr>
                        <tr><th>Payment type</th><td>{{ ucfirst($aRow->payment_method) }}</td></tr>
                        <tr><th>Payment Status</th><td>{{ ucfirst($aRow->payment_status) }}</td></tr>
                        @if (!empty($aRow->transaction_id))
                            <tr><th>Paypal Transaction id</th><td>{{ $aRow->transaction_id }}</td></tr>
                            <tr><th>Paypal Payer id</th><td>{{ $aRow->p_payerID }}</td></tr>                            
                        @endif

                        {{--
                        <tr><th>Property Name</th><td>{{$aRow->property['name']}}</td></tr>
                        <tr><th>Image</th><td><img src="{{  App\Helpers\CustomHelper::displayImage($aRow->property['image']) }}" height="30px" width="30px" ></td></tr>
                        <tr><th>Property Owner </th><td>{{$aRow->property['user']['fname']}} {{$aRow->property['user']['lname']}}</td></tr>
                        <tr><th>Guest Email</th><td>{{$aRow->user['email']}}</td></tr>
                       --}}
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
