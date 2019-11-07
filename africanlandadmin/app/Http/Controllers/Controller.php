<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function UserLoginType($role_id){
        if (in_array($role_id, array(User::ROLE_ADMIN, User::ROLE_SUBADMIN)))
            return 'adminLogin';
        if (in_array($role_id, array(User::ROLE_AGENT)))
            return 'staffLogin';
        if (in_array($role_id, array(User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL)))
            return 'hostLogin';
    }
}
