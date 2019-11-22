<?php
namespace App\Modules\Operations\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Operations\Models\Operations;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class OperationsController extends Controller {
    
    public function create()
    {
       return view('Operations::operations-create');
    }
    //upload dealer details to database table
    public function save(Request $request)
    {
        // \Auth::user()->root->first()->id
        $root_id=\Auth::user()->id;
        if($request->user()->hasRole('root')){
            $rules = $this->user_create_rules();
            $this->validate($request, $rules);
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => 1,
                'password' => bcrypt($request->password),
            ]);
            $operations = Operations::create([
                'user_id' => $user->id,
                'root_id'=>$root_id,
                'name' => $request->name,            
                'address' => $request->address,
            ]);
            User::where('username', $request->username)->first()->assignRole('operations');
            
        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New operations created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('operations')); 
    }
////////////////////////////operations list////////////////////////

     //Display employee details 
    public function operationsListPage()
    {
        return view('Operations::operations-list');
    }
    //returns employees as json 
    public function getOperations()
    {
        $operations = Operations::select(
            'id', 
            'user_id',                      
            'name',                   
            'address',                                        
            'deleted_at'
        )
        ->withTrashed()
        ->with('user:id,email,mobile,deleted_at')
        ->get();
        return DataTables::of($operations)
        ->addIndexColumn()
        ->addColumn('working_status', function ($operations) {
            if($operations->user->deleted_at == null){ 
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disableOperations(".$operations->user_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
            ";
            }else{ 
            return "
                <b style='color:#FF0000';>Disabled</b>
                <button onclick=enableOperations(".$operations->user_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Enable </button>
            ";
            }
        })
        ->addColumn('action', function ($operations) {
             $b_url = \URL::to('/');
            if($operations->user->deleted_at == null){ 
            return "
            <a href=".$b_url."/operations/".Crypt::encrypt($operations->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <a href=".$b_url."/operations/".Crypt::encrypt($operations->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/operations/".Crypt::encrypt($operations->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
           
            ";
            }else{ 
            return "";
            }
        })
        ->rawColumns(['link', 'action','working_status'])
        ->make();
    }
    //dealer creation page

























    //Dealer details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $operations = Operations::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);   
        
        if($operations == null){
            return view('Operations::404');
        }
        return view('Operations::operations-details',['operations' => $operations,'user' => $user]);
    }

    //for edit page of Dealers
    public function edit(Request $request)
    {
        // dd(1);
        $decrypted = Crypt::decrypt($request->id); 
        $operations = Operations::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);
// dd($user);
        if($operations == null){
            return view('Operations::404');
        }
        return view('Operations::operations-edit',['operations' => $operations,'user' => $user]);
    }
    //update dealers details
    public function update(Request $request)
    {  
        $user = User::find($request->id);
        $operations = Operations::where('user_id', $request->id)->first();

        if($operations == null){
           return view('Operations::404');
        } 
        $rules = $this->operationsUpdatesRules($user);
        $this->validate($request, $rules);   
        $operations->name = $request->name;
        $operations->address = $request->address;       
        $operations->save();
        $user->mobile = $request->phone_number;
        $user->email = $request->email;
        $user->save();
        $did = encrypt($user->id);
        $request->session()->flash('message', 'Operations details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('operations.edit',$did));  
    }
    //for edit page of employee password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $operations = Operations::where('user_id', $decrypted)->first();
        // $dealer = Dealer::find($decrypted);
        if($operations == null){
           return view('Operations::404');
        }
        return view('Operations::operations-change-password',['operations' => $operations]);
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
        return  redirect(route('operations.change-password',$did));
    }

    //delete dealer details from table
    public function disableOperations(Request $request)
    {
        $operations_user = User::find($request->id);
        $operations = Operations::select('id')->where('user_id',$operations_user->id)->first();
        if($operations_user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Operations does not exist'
            ]);
        }
        $operations_user->delete();
        $operations->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Operations disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableDealer(Request $request)
    {
        $operations_user = User::withTrashed()->find($request->id);
        $operations = Operations::withTrashed()->select('id')->where('user_id',$operations_user->id)->first();
        if($operations_user==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Operations does not exist'
            ]);
        }
        $operations_user->restore();
        $operations->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Opertaions enabled successfully'
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
                'message' => 'Dealer does not exist'
            ]);
        }
        $dealer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer deleted successfully'
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
                'message' => 'Dealer does not exist'
            ]);
        }
        $dealer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer restored successfully'
        ]);
    }

////////////////////////Dealer Profile-start/////////////////

    //Dealer profile view
    public function operationsProfile()
    {
        $operations_id = \Auth::user()->operations->id;
        $operations_user_id = \Auth::user()->id;
        $operations = Operations::withTrashed()->where('id', $operations_id)->first();
        $user=User::find($operations_user_id); 
        if($operations == null)
        {
           return view('Operations::404');
        }
        return view('Operations::operations-profile',['operations' => $operations,'user' => $user]);
    }

    //for edit page of operations profile
    public function editOperationsProfile()
    {
        $operations_id=\Auth::user()->operations->id;
        $operation = Operations::where('id', $operations_id)->first();
        if($operation == null){
            return view('Operations::404');
        }
        return view('Operations::operations-profile-edit',['operation' => $operation]);
    }
    //update dealer profile details
    public function updateOperationsProfile(Request $request)
    {  
        $operation = Operations::find($request->id);
        $user = User::where('id', $operation->user_id)->first();
        if($operation == null){
           return view('Operation::404');
        } 
        $rules = $this->operationProfileUpdatesRules($user);
        $this->validate($request, $rules);   
        $operation->name = $request->name;
        $operation->address = $request->address;
        $operation->save();
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();
        $request->session()->flash('message', 'Your details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('operations.profile'));  
    }

////////////////////////Dealer Profile-end////////////////

     public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
    }
    //validation for employee creation
    public function dealerCreateRules()
    {
        $rules = [
            'name' => 'required',       
            'address' => 'required',       
            'phone_number' => 'required|numeric|min:10|max:10',
            'username' => 'nullable|string|max:20|unique:dealers',
            'password' => 'nullable|string|min:6|confirmed',
        ];
        return  $rules;
    }
    //validation for employee updation
    public function operationsUpdatesRules($user)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,       
        ];
        return  $rules;
    }
    public function operationProfileUpdatesRules($user){
        $rules = [
            'name' => 'required',       
            'address' => 'required',       
            'mobile' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }
    public function passwordUpdateRules()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
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
}
