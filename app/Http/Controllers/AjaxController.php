<?php

namespace App\Http\Controllers;

use App\City;
use App\Property;
use App\Review;
use App\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function __construct()
    {

    }

    public function getcity()
    {
        $country = $_POST['country'];
        $aCities = City::where('country_id', '=', $country)->pluck('name', 'id')->toArray();
        return view('ajax.getcity', compact('aCities'));
    }

    public function getcityForHost()
    {
        $country = $_POST['country'];
        $aCities = City::where('country_id', '=', $country)->select('name', 'id')->get();
        return $aCities;
    }

    public function getpropertytype()
    {
        $host = $_POST['host'];
        $aProptypes = Property::getPropertyTypes($host);
        return view('ajax.getpropertytype', compact('aProptypes'));
    }

    public function getUserDetail($id)
    {
        $aRow = User::where('id', $id)->first();
        return view('ajax.userDetail', compact('aRow'));
    }

    public function getBookingDetail($id)
    {
        $aRow = Property::select('bookings.*', 'properties.services as proServices')->join('bookings', 'properties.id', '=', 'bookings.property_id')->where('bookings.id', $id)->first();
        return view('ajax.bookingDetail', compact('aRow'));
    }

    public function addReview($id, Request $request)
    {

        $userDetail = \Auth::user();
        $aRow = Property::select('bookings.id as bookingId', 'properties.id as propertiesId', 'properties.name', 'properties.image')
            ->join('bookings', 'properties.id', '=', 'bookings.property_id')->where('bookings.id', $id)->first();

        if ($request->isMethod('post')) {
            $data = $request->all();

            $return = json_encode(array("status" => "error", "action" => "message", "message" => "Invalid Data"));

            $data['property_id'] = $aRow->propertiesId;
            $data['booking_id'] = $aRow->bookingId;
            $data['user_id'] = $userDetail->id;
            $data['review'] = $request->Review;
            $data['rating'] = $request->rating;

            $reviewData = Review::create($data);

            if ($reviewData) {
                $msg = "Thank you for support";
                $msgView = view('layouts.msg', compact('msg'))->render();
                $return = json_encode(array("status" => "success", "action" => "showpopup", "message" => $msgView));
                echo $return;
            }
            die();
        }

        return view('ajax.addReview', compact('aRow', 'userDetail'));

    }

    public function getReviews($id)
    {
        $property = Property::select('image','name')->findOrFail($id);

        $aRows = Review::select('reviews.*','users.fname','users.image')
                ->join('users','users.id','=','reviews.user_id')
                ->where('reviews.property_id', $id)->orderBy('reviews.id','DESC')->get();

                return view('ajax.getReviews', compact('aRows','property'));
    }

}
