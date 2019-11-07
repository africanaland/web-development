@extends('layouts.app')
@section('title') Favourites @endsection

@section('pagebanner')
<div class="pageBanner bookingBanner favourites" style="background: url({{ asset('public/images/bg2.png') }})">
    <div>
        <h6>Favourites</h6>
        <form action="{{Request::url()}}" method="POST" class="bookingSearchBox mx-auto">
                {{ csrf_field() }}
                <input type="text" name="keyword" id="" class=" " placeholder="Search">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
</div>
@endsection
@section('content')

<div class="container pageWrapper">
    <div class="row justify-content-left">
        @if(count($aRows))
            @foreach($aRows as $aKey => $aRow)
                <div class="col-md-4">
                    @include('layouts.fav_property')
                    <!-- <a href="javascript:void(0);" onclick="makeFavorite('{{ $aRow->id }}','0');">Remove Favorite</a> -->
                </div>
            @endforeach
        @else
           <div class="col-md-12 mt-2">No data found </div>
        @endif
    </div>
    <div class="d-flex justify-content-center searchPagination">
            {!! $aRows->render() !!}
    </div>
</div>
@endsection
