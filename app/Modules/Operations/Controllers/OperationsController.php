<?php
namespace App\Modules\Operations\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Operations\Models\Operations;
use App\Modules\Operations\Models\VehicleModels;
use App\Modules\Operations\Models\VehicleMake;
use App\Modules\Servicer\Models\ServiceCenter;
use App\Modules\Servicer\Models\ServiceStore;
use App\Modules\Operations\Models\StoreKeeper;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class OperationsController extends Controller {


    public function create()
    {
        $service_in = ServiceCenter::orderby('created_at', 'desc')->get();
       return view('Operations::operations-create',['service'=>$service_in]);
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
                'mobile' => $request->mobile_number,
                'status' => 1,
                'role_id'=>11,
                'password' => bcrypt($request->password),
            ]);
            $operations = Operations::create([
                'user_id' => $user->id,
                'root_id'=>$root_id,
                'name' => $request->name,
                'address' => $request->address,
                'service_center_id'=>$request->service_center_id
            ]);
            User::where('username', $request->username)->first()->assignRole('operations');

        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New operations created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('operations'));
    }
    public function operationsListPage()
    {
        return view('Operations::operations-list');
    }
    public function getOperations()
    {
        $operations = Operations::select(
            'id',
            'user_id',
            'name',
            'address',
            'deleted_at',
            'service_center_id'
        )
        ->withTrashed()
        ->with('user:id,email,mobile,deleted_at')
        ->with('center:id,name')
       
        ->orderBy('created_at','DESC')
        ->get();
        return DataTables::of($operations)
        ->addIndexColumn()
        ->addColumn('service_center_id', function ($operations) {
            return optional($operations->center)->name ?? '';
        })
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
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $operations = Operations::where('user_id', $request->id)->first();

        if($operations == null){
           return view('Operations::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->operationsUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->operationsUpdatesRules($user);
        }
        else
        {
           $rules = $this->operationsUpdatesRules($user);
        }
        $this->validate($request, $rules);
        $operations->name = $request->name;
        $operations->address = $request->address;
        $operations->save();
        $user->mobile = $request->mobile_number;
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

    public function changeStoreKeeperPassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $operations = StoreKeeper::where('user_id', $decrypted)->first();
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

    public function changeProfilePassword(Request $request)
    {
         $decrypted = Crypt::decrypt($request->id);
          $trader = Trader::where('user_id', $decrypted)->first();

        if($trader == null){
           return view('Trader::404');
        }
        return view('Trader::trader-profile-change-password',['trader' => $trader]);
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
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->operationProfileUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->operationProfileUpdatesRules($user);
        }
        else
        {
           $rules = $this->operationProfileUpdatesRules($user);
        }
        $this->validate($request, $rules);
        $operation->name = $request->name;
        $operation->address = $request->address;
        $operation->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $request->session()->flash('message', 'Your details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('operations.profile'));
    }
    public function vehicleModelsCreate()
    {
        $vehicle_make=VehicleMake::select('id','name')
        ->get();
       return view('Operations::vehicle-models-create',['vehicle_makes'=>$vehicle_make]);
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
                'name'              => $request->name,
                'vehicle_make_id'   => $request->vehicle_make,
                'fuel_capacity'     => $request->fuel_capacity,
                'fuel_min'          => $request->fuel_min,
                'fuel_25'           => $request->fuel_25,
                'fuel_50'           => $request->fuel_50,
                'fuel_75'           => $request->fuel_75,
                'fuel_max'          => $request->fuel_max,
            ]);
        }

        $request->session()->flash('message', 'New vehicle models created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('vehicle.models'));
    }
     //Display employee details
    public function vehicleModelsListPage()
    {
        return view('Operations::vehicle-models-list');
    }
    //returns employees as json
    public function getVehicleModels()
    {
        $vehicle_models = VehicleModels::select(
            'id',
            'name',
            'vehicle_make_id',
            'fuel_capacity',
            'fuel_min',
            'fuel_25',
            'fuel_50',
            'fuel_75',
            'fuel_max',
            'deleted_at'
        )
        ->withTrashed()
        ->with('vehicleMake:id,name')
        ->get();
        return DataTables::of($vehicle_models)
        ->addIndexColumn()
        ->addColumn('action', function ($vehicle_models) {
             $b_url = \URL::to('/');
            if($vehicle_models->deleted_at == null){
            return "
            <a href=".$b_url."/vehicle-models/".Crypt::encrypt($vehicle_models->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>

            ";
            }else{
            return "";
            }
        })
        ->rawColumns(['link', 'action','working_status'])
        ->make();
    }
