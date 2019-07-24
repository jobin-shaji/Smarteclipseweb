<?php
namespace App\Modules\SubDealer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
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
            'deleted_at'
        )
        ->withTrashed()
        ->with('dealer:id,user_id,name')
        ->with('user:id,email,mobile,deleted_at')
        ->where('deleted_at',NULL)
        ->get();
        return DataTables::of($subdealers)
        ->addIndexColumn()      
        ->addColumn('working_status', function ($subdealers) {
            if($subdealers->user->deleted_at == null){ 
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
        $sub_dealer = User::find($request->id);
        if($sub_dealer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Sub Dealer does not exist'
            ]);
        }
        $sub_dealer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Sub Dealer disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableSubDealer(Request $request)
    {
        $sub_dealer = User::withTrashed()->find($request->id);
        if($sub_dealer==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Sub Dealer does not exist'
            ]);
        }
        $sub_dealer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Sub Dealer enabled successfully'
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
        $rules = $this->user_create_rules();
        $this->validate($request, $rules);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
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
        $request->session()->flash('message', 'New dealer created successfully!'); 
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
        ->with('user:id,email,mobile')
        ->where('dealer_id',$dealer)
        ->get();
        return DataTables::of($subdealers)
        ->addIndexColumn()
        ->addColumn('action', function ($subdealers) {
            $b_url = \URL::to('/');
        if($subdealers->deleted_at == null){ 
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
        if($subdealer == null){
           return view('SubDealer::404');
        } 
        $rules = $this->dealersUpdateRules($subdealer);
        $this->validate($request, $rules);       
        $subdealer->name = $request->name;
        $subdealer->save();
        $user = User::find($request->id);
        $user->mobile = $request->phone_number;
        $user->save();
        $did = encrypt($user->id);
        // $subdealer->phone_number = $request->phone_number;       
        // $did = encrypt($subdealer->id);
        $request->session()->flash('message', 'SubDealer details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('sub.dealers.edit',$did));  
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
        $rules=$this->updateDepotUserRuleChangePassword($subdealer);
        $this->validate($request,$rules);
        $subdealer->password=bcrypt($request->password);
        $subdealer->save();
        $request->session()->flash('message','SubDealer Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('sub.dealers.change-password',$did));
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
                'message' => 'Sub Dealer does not exist'
            ]);
        }
        $subdealer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Sub Dealer deleted successfully'
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
                'message' => 'Sub Dealer does not exist'
             ]);
        }

        $subdealer->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Sub Dealer restored successfully'
        ]);
    }
 public function passwordUpdateRules(){
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
  }
    public function user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'mobile' => 'required|numeric|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        return  $rules;
    }
    public function updateDepotUserRuleChangePassword()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
    }
}
