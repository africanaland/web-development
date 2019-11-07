<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class Agreement
{

    public function handle($request, Closure $next, $guard = null)
    {
        $userArray = array(User::ROLE_AGENT,User::ROLE_HOST_COMPANY,User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL);
        $aUser = Auth::guard('admin')->user();
        if (in_array($aUser->role_id,$userArray) && $aUser->agreement != 2) {
            return redirect('/agreement');
        }
        return $next($request);
    }
}
