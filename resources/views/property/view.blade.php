@extends('layouts.app')
@section('title') {{ $aRow->name }} @endsection


@section('pagebanner')
<div class="pageBanner1 propertyBanner">
    <div class="pageBannerImage" style='background:url({{ asset('public/images/bg1.png')  }})'></div>
    {{-- <img src="" alt=""> --}}
    <span></span>
</div>
@endsection

@section('content')
<?php
$aImages = unserialize($aRow->gallery_images);
$amenities = $aRow->get_property_fields($aRow->amenities, 'amenities');
$services = $aRow->get_property_fields($aRow->services, 'services');
?>
<form id="frmViewPorperty" method="post">
    @csrf
    <div class="container pageWrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card pl-0 pr-0">
                    <div class="card-body pl-0 pr-0 pt-sm-3 pt-0">
                        <div class="row border-bottom py-4 px-3 mx-0">
                            <div class="col-md-8 mb-sm-0 mb-2">
                                <div class="d-flex">
                                    <div class="">
                                        <img src="@if ($aRow->user['image']){{ asset('public/uploads/'.$aRow->user['image'])  }} @else {{ asset('public/images/profile.png')  }} @endif" class="rounded-circle" height="50px" width="50px">
                                    </div>
                                    <div class="pl-3">
                                        <b>{{ @$aRow->user['fname'] }} {{ @$aRow->user['lname'] }}</b> <br>
                                        <div class="ratings">
                                                <div class="empty-stars"></div>
                                                <div class="full-stars" style="width:{{\App\Review::ratings($aRow->id )}}%"></div>
                                        </div>
                                        @php $review = \App\Review::reviewCount($aRow->id ) @endphp
                                        @if ($review)
                                        <a href="javascript:void(0);" onclick="openPopup('{{ route('getReviews', $aRow->id  )}}')" title="Property Review">	
                                            <span class="mt-2 text-size12">Review ({{$review}})</span>
                                        </a>							
                                        @endif                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-sm-0 mb-2 text-size12">
                                <b class="text-size15">{{ $aRow->name }}</b> <br>
                                <i class="fa fa-map-marker mr-1" aria-hidden="true"></i>{{ $aRow->address }}
                            </div>
                        </div>

                        <div class="row border-bottom py-4 px-2 justify-content-center mx-0 addRightBorder">
                            <div class="col-md-12 border-0">
                                <h3 class="text-size20">Overview</h3>
                            </div>

                            <div class="col-sm-3 col-6 text-center mx-auto">
                                <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon5.png')  }}" class=""></p>
                                <p class="mb-1">Bedrooms </p>
                                <p class="mb-1 font-weight-bold">{{ $aRow->no_bedrooms }} Bedrooms / {{ $aRow->no_beds }} Beds</p>
                            </div>

                            <div class="col-sm-2 col-6 text-center mx-auto">
                                <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon6.png')  }}" class=""></p>
                                <p class="mb-1">Kitchens </p>
                                <p class="mb-1 font-weight-bold">{{ $aRow->no_kitchens }} full</p>
                            </div>

                            <div class="col-sm-2 col-6 text-center mx-auto">
                                <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon7.png')  }}" class=""></p>
                                <p class="mb-1">Parkings </p>
                                <p class="mb-1 font-weight-bold">{{ $aRow->no_parking }}</p>
                            </div>

                            <div class="col-sm-2 col-6 text-center mx-auto">
                                <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon8.png')  }}" class=""></p>
                                <p class="mb-1">Bathrooms </p>
                                <p class="mb-1 font-weight-bold">{{ $aRow->no_bathrooms }} full</p>
                            </div>

                            <div class="col-sm-2 col-6 text-center  mx-auto">
                                <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon9.png')  }}" class=""></p>
                                <p class="mb-1">Receptions </p>
                                <p class="mb-1 font-weight-bold">{{ $aRow->no_reception }}</p>
                            </div>

                        </div>

                        <div class="row border-bottom py-4 px-3 justify-content-center mx-0 addRightBorder">
                            <div class="col-md-12 pb-3 border-0">
                                <h4 class="text-size20">Amenities</h4>
                            </div>
                            @if($amenities)
                            @foreach($amenities as $key => $amenity)

                            <div class="col-sm-2 col-6 text-center">
                                <p class="mb-0"><img class="proOverviewImg" src="@if ($amenity['image']){{ asset('public/uploads/'.$amenity['image'])  }} @else {{ asset('public/images/noimage.png')  }} @endif" class=""></p>
                                <p class="mb-1 font-weight-bold">{{ $amenity['name'] }}</p>
                            </div>

                            @endforeach
                            @endif
                        </div>
                        @if($aImages)
                        <div class="font-weight-bold  px-sm-4 px-2">Gallery</div>
                        <div class="row mx-0 mt-2  px-sm-4 px-2 pb-3">
                            @php $i = 1; @endphp
                            @foreach($aImages as $aImage)
                            @if($i >= 12)
                            <div class="col-sm-2 col-4 p-0 summeryImg layer" style="background:url({{ asset('public/uploads/'.$aImage)  }})">
                                <a href="">
                                    <div class="layerContent">
                                        more
                                    </div>
                                </a>
                            </div>
                            @php break @endphp
                            @else
                            <div class="col-sm-2 col-4 p-0 summeryImg " style="background:url({{ asset('public/uploads/'.$aImage)  }})">
                            </div>
                            @endif
                            @php $i++; @endphp
                            @endforeach
                        </div>
                        <div class="row border-bottom"></div>
                        @endif
                

                        <div class="row border-bottom py-4 px-3 mx-0">
                            <div class="col-md-12">
                                <h4 class="text-size20">Internal Policy</h4>
                            </div>
                            <div class="col-md-12">
                                <div class="cke_wrapper">{!!html_entity_decode($aRow->policy)!!}</div>
                            </div>
                        </div>

                        @php
                        $aLocations = array();
                        $aLocations[] = array(
                        "title" => $aRow->name,
                        "content" => $aRow->name,
                        "lat" => @(integer)$aRow->latitude,
                        "lon" => @(integer)$aRow->longitude
                        );
                        @endphp
                        @include('property.map',['aLocations' => $aLocations ])
                        <div id="map" style="width:100%;height:400px;"></div>


                        <div class="row py-4 px-3 justify-content-center mx-0">
                            <div class="col-sm-8">
                                <input id="bookingdatepicker" name="bookingdates" type="hidden">
                                <div id="bookingdatepicker-container" class="embedded-daterangepicker "></div>
                            </div>
                        </div>
                        <div class="calenderOnfo text-center mb-3">
                            <div class="available d-sm-inline">
                                <span ></span>&nbsp;&nbsp;Available
                            </div>
                            <div class="offClass d-sm-inline">
                                <span ></span>&nbsp;&nbsp;Booked
                            </div>
                            <div class="pendingClass d-sm-inline">
                                <span ></span>&nbsp;&nbsp;pending
                            </div>

                        </div>

                        @guest
                        @else
                        <div class="row border-top py-4 px-3 justify-content-center mx-0">
                            <div class="d-sm-flex">
                                <a href="javascript:void(0);" data-toggle="modal" class="btn btn-afland btn-afland-white mr-3 " data-target="#addition_service">Additional Services</a>
                                <a id="btnbookingssummary" href="javascript:void(0);" class="btn btn-afland btn-afland-disable " onclick="bookingssummary(this,'{{ route("bookingssummary",$aRow->id) }}');">Booking Summary</a>
                            </div>
                        </div>
                        @endguest

                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('property.addservice')

