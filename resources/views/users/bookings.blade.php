@extends('layouts.app')
@section('title') {{ $aTitle }} @endsection

@section('pagebanner')
<div class="pageBanner bookingBanner {{ $type }}" style="background: url({{ asset('public/images/bg2.png') }}); ">
    <div>
        <h6>{{ $aTitle }}</h6>
        <form action="{{Request::url()}}" method="POST" class="bookingSearchBox mx-auto">
                {{ csrf_field() }}
                <input type="text" name="keyword" id="" class=" " placeholder="Search">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>

</div>
@endsection
@section('content')

<div class="container pageWrapper " id="page">
    <div class="row justify-content-left">
        <div class="col-md-11 mx-auto">
            <ul class="nav nav-tabs afTabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link @if($type == 'previous') active @endif" href="{{ route('userbookings','previous') }}" role="tab" >Previous</a>
              </li>
              <li class="nav-item">
                <a class="nav-link @if($type == 'upcoming') active @endif" href="{{ route('userbookings','upcoming') }}" role="tab">Upcoming</a>
              </li>

            </ul>
            <div class="tab-content my-3">
                <div class="tab-pane fade show active" id="" role="tabpanel">
                    <div class="row justify-content-left">
                    @if(count($aRows))
                        @foreach($aRows as $aKey => $aRow)
                            <div class="col-md-4">
                                @include('layouts.booking_property')
                            </div>
                        @endforeach
                    @else
                       <div class="col-6 mx-auto my-5 text-center">
                           <img src="{{ asset('public/images/norecordfound1.png')}}" alt="" class="img-fluid" srcset="">
                       </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center searchPagination">
        {!! $aRows->render() !!}
    </div>
</div>
@endsection
