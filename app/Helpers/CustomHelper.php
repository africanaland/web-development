<?php

namespace App\Helpers;

use Mail;
use App\Property;
use DateTime;
use App\Booking;
use App\User;
use Carbon\Carbon;
use App\Membership;
use App\Events\sendNotification;
use App\Policy;
use App\notification;

class CustomHelper
{
    public static function sendEmail($aTo, $aSubject, $aBody, $attachments = "")
    {
        Mail::send(['html' => 'emails.send'], ['title' => $aSubject, 'body' => $aBody],
            function ($message) use ($aTo, $aSubject, $aBody, $attachments) {
            $message->from('no-reply@africanaland.com', 'Africanland Team');
            $message->to([$aTo]);
            $message->subject($aSubject);
            if ($attachments) {
                $message->attach($attachments);
                //$message->attach('path_to_pdf_file', [ 'as' => 'your-desired-name.zip', 'mime' => 'application/pdf'] );
            }
        });
    }

    public static function sendServiceEmail($aTo, $aSubject,$tPath , $aBody, $attachments = "")
    {
        Mail::send(['html' => $tPath], $aBody, function ($message) use ($aTo, $aSubject, $aBody, $attachments) {
            $message->from('no-reply@africanaland.com', 'Africanland Team');
            $message->to([$aTo]);
            $message->subject($aSubject);
            if ($attachments) {
                $message->attach($attachments);
            }
        });
    }

    public static function removeImage($image)
    {
        $imgPath = public_path('/uploads/' . $image);
        @unlink($imgPath);
        return true;
    }
    public static function uploadImage($image, $chkext = true)
    {
        $imageArray = array("png", "jpg", "jpeg", "gif", "bmp");
        $imagename = "";
        if ($image) {
            $imageext = $image->getClientOriginalExtension();
            if (!in_array($imageext, $imageArray) && $chkext) {
                return "";
            }
            $imagename = time() . '.' . $imageext;
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $imagename);
        }
        return  $imagename;
    }

    public static function getNotificationTime($date){
        $time = '';
        $first_date = Carbon::today();
        $second_date = Carbon::parse($date);
        $difference = $second_date->diff($first_date);
        if(!empty($difference->m))
            $time = $difference->m.' Month Ago';
        else if(!empty($difference->d))
            $time = $difference->d." Day Ago";
        else if(!empty($difference->h))
            $time = $difference->h." Hour Ago";
        else if(!empty($difference->i))
            $time = $difference->i." Min Ago";
        return $time;
    }

    public static function updateMembershis($userId){
        $now = Carbon::today();
        $uData = User::where('id',$userId)->first();
        $mData = Membership::pluck('no_bookings','id')->toArray();
        $count = Booking::where([['user_id',$uData->id],['bookingStatus',1],['status',2]])
                            ->where('checkout','<',$now)->count();

        $temp = '';
        foreach ($mData as $key => $value) {
            if($count >= $value){
                $temp = $key;
            }else{
                break;
            }
        }
        if($temp > $uData->membership_id){
            $uData->membership_id = $temp;
            $uData->update();
            event(new sendNotification(0,$userId,14,$userId));/* upgrade membership */
        }
        return true;
    }


    public static function getNotificationMgs($id, $type)
    {
        switch($type){
            case "bookingConfirm":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('bookings', 'bookings.id', '=', 'notifications.data_id')
                                ->join('users', 'users.id', '=', 'bookings.user_id')
                                ->join('properties','properties.id','=','bookings.property_id')
                                ->select('properties.name as proName', 'bookings.id as bookingId','users.fname as userName', 'notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();

                if ($aData) {
                    $array1 = ['pro:name', '<a href="pro:url" class="btn btn-sm">Click</a>','user:name'];
                    $array2 = [
                        $aData->proName,
                        'Booking Id : '.$aData->bookingId,
                        $aData->userName
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;

            case "membership":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('users', 'users.id', '=', 'notifications.data_id')
                                ->join('memberships', 'users.membership_id', '=', 'memberships.id')
                                ->select('memberships.name as Mname','users.fname as userName', 'notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();

                if ($aData) {
                    $array1 = ['user:name', 'data:type'];
                    $array2 = [
                        $aData->userName,
                        $aData->Mname,
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;

            case "guestCareReport":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('guestcares', 'guestcares.id', '=', 'notifications.data_id')
                                ->join('users', 'users.id', '=', 'guestcares.user_id')
                                ->select('guestcares.subject as subject','users.fname as userName', 'guestcares.id as report_id','notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();

                if ($aData) {
                    $array1 = ['user:name', 'report:subject','report:url'];
                    $array2 = [
                        $aData->userName,
                        $aData->subject,
                        route('guestcareView',$aData->report_id),
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;
            
            
            case "text":
                $aData = notification::join('notification_detail', 'notification_detail.id', '=', 'notifications.text_id')
                                    ->select('detail')
                                    ->where('notifications.id', $id)->first();
            if ($aData) 
                return $aData->detail;
            break;


 
 
            default:
                return false;
        }
    }

}
