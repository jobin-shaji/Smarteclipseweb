<?php

namespace App\Modules\Root\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\EmployeeDesignation;
use App\Modules\Employee\Models\EmploymentType;
use App\Modules\Employee\Models\BloodGroup;
use App\Modules\Depot\Models\State;
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
                return "
                    <a href=/state/".$state->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
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
