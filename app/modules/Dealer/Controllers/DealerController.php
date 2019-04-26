<?php

namespace App\Modules\Dealer\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Dealer\Models\Dealer;
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
                    
                    'name',                   
                    'address',                    
                    'phone_number',
                    'username',
                    'deleted_at',
                    'password')
                    ->withTrashed()
                   ->get();
        return DataTables::of($dealers)
            ->addIndexColumn()
            ->addColumn('action', function ($dealers) {
                if($dealers->deleted_at == null){ 
                
                    return "
                     <a href=/dealers/".Crypt::encrypt($dealers->id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
                     <a href=/dealers/".Crypt::encrypt($dealers->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <a href=/dealers/".Crypt::encrypt($dealers->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                   
                    <button onclick=delDealers(".$dealers->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
                 }else{ 
                  
                    return "
                  
                    <a href=/dealers/".Crypt::encrypt($dealers->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateDealer(".$dealers->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }


//     //employee creation page
    public function create()
    {
       return view('Dealer::dealer-create');
    }

    //upload employee details to database table
    public function save(Request $request)
    {
        $rules = $this->dealerCreateRules();
        $this->validate($request, $rules);
        $dealer = Dealer::create([
            
            'name' => $request->name,            
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'username' => $request->username,
            'status'=>1,
            'password' => $request->password
            // 'created_by' => \Auth::user()->id
        ]);
         $eid= encrypt($dealer->id);
        $request->session()->flash('message', 'New dealer created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
         return redirect(route('dealer.details',$eid));
    }

    //employee details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        $dealer = Dealer::find($decrypted);
        if($dealer == null){
           return view('Dealer::404');
        }
       return view('Dealer::dealer-details',['dealer' => $dealer]);
    }

    //for edit page of Dealers
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        $dealers = Dealer::find($decrypted);
       
       
        
        if($dealers == null){
           return view('Dealer::404');
        }
       return view('Dealer::dealer-edit',['dealers' => $dealers]);
    }

    //update dealers details
    public function update(Request $request)
    {
        $dealer = Dealer::find($request->id);
        if($dealer == null){
           return view('Dealer::404');
        } 
        $rules = $this->dealersUpdateRules($dealer);
        $this->validate($request, $rules);
       
        $dealer->name = $request->name;
       
        $dealer->phone_number = $request->phone_number;
        $dealer->save();
        $did = encrypt($dealer->id);
        $request->session()->flash('message', 'Dealer details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('dealers.edit',$did));  
    }

//     //for edit page of employee password
    public function changePassword(Request $request)
    {
         $decrypted = Crypt::decrypt($request->id);
        $dealer = Dealer::find($decrypted);
        if($dealer == null){
           return view('Dealer::404');
        }
        return view('Dealer::dealer-change-password',['dealer' => $dealer]);
    }

    //update password
    public function updatePassword(Request $request)
    {
        $dealer = Dealer::find($request->id);
        $did = encrypt($dealer->id);
        if($dealer == null){
           return view('Dealer::404');
        }
        $rules = $this->passwordUpdateRules();
        $this->validate($request, $rules);
        $old_password=$dealer->password;
        $entered_old_password=$request->old_password;
        if($old_password==$entered_old_password)
        {
            $dealer->password = $request->password;
            $dealer->save();
            $did = encrypt($dealer->id);
            $request->session()->flash('message', 'Password updated successfully!');
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('dealers.edit',$did));   
        }
        else
        {
            $request->session()->flash('message', 'Old password is incorrect!');
            $request->session()->flash('alert-class', 'alert-danger'); 
            return redirect(route('dealer.change-password',$did));
        }
         
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

    public function passwordUpdateRules(){
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
  }


}
