<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
class checkStaffLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth=Auth::guard('admin')->user();
        if (!in_array($auth->role_id,[User::ROLE_ADMIN, User::ROLE_SUBADMIN,User::ROLE_AGENT,User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL])) {
          Session::put('error','You are not aunthicate user');
            return redirect()->route('getLogout');
        }

        

        return $next($request);
    }
}
