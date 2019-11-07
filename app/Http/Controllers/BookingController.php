<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Coupon;
use App\Property;
use App\Service;
use Carbon\Carbon;
use App\Events\sendNotification;
use CustomHelper;
use App\walletHistory;
use App\User;
use Session;
use Config;


class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function bookingpayment($booking_id)
    // {
    //     $aRow = Booking::where("id","=",$booking_id)->first();
    //     return view('bookings.payment',compact('aRow'));
    // }

    public function bookingpayment(){
        $aPosts = isset($_POST) ? $_POST : array();
        $aVals = json_decode($aPosts['vals'], true);
        $payKey = '';
        $property_id = $aPosts['property_id'];
        $aRow = Property::where("id", "=", $property_id)->first();
        $aUser = User::where('id',$aRow->user_id)->first();
        $total_amount = 0;
        
        if(in_array($aUser->role_id,[User::ROLE_ADMIN,User::ROLE_SUBADMIN]))
            $payKey = Config::get('services.paypal.app_key');
        else
            $payKey = $aUser->paypalClientId;

        list($addservices, $total_amount) = $this->getServiceArray($aVals, $aRow);
        $bookingdates = explode("/", $aVals['bookingdates']);
        $checkin = $bookingdates[0];
        $checkout = $bookingdates[1];

        return view('bookings.payment', compact('aRow', 'addservices', 'checkin', 'checkout', 'total_amount','payKey'));
    }

    public function bookingconfirm()
    {
        $aVals = isset($_POST) ? $_POST : array();
        $walletAmount = '';
        $payment_method = $aVals['payment_method'];
        $propertyDetail = Property::select('user_id','host_name')->where('id',$aVals['property_id'])->first();
        $aUser = \Auth::user();

        $aVals['user_id'] = $aUser->id;
        $aVals['payment_status'] = "pending";
        if ($payment_method == "Wallet") {
            $walletAmount = walletHistory::countWallet($aUser->id);
            if($walletAmount->userAmount < $aVals['paid_amount']){
                $return = json_encode(array("status" => "success", "action" => "showError", "errors" => array('0'=>'Wallet balance is low')));
                echo $return;
                die;        
            }
        }

        if ($payment_method == "onarrival") {
            $aVals['payment_status'] = "confirm";
        }
        if (!empty($aVals['transaction_id']) && !empty($aVals['p_payerID'])) {
            $aVals['payment_status'] = "confirm";
        }
        $aVals['status'] = 1;
        $aVals['checkin'] = date('Y-m-d H:i:s', strtotime($aVals['checkin']));
        $aVals['checkout'] = date('Y-m-d H:i:s', strtotime($aVals['checkout']));
        $aBooking = Booking::create($aVals);

        if ($aBooking->payment_method == 'paypal') {
            event(new sendNotification(0,$propertyDetail->host_name,6,$aBooking->id));/* on payOnline */
        }
            event(new sendNotification(0,$propertyDetail->host_name,4,$aBooking->id));/* booking create */

        /* update membership on booking */
        CustomHelper::updateMembershis($aUser->id);

        /* reduce wallet amount */
        if ($payment_method == "Wallet") {
            $walletAmount = walletHistory::useCoinForBooking($aUser->id,$aBooking->paid_amount);
        }

        Session::forget('checkin');
        Session::forget('checkout');
        Session::save();

       
        $msg = "Your booking successfully done";
        $msgView = view('layouts.msg', compact('msg'))->render();
        $return = json_encode(array("status" => "success", "action" => "showpopup", "message" => $msgView));
        echo $return;
        die;
    }

    public function bookingUpdate()
    {
        $addservicesArray = $addservices = array();
        $Data = array();
        $aVals = isset($_POST) ? $_POST : array();
        $userData = \Auth::user();
        $BookingData = Booking::with('property')->where('id', $aVals['bookingId'])->first();
        $addservicesArray = json_decode($BookingData->addservices);

        if (isset($aVals['add_service']) && $aVals['add_service']) {
            foreach ($aVals['add_service'] as $key => $service) {
                if (isset($service['id']) && $service['id'] > 0) {
                    if (isset($service['hrs']) && $service['hrs'] > 0) {
                        $service_amount = $service['price'];
                    }
                    $addservices[$key] = $service;
                }
            }
        $addservicesArray = $addservices;
        }

        if ($BookingData) {
            if((isset($aVals['checkin']) && $aVals['checkin']) && (isset($aVals['checkout']) && $aVals['checkout']))
            {
                $now = Carbon::today();
                
                $checkinObj = Carbon::parse($aVals['checkin']);
                $checkin = $checkinObj->format('d-m-Y');
                
                $checkoutObj = Carbon::parse($aVals['checkout']);
                $checkout = $checkoutObj->format('d-m-Y');
                
                if($checkinObj > $checkoutObj){
                    return redirect()->back()->with('error','Please select valid date range');
                    die;
                }
                $checkBooking = Booking::select('id','property_id','checkin','checkout')
                                        ->where([['status', '1'],['bookingStatus','1']])
                                        ->Where(function($query) use ($checkinObj){
                                            $query->where('checkin','<=',$checkinObj)->where('checkout','>=',$checkinObj);
                                        })
                                        ->orWhere(function($query) use ($checkoutObj){
                                            $query->where('checkin','<=',$checkoutObj)->where('checkout','>=',$checkoutObj);
                                        })                                        
                                        ->where([['checkout','>',$now],['property_id',$BookingData->property_id]])
                                        ->get();

                if(empty($checkBooking)){
                    $return = json_encode(array("status" => "success", "action" => "showError", "errors" => array('0'=>'No Empty Booking on this date')));
                    echo $return;
                    die;        
                }
            }

            $Data['checkin'] = date('Y-m-d H:i:s', strtotime($aVals['checkin']));
            $Data['checkout'] = date('Y-m-d H:i:s', strtotime($aVals['checkout']));
            $Data['services'] = json_encode($addservicesArray);
        }
        $BookingData->update($Data);

        event(new sendNotification(0,$BookingData['property']->host_name,8,$BookingData->id));

        /* mail user */
        $subject = 'AfricanaLand Booking Update';
        $tPath = "emails.bookingupdated";
        $serviceArray = array();

        $toEmail = $userData->email;
        $name = $userData->fname;

        if (!empty($addservicesArray)) {
            foreach ($addservicesArray as $key => $value) {
                $serviceDetail = Service::getData($value['id'], array('name'));

                $serviceArray[$key]['name'] = $serviceDetail->name;
                $serviceArray[$key]['hrs'] = @$value['hrs'];
            }
        }

        $siteSettings = \DB::select('SELECT meta_value from settings where status=?', [1]);
        $socialFacebook = $siteSettings[2]->meta_value;
        $socialTwitter = $siteSettings[3]->meta_value;
        $socialInstagram = $siteSettings[4]->meta_value;
        $siteEmail = $siteSettings[6]->meta_value;
        $sitePhone = $siteSettings[7]->meta_value;

        $body = [
            'title' => $subject,
            'name' => $name,
            'url' => route('userbookings', 'upcoming'),
            'bookingId' => $aVals['bookingId'],
            'propertyName' => $BookingData->property['name'],
            'address' => $BookingData->property['address'],
            'checkin' => date('d/M/y', strtotime($aVals['checkin'])),
            'checkout' => date('d/M/y', strtotime($aVals['checkout'])),
            'service' => $serviceArray,
            'img' => $BookingData->property['image'],
            'siteEmail' => $siteEmail,
            'sitePhone' => $sitePhone,
            'Facebook' => $socialFacebook,
            'Twitter' => $socialTwitter,
            'Instagram' => $socialInstagram,
        ];

        \CustomHelper::sendServiceEmail($toEmail, $subject, $tPath, $body);

        $msg = "Your booking Update done";
        $msgView = view('layouts.msg', compact('msg'))->render();
        $return = json_encode(array("status" => "success", "action" => "showpopup", "message" => $msgView));
        echo $return;
        die;
    }

    public function checkoffer()
    {
        $aVals = isset($_POST) ? $_POST : array();
        $return = json_encode(array("status" => "error", "action" => "message", "message" => "Coupon Invalid"));
        $today = Carbon::today();
        $aChk = Coupon::where('is_used', 0)->where('code', $aVals['coupon_code'])->whereRaw("start_date <= ?", array($today))->whereRaw("end_date >= ?", array($today))->first();

        if ($aChk) {
            $discount = $aChk->discount;
            $offer = number_format($aVals['paid_amount'] * ($discount / 100), 2);
            $paid_amount = $aVals['paid_amount'] - $offer;
            $return = json_encode(array(
                "status" => "success", "action" => "message", "message" => "Coupon Applied",
                "vals" => array("offer" => $offer, "paid_amount" => $paid_amount),
            ));
        }
        echo $return;
        die;
    }

    public function delete($id)
    {
        $aUser = \Auth::user();
        $bookingDetail = Booking::where("id", $id)->first();

        $aProperty = Property::select('host_name')->where("id", $bookingDetail->property_id)->first();

        if ($bookingDetail) {
            $bookingDetail->bookingStatus = 0;
            $bookingDetail->update();
            // Booking::findOrFail($id)->delete();

            /* mail user */
            $subject = 'AfricanaLand Cancel Booking';
            $tPath = "emails.cancelBooking";

            $toEmail = $aUser->email;
            $name = $aUser->fname;

            $siteSettings = \DB::select('SELECT meta_value from settings where status=?', [1]);
            $socialFacebook = $siteSettings[2]->meta_value;
            $socialTwitter = $siteSettings[3]->meta_value;
            $socialInstagram = $siteSettings[4]->meta_value;
            $siteEmail = $siteSettings[6]->meta_value;
            $sitePhone = $siteSettings[7]->meta_value;

            
            $body = [
                'title' => $subject,
                'name' => $name,
                'bookingId' => $bookingDetail->id,
                'siteEmail' => $siteEmail,
                'sitePhone' => $sitePhone,
                'Facebook' => $socialFacebook,
                'Twitter' => $socialTwitter,
                'Instagram' => $socialInstagram,
            ];

            \CustomHelper::sendServiceEmail($toEmail, $subject, $tPath, $body);

            event(new sendNotification(0,$aProperty->host_name,7,$bookingDetail->id));

            return back()->with('message', 'Booking Cancelled Successfully.');
        }
        return back()->with('error', 'Some error occurred');
    }

    public function save()
    {
        /*$aVals = isset($_POST) ? $_POST : array();
    $aVals['user_id'] = \Auth::user()->id;
    $aVals['paid_amount'] = $aVals['booking_amount'];
    $aVals['payment_status'] = "pending";
    $aVals['status'] = 1;
    $aVals['checkin'] = date('Y-m-d H:i:s', strtotime($aVals['checkin']));
    $aVals['checkout'] = date('Y-m-d H:i:s', strtotime($aVals['checkout']));
    $aBooking = Booking::create($aVals);
    $booking_id = $aBooking->id;

    $url = url("bookings/payment/{$booking_id}");
    $return = json_encode(array("status" => "success","action" => "popup","url" => $url));
    echo $return;
    die;*/}

    public function summary($property_id)
    {
        $aRow = Property::where("id", "=", $property_id)->first();
        $aVals = isset($_POST) ? $_POST : array();
        $total_amount = 0;
        list($addservices, $total_amount) = $this->getServiceArray($aVals, $aRow);
        return view('bookings.summary', compact('aRow', 'total_amount', 'aVals'));
    }

    private function getServiceArray($aVals, $aRow)
    {
        $bookingdates = explode("/", $aVals['bookingdates']);
        $checkin = $bookingdates[0];
        $checkout = $bookingdates[1];
        $diff = strtotime($checkout) - strtotime($checkin);
        $days = abs(round($diff / 86400));
        $services = isset($_POST) ? $aVals['add_service'] : array();
        $amountPerDay = $aRow->daily_rate;
        $totalDay = $days + 1;
        $amount = $amountPerDay * $totalDay;

        $addservices = array();
        if ($services) {
            foreach ($services as $key => $service) {
                if (isset($service['id']) && $service['id'] > 0) {
                    if (isset($service['hrs']) && $service['hrs'] > 0) {
                        $service_amount = $days * $service['hrs'] * $service['price'];
                    } else {
                        $service_amount = $service['price'];
                    }
                    $addservices[$key] = $service;
                    $amount = $amount + $service_amount;
                }
            }
        }
        return array($addservices, $amount);
    }


}
