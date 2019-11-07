@extends('layouts.app')
@section('title') Guest Care @endsection


@section('pagebanner')
<div class="pageBanner guestCareBanner">
    <img src="{{ asset('public/images/bg3.png')  }}"  alt="">
    <span>{{ __('Guest Care') }}</span>
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
                <!-- <div class="card-header"></div> -->
                <div class="card-body">
                    <form method="POST" action="{{ route('guestcare') }}" enctype="multipart/form-data">
                        @csrf

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
                                <input id="mobile" type="text" readonly class="form-control" name="mobile" value="{{ $aUser->mobile }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="col-form-label">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control" readonly name="email" value="{{ $aUser->email }}" required>
                            </div>

                        </div>

                        <div class="form-group row">

                            <div class="col-md-6 customSelect">
                                <label for="mobile" class="col-form-label ">{{ __('Department') }}</label>
                                {{ Form::select('department', ['' =>'Select Department','Complaints' => 'Complaints'] ,  old('department') , ['class' => 'form-control show-tick', 'required' => 'required']) }}
                            </div>
                            <div class="col-md-6">
                                <label for="" class="col-form-label">{{ __('Subject') }}</label>
                                <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject') }}" required>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="username" class="col-form-label">{{ __('Message') }}</label>
                                <textarea class="form-control" rows="6" name="message" required>{{ old('message')}}</textarea>
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
@endsection
