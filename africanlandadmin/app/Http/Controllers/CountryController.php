<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Country;
use App\City;
use Auth;

class CountryController extends Controller
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
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }

        $aQvars = $request->query();

        $aCountries = Country::get()->pluck('name', 'id')->toArray();

        

        if(isset($aQvars['country']) && $aQvars['country'] > 0)
        {
            $aQry = City::select(['*']);
            $aQry->where("country_id", "=",$aQvars['country']);
            $aRows = $aQry->get();      
            return view('admin.city.index',compact('aRows','aQvars','aCountries'));
        }
        else
        {
            $aQry = Country::select(['*']);
            $aRows = $aQry->get(); 
            return view('admin.country.index',compact('aRows','aQvars','aCountries'));
        }    
          
    }

    public function create()
    {
        $aRow = array();
        return view('admin.country.add',compact('aRow'));
    }
    public function store(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }


        $this->validate($request, [
             'name' => 'required|string|max:255|unique:countries',        
        ]);

        Country::create($request->all());
        return redirect('country')->with('message', 'New Country Added Successfully.');
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }

        $aRow = Country::findOrFail($id);
        return view('admin.country.add',compact('aRow'));
    }

   
    public function update(Request $request, $id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }


        $aVals = $request->all();
        $this->validate($request, [
             'name' => 'required|string|max:255|unique:countries,name,'.$id,       
        ]);

        $aRow = Country::find($id);
        $aRow->update($aVals);

        return redirect('country')->with('message', 'Country updated Successfully.');
    }

    public function status($id,$status)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }


        $aRow = Country::find($id);  
        $aRow->status = $status;
        $aRow->save();
        return redirect('country')->with('message', 'country status changed Successfully.');
    }
    
    public function destroy($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin != "adminLogin") {
            return redirect('home');
        }


        $aRow = Country::findOrFail($id);
        $aRow->delete();
        City::where("country_id", "=",$id)->delete();          
        return redirect('country')->with('message', 'Country deleted Successfully.');
    }
    
}
