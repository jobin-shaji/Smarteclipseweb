<?php

namespace App\Modules\Servicer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Modules\Gps\Models\Gps;
use App\Modules\Warehouse\Models\GpsStock;

use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\User\Models\User;
use App\Modules\Client\Models\Client;
use App\Modules\Driver\Models\Driver;
use DataTables;
use PDF;
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
            $sub_dealer_id=\Auth::user()->subdealer->id;
             $servicer = Servicer::create([
                'name' => $request->name,
                'address' => $request->address,
                'type' => 2,
                'status' => 0,
                'sub_dealer_id' => $sub_dealer_id,
                'user_id' => $user->id
            ]);
        }

        $request->session()->flash('message', 'New servicer created successfully!'); 
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
        $user = User::find($servicer->user->id);
        if($servicer == null){
           return view('User::404');
        }
        $rules = $this->servicerUpdateRules($user);
        $this->validate($request,$rules);
        $servicer->name = $request->name;
        $servicer->address = $request->address;
        $servicer->save();
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
            // \Auth::user()->subdealer->id
            $servicer = $servicer->where('type',2)->where('sub_dealer_id',$request->user()->subdealer->id);
        }
        $servicer->get();
        return DataTables::of($servicer)
            ->addIndexColumn()
            ->addColumn('action', function ($servicer) {
                $b_url = \URL::to('/');
                if($servicer->deleted_at == null){
                    return "
                    <a href=".$b_url."/servicer/".Crypt::encrypt($servicer->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View</a>

                    <button onclick=delServicer(".$servicer->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> Deactivate</button>
                    <a href=".$b_url."/servicer/".Crypt::encrypt($servicer->id)."/edit class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> Edit</a>"; 
                }else{
                     return "
                    <button onclick=activateServicer(".$servicer->id.") class='btn btn-xs btn-success'data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i> Activate</button>"; 

                }
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }



    public function assignServicer()
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
        $placeLatLng=$this->getPlaceLatLng($request->search_place);

        if($placeLatLng==null){
              $request->session()->flash('message', 'Enter correct location'); 
              $request->session()->flash('alert-class', 'alert-danger'); 
              return redirect(route('sub-dealer.assign.servicer'));        
        }
        $location_lat=$placeLatLng['latitude'];
        $location_lng=$placeLatLng['logitude'];        
        $user_id=\Auth::user()->id;
        $servicer = ServicerJob::create([
            'servicer_id' => $request->servicer,
            'client_id' => $request->client,
            'job_id' => $job_id,
            'job_type' => $request->job_type,
            'user_id' => $user_id,
            'description' => $request->description,
            'gps_id' => $request->gps, 
            'job_date' => $job_date,                
            'status' => 0,
            'latitude'=>$location_lat,
            'longitude'=>$location_lng              
        ]); 
        // $gps = Gps::find($request->gps);
        // $gps->user_id = null;        
        // $gps->save();                
        $request->session()->flash('message', 'Assign  servicer successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('assign.servicer'));  
       
         
    }


    public function assignServicerList()
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
            'gps_id',
            // 'job_date',
             \DB::raw('Date(job_date) as job_date'),                 
            'created_at',
            'status'
        )
        ->where('user_id',$user_id)
        ->with('user:id,username')
        ->with('gps:id,imei,serial_no')
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

    public function subDealerAssignServicer()
    {
        $sub_dealer_id=\Auth::user()->subDealer->id;
        // dd($sub_dealer_id);
        $servicer = Servicer::select('id','name','type','status','user_id','deleted_by','sub_dealer_id')
        ->where('sub_dealer_id',$sub_dealer_id)
        ->where('status',0)
        ->where('type',2)
        ->get();
        // dd($servicer);
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

        // $placeLatLng=$this->getPlaceLatLng($request->search_place);

        // if($placeLatLng==null){
        //       $request->session()->flash('message', 'Enter correct location'); 
        //       $request->session()->flash('alert-class', 'alert-danger'); 
        //       return redirect(route('sub-dealer.assign.servicer'));        
        // }

        // $location_lat=$placeLatLng['latitude'];
        // $location_lng=$placeLatLng['logitude'];
        $location=$request->search_place;

        $user_id=\Auth::user()->id;
                $servicer = ServicerJob::create([
                'servicer_id' => $request->servicer,
                'client_id' => $request->client,
                'job_id' => $job_id,
                'job_type' => $request->job_type,
                'user_id' => $user_id,
                'description' => $request->description,
                'job_date' => $job_date,
                'gps_id' => $request->gps,                
                'status' => 0, 
                'location'=>$location 
                // 'latitude'=>$location_lat,
                // 'longitude'=>$location_lng           
            ]); 
            $request->session()->flash('message', 'Assign  servicer successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            
            return redirect(route('sub-dealer.assign.servicer'));  
    }
    public function subDealerAssignServicerList()
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
            'gps_id',
            // 'job_date', 
             \DB::raw('Date(job_date) as job_date'),                
            'created_at',
            'status'
        )
        ->where('user_id',$user_id)
        ->with('user:id,username')
        ->with('gps:id,imei,serial_no')
        ->with('clients:id,name')
        ->whereNull('job_complete_date')
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
    public function jobList()
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
            'gps_id',
            'job_complete_date', 
            \DB::raw('Date(job_date) as job_date'),                 
            'created_at',
            'latitude',
            'longitude',
            'location',
            'status'
        )
        ->where('servicer_id',$user_id)
        ->whereNull('job_complete_date')
        ->with('gps:id,imei,serial_no')
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
        // ->addColumn('location', function ($servicer_job) {                    
        //     $latitude= $servicer_job->latitude;
        //     $longitude=$servicer_job->longitude;          
        //     if(!empty($latitude) && !empty($longitude)){
        //         //Send request and receive json data by address
        //         $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
        //         $output = json_decode($geocodeFromLatLong);         
        //         $status = $output->status;
        //         //Get address from json data
        //         $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        //         //Return address of the given latitude and longitude
        //         if(!empty($address)){
        //             $location=$address;
        //             return $location;                                 
        //         }        
        //     }
        //     else
        //     {
        //         return "No Address";
        //     }
        //  })
         ->addColumn('action', function ($servicer_job) {
             $b_url = \URL::to('/');
                return "
                <a href=".$b_url."/job/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";
          
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function jobDetails(Request $request)
    {

        $decrypted = Crypt::decrypt($request->id); 
        $servicer_job = ServicerJob::select(
            'id',
            'servicer_id',
            'client_id',
            'job_id',
            'job_type',
            'user_id',
            'description',
            'job_date',
            'job_complete_date',
            'status',
            'latitude',
            'longitude',
            'gps_id'
        )
        ->withTrashed()
        ->where('id', $decrypted)
        ->with('gps:id,imei')
        ->with('clients:id,name')
        ->first();
        $client_id=$servicer_job->client_id;
        // dd($client_id);
        $servicer_id=\Auth::user()->servicer->id;
        $vehicleTypes=VehicleType::select(
            'id','name'
        )
        ->get();       
        $drivers=Driver::select('id','name')
        ->where('client_id',$client_id)
        ->get();       
       if($servicer_job == null){
           return view('Servicer::404');
        }
        return view('Servicer::job-details',['servicer_job' => $servicer_job,'vehicleTypes'=>$vehicleTypes,'client_id'=>$request->id,'drivers'=>$drivers]);
    }


    public function servicerJobSave(Request $request)
    { 
         $custom_messages = [
        'path.required' => 'File cannot be blank',
        'installation_photo.required' => 'File cannot be blank',
        'activation_photo.required' => 'File cannot be blank',
        'vehicle_photo.required' => 'File cannot be blank'
        ];
        // dd($request->id);
        $rules = $this->servicercompleteJobRules();
        $this->validate($request,$rules);      
        // $job_completed_date=date("Y-m-d"), strtotime($request->job_completed_date));
        $job_completed_date=date("Y-m-d"); 
        $servicer_job = ServicerJob::find($request->id);
        $servicer_job->job_complete_date = $job_completed_date;
        $driver_id=$request->driver;
        // $path = $request->path;
        $driver = Driver::find($driver_id);
        if($driver)
        {
            
       
            $servicer_job->comment = $request->comment;
            $servicer_job->status = 1;
            $servicer_job->save();
            if($servicer_job)
            {        
            $name= $request->name;         
            $register_number = $request->register_number;
            $vehicle_type_id = $request->vehicle_type_id;
            $gps_id = $request->gps_id;
            $client_id = $request->client_id;
            $servicer_job_id = $request->servicer_job_id;
            $engine_number = $request->engine_number;
            $chassis_number = $request->chassis_number;



            $vehicle_create= Vehicle::create([
                'name' => $name,
                'register_number' => $register_number,
                'vehicle_type_id' => $vehicle_type_id,
                'gps_id' => $gps_id,
                'client_id' => $client_id,
                'servicer_job_id' =>$servicer_job->id,
                'engine_number' => $engine_number,
                'chassis_number' => $chassis_number,
                'driver_id' => $driver_id,
                'status' => 1
            ]);
            // $this->validate($request, $rules, $custom_messages);
            $file=$request->path;
            $installation_photo=$request->installation_photo;
            $activation_photo=$request->activation_photo;
            $vehicle_photo=$request->vehicle_photo;
           
            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;
            //Move Uploaded File
            $destinationPath = 'documents';
            $file->move($destinationPath,$uploadedFile);

            $getInstallationFileExt   = $installation_photo->getClientOriginalExtension();
            $uploadedInstallationFile =   time().'.'.$getInstallationFileExt;
            $installation_photo->move($destinationPath,$uploadedInstallationFile);

            $getActivationFileExt   = $activation_photo->getClientOriginalExtension();
            $uploadedActivationFile =   time().'.'.$getActivationFileExt;
            $activation_photo->move($destinationPath,$uploadedActivationFile);

            $getVehicleFileExt   = $vehicle_photo->getClientOriginalExtension();
            $uploadedVehicleFile =   time().'.'.$getVehicleFileExt;
            $vehicle_photo->move($destinationPath,$uploadedVehicleFile);


            $documents = Document::create([
                'vehicle_id' => $vehicle_create->id,
                'document_type_id' => 1,
                'expiry_date' => null,
                'path' => $uploadedFile,
            ]);
            $installation_documents = Document::create([
                'vehicle_id' => $vehicle_create->id,
                'document_type_id' => 6,
                'expiry_date' => null,
                'path' => $uploadedInstallationFile,
            ]);
            $activation_documents = Document::create([
                'vehicle_id' => $vehicle_create->id,
                'document_type_id' => 7,
                'expiry_date' => null,
                'path' => $uploadedActivationFile,
            ]);
            $vehicle_photo = Document::create([
                'vehicle_id' => $vehicle_create->id,
                'document_type_id' => 8,
                'expiry_date' => null,
                'path' => $uploadedVehicleFile,
            ]);
            // dd($servicer_job->id);
            // $service_job_id=Crypt::encrypt($servicer_job->id);
            $request->session()->flash('message', 'Job  completed successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect()->route('job.history.details',['id' => encrypt($servicer_job->id)]);
        }
    }
    else
    {
        $request->session()->flash('message', 'Driver doesnot exist!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
       return view('Servicer::404');
    }

        // return redirect(route('job.list'));  
        // return redirect(route('job-complete.certificate',$service_job_id));  
    }
    // save vehicle
   
     public function jobCompleteCertificate(Request $request)
    {

        return view('Servicer::servicer-cerificate',['id'=>$request->id]);
    }

    public function downloadJobCompleteCertificate(Request $request){

        $servicer_job_id = Crypt::decrypt($request->id);
        $servicer_job = ServicerJob::find($servicer_job_id);
        $client_id=$servicer_job->client_id;
        $client = Client::find($client_id);
         $vehicle = Vehicle::select(
            'id',
            'name',
            'register_number',
            'vehicle_type_id',
            'gps_id',
            'client_id',
            'servicer_job_id',
            'chassis_number',
            'engine_number'             
        )
        ->with('gps:id,imei')
        ->where('servicer_job_id',$servicer_job_id)
        // ->where('id',$vehicle_id)
        ->first();
        // dd($vehicle);
        if($servicer_job == null){
           return view('Servicer::404');
        }
        $pdf = PDF::loadView('Servicer::installation-certificate-download',['servicer_job' => $servicer_job,'vehicle'=> $vehicle,'client' => $client]);
        return $pdf->download('installation-certificate.pdf');
    }
    public function jobHistoryList()
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
            'status',
            'latitude',
            'longitude',
            'gps_id'
        )
        ->where('servicer_id',$user_id)
        ->whereNotNull('job_complete_date')
        ->with('user:id,username')
        ->with('gps:id,imei,serial_no')
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
         ->addColumn('location', function ($servicer_job) {                    
            $latitude= $servicer_job->latitude;
            $longitude=$servicer_job->longitude;          
            if(!empty($latitude) && !empty($longitude)){
                //Send request and receive json data by address
                $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
                $output = json_decode($geocodeFromLatLong);         
                $status = $output->status;
                //Get address from json data
                $address = ($status=="OK")?$output->results[1]->formatted_address:'';
                //Return address of the given latitude and longitude
                if(!empty($address)){
                    $location=$address;
                    return $location;                                 
                }        
            }
            else
            {
                return "No Address";
            }
         }) 
         ->addColumn('action', function ($servicer_job) {
           $b_url = \URL::to('/');
                return "
                <a href=".$b_url."/job-history/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";
          
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
            'name',
            'servicer_job_id',
            'client_id'
        )
        ->where('client_id',$client_id)
        ->where('servicer_job_id',$servicer_job->id)
        ->first();
        
        if($servicer_job == null){
           return view('Servicer::404');
        }
        return view('Servicer::job-history-details',['servicer_job' => $servicer_job,'vehicle_device' => $vehicle_device]);
    }
    public function servicerJobHistory(Request $request)
    {
        $servicer_job_id = $request->servicer_job_id;
        // dd($servicer_job_id);
        $vehicle = Vehicle::select(
            'id',
            'name',
            'register_number',
            'vehicle_type_id',
            'gps_id',
            'client_id',
            'servicer_job_id'               
        )
        ->with('gps:id,imei')
       // ->with('vehicle:id,name,register_number')
        ->where('servicer_job_id',$servicer_job_id)
        ->get();
        return DataTables::of($vehicle)
        ->addIndexColumn() 
        ->addColumn('action', function ($vehicle) {
          $b_url = \URL::to('/');
                return "
                <a href=".$b_url."/job-complete/".Crypt::encrypt($vehicle->servicer_job_id)."/downloads/".Crypt::encrypt($vehicle->id).">
                        <button class='btn'><i class='fa fa-download'></i>Download</button>
                      </a>";
          
        })
        ->rawColumns(['link', 'action'])             
        ->make();
 
        
    }


#################################################
    function getPlaceLatLng($address){

        $data = urlencode($address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $data . "&sensor=false&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo";
        $geocode_stats = file_get_contents($url);
        $output_deals = json_decode($geocode_stats);
        if ($output_deals->status != "OK") {
            return null;
        }
        if ($output_deals) {
            $latLng = $output_deals->results[0]->geometry->location;
            $lat = $latLng->lat;
            $lng = $latLng->lng;
            $locationData = ["latitude" => $lat, "logitude" => $lng];
            return $locationData;
        } else {
            return null;
        }
    }
################################################################################


//Alert Notification
    public function clientGpsList(Request $request)
    {
        $user = $request->user();
        $client_id=$request->client_id;
        $client = Client::find($client_id);
        $gps_stocks = GpsStock::select(
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client_id)
        ->get();

        $stock_gps_id = [];
        foreach($gps_stocks as $stock_gps){
            $stock_gps_id[] = $stock_gps->gps_id;
        }       
        if($stock_gps_id)
        {        
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
        
        $servicer_jobs = ServicerJob::select(
            'gps_id',
            'servicer_id',
            'user_id',
            'client_id'
        )
        ->where('client_id',$client_id)
        ->get();
        $servicer_gps = [];
        foreach($servicer_jobs as $servicer_job){
            $servicer_gps[] = $servicer_job->gps_id;
        }     
        // dd($servicer_gps);
        $devices=Gps::select('id','imei','serial_no')
        ->whereIn('id',$stock_gps_id)
        ->whereNotIn('id',$single_gps)
        ->whereNotIn('id',$servicer_gps)
        ->get();
 
        // if($user->hasRole('sub_dealer')){
        if($devices)
        {               
            $response_data = array(
                'status'  => 'client-gps',
                'devices' => $devices
            );
        }
        else{
            $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0
            );
        }
    }
    else
    {
         $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0
            );
    }
        return response()->json($response_data); 
        // }
    }
    ##############################################

    public function servicerJobHistoryList()
    {
        return view('Servicer::servicer-job-history-list');
    }

     public function getServicerJobsHistoryList()
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
            'job_complete_date', 
             \DB::raw('Date(job_date) as job_date'),                 
            'created_at',
            'gps_id',
            'status'
        )
        ->where('user_id',$user_id)
        ->whereNotNull('job_complete_date')
        ->with('user:id,username')
        ->with('gps:id,imei,serial_no')
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
           $b_url = \URL::to('/');
                return "
                <a href=".$b_url."/job-history/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";
          
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
            'mobile' => 'required|string|min:10|max:10|unique:users'  
           
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
            'gps' => 'required',
            'job_date' => 'required',
            'search_place'=>'required'            
        ];
        return  $rules;
    }

    public function servicerUpdateRules($user)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'mobile' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'address' => 'required',
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
            // 'job_completed_date' => 'required',
            'name' => 'required',
            'register_number' => 'required|unique:vehicles',
            'vehicle_type_id' => 'required',
            'gps_id' => 'required',
            'client_id' => 'required',
            'servicer_job_id' => 'required',
            'engine_number' => 'required',
            'chassis_number' => 'required',
            'name' => 'required',
            'path' => 'required|mimes:jpeg,png|max:4096',
            'installation_photo' => 'required|mimes:jpeg,png|max:4096',
            'activation_photo' => 'required|mimes:jpeg,png|max:4096',
            'vehicle_photo' => 'required|mimes:jpeg,png|max:4096',
            'comment' => 'required',
            'driver'=>'required'

        ];
        return  $rules;
    }


}
