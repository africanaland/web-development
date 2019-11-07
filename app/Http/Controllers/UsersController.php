<?php

namespace App\Http\Controllers;

use App\Becomehost;
use App\Booking;
use App\Card;
use App\City;
use App\Country;
use App\Events\sendNotification;
use App\Offer;
use App\Property;
use App\Role;
use App\Service;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['activation', 'becomehost']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function activation($token = "")
    {
        $this->middleware('guest');
        if ($aUser = User::where('email_token', '=', $token)->first()) {
            $aUser->status = 1;
            $aUser->save();

            /* mail user */
            $subject = 'Thanks For Registration';
            $tPath = "emails.register";

            $toEmail = $aUser->email;
            $name = $aUser->username;

            $siteSettings = \DB::select('SELECT meta_value from settings where status=?', [1]);
            $socialFacebook = $siteSettings[2]->meta_value;
            $socialTwitter = $siteSettings[3]->meta_value;
            $socialInstagram = $siteSettings[4]->meta_value;
            $siteEmail = $siteSettings[6]->meta_value;
            $sitePhone = $siteSettings[7]->meta_value;

            $body = [
                'title' => $subject,
                'name' => $name,
                'url' => route('login'),
                'siteEmail' => $siteEmail,
                'sitePhone' => $sitePhone,
                'Facebook' => $socialFacebook,
                'Twitter' => $socialTwitter,
                'Instagram' => $socialInstagram,
            ];

            \CustomHelper::sendServiceEmail($toEmail, $subject, $tPath, $body);

            event(new sendNotification(0, 1, 2, $aUser->id));

            return redirect('login')->with('message', 'Your account successfully activated. ');

        }
        return redirect('login')->with('message', 'Some error occurred please try again.');
    }

    public function changepassword()
    {
        return view('users.change_password');
    }

    public function passwordupdate(Request $request)
    {
        $this->validate($request, [
            'password_current' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required|same:password',
        ]);

        $aUser = \Auth::user();

        if (!Hash::check($request->password_current, $aUser->password)) {

            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        $aUser->password = Hash::make($request['password']);
        $aUser->save();
        return redirect()->back()->with("message", "Your password change successfully.");
    }

    public function profile()
    {
        $aUserId = \Auth::user()->id;
        $aUser = User::with('role')->with('membership')->where('id', '=', $aUserId)->first();

        $aCountries = Country::where('is_african', '=', 1)->get()->pluck('name', 'id')->toArray();

        $aCities = City::get()->where('country_id', '=', $aUser->country)->pluck('name', 'id')->toArray();
        return view('users.profile', compact('aUser', 'aCountries', 'aCities'));
    }

    public function update(Request $request)
    {
        $authId = \Auth::user();
        $aUser = User::findorfail($authId->id);
        $this->validate(request(), [
            'username' => 'required|string|max:255|unique:users,username,' . $aUser->id,
            'email' => 'required|string|max:255|unique:users,email,' . $aUser->id,
            'fname' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'mobile' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $aVals = $request->all();

        if ($aVals['password'] != "") {
            $this->validate(request(), [
                'password' => 'string|min:8',
            ]);
            $aVals['password'] = Hash::make($aVals['password']);

            /* mail user */
            $subject = 'AfricanaLand Password change successfully';
            $tPath = "emails.passwordChange";

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
                'url' => route('login'),
                'siteEmail' => $siteEmail,
                'sitePhone' => $sitePhone,
                'Facebook' => $socialFacebook,
                'Twitter' => $socialTwitter,
                'Instagram' => $socialInstagram,
            ];

            \CustomHelper::sendServiceEmail($toEmail, $subject, $tPath, $body);
        } else {
            unset($aVals['password']);
        }
        $imageName = "";
        if ($image = request()->image) {
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }
        $aUser->update($aVals);

        return redirect()->route('userprofile')->with('message', 'User updated Successfully.');
    }

    public function cards()
    {
        $aUser = \Auth::user();

        $aMonths = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
        $aYears = array();
        for ($i = 2019; $i < 2030; $i++) {
            $aYears[$i] = $i;
        }

        $aRows = Card::get()->where('user_id', '=', $aUser->id);
        return view('users.card', compact('aUser', 'aRows', 'aMonths', 'aYears'));
    }

    public function cardsave(Request $request)
    {
        $this->validate(request(), [
            'card_no' => 'required|digits:16|numeric|unique:cards',
            'cardholder_name' => 'required|string|max:255',
            'card_cvv' => 'required|numeric|digits:3',
        ]);

        $aVals = $request->all();
        $aUser = \Auth::user();
        $aVals['user_id'] = $aUser->id;
        if (isset($aVals['month']) && isset($aVals['year'])) {
            $aVals['expiration_date'] = $aVals['month'] . "/" . $aVals['year'];
        }
        Card::create($aVals);

        /* mail user */

        $subject = 'Card Add TO AfricanaLand successfully';
        $tPath = "emails.addCreditCard";

        $strlength = strlen($aVals['card_no']);
        $cardNo = substr($aVals['card_no'], $strlength - 4, $strlength);
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
            'cardNo' => $cardNo,
            'siteEmail' => $siteEmail,
            'sitePhone' => $sitePhone,
            'Facebook' => $socialFacebook,
            'Twitter' => $socialTwitter,
            'Instagram' => $socialInstagram,
        ];

        \CustomHelper::sendServiceEmail($toEmail, $subject, $tPath, $body);

        return "success";
        //return redirect('userwallet')->with('message', 'Card added Successfully.');
    }

    public function carddelete($id)
    {
        $aUser = \Auth::user();
        $cardDetail = Card::where("user_id", $aUser->id)->where("id", $id)->first();
        if (!empty($cardDetail)) {
            Card::findOrFail($id)->delete();

            /* mail user */
            $subject = 'Card remove from AfricanaLand successfully';
            $tPath = "emails.creditCard";

            $strlength = strlen($cardDetail->card_no);
            $cardNo = substr($cardDetail->card_no, $strlength - 4, $strlength);
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
                'cardNo' => $cardNo,
                'siteEmail' => $siteEmail,
                'sitePhone' => $sitePhone,
                'Facebook' => $socialFacebook,
                'Twitter' => $socialTwitter,
                'Instagram' => $socialInstagram,
            ];

            \CustomHelper::sendServiceEmail($toEmail, $subject, $tPath, $body);

            return back()->with('message', 'Card deleted Successfully.');
        }

        return back()->with('error', 'Some error occured');
    }

    public function becomehost(Request $request)
    {
        $aUser = \Auth::user();
        if ($aUser) {
            return redirect('home');
        }

        
        if ($request->isMethod('post')) {

            $aVals = $request->all();

            $this->validate(request(), [
                'email' => 'email|required|string|max:255|unique:host_requests',
                'fname' => 'required',
                'lname' => 'required',
                'mobile' => 'required',
                'role_id' => 'required',

            ]);
            if (isset($aVals['services']) && $aVals['services']) {
                $aVals['services'] = implode(",", $aVals['services']);
            }
            if (!is_numeric($aVals['country'])) {
                $aVals['country2'] = $aVals['country'];
                $aVals['country'] = 0;
            }
            if (!is_numeric($aVals['city'])) {
                $aVals['city2'] = $aVals['city'];
                $aVals['city'] = 0;
            }
            Becomehost::create($aVals);
            return back()->with('message', 'Your request submit successfully.');
        }

        $aRoles = array(User::ROLE_HOST_COMPANY => "Host(Hospitality Company)", user::ROLE_HOST_INDIVIDUAL => "Host(individual) ");
        $aHosttypes = Role::whereIn('id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL])
            ->get()->pluck('name', 'id')->toArray();

            
        // $aProptypes = Property::getPropertyTypes(User::ROLE_HOST_COMPANY);    
        $aProptypes = array();

        $aCountries = Country::get()->pluck('name', 'id')->toArray();
        $aServices = Service::get()->pluck('name', 'id')->toArray();
        return view('users.becomehost', compact('aCountries', 'aRoles', 'aServices', 'aHosttypes', 'aProptypes'));
    }

    public function offers()
    {
        $aUser = \Auth::user();
        $now = date('Y-m-d');
        // $aRows = Offer::where('membership_id', '=', $aUser->membership_id)->where('is_used', '=', 0)->where('start_date', '<=', $now)->where('end_date', '>=', $now)->get();
        $aRows = Offer::join('memberships', 'memberships.id', '=', 'offers.membership_id')->select('*', 'offers.description as description')->get();
        return view('users.offers', compact('aRows'));
    }

    public function bookings($type, Request $request)
    {
        $aUser = \Auth::user();
        $status = true;
        $aQry = Booking::select(['*'])->where('bookings.user_id', $aUser->id)
            ->where('bookings.bookingStatus', 1)->with('property.user')->with('user');
        $today = Carbon::today();
        $requestValue = '';
        if ($type == "previous") {
            $status = false;
            $aQry->whereRaw("checkout < ?", array($today));
        }
        if ($type == "upcoming") {
            $aQry->whereRaw("checkin >= ?", array($today));
        }
        if ($request->isMethod('post')) {
            if (!empty($request->keyword)) {
                $aQry->leftJoin('properties', 'properties.id', '=', 'bookings.property_id');
                $aQry->where('properties.name', 'like', '%' . $request->keyword . '%');
            }
            $requestValue = $request->keyword;
        }
        $aRows = $aQry->paginate(9);

        $aTitle = ucfirst($type);
        return view('users.bookings', compact('aRows', 'aTitle', 'type', 'requestValue', 'status'));
    }

    public function wallet()
    {
        $aRows = array();
        $aUser = \Auth::user();
        $aCards = Card::get()->where('user_id', '=', $aUser->id);
        return view('users.wallet', compact('aRows', 'aCards'));
    }


    public function cardadd()
    {
        return view('users.cardadd');
    }
}