</form>

@endsection

@push('after-scripts')
<script src="https://www.paypalobjects.com/api/checkout.js "></script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
    /*var disabledArr = ["07/24/2019","07/25/2019","07/26/2019","07/27/2019","07/28/2019","07/29/2019","07/23/2019","08/14/2019","08/15/2019","08/16/2019","08/17/2019","08/18/2019","08/19/2019","08/20/2019"];*/

    var disabledArr = <?php echo  json_encode($aBookedDates) ?>;
    
    var todayDate = new Date();
    var sDate = "<?php echo Session::get('checkin') ?>";
    var eDate = "<?php echo Session::get('checkout') ?>";
    var startDate = sDate || todayDate;
    var endDate = eDate || todayDate;
    var picker = jQuery('#bookingdatepicker').daterangepicker({
        "parentEl": "#bookingdatepicker-container",
        "autoApply": true,
        "format": 'DD-MM-YYYY',
        "minDate": todayDate,
        "startDate" : startDate,
        "endDate" : endDate,

        isInvalidDate: function(arg) {
            var thisMonth = arg._d.getMonth() + 1;
            if (thisMonth < 10) {
                thisMonth = "0" + thisMonth;
            }
            var thisDate = arg._d.getDate();
            if (thisDate < 10) {
                thisDate = "0" + thisDate;
            }
            var thisYear = arg._d.getYear() + 1900;
            var thisCompare = thisMonth + "/" + thisDate + "/" + thisYear;
            if ($.inArray(thisCompare, disabledArr) != -1) {
                return true;
            }
        }
    });
    
    var checkDate = document.getElementById('bookingdatepicker').value;
    if(checkDate){
        $('#btnbookingssummary').removeClass('btn-afland-disable');
    }
    picker.on('apply.daterangepicker', function(ev, picker) {

        var startDate = picker.startDate.format('MM/DD/YYYY')
        var endDate = picker.endDate.format('MM/DD/YYYY')


        var clearInput = false;
        for (i = 0; i < disabledArr.length; i++) {
            if (startDate < disabledArr[i] && endDate > disabledArr[i]) {
                clearInput = true;
            }
        }
        if (clearInput) {
            var today = new Date();
            $(this).data('daterangepicker').setStartDate(today);
            $(this).data('daterangepicker').setEndDate(today);
            alert("Your range selection includes disabled dates!");
            $('#btnbookingssummary').addClass('btn-afland-disable');
            return;
        }
        $("#bookingdatepicker").val(picker.startDate.format('DD-MM-YYYY') + '/' + picker.endDate.format('DD-MM-YYYY'));
        $('#btnbookingssummary').removeClass('btn-afland-disable');
    });
    picker.on('showCalendar.daterangepicker', function(ev, picker) {
        $("#bookingdatepicker").val(picker.startDate.format('DD-MM-YYYY') + '/' + picker.endDate.format('DD-MM-YYYY'));
    });

    picker.data('daterangepicker').hide = function() {};
    picker.data('daterangepicker').show();
</script>

@endpush
