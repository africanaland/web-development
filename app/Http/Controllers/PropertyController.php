<?php

namespace App\Http\Controllers;

use App\Property;
use App\Becomehost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Policy;
use App\Booking;
use App\favorite;
use App\Events\sendNotification;
use Carbon\Carbon;
use Session;


class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['search', 'view','gallery']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $aUserId = \Auth::user()->id;
        $aRows = Property::where('status', '=', '1')->get();
        $aUserHouses = DB::table('favorite_properties')->where('user_id', $aUserId)->get()->pluck('property_id')->toArray();;
        return view('property.index', compact('aRows', 'aUserHouses'));
    }


    public function search(Request $request)
    {
        $keyword = '';
        $propertyList = array();
        $checkin = '';
        $checkout = '';
        $counter = Property::select(['*'])->with('user')->where('status', '=', '1')->count();
        $aQry = Property::select(['*'])->with('user')->where('status', '=', '1');
        // if ($request->isMethod('post')) {
            $aVals = $request->all();
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
                Session::put('checkin',date('m/d/Y',strtotime($checkin)));
                Session::put('checkout',date('m/d/Y',strtotime($checkout)));

                $checkBooking = Booking::select('id','property_id','checkin','checkout')
                                        ->where([['status', '1'],['bookingStatus','1']])
                                        ->Where(function($query) use ($checkinObj){
                                            $query->where('checkin','<=',$checkinObj)->where('checkout','>=',$checkinObj);
                                        })
                                        ->orWhere(function($query) use ($checkoutObj){
                                            $query->where('checkin','<=',$checkoutObj)->where('checkout','>=',$checkoutObj);
                                        })                                        
                                        ->where('checkout','>',$now)
                                        ->get();

            foreach ($checkBooking as $key => $value) {
                $propertyList[] = $value->property_id;
            }
            $aQry->whereNotIn("id",$propertyList);
            }
            if(isset($aVals['keyword']) && $aVals['keyword'])
            {
                $aQry->where("name", "like", "%".$aVals['keyword']."%");
                $keyword = $aVals['keyword'];
            }
            if(isset($aVals['host']) && $aVals['host'])
            {
                $aQry->where("host_type", "=",$aVals['host']);
            }
            if(isset($aVals['country']) && $aVals['country'])
            {
                $aQry->where("country", "=",$aVals['country']);
            }
            if(isset($aVals['city']) && $aVals['city'])
            {
                $aQry->where("city", "=",$aVals['city']);
            }
        // }
        $aRows = $aQry->paginate(6);
        $counter = $aQry->count();

        $favorite = 0;
        if (!empty(\Auth::user()->id)) {
            $favorite = favorite::where('user_id', \Auth::user()->id)->get();
        }

        return view('property.search', compact('aRows', 'favorite', 'counter','keyword','checkin','checkout'));
    }

    public function view($id)
    {
        $aBookedDates = array();
        $aBookings = Booking::select(['*'])->with('user')->where('property_id', $id)->get();
        if ($aBookings) {
            foreach ($aBookings as $key => $aBooking) {
                $start_date = date("Y-m-d", strtotime($aBooking->checkin));
                $end_date = date("Y-m-d", strtotime($aBooking->checkout));
                $aDates = $this->getDatesFromRange($start_date, $end_date);
                $aBookedDates = array_merge($aBookedDates, $aDates);
            }
        }
        $aRow = Property::where("id", "=", $id)->first();

        $aPolicies = array();
        return view('property.view', compact('aRow', 'aBookedDates'));
    }

    public function favorite(Request $request)
    {

        $aUserId = \Auth::user()->id;
        $ids =   DB::table('favorite_properties')->where('user_id', '=', $aUserId)->get()->pluck('property_id')->toArray();
        $aRow = Property::with('user')->where('status', '=', '1')->whereIn("id", $ids);
        if ($request->isMethod('post')) {
            if (!empty($request->keyword)) {
                $aRow->where('properties.name', 'like', '%' . $request->keyword . '%');
            }
        }
        $aRows = $aRow->paginate(9);

        $favorite = 0;
        if (!empty($aUserId)) {
            $favorite = favorite::where('user_id', $aUserId)->get();
        }
        return view('property.favorite', compact('aRows', 'favorite'));
    }

    public function makefavorite()
    {
        $property_id = $_POST['property_id'];
        $aUserId = \Auth::user()->id;
        $action = $_POST['action'];
        if ($action == 1) {
            favorite::insert(
                array('property_id' => $property_id, 'user_id' => $aUserId)
            );
            echo "House added to your favorite";
        } else {
            favorite::where(array('property_id' => $property_id, 'user_id' => $aUserId))->delete();
            echo "House remove from your favorite";
        }
        die();
    }

    function getDatesFromRange($sStartDate, $sEndDate)
    {
        $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
        $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));
        $aDays[] = date("m/d/Y", strtotime($sStartDate));
        $sCurrentDate = $sStartDate;
        while ($sCurrentDate < $sEndDate) {
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
            $aDays[] = date("m/d/Y", strtotime($sCurrentDate));
        }
        return $aDays;
    }

    public function gallery($id){
        $aRow = property::select('gallery_images')->where('id',$id)->first();
        return view('ajax.propertyGallery',compact('aRow'));
    }
}
