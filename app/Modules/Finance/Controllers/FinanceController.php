<?php
namespace App\Modules\Finance\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Modules\Finance\Models\Finance;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class FinanceController extends Controller {


    public function create()
    {
        echo "here";die;
       return view('Finance::finance-create');
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
                 $rules = $this->rayfleet_finance_create_rules();
            }
            else if (strpos($url, $eclipse_key) == true) {
                 $rules = $this->finance_create_rules();
            }
            else
            {
               $rules = $this->finance_create_rules();
            }
            $this->validate($request, $rules);
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile_number,
                'status' => 1,
                'password' => bcrypt($request->password),
            ]);
            $finance = finance::create([
                'user_id' => $user->id,
                'root_id'=>$root_id,
                'name' => $request->name,
                'address' => $request->address,
            ]);
            User::where('username', $request->username)->first()->assignRole('Finance');

        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New Finance person created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('Finance'));
    }
    public function financeListPage()
    {
        return view('Finance::finance-list');
    }
    public function getfinances()
    {
        $finances = Finance::select(
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
        return DataTables::of($finances)
        ->addIndexColumn()
        ->addColumn('working_status', function ($finances) {
            if($finances->user->deleted_at == null){
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disablefinance(".$finances->user_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
            ";
            }else{
            return "
                <b style='color:#FF0000';>Disabled</b>
                <button onclick=enablefinance(".$finances->user_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Enable </button>
            ";
            }
        })
        ->addColumn('action', function ($finances) {
             $b_url = \URL::to('/');
            if($finances->user->deleted_at == null){
            return "
            <a href=".$b_url."/finance/".Crypt::encrypt($finances->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <a href=".$b_url."/finance/".Crypt::encrypt($finances->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/finance/".Crypt::encrypt($finances->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>

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
        $finance = Finance::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);

        if($finance == null){
            return view('Sales::404');
        }
        return view('Finance::finance-details',['Finance' => $finance,'user' => $user]);
    }
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $finance = Finance::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);
        if($finance == null){
            return view('Sales::404');
        }
        return view('Finance::finance-edit',['finance' => $finance,'user' => $user]);
    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $finance = Finance::where('user_id', $request->id)->first();

        if($finance == null){
           return view('Sales::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->financeUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->financeUpdatesRules($user);
        }
        else
        {
           $rules = $this->financeUpdatesRules($user);
        }
        $this->validate($request, $rules);
        $finance->name = $request->name;
        $finance->address = $request->address;
        $finance->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $did = encrypt($user->id);
        $request->session()->flash('message', 'finance details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('finance.edit',$did));
    }
    //for edit page of employee password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $finance = Finance::where('user_id', $decrypted)->first();
        if($finance == null){
           return view('Sales::404');
        }
        return view('Sales::sales-change-password',['finance' => $finance]);
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
        return  redirect(route('Finance.change-password',$did));
    }

    //delete dealer details from table
    public function disableFinance(Request $request)
    {
        $sales_user = User::find($request->id);
        $sales = Finance::select('id')->where('user_id',$sales_user->id)->first();
        if($sales_user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'finance does not exist'
            ]);
        }
        $sales_user->delete();
        $sales->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'finance disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableFinance(Request $request)
    {
        $sales_user = User::withTrashed()->find($request->id);
        $sales = finance::withTrashed()->select('id')->where('user_id',$sales_user->id)->first();
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
    public function financeProfile()
    {
        $finance_id = \Auth::user()->finance->id;
        $finance_user_id = \Auth::user()->id;
        $finance = Finance::withTrashed()->where('id', $finance_id)->first();
        $user=User::find($finance_user_id);
        if($finance == null)
        {
           return view('Sales::404');
        }
        return view('Finance::finance-profile',['finance' => $finance,'user' => $user]);
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

    //for edit page of finance profile
    public function editFinanceProfile()
    {
        $finance_id=\Auth::user()->finance->id;
        $finance = Finance::where('id', $Finance_id)->first();
        if($finance == null){
            return view('Sales::404');
        }
        return view('Finance::finance-profile-edit',['finance' => $finance]);
    }
    //update  profile details
    public function updateFinanceProfile(Request $request)
    {
        $finance = Finance::find($request->id);
        $user = User::where('id', $finance->user_id)->first();
        if($finance == null){
           return view('Sales::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->financeProfileUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->financeProfileUpdatesRules($user);
        }
        else
        {
           $rules = $this->financeProfileUpdatesRules($user);
        }
        $this->validate($request, $rules);
        $finance->name = $request->name;
        $finance->address = $request->address;
        $finance->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $request->session()->flash('message', 'Your details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('finance.profile'));
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
    public function financeUpdatesRules($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
        ];
        return  $rules;
    }
    public function financeUpdatesRulesRayfleet($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
        ];
        return  $rules;
    }

    public function financeProfileUpdatesRules($user){
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }

    public function financeProfileUpdatesRulesRayfleet($user){
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
    public function finance_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile_number' => 'required|string|unique:users,mobile|min:10|max:10',
        ];
        return  $rules;
    }

    public function finance_user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile_number' => 'required|string|unique:users,mobile|min:11|max:11'
        ];
        return  $rules;
    }
    
}
