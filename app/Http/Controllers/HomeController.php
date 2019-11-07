<?php

namespace App\Http\Controllers;

use App\Country;
use App\Guestcare;
use App\Page;
use App\Role;
use App\Setting;
use App\User;
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
        //$this->middleware('auth');
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

    public function welcome()
    {

        $aCountries = Country::get()->pluck('name', 'id')->toArray();
        $aHosts     = Role::where('privileges', User::PREV_HOST)->orderBy('id', 'desc')
            ->get()->pluck('name', 'id')->toArray();

        return view('welcome', compact('aCountries', 'aHosts'));
    }

    public function privacy()
    {
        $aPrivacy = Page::where('page_name', '=', 'policy')->first();
        $aTerms   = Page::where('page_name', '=', 'terms')->first();
        return view('pages/privacy', compact('aPrivacy', 'aTerms'));
    }

    public function guestcare(Request $request)
    {
        // $adminEmail = Setting::getSetting('site_email');
        $aUser = \Auth::user();
        if ($request->isMethod('post')) {
            $aVals            = $request->all();
            $aVals['status']  = "Waiting";
            $aVals['user_id'] = $aUser->id;
            Guestcare::create($aVals);
            $adminEmail = Setting::getSetting('site_email');

            $tPath = "emails.gusetCare";

            $subject  = "you receive a complaint";
            $bodyText = "<p>{$aVals['name']} sent you a complaint</p>";
            $bodyText .= "<p>Name : {$aVals['name']}</p>";
            $bodyText .= "<p>Email : {$aVals['email']}</p>";
            $bodyText .= "<p>Mobile : {$aVals['mobile']}</p>";
            $bodyText .= "<p>Subject : {$aVals['subject']}</p>";
            $bodyText .= "<p>Message : {$aVals['message']}</p>";

            $siteSettings    = \DB::select('SELECT meta_value from settings where status=?', [1]);
            $socialFacebook  = $siteSettings[2]->meta_value;
            $socialTwitter   = $siteSettings[3]->meta_value;
            $socialInstagram = $siteSettings[4]->meta_value;
            $siteEmail       = $siteSettings[6]->meta_value;
            $sitePhone       = $siteSettings[7]->meta_value;

            $body = [
                'title'     => $subject,
                'body'      => $bodyText,
                'siteEmail' => $siteEmail,
                'sitePhone' => $sitePhone,
                'Facebook'  => $socialFacebook,
                'Twitter'   => $socialTwitter,
                'Instagram' => $socialInstagram,
            ];

            \CustomHelper::sendServiceEmail($adminEmail, $subject, $tPath, $body);
            redirect()->back()->with("message", "Your complaint successfully sent to admin.");

        }

        $this->middleware('auth');
        $aUserId = $aUser->id;
        $aUser   = User::with('role')->with('membership')->where('id', '=', $aUserId)->first();
        return view('pages/guestcare', compact('aUser'));
    }

    public function guestcareView($id)
    {
        $this->middleware('auth');
        $aUser = \Auth::user();
        $aRow = Guestcare::where('id',$id)->first();
        return view('pages/guestcareView', compact('aUser','aRow'));
    }

}
