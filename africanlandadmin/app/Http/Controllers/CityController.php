<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\City;
use App\Country;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }


    public function index(Request $request)
    {    
        $aUserData = \Auth::guard('admin')->user();
        $hostLogin = $staffLogin = $adminLogin = false;
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);

        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
        }
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }



        $aQvars = $request->query();
        $aCountriesObj = Country::where('status',1);
        if($staffLogin)            
            $aCountriesObj->where('id',$aUserData->country);
        $aCountries = $aCountriesObj->pluck('name', 'id')->toArray(); 

        $aQry = City::select(['*']);

        if(isset($aQvars['keyword']) && $aQvars['keyword'])
        {
            $keyword = $aQvars['keyword'];
            $aQry->where(function ($aQry) use ($keyword)
            {
                $aQry->where('name', 'LIKE', '%' . $keyword . '%');
    
            });
        }
        if(isset($aQvars['country']) && $aQvars['country'] > 0)
        {
            $aQry->where("country_id", "=",$aQvars['country']);
        }
        if($staffLogin)            
            $aQry->where('country_id',$aUserData->country);


        $aRows = $aQry->get();      
        return view('admin.city.index',compact('aRows','aQvars','aCountries'));
    }

    public function index1($country_id = 0)
    {
        $aCountries = Country::get()->pluck('name', 'id')->toArray();      
        $aRows = city::with('country')->get(); 
        if($country_id > 0)
        {
            $aRows = city::with('country')->where('country_id',$country_id)->get(); 
        }               
      
        return view('admin.city.index',compact('aRows','aCountries','country_id'));
    }

    public function create()
    {
        $aCountries = Country::get()->pluck('name', 'id')->toArray();       
        return view('admin.city.add',compact('aCountries'));
    }
    public function store(Request $request)
    {
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }


        $this->validate($request, [
             'name' => 'required|string|max:255|unique:cities',        
        ]);

        city::create($request->all());
        return redirect('country?country='.$request->country_id)->with('message', 'New city Added Successfully.');
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }

        
        $aCountries = Country::get()->pluck('name', 'id')->toArray();    
        $aRow = city::findOrFail($id);
        return view('admin.city.edit',compact('aRow','aCountries'));
    }

   
    public function update(Request $request, $id)
    {
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }
        
        $this->validate($request, [
             'name' => 'required|string|max:255|unique:cities,name,'.$id,       
        ]);


        $aRow = city::find($id);
        $aRow->name = $request->name;
        $aRow->country_id = $request->country_id;
        $aRow->save();

        return redirect('country?country='.$aRow->country_id)->with('message', 'city updated Successfully.');
    }

    public function status($id,$status)
    {
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }

        $aRow = city::find($id);  
        $aRow->status = $status;
        $aRow->save();
        return redirect('country?country='.$aRow->country_id)->with('message', 'city status changed Successfully.');
    }
    
    public function destroy($id)
    {
        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "hostLogin") {
            return redirect('home');
        }


        $aRow = city::findOrFail($id);      
        $aRow->delete();
        return redirect('country?country='.$aRow->country_id)->with('message', 'city deleted Successfully.');
    }
    
    
}
