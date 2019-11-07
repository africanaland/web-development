<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout','getLogout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function attemptLogin(Request $request)
    {
        $email = $request->email;
        $domain = $_SERVER['SERVER_NAME'];
        $aUser = User::where('email','=',$email)->first();

        if(!$aUser)
        {
            return $this->sendFailedLoginResponse($request);
        }
        else{
            $privileges = Role::getRolename($aUser->role_id,'privileges');
        }
        if($privileges == 3){
            return $this->sendFailedLoginResponse($request); /* for guest */
        }
        if($domain == "staff.africanaland.com")
        {
            if($privileges != User::PREV_ADMIN)
            {
                return $this->sendFailedLoginResponse($request);
            }
        }
        if($domain == "host.africanaland.com")
        {
            if($privileges != User::PREV_HOST)
            {
                return $this->sendFailedLoginResponse($request);
            }
        }    

        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );    
        
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }

    /* for get Logout request */
    public function getLogout()
    {
        if(\Session::get('error')){
            $message = \Session::get('error');
        }else{
            $message = "";
        }
        Auth::guard('admin')->logout();
        return redirect('/')->with('error',$message);
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only('email', 'password');
        //$credentials = array_add($credentials, 'role_id', User::ROLE_ADMIN);
        $credentials = array_add($credentials, 'status', '1');

        return $credentials;
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
