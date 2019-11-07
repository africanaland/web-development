<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserLoginType
{

    public function handle($request, Closure $next, $guard = null)
    {
        $aUser = Auth::guard('admin')->user();
        $adminLogin = $staffLogin = $hostLogin = false;
        if (in_array($aUser->role_id, array(User::ROLE_ADMIN, User::ROLE_SUBADMIN)))
            $adminLogin = true;
        if (in_array($aUser->role_id, array(User::ROLE_AGENT)))
            $staffLogin = true;
        if (in_array($aUser->role_id, array(User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL)))
            $hostLogin = true;

        view()->share('adminLogin', $adminLogin);
        view()->share('staffLogin', $staffLogin);
        view()->share('hostLogin', $hostLogin);

        return $next($request);
    }
}
