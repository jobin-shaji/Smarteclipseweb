<?php
namespace App\Modules\SubDealer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\User\Models\User;
use App\Modules\Warehouse\Models\TemporaryCertificate;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use PDF;
class SubDealerController extends Controller {
    //Display employee details 
    public function subdealerListPage()
    {
        return view('SubDealer::sub-dealer-root-list');
    }
    //returns employees as json 
    public function getSubDealers()
    {
        $subdealers = SubDealer::select(
            'id', 
            'user_id',
            'dealer_id',                      
            'name',                   
            'address',
            'created_at',                               
            'deleted_at'
        )
        ->withTrashed()
        ->with('dealer:id,user_id,name')
        ->with('user:id,email,mobile,deleted_at')
        ->orderBy('created_at','DESC')
        ->get();

        return DataTables::of($subdealers)
        ->addIndexColumn()      
        ->addColumn('working_status', function ($subdealers) {
            if($subdealers->user->deleted_at == null && $subdealers->deleted_at == null){ 
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disableSubDealers(".$subdealers->user_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
            ";
            }else{ 
            return "
                <b style='color:#FF0000';>Disabled</b>
                <button onclick=enableSubDealer(".$subdealers->user_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Enable </button>
            ";
            }
        })
        ->rawColumns(['link','working_status'])     
        ->make();
    }

    //delete sub_dealer details from table
    public function disableSubDealer(Request $request)
    {
        $sub_dealer_user = User::find($request->id);
        $sub_dealer = SubDealer::where('user_id',$request->id)->first();
        if($sub_dealer_user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Dealer does not exist'
            ]);
        }
        $sub_dealer_user->delete();
        $sub_dealer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableSubDealer(Request $request)
    {
        $sub_dealer_user = User::withTrashed()->find($request->id);
        $sub_dealer = SubDealer::withTrashed()->where('user_id',$request->id)->first();
        if($sub_dealer_user==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Dealer does not exist'
            ]);
        }
        $sub_dealer_user->restore();
        $sub_dealer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer enabled successfully'
        ]);
    }

    //employee creation page
    public function create()
    {
       return view('SubDealer::sub-dealer-create');
    }
    //upload employee details to database table
    public function save(Request $request)
    { 
        $dealer_id = \Auth::user()->dealer->id;
        if($request->user()->hasRole('dealer')){
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->subdealerCreateRulesRayfleet();
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->subdealerCreateRules();
        }
        else
        {
           $rules = $this->subdealerCreateRules();
        }
        $this->validate($request, $rules);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile_number,
            'status' => 1,
            'password' => bcrypt($request->password),
        ]);
            $dealer = SubDealer::create([            
            'user_id' => $user->id,
            'dealer_id' => $dealer_id,
            'name' => $request->name,            
            'address' => $request->address,           
           ]);
            User::where('username', $request->username)->first()->assignRole('sub_dealer');
        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New Dealer created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
         return redirect(route('subdealers'));        
    }
    public function subdealerList()
    {
        return view('SubDealer::subdealer-list');
    }

    public function getSubDealerlist(Request $request)
    {
       
        $dealer=$request->user()->dealer->id;
        $subdealers = SubDealer::select(
        'id', 
        'user_id',
        'dealer_id',                      
        'name',                   
        'address',
        'deleted_at')
        ->withTrashed()
        ->with('user:id,email,mobile,deleted_at')
        ->where('dealer_id',$dealer)
        ->get();
        return DataTables::of($subdealers)
        ->addIndexColumn()
        ->addColumn('action', function ($subdealers) {
            $b_url = \URL::to('/');
        if($subdealers->user->deleted_at == null && $subdealers->deleted_at == null){ 
            return "
            <a href=".$b_url."/sub-dealers/".Crypt::encrypt($subdealers->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
             <a href=".$b_url."/sub-dealers/".Crypt::encrypt($subdealers->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
              <a href=".$b_url."/sub-dealers/".Crypt::encrypt($subdealers->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <button onclick=delSubDealers(".$subdealers->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
        }else{                   
                return "

                <button onclick=activateSubDealer(".$subdealers->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }


    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $subdealers = SubDealer::withTrashed()->where('user_id', $decrypted)->first();
        $user=User::find($decrypted);        
        if($subdealers == null)
        {
           return view('SubDealer::404');
        }
        return view('SubDealer::sub-dealer-edit',['subdealers' => $subdealers,'user' => $user]);
    }

    //update dealers details
    public function update(Request $request)
    {

        $subdealer = subdealer::where('user_id', $request->id)->first();

        $user = User::find($request->id);
        if($subdealer == null){

           return view('SubDealer::404');
        } 
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->subdealersUpdateRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->subdealersUpdateRules($user);
        }
        else
        {

           $rules = $this->subdealersUpdateRules($user);
        }

        $this->validate($request, $rules);  
        $subdealer->name = $request->name;
        $subdealer->address = $request->address;
        $subdealer->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $did = encrypt($user->id);
        $request->session()->flash('message', 'Dealer details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('sub.dealer.details',$did));  
    }

    //for edit page of subdealer password
    public function changePassword(Request $request)
    {
         $decrypted = Crypt::decrypt($request->id);
          $subdealer = SubDealer::where('user_id', $decrypted)->first();
         
        if($subdealer == null){
           return view('SubDealer::404');
        }
        return view('SubDealer::sub-dealer-change-password',['subdealer' => $subdealer]);
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
        $request->session()->flash('message','Password updated successfully!');
        $request->session()->flash('alert-class','alert-success');
        $user=\Auth::user();
        $user_role=$user->roles->first()->name;
        if($user_role=='sub_dealer')
        {
            return redirect()->back();
        }
        else{
            return redirect(route('subdealers'));  
        } 
     
    }
    

    //employee details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $subdealer = SubDealer::withTrashed()->where('user_id', $decrypted)->first();
        $user=User::find($decrypted);    
        
        if($subdealer == null){
           return view('SubDealer::404');
        }
        return view('SubDealer::sub-dealer-details',['subdealer' => $subdealer,'user' => $user]);
    }
     //delete Sub Dealer details from table
    public function deleteSubDealer(Request $request)
    {
        $subdealer = SubDealer::find($request->uid);
        if($subdealer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Dealer does not exist'
            ]);
        }
        $subdealer->user->delete();
        $subdealer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer deactivated successfully'
        ]);
    }

    // restore emplopyee
    public function activateSubDealer(Request $request)
    {
        $subdealer = SubDealer::withTrashed()->find($request->id);
        if($subdealer==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Dealer does not exist'
             ]);
        }

        $subdealer->user->restore();
        $subdealer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer activated successfully'
        ]);
    }

