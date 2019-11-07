@extends('layouts.app')
@section('title') Profile @endsection


@section('pagebanner')
<div class="pageBanner profileBanner">
    <img src="{{ asset('public/images/bg6.png')  }}" alt="">
    <span>{{ __('Settings') }}</span>
</div>
@endsection
@section('content')

<script>
    var getcityurl = '{{ route("getcity") }}';
</script>
<div class="container pageWrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body p-sm-3 p-0">
                    <form method="POST" action="{{ route('userupdate') }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('patch') }}

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="fname" class="col-form-label">{{ __('Name') }}</label>
                                <input id="fname" type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ $aUser->fname }}" required>
                                @if ($errors->has('fname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fname') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="mobileFlag" class="col-form-label">{{ __('Mobile') }}</label>
                                <div class="d-flex">
                                    {{-- <input id="mobile" type="tel" class="w-100 form-control {{ $errors->has('countryCode') ? ' is-invalid' : '' }}" name="countryCode" value="{{ $aUser->countryCode }}" required> --}}
                                    <input id="mobileFlag" type="tel" pattern="[0-9,+]+" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ $aUser->mobile }}" required>
                                </div>
                                @if ($errors->has('mobile'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                                @endif
                                @if ($errors->has('countryCode'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('countryCode') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>


                        <div class="form-group row">

                            <div class="col-md-6">
                                <label for="email" class="col-form-label">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $aUser->email }}" required>
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="mobile" class="col-form-label">{{ __('Country') }}</label>
                                {{ Form::select('country', ['' =>'Please Select'] + $aCountries,  $aUser ? $aUser->country : old('country') , ['class' => 'form-control show-tick', 'required' => 'required','onchange' => 'getcity(this)']) }}
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <label for="city" class="col-form-label">{{ __('City') }}</label>
                                {{ Form::select('city', ['' =>'Please Select'] + $aCities, $aUser ? $aUser->city : old('city') , ['class' => 'form-control citywrap', ]) }}
                            </div>

                            <div class="col-md-6">
                                <label for="address" class="col-form-label">{{ __('Address') }}</label>
                                <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $aUser->address }}" required>
                            </div>

                        </div>


                        <div class="form-group row">

                            <div class="col-md-6">
                                <label for="dob" class="col-form-label">{{ __('Date Of Birth') }}</label>
                                <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control {{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="DD/MM/YYYY" name="dob" value="{{ $aUser->dob }}" required >
                                        <div class="input-group-addon">
                                        </div>
                                    </div>

                                @if ($errors->has('dob'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6 f-flex">
                                <label class="col-form-label">{{ __('Gender') }}</label>
                                <div class="checkDiv">
                                    <input type="radio" name="gender" class="d-none" value="1" @if($aUser->gender == 1) checked @endif id="Usermale">
                                    <input type="radio" name="gender" class="d-none" value="2" @if($aUser->gender == 2) checked @endif id="Userfemale">
                                </div>

                                <div data-value='Usermale' class="btn btn-user @if($aUser->gender == 1) active @endif">Male</div>
                                <div data-value='Userfemale' class="btn btn-user @if($aUser->gender == 2) active @endif">Female</div>

                                @if ($errors->has('gender'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="username" class="col-form-label">{{ __('User Name') }}</label>
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $aUser->username }}" required>
                                @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="col-form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="image" class="col-form-label">{{ __('Profile Image') }}</label>
                                <input id="image" type="file" class="form-control p-1" name="image" value="">
                                @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-5 text-center"></div>
                            <div class="col-md-2 text-center">
                                <button type="submit" class="btn btn-afland">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>

                    <!-- <br>
<br>

<a class="" href="{{ route('usercard') }}">{{ __('Add credit cards') }}</a>
<a class="" href="{{ route('changepassword') }}" style="float: right;">{{ __('Change Password') }}</a>
 -->

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('after-scripts')
<script>
$(document).ready(function(){
    var input = document.querySelector("#mobileFlag");
    window.intlTelInput(input);
})

</script>

@endpush
