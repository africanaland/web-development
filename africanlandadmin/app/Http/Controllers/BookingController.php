<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Booking;
use App\Property;
use App\User;
use App\Country;
use App\City;
use App\Service;
use App\Events\sendNotification;


use function GuzzleHttp\json_decode;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }


    public function index(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;

        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
            $AllRigisteredHost = User::where('creator_id', $aUser->id)->pluck('id')->toArray();
            $AllRigisteredProperty = Property::whereIn('user_id', $AllRigisteredHost)->pluck('id')->toArray();
        }
        if ($CurrentLogin == "hostLogin") {
            $hostLogin = true;
            $AllRigisteredProperty = Property::where('user_id', $aUser->id)->pluck('id')->toArray();
        }


        $aCountriesObj = Country::select();
        if($staffLogin)
            $aCountriesObj->where('id',$aUser->country);
        $aCountries = $aCountriesObj->pluck('name', 'id')->toArray();
        $aCities =  array();
        $aHostLists = User::select(DB::raw("CONCAT(fname,' ',lname) AS name"), 'id')->whereIn('role_id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL])->get()->pluck('name', 'id')->toArray();

        $aQvars = $request->query();
        $aQry = Booking::select(['bookings.*'])->with('property.user')->with('user');
        $aQry = $aQry->join('users', 'users.id', '=', 'bookings.user_id');
        $aQry = $aQry->join('properties', 'properties.id', '=', 'bookings.property_id');

        if (isset($aQvars['country']) && $aQvars['country']) {
            $aQry->where("users.country", "=", $aQvars['country']);
            $aCities = City::get()->where('country_id', '=', $aQvars['country'])->pluck('name', 'id')->toArray();
        }
        if (isset($aQvars['city']) && $aQvars['city']) {
            $aQry->where("users.city", "=", $aQvars['city']);
        }
        if (isset($aQvars['host_id']) && $aQvars['host_id']) {
            $aQry->where("properties.host_name", "=", $aQvars['host_id']);
        }
        if($staffLogin)
            $aQry->whereIn("bookings.property_id",$AllRigisteredProperty);
        if($hostLogin)
            $aQry->whereIn("bookings.property_id",$AllRigisteredProperty);

        $aRows = $aQry->get();


        return view('admin.booking.index', compact('aRows', 'aQvars', 'aCountries', 'aCities', 'aHostLists'));
    }

    public function view($id)
    {
        $aRow = Booking::with('property.user')->with('user')->findOrFail($id);
        return view('admin.booking.view', compact('aRow'));
    }


    public function bookingStatus($id, $value)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        $aRow = Booking::with('property')->with('user')->findOrFail($id);


        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
            $AllRigisteredHost = User::where('creator_id', $aUser->id)->pluck('id')->toArray();
            $AllRigisteredProperty = Property::whereIn('user_id', $AllRigisteredHost)->pluck('id')->toArray();
            if(!in_array($aRow['property']->id,$AllRigisteredProperty))
                return redirect()->back()->with('error','Unauthorized Access');
        }
        if ($CurrentLogin == "hostLogin") {
            $hostLogin = true;
            $AllRigisteredProperty = Property::where('user_id', $aUser->id)->pluck('id')->toArray();
            if(!in_array($aRow['property']->id,$AllRigisteredProperty))
                return redirect()->back()->with('error','Unauthorized Access');
        }





        $aRow->status = $value;
        $aRow->update();

        event(new sendNotification(0,$aRow['user']->id,5,$aRow->id));

        if ($value == 2) {

            /* mail user */
            $subject = 'AfricanaLand Booking Confirm';
            $tPath = "emails.allbookingStep";
            $serviceArray = array();

            $toEmail = $aRow->user['email'];
            $name = $aRow->user['fname'];

            if (!empty($aRow->services)) {
                $service = json_decode($aRow->services);
                foreach ($service as $key => $value) {
                    $serviceDetail = Service::getData($value->id, array('name'));
                    if(isset($serviceDetail->name) && $serviceDetail->name)
                        $serviceArray[$key]['name'] = $serviceDetail->name;
                    if(isset($value->hrs) && $value->hrs && isset($serviceDetail->name))
                        $serviceArray[$key]['hrs'] = @$value->hrs;
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
                    'bookingId' => $aRow->id,
                    'propertyName' => $aRow->property['name'],
                    'address' => $aRow->property['address'],
                    'url' =>    env('APP_MAIN_URL')."/users/upcoming/bookings",
                    'checkin' => date('d/M/y',strtotime($aRow->checkin)),
                    'checkout' => date('d/M/y',strtotime($aRow->checkout)),
                    'service'   => $serviceArray,
                    'price' => $aRow->booking_amount,
                    'img' => $aRow->property['image'],
                    'siteEmail' => $siteEmail,
                    'sitePhone' => $sitePhone,
                    'Facebook' => $socialFacebook,
                    'Twitter' => $socialTwitter,
                    'Instagram' => $socialInstagram,
                ];

                \CustomHelper::sendServiceEmail($toEmail, $subject, $tPath, $body);
            }
        return back()->with('message', 'Booking updates Successfully');
    }
}
