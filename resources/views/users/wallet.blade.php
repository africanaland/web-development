@extends('layouts.app')
@section('title') Wallet @endsection


@section('pagebanner')
<div class="pageBanner walletBanner">
    <img src="{{ asset('public/images/bg9.png')  }}" alt="">
    <span>{{ __('Wallet') }}</span>
</div>
@endsection
@section('content')
@inject('balance', 'App\walletHistory')
@php $aRow1 = $balance->countWallet(Auth::user()->id);
     $aRow2 = $balance->countDeposits(Auth::user()->id); @endphp

<div class="container pageWrapper">
    <div class="row justify-content-center">
        <div class="col-md-10 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex border-bottom pb-4">
                      <div class="pr-3 walletProfile">
                          <img class="rounded-circle" height="60px" width="60px" src="@if( Auth::user()->image ) {{ asset('public/uploads/'.Auth::user()->image)  }}  @else {{ asset('public/images/profile.png') }}  @endif">
                      </div>
                      <div class="pl-3 pt-1">
                            <b>{{ Auth::user()->fname }} {{ Auth::user()->lname }}</b>
                      </div>
                    </div>

                    <div class="d-sm-flex justify-content-between pt-4 addRightBorder">
                        <div class="text-center flex-fill py-sm-3 py-1"><b>Balance</b> <br>        ${{$aRow1->userAmount ?? '0'}}</div>
                        <div class="text-center flex-fill py-sm-3 py-1"><b>Total Deposits</b> <br> ${{$aRow2->userAmount ?? '0'}}</div>
                        <div class="text-center flex-fill py-sm-3 py-1"><b>Total Withdraw</b> <br> $0</div>
                    </div>


                </div>
            </div>
        </div>


        <div class="col-md-10 col-sm-12 mt-5">
            <div class="card">
                <div class="card-body">

                    <div class="row justify-content-between">
                        <div class="col-md-5">
                        <form action="{{route('addMoney')}}" method="post">
                            {{ csrf_field() }}
                            <h4 class="border-bottom text-center pb-4 mb-4 text-size18">Add Money</h4>
                            @if(count($aCards))
                            <div class="row">
                            @foreach($aCards as $aKey => $aCard)
                            <div class="col-md-12">
                                <div class="d-flex align-content-center mb-4 cardrow">
                                    <div>
                                        <img src="{{ asset('public/images/addcard.png')}}" class="cardimg" >
                                    </div>
                                    <div class="ml-3 flex-fill">
                                        <div class="border-bottom mb-0 py-1 text-size15">
                                            <div class="row m-0">
                                                <div class="col-10 p-0">
                                                    <div class="checkbox orange d-sm-inline d-flex mr-2">
                                                        <input type="radio" class=" mr-1" name="cardId" id="{{"addId".$aCard->id}}" value="{{$aCard->id}}">
                                                        <label class="font-weight-normal" for="{{"addId".$aCard->id}}"><b>{{$aCard->cardholder_name}}</b></label>
                                                    </div>
                                                </div>
                                                <div class="col-2 p-0">
                                                    <a class="float-right carddelete" href="{{ route('carddelete', $aCard->id) }}" onclick="return confirm('Are you sure?');" ><i class="fa fa-remove"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @php $strlength = strlen($aCard->card_no); @endphp
                                        <p class="mb-0 py-1 text-secondary text-size15 walletCard">XXXX XXXX XXXX {{ substr($aCard->card_no,$strlength-4,$strlength)}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                            @endif
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="cmd" value="_xclick" />
                            <input type="hidden" name="no_note" value="1" />
                            <input type="hidden" name="lc" value="UK" />
                            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                          <input type="text" autocomplete="false" name="amount" class="border-right-0 form-control" id="" placeholder="Amount" required>
                                          <div class="input-group-append">
                                            <span class="input-group-text border-left-0">$</span>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-afland walletBtn" type="submit">Add Money</button>
                                </div>
                            </div>
                        </form>
                        </div>
                        <div class="col-md-1 d-sm-block d-none text-center"><p class="divSep"></p></div>
                        <div class="col-md-5">
                            <h4 class="border-bottom text-center pb-4 mb-4 text-size18">Withdraw Money</h4>
                            @if(count($aCards))
                            <div class="row">
                            @foreach($aCards as $aKey => $aCard)
                            <div class="col-md-12">
                                <div class="d-flex align-content-center mb-4">
                                    <div>
                                        <img src="{{ asset('public/images/withdraw.png')}}" class="cardimg" >
                                    </div>
                                    <div class="ml-3 flex-fill">
                                        <div class="border-bottom mb-0 py-1 text-size15">
                                            <div class="checkbox orange d-sm-inline d-flex mr-2">
                                                <input type="radio" class=" mr-1" name="cardId" id="{{"WithdrawId".$aCard->id}}" value="{{$aCard->id}}" required>
                                                <label class="font-weight-normal" for="{{"WithdrawId".$aCard->id}}"><b>{{$aCard->cardholder_name}}</b></label>
                                            </div>
                                        </div>
                                        @php $strlength = strlen($aCard->card_no); @endphp
                                        <p class="mb-0 py-1 text-secondary text-size15 walletCard">XXXX XXXX XXXX {{ substr($aCard->card_no,$strlength-4,$strlength)}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                            @endif


                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                          <input type="text" autocomplete="false" name="amount" class="border-right-0 form-control" id="" placeholder="Amount">
                                          <div class="input-group-append">
                                            <span class="input-group-text border-left-0">$</span>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-afland btn-afland-white walletBtn" type="submit">Withdraw Money</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

         <div class="col-md-10 col-sm-12 mt-4">
            <div class="card text-center">
                <a onclick="openPopup('{{ route("cardadd") }}');" href="javascript:void(0);" class="text-decoration-none"><i class="fa fa-plus"></i><b>&nbsp;Add Credit Card</b></a>
            </div>
        </div>


    </div>
</div>

@endsection

@push('after-scripts')
<script src="{{ asset('public/js/select2.min.js')}}"></script>
@endpush
