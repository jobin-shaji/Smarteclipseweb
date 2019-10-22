<?php

namespace App\Modules\Root\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\EmployeeDesignation;
use App\Modules\Employee\Models\EmploymentType;
use App\Modules\Employee\Models\BloodGroup;
use App\Modules\Depot\Models\State;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use DB;
use App\Modules\User\Models\User;

class RootController extends Controller {

    //All states 
    public function statesListPage()
    {
        return view('Root::states-list');
    }


    //returns states as json 
    public function getStates()
    {
        $states = State::select(
                    'id',
                    'name')->get();
        return DataTables::of($states)
            ->addIndexColumn()
            ->addColumn('action', function ($state) {
                $b_url = \URL::to('/'); 
                return "
                    <a href=".$b_url."/state/".$state->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    public function StateDetails(Request $request){
        $state = State::find($request->id);
        $users = $state->users();
        return view('Root::state-details',compact(['state','users']));
    }

    public function createUser(Request $request){
        $rules = $this->state_user_add_rules();
        $request->validate($rules);

         $user =  DB::table('users')->insert([
            'username' => $request->username,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 1,
            'state_id' => $request->id
        ]);

        if($user){
            User::where('username',$request->username)->first()->assignRole('state');
            $request->session()->flash('message', 'User created successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
        }

        return back();
    }

    public function changeRootPassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $user = User::where('id', $decrypted)->first();
        if($user == null){
           return view('Root::404');
        }
        return view('Root::root-change-password',['user' => $user]);
    }

    //update password
    public function updateRootPassword(Request $request)
    {
        $user=User::find($request->id);
        if($user== null){
            return view('Root::404');
        }
        $did=encrypt($user->id);
        $rules=$this->updateRootPasswordRule();
        $this->validate($request,$rules);
        $user->password=bcrypt($request->password);
        $user->save();
        $request->session()->flash('message','Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('root.change.password',$did));  
    }

    public function updateRootPasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
    }

    //rules for adding a state user
    public function state_user_add_rules()
    {
        $rules=[
        'username' => 'required|string|max:255|min:5|unique:users',
        'password' => 'required|min:6', 
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required'
             ];

        return $rules;
    }

}
