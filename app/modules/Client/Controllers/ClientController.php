<?php
namespace App\Modules\Client\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Models\ClientAlertPoint;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Alert\Models\AlertType;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class ClientController extends Controller {
   
    //employee creation page
    public function create()
    {
       return view('Client::client-create');
    }
    //upload employee details to database table
    public function save(Request $request)
    {      
        $subdealer_id = \Auth::user()->subdealer->id; 
        if($request->user()->hasRole('sub_dealer'))
        {
            $rules = $this->user_create_rules();
            $this->validate($request, $rules);
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => 1,
                'password' => bcrypt($request->password),
            ]);
            $client = Client::create([            
                'user_id' => $user->id,
                'sub_dealer_id' => $subdealer_id,
                'name' => $request->name,            
                'address' => $request->address,           
            ]);
            User::where('username', $request->username)->first()->assignRole('client');
            
            $alert_types = AlertType::all(); 
            if($client){
                foreach ($alert_types as $alert_type) {
                    $user_alerts = UserAlerts::create([
                      "alert_id" => $alert_type->id, 
                      "client_id" => $client->id, 
                      "status" => 1
                    ]);
                    $client_alert_point = ClientAlertPoint::create([
                      "alert_type_id" => $alert_type->id, 
                      "driver_point" => $alert_type->driver_point, 
                      "client_id" => $client->id
                    ]);
                }
            }
        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New client created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
         return redirect(route('clients'));        
    }
    public function clientList()
    {
        return view('Client::client-list');
    }
    public function user_create_rules()
    {
        $rules = [
            'username' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        return  $rules;
    }
    public function getClientlist(Request $request)
    {
        $subdealer=$request->user()->subdealer->id;
        $client = Client::select(
        'id', 
        'user_id',
        'sub_dealer_id',                      
        'name',                   
        'address',                                       
        'deleted_at')
        ->withTrashed()
        ->with('user:id,email,mobile')
        ->where('sub_dealer_id',$subdealer)
        ->get();
        return DataTables::of($client)
        ->addIndexColumn()
        ->addColumn('action', function ($client) {
        if($client->deleted_at == null){ 
            return "
            <a href=/client/".Crypt::encrypt($client->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
             <a href=/client/".Crypt::encrypt($client->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
              <a href=/client/".Crypt::encrypt($client->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <button onclick=delClient(".$client->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
        }else{                   
                return "
              
                <a href=/client/".Crypt::encrypt($client->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=activateClient(".$client->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $client = Client::withTrashed()->where('user_id', $decrypted)->first();
        $user=User::find($decrypted); 
       
        if($client == null)
        {
           return view('Client::404');
        }
        return view('Client::client-edit',['client' => $client,'user' => $user]);
    }

    //update dealers details
    public function update(Request $request)
    {
        $client = Client::where('user_id', $request->id)->first();
        if($client == null){
           return view('Client::404');
        } 
        $rules = $this->dealersUpdateRules($client);
        $this->validate($request, $rules);       
        $client->name = $request->name;
        $client->save();
        $user = User::find($request->id);
        $user->mobile = $request->phone_number;
        $user->save();
        $did = encrypt($user->id);
        // $subdealer->phone_number = $request->phone_number;       
        // $did = encrypt($subdealer->id);
        $request->session()->flash('message', 'Client details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('client.edit',$did));  
    }
     //validation for employee updation
    public function dealersUpdateRules($subdealer)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|numeric'
            
        ];
        return  $rules;
    }
    //     //for edit page of subdealer password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $client = Client::where('user_id', $decrypted)->first();
         
        if($client == null){
           return view('Client::404');
        }
        return view('Client::client-change-password',['client' => $client]);
    }

    
    //update password
    public function updatePassword(Request $request)
    {
        $client=User::find($request->id);
        if($client== null){
            return view('SubDealer::404');
        }
        $did=encrypt($client->id);
        // dd($request->password);
        $rules=$this->updateDepotUserRuleChangePassword($client);
        $this->validate($request,$rules);
        $client->password=bcrypt($request->password);
        $client->save();
        $request->session()->flash('message','Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('client.change-password',$did));
    }
    public function updateDepotUserRuleChangePassword()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
    }

    //employee details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 

        $client = Client::withTrashed()->where('user_id', $decrypted)->first();
        $user=User::find($decrypted); 

        if($client == null){
           return view('Client::404');
        }
        return view('Client::client-details',['client' => $client,'user' => $user]);
    }


    public function clientListPage()
    {
        return view('Client::root-client-list');
    }
    //returns employees as json 
    public function getRootClient()
    {
        $client = Client::select(
            'id', 
            'user_id',
            'sub_dealer_id',                      
            'name',                   
            'address',                               
            'deleted_at'
        )
        ->withTrashed()
        ->with('subdealer:id,user_id,name')
        ->with('user:id,email,mobile,deleted_at')
        ->where('deleted_at',NULL)
        ->get();
        return DataTables::of($client)
        ->addIndexColumn()  
        ->addColumn('working_status', function ($client) {
            if($client->user->deleted_at == null){ 
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disableEndUser(".$client->user_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
            ";
            }else{ 
            return "
                <b style='color:#FF0000';>Disabled</b>
                <button onclick=enableEndUser(".$client->user_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Enable </button>
            ";
            }
        })
        ->rawColumns(['link','working_status'])             
        ->make();
    }

    //delete client details from table
    public function disableClient(Request $request)
    {
        $client = User::find($request->id);
        if($client == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Client does not exist'
            ]);
        }
        $client->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Client disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableClient(Request $request)
    {
        $client = User::withTrashed()->find($request->id);
        if($client==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Client does not exist'
            ]);
        }
        $client->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Client enabled successfully'
        ]);
    }

    public function dealerClientListPage()
    {
        return view('Client::dealer-client-list');
    }
    //returns employees as json 
    public function getDealerClient()
    {
         $dealer_id=\Auth::user()->dealer->id;
        $sub_dealers = SubDealer::select(
                'id'
                )
                ->where('dealer_id',$dealer_id)
                ->get();
        $single_sub_dealers = [];
        foreach($sub_dealers as $sub_dealer){
            $single_sub_dealers[] = $sub_dealer->id;
        }
       

        $client = Client::select(
            'id', 
            'user_id',
            'sub_dealer_id',                      
            'name',                   
            'address',                               
            'deleted_at'
        )
        ->withTrashed()
        ->with('subdealer:id,user_id,name')
         ->with('user:id,email,mobile')
        ->whereIn('sub_dealer_id',$single_sub_dealers)
        ->get();
        return DataTables::of($client)
        ->addIndexColumn()           
        ->make();
    }

    //delete Sub Dealer details from table
    public function deleteClient(Request $request)
    {
        $client = Client::find($request->uid);
        if($client == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Client does not exist'
            ]);
        }
        $client->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Client deleted successfully'
        ]);
    }

    // restore emplopyee
    public function activateClient(Request $request)
    {
        $client = Client::withTrashed()->find($request->id);
        if($client==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Client does not exist'
             ]);
        }

        $client->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Client restored successfully'
        ]);
    }

