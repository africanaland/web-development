<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Country;
use App\City;
use App\Membership;
use App\Events\sendNotification;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth', ['except' => ['getcity']]);
    }

    public function index($type = "guest",Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);
        /* redirect host */
        if($CurrentLogin == "hostLogin")
            return redirect('/');


        $aQvars = $request->query();
        $aQry = User::select(['*']);

        $aRoles = $aCountries = $aMemberships = $aCities = array();

        if(isset($aQvars['role_id']) && $aQvars['role_id'] > 0)
        {
            $aQry->where("role_id", "=",$aQvars['role_id']);
        }
        else
        {
            if($type == "guest")
            {
                $aQry->where("role_id", "=",User::ROLE_GUEST);
            }
            if($type == "staff")
            {
                //User::ROLE_ADMIN,
                $aQry->whereIn('role_id', [ User::ROLE_SUBADMIN, User::ROLE_AGENT]);             
            }
            if($type == "hosts")
            {
                $aQry->whereIn('role_id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL]); 
            }
        }

        if(isset($aQvars['keyword']) && $aQvars['keyword'])
        {
            $keyword = $aQvars['keyword'];
            $aQry->where(function ($aQry) use ($keyword)
            {
                $aQry->where('fname', 'LIKE', '%' . $keyword . '%')
                     ->orWhere('lname', 'LIKE', '%' . $keyword . '%')
                     ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('username', 'LIKE', '%' . $keyword . '%');
            });
        }

        if(isset($aQvars['country']) && $aQvars['country'] > 0)
        {
            $aQry->where("country", "=",$aQvars['country']);
            $aCities = City::get()->where('country_id','=',$aQvars['country'])->pluck('name', 'id')->toArray();
        }
        if(isset($aQvars['city']) && $aQvars['city'])
        {
            $aQry->where("city", "=",$aQvars['city']);    
        }
        
        if(isset($aQvars['membership']) && $aQvars['membership'] > 0)
        {
            $aQry->where("membership_id", "=",$aQvars['membership']);
        }
        if($CurrentLogin == 'staffLogin')
            $aQry->where('creator_id', $aUser->id);
        

        $aRows = $aQry->with('role')->get();
      

        
        $pageName = "Guests" ; 
        if($type == "staff")
        { 
            $aRoles = Role::whereIn('id', [ User::ROLE_SUBADMIN, User::ROLE_AGENT])->get()->pluck('name', 'id')->toArray();   
            $pageName = "Staff"; 
        }
        if($type == "hosts")
        {
            
            $aRoles = Role::whereIn('id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL])
            ->get()->pluck('name', 'id')->toArray();
            $pageName = "Hosts"; 
            $aCountries = Country::get()->pluck('name', 'id')->toArray(); 
        }

        
        if($type == "guest")
        {
            $aCountries = Country::get()->pluck('name', 'id')->toArray();
            $aMemberships = Membership::get()->pluck('name', 'id')->toArray();  
        }
        
              
        return view('admin.users.index',compact('aRows','pageName','aRoles','aQvars','type','aMemberships','aCountries','aCities'));
    }
   

    public function create($type = "guest")
    {
        $aRoles = Role::whereIn('id', [ User::ROLE_GUEST])
            ->get()->pluck('name', 'id')->toArray();
        if($type == "staff")
        { 
            $aRoles = Role::whereIn('id', [ User::ROLE_SUBADMIN, User::ROLE_AGENT])
            ->get()->pluck('name', 'id')->toArray();   
        }
        if($type == "hosts")
        {            
            $aRoles = Role::where('privileges',User::PREV_HOST)
            ->get()->pluck('name', 'id')->toArray();
        }

        $aMemberships = Membership::get()->pluck('name', 'id')->toArray();  
        $aCountries = Country::get()->pluck('name', 'id')->toArray();
        $aCities = array();  
        $aRow = array();
        $guest_role = User::ROLE_GUEST;
        return view('admin.users.add',compact('aRoles','aCountries','aCities','aRow','aMemberships','guest_role','type'));
    }
    public function store(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUser->role_id);

        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin == "staffLogin")
            $staffLogin = true;
        if ($CurrentLogin == "hostLogin")
            $hostLogin = true;
        if ($CurrentLogin == "adminLogin")
            $adminLogin = true;



        $this->validate($request, [
            'fname' => 'required|string|max:255', 
            'lname' => 'required|string|max:255', 
            'username' => 'required|string|max:255|unique:users', 
            'email' => 'required|string|max:255|unique:users', 
            'password' => 'required|string|min:8|confirmed', 
            'mobile' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $aVals = $request->all();

        if($adminLogin)
            $aVals['creator_id'] = 1; //admin
        else
            $aVals['creator_id'] = $aUser->id;



        $imageName = "";
        if($image = request()->image)
        {       
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }
        $aVals['password'] = Hash::make($aVals['password']);
        $aVals['membership_id'] =   Membership::getDefault();

        
        $aData = User::create($aVals);

        if(in_array($aVals['role_id'],[User::ROLE_HOST_COMPANY,User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL])){
                event(new sendNotification(0,1,3,$aData->id));
        }    

            return redirect($this->redirecturl($aVals['role_id']))->with('message', 'New user Added Successfully.');
    }

    
    public function show($id)
    {
         $aRow = user::findOrFail($id);
         return view('admin.users.show',compact('aRow'));
    }

    public function edit($id)
    {
        $type = "guest";
        $aRow = User::findOrFail($id);
        $aRoles = Role::whereIn('id', [ User::ROLE_GUEST])
            ->get()->pluck('name', 'id')->toArray();
          
        $aCountries = Country::get()->pluck('name', 'id')->toArray(); 
        $aCities = City::get()->where('country_id','=',$aRow->country)->pluck('name', 'id')->toArray();    
        $guest_role = User::ROLE_GUEST;  

        if(in_array($aRow->role_id, array(User::ROLE_SUBADMIN, User::ROLE_AGENT)))
        {
            $type = "staff";
            $aRoles = Role::whereIn('id', [ User::ROLE_SUBADMIN, User::ROLE_AGENT])
            ->get()->pluck('name', 'id')->toArray(); 
        }
        if(in_array($aRow->role_id, array(User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL)))
        {
            $type = "host";
            $aRoles = Role::whereIn('id', [User::ROLE_HOST_COMPANY, User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL])
            ->get()->pluck('name', 'id')->toArray();
        }

        $aMemberships = Membership::get()->pluck('name', 'id')->toArray();  
        return view('admin.users.add',compact('aRoles','aCountries','aCities','aRow','guest_role','aMemberships','type'));
    }

   
    public function profile()
    {
        $aUser = \Auth::guard('admin')->user();
        $aRow = User::findOrFail($aUser->id);
        $aCountries = Country::get()->pluck('name', 'id')->toArray(); 
        $aCities = City::get()->where('country_id','=',$aRow->country)->pluck('name', 'id')->toArray();   
        $profilePage = true; 
        $type = "Profile";
        return view('admin.users.add',compact('aCountries','aCities','aRow','profilePage','type'));
    }

    public function update(Request $request, $id)
    {
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);

        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin == "staffLogin")
            $staffLogin = true;
        if ($CurrentLogin == "hostLogin")
            $hostLogin = true;
        if ($CurrentLogin == "adminLogin")
            $adminLogin = true;

        
        // event(new sendNotification(0,$aUserId->id,11,$aUserId->id));


       
        $this->validate($request, [
            'username' => 'required|string|max:255|unique:users,username,'.$id, 
            'email' => 'required|string|max:255|unique:users,email,'.$id, 
            'fname' => 'required|string|max:255', 
            'lname' => 'required|string|max:255', 
            'mobile' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $aRow = User::find($id);

        if($hostLogin){
            if($aUserId->id != $id){
                return redirect()->back()->with('error','unauthorized Access');
            }     
        }
        if($staffLogin){
            if($aUserId->id != $aRow->creator_id){
                return redirect()->back()->with('error','unauthorized Access');
            }     
        }

        $aVals = $request->all();
        $imageName = "";
        if($image = request()->image)
        {       
            $imageName = \CustomHelper::uploadImage($image);
            $aVals['image'] = $imageName;
        }
        $aRow->update($aVals);

        if($aUserId->id == $id)
        {
            return redirect('users/profile')->with('message', 'Profile updated Successfully.');
        }
        return redirect($this->redirecturl($aRow->role_id))->with('message', 'User updated Successfully.');
    }

    
    public function destroy($id)
    {
        $aUserId = \Auth::guard('admin')->user();
        $CurrentLogin = $this->UserLoginType($aUserId->role_id);

        $hostLogin = $staffLogin = $adminLogin = false;
        if ($CurrentLogin == "staffLogin")
            $staffLogin = true;
        if ($CurrentLogin == "hostLogin")
            return redirect('home');
        if ($CurrentLogin == "adminLogin")
            $adminLogin = true;

        $aRow = User::findOrFail($id);
        if($staffLogin){
            if($aUserId->id != $aRow->creator_id){
                return redirect()->back()->with('error','unauthorized Access');
            }     
        }

        $aRow->delete();
        return redirect($this->redirecturl($aRow->role_id))->with('message', 'user deleted Successfully.');
    }

    public function status($id,$status)
    {
        $aRow = User::findOrFail($id);
        $aRow->update(array('status' => $status));
        return redirect($this->redirecturl($aRow->role_id))->with('message', 'user status changed Successfully.');
    }
    

    public function redirecturl($role_id)
    {
        $url = "users";
        if(in_array($role_id, array(User::ROLE_ADMIN,User::ROLE_SUBADMIN,User::ROLE_AGENT)))
        {
            $url = "users/index/staff";
        }
        if(in_array($role_id, array(User::ROLE_HOST_COMPANY,User::ROLE_HOST_INDIVIDUAL,User::ROLE_HOTEL)))
        {
            $url = "users/index/hosts";
        }
        return $url;
    }

    public function getcity()
    {
        $country = $_POST['country'];
        $aRows = City::where('country_id', '=', $country)->pluck('name', 'id')->toArray();    
                
        $html = '<option value="">Please Select</option>';
        if($aRows)
        {
            foreach ($aRows as $aKey => $aRow) {
                $html .= '<option value="'.$aKey.'">'.$aRow.'</option>';
            }
        }
        echo $html;
        exit;
    }
    


}
