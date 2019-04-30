<?php

namespace App\Modules\User\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;
use App\Modules\Depot\Models\DepotUser;
use DataTables;

class ClientController extends Controller {
    
    //user create page 
    public function create()
    {
        return view('User::user-create');
    }

    //creating a user 
    public function store(Request $request)
    {
        $rules = $this->user_create_rules();
        $this->validate($request, $rules);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if($request->user()->hasRole('depot')){
            $depot_user = DepotUser::create([
                'depot_id' => $request->user()->depot->first()->id,
                'user_id' => $user->id,
            ]);
        }

        $user->assignRole('waybill');

        $request->session()->flash('message', 'New user created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('users.details',$user->id));
    }

    //user list page 
    public function index()
    {
       $users = User::all(); 
       return view('User::user-list',['users' => $users]);
    }

    //user edit page 
    public function edit(Request $request){     
       $user = User::find($request->id);
        if($user == null){
           return view('User::404');
        }
       return view('User::user-edit',['user' => $user]);
    }

    //user details page 
    public function details(Request $request)
    {
        $user = User::find($request->id);
        if($user == null){
           return view('User::404');
        }
       return view('User::user-details',['user' => $user]);
    }

    //updating a user 
    public function update(Request $request)
    {
        $user = User::find($request->id);
        if($user == null){
           return view('User::404');
        }
        $rules = $this->user_update_rules($user);
        $this->validate($request, $rules);
        $user->email = $request->email;
        $user->username = $request->username;
        $user->save();
        $request->session()->flash('message', 'User details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('users.update',$user));
    }

    //deleting a user 
    public function delete(Request $request)
    {
        $user = User::find($request->uid);
        if($user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'User does not exist'
            ]);
        }
        $user->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'User deleted successfully'
        ]);

    }

    //user list page 
    public function UserListPage()
    {
        return view('User::list');
    }

    //returns users as json 
    public function getUsers(Request $request)
    {
        if($request->user()->hasRole('root')){
            $users = User::all();
        }
        
        return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('action', function ($user) {
        return "
        <a href=/users/".$user->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
        <a href=/users/".$user->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
        <button onclick=delUser(".$user->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-trash'></i> Delete </button>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    //user create rules 
    public function user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        return  $rules;
    }

    //user update rules 
    public function user_update_rules($user){
        $rules = [
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return $rules;
    }

    //password update rules 
    public function password_update_rules(){
        $rules = [
            'password' => 'required|string|min:6',
        ];
        return  $rules;
    }

}