////////////////////////Sub Dealer Profile-start/////////////////////

    //Sub Dealer profile view
    public function subDealerProfile()
    {
        $sub_dealer_id = \Auth::user()->subdealer->id;
        $sub_dealer_user_id = \Auth::user()->id;
        $sub_dealer = SubDealer::withTrashed()->where('id', $sub_dealer_id)->first();
        $user=User::find($sub_dealer_user_id); 
        if($sub_dealer == null)
        {
           return view('SubDealer::404');
        }
        return view('SubDealer::sub-dealer-profile',['sub_dealer' => $sub_dealer,'user' => $user]);
    }

/////////////////////////////////Sub Dealer Profile-end////////////////////

    public function subdealerCreateRules(){
        $rules = [
            'name' => 'required|max:50',
            'address' => 'required|max:150',
            'username' => 'required|unique:users',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
        ];
        return  $rules;
    }

    public function subdealerCreateRulesRayfleet(){
        $rules = [
            'name' => 'required|max:50',
            'address' => 'required|max:150',
            'username' => 'required|unique:users',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
        ];
        return  $rules;
    }

    //validation for employee updation
    public function subdealersUpdateRules($user)
    {
        $rules = [
            'name' => 'required|max:50',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'address' => 'required|max:150'
        ];
        return  $rules;
    }

    //validation for employee updation
    public function subdealersUpdateRulesRayfleet($user)
    {
        $rules = [
            'name' => 'required|max:50',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'address' => 'required|max:150' 
        ];
        return  $rules;
    }

    public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }

    public function temporaryCertificate()
    {
        $sub_dealer_id  =   \Auth::user()->subdealer->id;
        $data = TemporaryCertificate::select('id','details')->where('user_id',$sub_dealer_id)->get();
        return view('SubDealer::temporary-certificates',['details' => $data]);
    }

    public function temporaryCertificatecreate()
    {
        $sub_dealer_id  =   \Auth::user()->subdealer->id;
        $clients        =   Client::select('id','name')->where('sub_dealer_id',$sub_dealer_id)->get();
        return view('SubDealer::temporary-certificate-create',['user_id' => $sub_dealer_id,'clients' => $clients]);
    }

    public function getOwner(Request $request)
    {
        $client_name  =   $request->id;
        return Client::select('id','name','address')->where('name',$client_name)->first();
    }

    public function certificateDetailedview(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $data = TemporaryCertificate::select('id','details')->where('id',$decrypted)->first();
        return view('SubDealer::temporary-certificates-view',['data' => $data]);
    }

    public function temporaryCertificatedownload(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        if($decrypted != null)
        {
            $data = TemporaryCertificate::select('id','details')->where('id',$decrypted)->first();
            $pdf  =   PDF::loadView('SubDealer::temporary-certificate-download',['data' => $data]);
            return $pdf->download('temporary-certificate.pdf');
        }
        else
        {
            $request->session()->flash('message','Something went wrong');
            $request->session()->flash('alert-class','alert-success');
            return redirect(route('temporary-certificate-sub-dealer'));
        }
    }

    public function temporaryCertificatesave(Request $request)
    {
        $detail['plan_name']                                =   $request->plan;
        $detail['client_name']                              =   $request->client;
        $detail['imei']                                     =   $request->imei;
        $detail['device_model']                             =   $request->model;
        $detail['manufacturer_name']                        =   $request->manufacturer;
        $detail['cdac_certification_number']                =   $request->cdac;
        $detail['vehicle_registration_number']              =   $request->register_number;
        $detail['vehicle_engine_number']                    =   $request->engine_number;
        $detail['vehicle_chasis_number']                    =   $request->chassis_number;
        $detail['owner_name']                               =   $request->owner_name;
        $detail['owner_address']                            =   $request->owner_address;
        $detail['device_expected_date_of_installation']     =   $request->job_date;
        $json_details                                       =   json_encode($detail);
        $details                                            =   TemporaryCertificate::create([
                                                                    'user_id' => $request->user_id,
                                                                    'details' => $json_details,
                                                                ]);
        $request->session()->flash('message','Temporary installation certificate created successfully!');
        $request->session()->flash('alert-class','alert-success');
        return redirect(route('temporary-certificate-sub-dealer'));
    }
}
