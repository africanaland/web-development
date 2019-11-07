<script type="text/javascript">
    $(document).ready(function () {
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        $('.datepicker-input').datepicker({
            startDate: today,
            viewMode: "months",
            minViewMode: "months",
            format: 'mm/yyyy'
        });
    });
</script>
<div class="modal-header border-bottom mb-2 py-3 px-5">
    <h5 class="modal-title text-left text-size15" id="exampleModalLabel">{{ __('Add Credit Card') }}</h5>
</div>
<div class="modal-body px-5">
    <div class="modal-error"></div>
    <form method="POST" action="{{ route('cardsave') }}" enctype="multipart/form-data" onsubmit="return submitFrm(this,'{{ route('userwallet') }}');">
        @csrf

        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group">
                    {{ Form::select('card_type', ['' =>'Card Type','Visa' => 'Visa','Master Card' => 'Master Card','American Express' => 'American Express'] , old('card_type') , ['class' => 'form-control show-tick', 'required' => 'required']) }}
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <img src="{{ asset('public/images/iuser.png')}}">
                        </span>
                    </div>
                    <input type="text" placeholder="{{ __('Name of Card') }}" class="form-control"
                    name="cardholder_name" value="" required>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <img src="{{ asset('public/images/icard.png')}}">
                        </span>
                    </div>
                    <input type="text" placeholder="{{ __('Card Number') }}" maxlength="16" class="form-control"
                    name="card_no" value="" required>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <img src="{{ asset('public/images/cal.png')}}">
                        </span>
                    </div>
                    <input type="text" readonly="" placeholder="{{ __('MM/YYYY') }}" class="bg-transparent datepicker-input form-control"  name="expiration_date" value="" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <img src="{{ asset('public/images/icard.png')}}">
                        </span>
                    </div>
                    <input type="text" placeholder="{{ __('Cvv') }}" class="form-control"
                    name="card_cvv" value="" required>
                </div>
            </div>
        </div>

        {{-- <div class="form-group row">
            <div class="col-md-12">
                <input id="" type="checkbox" class="" name="business_booking" value="1">
                &nbsp;Use this card for business booking
            </div>
            <div class="col-md-12">
                <input id="" type="checkbox" class="" name="reward_booking" value="1">
                &nbsp;Use this card for reward booking
            </div>
        </div> --}}

        <div class="form-group row pt-3">
            <div class="col-md-6">
                <button type="submit" class="btn btn-afland"> {{ __('Add Card') }}</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-afland btn-afland-white" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>



    </form>
</div>

<div class="modal-loader">
    <i class="fa fa-spinner fa-spin"></i>
</div>
