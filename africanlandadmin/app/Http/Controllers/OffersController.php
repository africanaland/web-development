<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Offer;
use App\Membership;

class OffersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index(Request $request)
    {     
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }

        $aQvars = $request->query();
        $aQry = Offer::select(['*']);
        
        if(isset($aQvars['membership']) && $aQvars['membership'] > 0)
        {
            $aQry->where("membership_id", "=",$aQvars['membership']);
        }        
        $aMemberships = Membership::get()->pluck('name', 'id')->toArray();
        $aRows = $aQry->with('membership')->get();             
        return view('admin.offers.index',compact('aRows','aQvars','aMemberships'));
    }

    public function create()
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin != "adminLogin")
            return redirect('offers');
 
        $aRow = array();
        $aMemberships = Membership::get()->pluck('name', 'id')->toArray();
        return view('admin.offers.add',compact('aRow','aMemberships'));
    }

    public function store(Request $request)
    {
    	
        $this->validate($request, [
             'name' => 'required|string|max:255|unique:offers', 
             'start_date' => 'required',
             'end_date'   => 'required|after:start_date',
             'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
     
        ]);
        $aData = $request->all();
        if ($image = $request->image) {
            $imageName = \CustomHelper::uploadImage($image);
            $aData['image'] = $imageName;
        }
      
        Offer::create($aData);
        return redirect('offers')->with('message', 'New offer Added Successfully.');
    }

    
    public function show($id)
    {
         $aRow = Offer::with('membership')->findOrFail($id);
         return view('admin.offers.show',compact('aRow'));
    }

    public function edit($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin != "adminLogin")
            return redirect('offers');

        $aRow = Offer::findOrFail($id);
        $aMemberships = Membership::get()->pluck('name', 'id')->toArray(); 
        return view('admin.offers.add',compact('aRow','aMemberships'));
    }

   
    public function update(Request $request, $id)
    {
    	$aVals = $request->all();
        $this->validate($request, [
             'name' => 'required|string|max:255|unique:offers,name,'.$id, 
             'start_date' => 'required',
             'end_date'   => 'required|after:start_date',
             'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',      
        ]);
        if ($image = $request->image) {
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }


        $aRow = Offer::find($id);
        $aRow->update($aVals);     
        return redirect('offers')->with('message', 'offer updated Successfully.');
    }

    
    public function destroy($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin != "adminLogin") 
            return redirect('offers');

        $aRow = Offer::findOrFail($id);
        $aRow->delete();     
        return redirect('offers')->with('message', 'offer deleted Successfully.');
    }
    
    
}
