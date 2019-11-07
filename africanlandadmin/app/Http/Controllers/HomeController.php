<?php

namespace App\Http\Controllers;

use App\Becomehost;
use App\Booking;
use App\City;
use App\Country;
use App\Events\sendNotification;
use App\Guestcare;
use App\Http\Controllers\Controller;
use App\Membership;
use App\Policy;
use App\Property;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['admin.auth']);
    }

    public function index(Request $request)
    {
        $totalBooking     = $totalBookingHost     = $pendingBooking     = $cancelBooking     = $userCancelBooking     = $mostBookingProperty     = $chartTotalBooking     = $chartTotalCancelBooking     = $aMemberData     =
        $totalHostRequest = $totalCountry = $totalCity = $totalProperty = $totalReports = $totalStaff = $totalAdmin =
        $totalAmbasaddar  = $totalHost  = $totalGuest  = "";

        $now          = Carbon::now();
        $aUser        = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin    = $staffLogin    = $adminLogin    = false;

        if ($CurrentLogin == "staffLogin") {
            $staffLogin            = true;
            $AllRigisteredHost     = User::where('creator_id', $aUser->id)->pluck('id')->toArray();
            $AllRigisteredGuest    = User::where('country', $aUser->country)->pluck('id')->toArray();
            $AllRigisteredProperty = Property::whereIn('user_id', $AllRigisteredHost)->pluck('id')->toArray();
        }
        if ($CurrentLogin == "hostLogin") {
            $hostLogin             = true;
            $AllRigisteredProperty = Property::where('user_id', $aUser->id)->pluck('id')->toArray();
        }

        /************************************** booking detail **************************************/

        $totalBooking    = Booking::where('bookingStatus', 1)->where('status', 2)->count();
        $totalBookingObj = Booking::where('bookingStatus', 1)->where('status', 2);
        if ($staffLogin || $hostLogin) { // for host and ambassador
            $totalBookingObj->whereIn('property_id', $AllRigisteredProperty);
        }
        $totalBookingHost = $totalBookingObj->count();

        $pendingBookingObj = Booking::where('bookingStatus', 1)->where('status', 1);
        if ($staffLogin || $hostLogin) { // for host and ambassador
            $pendingBookingObj->whereIn('property_id', $AllRigisteredProperty);
        }
        $pendingBooking = $pendingBookingObj->count();

        /* when Host cancel booking */
        $cancelBookingObj = Booking::where('bookingStatus', 1)->where('status', 0);
        if ($staffLogin || $hostLogin) { // for host and ambassador
            $cancelBookingObj->whereIn('property_id', $AllRigisteredProperty);
        }
        $cancelBooking = $cancelBookingObj->count();

        /* when user cancel booking */
        $userCancelBookingObj = Booking::where('bookingStatus', 0);
        if ($staffLogin || $hostLogin) { // for host and ambassador
            $userCancelBookingObj->whereIn('property_id', $AllRigisteredProperty);
        }
        $userCancelBooking = $userCancelBookingObj->count();

        /* top 5 booked booking */
        $mostBookingPropertyObj = Booking::where(['bookingStatus' => 1, 'status' => 2])
            ->select(\DB::raw('count(id) as `total`'), 'property_id')
            ->where('checkout', '<', $now);
        if ($staffLogin || $hostLogin) { // for host and ambassador
            $mostBookingPropertyObj->whereIn('property_id', $AllRigisteredProperty);
        }
        $mostBookingProperty = $mostBookingPropertyObj->with('property')->groupBy('property_id')->orderBy('total','DESC')->limit(5)->get();
        /************************************** booking chart start **************************************/

        if ($request->type == 'year') {
            $year = $request->id;
        } else {
            $year = Carbon::now()->format('Y');
        }

        $data1 = Booking::where('bookingStatus', 1)->where('status', 2)
            ->select(\DB::raw('count(id) as `total`'), \DB::raw('MONTH(created_at) month'));
        if ($year) {
            $data1->whereYear('created_at', $year);
        }

        if ($staffLogin || $hostLogin) { // for host and ambassador
            $data1->whereIn('property_id', $AllRigisteredProperty);
        }

        $ChartBookingConfirm = $data1->groupBy('month')->get();

        $data2 = Booking::where('bookingStatus', 0)->where('status', 2)
            ->select(\DB::raw('count(id) as `total`'), \DB::raw('MONTH(created_at) month'));
        if ($year) {
            $data2->whereYear('created_at', $year);
        }

        if ($staffLogin || $hostLogin) { // for host and ambassador
            $data2->whereIn('property_id', $AllRigisteredProperty);
        }

        $ChartBookingCancel = $data2->groupBy('month')->get();

        $bookdata   = array();
        $monthArray = array('', "January", "February", "March", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");
        /* in year confirm bookind  */
        for ($i = 1; $i <= 12; $i++) {
            $bookdata[$i] = [$monthArray[$i], 0];
            foreach ($ChartBookingConfirm as $key1 => $value1) {
                if (isset($value1['month']) && $value1['month'] == $i) {
                    $bookdata[$i] = [$monthArray[$i], $value1['total']];
                }
            }
        }
        $chartTotalBooking = $bookdata;

        $bookdata = array();
        /* in year cancel bookind  */
        for ($i = 1; $i <= 12; $i++) {
            $bookdata[$i] = [$monthArray[$i], 0];
            foreach ($ChartBookingCancel as $key2 => $value2) {
                if (isset($value1['month']) && $value2['month'] == $i) {
                    $bookdata[$i] = [$monthArray[$i], $value2['total']];
                }
            }
        }
        $chartTotalCancelBooking = $bookdata;

        /************************************** end booking chart start **************************************/

        /************************************** User memberShip detail **************************************/
        $aMemberData     = array();
        $getMemberShipId = Membership::pluck('name', 'id')->toArray();

        foreach ($getMemberShipId as $key => $value) {
            $data = User::where('membership_id', $key);
            if ($staffLogin) {
                $data->where('country', $aUser->country);
            }
            $counterData         = $data->count();
            $aMemberData[$value] = $counterData;
        }

        /************************************** Host Request **************************************/
        $totalHostRequestObj = Becomehost::where('status', 1);
        if ($staffLogin) {
            $totalHostRequestObj->where('country', $aUser->country);
        }
        $totalHostRequest = $totalHostRequestObj->count();

        /************************************** Country detail **************************************/
        $totalCountry = Country::where('status', 1)->count();
        $totalCityObj = City::where('status', 1);
        if ($staffLogin) {
            $totalCityObj->where('country_id', $aUser->country);
        }
        $totalCity = $totalCityObj->count();

        /************************************** property detail **************************************/
        $totalPropertyObj = Property::where('status', 1);
        if ($staffLogin) {
            $totalPropertyObj->whereIn('user_id', $AllRigisteredHost);
        }

        if ($hostLogin) {
            $totalPropertyObj->where('user_id', $aUser->id);
        }

        $totalProperty = $totalPropertyObj->count();

        if (!$hostLogin) { /* no need while host login */
            /************************************** Guestcare report **************************************/
            $totalReportsObj = Guestcare::where('status', 'Waiting');
            if ($staffLogin) {
                $totalReportsObj->whereIn('user_id', $AllRigisteredGuest);
            }
            $totalReports = $totalReportsObj->count();

            /************************************** User detail **************************************/
            $totalStaff      = User::whereIn('role_id', [User::ROLE_SUBADMIN, User::ROLE_AGENT])->count();
            $totalAdmin      = User::where('role_id', User::ROLE_SUBADMIN)->count();
            $totalAmbasaddar = User::where('role_id', User::ROLE_AGENT)->count();
            $totalHostObj    = User::select(\DB::raw('role_id,count(id) as counter'))
                ->whereIn('role_id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL])
                ->groupBy('role_id');
            if ($staffLogin) {
                $totalHostObj->where('creator_id', $aUser->id);
            }
            $totalHost = $totalHostObj->orderBy('role_id', 'ASC')->get();
        }

        $totalGuestObj = User::where('role_id', User::ROLE_GUEST);
        if ($staffLogin) {
            $totalGuestObj->where('country', $aUser->country);
        }
        $totalGuest = $totalGuestObj->count();

        return view('admin.home', compact('totalBooking', 'totalBookingHost', 'pendingBooking', 'cancelBooking',
            'userCancelBooking', 'mostBookingProperty', 'chartTotalBooking', 'chartTotalCancelBooking',
            'aMemberData', 'totalHostRequest', 'totalCountry', 'totalCity', 'totalProperty', 'totalReports',
            'totalStaff', 'totalAdmin', 'totalAmbasaddar', 'totalHost', 'totalGuest'));
    }

    public function setting(Request $request)
    {
        if ($request->method() == 'POST') {
            $aVals = $request->all();
            if ($aVals) {
                if ($site_logo = request()->site_logo) {
                    $aVals['val']['site_logo'] = \CustomHelper::uploadImage($site_logo);
                }

                foreach ($aVals['val'] as $aKey => $aVal) {
                    $aSetting = Setting::where('meta_key', $aKey)->first();
                    if ($aSetting) {
                        $aSetting->update(array('meta_value' => $aVal));
                    } else {
                        $aOpt['meta_key']   = $aKey;
                        $aOpt['meta_value'] = isset($aVal) ? $aVal : "";
                        Setting::create($aOpt);
                    }
                }
            }
            redirect('sitesetting')->with('message', 'Setting updated Successfully.');
        }
        $aSettings = Setting::get()->pluck('meta_value', 'meta_key')->toArray();
        return view('admin.setting', compact('aSettings'));
    }

    public function guestcare(Request $request)
    {
        $aUser        = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin    = $staffLogin    = $adminLogin    = false;
        if ($CurrentLogin == 'hostLogin') {
            return redirect('home');
        }

        $aQvars = $request->query();
        $aQry   = Guestcare::select(['*']);
        if (isset($aQvars['city']) && $aQvars['city']) {
            $aQry->where("department", "=", $aQvars['department']);
        }
        if ($CurrentLogin == "staffLogin") {
            $AllRigisteredGuest = User::where('country', $aUser->country)->pluck('id')->toArray();
            $aQry->whereIn("user_id", $AllRigisteredGuest);
        }
        $aRows        = $aQry->orderBy('id','DESC')->get();
        $aDepartments = array('Complaints' => 'Complaints');
        return view('admin.guestcare.index', compact('aRows', 'aQvars', 'aDepartments'));
    }

    public function guestcaredetail($id, Request $request)
    {
        $aRow = Guestcare::findOrFail($id);
        if ($request->method() == 'POST') {
            $aVals          = $request->all();
            $aVals['reply'] = trim($aVals['reply']);
            $aVals['reply_by'] = \Auth::guard('admin')->user()->id;
            $aRow->update($aVals);
            if($aVals['status'] == 'Solved')
                event(new sendNotification(0, $aRow->user_id, 15, $aRow->id)); /* send guest care report solve notification */

            redirect()->back()->with('message', 'Reply sent Successfully.');
        }

        return view('admin.guestcare.view', compact('aRow'));
    }

    public function agreement(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        if ($request->isMethod('post')) {
            if ($request->btn == 1) {
                $uDetail            = User::where('id', $aUser->id)->first();
                $uDetail->agreement = 1;
                $uDetail->update();

                /* notification for admin */
                event(new sendNotification(0, 1, 9, $aUser->id));
                return redirect('agreement')->with('message', 'your account activate soon');
            }
            if ($request->btn == 0) {
                event(new sendNotification(0, 1, 10, $aUser->id));
                return redirect('agreement')->with('message', 'thank you for your feedback');
            }
        }

        $aRow = Policy::where(['status' => 1, 'role_id' => $aUser->role_id])->first();
        return view('admin.users.agreement', compact('aRow', 'aUser'));
    }

}
