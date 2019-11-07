<?php
namespace App\Helpers;
use Mail;
use App\Category;
use Auth;
use App\Property;
use App\notification;
use App\Booking;
use App\Policy;
use App\User;


class CustomHelper
{
    public static function sendEmail($aTo,$aSubject,$aBody,$attachments = "")
    {
        Mail::send(['html' => 'emails.send'], ['title' => $aSubject, 'body' => $aBody], function ($message) use ($aTo,$aSubject,$aBody,$attachments)
        {
              $message->from('no-reply@africanaland.com', 'African Land');
              $message->to([$aTo]);
              $message->subject($aSubject);
              if($attachments)
              {
                $message->attach($attachments);
              }


        });
    }

    public static function sendServiceEmail($aTo, $aSubject,$tPath , $aBody, $attachments = "")
    {
        Mail::send(['html' => $tPath], $aBody, function ($message) use ($aTo, $aSubject, $aBody, $attachments) {
            $message->from('no-reply@africanaland.com', 'African Land');
            $message->to([$aTo]);
            $message->subject($aSubject);
            if ($attachments) {
                $message->attach($attachments);
            }
        });
    }


    public static function displayImage($image)
    {

        $imgPath = self::getImagepath('url')."/images/profile.png";
        if($image)
        {
            $imgPath = self::getImagepath('url')."/uploads/".$image;
        }
        return $imgPath;
    }

    public static function getImagepath($type = 'dir')
    {
        $path = dirname(dirname(public_path()))."/public";
        if($type == "url")
        {
            $path = env('APP_MAIN_URL')."/public";
        }
        return $path;
    }

    public static function removeImage($image)
    {
        $imgPath = self::getImagepath()."/uploads/".$image;
        @unlink($imgPath);
        return true;
    }

    public static function uploadImage($image,$chkext = true)
    {
        $imageArray = array("png","jpg","jpeg","gif","bmp");
    	$imagename = "";
    	if($image)
        {
            $imageext = $image->getClientOriginalExtension();
            $imgname = $image->getClientOriginalName();
            if(!in_array($imageext,$imageArray) && $chkext)
            {
                return "";
            }
            $imagename = strtolower($imgname)."_".time().'.'.$imageext;
            $destinationPath = self::getImagepath()."/uploads/";
            $image->move($destinationPath, $imagename);

        }
        return  $imagename;
    }


