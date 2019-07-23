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

use App\Modules\Vehicle\Models\VehicleType;
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

        if($request->user()->hasRole('root')){
            $servicer = Servicer::create([
                'name' => $request->name,
                'address' => $request->address,
                'type' => 1,
                'status' => 0,
                'user_id' => $user->id
            ]);
        }else{
             $servicer = Servicer::create([
                'name' => $request->name,
                'address' => $request->address,
                'type' => 2,
                'status' => 0,
                'sub_dealer_id' => $request->user()->id,
                'user_id' => $user->id
            ]);
        }

        $request->session()->flash('message', 'New servicer successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('servicer.details',encrypt($servicer->id)));
    }

    public function list()
    {
        return view('Servicer::list'); 
    }

    public function edit(Request $request){
        $servicer = Servicer::find(decrypt($request->id));
        if($servicer == null){
           return view('User::404');
        }
        return view('Servicer::edit',compact('servicer'));
    }

    public function update(Request $request)
    {
        $servicer = Servicer::find($request->id);
        if($servicer == null){
           return view('User::404');
        }

        $rules = $this->servicerUpdateRules($servicer->user);
        $this->validate($request,$rules);

  
        $servicer->name = $request->name;
        $servicer->address = $request->address;
        $servicer->save();

        $user = User::find($servicer->user->id);
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();

        $request->session()->flash('message', 'Servicer details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 

        return redirect()->route('servicer.details',['id' => encrypt($servicer->id)]);

    }

    public function delete(Request $request)
    {
        $servicer=Servicer::find($request->id);
        if($servicer == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Servicer does not exist'
            ]);
        }
        $servicer->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Servicer deleted successfully'
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

    public function activate(Request $request)
    {
        $servicer = Servicer::withTrashed()->find($request->id);
        if($servicer==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Servicer does not exist'
             ]);
        }
        $servicer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Servicer restored successfully'
        ]);
    }

    public function p_List(Request $request)
    {
        $servicer = Servicer::select(
                    'id',
                    'name',
                    'address',
                    'user_id',
                    'deleted_at'
                    )
            ->with('user')
            ->withTrashed();
        if($request->user()->hasRole('root')){
            $servicer = $servicer->where('type',1);
        }else{
            $servicer = $servicer->where('type',2)->where('sub_dealer_id',$request->user()->id);
        }
        $servicer->get();
        return DataTables::of($servicer)
            ->addIndexColumn()
            ->addColumn('action', function ($servicer) {
                if($servicer->deleted_at == null){
                    return "
                    <a href=/servicer/".Crypt::encrypt($servicer->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View</a>

                    <button onclick=delServicer(".$servicer->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> Deactivate</button>
                    <a href=/servicer/".Crypt::encrypt($servicer->id)."/edit class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> Edit</a>"; 
                }else{
                     return "
                    <a href=/servicer/".Crypt::encrypt($servicer->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View</a>
                    <button onclick=activateServicer(".$servicer->id.") class='btn btn-xs btn-success'data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i> Activate</button>"; 

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
            // 'job_date',
             \DB::raw('Date(job_date) as job_date'),                 
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
            // 'job_date', 
             \DB::raw('Date(job_date) as job_date'),                
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
    public function JobList()
    {

        return view('Servicer::job-list');
    }
    public function getJobsList()
    {
        $user_id=\Auth::user()->servicer->id;
        $servicer_job = ServicerJob::select(
            'id', 
            'servicer_id',
            'client_id',
            'job_id',
            'job_type',
            'user_id',
            'description',
            'job_complete_date', 
             \DB::raw('Date(job_date) as job_date'),                 
            'created_at',
            'status'
        )
        ->where('servicer_id',$user_id)
        ->whereNull('job_complete_date')
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
         ->addColumn('action', function ($servicer_job) {
          
                return "
                <a href=/job/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";
          
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function jobDetails(Request $request)
    {

        $decrypted = Crypt::decrypt($request->id); 

        $servicer_job = ServicerJob::withTrashed()->where('id', $decrypted)->first();
        $client_id=$servicer_job->client_id;
          $vehicle_device = Vehicle::select(
            'gps_id',
            'id',
            'register_number',
            'name'
            )
            ->where('client_id',$client_id)
            ->get();


        $servicer_id=\Auth::user()->servicer->id;
        $client = Client::select(
            'user_id'
            )
            ->where('id',$client_id)
            ->first();
            $client_user_id=$client->user_id;
        $vehicleTypes=VehicleType::select(
                'id','name')->get();
        $vehicle_device = Vehicle::select(
                'gps_id',
                'id',
                'register_number',
                'name'
                )
                ->where('client_id',$client_id)
                ->get();

        $single_gps = [];
        foreach($vehicle_device as $device){
            $single_gps[] = $device->gps_id;
        } 

        $devices=Gps::select('id','name','imei')
                ->where('user_id',$client_user_id)
                ->whereNotIn('id',$single_gps)
                ->get();
       if($servicer_job == null){
           return view('Servicer::404');
        }
        return view('Servicer::job-details',['servicer_job' => $servicer_job,'vehicle_device' => $vehicle_device,'vehicleTypes'=>$vehicleTypes,'devices'=>$devices,'client_id'=>$request->id]);
    }


    public function ServicerJobSave(Request $request)
    { 
        // dd($request->id);
        $rules = $this->servicercompleteJobRules();
        $this->validate($request,$rules);      
        $job_completed_date=date("Y-m-d", strtotime($request->job_completed_date)); 
        $servicer_job = ServicerJob::find($request->id);
        $servicer_job->job_complete_date = $job_completed_date;
        // $servicer->address = $request->address;
        $servicer_job->save();


        $request->session()->flash('message', 'Assign  servicer successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('job.list'));  
        // return redirect(route('job-complete.certificate'));  
    }
    // save vehicle
    public function servicerSaveVehicle(Request $request)
    {

        // $client_id=\Auth::user()->servicer->id;
       // $client_id= $request->client;         
        $name= $request->name;         
        $register_number = $request->register_number;
        $vehicle_type_id = $request->vehicle_type_id;
        $gps_id = $request->gps_id;
        $client_id = $request->client_id;
        $servicer_job_id = $request->servicer_job_id;
 // dd($servicer_job_id);
        if($gps_id!=null)
        {
            $route_area = Vehicle::create([
                'name' => $name,
                'register_number' => $register_number,
                'vehicle_type_id' => $vehicle_type_id,
                'gps_id' => $gps_id,
                'client_id' => $client_id,
                'servicer_job_id' => $servicer_job_id,
                'status' => 1
            ]);
        }
         

          $vehicle = Vehicle::select(
                    'name',
                    'register_number',
                    'vehicle_type_id',
                    'gps_id',
                    'client_id',
                    'servicer_job_id'               
                    )
        ->with('gps:id,name,imei')
       // ->with('vehicle:id,name,register_number')
        ->where('servicer_job_id',$servicer_job_id)
        ->get();
        return DataTables::of($vehicle)
            ->addIndexColumn() 
            
            ->rawColumns(['link'])         
            ->make();
 
        
    }
     public function JobCompleteCertificate()
    {

        return view('Servicer::servicer-cerificate');
    }





     public function JobHistoryList()
    {

        return view('Servicer::job-history-list');
    }
    public function getJobsHistoryList()
    {
        $user_id=\Auth::user()->servicer->id;
        $servicer_job = ServicerJob::select(
            'id', 
            'servicer_id',
            'client_id',
            'job_id',
            'job_type',
            'user_id',
            'description',
            'job_complete_date', 
             \DB::raw('Date(job_date) as job_date'),                 
            'created_at',
            'status'
        )
        ->where('servicer_id',$user_id)
        ->whereNotNull('job_complete_date')
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
         ->addColumn('action', function ($servicer_job) {
          
                return "
                <a href=/job-history/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";
          
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

     public function jobHistoryDetails(Request $request)
    {

        $decrypted = Crypt::decrypt($request->id); 

        $servicer_job = ServicerJob::withTrashed()->where('id', $decrypted)->first();
        $client_id=$servicer_job->client_id;
          $vehicle_device = Vehicle::select(
            'gps_id',
            'id',
            'register_number',
            'name'
            )
            ->where('client_id',$client_id)
            ->get();


        $servicer_id=\Auth::user()->servicer->id;
        $client = Client::select(
            'user_id'
            )
            ->where('id',$client_id)
            ->first();
            $client_user_id=$client->user_id;
        $vehicleTypes=VehicleType::select(
                'id','name')->get();
        $vehicle_device = Vehicle::select(
                'gps_id',
                'id',
                'register_number',
                'name'
                )
                ->where('client_id',$client_id)
                ->get();

        $single_gps = [];
        foreach($vehicle_device as $device){
            $single_gps[] = $device->gps_id;
        } 

        $devices=Gps::select('id','name','imei')
                ->where('user_id',$client_user_id)
                ->whereNotIn('id',$single_gps)
                ->get();
       if($servicer_job == null){
           return view('Servicer::404');
        }
        return view('Servicer::job-history-details',['servicer_job' => $servicer_job,'vehicle_device' => $vehicle_device,'vehicleTypes'=>$vehicleTypes,'devices'=>$devices,'client_id'=>$request->id]);
    }


    public function servicerJobHistory(Request $request)
    {
        $servicer_job_id = $request->servicer_job_id;
 // dd($servicer_job_id);
       
         

          $vehicle = Vehicle::select(
                    'name',
                    'register_number',
                    'vehicle_type_id',
                    'gps_id',
                    'client_id',
                    'servicer_job_id'               
                    )
        ->with('gps:id,name,imei')
       // ->with('vehicle:id,name,register_number')
        ->where('servicer_job_id',$servicer_job_id)
        ->get();
        return DataTables::of($vehicle)
            ->addIndexColumn() 
            
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

    public function servicerUpdateRules($user)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'address' => 'required',
            'mobile' => 'required'
        ];
        return  $rules;
    }
       public function servicerVehicleCreateRules()
    {
        $rules = [
            'name' => 'required',
            'register_number' => 'required|unique:vehicles',
            'vehicle_type_id' => 'required',
            'gps_id' => 'required'
            
        ];
        return  $rules;
    }
     public function servicercompleteJobRules()
    {
        $rules = [
          
            'job_completed_date' => 'required'            
        ];
        return  $rules;
    }

}
