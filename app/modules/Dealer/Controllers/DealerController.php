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
        ->with('user:id,email,mobile')
        ->get();
        return DataTables::of($dealers)
        ->addIndexColumn()
        ->addColumn('action', function ($dealers) {
            if($dealers->deleted_at == null){ 
            return "
            <a href=/dealers/".Crypt::encrypt($dealers->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <a href=/dealers/".Crypt::encrypt($dealers->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=/dealers/".Crypt::encrypt($dealers->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
            <button onclick=delDealers(".$dealers->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
            }else{ 
            return "<a href=/dealers/".Crypt::encrypt($dealers->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <button onclick=activateDealer(".$dealers->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link', 'action'])
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
            $rules = $this->user_create_rules();
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
        $request->session()->flash('message', 'New dealer created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('dealers')); 
    }
    //Dealer details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        // $dealer = Dealer::find($decrypted);
        $dealer = Dealer::select(
            'id', 
            'user_id',                      
            'name',                   
            'address',                                        
            'deleted_at'
        )
        ->withTrashed()
        ->with('user:id,email,mobile')
        ->where('user_id',$decrypted)
        ->get();
        if($dealer == null){
            return view('Dealer::404');
        }
        return view('Dealer::dealer-details',['dealer' => $dealer]);
    }
    //for edit page of Dealers
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        // $dealers = Dealer::find($decrypted);
        $dealers = Dealer::select(
            'id', 
            'user_id',                      
            'name',                   
            'address',                                        
            'deleted_at'
        )
        ->withTrashed()
        ->with('user:id,email,mobile')
        ->where('user_id',$decrypted)
        ->get();
        if($dealers == null){
            return view('Dealer::404');
        }
        return view('Dealer::dealer-edit',['dealers' => $dealers]);
    }
    //update dealers details
    public function update(Request $request)
    { 
       $dealer = Dealer::where('user_id', $request->id)->first();
        if($dealer == null){
           return view('Dealer::404');
        } 
        $rules = $this->dealersUpdateRules($dealer);
        $this->validate($request, $rules);      
        $dealer->name = $request->name;
        $dealer->save();
        $user = User::find($request->id);
        $user->mobile = $request->phone_number;
        $user->save();
        $did = encrypt($user->id);
        $request->session()->flash('message', 'Dealer details updated successfully!');
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
        $rules=$this->updateDepotUserRuleChangePassword($subdealer);
        $this->validate($request,$rules);
        $subdealer->password=bcrypt($request->password);
        $subdealer->save();
        $request->session()->flash('message','Dealer Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('dealers.change-password',$did));
    }
    public function updateDepotUserRuleChangePassword()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
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
    //validation for employee creation
    public function dealerCreateRules()
    {
        $rules = [
            'name' => 'required',       
            'address' => 'required',       
            'phone_number' => 'required|numeric',
            'username' => 'nullable|string|max:20|unique:dealers',
            'password' => 'nullable|string|min:6|confirmed',
        ];
        return  $rules;
    }
    //validation for employee updation
    public function dealersUpdateRules($dealer)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|numeric'       
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
            'mobile' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        return  $rules;
    }
}