    public static function getNotificationMgs($id, $type)
    {
        switch($type){
            case "properties":
                $aData = Property::join('notifications', 'notifications.data_id', '=', 'properties.id')
                                    ->join('notification_detail', 'notification_detail.id', '=', 'notifications.text_id')
                                    ->join('countries', 'countries.id', '=', 'properties.country')
                                    ->join('users', 'users.id', '=', 'properties.user_id')
                                    ->select('users.fname as userName','countries.name as countryName','properties.name as proName', 'properties.id as proId', 'notification_detail.detail as proContent')
                                    ->where('notifications.id', $id)->first();
                if ($aData) {
                    $array1 = ['pro:name', 'pro:url','data:country','data:name'];
                    $array2 = [
                        $aData->proName,
                        route('property.show', $aData->proId),
                        $aData->countryName,
                        $aData->userName,
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;

            case "gustRegister":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('users', 'users.id', '=', 'notifications.data_id')
                                ->select('users.id as userId','users.username as userName', 'notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();

                if ($aData) {
                    $array1 = ['user:name', 'data:url'];
                    $array2 = [
                        $aData->userName,
                        route('users.show', $aData->userId)
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;

            case "hostRegister":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('users', 'users.id', '=', 'notifications.data_id')
                                ->select('users.creator_id','users.id as userId','users.fname as userName', 'notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();

                if ($aData) {
                    $creator = User::getUserData($aData->creator_id,array('fname'));
                    $array1 = ['user:name', 'data:url','data:name'];
                    $array2 = [
                        $aData->userName,
                        route('users.show', $aData->userId),
                        $creator->fname,
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;

            case "bookingCreate":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('bookings', 'bookings.id', '=', 'notifications.data_id')
                                ->join('users', 'users.id', '=', 'bookings.user_id')
                                ->join('properties','properties.id','=','bookings.property_id')
                                ->select('properties.name as proName', 'bookings.id as bookingId','users.fname as userName', 'notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();

                if ($aData) {
                    $array1 = ['pro:name', 'pro:url','user:name'];
                    $array2 = [
                        $aData->proName,
                        route('viewbooking', $aData->bookingId),
                        $aData->userName
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;

            case "bookingConfirm":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('bookings', 'bookings.id', '=', 'notifications.data_id')
                                ->join('users', 'users.id', '=', 'bookings.user_id')
                                ->join('properties','properties.id','=','bookings.property_id')
                                ->select('properties.name as proName', 'bookings.id as bookingId','users.fname as userName', 'notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();

                if ($aData) {
                    $array1 = ['pro:name', 'pro:url','user:name'];
                    $array2 = [
                        $aData->proName,
                        route('viewbooking', $aData->bookingId),
                        $aData->userName
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;


            case "bookingPayment":
                $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                    ->join('bookings', 'bookings.id', '=', 'notifications.data_id')
                                    ->join('users', 'users.id', '=', 'bookings.user_id')
                                    ->join('properties','properties.id','=','bookings.property_id')
                                    ->select('bookings.paid_amount as amount','properties.name as proName', 'bookings.id as bookingId','users.fname as userName', 'notification_detail.detail as proContent')
                                    ->where('notifications.id', $id)->first();
                
                    if ($aData) {
                        $array1 = ['pro:name', 'pro:url','user:name','pro:amount'];
                        $array2 = [
                            $aData->proName,
                            route('viewbooking', $aData->bookingId),
                            $aData->userName,
                            $aData->amount,
                        ];
                        return str_replace($array1, $array2, $aData->proContent);
                    }
            break;

            case "bookingCancel":
                $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                    ->join('bookings', 'bookings.id', '=', 'notifications.data_id')
                                    ->join('users', 'users.id', '=', 'bookings.user_id')
                                    ->join('properties','properties.id','=','bookings.property_id')
                                    ->select('properties.name as proName', 'bookings.id as bookingId','users.fname as userName', 'notification_detail.detail as proContent')
                                    ->where('notifications.id', $id)->first();
                
                    if ($aData) {
                        $array1 = ['pro:name', 'pro:url','user:name'];
                        $array2 = [
                            $aData->proName,
                            route('viewbooking', $aData->bookingId),
                            $aData->userName
                        ];
                        return str_replace($array1, $array2, $aData->proContent);
                    }
            break;

            case "bookingUpdate":
                $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                    ->join('bookings', 'bookings.id', '=', 'notifications.data_id')
                                    ->join('users', 'users.id', '=', 'bookings.user_id')
                                    ->join('properties','properties.id','=','bookings.property_id')
                                    ->select('properties.name as proName', 'bookings.id as bookingId','users.fname as userName', 'notification_detail.detail as proContent')
                                    ->where('notifications.id', $id)->first();
                
                    if ($aData) {
                        $array1 = ['pro:name', 'pro:url','user:name'];
                        $array2 = [
                            $aData->proName,
                            route('viewbooking', $aData->bookingId),
                            $aData->userName
                        ];
                        return str_replace($array1, $array2, $aData->proContent);
                    }
            break;

            case "agreementAccept":
                $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                    ->join('users', 'users.id', '=', 'notifications.data_id')
                                    ->join('roles', 'roles.id', '=', 'users.role_id')
                                    ->select('roles.name as roleName','users.id as userId','users.fname as userName', 'notification_detail.detail as proContent')
                                    ->where('notifications.id', $id)->first();

                    if ($aData) {
                        $array1 = ['user:name', 'user:url','host::type'];
                        $array2 = [
                            $aData->userName,
                            route('users.edit', $aData->userId),
                            $aData->roleName
                        ];
                        return str_replace($array1, $array2, $aData->proContent);
                    }
            break;

            case "agreementReject":
                $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                    ->join('users', 'users.id', '=', 'notifications.data_id')
                                    ->join('roles', 'roles.id', '=', 'users.role_id')
                                    ->select('roles.name as roleName','users.id as userId','users.fname as userName', 'notification_detail.detail as proContent')
                                    ->where('notifications.id', $id)->first();

                    if ($aData) {
                        $array1 = ['user:name', 'user:url','host::type'];
                        $array2 = [
                            $aData->userName,
                            route('users.edit', $aData->userId),
                            $aData->roleName
                        ];
                        return str_replace($array1, $array2, $aData->proContent);
                    }
            break;

            case "profile":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('users', 'users.id', '=', 'notifications.data_id')
                                ->select('users.updated_at as date','users.fname as userName', 'notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();

                if ($aData) {
                    $array1 = ['data:name', 'data:date'];
                    $array2 = [
                        $aData->userName,
                        date('d/M/y',strtotime($aData->date)),
                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;

        
            case "AdminPayment":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('challans', 'challans.id', '=', 'notifications.data_id')
                                ->join('users', 'users.id', '=', 'challans.user_id')
                                ->select('challans.id as cID','challans.mark','challans.admin_amount','users.fname as userName','users.id as userId','notification_detail.detail as proContent')
                                ->where('notifications.id',$id)->first();
            // $aData->total ? $type = true : $type = false ;
                if ($aData) {
                    $array1 = ['data:name', 'pro:url','user:service','pro:amount'];
                    $array2 = [
                        $aData->userName,
                        route('challan.show', $aData->cID),
                        $aData->mark,
                        $aData->admin_amount,

                    ];
                    return str_replace($array1, $array2, $aData->proContent);
                }
            break;

            case "HostPayment":
            $aData = notification::join('notification_detail', 'notifications.text_id', '=', 'notification_detail.id')
                                ->join('challans', 'challans.id', '=', 'notifications.data_id')
                                ->join('users', 'users.id', '=', 'challans.user_id')
                                ->select('challans.id as cID','challans.mark','challans.admin_amount','users.fname as userName','users.id as userId','notification_detail.detail as proContent')
                                ->where('notifications.id', $id)->first();
                if ($aData) {
                    $array1 = ['user:name', 'pro:url','user:service','pro:amount'];
                    $array2 = [
                        $aData->userName,
                        route('challan.show', $aData->cID),
                        $aData->mark,
                        $aData->admin_amount,
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
