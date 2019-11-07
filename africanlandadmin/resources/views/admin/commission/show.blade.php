@extends('admin.layouts.app')

@php
    $page_name = "View Details"
@endphp

@section('title') {{ $page_name }} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0);"> {{ $page_name }}</a></li>
@endsection

<?php
    $aImages = unserialize($aRow->gallery_images);
    $amenities = $aRow->get_property_fields($aRow->amenities,'amenities');
    $services = $aRow->get_property_fields($aRow->services,'services')
?>

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
                        <tr><th>Property Name</th><td>{{$aRow->name}}</td></tr>
                        <tr><th>Image</th><td><img src="{{  App\Helpers\CustomHelper::displayImage($aRow->image) }}" height="30px" width="30px" ></td></tr>
                        <tr><th>Ratings</th><td>
                        <div class="ratings">
                                <div class="empty-stars"></div>
                                <div class="full-stars" style="width:{{\App\Review::ratings($aRow->id )}}%"></div>
                        </div>
                        </td></tr>

                        <tr><th>Hosts</th><td>{{$aRow->type}}</td></tr>
                        <tr><th>Property type</th><td>{{$aRow->subtype}}</td></tr>
                        <tr><th>Max guests</th><td>{{$aRow->max_guest}}</td></tr>
                        <tr><th>No of Bedrooms</th><td>{{$aRow->no_bedrooms}}</td></tr>
                        <tr><th>No of kitchens</th><td>{{$aRow->no_kitchens}}</td></tr>
                        <tr><th>No of beds</th><td>{{$aRow->no_beds}}</td></tr>
                        <tr><th>No of bathrooms</th><td>{{$aRow->no_bathrooms}}</td></tr>
                        <tr><th>Daily Rate</th><td>{{$aRow->daily_rate}}</td></tr>
                        <tr><th>Property have tax</th><td> @if(isset($aRow['have_tax']) && $aRow['have_tax'] == 1) Yes @else No @endif</td></tr>
                         <tr><th>Tax Rate</th><td>{{$aRow->tax_rate}}</td></tr>

                         <tr><th>Amenities</th><td>@if($amenities)
                                @foreach($amenities as $amenity)
                                {{ $amenity }},
                                @endforeach
                                @endif
                        </td></tr>
                        <tr><th>Services</th><td> @if($services)
                                @foreach($services as $service)
                                {{ $service }},
                                @endforeach
                                @endif
                        </td></tr>

                        <tr><th>Location on map</th><td>{{$aRow->address}}</td></tr>
                        <tr><th>Country</th><td>{{$aRow->country_name['name']}}</td></tr>
                        <tr><th>City</th><td>{{$aRow->city_name['name']}}</td></tr>
                        <tr><th>Policy</th><td><div class="cke_wrapper">{!!html_entity_decode($aRow->policy)!!}       </div></td></tr>

                        <tr><th>Created Date</th><td>{{ date("d-m-Y",strtotime($aRow->created_at)) }}</td></tr>

                       <tr><th>Property</th><td> @if($aImages)
    <div class="row clearfix mt-3">

            @foreach($aImages as $aImage)
            <div class="col-md-2 mb-2">
                <img src="{{  App\Helpers\CustomHelper::displayImage($aImage) }}" class="rounded" height="100px" width="100%" >
            </div>
            @endforeach
        </div>

    @endif
                 </td></tr>
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
