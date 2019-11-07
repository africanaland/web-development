<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Amenity;
use App\User;


class AmenityController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index()
    {    
        $aRows = Amenity::orderBy('id','DESC')->get();        
        return view('admin.amenity.index',compact('aRows'));
    }

    public function create()
    {
        $aRow = array();
        return view('admin.amenity.add',compact('aRow'));
    }
    public function store(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        $this->validate($request, [
             'name' => 'required|string|max:255|unique:amenities', 
             'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',       
        ]);

        $aVals = $request->all();   

        $roleArray = array(User::ROLE_ADMIN,User::ROLE_SUBADMIN);
        if(!in_array($aUser->role_id,$roleArray))
        $aVals['creator_id'] = $aUser->id;
   

        $imageName = "";
        if($image = request()->image)
        {       
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }

        Amenity::create($aVals);
        return redirect('amenity')->with('message', 'New amenity Added Successfully.');
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $aRow = Amenity::findOrFail($id);
        $roleArray = array(User::ROLE_ADMIN,User::ROLE_SUBADMIN);
        if( in_array($aUser->role_id,$roleArray) || ($aUser->id == $aRow->creator_id) ){}
        else {
            return redirect('amenity')->with('error','Unauthorized Request');
        }
        
        return view('admin.amenity.add',compact('aRow'));
    }

   
    public function update(Request $request, $id)
    {
    
        $aUser = \Auth::guard('admin')->user();
        $aRow = Amenity::find($id);
        $roleArray = array(User::ROLE_ADMIN,User::ROLE_SUBADMIN);
        if( in_array($aUser->role_id,$roleArray) || ($aUser->id == $aRow->creator_id) ){}
        else {
            return redirect('amenity')->with('error','Unauthorized Request');
        }

        $this->validate($request, [
             'name' => 'required|string|max:255|unique:amenities,name,'.$id,  
             'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',     
        ]);

        $aVals = $request->all();      

        $imageName = "";
        if($image = request()->image)
        {       
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }

        $aRow->update($aVals);

        return redirect('amenity')->with('message', 'amenity updated Successfully.');
    }

    
    public function destroy($id)
    {
        $aUser = \Auth::guard('admin')->user();
        $aRow = Amenity::findOrFail($id);
        $roleArray = array(User::ROLE_ADMIN,User::ROLE_SUBADMIN);
        if( in_array($aUser->role_id,$roleArray) || ($aUser->id == $aRow->creator_id) ){}
        else {
            return redirect('amenity')->with('error','Unauthorized Request');
        }

        $aRow->delete();     
        return redirect('amenity')->with('message', 'amenity deleted Successfully.');
    }
    
    
}
