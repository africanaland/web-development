@extends('layouts.app')
@section('title') Become a host @endsection
@push('add-css')
<link rel="stylesheet" href="{{ asset('public/css/select2.min.css')}}">
@endpush



@section('pagebanner')
<div class="pageBanner becomHostBanner">
    <img src="{{ asset('public/images/bg1.png')  }}" alt="">
    <span>{{ __('Become a host') }}</span>
</div>
@endsection
@section('content')

<div class="container pageWrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!--  <div class="card-header"></div> -->
                <div class="card-body p-sm-3 p-0">
                    <form method="POST" action="{{ route('postbecomehost') }}" class="becomehostForm" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname" class="col-form-label">{{ __('First Name') }}</label>
                                    <input id="fname" type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ old('fname') }}" required>
                                    @if ($errors->has('fname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label text-md-right">{{ __('Last Name') }}</label>

                                    <input id="lname" type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{ old('lname') }}" required>

                                    @if ($errors->has('lname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name" class="col-form-label ">{{ __('Company Name') }}</label><input id="company_name" type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ old('company_name') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="col-form-label">{{ __('Email') }}</label>


                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class=" col-form-label">{{ __('Phone Number') }}</label>
                                    <input id="mobileFlag" type="tel" pattern="[0-9,+]+" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class=" col-form-label">{{ __('Mobile Number') }}</label>
                                    <input id="phoneFlag" type="tel" pattern="[0-9,+]+" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" required>
                                    @if ($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">{{ __('Country') }}</label>
                                    {{ Form::select('country', ['' =>'Please Select'] + $aCountries,  old('country') , ['class' => 'form-control show-tick selectDropDown', 'required' => 'required','onchange' => 'getcityForHost(this)']) }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city" class="col-form-label">{{ __('City') }}</label>
                                    <div class="">
                                        {{ Form::select('city', ['' =>'Please Select'], old('city') , ['class' => 'cityList form-control selectDropDown', ]) }}
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">{{ __('Host Type') }}</label>
                                    <div class="clear"></div>
                                    @if($aHosttypes)
                                    @foreach($aHosttypes as $hKey => $aHosttype)
                                    <div class=" form-control radio-control">
                                        <input type="radio" name="role_id" value="{{$hKey}}" onclick="getprotype(this);" >
                                        <label>{{ $aHosttype }}</label>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">{{ __('Property Type') }}</label>
                                    <hr class="my-1">
                                    <div class="protypewrap" style="padding-top: 10px">
                                        @if($aProptypes)
                                        @foreach($aProptypes as $pKey => $aProptype)
                                        <div class="checkbox orange d-sm-inline d-flex mr-2">
                                            <input type="radio" class=" mr-1" name="property_type" id="{{$aProptype}}" value="{{$aProptype}}" required>
                                            <label class="font-weight-normal" for="{{$aProptype}}">{{$aProptype}}</label>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                        <label for="" class="col-form-label">{{ __('Has additional services') }}</label>

                        <div class="" style="padding-top: 10px">
                            <input type="radio" name="has_service" value="1" required onchange="show_services('1')">&nbsp;Yes &nbsp;&nbsp;
                            <input type="radio" name="has_service" value="0" checked="" required onchange="show_services('0')">&nbsp;No &nbsp;&nbsp;
                        </div>
                </div>
            </div>

            <div class="col-md-6">
            </div>
        </div>--}}

        <div class="row">
            <div class="col-md-12">
                <div class="form-group additional_services" style="">
                    <label for="" class="col-form-label">{{ __('Additional services') }}</label>
                    <div class="pt-2 d-sm-flex">
                        @if($aServices)
                        @foreach($aServices as $aKey => $aService)
                        <div class="form-control checkbox-control radio-control-checkbox mr-sm-2" data-value="{{ $aKey }}">
                            <input type="checkbox" class="data-{{ $aKey }} d-none" name="services[]"  value="{{ $aKey }}">&nbsp; {{ $aService }} &nbsp;&nbsp;
                        </div>
                        @endforeach
                        <div class="form-control checkbox-control radio-control-checkbox mr-sm-2" data-value="other">
                            <input type="checkbox" class="data-other d-none"  name="other" value="other">&nbsp; Other &nbsp;&nbsp;
                        </div>
                        @endif
                        <br><br>

                    </div>
                    <input id="service_other" type="service_other" class="form-control d-none" name="service_other" value="{{ old('service_other') }}" placeholder="Other Service">
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="" class="col-form-label">{{ __('Message') }}</label>
                    <textarea class="form-control" name="message" required rows="5">{{ old('message') }}</textarea>
                </div>
            </div>


        </div>



        <div class="row">
            <div class="col-md-5 text-center"></div>
            <div class="col-md-2 text-center">
                <button type="submit" class="btn btn-afland">{{ __('Send') }}</button>
            </div>


        </div>



        </form>
    </div>
</div>
</div>
</div>
</div>
<script>
    var getcityurl = '{{ route("getcityForHost") }}';
</script>

@endsection
@push('after-scripts')
<script src="{{ asset('public/js/select2.min.js')}}"></script>
<script>
$(document).ready(function(){
    $('.selectDropDown').select2({
        tags: true,
        width: "100%"
    });
})

$(document).ready(function(){
    var input = document.querySelector("#mobileFlag");
    var input2 = document.querySelector("#phoneFlag");
    window.intlTelInput(input);
    window.intlTelInput(input2);
})

</script>

@endpush
