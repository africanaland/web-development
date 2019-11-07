<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Becomehost;
use App\Country;
use App\City;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function hosts(Request $request)
    {

        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin == "staffLogin")
            $staffLogin = true;
        if ($CurrentLogin == "hostLogin")
            return redirect('home');




        $aQvars = $request->query();
        $aCountriesObj = Country::where('status',1);
        if($staffLogin)
            $aCountriesObj->where('id',$aUser->country);
        $aCountries = $aCountriesObj->pluck('name', 'id')->toArray(); 
        $aCities = array();

        $aQry = Becomehost::select(['*']);
        if(isset($aQvars['country']) && $aQvars['country'])
        {
            $aQry->where("country", "=",$aQvars['country']);
            $aCities = City::get()->where('country_id','=',$aQvars['country'])->pluck('name', 'id')->toArray();
        }
        if($staffLogin)
            $aQry->where('country',$aUser->country);

        $aRows = $aQry->with('role')->with('city_name')->with('country_name')->get();
       	return view('admin.request.hosts',compact('aRows','aCountries','aCities','aQvars'));
    }

    public function hostshow($id)
    {
        $aRow = Becomehost::findOrFail($id);
        return view('admin.request.hostshow',compact('aRow'));
    }

    public function hostreply($id,Request $request)
    {
    	$aRow = Becomehost::findOrFail($id);
    	if ($request->isMethod('put'))
        {
            $aVals = $request->all();
            $imageName = "";
	        if($image = request()->image)
	        {       
	            $imageName = \CustomHelper::uploadImage($image,false);
	            $aVals['reply_attachment'] = $imageName;
	        }

	        $attachPath = $imageName ? public_path('/uploads/'.$imageName) : "";
		    $bodyText = "Hi {$aRow->fname}, <br>";
	        $bodyText .= $aVals['reply'];
	        \CustomHelper::sendEmail($aRow->email,"Reply for request",$bodyText,$attachPath);


            $aVals['status'] = 1;
        	$aRow->update($aVals); 
        	return redirect('request/hosts')->with('message', 'reply sent Successfully.');
        }

    	return view('admin.request.replyhost',compact('aRow'));
    }

    
    
    
}
