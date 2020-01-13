<?php

namespace App\Modules\Trader\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Trader\Models\Trader;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

class TraderController extends Controller 
{
    
    //Display sub dealer details 
    public function traderList()
    {
        return view('Trader::trader-list');
    }
    //returns sub dealer as json 
    public function getTraderList(Request $request)
    {
       
        $sub_dealer_id=$request->user()->subdealer->id;
        $traders = Trader::select(
        'id', 
        'user_id',
        'sub_dealer_id',                      
        'name',                   
        'address',                                       
        'deleted_at')
        ->withTrashed()
        ->with('user:id,email,mobile,deleted_at')
        ->where('sub_dealer_id',$sub_dealer_id)
        ->get();
        return DataTables::of($traders)
        ->addIndexColumn()
        ->addColumn('action', function ($traders) {
            $b_url = \URL::to('/');
        if($traders->user->deleted_at == null && $traders->deleted_at == null){ 
            return "
            <a href=".$b_url."/trader/".Crypt::encrypt($traders->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
            <a href=".$b_url."/trader/".Crypt::encrypt($traders->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/trader/".Crypt::encrypt($traders->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <button onclick=deactivateTrader(".$traders->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
        }
        else
        {                   
            return "
            <button onclick=activateTrader(".$traders->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
        }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create sub dealer
    public function createTrader()
    {
        return view('Trader::trader-create');
    }
    // save sub dealer
    public function saveTrader(Request $request)
    {
        $sub_dealer_id = \Auth::user()->subdealer->id;
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->traderCreateRulesRayfleet();
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->traderCreateRules();
        }
        else
        {
           $rules = $this->traderCreateRules();
        }
        $this->validate($request, $rules);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile_number,
            'status' => 1,
            'password' => bcrypt($request->password),
        ]);
            $trader = Trader::create([            
            'user_id' => $user->id,
            'sub_dealer_id' => $sub_dealer_id,
            'name' => ucfirst($request->name),            
            'address' => $request->address,           
           ]);
        User::where('username', $request->username)->first()->assignRole('trader');
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New Sub Dealer created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('trader')); 
    }

    // sub dealer details
    public function detailsTrader(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $trader = Trader::withTrashed()->where('user_id', $decrypted)->first();
        $user=User::find($decrypted);    
        
        if($trader == null){
           return view('Trader::404');
        }
        return view('Trader::trader-details',['trader' => $trader,'user' => $user]);
    }

    //edit sub dealer details
    public function editTrader(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $trader = Trader::withTrashed()->where('user_id', $decrypted)->first();
        $user=User::find($decrypted);        
        if($trader == null)
        {
           return view('Trader::404');
        }
        return view('Trader::trader-edit',['trader' => $trader,'user' => $user]);
    }

    //update dealers details
    public function updateTrader(Request $request)
    {
        $trader = Trader::where('user_id', $request->id)->first();
        $user = User::find($request->id);
        if($trader == null){
           return view('Trader::404');
        } 
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->traderUpdateRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->traderUpdateRules($user);
        }
        else
        {
           $rules = $this->traderUpdateRules($user);
        }

        $this->validate($request, $rules);  
        $trader->name = ucfirst($request->name);
        $trader->address = $request->address;
        $trader->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $did = encrypt($user->id);
        $request->session()->flash('message', 'Sub dealer details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('trader.details',$did));  
    }

    //for edit page of sub dealer password
    public function changeTraderPassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $trader = Trader::where('user_id', $decrypted)->first();
        if($trader == null){
           return view('Trader::404');
        }
        return view('Trader::trader-change-password',['trader' => $trader]);
    }

    //update password
    public function updateTraderPassword(Request $request)
    {
        $trader=User::find($request->id);
        if($trader== null){
            return view('Trader::404');
        }
        $did=encrypt($trader->id);
        $rules=$this->updatePasswordRule();
        $this->validate($request,$rules);
        $trader->password=bcrypt($request->password);
        $trader->save();
        $request->session()->flash('message','Password updated successfully!');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('trader.change.password',$did));
    }

     //deactivate Sub Dealer details from table
     public function deactivateTrader(Request $request)
     {
         $trader = Trader::find($request->trader_id);
         if($trader == null){
             return response()->json([
                 'status' => 0,
                 'title' => 'Error',
                 'message' => 'Dealer does not exist'
             ]);
         }
         $trader->user->delete();
         $trader->delete();
         return response()->json([
             'status' => 1,
             'title' => 'Success',
             'message' => 'Dealer deactivated successfully'
         ]);
     }
 
     // restore sub dealer details
     public function activateTrader(Request $request)
     {
         $trader = Trader::withTrashed()->find($request->trader_id);
         if($trader==null){
              return response()->json([
                 'status' => 0,
                 'title' => 'Error',
                 'message' => 'Dealer does not exist'
              ]);
         }
 
         $trader->user->restore();
         $trader->restore();
         return response()->json([
             'status' => 1,
             'title' => 'Success',
             'message' => 'Dealer activated successfully'
         ]);
     }
    
    public function traderCreateRules(){
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'username' => 'required|unique:users',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        return  $rules;
    }

    public function traderCreateRulesRayfleet(){
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'username' => 'required|unique:users',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        return  $rules;
    }

    public function traderUpdateRules($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'address' => 'required'

            
        ];
        return  $rules;
    }

    public function traderpdateRulesRayfleet($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'address' => 'required'


            
        ];
        return  $rules;
    }

    public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
    }

}
