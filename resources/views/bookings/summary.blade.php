<?php
$aImages = unserialize($aRow->gallery_images);
$amenities = $aRow->get_property_fields($aRow->amenities, 'amenities');
$services = $aRow->get_property_fields($aRow->services, 'services');
?>
<div class="modal-header border-bottom  px-sm-4 px-2">
    <h5 class="modal-title text-left text-size15 px-3" id="exampleModalLabel">Booking Summary</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body pt-0">
    <div class="modal-error"></div>

    <!-- <form method="post" id="frmBookingSummary" action="{{ route('bookingsave')}}" onsubmit="return submitFrm(this);"> -->
    <form method="post" id="frmBookingSummary">
        @csrf
        <input type="hidden" name="property_id" value="{{ $aRow->id }}">
        <input type="hidden" name="vals" value="{{ json_encode($aVals) }}">

        @if ($aRow->image)
        <div class="row justify-content-center"  >
            <div class="col-md-12 p-0 mx-auto">
                <img src="{{asset('public/uploads/'.$aRow->image)}}" alt="" style="height:200px"  class="w-100" srcset="">
            </div>
        </div>            
        @endif

        <div class="row border-bottom py-4 px-sm-4 px-2 justify-content-center">
            <div class="col-md-12 text-size12">
                <b class="text-size15">{{ $aRow->name }}</b> <br>
                <i class="fa fa-map-marker mr-1" aria-hidden="true"></i>{{ $aRow->address }}
            </div>
        </div>


        <div class="row border-bottom py-4 px-sm-4 px-2 justify-content-center addRightBorder">
            <div class="col-md-12 border-0">
                <h4 class="text-size20">Overview</h4>
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

            <div class="col-sm-2 col-6 text-center mx-auto ">
                <p class="mb-0"><img class="proOverviewImg" src="{{ asset('public/images/icon9.png')  }}" class=""></p>
                <p class="mb-1">Receptions </p>
                <p class="mb-1 font-weight-bold">{{ $aRow->no_reception }}</p>
            </div>

        </div>

        <div class="row border-bottom py-4  px-sm-4 px-2 justify-content-center addRightBorder">
            <div class="col-md-12 pb-3 border-0">
                <h4 class="text-size20">Amenities</h4>
            </div>
            @if($amenities)
            @foreach($amenities as $key => $amenity)

            <div class="col-sm-2 col-6 text-center">
                <p class="mb-0"><img class="proOverviewImg"
                        src="@if ($amenity['image']){{ asset('public/uploads/'.$amenity['image'])  }} @else {{ asset('public/images/noimage.png')  }} @endif"
                        class=""></p>
                <p class="mb-1 font-weight-bold">{{ $amenity['name'] }}</p>
            </div>

            @endforeach
            @endif
        </div>

        <div class="row border-bottom py-4 px-sm-4 px-2">
            <div class="col-md-12">
                <h4 class="text-size20">Internal Policy</h4>
            </div>
            <div class="col-md-12">
                <div class="cke_wrapper word-break" >{!!html_entity_decode($aRow->policy)!!}</div>
            </div>
        </div>

        <div class="row py-4 px-sm-4 px-2">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" autocomplete="false" readonly class="border-right-0 form-control" id=""
                            placeholder="Per Night" style="background: #fff">
                        <div class="input-group-append">
                            <span class="input-group-text border-left-0" style="color: #dc8b64">{{ $aRow->daily_rate }}
                                $</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" autocomplete="false" readonly class="border-right-0 form-control" id=""
                            placeholder="Total Price" style="background: #fff">
                        <div class="input-group-append">
                            <span class="input-group-text border-left-0" style="color: #dc8b64">{{ $total_amount }}
                                $</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-4  px-sm-4 px-2 justify-content-center">
            <div class="d-flex">
                <input type="button" class="btn btn-lg btn-afland mr-3" name="" value="Continue"
                    onclick="openPopup('{{ route("bookingpayment")}}','frmBookingSummary','modal-md');">
            </div>
        </div>
    </form>
</div>
<div class="modal-loader"><i class="fa fa-spinner fa-spin"></i></div>
