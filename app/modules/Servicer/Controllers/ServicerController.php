<?php

namespace App\Modules\Servicer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\User\Models\User;
use DataTables;

class ServicerController extends Controller {
    

    public function create()
    {
        return view('Servicer::create');
    }

    public function save(Request $request)
    {
        $rules = $this->servicerCreateRules();
        $this->validate($request, $rules);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'status' => 1,
        ]);

        $user->assignRole('servicer');

        $servicer = Servicer::create([
            'name' => $request->name,
            'address' => $request->address,
            'type' => 1,
            'status' => 0,
            'user_id' => $user->id
        ]);

        $request->session()->flash('message', 'New user servicer successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('servicer.details',encrypt($servicer->id)));
    }

    public function list()
    {
        return view('Servicer::list'); 
    }

    public function delete()
    {
        $route=Route::find($request->id);
        if($route == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Route does not exist'
            ]);
        }
        $route->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Route deleted successfully'
        ]);
    }

    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $servicer=Servicer::find($decrypted_id);
        if($servicer==null){
            return view('Route::404');
        } 
        return view('Servicer::details',compact('servicer'));
    }

    public function activate()
    {
        $route = Route::withTrashed()->find($request->id);
        if($route==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Route does not exist'
             ]);
        }
        $route->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Route restored successfully'
        ]);
    }



    // data for list page
    public function getServicerList()
    {
        $client_id=\Auth::user()->client->id;
        $route = Route::select(
                    'id',
                    'name',
                    'deleted_at'
                    )
            ->withTrashed()
            ->where('client_id',$client_id)
            ->get();
        return DataTables::of($route)
            ->addIndexColumn()
            ->addColumn('action', function ($route) {
                if($route->deleted_at == null){
                    return "
                     <a href=/route/".Crypt::encrypt($route->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View</a>

                    <button onclick=deleteRoute(".$route->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> Deactivate</button>"; 
                }else{
                     return "
                    <a href=/route/".Crypt::encrypt($route->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View</a>
                    <button onclick=activateRoute(".$route->id.") class='btn btn-xs btn-success'data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i> Activate</button>"; 
                }
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }
    
    public function servicerCreateRules()
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required',
            'mobile' => 'required'
        ];
        return  $rules;
    }

}
