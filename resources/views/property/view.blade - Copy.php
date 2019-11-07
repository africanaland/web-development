@extends('layouts.app')
@section('title') {{ $aRow->name }} @endsection


@section('pagebanner')
<div class="pageBanner propertyBanner">
    <img src="{{ asset('public/images/bg1.png')  }}" alt="">
    <span></span>
</div>
@endsection



@section('content')
<?php
    $aImages = unserialize($aRow->gallery_images);
    $amenities = $aRow->get_property_fields($aRow->amenities,'amenities');
    $services = $aRow->get_property_fields($aRow->services,'services');
?>

<div class="container pageWrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card pl-0 pr-0">              
                <div class="card-body pl-0 pr-0">
                    <div class="row border-bottom py-4 px-3 mx-0">
                        <div class="col-md-8">
                            <div class="d-flex">
                                <div class="">
                                    <img src="@if ($aRow->user['image']){{ asset('public/uploads/'.$aRow->user['image'])  }} @else {{ asset('public/images/profile.png')  }} @endif" class="rounded-circle" height="50px" width="50px" >
                                </div>
                                <div class="pl-3">
                                    <b>{{ @$aRow->user['fname'] }} {{ @$aRow->user['lname'] }}</b> <br>
                                    <div class="proRate">
                                        <span class="fa fa-star fillStar"></span>
                                        <span class="fa fa-star fillStar"></span>
                                        <span class="fa fa-star fillStar"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        Review
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <b>{{ $aRow->name }}</b> <br>
                            <i class="fa fa-location"></i>{{ $aRow->address }}
                        </div>              
                    </div>

                    <div class="row border-bottom py-4 px-2 justify-content-center mx-0">
                        <div class="col-md-12"><h4>Overview</h4></div>

                        <div class="col-sm-3 text-center border-right">
                            <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon5.png')  }}" class="" ></p>
                            <p class="mb-1">Bedrooms </p>       
                            <p class="mb-1">{{ $aRow->no_bedrooms }} Bedrooms / {{ $aRow->no_beds }} Beds</p>
                        </div>

                        <div class="col-sm-2 text-center border-right">
                            <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon6.png')  }}" class="" ></p>
                            <p class="mb-1">Kitchens </p>       
                            <p class="mb-1">{{ $aRow->no_kitchens }} full</p>
                        </div>

                        <div class="col-sm-2 text-center border-right">
                            <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon7.png')  }}" class="" ></p>
                            <p class="mb-1">Parkings </p>       
                            <p class="mb-1">{{ $aRow->no_parking }}</p>
                        </div>

                        <div class="col-sm-2 text-center border-right">
                            <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon8.png')  }}" class="" ></p>
                            <p class="mb-1">Bathrooms </p>       
                            <p class="mb-1">{{ $aRow->no_bathrooms }}</p>
                        </div>

                        <div class="col-sm-2 text-center ">
                            <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon9.png')  }}" class="" ></p>
                            <p class="mb-1">Receptions </p>       
                            <p class="mb-1">{{ $aRow->no_reception }}</p>
                        </div>

                    </div>

                    <div class="row border-bottom py-4 px-3 justify-content-center mx-0">
                        <div class="col-md-12 pb-3"><h4>Amenities</h4></div>
                        @if($amenities)      
                        @foreach($amenities as $key => $amenity)

                        <div class="col-sm-2 text-center @if($key < count($amenities)-1 ) border-right @endif">
                            <p class="mb-0"><img class="proOverviewImg" src="@if ($amenity['image']){{ asset('public/uploads/'.$amenity['image'])  }} @else {{ asset('public/images/noimage.png')  }} @endif" class="" ></p>
                            <p class="mb-1">{{ $amenity['name'] }}</p>     
                        </div>
                      
                        @endforeach           
                        @endif
                    </div>

                    <div class="row border-bottom py-4 px-3 mx-0">
                        <div class="col-md-12"><h4>Internal Policy</h4></div>
                        <div class="col-md-12">
                            <div class="cke_wrapper">{!!html_entity_decode($aRow->policy)!!}</div>
                        </div>
                    </div>
                                         
                    @php       
                    $aLocations = array();      
                    $aLocations[] = array(
                    "title" => $aRow->name,
                    "content" => $aRow->name,
                    "lat" => @$aRow->latitude,
                    "lon" => @$aRow->longitude
                    );
                    @endphp
                    @include('property.map', ['aLocations' => $aLocations ])
                    <div id="map" style="width:100%;height:400px;"></div>


                    <div class="row py-4 px-3 justify-content-center mx-0">
                        <div class="col-sm-6">
                            <input type="text" class="daterangepicker-input" name="">
                        </div>

                    </div>

                    <div class="row border-top py-4 px-3 justify-content-center mx-0">
                        <div class="d-flex">
                            <a href="javascript:void(0);" data-toggle="modal" class="btn btn-afland btn-afland-white mr-3" data-target="#addition_service">Additional Services</a>
                            <a href="" class="btn btn-afland btn-afland-disable">Booking Summary</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.embedded-daterangepicker .daterangepicker::before,
