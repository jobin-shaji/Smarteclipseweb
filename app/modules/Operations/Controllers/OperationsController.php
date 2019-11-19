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
    //Dealer details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $dealer = Dealer::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);   
        
        if($dealer == null){
            return view('Dealer::404');
        }
        return view('Dealer::dealer-details',['dealer' => $dealer,'user' => $user]);
    }
    //for edit page of Dealers
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $dealers = Dealer::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);

        if($dealers == null){
            return view('Dealer::404');
        }
        return view('Dealer::dealer-edit',['dealers' => $dealers,'user' => $user]);
    }
    //update dealers details
    public function update(Request $request)
    {  
        $user = User::find($request->id);
        $dealer = Dealer::where('user_id', $request->id)->first();
        if($dealer == null){
           return view('Dealer::404');
        } 
        $rules = $this->dealersUpdatesRules($user);
        $this->validate($request, $rules);   
        $dealer->name = $request->name;
        $dealer->save();
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
        $rules=$this->updatePasswordRule();
        $this->validate($request,$rules);
        $subdealer->password=bcrypt($request->password);
        $subdealer->save();
        $request->session()->flash('message','Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('dealers.change-password',$did));
    }

    //delete dealer details from table
    public function disableDealer(Request $request)
    {
        $dealer_user = User::find($request->id);
        $dealer = Dealer::select('id')->where('user_id',$dealer_user->id)->first();
        if($dealer_user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Dealer does not exist'
            ]);
        }
        $dealer_user->delete();
        $dealer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableDealer(Request $request)
    {
        $dealer_user = User::withTrashed()->find($request->id);
        $dealer = Dealer::withTrashed()->select('id')->where('user_id',$dealer_user->id)->first();
        if($dealer_user==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Dealer does not exist'
            ]);
        }
        $dealer_user->restore();
        $dealer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer enabled successfully'
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
    public function dealerProfile()
    {
        $dealer_id = \Auth::user()->dealer->id;
        $dealer_user_id = \Auth::user()->id;
        $dealer = Dealer::withTrashed()->where('id', $dealer_id)->first();
        $user=User::find($dealer_user_id); 
        if($dealer == null)
        {
           return view('Dealer::404');
        }
        return view('Dealer::dealer-profile',['dealer' => $dealer,'user' => $user]);
    }

    //for edit page of Dealer profile
    public function editDealerProfile()
    {
        $dealer_id=\Auth::user()->dealer->id;
        $dealer = Dealer::where('id', $dealer_id)->first();
        if($dealer == null){
            return view('Dealer::404');
        }
        return view('Dealer::dealer-profile-edit',['dealer' => $dealer]);
    }
    //update dealer profile details
    public function updateDealerProfile(Request $request)
    {  
        $dealer = Dealer::find($request->id);
        $user = User::where('id', $dealer->user_id)->first();
        if($dealer == null){
           return view('Dealer::404');
        } 
        $rules = $this->dealerProfileUpdatesRules($user);
        $this->validate($request, $rules);   
        $dealer->name = $request->name;
        $dealer->address = $request->address;
        $dealer->save();
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();
        $request->session()->flash('message', 'Your details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('dealer.profile'));  
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
    public function dealersUpdatesRules($user)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,       
        ];
        return  $rules;
    }
    public function dealerProfileUpdatesRules($user){
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
