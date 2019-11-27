<?php
namespace App\Modules\Operations\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Operations\Models\Operations;
use App\Modules\Operations\Models\VehicleMake;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class VehicleMakeController extends Controller {
    public function create()
    {
       return view('Operations::vehicle-make-create');
    }
    public function save(Request $request)
    {
        $rules = $this->vehicle_make_rules();
        $this->validate($request, $rules);       
        $vehicle = VehicleMake::create([
            'name' => $request->name
        ]);
        $request->session()->flash('message', 'created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle.make.create')); 
    }
////////////////////////////operations list////////////////////////

     //Display employee details 
    public function vehicleMakeListPage()
    {
        return view('Operations::vehicle-make-list');
    }
    //returns employees as json 
    public function getVehicleMake()
    {
        $vehicle_make = VehicleMake::select(
            'id', 
            'name',                                                           
            'deleted_at'
        )
        ->withTrashed()
        ->get();
        return DataTables::of($vehicle_make)
        ->addIndexColumn()
        ->addColumn('working_status', function ($vehicle_make) {
            if($vehicle_make->deleted_at == null){ 
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disableVehicleMake(".$vehicle_make->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
            ";
            }else{ 
            return "
                <b style='color:#FF0000';>Disabled</b>
                <button onclick=enableVehicleMake(".$vehicle_make->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Enable </button>
            ";
            }
        })
        ->addColumn('action', function ($vehicle_make) {
             $b_url = \URL::to('/');
            if($vehicle_make->deleted_at == null){ 
            return "
            <a href=".$b_url."/vehicle-make/".Crypt::encrypt($vehicle_make->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/vehicle-make/".Crypt::encrypt($vehicle_make->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
           
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
        $operations = VehicleMake::where('user_id', $decrypted)->first();
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
        $vehicle_make = VehicleMake::where('id', $decrypted)->first();
        
        if($vehicle_make == null){
            return view('Operations::404');
        }
        return view('Operations::vehicle-make-edit',['vehicle_make' => $vehicle_make]);
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


     public function vehicleModelsCreate()
    {
       return view('Operations::vehicle-models-create');
    }
    //upload dealer details to database table
    public function vehicleModelsSave(Request $request)
    {
        // \Auth::user()->root->first()->id
        $root_id=\Auth::user()->id;
        if($request->user()->hasRole('operations')){
            $rules = $this->vehicle_model_create_rules();
            $this->validate($request, $rules);
            $vehicle_models = VehicleModels::create([
                'vehicle_model' => $request->name,
                'fuel_min' => $request->fuel_min,
                'fuel_max' => $request->fuel_max,
            ]);                       
        }
        
        $request->session()->flash('message', 'New vehicle models created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle.models.create')); 
    }
     //Display employee details 
    public function vehicleModelsListPage()
    {
        return view('Operations::vehicle-models-list');
    }
    //returns employees as json 
    public function getVehicleModels()
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













////////////////////////Dealer Profile-end////////////////

     public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
    }
    //validation for employee creation
    public function vehicle_model_create_rules()
    {
        $rules = [
            'name' => 'required',       
            'fuel_min' => 'required',       
            'fuel_max' => 'required',
           
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
    public function vehicle_make_rules(){
        $rules = [
            'name' => 'required'
        ];
        return  $rules;
    }
}