.embedded-daterangepicker .daterangepicker::after
{
  display: none;
}
.embedded-daterangepicker .daterangepicker {
  position: relative !important;
  top: auto !important;
  left: auto !important;
  float: left;
  width: 100%;
  margin-top: 0;
}
.embedded-daterangepicker .daterangepicker .drp-calendar {
  width: 40%;
  max-width: 50%;
}
</style>


<input id="daterangepicker1" type="text">
<div id="daterangepicker1-container" class="embedded-daterangepicker"></div>





<div class="modal fade" id="addition_service" tabindex="-1" role="dialog" aria-labelledby="afModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header border-bottom">
<h5 class="modal-title text-left" id="exampleModalLabel">Additional Services</h5>        
</div>
<div class="modal-body">
@if($services)
<div class="row">
@foreach($services as $service)
<div class="col-sm-6">
<div class="text-center border radio-control p-2 add-service">
    <div class="d-flex">
        <div>
            <p class="py-1 my-0 text-left"><input type="checkbox" name=""></p>
            <p class="py-1"><img class="proOverviewImg" src="@if ($service['image']){{ asset('public/uploads/'.$service['image'])  }} @else {{ asset('public/images/noimage.png')  }} @endif" class="" ></p>
        </div>
        <div class="p-2 pr-3"><p class="border-right border-left" style="height: 100%;"></p></div>
        <div class="text-left">
            
            <p class="py-1 my-0"><b>{{ $service['name'] }}</b></p>
            @if($service['type'] == 'calculable')
            <p class="py-1 my-0">
                <input class="form-control p-1" type="number" min="1" value="1" name="" size="10" style="width: 40px;display: inline-block;"> Hour/daily
            </p> 
            @endif
            <p class="py-1 my-0">$ 100</p>   
        </div>
    </div>
</div>
</div>
@endforeach
</div>

<div class="row  py-4  justify-content-center">
<div class="d-flex">
<a href="javascript:void(0);" class="btn btn-afland  mr-3">Done</a>
<button type="button" class="btn btn-afland btn-afland-white" data-dismiss="modal" aria-label="Close">
    Cancel
    </button>
</div>
</div>

@endif
</div>
</div>
</div>
</div>

<div class="" style="display: none;">

@if ($aRow->image)
<div class="row clearfix">
    <img src="{{ asset('public/uploads/'.$aRow->image)  }}" class="" height="400px" width="100%" >
</div>
<hr>
@endif

@if($aImages)
@foreach($aImages as $aImage)  
<div class="col-md-2 mb-2">
<img src="{{ asset('public/uploads/'.$aImage)  }}" class="rounded" height="100px" width="100%" >
</div>
@endforeach        
@endif

${{ $aRow->daily_rate }}/night

</div>
@endsection

@push('after-scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
    var picker = jQuery('#daterangepicker1').daterangepicker({
  "parentEl": "#daterangepicker1-container",
  "autoApply": true,
});

picker.on('apply.daterangepicker', function(ev, picker) {   
    $("#daterangepicker1").val(picker.startDate.format('YYYY-MM-DD') + '/' + picker.endDate.format('YYYY-MM-DD'));
});
picker.data('daterangepicker').hide = function () {};
picker.data('daterangepicker').show();

</script>

@endpush