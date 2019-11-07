<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
     <h4 class="popupHeading text-center">{{ __('Login to your account') }}   </h4>
    @include('users.social')

    <div class="modal-error"></div>

    <form method="POST" action="{{ route('login') }}" class="socialLoginForm" onsubmit="return submitFrm(this,'{{ route('userprofile') }}');" id="loginFrm">
        @csrf
        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                    <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    </div>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Password') }}">
                    <span class="pwsBtn" id="pwsBtn" onclick="ShowPassword()">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6">
                <div class="form-check text-size14">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
            <div class="col-6 text-right">
                @if (Route::has('password.request'))
                <a class="btn-link text-size14" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>
        </div>

        <div class="form-group row pt-2">
            <div class="col-md-12">
                <button type="submit" class="btn btn-afland">
                    {{ __('Login') }}
                </button>
            </div>
        </div>

    </form>
</div>
<div class="modal-loader"><i class="fa fa-spinner fa-spin"></i></div>
