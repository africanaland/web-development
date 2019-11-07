@extends('layouts.app')

@section('content')
<script>
    var getcityurl = '{{ route("getcity") }}';
</script>
<div class="container">
    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Credit Card') }}</div>
                <div class="card-body">
                    @if(count($aRows))
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Card Type</th>
                                    <th>Card No</th>
                                    <th>Name</th>
                                    <th>Expiry Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aRows as $aKey => $aRow)
                                <tr>
                                    <th scope="row">{{ $aKey+1 }}</th>
                                    <td>{{$aRow->card_type}}</td>
                                    <td>{{$aRow->card_no}}</td>
                                    <td>{{$aRow->cardholder_name}}</td>
                                    <td>{{$aRow->expiration_date}}</td>
                                    <td>
                                        <a href="{{ route('carddelete', $aRow->id) }}" onclick="return confirm('Are you sure?');" >Delete</a>
                                    </td>
                                </tr>
                                 @endforeach
                            </tbody>
                        </table>
                        @else
                        No data found
                        @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Add Credit Card') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('cardsave') }}" enctype="multipart/form-data">
                        @csrf
                              <div class="col-md-10">
                            <div class="form-group row">
                                <label for="" class="col-form-label">{{ __('Card Type') }}</label><br>
                                {{ Form::select('card_type', ['' =>'Please Select','Visa' => 'Visa','Master Card' => 'Master Card','American Express' => 'American Express'] , old('card_type') , ['class' => 'form-control show-tick', 'required' => 'required']) }}
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-form-label">{{ __('Card Number') }}</label><br>
                                <input id="card_no" type="number" class="form-control{{ $errors->has('card_no') ? ' is-invalid' : '' }}" name="card_no" value="{{ old('card_no') }}" required>

                                @if ($errors->has('card_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('card_no') }}</strong>
                                    </span>
                                @endif

                            </div>
                             <div class="form-group row">
                                <label for="" class="col-form-label">{{ __('Card Holder Name') }}</label><br>
                                <input id="cardholder_name" type="text" class="form-control{{ $errors->has('cardholder_name') ? ' is-invalid' : '' }}" name="cardholder_name" value="" required>

                                @if ($errors->has('cardholder_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cardholder_name') }}</strong>
                                    </span>
                                @endif
                            </div>


                             <div class="form-group row">
                                <label for="" class="col-form-label">{{ __('Expiration Date') }}</label><br>
                               <div class="clearfix" style="width: 100%">
                                {{ Form::select('month', ['' =>'Please Select'] + $aMonths , old('month') , ['class' => 'form-control', 'required' => 'required','style' => 'width:34%;display: inline-block']) }}
                                {{ Form::select('year', ['' =>'Please Select'] + $aYears , old('year') , ['class' => 'form-control', 'required' => 'required','style' => 'width:45%;display: inline-block']) }}
                                </div>
                            </div>


                             <div class="form-group row">
                                <input id="" type="checkbox" class="" name="business_booking" value="1">
                               &nbsp;&nbsp; Use this card for business booking

                            </div>

                            <div class="form-group row">
                                <input id="" type="checkbox" class="" name="reward_booking" value="1">
                                &nbsp;&nbsp; Use this card for reward booking

                            </div>


                             <div class="form-group row">
                                <button type="submit" class="btn btn-primary"> {{ __('Save') }}                           </button>                           </div>


                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
