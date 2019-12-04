<?php
namespace App\Modules\Dealer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\User\Models\User;
use App\Modules\Depot\Models\DepotUser;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class DealerController extends Controller {
    //Display employee details 
    public function dealerListPage()
    {
        return view('Dealer::dealer-list');
    }
    //returns employees as json 
    public function getDealers()
    {
        $dealers = Dealer::select(
            'id', 
            'user_id',                      
            'name',                   
            'address',                                        
            'deleted_at'
        )
        ->withTrashed()
        ->with('user:id,email,mobile,deleted_at')
        ->get();
        return DataTables::of($dealers)
        ->addIndexColumn()
        ->addColumn('working_status', function ($dealers) {
            if($dealers->user->deleted_at == null){ 
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disableDealers(".$dealers->user_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
            ";
            }else{ 
            return "
                <b style='color:#FF0000';>Disabled</b>
                <button onclick=enableDealer(".$dealers->user_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Enable </button>
            ";
            }
        })
        ->addColumn('action', function ($dealers) {
             $b_url = \URL::to('/');
            if($dealers->user->deleted_at == null){ 
            return "
            <a href=".$b_url."/dealers/".Crypt::encrypt($dealers->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <a href=".$b_url."/dealers/".Crypt::encrypt($dealers->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/dealers/".Crypt::encrypt($dealers->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
           
            ";
            }else{ 
            return "";
            }
        })
        ->rawColumns(['link', 'action','working_status'])
        ->make();
    }
    //dealer creation page
    public function create()
    {
       return view('Dealer::dealer-create');
    }
    //upload dealer details to database table
    public function save(Request $request)
    {
        // \Auth::user()->root->first()->id
        $root_id=\Auth::user()->id;
        if($request->user()->hasRole('root')){
            $url=url()->current();
            $rayfleet_key="rayfleet";
            $eclipse_key="eclipse";

            if (strpos($url, $rayfleet_key) == true) {
                 $rules = $this->rayfleet_user_create_rules();
            }
            else if (strpos($url, $eclipse_key) == true) {
                 $rules = $this->user_create_rules();
            }
            else
            {
               $rules = $this->user_create_rules();
            }
            $this->validate($request, $rules);
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => 1,
                'password' => bcrypt($request->password),
            ]);
            $dealer = Dealer::create([
                'user_id' => $user->id,
                'root_id'=>$root_id,
                'name' => $request->name,            
                'address' => $request->address,
            ]);
            User::where('username', $request->username)->first()->assignRole('dealer');
        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New Distributor created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('dealers')); 
    }
    //Dealer details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $dealer = Dealer::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);   
        
        if($dealer == null){
            return view('Dealer::404');
        }
        return view('Dealer::dealer-details',['dealer' => $dealer,'user' => $user]);
    }
    //for edit page of Dealers
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $dealers = Dealer::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);

        if($dealers == null){
            return view('Dealer::404');
        }
        return view('Dealer::dealer-edit',['dealers' => $dealers,'user' => $user]);
    }
    //update dealers details
    public function update(Request $request)
    {  
        $user = User::find($request->id);
        $dealer = Dealer::where('user_id', $request->id)->first();
        if($dealer == null){
           return view('Dealer::404');
        } 
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->dealersUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->dealersUpdatesRules($user);
        }
        else
        {
           $rules = $this->dealersUpdatesRules($user);
        }
        $this->validate($request, $rules);   
        $dealer->name = $request->name;
        $dealer->save();
        $user->mobile = $request->phone_number;
        $user->save();
        $did = encrypt($user->id);
        $request->session()->flash('message', 'Distributor details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('dealers.edit',$did));  
    }
    //for edit page of employee password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $dealer = Dealer::where('user_id', $decrypted)->first();
        // $dealer = Dealer::find($decrypted);
        if($dealer == null){
           return view('Dealer::404');
        }
        return view('Dealer::dealer-change-password',['dealer' => $dealer]);
    }
    //update password
    public function updatePassword(Request $request)
    {
        $subdealer=User::find($request->id);
        if($subdealer== null){
            return view('SubDealer::404');
        }
        $did=encrypt($subdealer->id);
        // dd($request->password);
        $rules=$this->updatePasswordRule();
        $this->validate($request,$rules);
        $subdealer->password=bcrypt($request->password);
        $subdealer->save();
        $request->session()->flash('message','Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('dealers.change-password',$did));
    }

    //delete dealer details from table
    public function disableDealer(Request $request)
    {
        $dealer_user = User::find($request->id);
        $dealer = Dealer::select('id')->where('user_id',$dealer_user->id)->first();
        if($dealer_user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Distributor does not exist'
            ]);
        }
        $dealer_user->delete();
        $dealer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Distributor disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableDealer(Request $request)
    {
        $dealer_user = User::withTrashed()->find($request->id);
        $dealer = Dealer::withTrashed()->select('id')->where('user_id',$dealer_user->id)->first();
        if($dealer_user==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Distributor does not exist'
            ]);
        }
        $dealer_user->restore();
        $dealer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Distributor enabled successfully'
        ]);
    }
   
    //delete employee details from table
    public function deleteDealer(Request $request)
    {
        $dealer = Dealer::find($request->uid);
        if($dealer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Distributor does not exist'
            ]);
        }
        $dealer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Distributor deleted successfully'
        ]);
    }
    // restore emplopyee
    public function activateDealer(Request $request)
    {
        $dealer = Dealer::withTrashed()->find($request->id);
        if($dealer==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Distributor does not exist'
            ]);
        }
        $dealer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Distributor restored successfully'
        ]);
    }