//////////////////////////////////////User Profile/////////////////////////////////////

    //user profile view
    public function userProfile()
    {
        $client_id = \Auth::user()->client->id;
        $client_user_id = \Auth::user()->id;
        $client = Client::withTrashed()->where('id', $client_id)->first();
        $user=User::find($client_user_id); 
        if($client == null)
        {
           return view('Client::404');
        }
        return view('Client::client-profile',['client' => $client,'user' => $user]);
    }

    // update user logo
    public function saveUserLogo(Request $request)
    {
        $client = Client::find($request->id);
        if($client == null){
           return view('Client::404');
        }
        $rules = $this->logoUpdateRules();
        $this->validate($request, $rules);

        $file=$request->file('logo');
        if($file){
            $old_file = $client->logo;
            if($old_file){
                $myFile = "logo/".$old_file;
                $delete_file=unlink($myFile);
            }
            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;
            //Move Uploaded File
            $destinationPath = 'logo';
            $file->move($destinationPath,$uploadedFile);
            $client->logo = $uploadedFile;
            $client->save();
        }
        $request->session()->flash('message', 'Logo updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('client.profile'));  
    }

//////////////////////////////////////User Change Password//////////////////////////////

    //user change password view
    public function userPasswordChange()
    {
        $client_id = \Auth::user()->client->id;
        $client_user_id = \Auth::user()->id;
        $client = Client::withTrashed()->where('id', $client_id)->first();
        $user=User::find($client_user_id); 
        if($client == null)
        {
           return view('Client::404');
        }
        return view('Client::-chang',['client' => $client,'user' => $user]);
    }

    // update change password
    public function saveUserNewPassword(Request $request)
    {
        $client = Client::find($request->id);
        if($client == null){
           return view('Client::404');
        }
        $rules = $this->logoUpdateRules();
        $this->validate($request, $rules);

        $file=$request->file('logo');
        if($file){
            $old_file = $client->logo;
            if($old_file){
                $myFile = "logo/".$old_file;
                $delete_file=unlink($myFile);
            }
            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;
            //Move Uploaded File
            $destinationPath = 'logo';
            $file->move($destinationPath,$uploadedFile);
            $client->logo = $uploadedFile;
            $client->save();
        }
        $request->session()->flash('message', 'Logo updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('client.profile'));  
    }

///////////////////////////////////////////////////////////////////////////////////////
    public function passwordUpdateRules(){
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
    }

    // logo update rules
    public function logoUpdateRules()
    {
        $rules = [
            'logo' => 'required'
        ];
        return  $rules;
    }
}
