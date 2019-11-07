<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    public $table = 'rooms';
    protected $fillable = ['s_id', 'r_id', 'roomId','updated_at'];


    public static function getMessage($s_id = 0, $count = false)
    {

        $aUserId = Auth::user();

        $countMsg = \DB::table('message')->where('seen', '0');
        if ($s_id == 0) {
            $countMsg->where('r_id', $aUserId->id);
        } else {
            $countMsg->where('s_id', $s_id)->where('r_id', $aUserId->id);
        }

        $countMsg->orderBy('created_at', 'ASC');
        if ($count) {
            $result = $countMsg->count();
        } else {
            $result = $countMsg->limit('3')->get();
        }
        return $result;
    }
}
