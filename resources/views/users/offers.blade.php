@extends('layouts.app')

@section('title') Offer @endsection


@section('pagebanner')
<div class="pageBanner walletBanner">
    <img src="{{ asset('public/images/bg6.png')  }}" alt="">
    <span>{{ __('Offer') }}</span>
</div>
@endsection


@section('content')
<div class="container py-sm-5 py-3">
    <div class="row">
        <div class="col-xl-10  col-sm-12 mx-auto">
            {{-- <div class="card">
                <div class="card-header">{{ __('Offers') }}</div>
                <div class="card-body">
                   @if(count($aRows))
                    @foreach($aRows as $aKey => $aRow)
                    <div class="row m-b-10">
                        <div class="col-md-12">
                            <b>{{ $aRow->name }}</b> <br><br>
                            <div class="cke_wrapper">{!!html_entity_decode($aRow->description)!!}       </div>

                            <p>from date {{ date("d/m/Y",strtotime($aRow->start_date))}} to date {{ date("d/m/Y",strtotime($aRow->end_date))}}</p>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @else
                    <div class="row m-b-10">
                        <div class="col-md-12">  No offers for your membership </div>
                    </div>
                    @endif
                </div>
            </div> --}}

            <div class="row">
                @foreach ($aRows as $key => $item)
                <div class="col-sm-3 col-12 mb-2">
                    <div class="w-100 OfferShadow py-1 px-sm-4 px-2 text-center rounded bg-white offerBlock">
                        <img src="{{ asset('public/uploads/'.$item->image)}}" alt="" class="img-fluid" srcset="">
                        <h5>{{$item->name}}</h5>
                        <hr>
                        <p>Start Offer</p>
                        <h6 class="font-weight-none">{{ date('d - M - y',strtotime($item->start_date))}}</h6>
                        <hr>
                        <p>End Offer</p>
                        <h6 class="font-weight-none">{{ date('d - M - y',strtotime($item->end_date))}}</h6>
                        <hr>
                        {{-- <div class="price">
                            <span>$ 50.00</span>&nbsp;&nbsp;<del>$ 60.00</del>
                        </div> --}}
                        <button class="btn btn-button" data-toggle="modal" data-target="#myModal{{$key}}">Get Detail</button>
                    </div>
                </div>

                <div class="modal fade" id="myModal{{$key}}">
                        <div class="modal-dialog">
                          <div class="modal-content">
                          
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Offer for {{$item->name}}</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>                            
                            <!-- Modal body -->
                            <div class="modal-body text-justify">
                              {!! $item->description !!}
                            </div>
                            
                            <!-- Modal footer -->
                            
                          </div>
                        </div>
                      </div>
                @endforeach



            {{-- <div class="row">
                    <div class="col-6 mb-2">
                        <div class="w-100 text-center bg-white offerBlock border">
                            <img src="{{ asset('public/images/icon1.png')}}" alt="" class="img-fluid m-0" srcset="">
                            <h6 class="text-size14 mb-1">Classic</h6>
                            <div class="text-size12 mb-2">
                                <span class="text-size14">$ 50.00</span>&nbsp;&nbsp;<del>$ 60.00</del>
                            </div>
                            <div class="row mx-0 border-top">
                                <div class="col-6 p-0 py-1 bg-mSecondary">
                                    <p class="m-0 text-size10">Start Offer</p>
                                    <h6 class="font-weight-none text-size10 m-0">{{ date('d - M - y',strtotime('2019-04-13 00:00:00.000000'))}}</h6>
                                </div>
                                <div class="py-1 col-6 p-0">
                                    <p class="m-0 text-size10">End Offer</p>
                                    <h6 class="font-weight-none text-size10 m-0">{{ date('d - M - y',strtotime('2019-04-17 00:00:00.000000'))}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 mb-2">
                        <div class="w-100 text-center bg-white offerBlock border">
                            <img src="{{ asset('public/images/icon2.png')}}" alt="" class="img-fluid m-0" srcset="">
                            <h6 class="text-size14 mb-1">Silver</h6>
                            <div class="text-size12 mb-2">
                                <span class="text-size14">$ 70.00</span>&nbsp;&nbsp;<del>$ 85.00</del>
                            </div>
                            <div class="row mx-0 border-top">
                                <div class="col-6 p-0 py-1 bg-mSecondary">
                                    <p class="m-0 text-size10">Start Offer</p>
                                    <h6 class="font-weight-none text-size10 m-0">{{ date('d - M - y',strtotime('2019-04-13 00:00:00.000000'))}}</h6>
                                </div>
                                <div class="py-1 col-6 p-0">
                                    <p class="m-0 text-size10">End Offer</p>
                                    <h6 class="font-weight-none text-size10 m-0">{{ date('d - M - y',strtotime('2019-04-17 00:00:00.000000'))}}</h6>
                                </div>
                            </div>
                        </div>
                    </div> --}}
{{--
                    <div class="col-sm-3 col-12 mb-2">
                        <div class="w-100 OfferShadow py-1 px-sm-4 px-2 text-center rounded bg-white offerBlock">
                            <img src="{{ asset('public/images/icon2.png')}}" alt="" class="img-fluid" srcset="">
                            <h5>Silver</h5>
                            <hr>
                            <p>Start Offer</p>
                            <h6 class="font-weight-none">{{ date('d - M - y',strtotime('2019-04-13 00:00:00.000000'))}}</h6>
                            <hr>
                            <p>End Offer</p>
                            <h6 class="font-weight-none">{{ date('d - M - y',strtotime('2019-04-17 00:00:00.000000'))}}</h6>
                            <hr>
                            <div class="price">
                                <span>$ 70.00</span>&nbsp;&nbsp;<del>$ 85.00</del>
                            </div>
                            <button class="btn btn-button">Get Now</button>
                        </div>
                    </div>

                    <div class="col-sm-3 col-12 mb-2">
                        <div class="w-100 OfferShadow py-1 px-sm-4 px-2 text-center rounded bg-white offerBlock">
                            <img src="{{ asset('public/images/icon3.png')}}" alt="" class="img-fluid" srcset="">
                            <h5>Gold</h5>
                            <hr>
                            <p>Start Offer</p>
                            <h6 class="font-weight-none">{{ date('d - M - y',strtotime('2019-04-13 00:00:00.000000'))}}</h6>
                            <hr>
                            <p>End Offer</p>
                            <h6 class="font-weight-none">{{ date('d - M - y',strtotime('2019-04-17 00:00:00.000000'))}}</h6>
                            <hr>
                            <div class="price">
                                <span>$ 100.00</span>&nbsp;&nbsp;<del>$ 110.00</del>
                            </div>
                            <button class="btn btn-button">Get Now</button>
                        </div>
                    </div>

                    <div class="col-sm-3 col-12 mb-2">
                        <div class="w-100 OfferShadow py-1 px-sm-4 px-2 text-center rounded bg-white offerBlock">
                            <img src="{{ asset('public/images/icon4.png')}}" alt="" class="img-fluid" srcset="">
                            <h5>Premium</h5>
                            <hr>
                            <p>Start Offer</p>
                            <h6 class="font-weight-none">{{ date('d - M - y',strtotime('2019-04-13 00:00:00.000000'))}}</h6>
                            <hr>
                            <p>End Offer</p>
                            <h6 class="font-weight-none">{{ date('d - M - y',strtotime('2019-04-17 00:00:00.000000'))}}</h6>
                            <hr>
                            <div class="price">
                                <span>$ 130.00</span>&nbsp;&nbsp;<del>$ 150.00</del>
                            </div>
                            <button class="btn btn-button">Get Now</button>
                        </div>
                    </div> --}}



                </div>



        </div>
    </div>
</div>
@endsection
