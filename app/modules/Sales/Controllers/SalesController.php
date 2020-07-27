<?php
namespace App\Modules\Sales\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Sales\Models\Salesman;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class SalesController extends Controller {


    public function create()
    {
       return view('Sales::sales-create');
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
                 $rules = $this->rayfleet_salesman_create_rules();
            }
            else if (strpos($url, $eclipse_key) == true) {
                 $rules = $this->salesman_create_rules();
            }
            else
            {
               $rules = $this->salesman_create_rules();
            }
            $this->validate($request, $rules);
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile_number,
                'status' => 1,
                'password' => bcrypt($request->password),
            ]);
            $salesman = Salesman::create([
                'user_id' => $user->id,
                'root_id'=>$root_id,
                'name' => $request->name,
                'address' => $request->address,
            ]);
            User::where('username', $request->username)->first()->assignRole('sales');

        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New sales person created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('salesman'));
    }
    public function salesmanListPage()
    {
        return view('Sales::salesman-list');
    }
    public function getSalesmans()
    {
        $salesmans = Salesman::select(
            'id',
            'user_id',
            'name',
            'address',
            'deleted_at'
        )
        ->withTrashed()
        ->with('user:id,email,mobile,deleted_at')
        ->orderBy('created_at','DESC')
        ->get();
        return DataTables::of($salesmans)
        ->addIndexColumn()
        ->addColumn('working_status', function ($salesmans) {
            if($salesmans->user->deleted_at == null){
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disableSalesman(".$salesmans->user_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
            ";
            }else{
            return "
                <b style='color:#FF0000';>Disabled</b>
                <button onclick=enableSalesman(".$salesmans->user_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Enable </button>
            ";
            }
        })
        ->addColumn('action', function ($salesmans) {
             $b_url = \URL::to('/');
            if($salesmans->user->deleted_at == null){
            return "
            <a href=".$b_url."/salesman/".Crypt::encrypt($salesmans->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <a href=".$b_url."/salesman/".Crypt::encrypt($salesmans->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/salesman/".Crypt::encrypt($salesmans->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>

            ";
            }else{
            return "";
            }
        })
        ->rawColumns(['link', 'action','working_status'])
        ->make();
    }
    //sales creation page
    //sales details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $salesman = Salesman::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);

        if($salesman == null){
            return view('Sales::404');
        }
        return view('Sales::sales-details',['salesman' => $salesman,'user' => $user]);
    }
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $salesman = Salesman::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);
        if($salesman == null){
            return view('Sales::404');
        }
        return view('Sales::salesman-edit',['salesman' => $salesman,'user' => $user]);
    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $salesman = Salesman::where('user_id', $request->id)->first();

        if($salesman == null){
           return view('Sales::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->salesmanUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->salesmanUpdatesRules($user);
        }
        else
        {
           $rules = $this->salesmanUpdatesRules($user);
        }
        $this->validate($request, $rules);
        $salesman->name = $request->name;
        $salesman->address = $request->address;
        $salesman->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $did = encrypt($user->id);
        $request->session()->flash('message', 'Salesman details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('salesman.edit',$did));
    }
    //for edit page of employee password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $salesman = Salesman::where('user_id', $decrypted)->first();
        if($salesman == null){
           return view('Sales::404');
        }
        return view('Sales::sales-change-password',['salesman' => $salesman]);
    }
    //update password
    public function updatePassword(Request $request)
    {
        $user=User::find($request->id);
        if($user== null){
            return view('Sales::404');
        }
        $did=encrypt($user->id);
        $rules=$this->updatePasswordRule();
        $this->validate($request,$rules);
        $user->password=bcrypt($request->password);
        $user->save();
        $request->session()->flash('message','Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('salesman.change-password',$did));
    }

    //delete dealer details from table
    public function disableSalesman(Request $request)
    {
        $sales_user = User::find($request->id);
        $sales = Salesman::select('id')->where('user_id',$sales_user->id)->first();
        if($sales_user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'salesman does not exist'
            ]);
        }
        $sales_user->delete();
        $sales->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'salesman disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableSalesman(Request $request)
    {
        $sales_user = User::withTrashed()->find($request->id);
        $sales = Salesman::withTrashed()->select('id')->where('user_id',$sales_user->id)->first();
        if($sales_user==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'sales does not exist'
            ]);
        }
        $sales_user->restore();
        $sales->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'sales enabled successfully'
        ]);
    }
    public function salesmanProfile()
    {
        $salesman_id = \Auth::user()->salesman->id;
        $salesman_user_id = \Auth::user()->id;
        $salesman = Salesman::withTrashed()->where('id', $salesman_id)->first();
        $user=User::find($salesman_user_id);
        if($salesman == null)
        {
           return view('Sales::404');
        }
        return view('Sales::salesman-profile',['salesman' => $salesman,'user' => $user]);
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

    //for edit page of salesman profile
    public function editSalesmanProfile()
    {
        $salesman_id=\Auth::user()->salesman->id;
        $salesman = Salesman::where('id', $salesman_id)->first();
        if($salesman == null){
            return view('Sales::404');
        }
        return view('Sales::salesman-profile-edit',['salesman' => $salesman]);
    }
    //update  profile details
    public function updateSalesmanProfile(Request $request)
    {
        $salesman = Salesman::find($request->id);
        $user = User::where('id', $salesman->user_id)->first();
        if($salesman == null){
           return view('Sales::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->salesmanProfileUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->salesmanProfileUpdatesRules($user);
        }
        else
        {
           $rules = $this->salesmanProfileUpdatesRules($user);
        }
        $this->validate($request, $rules);
        $salesman->name = $request->name;
        $salesman->address = $request->address;
        $salesman->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $request->session()->flash('message', 'Your details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('salesman.profile'));
    }
  


////////////////////////Sales Profile-end////////////////

     public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }
 
    //validation for employee updation
    public function salesmanUpdatesRules($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
        ];
        return  $rules;
    }
    public function salesmanUpdatesRulesRayfleet($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
        ];
        return  $rules;
    }

    public function salesmanProfileUpdatesRules($user){
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }

    public function salesmanProfileUpdatesRulesRayfleet($user){
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
    public function salesman_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile_number' => 'required|string|unique:users,mobile|min:10|max:10',
        ];
        return  $rules;
    }

    public function salesman_user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile_number' => 'required|string|unique:users,mobile|min:11|max:11'
        ];
        return  $rules;
    }
    
}
