<?php

namespace App\Modules\Servicer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Modules\Gps\Models\Gps;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Servicer\Models\ServicerJob;

use App\Modules\User\Models\User;
use App\Modules\Client\Models\Client;
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



    public function AssignServicer()
    {
        $user_id=\Auth::user()->id;
        $servicer = Servicer::select('id','name','type','status','user_id','deleted_by')
        // ->where('user_id',$user_id)
        ->where('status',0)
        ->where('type',1)
        ->get();
        $clients = Client::select('id','name','user_id')
        ->get();
        return view('Servicer::assign-servicer',['servicers'=>$servicer,'clients'=>$clients]);
    }
    public function saveAssignServicer(Request $request)
    {
        $rules = $this->servicerJobRules();
        $this->validate($request, $rules);
        $job_date=date("Y-m-d", strtotime($request->job_date));
        
        $job_id = str_pad(mt_rand(0, 999999), 5, '0', STR_PAD_LEFT);
        $user_id=\Auth::user()->id;
                $servicer = ServicerJob::create([
                'servicer_id' => $request->servicer,
                'client_id' => $request->client,
                'job_id' => $job_id,
                'job_type' => $request->job_type,
                'user_id' => $user_id,
                'description' => $request->description,
                'job_date' => $job_date,                
                'status' => 0,            
            ]); 
            $request->session()->flash('message', 'Assign  servicer successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('assign.servicer'));  
       
         
    }


    public function AssignServicerList()
    {

        return view('Servicer::assign-servicer-list');
    }
    public function getAssignServicerList()
    {
        $user_id=\Auth::user()->id;

        $servicer_job = ServicerJob::select(
            'id', 
            'servicer_id',
            'client_id',
            'job_id',
            'job_type',
            'user_id',
            'description',
            'job_date',               
            'created_at',
            'status'
        )
        ->where('user_id',$user_id)
        ->with('user:id,username')
        ->with('clients:id,name')
        ->with('servicer:id,name')
        ->get();       
        return DataTables::of($servicer_job)
        ->addIndexColumn()
         ->addColumn('job_type', function ($servicer_job) {
            if($servicer_job->job_type==1)
            {
                return "Installation" ; 
            }
            else
            {
                return "Service" ; 
            }
                       
         })            
        ->rawColumns(['link'])
        ->make();
    }

    public function SubDealerAssignServicer()
    {
        $sub_dealer_id=\Auth::user()->subDealer->id;
        $servicer = Servicer::select('id','name','type','status','user_id','deleted_by','sub_dealer_id')
        ->where('sub_dealer_id',$sub_dealer_id)
        ->where('status',0)
        ->where('type',2)
        ->get();
        $clients = Client::select('id','name','user_id','sub_dealer_id')
        ->where('sub_dealer_id',$sub_dealer_id)
        ->get();
        return view('Servicer::sub-dealer-assign-servicer',['servicers'=>$servicer,'clients'=>$clients]);
    }
    public function saveSubDealerAssignServicer(Request $request)
    {
        $rules = $this->servicerJobRules();
        $this->validate($request, $rules);
        $job_date=date("Y-m-d", strtotime($request->job_date));        
        $job_id = str_pad(mt_rand(0, 999999), 5, '0', STR_PAD_LEFT);
        $user_id=\Auth::user()->id;
                $servicer = ServicerJob::create([
                'servicer_id' => $request->servicer,
                'client_id' => $request->client,
                'job_id' => $job_id,
                'job_type' => $request->job_type,
                'user_id' => $user_id,
                'description' => $request->description,
                'job_date' => $job_date,                
                'status' => 0,            
            ]); 
            $request->session()->flash('message', 'Assign  servicer successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('sub-dealer.assign.servicer'));  
    }
    public function SubDealerAssignServicerList()
    {

        return view('Servicer::sub-dealer-assign-servicer-list');
    }
     public function getSubDealerAssignServicerList()
    {
        $user_id=\Auth::user()->id;

        $servicer_job = ServicerJob::select(
            'id', 
            'servicer_id',
            'client_id',
            'job_id',
            'job_type',
            'user_id',
            'description',
            'job_date',               
            'created_at',
            'status'
        )
        ->where('user_id',$user_id)
        ->with('user:id,username')
        ->with('clients:id,name')
        ->with('servicer:id,name')
        ->get();       
        return DataTables::of($servicer_job)
        ->addIndexColumn()
         ->addColumn('job_type', function ($servicer_job) {
            if($servicer_job->job_type==1)
            {
                return "Installation" ; 
            }
            else
            {
                return "Service" ; 
            }
                       
         })            
        ->rawColumns(['link'])
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
    
    public function servicerJobRules()
    {
        $rules = [
            'servicer' => 'required',
            'client' => 'required',
            'job_type' => 'required',
            'description' => 'required',
            'job_date' => 'required'            
        ];
        return  $rules;
    }

}
