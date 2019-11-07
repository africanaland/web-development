<?php
namespace App\Http\Controllers;

use App\Amenity;
use App\City;
use App\Country;
use App\Events\sendNotification;
use App\Http\Controllers\Controller;
use App\Property;
use App\Review;
use App\Role;
use App\Service;
use App\User;
use App\notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
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
            $AllRigisteredHost = User::where('creator_id', $aUserData->id)->pluck('id')->toArray();
        }
        if ($CurrentLogin == "hostLogin") {
            $hostLogin = true;
            $AllRigisteredProperty = Property::where('user_id', $aUserData->id)->pluck('id')->toArray();
        }

        $aQvars = $request->query();
        $aUser = User::findOrFail($aUserData->id);
        $aTypes = Property::getTypes();
        $aQry = Property::select(['*']);
        
        $aCountriesObj = Country::where('status',1);
            if($staffLogin)
               $aCountriesObj->where('id',$aUserData->country);
            $aCountries = $aCountriesObj->pluck('name', 'id')->toArray();
        $aCities = $aSubTypes = array();
        
        $aHosttypes = Role::whereIn('id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL, User::ROLE_HOTEL])
                            ->get()->pluck('name', 'id')->toArray();
        $aProptypes = array(); //Property::getTypes($aRow->host_type);

        if (isset($aQvars['keyword']) && $aQvars['keyword']) {
            $keyword = $aQvars['keyword'];
            $aQry->where(function ($aQry) use ($keyword) {
                $aQry->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('details', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('overview', 'LIKE', '%' . $keyword . '%');
            });
        }
        if (isset($aQvars['host_type']) && $aQvars['host_type']) {
            $aQry->where("host_type", "=", $aQvars['host_type']);
            $aProptypes = Property::getTypes($aQvars['host_type']);
        }
        if (isset($aQvars['country']) && $aQvars['country']) {
            $aQry->where("country", "=", $aQvars['country']);
            $aCities = City::get()->where('country_id', '=', $aQvars['country'])->pluck('name', 'id')->toArray();
        }
        if (isset($aQvars['city']) && $aQvars['city']) {
            $aQry->where("city", "=", $aQvars['city']);
        }

        if ($hostLogin)
            $aQry->where("user_id", "=", $aUserData->id);
        if ($staffLogin)
            $aQry->whereIn("user_id", $AllRigisteredHost);

        $aRows = $aQry->orderBy('id','DESC')->get();

        return view('admin.property.index', compact('aRows', 'aQvars', 'aTypes', 'aSubTypes', 'aCountries', 'aCities', 'aHosttypes', 'aProptypes'));
    }

    public function create()
    {
        $aUserData = \Auth::guard('admin')->user();
        $hostLogin = $staffLogin = $adminLogin = false;
        $aCities = $aSubTypes = array();
        $aHostLists = $aHosttypes = $aProptypes = array();
        $aRow = array();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);
        if ($CurrentLogin == "staffLogin")
            $staffLogin = true;
        if ($CurrentLogin == "adminLogin")
            $adminLogin = true;
        if ($CurrentLogin == "hostLogin")
            $hostLogin = true;


        $aUserData = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);

        $aTypes = Property::getTypes();
        $aCountriesObj = Country::where('status',1);
        if($staffLogin)
           $aCountriesObj->where('id',$aUserData->country);
        $aCountries = $aCountriesObj->pluck('name', 'id')->toArray();

        if($hostLogin){
            $aCountries = $aUserData->country;
            $aCities = $aUserData->city;
            $aHostLists = $aUserData->id;
            $aHosttypes = $aUserData->role_id;
            $aProptypes = Property::getTypes($aHosttypes);
        }

        $aServices = Service::get()->pluck('name', 'id')->toArray();
        $aAmenities = Amenity::get()->pluck('name', 'id')->toArray();

        return view('admin.property.add', compact('aCountries', 'aCities', 'aRow', 'aServices', 'aAmenities', 'aTypes', 'aSubTypes', 'aHostLists', 'aHosttypes', 'aProptypes'));

    }
    public function store(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        $hostLogin = $staffLogin = $adminLogin = false;
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        if ($CurrentLogin == "staffLogin")
            $staffLogin = true;
        if ($CurrentLogin == "adminLogin")
            $adminLogin = true;
        if ($CurrentLogin == "hostLogin")
            $hostLogin = true;

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'daily_rate' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
        ]);
        $aVals = $this->preparevalue($request);
        $aVals['user_id'] = $aUser->id;

        $propertyData = Property::create($aVals);

        if($staffLogin)
        $nData = [['broadcast'=>0,'s_id'=>0,'r_id'=>1,'text_id'=>1,'data_id'=>$propertyData->id]
                    ,['broadcast'=>0,'s_id'=>0,'r_id'=>$aVals['host_name'],'text_id'=>1,'data_id'=>$propertyData->id]];
        if($adminLogin){
            $nData = [['broadcast'=>0,'s_id'=>0,'r_id'=>$aVals['host_name'],'text_id'=>1,'data_id'=>$propertyData->id]];
        }
        if($hostLogin)
        $nData = [['broadcast'=>0,'s_id'=>0,'r_id'=>1,'text_id'=>1,'data_id'=>$propertyData->id]
                ,['broadcast'=>0,'s_id'=>0,'r_id'=>$aUser->creator_id,'text_id'=>1,'data_id'=>$propertyData->id]];
        notification::insert($nData);

        return redirect('property')->with('message', 'New property Added Successfully.');
    }

    public function show($id)
    {
        $result = $this->checkUser($id);
        if(!$result ){
            return redirect('property')->with('error','Unauthorized Request');
        }

        $aRow = $review = array();
        $aRow = Property::findOrFail($id);
        $review = Review::select(\DB::raw('count(user_id) as count , rating as star'))->where('property_id', $id)->groupBy('rating')->get();
        return view('admin.property.show', compact('aRow', 'review'));
    }

    public function edit($id)
    {
        $result = $this->checkUser($id);
        if(!$result){
            return redirect('property')->with('error','Unauthorized Request');
        }

        
        $aRow = Property::findOrFail($id);
        $aTypes = Property::getTypes();
        $aSubTypes = Property::getTypes($aRow->type);
        $aCountries = Country::get()->pluck('name', 'id')->toArray();
        $aCities = City::get()->where('country_id', '=', $aRow->country)->pluck('name', 'id')->toArray();
        $aServices = Service::get()->pluck('name', 'id')->toArray();
        $aAmenities = Amenity::get()->pluck('name', 'id')->toArray();
        $aHostLists = $aHosttypes = $aProptypes = array();
        $aHostLists = User::select(DB::raw("CONCAT(fname,' ',lname) AS name"), 'id')->whereIn('role_id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL])->get()->pluck('name', 'id')->toArray();
        $aHosttypes = Role::where('id', '=', $aRow->host_type)->get()->pluck('name', 'id')->toArray();
        $aProptypes = Property::getTypes($aRow->host_type);

        return view('admin.property.add', compact('aCountries', 'aCities', 'aRow', 'aServices', 'aAmenities', 'aTypes', 'aSubTypes', 'aHostLists', 'aHosttypes', 'aProptypes'));
    }

    private function preparevalue($request, $is_edit = 0)
    {
        $aVals = $request->all();
        if (isset($aVals['services']) && $aVals['services']) {
            $aVals['services'] = implode(",", array_filter($aVals['services']));
        }
        if (isset($aVals['amenities']) && $aVals['amenities']) {
            $aVals['amenities'] = implode(",", array_filter($aVals['amenities']));
        }

        if (isset($aVals['have_tax']) && $aVals['have_tax'] == 1) {
            $aVals['have_tax'] = 1;
        } else {
            $aVals['have_tax'] = 0;
            $aVals['tax_rate'] = 0;
        }

        $imageName = "";
        if ($image = request()->image) {
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }

        if ($files = $request->file('property')) {
            $gallery_images = array();

            if ($is_edit > 0) {
                $aRow = Property::find($is_edit);
                $gallery_images = unserialize($aRow->gallery_images);
            }

            foreach ($files as $file) {
                $imageName = \CustomHelper::uploadImage($file);
                $imgexplode = explode(".", $imageName);
                $imgname = $imgexplode[0];
                if ($imageName) {
                    $gallery_images[$imgname] = $imageName;
                }
            }
            $aVals['gallery_images'] = serialize($gallery_images);
        }
        $aVals['status'] = 1;
        return $aVals;
    }

    public function update(Request $request, $id)
    {
        $result = $this->checkUser($id);
        if(!$result){
            return redirect('property')->with('error','Unauthorized Request');
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'daily_rate' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
        ]);

        $aVals = $this->preparevalue($request, $id);

        $aRow = Property::find($id);
        $aRow->update($aVals);
        return redirect('property')->with('message', 'property updated Successfully.');
    }

    public function updategallery(Request $request, $id)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $imageName = "";
        $gallery_images = array();
        $aRow = Property::find($id);
        if ($aRow->gallery_images) {
            $gallery_images = unserialize($aRow->gallery_images);
        }
        if ($image = request()->image) {
            $imageName = \CustomHelper::uploadImage($image);
            $imgexplode = explode(".", $imageName);
            $imgname = $imgexplode[0];
            if ($imageName) {
                $gallery_images[$imgname] = $imageName;
            }
            $aVals['gallery_images'] = serialize($gallery_images);
            $aRow->update($aVals);
        }

        return redirect('property/gallery/' . $id)->with('message', 'gallery image added Successfully.');
    }

    public function status($id, $status)
    {
        $result = $this->checkUser($id);
        if(!$result){
            return redirect('property')->with('error','Unauthorized Request');
        }

        $aRow = Property::findOrFail($id);
        $aRow->update(array('status' => $status));
        return redirect('property')->with('message', 'status changed Successfully.');
    }

    public function destroy($id)
    {
        $result = $this->checkUser($id);
        if(!$result){
            return redirect('property')->with('error','Unauthorized Request');
        }

        $aRow = Property::findOrFail($id);
        $aRow->delete();
        return redirect('property')->with('message', 'property deleted Successfully.');
    }

    public function removegallery($id, $gallery_id)
    {
        $aRow = Property::find($id);
        $gallery_images = unserialize($aRow->gallery_images);
        $image = $gallery_images[$gallery_id];
        unset($gallery_images[$gallery_id]);
        \CustomHelper::removeImage($image);
        $aVals['gallery_images'] = "";
        if ($gallery_images) {
            $aVals['gallery_images'] = serialize($gallery_images);
        }
        $aRow->update($aVals);
        return redirect("property/{$id}/edit/")->with('message', 'gallery image remove Successfully.');
    }

    public function gallery($id)
    {
        $aRow = Property::find($id);
        $aImages = unserialize($aRow->gallery_images);
        return view('admin.property.gallery', compact('aRow', 'aImages'));
    }

    public function getsubtype()
    {
        $type = $_POST['type'];
        $aRows = Property::getTypes($type);

        $html = '<option value="">Please Select</option>';
        if ($aRows) {
            foreach ($aRows as $aKey => $aRow) {
                $html .= '<option value="' . $aKey . '">' . $aRow . '</option>';
            }
        }
        echo $html;
        exit;
    }

    public function gethostlists()
    {
        $city = $_POST['city'];
        $aRows = User::where('city', '=', $city)->whereIn('role_id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL])->get();

        $html = '<option value="">Please Select</option>';
        if ($aRows) {
            foreach ($aRows as $aKey => $aRow) {
                $html .= '<option value="' . $aRow->id . '">' . $aRow->fname . " " . $aRow->lname . '</option>';
            }
        }
        echo $html;
        exit;
    }

    public function gethosttype()
    {
        $host_name = $_POST['host_name'];
        $aRows = User::with('role')->where('id', '=', $host_name)->get();

        $html = '';
        if ($aRows) {
            foreach ($aRows as $aKey => $aRow) {
                $html .= '<option selected value="' . $aRow->role_id . '">' . $aRow->role['name'] . '</option>';
            }
        }
        echo $html;
        exit;
    }


    /* for check user to update only our data */
    public function checkUser($propertyId){

        $aUserData = \Auth::guard('admin')->user();
        $hostLogin = $staffLogin = $adminLogin = $result = false;
        $CurrentLogin = $this->UserLoginType($aUserData->role_id);

        if ($CurrentLogin == "staffLogin") {
            $staffLogin = true;
            $AllRigisteredHost = User::where('creator_id', $aUserData->id)->pluck('id')->toArray();
            $AllRigisteredProperty = Property::whereIn('user_id', $AllRigisteredHost)->pluck('id')->toArray();
            if(in_array($propertyId,$AllRigisteredProperty)){
                $result = true;
            }
        }
        if ($CurrentLogin == "hostLogin") {
            $hostLogin = true;
            $AllRigisteredProperty = Property::where('user_id', $aUserData->id)->pluck('id')->toArray();
            if(in_array($propertyId,$AllRigisteredProperty)){
                $result = true;
            }
        }
        if ($CurrentLogin == "adminLogin") {
            $result = true;
        }
        return $result;

    }

}
