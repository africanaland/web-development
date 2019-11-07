<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;


class notification extends Model
{
    protected $fillable = ['broadcast','s_id','r_id','text_id','data_id','castDate','castStatus','status'];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'r_id');
    }


/*
               (manual notification)                    ||           (for)
            (broadcast)    (s_id)         (r_id)        ||         
                0             0     |       id          ||      system to user(all type of user)
                0            id     |       id          ||      user to user
----------------------------------------------------------------------------------------
                (Broadcast message)
            (broadcast)    (s_id)         (r_id)        ||         
              role_Id       0/id     |       0          ||      user(admin/staff) ADD Broadcast for staff
              role_Id       0/id     |       0          ||      user(admin/staff) Add BroadCast for host
              role_Id       0/id     |       0          ||      user(admin/staff) Add BroadCast for guest

*/

    public static function getNotification($user,$type=0,$count = false)
    {
        $aUser = \Auth::guard('admin')->user();
        $today = Carbon::now();
        $aRow = notification::join('notification_detail','notification_detail.id','=','notifications.text_id')
                                ->select('notification_detail.*','notifications.id as id','notifications.*');

        if($count)
        $aRow->whereRaw("NOT FIND_IN_SET(".$aUser->id.",notifications.castStatus)");

        if($user == 'admin'){
            if($type)
                $aRow->where('notifications.s_id',$aUser->id);
            else{
                $aRow->where(function($query){
                    $query->where('notifications.s_id', 0); // from host
                    $query->whereNotIn('notifications.text_id',[12,5,15]);
                    $query->orWhere(function($query1){
                        $query1->where([['notifications.r_id','=',1]]);
                    });
                });    
            }
        }
        if($user == 'staff'){
            if($type){
                $aRow->where('notifications.s_id',$aUser->id);
            }
            else{
                $AllRigisteredHost = User::where('creator_id', $aUser->id)->pluck('id')->toArray();
                $aRow->where(function($query) use ($aUser,$AllRigisteredHost){
                    $query->whereIn('notifications.r_id',$AllRigisteredHost); // from host
                    $query->orWhere('notifications.r_id',$aUser->id);
                });
                $aRow->where('notifications.castDate','<=',$today);
            }
        }
        if($user == 'host'){
            $aRow->where(function($query) use ($aUser){
                $query->where('notifications.r_id','=',$aUser->id); // send by admin
                $query->orWhere('notifications.broadcast',$aUser->role_id);
            });
            $aRow->where('notifications.castDate','<=',$today);
        }

        $aRow->orderBy('notifications.id','DESC');

        if($count)
            $result = $aRow->count();
        else
            $result = $aRow->get();
        //     $result = $aRow->toSql();
        // echo '<pre>';
        // print_r($result);
        // die();

        if($result)
            return $result;
        else
            return false;
        
    }
}
