<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\Membership;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

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
    protected $redirectTo = '/users/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials = array_add($credentials, 'role_id', User::ROLE_GUEST);
        $credentials = array_add($credentials, 'status', '1');

        return $credentials;
    }


    public function socialredirect($service) {
        return Socialite::driver ( $service )->redirect ();
    }

    public function socialcallback($service) { 
        $user = Socialite::with ( $service )->user ();
        
        $email = "";
        if(isset($user) && $user->email)
        {
            $email = $user->email;
            $aUser = User::where('email','=',$email)->first();
            if($aUser)
            {
                auth()->login($aUser, true);
            }
            else
            {
                $signup_token = base64_encode(time()); 
                $aUser = User::create([
                    'email' => $email,
                    'password' => "",
                    'email_token' => $signup_token,
                    'role_id' => User::ROLE_GUEST,
                    'membership_id' => Membership::getDefault(),
                    'status' => 1
                ]);
                auth()->login($aUser, true);
            }

            return redirect('users/profile')->with('message', 'login successfully. ');            
        }

        return redirect('login')->with('error', 'login failed. ');

    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showAjaxLoginForm()
    {
        return view('auth.ajaxlogin');
    }

    public function sociallogin()
    {
        $aVals = isset($_POST) ? $_POST : array();
        if($aVals && $aVals['email'])
        {
            $aUser = User::where('email','=',$aVals['email'])->first();
            if($aUser)
            {
                auth()->login($aUser, true);
            }
            else
            {
                $signup_token = base64_encode(time()); 
                $aUser = User::create([
                    'email' => $aVals['email'],
                    'password' => "",
                    'email_token' => $signup_token,
                    'role_id' => User::ROLE_GUEST,
                    'membership_id' => Membership::getDefault(),
                    'status' => 1
                ]);
                auth()->login($aUser, true);
            }

            Session::flash('message', 'You login successfully !'); 
            return  url("users/profile");
            exit;
        }

        Session::flash('error', 'Login failed !'); 
        return  url("users/login");
        exit;
    }
    
}
