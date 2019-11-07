@extends('layouts.app')

@section('title') Property Search @endsection

@section('content')
@php
    $dataNow = date('d-m-Y');
@endphp
<div class="searchWrapper">
    <div class="searchLeft">
        <div id="map" style=""></div>
    </div>
    <div class="searchRight pl-sm-4">
        <div class="container-fluid pageWrapper pr-sm-4">
            <form method="post" action="{{ route('searchproperty') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-4 pr-sm-1 mb-3"><input type="text" class="form-control" value="{{$keyword}}" name="keyword" placeholder="Keyword"></div>
                    <div class="col-md-3 px-sm-1">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <img src="{{ asset('public/images/cal.png')  }}" alt="">
                                </span>
                            </div>
                            <input type="text" class="border-left-0 form-control datepicker-input" id="" name="checkin" value="{{ $checkin ?? old('checkin') }}" placeholder="DD/MM/YYYY">
                        </div>
                    </div>
                    <div class="col-md-3 px-sm-1">
                        <div class="input-group mb-3" >
                            <div class="input-group-prepend">
                                <span class="input-group-text border-right-0">
                                    <img src="{{ asset('public/images/cal.png')  }}" alt="">
                                </span>
                            </div>
                            <input type="text" class="border-left-0 form-control datepicker-input" id="" name="checkout" value="{{ $checkout ?? old('checkout') }}" placeholder="DD/MM/YYYY">
                        </div>
                    </div>
                    <div class="col-md-2 pl-sm-1">
                        <div class="d-flex">
                            <a class="form-control text-center mr-2 px-2 py-2 w-ft settingBtn">
                                <img src="{{ asset('public/images/setting.png  ')  }}">
                            </a>
                            <button type="submit" class="btn btn-afland btn-width  m-0">{{ __('Search') }}</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            @if(!empty($aRows))
            <div class="text-secondary">{{ @$counter}}&nbsp;&nbsp;Guest House</div>
            @endif
            <div class="row mt-4">
                @php $aLocations = array(); @endphp
                @if(count( $aRows))
                @foreach($aRows as $aKey => $aRow)
                @php
                $aLocations[] = array(
                "title" => $aRow->name,
                "content" => $aRow->name,
                "lat" => @(integer)$aRow->latitude,
                "lon" => @(integer)$aRow->longitude
                );
                @endphp

                <div class="col-md-6">
                    @include('layouts.property')
                </div>
                @endforeach
                @else
                <div class="col-sm-12 text-center">No data found</div>
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-center searchPagination">
                {!! $aRows->appends(Illuminate\Support\Facades\Input::except('page'))->render() !!}
        </div>
    </div>
</div>

@endsection


<script>
    var map;

    var locations = @php echo $aLocationsJson = json_encode($aLocations); @endphp;


    function initMap() {
        myLatLng = {
            lat: locations[0]['lat'],
            lng: locations[0]['lon']
        };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: myLatLng
        });
        setMarkers(map, locations);
    }

    function setMarkers(map, locations) {

        var marker, i
        for (i = 0; i < locations.length; i++) {
            var title = locations[i]['title']
            var lat = locations[i]['lat']
            var long = locations[i]['lon']
            var content = locations[i]['content']
            latlngset = new google.maps.LatLng(lat, long);

            var marker = new google.maps.Marker({
                map: map,
                title: title,
                position: latlngset
            });
            map.setCenter(marker.getPosition());

            var infowindow = new google.maps.InfoWindow()

            google.maps.event.addListener(marker, 'click', (function(marker, content, infowindow) {
                return function() {
                    if ($('.gm-style-iw').length) {
                        $('.gm-style-iw').parent().remove();
                    }
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                };
            })(marker, content, infowindow));
        }
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBF7qLSXQ8ydU4opxZvt9AuWm0BgpHR4O4&callback=initMap">
</script>
