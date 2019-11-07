<div class="modal-header border-bottom">
<h5 class="modal-title text-left px-4" id="exampleModalLabel">Payment</h5>    
</div>
<div class="modal-body">
<div class="modal-error"></div>

<form method="post" action="{{ route('bookingconfirm')}}" onsubmit="return submitFrm(this);"> 
@csrf

<input type="hidden" name="paid_amount" id="paid_amount" value="{{$aRow->paid_amount }}">
<input type="hidden" name="booking_amount" id="booking_amount" value="{{$aRow->booking_amount }}">
<input type="hidden" name="booking_id" id="paid_amount" value="{{$aRow->id }}">


<input type="hidden" name="checkin" value="{{ $checkin }}">
<input type="hidden" name="checkout" value="{{ $checkout }}">
<input type="hidden" name="property_id" value="{{ $aRow->id }}">
<input type="hidden" name="services" value="{{ json_encode($addservices) }}">
<input type="hidden" name="daily_rate"  value="{{ $aRow->daily_rate }}">
<input type="hidden" name="booking_amount" value="{{ $amount }}">

<div class="row px-4">
<div class="col-md-9">
    <div class="form-group">                                
        <div class="input-group mb-1"> 
            <span class="input-group-text mr-3">Coupon Code</span>
            <input type="text" autocomplete="false" class="rounded form-control mr-3" id="coupon_code" 
            style="background: #fff;padding:20px;">
            <a href="javascript:void(0);" onclick="checkoffer('{{ route('checkoffer')}}');"><img src="{{ asset('public/images/check.png')  }}" alt=""></a>
        </div>
    </div>
</div>
</div>

<div class="row px-4">
<div class="col-md-12">
    <div class="form-group">                                
        <div class="input-group mb-1">                                          
            <input type="text" autocomplete="false" readonly class="border-right-0 form-control" id="" placeholder="Discount Price" style="background: #fff">
            <div class="input-group-append">
            <span class="input-group-text border-left-0" id="offer_span" style="color: #dc8b64">0 $</span>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row px-4">
<div class="col-md-12">
    <div class="form-group">                                
        <div class="input-group mb-1">                                          
            <input type="text" autocomplete="false" readonly class="border-right-0 form-control" id="" placeholder="Total Price" style="background: #fff">
            <div class="input-group-append">
             <span class="input-group-text border-left-0" id="total_price_span" style="color: #dc8b64">{{ $aRow->booking_amount }} $</span>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row px-4">
    <div class="col-md-4">
        <div class="form-control radio-control  radio-control-fill ">
               <input type="radio" name="payment_method" value="onarrival" checked="">
                <label><img src="{{ asset('public/images/airplane.png')  }}" alt=""> On Arrival</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-control radio-control  radio-control-fill ">
               <input type="radio" name="payment_method" value="creditcard">
                <label><img src="{{ asset('public/images/creditcard.png')  }}" alt=""> Credit Card</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-control radio-control  radio-control-fill ">
               <input type="radio" name="payment_method" value="paypal">
                <label><img src="{{ asset('public/images/paypal.png')  }}" alt=""> Paypal</label>
        </div>
    </div>
</div>

<div class="row py-4 px-3 justify-content-center">
    <div class="col-md-12">
        <input type="submit" class="btn btn-lg btn-afland mr-3 btn-afland-white" name="" value="Finish">
    </div>
</div>
</form>
</div>
<div class="modal-loader"><i class="fa fa-spinner fa-spin"></i></div>
