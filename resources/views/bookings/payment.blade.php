<div class="modal-header border-bottom">
<h5 class="modal-title text-left px-4" id="exampleModalLabel">Payment</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>

</div>
<div class="modal-body">
<div class="modal-error"></div>

<form method="post" action="{{ route('bookingconfirm')}}" class="paymentForm" onsubmit="return submitFrm(this);">
@csrf


<input type="hidden" name="checkin" value="{{ $checkin }}">
<input type="hidden" name="checkout" value="{{ $checkout }}">
<input type="hidden" name="property_id" value="{{ $aRow->id }}">
<input type="hidden" name="services" value="{{ json_encode($addservices) }}">
<input type="hidden" name="daily_rate"  value="{{ $aRow->daily_rate }}">
<input type="hidden" name="booking_amount" id="booking_amount" value="{{ $total_amount }}">
<input type="hidden" name="paid_amount" id="paid_amount" value="{{ $total_amount }}">
<input type="hidden" name="transaction_id" id="p_id" value="">
<input type="hidden" name="p_payerID" id="p_payerID" value="">
<div class="row px-4">
<div class="col-md-9">
    <div class="form-group">
        <div class="d-sm-flex mb-1">
            <span class="input-group-text mr-sm-3 mb-sm-0 mb-1 text-sm-left text-center  text-secondary">Coupon Code</span>
            <div class="d-flex mb-sm-0 mb-1">
                <input type="text" autocomplete="false" class="rounded form-control mr-sm-3" id="coupon_code"
                style="background: #fff;padding:20px;">
                <a href="javascript:void(0);" onclick="checkoffer('{{ route('checkoffer')}}');"><img src="{{ asset('public/images/check.png')  }}" alt=""></a>
            </div>
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
             <span class="input-group-text border-left-0" id="total_price_span" style="color: #dc8b64">{{ $total_amount }} $</span>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row px-4">
    <div class="col-md-4 mb-sm-0 mb-2">
        <div class="w-100  radio-control ">
            <label class="selectPayment m-0" data-value="onarrival">
                <input type="radio" name="payment_method" value="onarrival" id="onarrival"  class="paymentType" required >
                <i class="fa fa-plane" aria-hidden="true"></i>&nbsp;&nbsp;On Arrival
            </label>
        </div>
    </div>
    <div class="col-md-4 mb-sm-0 mb-2">
        <div class="w-100  radio-control ">
            <label class="selectPayment m-0" data-value="creditcard">
                <input type="radio" name="payment_method" value="Wallet" id="Wallet" class="paymentType" required >
                <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;Wallet
            </label>
        </div>
    </div>
    <div class="col-md-4 mb-sm-0 mb-2">
        <div class="w-100  radio-control ">
            <label class="selectPayment m-0" data-value="paypal">
                <input type="radio" name="payment_method" value="paypal" id="paypal" class="paymentType" required >
                <i class="fa fa-paypal" aria-hidden="true"></i>&nbsp;&nbsp;Paypal
            </label>
        </div>
    </div>
</div>

<div class="row py-4 px-3 justify-content-center">
    <div class="col-md-12" >
        <input type="submit" id="paymentBtn" class="btn btn-lg btn-afland mr-3 btn-afland-white" name="" value="Finish">
        @if (!empty($payKey))
        <div style="display: none" id="paypalBtn"></div>
        @else
        <div style="display: none" id="paypalBtn">
            <div class="text-center text-danger">service not Available</div>
        </div>
        @endif
    </div>
</div>
</form>
</div>
<div class="modal-loader"><i class="fa fa-spinner fa-spin"></i></div>
<script>
    var palPAlKey = '<?PHP echo $payKey; ?>';
  paypal.Button.render({

    env: 'sandbox',
    client: {
        sandbox: palPAlKey,
        // sandbox: 'AQjA3XLEp1xv4wXJGavID5kIJiUlQSfc4KtzbuIpzlbctFoXdRixCw7AMcBDoAKuZvvj7Wbzf2R7__S3',
    //   production: 'demo_production_client_id'
    },
    locale: 'en_US',
    style: {
      size: 'responsive',
      color: 'gold',
      shape: 'rect',
    },

    commit: true,

    payment: function(data, actions) {
       var totalMount = $('#paid_amount').val();

      return actions.payment.create({
        transactions: [{
          amount: {
            total: totalMount,
            currency: 'USD'
          }
        }]
      });
    },
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function(res) {
        window.alert('Payment is successfully Done');
        $('#p_id').val(res.transactions[0].related_resources[0].sale.id);
        $('#p_payerID').val(res.payer.payer_info.payer_id)
        $('#paymentBtn').click();
     });
    },
    onCancel: function (data) {
        window.alert('Transaction Canceled');
    },
    // onError: function (err) {
    //     window.alert('Transaction Error Try diffrent option');
    // }
  }, '#paypalBtn');


</script>