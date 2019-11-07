@extends('layouts.app')
@section('title') Guest Care Report @endsection
@inject('userObj', 'App\User')
@php
    $userdata = $userObj->getUserData($aRow->reply_by,array('username'));
@endphp

@section('pagebanner')
<div class="pageBanner guestCareBanner">
    <img src="{{ asset('public/images/bg3.png')  }}"  alt="">
    <span>{{ __('Guest Care Report') }}</span>
</div>
@endsection
@section('content')
<div class="container pageWrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header"></div> -->
                <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="" class="col-form-label">{{ __('Username') }}</label>
                                <input id="username" type="text" readonly class="form-control" name="username" value="{{ $aUser->username }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="" class="col-form-label">{{ __('Name') }}</label>
                                <input id="name" type="text" readonly class="form-control" name="name" value="{{ $aUser->fname }} {{ $aUser->lname }}" required>
                            </div>
                        </div>


                        <div class="form-group row">


                            <div class="col-md-6">
                                <label for="mobile" class="col-form-label">{{ __('Mobile') }}</label>
                                <input id="mobile" type="text" readonly class="form-control" name="mobile" value="{{ $aUser->mobile }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="col-form-label">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control" readonly name="email" value="{{ $aUser->email }}" readonly>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="" class="col-form-label">{{ __('Subject') }}</label>
                                <input id="subject" type="text" class="form-control" name="subject" value="{{ $aRow->subject }}" readonly>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="username" class="col-form-label">{{ __('Reply By') }}</label>
                                <input id="email" type="email" class="form-control" readonly name="email" value="{{ $userdata->username }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="username" class="col-form-label">{{ __('Message') }}</label>
                                <textarea class="form-control" rows="6" name="message" readonly>{{ $aRow->message }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="username" class="col-form-label">{{ __('Reply Message') }}</label>
                                <textarea class="form-control" rows="6" name="message" readonly>{{ $aRow->reply }}</textarea>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
