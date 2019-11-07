<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class notification extends Model
{
    protected $fillable = ['s_id','r_id','text_id','data_id','castDate','castStatus','status'];
    public $timestamps = false;


    public static function getNotification($count = false){
        $aUser = Auth::user();
        $today = Carbon::now();
        $aRow = notification::join('notification_detail','notification_detail.id','=','notifications.text_id')
                                ->select('notification_detail.*','notifications.id as id','notifications.*');
        

        if($count)
        $aRow->whereRaw("NOT FIND_IN_SET(".$aUser->id.",notifications.castStatus)");
        $aRow->where(function($query) use ($aUser,$today){
            $query->where('notifications.r_id',$aUser->id);
            $query->Where('notifications.castDate','<=',$today);
        });
        $aRow->orderBy('notifications.id','DESC');

        if($count)
            $result = $aRow->count();
        else
            $result = $aRow->get();


        if($result)
            return $result;
        else {
            return false;
        }
    }

}