//////////////////Vehicle Model edit/////////////
    public function modelEdit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $vehicle_models = VehicleModels::where('id', $decrypted)->first();
        $vehicle_make=VehicleMake::select('id','name')
        ->get();
        if($vehicle_models == null){
            return view('Operations::404');
        }
        return view('Operations::vehicle-models-edit',['vehicle_models' => $vehicle_models,'vehicle_makes' => $vehicle_make]);
    }
    public function modelUpdate(Request $request)
    {
        $vehicle_models = VehicleModels::where('id', $request->id)->first();
        if($vehicle_models == null){
           return view('Operations::404');
        }
        $rules = $this->vehiclemodelsUpdatesRules($vehicle_models);
        $this->validate($request, $rules);
        $vehicle_models->name               = $request->name;
        $vehicle_models->vehicle_make_id    = $request->vehicle_make;
        $vehicle_models->fuel_capacity      = $request->fuel_capacity;
        $vehicle_models->fuel_min           = $request->fuel_min;
        $vehicle_models->fuel_25            = $request->fuel_25;
        $vehicle_models->fuel_50            = $request->fuel_50;
    $vehicle_models->fuel_75                = $request->fuel_75;
        $vehicle_models->fuel_max           = $request->fuel_max;
        $vehicle_models->save();
        $did                                = encrypt($vehicle_models->id);
        $request->session()->flash('message', 'vehicle models details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('vehicle.models'));
    }
    public function disableVehicleModels(Request $request)
    {
        $vehicle_models = VehicleModels::find($request->id);
        if($vehicle_models == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'vehicle model does not exist'
            ]);
        }
        $vehicle_models->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Vehicle model disabled successfully'
        ]);
    }
    public function enableVehicleModels(Request $request)
    {
        $vehicle_models = VehicleModels::withTrashed()->find($request->id);
        if($vehicle_models==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Vehicle model does not exist'
            ]);
        }
        $vehicle_models->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Vehicle model enabled successfully'
        ]);
    }











////////////////////////Dealer Profile-end////////////////

     public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }
    //validation for employee creation
    public function vehicle_model_create_rules()
    {
        $rules = [
            'name' => 'required',
            'vehicle_make'=> 'required',
            'fuel_capacity' => 'required',
            'fuel_min' => 'required',
            'fuel_25' => 'required',
            'fuel_50' => 'required',
            'fuel_75' => 'required',
            'fuel_max' => 'required',

        ];
        return  $rules;
    }
    //validation for employee updation
    public function operationsUpdatesRules($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
        ];
        return  $rules;
    }
    public function operationsUpdatesRulesRayfleet($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
        ];
        return  $rules;
    }

    public function operationProfileUpdatesRules($user){
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }

    public function operationProfileUpdatesRulesRayfleet($user){
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }
    public function passwordUpdateRules()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }
    //user create rules
    public function user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile_number' => 'required|string|unique:users,mobile|min:10|max:10',
        ];
        return  $rules;
    }

    public function rayfleet_user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile_number' => 'required|string|unique:users,mobile|min:11|max:11'
        ];
        return  $rules;
    }
    public function vehiclemodelsUpdatesRules($vehicle_models)
    {
        $rules = [
            'name' => 'required',
            'vehicle_make' => 'required',
            'fuel_capacity' => 'required',
            'fuel_min' => 'required',
            'fuel_25' => 'required',
            'fuel_50' => 'required',
            'fuel_75' => 'required',
            'fuel_max' => 'required'

        ];
        return  $rules;
    }

    public function getAddress(Request $request)
    {
        $service_in = ServiceCenter::find($request->centerId);
        if($service_in ){

            return response()->json([
                'status' => 1,
                 'address'=>$service_in->address
            ]);
        }
    }

    //store Keeper

    public function storekeeperListPage()
    {
        return view('Operations::storekeeper-list');
    }
    public function getStoreKeeper()
    {
        $operations = StoreKeeper::select(
            'id',
            'user_id',
            'name',
            'address',
            'deleted_at',
            'store_id'
        )
        ->withTrashed()
        ->with('user:id,email,mobile,deleted_at')
       
        ->orderBy('created_at','DESC')
        ->get();
        return DataTables::of($operations)
        ->addIndexColumn()
        ->addColumn('store_id', function ($operations) {
            if( $operations->store_id){
                return $operations->stores->name;
            }else{
                return '--';
            }
           
        })
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
            <a href=".$b_url."/storekeeper/".Crypt::encrypt($operations->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <a href=".$b_url."/storekeeper/".Crypt::encrypt($operations->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/storekeeper/".Crypt::encrypt($operations->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>

            ";
            }else{
            return "";
            }
        })
        ->rawColumns(['link', 'action','working_status'])
        ->make();
    }
    public function createStoreKeeper()
    {
        $service_in = ServiceStore::orderby('created_at', 'desc')->get();
       return view('Operations::storekeeper-create',['service'=>$service_in]);
    }

    public function saveStoreKeeper(Request $request)
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
                'mobile' => $request->mobile_number,
                'status' => 1,
                'role_id'=>11,
                'password' => bcrypt($request->password),
            ]);
            $operations = StoreKeeper::create([
                'user_id' => $user->id,
                'root_id'=>$root_id,
                'name' => $request->name,
                'address' => $request->address,
                'store_id'=>$request->store_id
            ]);
            User::where('username', $request->username)->first()->assignRole('StoreKeeper');

        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New Store keeper created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('store-keeper'));
    }
}
