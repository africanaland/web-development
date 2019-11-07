<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Membership;
use App\Helpers\CustomHelper;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8','required_with:password_confirmation','same:password_confirmation'],
            'password_confirmation' => ['required', 'min:8'],

        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $signup_token = base64_encode(time());
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_token' => $signup_token,
            'role_id' => User::ROLE_GUEST,
            'membership_id' => Membership::getDefault()
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        //$this->guard()->login($user);
        $signup_token = base64_encode(time());
        $alink =  url("users/activation/{$signup_token}");
        $bodyText = "Hi ".$request['username'];
        $bodyText .= "<p>Thank you for registration.please <a href='".$alink."'>
        click here</a> to activate you account</p>";
        CustomHelper::sendEmail($request['email'],"Activation Email",$bodyText);
        //$this->registered($request, $user);
        $data = array();
        $data['status'] = 'success';
        $data['message'] = 'Registration success';
        return response()->json($data);
        //return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
}
