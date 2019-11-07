<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @include('users.social')
    <div class="modal-error"></div>
    <form method="POST" id="frmRegister" action="{{ route('register') }}" onsubmit="return submitFrm(this);">
        @csrf

        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input id="email" type="text" placeholder="{{ __('Username') }}" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>
                    @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                    <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    </div>
                    <input id="password" placeholder="{{ __('Password') }}" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    </div>
                    <input id="password" placeholder="{{ __('Confirm Password') }}" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

                </div>
            </div>
        </div>




        <div class="form-group row">
            <div class="col-md-12 text-center">
                <input class="form-check-input" type="checkbox" required name="accept">
                I accept <a href="{{ route('privacy-policy') }}" class="btn-link">terms & conditons</a>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-afland">
                    {{ __('Sign Up') }}
                </button>
                <div class="clearfix text-center mt-2">
                    <a class="btn-link" onclick="showLogin()" href="javascript:void(0);">
                        {{ __('Already an account?') }}
                    </a>
                </div>
            </div>
        </div>

    </form>
</div>


<div class="modal-loader"><i class="fa fa-spinner fa-spin"></i></div>
