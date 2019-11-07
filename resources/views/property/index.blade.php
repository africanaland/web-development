@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Property</div>

                <div class="card-body">
                    <div class="row clearfix">
                     @if(count($aRows)) 
                     @foreach($aRows as $aKey => $aRow)
                       <div class="col-md-4"> 
                     <div class="card" style="">
                        @if ($aRow->image)
                        <img src="{{ asset('public/uploads/'.$aRow->image)  }}" class="card-img-top" height="200px" width="100%" >
                        @else
                        <img src="{{ asset('public/images/noimage.png')  }}" class="card-img-top" height="200px" width="100%" >
                        @endif
                      
                      <div class="card-body">
                        <p class="card-text text-center"><b>{{ $aRow->name }}</b></p>
                        <p class="card-text text-center">

                            <a href="{{ route('viewproperty', $aRow->id ) }}" class="clearfix mb-5">View Property</a> 

                            @if( in_array( $aRow->id,$aUserHouses ))
                            <a href="javascript:void(0);" onclick="makeFavorite('{{ $aRow->id }}','0');">Remove Favorite</a> 
                            @else
                            <a href="javascript:void(0);" onclick="makeFavorite('{{ $aRow->id }}','1');">Make Favorite</a> 
                            @endif
                            </p>                            
                      </div>
                    </div></div>
                    @endforeach
                     @else
                        No data found
                    @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