////////////////////////Dealer Profile-start/////////////////

    //Dealer profile view
    public function dealerProfile()
    {
        $dealer_id = \Auth::user()->dealer->id;
        $dealer_user_id = \Auth::user()->id;
        $dealer = Dealer::withTrashed()->where('id', $dealer_id)->first();
        $user=User::find($dealer_user_id); 
        if($dealer == null)
        {
           return view('Dealer::404');
        }
        return view('Dealer::dealer-profile',['dealer' => $dealer,'user' => $user]);
    }

    //for edit page of Dealer profile
    public function editDealerProfile()
    {
        $dealer_id=\Auth::user()->dealer->id;
        $dealer = Dealer::where('id', $dealer_id)->first();
        if($dealer == null){
            return view('Dealer::404');
        }
        return view('Dealer::dealer-profile-edit',['dealer' => $dealer]);
    }
    //update dealer profile details
    public function updateDealerProfile(Request $request)
    {  
        $dealer = Dealer::find($request->id);
        $user = User::where('id', $dealer->user_id)->first();
        if($dealer == null){
           return view('Dealer::404');
        } 
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->dealerProfileUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->dealerProfileUpdatesRules($user);
        }
        else
        {
           $rules = $this->dealerProfileUpdatesRules($user);
        }
        $this->validate($request, $rules);   
        $dealer->name = $request->name;
        $dealer->address = $request->address;
        $dealer->save();
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();
        $request->session()->flash('message', 'Details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('dealer.profile'));  
    }

////////////////////////Dealer Profile-end////////////////

    public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
    }
    
    //validation for employee updation
    public function dealersUpdatesRules($user)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,       
        ];
        return  $rules;
    }
    public function dealersUpdatesRulesRayfleet($user)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,       
        ];
        return  $rules;
    }
    public function dealerProfileUpdatesRules($user){
        $rules = [
            'name' => 'required',       
            'address' => 'required',       
            'mobile' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }

    public function dealerProfileUpdatesRulesRayfleet($user){
        $rules = [
            'name' => 'required',       
            'address' => 'required',       
            'mobile' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }
    
    //user create rules 
    public function user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|unique:users|min:10|max:10',
            'password' => 'required|string|min:6|confirmed',
        ];
        return  $rules;
    }

    public function rayfleet_user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|unique:users|min:11|max:11',
            'password' => 'required|string|min:6|confirmed',
        ];
        return  $rules;
    }
}
