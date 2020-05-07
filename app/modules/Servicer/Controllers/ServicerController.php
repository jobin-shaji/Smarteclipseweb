<?php
 
namespace App\Modules\Servicer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransferItems;

use App\Modules\Root\Models\Root;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Vehicle\Models\VehicleDailyUpdate;
use App\Modules\Operations\Models\VehicleModels;
use App\Modules\Operations\Models\VehicleMake;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Trader\Models\Trader;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Servicer\Models\FcmLog;
use App\Modules\Servicer\Models\ServicerNotification;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\User\Models\User;
use App\Modules\Client\Models\Client;
use App\Modules\Driver\Models\Driver;
use App\Modules\Driver\Models\DriverVehicleHistory;
use App\Modules\Ota\Models\OtaResponse;
use App\Modules\Configuration\Models\Configuration;
use DataTables;
use PDF;
class ServicerController extends Controller {

    CONST JOB_STATUS_NEW            = 1;
    CONST JOB_STATUS_IN_PROGRESS    = 2;
    CONST JOB_STATUS_COMPLETED      = 3;
    CONST JOB_TYPE_INSTALLATION     = 1;
    CONST JOB_TYPE_SERVICE          = 2;
    CONST JOB_UNBOXING_STAGE        = 1;
    CONST JOB_FITTING_STAGE         = 2;
    CONST JOB_COMMAND_STAGE         = 3;
    CONST JOB_TEST_START_STAGE      = 4;
    CONST JOB_COMPLETED_STAGE       = 5;
    CONST JOB_DEVICE_TEST_START     = 1;
    CONST SOS_TEST_TYPE_STOP        = "STOP";
    CONST SOS_TEST_TYPE_RESET       = "RESET";

    CONST OTA_COMMAND_EMERGENCY_OFF = "SET EO";

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
            'mobile' => $request->mobile_number,
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
        }else if($request->user()->hasRole('sub_dealer')){
            $sub_dealer_id=\Auth::user()->subdealer->id;
             $servicer = Servicer::create([
                'name' => $request->name,
                'address' => $request->address,
                'type' => 2,
                'status' => 0,
                'sub_dealer_id' => $sub_dealer_id,
                'user_id' => $user->id
            ]);
        }else{
             $trader_id=\Auth::user()->trader->id;
             $servicer = Servicer::create([
                'name' => $request->name,
                'address' => $request->address,
                'type' => 3,
                'status' => 0,
                'trader_id' => $trader_id,
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
        $request->session()->flash('message', 'Details updated successfully!');
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
        $servicer->user->delete();
        $servicer->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Servicer deactivated successfully'
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
        $servicer->user->restore();
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
        }elseif($request->user()->hasRole('sub_dealer')){
            // \Auth::user()->subdealer->id
            $servicer = $servicer->where('type',2)->where('sub_dealer_id',$request->user()->subdealer->id);
        }else{
               // \Auth::user()->subdealer->id
            $servicer = $servicer->where('type',3)->where('trader_id',$request->user()->trader->id);
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
                     <a href=".$b_url."/servicer/".Crypt::encrypt($servicer->user_id)."/password-change class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
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
        $cient = Client::select('id')
        ->orderBy('id','desc')
        ->first();
        return view('Servicer::assign-servicer',['servicers'=>$servicer,'client_id'=>$cient->id]);
    }
    public function saveAssignServicer(Request $request)
    {
        $rules              =   $this->servicerJobRules();
        $customMessages     =   ['gps.required' => 'The GPS field is required.'];
        $this->validate($request, $rules, $customMessages);
        
        $job_date           =   date("Y-m-d H:i:m", strtotime($request->job_date));
        $job_id             =   str_pad(mt_rand(0, 999999), 5, '0', STR_PAD_LEFT);
        // $placeLatLng=$this->getPlaceLatLng($request->search_place);

        // if($placeLatLng==null){
        //       $request->session()->flash('message', 'Enter correct location');
        //       $request->session()->flash('alert-class', 'alert-danger');details
        //       return redirect(route('sub-dealer.assign.servicer'));
        // }
        // $location_lat=$placeLatLng['latitude'];
        // $location_lng=$placeLatLng['logitude'];
        $location           =   $request->search_place;
        $job_type           =   $request->job_type;
        $gps_id             =   $request->gps;
        if($request->job_type == 2)
        {
            $start_code = str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
        }
        else
        {
            $start_code = NULL;
        }
        if($request->job_type == 1)
        {
            $is_already_job_created_for_gps     =   (new ServicerJob())->checkUncompleteRepeatedJobForGps($gps_id);
            if( $is_already_job_created_for_gps > 0)
            {
                $request->session()->flash('message', 'Job already assigned for selected GPS!');
                $request->session()->flash('alert-class', 'alert-danger');
            }
        }
        else if($request->job_type == 3)
        {
            $is_already_job_created_for_gps     =   (new ServicerJob())->checkUncompleteRepeatedJobForGps($gps_id);
            if( $is_already_job_created_for_gps > 0)
            {
                $request->session()->flash('message', 'Job already assigned for selected GPS!');
                $request->session()->flash('alert-class', 'alert-danger');
            }
            $vehicle_id                 =   $request->vehicle;
            $is_already_job_created_for_vehicle =   (new Vehicle())->checkAlreadytJobCreatedForVehicle($vehicle_id);
            if( $is_already_job_created_for_vehicle > 0)
            {
                $request->session()->flash('message', 'Job already assigned for selected vehicle!');
                $request->session()->flash('alert-class', 'alert-danger');
            }
        }
        $user_id        =   \Auth::user()->id;
        //Service Job
        $service_job    =   ServicerJob::create([
                                'servicer_id'   =>  $request->servicer,
                                'client_id'     =>  $request->client,
                                'job_id'        =>  $job_id,
                                'start_code'    =>  $start_code,
                                'job_type'      =>  $job_type,
                                'user_id'       =>  $user_id,
                                'description'   =>  $request->description,
                                'gps_id'        =>  $gps_id,
                                'role'          =>  $request->role,
                                'job_date'      =>  $job_date,
                                'status'        =>  1, //ASSIGNED STATUS
                                'location'      =>  $location,
                                'job_status'    =>  0,
                                'reinstallation_vehicle_id' =>  $request->vehicle
                                // 'longitude'=>$location_lng
                            ]);
        if($request->job_type == 1)
        {
            $title   ="New Installation Job"; 
            $message = ['job_id'  => $job_id,
                        'title'   => $title,
                        'content' => $request->description,
                        'type'    => "INSTALLATION",
                        'date'    => date('Y-m-d H:i:s')
                         ];
        }
        else if($request->job_type == 3)
        {
            $title   ="New Reinstallation Job"; 
            $message = ['job_id'  => $job_id,
                        'title'   => $title,
                        'content' => $request->description,
                        'type'    => "REINSTALLATION",
                        'date'    => date('Y-m-d H:i:s')
                            ];
            //get selected vehicle from returned device vehicle list of this client
            $get_choosed_vehicle_for_reinstallation     =   (new Vehicle())->getChoosedVehicleForReinstallation($request->vehicle);
            //update reinstallation job created status as 1(job created)
            if($get_choosed_vehicle_for_reinstallation)
            {
                $get_choosed_vehicle_for_reinstallation->is_reinstallation_job_created =   1;
                $get_choosed_vehicle_for_reinstallation->save();
            }
        }
        else
        {
            $title   = "New Service Job"; 
            $message = ['job_id'  => $job_id,
                        'title'   => $title,
                        'content' => $request->description,
                        'type'    => "SERVICE",
                        'date'    => date('Y-m-d H:i:s')
                         ];
        }
              
        ServicerNotification::create([
                                        'servicer_id'       => $request->servicer,
                                        'service_job_id'    =>$service_job->id,
                                        'title'             => $title,
                                        'data'              => json_encode($message,true)
                                    ]);

        $servicer = Servicer::find($request->servicer);      
        $devices  = $servicer->devices;
        foreach ($devices as $device) {
            $this->fcmPushNotification($device->firebase_token,$title,$message);
        }
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
            'job_date',
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
    public function subDealerAssignServicer(Request $request)
    {
        if($request->user()->hasRole('sub_dealer')){
            $sub_dealer_id=\Auth::user()->subDealer->id;
            $servicer = Servicer::select('id','name','type','status','user_id','deleted_by','sub_dealer_id')
            ->where('sub_dealer_id',$sub_dealer_id)
            ->where('status',0)
            ->where('type',2)
            ->get();
            $client = Client::select('id','sub_dealer_id')
            ->orderBy('id','desc')
            ->where('sub_dealer_id',$sub_dealer_id)
            ->first();
        }
        else{
            $trader_id=\Auth::user()->trader->id;
            $servicer = Servicer::select('id','name','type','status','user_id','deleted_by','trader_id')
            ->where('trader_id',$trader_id)
            ->where('status',0)
            ->where('type',3)
            ->get();
            $client = Client::select('id','trader_id')
            ->where('trader_id',$trader_id)
            ->orderBy('id','desc')
            ->first();
        }
        return view('Servicer::sub-dealer-assign-servicer',['servicers'=>$servicer,'client_id'=>$client->id]);
    }

    //get client based on job type
    public function getClientBasedOnJobType(Request $request)
    {
        $job_type           =   $request->job_type;
        if($request->user()->hasRole('sub_dealer'))
        {
            $sub_dealer_id  =   \Auth::user()->subDealer->id;
            if($job_type == 1 || $job_type == 2)
            {
                $clients    =   (new Client())->getDetailsOfClientsUnderSubDealer($sub_dealer_id);
            }
            else if($job_type == 3)
            { 
                $clients    =   (new Client())->getDetailsOfClientsWithReturnedVehicleGpsUnderSubDealer($sub_dealer_id);
            }
            
        }
        else if($request->user()->hasRole('trader'))
        {
            $trader_id=\Auth::user()->trader->id;
            if($job_type == 1 || $job_type == 2)
            {
                $clients    =   (new Client())->getDetailsOfClientsUnderTrader($trader_id);
            }
            else if($job_type == 3)
            { 
                $clients    =   (new Client())->getDetailsOfClientsWithReturnedVehicleGpsUnderTrader($trader_id);
            }
        }
        else if($request->user()->hasRole('root'))
        {
            if($job_type == 1 || $job_type == 2)
            {
                $clients    =   (new Client())->getDetailsOfAllClients();
            }
            else if($job_type == 3)
            { 
                $clients    =   (new Client())->getDetailsOfClientsWithReturnedVehicleGps();
            }
        }
        return response()->json($clients);
    }



    public function saveSubDealerAssignServicer(Request $request)
    {
        $rules          =   $this->servicerJobRules();
        $customMessages =   [ 'gps.required' => 'The GPS field is required.'];
        $this->validate($request, $rules, $customMessages);
        $job_date       =   date("Y-m-d H:i:s", strtotime($request->job_date));

        $job_id         =   str_pad(mt_rand(0, 999999), 5, '0', STR_PAD_LEFT);

        // $placeLatLng=$this->getPlaceLatLng($request->search_place);

        // if($placeLatLng==null){
        //       $request->session()->flash('message', 'Enter correct location');
        //       $request->session()->flash('alert-class', 'alert-danger');
        //       return redirect(route('sub-dealer.assign.servicer'));
        // }

        // $location_lat=$placeLatLng['latitude'];
        // $location_lng=$placeLatLng['logitude'];
        $location       =   $request->search_place;
        $job_type       =   $request->job_type;
        $gps_id         =   $request->gps;
        if($request->job_type == 2)
        {
            $start_code = str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
        }
        else
        {
            $start_code = NULL;
        }
        if($request->job_type == 1)
        {
            $is_already_job_created_for_gps     =   (new ServicerJob())->checkUncompleteRepeatedJobForGps($gps_id);
            if( $is_already_job_created_for_gps > 0)
            {
                $request->session()->flash('message', 'Job already assigned for selected GPS!');
                $request->session()->flash('alert-class', 'alert-danger');
            }
        }
        else if($request->job_type == 3)
        {
            $is_already_job_created_for_gps     =   (new ServicerJob())->checkUncompleteRepeatedJobForGps($gps_id);
            if( $is_already_job_created_for_gps > 0)
            {
                $request->session()->flash('message', 'Job already assigned for selected GPS!');
                $request->session()->flash('alert-class', 'alert-danger');
            }
            $vehicle_id                 =   $request->vehicle;
            $is_already_job_created_for_vehicle =   (new Vehicle())->checkAlreadytJobCreatedForVehicle($vehicle_id);
            if( $is_already_job_created_for_vehicle > 0)
            {
                $request->session()->flash('message', 'Job already assigned for selected vehicle!');
                $request->session()->flash('alert-class', 'alert-danger');
            }
        }

        $user_id    =   \Auth::user()->id;
        $servicer   =   ServicerJob::create([
                            'servicer_id'   =>  $request->servicer,
                            'client_id'     =>  $request->client,
                            'job_id'        =>  $job_id,
                            'start_code'    =>  $start_code,
                            'job_type'      =>  $job_type,
                            'user_id'       =>  $user_id,
                            'description'   =>  $request->description,
                            'role'          =>  $request->role,
                            'job_date'      =>  $job_date,
                            'gps_id'        =>  $gps_id,
                            'status'        =>  1, //ASSIGN STATUS
                            'location'      =>  $location,
                            'job_status'    =>  0,
                            'reinstallation_vehicle_id' =>  $request->vehicle
                            // 'longitude'=>$location_lng
                        ]);
        if($request->job_type == 1)
        {
            $title   =  "New Installation Job"; 
            $message =  [   'job_id'  => $job_id,
                            'title'   => $title,
                            'content' => $request->description,
                            'type'    => "INSTALLATION",
                            'date'    => date('Y-m-d H:i:s')
                        ];
        }
        else if($request->job_type == 3)
        {
            $title   =  "New Reinstallation Job"; 
            $message =  [   'job_id'  => $job_id,
                            'title'   => $title,
                            'content' => $request->description,
                            'type'    => "REINSTALLATION",
                            'date'    => date('Y-m-d H:i:s')
                        ];
            //get selected vehicle from returned device vehicle list of this client
            $get_choosed_vehicle_for_reinstallation     =   (new Vehicle())->getChoosedVehicleForReinstallation($request->vehicle);
            //update reinstallation job created status as 1(job created)
            if($get_choosed_vehicle_for_reinstallation)
            {
                $get_choosed_vehicle_for_reinstallation->is_reinstallation_job_created =   1;
                $get_choosed_vehicle_for_reinstallation->save();
            }
        }
        else
        {
            $title   =  "New Service Job"; 
            $message =  [   'job_id'  => $job_id,
                            'title'   => $title,
                            'content' => $request->description,
                            'type'    => "SERVICE",
                            'date'    => date('Y-m-d H:i:s')
                        ];
        }
                
        ServicerNotification::create([
                                    'servicer_id'       => $request->servicer,
                                    'service_job_id'    => $servicer->id,
                                    'title'             => $title,
                                    'data'              => json_encode($message,true)
                                ]);

        $servicer   =   Servicer::find($request->servicer);      
        $devices    =   $servicer->devices;
        foreach ($devices as $device) {
            $this->fcmPushNotification($device->firebase_token,$title,$message);
        }
        $request->session()->flash('message', 'Assigned Job successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('sub-dealer.assign.servicer'));
    }
    public function subDealerAssignServicerList()
    {
        $user_id=\Auth::user()->id;
       

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
            'job_date',
            'created_at',
            'status'
        )
        ->where('user_id',$user_id)
        ->with('user:id,username')
        ->with('gps:id,imei,serial_no')
        ->with('clients:id,name')
        ->whereNull('job_complete_date')
        ->with('servicer:id,name')
        ->orderBy('id','desc')
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
    public function jobList(Request $request)
    {
        $key = ( isset($request->new_installation_search_key) ) ? $request->new_installation_search_key : null;
         return view('Servicer::job-list',['servicer_jobs'=> (new ServicerJob())->getNewInstallationList($key)]); 
  
    }

    public function reinstallationJobList(Request $request)
    {
        $key = ( isset($request->new_installation_search_key) ) ? $request->new_installation_search_key : null;
         return view('Servicer::reinstallation-job-list',['servicer_jobs'=> (new ServicerJob())->getNewReInstallationList($key)]); 
  
    }

    public function onProgressInstallationJobList(Request $request)
    {
        $key = ( isset($request->new_installation_search_key) ) ? $request->new_installation_search_key : null;
        return view('Servicer::on_progress_installation_job-list',['servicer_jobs'=> (new ServicerJob())->getOnProgressInstallationList($key)]); 
  
    }

    public function onProgressReinstallationJobList(Request $request)
    {
        $key = ( isset($request->new_installation_search_key) ) ? $request->new_installation_search_key : null;
        return view('Servicer::on_progress_reinstallation_job-list',['servicer_jobs'=> (new ServicerJob())->getOnProgressReinstallationList($key)]); 
  
    }
    
  // for new services
    public function serviceJobList(Request $request)
    {
        $key = ( isset($request->new_service_search_key) ) ? $request->new_service_search_key : null;
        return view('Servicer::new-service-job-list',['servicer_jobs'=> (new ServicerJob())->getNewServiceList($key)]); 
     
    }
    public function onProgresserviceJobList(Request $request)
    {
        $key = ( isset($request->in_progress_service_search_key) ) ? $request->in_progress_service_search_key : null;
        return view('Servicer::onProgress-service-job-list',['servicer_jobs'=> (new ServicerJob())->getOnProgressServiceList($key)]); 
     
    }
    //for completed service job list
    public function serviceJobHistoryList(Request $request)
    {
        $key = ( isset($request->completed_search_key) ) ? $request->completed_search_key : null;
        return view('Servicer::completedservicejob-history-list',['servicer_jobs'=> (new ServicerJob())->getCompletedServiceList($key)]); 
        // return view('Servicer::servicejob-history-list');
    }

    public function newInstallationJobDetails(Request $request)
    {

        $servicerjob_id = Crypt::decrypt($request->id);
       
        $current_stage=0;

        $pass_servicer_jobid=$request->id;
       
        if (!$servicerjob_id) { 
            $servicerjob_id="";
         }else
         {
            $servicerjob_id=Crypt::decrypt($request->id);
            
         }

        $service_engineer_installation     =  (new ServicerJob())->getServicerJob($servicerjob_id);
        
        if($service_engineer_installation  == null)
        {
            $request->session()->flash('message', 'jobs not found for the servicer');
            $request->session()->flash('alert-class', 'alert-danger');
        }
        else
        {
            $passed_stage_from_url     =    $service_engineer_installation->job_status;
           
           if($passed_stage_from_url   ==   0)
            {
                $job_plan              =    $service_engineer_installation->role;
           
                if($service_engineer_installation->unboxing_checklist != null)
                {
                     $unboxing_checklist    =    json_decode($service_engineer_installation->unboxing_checklist, true);
                 }
                else
                {
                    $check_list_configuration   =  (new Configuration())->getConfiguration('gps_unboxing_checklist');
              
                      if(isset($check_list_configuration[0])&& isset($job_plan))
                         {
                           $unboxing_checklist  =  json_decode($check_list_configuration[0]['value'],true )[$job_plan];
           
                           
                         }
                }
                $stage=$service_engineer_installation->job_status ;

                return view('Servicer::new-installation-first-step',['unboxing_checklist' => $unboxing_checklist,'servicerjob_id'=>$servicerjob_id,'pass_servicer_jobid'=>$pass_servicer_jobid]);
            }
            else if($passed_stage_from_url==1)
                {
                    return redirect('/servicer-installation-vehicle-details/'.$pass_servicer_jobid.'/vehicle-add');
                }
            else if($passed_stage_from_url==2)
                {
                 
                     return redirect('/servicer-installation-command-details/'.$pass_servicer_jobid.'/command-add');
                }
              
             else if(($passed_stage_from_url==3) || ($passed_stage_from_url==4)){
                     return redirect('/servicer-installation-devicetest-details/'.$pass_servicer_jobid.'/device-add');
               }
               }
           }

    public function getchecklist(Request $request)
    {
    
       
        $servicer_jobid =Crypt::decrypt($request->id);
        $pass_servicer_jobid=Crypt::encrypt($servicer_jobid);
       
        if(isset($_POST['checkbox_first_installation']))
            {
               $checklist   =   $_POST['checkbox_first_installation'];
            }
            else
            {
               $request->session()->flash('message', 'Please select atleast one checkobox');
               $request->session()->flash('alert-class', 'alert-danger');
               return redirect()->back()->with('success', ['your message,here']); 
            }
               $service_engineer_installation   = (new ServicerJob())->getServicerJob($servicer_jobid);
                 if($service_engineer_installation  == null)
                  {
                  $request->session()->flash('message', 'jobs not found for the servicer');
                  $request->session()->flash('alert-class', 'alert-danger');
                  }
                 else
                 {
                 $job_plan               =   $service_engineer_installation->role;
                 if($service_engineer_installation->unboxing_checklist != null)
                 {
                 $unboxing_checklist  = json_decode($service_engineer_installation->unboxing_checklist, true);
                 }
                else
                 {
                    $check_list_configuration   = (new Configuration())->getConfiguration('gps_unboxing_checklist');
                    if(isset($check_list_configuration[0])&& isset($job_plan))
                   {
                      $unboxing_checklist=json_decode($check_list_configuration[0]['value'],true )[$job_plan];
                   }
                  }
                  $check_list_items    =  $unboxing_checklist['checklist'][0]['items'];
                    $i=0;
                    foreach ($check_list_items as $items)
                    {
                    if (in_array($items['id'], $checklist))
                    {
                        $unboxing_checklist['checklist'][0]['items'][$i]['checked'] = true;
                    }else{
                        $unboxing_checklist['checklist'][0]['items'][$i]['checked'] = false;  
                    }
                    $i++;
                 }
                 $service_engineer_installation->unboxing_checklist = json_encode($unboxing_checklist,true);
                 $service_engineer_installation->job_status         = self::JOB_UNBOXING_STAGE;
                 $service_engineer_installation->status=  self::JOB_STATUS_IN_PROGRESS;
                 $service_engineer_installation->save();
                 return redirect('/servicer-installation-vehicle-details/'.$pass_servicer_jobid.'/vehicle-add');
 // for installation job completion
       
         }
    }

public function getVehicleAddPage(Request $request)
{

    $servicer_jobid=Crypt::decrypt($request->id);
    $pass_servicer_jobid=Crypt::encrypt($servicer_jobid);
    $current_stage=2;
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
                        'location',
                        'gps_id',
                        'unboxing_checklist',
                        'device_test_scenario',
                        'device_command','job_status',
                        'reinstallation_vehicle_id'
                    )
                    ->withTrashed()
                    ->where('id',crypt::decrypt($request->id))
                    ->with('gps:id,imei,serial_no')
                    ->with('clients:id,name')
                    ->with('user:id,email,mobile')
                    ->with('sub_dealer:user_id,name')
                    ->with('trader:user_id,name')
                    ->with('reinstallationVehicle')
                    ->first();

                    $client_id=$servicer_job->client_id;
                    $servicer_id=\Auth::user()->servicer->id;
                    $vehicleTypes=VehicleType::select(
                        'id','name'
                    )
                   ->get();
                    if($servicer_job  == null)
                  {
                  $request->session()->flash('message', 'jobs not found for the servicer');
                  $request->session()->flash('alert-class', 'alert-danger');
                  }
                 else
                 {
                    $passed_stage_from_url          =    $servicer_job->job_status;
                  
                   if($passed_stage_from_url       ==  1)
                     {
                        $drivers                   =    Driver::select('id','name')
                                                       ->where('client_id',$client_id)
                                                       ->get();
                        $makes                     =    VehicleMake::select('id','name')->get();
            
                        $models                   =    VehicleModels::select('id','name')->get();
                          

                           if($servicer_job == null)
                            {
                            return view('Servicer::404');
                            }
              
                            return view('Servicer::new-installation-second-step',['servicer_job' => $servicer_job,'vehicleTypes'=>$vehicleTypes,
                              'models'=>$models,'client_id'=>$request->id,'drivers'=>$drivers,'makes'=>$makes,
                               'servicerjob_id'=>$servicer_jobid,'pass_servicer_jobid'=>$request->id]);

                     } else if($passed_stage_from_url==0)
                     {
                      return redirect('/job/'.$pass_servicer_jobid.'/details');
                     }
                      else if($passed_stage_from_url==2)
                     {
                 
                     return redirect('/servicer-installation-command-details/'.$pass_servicer_jobid.'/command-add');
                     }
              
                         else if(($passed_stage_from_url==3) || ($passed_stage_from_url==4))  {
                      return redirect('/servicer-installation-devicetest-details/'.$pass_servicer_jobid.'/device-add');
                    }
                }

            }

 public function updateCommandcompleted(Request $request)
    {
        
             $servicer_jobid = Crypt::decrypt($request->id);
             $pass_servicer_jobid=Crypt::encrypt($servicer_jobid);

           if(isset($_POST['commandcheckbox']))
             {
                $command_selected_checkbox  =  $_POST['commandcheckbox'];
             }
             else
             {
                $request->session()->flash('message', 'Please select atleast one checkobox');
                $request->session()->flash('alert-class', 'alert-danger');
                return redirect()->back()->with('success', ['your message,here']); 
             }
            $service_eng_installation_command   =  (new ServicerJob())->getServicerJob($servicer_jobid);
            
             if($service_eng_installation_command  ==  null)
              {
              $request->session()->flash('message', 'jobs not found for the servicer');
              $request->session()->flash('alert-class', 'alert-danger');
              }
             else
              {
              $job_plan    =   $service_eng_installation_command->role;
                 if($service_eng_installation_command->device_command != null)
                  {
                    $command_configuration  = json_decode($service_eng_installation_command->device_command, true);
                    }
                    else
                    {
                     $command_configuration  =  (new Configuration())->getConfiguration('gps_init_commands');
                          $job_plan               =    'general';
                         if(isset($command_configuration[0])&& isset($job_plan)) 
                          {
                          $command_configuration   =    json_decode($command_configuration[0]['value'],true )[$job_plan];
                      }
                    }
                    $command_list_items    =  $command_configuration;
                     $i=0;
                        foreach ($command_list_items as $command_list)
                        {
                           if (in_array($command_list['id'], $command_selected_checkbox))
                           {
                            $command_configuration[$i]['checked']=true;
                             if($command_configuration[$i]['checked'] == true)
                            {
                            $command=$command_configuration[$i]['command'];
                            (new OtaResponse())->saveCommandsToDevice($service_eng_installation_command->gps_id,$command);
                            }   
                            }else
                            {
                             $command_configuration[$i]['checked']=false;
                            }
                            $i++;
                        }
                
                $service_eng_installation_command->device_command = json_encode($command_configuration,true); 
                $service_eng_installation_command->job_status  =  self::JOB_COMMAND_STAGE;
                $service_eng_installation_command->status      =  self::JOB_STATUS_IN_PROGRESS;
                $service_eng_installation_command->save();
                $stage= self::JOB_COMMAND_STAGE;
                  $request->session()->flash('message', 'Command added successfully!');
                  $request->session()->flash('alert-class', 'alert-success');
               }
                return redirect('/servicer-installation-devicetest-details/'.$pass_servicer_jobid.'/device-add');
     
             
    }

public function getDeviceTestAddPage(Request $request)
{

           $servicer_jobid = Crypt::decrypt($request->id);

           $device_test_installation_list = (new ServicerJob())->getInstallationJob($servicer_jobid);

            $stage=$device_test_installation_list->job_status;
             if($device_test_installation_list == null)
               {
               $request->session()->flash('message', 'jobs not found for the servicer');
               $request->session()->flash('alert-class', 'alert-danger');
               }
               else
               {
                $passed_stage_from_url               =    $device_test_installation_list->job_status;
                // dd($passed_stage_from_url);
             if (($passed_stage_from_url==3) || ($passed_stage_from_url==4))
                    // if($passed_stage_from_url  ==  3)
                    {
                    if($device_test_installation_list->device_test_scenario != null)
                    {
          
                    $device_test_case = json_decode($device_test_installation_list->device_test_scenario, true);
                    }
                   else
                    {

                    $device_test_case = (new Configuration())->getConfiguration('device_test_scenario');
            
                     if(isset($device_test_case[0])&& isset($device_test_installation_list->role)) 
                        {
                            $device_tests     = json_decode($device_test_case[0],true)['value'];
                            $device_test_case = json_decode($device_tests,true)[$device_test_installation_list->role]; 
                            $device_test_installation_list->device_test_scenario=json_encode($device_test_case,true );
                            $device_test_installation_list->save();
                        }
                    }
                     $request->session()->flash('message', 'Command added successfully!');
                     $request->session()->flash('alert-class', 'alert-success');
                    return view('Servicer::new-installation-fourth-step',['device_test_case'=>$device_test_case,'servicer_jobid'=>$servicer_jobid,'stage'=>$stage]);
                   }else if($passed_stage_from_url==0)
                     {
                      return redirect('/job/'.$pass_servicer_jobid.'/details');
                     }
                    else if($passed_stage_from_url==2)
                     {
                 
                     return redirect('/servicer-installation-command-details/'.$pass_servicer_jobid.'/command-add');
                    }
              
                    else if($passed_stage_from_url==1)  {
                      return redirect('/servicer-installation-vehicle-details/'.$pass_servicer_jobid.'/vehicle-add');
                    }
                 }
}
    public function startTest(Request $request)
    {
         $servicer_jobid  = $request->servicer_jobid;
         $pass_servicer_jobid=Crypt::encrypt($servicer_jobid);
         $servicer_job =  (new ServicerJob())->getServicerJob($servicer_jobid);
           
             if($servicer_job  ==  null)
              {
              $request->session()->flash('message', 'jobs not found for the servicer');
              $request->session()->flash('alert-class', 'alert-danger');
              }
             else
              {
                $servicer_job->job_status  = self::JOB_TEST_START_STAGE;
                $servicer_job->status      = self::JOB_STATUS_IN_PROGRESS;
                if($servicer_job->save())
                {
                    $gps_id=$servicer_job->gps_id;
                    
                    $gps=Gps::where('id',$gps_id)->first();

                    $gps->test_status   = self::JOB_DEVICE_TEST_START;
                    $gps->calibrated_on = null;
                    $gps->gps_fix_on    = null;
                    $gps->save();
                    $stage= self::JOB_TEST_START_STAGE;
                   
                }
                }
                 return redirect('/servicer-installation-devicetest-details/'.$pass_servicer_jobid.'/device-add');
                }
    
   


    public function completeTestCase(Request $request)
    {
       
     
             $servicer_jobid  = $request->id;
            
             $servicer_job =  (new ServicerJob())->getServicerJob($servicer_jobid);
             $gps=$servicer_job->gps_id;
             if($servicer_job  ==  null)
              {
              $request->session()->flash('message', 'jobs not found for the servicer');
              $request->session()->flash('alert-class', 'alert-danger');
              }
             else
              {
                  $job_completed_date = date("Y-m-d H:i:s");
                 
                $servicer_job->job_complete_date = $job_completed_date;
                $servicer_job->job_status  = self::JOB_COMPLETED_STAGE;
                $servicer_job->status      = self::JOB_STATUS_COMPLETED;
                if($servicer_job->save())
                {
                    $vehicle_daily_update = VehicleDailyUpdate::create([
                        'gps_id'          => $gps,
                        'km'              => 0,
                        'ignition_on'     => 0,
                        'ignition_off'    => 0,
                        'moving'          => 0,
                        'sleep'           => 0,
                        'halt'            => 0,
                        'stop'            => 0,
                        'ac_on'           => 0,
                        'ac_off'          => 0,
                        'ac_on_idle'      => 0,
                        'top_speed'       => 0,
                        'date'            =>  date("Y-m-d"),
                    ]);

                     $gps=Gps::where('id',$gps)->first();
                     $gps->test_status   = 0;
                     $gps->save();
                    
                }
                if( $servicer_job->job_type == 1 )
                {
                    return redirect(route('completed.installation.job.list'));
                }
                else if( $servicer_job->job_type == 3 )
                {
                    return redirect(route('reinstallation-job-history-list'));
                }
               }
          }

        public function sosButtonStop(Request $request)
        {
            $servicer_jobid=$request->servicer_jobid;
            $service_eng_installation_command   =  (new ServicerJob())->getServicerJob($servicer_jobid);
            
            if($service_eng_installation_command  ==  null)
            {
            $request->session()->flash('message', 'jobs not found for the servicer');
            $request->session()->flash('alert-class', 'alert-danger');
            }else
            {
                 $sos_button_test_type     =   self::SOS_TEST_TYPE_STOP;
                 $gps_id                   =   $service_eng_installation_command->gps_id;
                if($sos_button_test_type  == self::SOS_TEST_TYPE_STOP)
                {
                    $ota_command           =    'SET EO';
                    $ota_eo_response       =    (new OtaResponse())->checkOTARequested(self::OTA_COMMAND_EMERGENCY_OFF, $gps_id);
                    if($ota_eo_response > 0)
                    {
                       
                       return response()->json(['success' =>"success", 'message' => " Stop Command Already Send" ]);  
                    }
                    else
                    {
                        $otaResponse           =  new OtaResponse();
                        $otaResponse->gps_id   =  $gps_id;

                        $otaResponse->response = self::OTA_COMMAND_EMERGENCY_OFF;
                        if ($otaResponse->save())
                        {
                            return response()->json([ 'success' =>"success", 'message' => "SOS Button Stopped Successfully"]);
                        }
                        else
                        {
                           return response()->json([  'success' => $this->success, 'message' => "failed" ]);
                        }
                    }
                }
            }
            
         }
          public function sosButtonReset(Request $request)
        {
            $servicer_jobid=$request->servicer_jobid;
         
            $service_eng_installation_job   =  (new ServicerJob())->getServicerJob($servicer_jobid);
             if($service_eng_installation_job  ==  null)
            {
              return response()->json([  'message' => "Jobs Not Found "]);
            }else
            {
             $sos_button_test_type=self::SOS_TEST_TYPE_RESET;
             if($sos_button_test_type == self::SOS_TEST_TYPE_RESET)
                {
                   $gps_id=$service_eng_installation_job->gps_id;
                    
                    $gps=Gps::where('id',$gps_id)->first();
                    $gps->emergency_status     = 0;
                    $gps->test_status          = 1;
                     $gps->save();
                    // update json response
                    $device_test               = json_decode($service_eng_installation_job->device_test_scenario, true);
                 
                    $device_test['tests'][4]['sos']['status']   = 0;
                    $device_test['tests'][4]['test_status']     = 0;
                    $service_eng_installation_job->device_test_scenario     = json_encode($device_test, true);

                    $service_eng_installation_job->save();
                    $this->message                              = 'Success';
                    return response()->json([  'message' => "SOS Button Reset Activated Sucessfuly"]);
                }
                
            
            }
        }
        

//old job completion of installation
//  public function jobDetails(Request $request)
//     {

//         $decrypted = Crypt::decrypt($request->id);
//         $servicer_job = ServicerJob::select(
//             'id',
//             'servicer_id',
//             'client_id',
//             'job_id',
//             'job_type',
//             'user_id',
//             'description',
//             'job_date',
//             'job_complete_date',
//             'status',
//             'latitude',
//             'longitude',
//             'location',
//             'gps_id',
//             'unboxing_checklist',
//             'device_test_scenario',
//             'device_command'
//         )
//         ->withTrashed()
//         ->where('id', $decrypted)
//         ->with('gps:id,imei,serial_no')
//         ->with('clients:id,name')
//         ->with('user:id,email,mobile')
//         ->with('sub_dealer:user_id,name')
//         ->with('trader:user_id,name')
//         ->first();
//         $client_id=$servicer_job->client_id;
//         // dd($client_id);
//         $servicer_id=\Auth::user()->servicer->id;
//         $vehicleTypes=VehicleType::select(
//             'id','name'
//         )
//         ->get();
//         $drivers=Driver::select('id','name')
//         ->where('client_id',$client_id)
//         ->get();
//          $makes=VehicleMake::select('id','name')->get();

//          $models=VehicleModels::select('id','name')->get();
//        if($servicer_job == null){
//            return view('Servicer::404');
//         }
//         return view('Servicer::job-details',['servicer_job' => $servicer_job,'vehicleTypes'=>$vehicleTypes,'models'=>$models,'client_id'=>$request->id,'drivers'=>$drivers,'makes'=>$makes]);
//     }
// FOR SERVICE
public function serviceJobDetails(Request $request)
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
        ->with('gps:id,imei,serial_no')
        ->with('clients:id,name')
        ->with('user:id,email,mobile')
        ->with('sub_dealer:user_id,name')
        ->with('trader:user_id,name')
        ->first();
        $client_id=$servicer_job->client_id;
        $servicer_id=\Auth::user()->servicer->id;
        $vehicleTypes=VehicleType::select(
            'id','name'
        )
        ->get();
        $drivers=Driver::select('id','name')
        ->where('client_id',$client_id)
        ->get();

         $models=VehicleModels::select('id','name')->get();
       if($servicer_job == null){
           return view('Servicer::404');
        }
        return view('Servicer::service-job-details',['servicer_job' => $servicer_job,'vehicleTypes'=>$vehicleTypes,'models'=>$models,'client_id'=>$request->id,'drivers'=>$drivers]);
    }

    public function serviceJobedit(Request $request)
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
            'gps_id',
            'job_complete_date',
            \DB::raw('Date(job_date) as job_date'),
            'created_at',
            'location',
            'status'
        )
        ->withTrashed()
        ->where('id', $decrypted)
        ->with('gps:id,imei,serial_no')
        ->with('clients:id,name')
        ->with('user:id,email,mobile')
        ->with('sub_dealer:user_id,name')
        ->with('trader:user_id,name')
        ->first();
        $job_id=$servicer_job->job_id;
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

         $models=VehicleModels::select('id','name')->get();
       if($servicer_job == null){
           return view('Servicer::404');
        }
        return view('Servicer::service-job-edit',['servicer_job' => $servicer_job,'vehicleTypes'=>$vehicleTypes,'models'=>$models,'client_id'=>$request->id,'drivers'=>$drivers]);
    }
    public function vehicleDataUpdated(Request $request)
    {
     
        $servicer_jobid = Crypt::decrypt($request->id);

        $pass_servicer_jobid=Crypt::encrypt($servicer_jobid);
        $servicer_job = ServicerJob::find($servicer_jobid);
        if( $servicer_job->job_type == 1 )
        {
            $custom_messages = [
                'file.required' => 'Rc Book cannot be blank',
                 // 'file.uploaded' => 'Failed to upload an image. The image maximum size is 4kb.'
                'installation_photo.required' => 'File cannot be blank',
                'activation_photo.required' => 'File cannot be blank',
                'vehicle_photo.required' => 'File cannot be blank'
            ];
          
            $rules = $this->servicercompleteJobRules();
            $this->validate($request,$rules,$custom_messages);
            //$job_completed_date = date("Y-m-d H:i:s");
            // $servicer_job->job_complete_date = $job_completed_date;
            $driver_id=$request->driver;
            // $driver = Driver::find($driver_id);
            // $servicer_job->comment      =   $request->comment;
            $servicer_job->status       =   2;
            $servicer_job->job_status   =   2;
            $is_service_job_update      =   $servicer_job->save();
            if($is_service_job_update)
            {
                $name                   =   $request->name;
                $register_number        =   $request->register_number;
                $vehicle_type_id        =   $request->vehicle_type_id;
                $gps_id                 =   $request->gps_id;
                $client_id              =   $request->client_id;
                $servicer_job_id        =   $request->servicer_job_id;
                $engine_number          =   $request->engine_number;
                $chassis_number         =   $request->chassis_number;
                $model                  =   $request->model;

                $vehicle_create= Vehicle::create([
                    'name' => $name,
                    'register_number' => $register_number,
                    'vehicle_type_id' => $vehicle_type_id,
                    'gps_id' => $gps_id,
                    'client_id' => $client_id,
                    'servicer_job_id' =>$servicer_job->id,
                    'model_id' =>$model,
                    'engine_number' => $engine_number,
                    'chassis_number' => $chassis_number,
                    'driver_id' => $driver_id,
                    'status' => 1
                ]);
                if($driver_id)
                {
                    $driver_vehicle_history= DriverVehicleHistory::create([
                        'vehicle_id' => $vehicle_create->id,
                        'driver_id' => $driver_id,
                        'from_date' =>  date('Y-m-d')
                    ]);
                }
                if($vehicle_create)
                {

                    (new VehicleGps())->createNewVehicleGpsLog($vehicle_create->id,$gps_id,$servicer_jobid);

                    $client                         =   Client::find($client_id);
                    $client->latest_vehicle_updates =   date('Y-m-d H:i:s');
                    $client->save();
                    $file                           =   $request->file;
                    $installation_photo             =   $request->installation_photo;
                    $activation_photo               =   $request->activation_photo;
                    $vehicle_photo                  =   $request->vehicle_photo;
                    $passed_expiry_date                   =   $request->expiry_date;

                    $expiry_date                    =   date("Y-m-d",strtotime($passed_expiry_date));
                    
                  
                    $getFileExt                     =   $file->getClientOriginalExtension();
                    $uploadedFile                   =   'rcbook'.time().'.'.$getFileExt;
                    //Move Uploaded File
                    $destinationPath                =   'documents/vehicledocs';
                    $file->move($destinationPath,$uploadedFile);

                    $getInstallationFileExt         =   $installation_photo->getClientOriginalExtension();
                    $uploadedInstallationFile       =   'installation'.time().'.'.$getInstallationFileExt;
                    $installation_photo->move($destinationPath,$uploadedInstallationFile);

                    $getActivationFileExt           =   $activation_photo->getClientOriginalExtension();
                    $uploadedActivationFile         =   'activation'.time().'.'.$getActivationFileExt;
                    $activation_photo->move($destinationPath,$uploadedActivationFile);

                    $getVehicleFileExt              =   $vehicle_photo->getClientOriginalExtension();
                    $uploadedVehicleFile            =   'vehicle_photo'.time().'.'.$getVehicleFileExt;
                    $vehicle_photo->move($destinationPath,$uploadedVehicleFile);
                   
                      $documents = Document::create([
                        'vehicle_id'        =>  $vehicle_create->id,
                        'document_type_id'  =>  1,
                        'expiry_date'       => $expiry_date,
                        'path'              =>  $uploadedFile,
                    ]);
                   
                    $installation_documents = Document::create([
                        'vehicle_id'        =>  $vehicle_create->id,
                        'document_type_id'  =>  6,
                        'expiry_date'       =>  null,
                        'path'              =>  $uploadedInstallationFile,
                    ]);
                    $activation_documents = Document::create([
                        'vehicle_id'        =>  $vehicle_create->id,
                        'document_type_id'  =>  7,
                        'expiry_date'       =>  null,
                        'path'              =>  $uploadedActivationFile,
                    ]);
                    $vehicle_photo = Document::create([
                        'vehicle_id'        =>  $vehicle_create->id,
                        'document_type_id'  =>  8,
                        'expiry_date'       =>  null,
                        'path'              =>  $uploadedVehicleFile,
                    ]);
                }
                
            }
            else
            {
                $request->session()->flash('message', 'Something went wrong!');
                $request->session()->flash('alert-class', 'alert-danger');
            }
        }
        else if( $servicer_job->job_type == 3 )
        {
            $rules = $this->servicercompleteJobRulesForReinstallation();
            $this->validate($request,$rules);
            $driver_id                  =   $request->driver;
            $vehicle_id                 =   $request->vehicle_id;
            $gps_id                     =   $request->gps_id;
            $vehicle_details            =   (new Vehicle())->getSingleVehicleDetailsBasedOnVehicleId($vehicle_id);
            // $servicer_job->comment      =   $request->comment;
            $servicer_job->status       =   2;
            $servicer_job->job_status   =   2;
            $is_service_job_update      =   $servicer_job->save();
            if($is_service_job_update)
            {
                $vehicle_details->is_returned                       =   0;
                $vehicle_details->is_reinstallation_job_created     =   0;
                $vehicle_details->gps_id                            =   $gps_id;
                $vehicle_details->servicer_job_id                   =   $servicer_jobid;
                $is_vehicle_details_update                          =   $vehicle_details->save();
                if($is_vehicle_details_update)
                {
                    (new VehicleGps())->createNewVehicleGpsLog($vehicle_id,$gps_id,$servicer_jobid);
                }
            }
        }
        
        $request->session()->flash('message', 'Vehicle Details Added successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect('/servicer-installation-command-details/'.$pass_servicer_jobid.'/command-add');
        }
     
//for command list 
 public function getCommandAddPage(Request $request)
 {
    $servicer_jobid=Crypt::decrypt($request->id);

          $service_eng_installation_command   = (new ServicerJob())->getInstallationJob($servicer_jobid);
      //for listing command
        if($service_eng_installation_command  == null)
        {
            $request->session()->flash('message', 'jobs not found for the servicer');
            $request->session()->flash('alert-class', 'alert-danger');
        }
        else
        {
            $passed_stage_from_url        =    $service_eng_installation_command->job_status;
            
            if($passed_stage_from_url == 2)
            {
             
                if($service_eng_installation_command->device_command != null)
                    {
                    $command_configuration  = json_decode($service_eng_installation_command->device_command,true);
                    }
                    else
                    {
                    $command_configuration  = (new Configuration())->getConfiguration('gps_init_commands');
                        $job_plan               = 'general';
                         if(isset($command_configuration[0])&& isset($job_plan)) {
                         $command_configuration=json_decode($command_configuration[0]['value'],true )[$job_plan];

                    }
                    }
                 return view('Servicer::new-installation-third-step',['command_configuration' => $command_configuration,
               'servicer_jobid'=>$servicer_jobid,'pass_servicer_jobid'=>$request->id]);
            }
            else if($passed_stage_from_url==1)
                {
                    return redirect('/servicer-installation-vehicle-details/'.$pass_servicer_jobid.'/vehicle-add');
                }
            else if($passed_stage_from_url==0)
                {
                     return redirect('/job/'.$pass_servicer_jobid.'/details');
                    
                }
              
            else if(($passed_stage_from_url==3) || ($passed_stage_from_url==4)) {
                     return redirect('/servicer-installation-devicetest-details/'.$pass_servicer_jobid.'/device-add');
               }
     
        }


 }
    // for service job save
 
    public function jobSave(Request $request)
    {

        $job_completed_date = date("Y-m-d H:i:s");
        $servicer_job = ServicerJob::find($request->id);
        if($servicer_job!=null)
        {
            $servicer_job->job_complete_date = $job_completed_date;
            $servicer_job->comment = $request->comment;
            $servicer_job->status = 3;
            $servicer_job->save();
            // dd($servicer_job->id);
             // dd($servicer_job->id);
            $service_job_id=Crypt::encrypt($servicer_job->id);
            $request->session()->flash('message', 'Job  completed successfully!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect()->route('completed.service.job.list');
            // return redirect()->route('job.history.details',['id' => encrypt($servicer_job->id)]);
       }else
       {
             $request->session()->flash('message', 'Job completion failed');
             $request->session()->flash('alert-class', 'alert-danger');
             return redirect()->route('servicerjob.history.list');

      }
    }

    public function jobstatuscomplete(Request $request)
    {
      $job_completed_date=date("Y-m-d H:i:s");
        $servicer_job = ServicerJob::find($request->id);
        if($servicer_job!=null)
        {
            $servicer_job->job_complete_date = $job_completed_date;
            $servicer_job->comment = $request->comment;
            $servicer_job->status = 3;
            $servicer_job->save();
            $service_job_id=Crypt::encrypt($servicer_job->id);
       }
       else
       {
            return response()->json([
                'status' => 1,
                'title' => 'Failed',
                'message' => 'Something went wrong'
            ]);
             // $request->session()->flash('message', 'Job completion failed');
             // $request->session()->flash('alert-class', 'alert-danger');
             // return redirect()->route('job.history.details');
        }
    }

    public function jobupdate(Request $request)
    {

        $servicer_job = ServicerJob::find($request->id);
        // dd( $servicer_job);
        if($servicer_job!=null)
        {
            $servicer_job->comment = $request->comment;
            $servicer_job->status = 2;
            $servicer_job->save();
            // dd($servicer_job->id);
            $service_job_id=Crypt::encrypt($servicer_job->id);
            $request->session()->flash('message', 'Comments added successfully!');
            $request->session()->flash('alert-class', 'alert-success');
            // return redirect()->route('job.history.details',['id' => $service_job_id]);
             // return redirect()->back();
            return redirect()->route('service.job.list');

       }
       else
       {
            $request->session()->flash('message', 'Coments adding failed');
            $request->session()->flash('alert-class', 'alert-danger');
            return redirect()->route('service.job.list');
        }
    }

    // save vehicle

     public function jobCompleteCertificate(Request $request)
    {

        return view('Servicer::servicer-cerificate',['id'=>$request->id]);
    }

    public function downloadJobCompleteCertificate(Request $request){
        
        $servicer_job_id = Crypt::decrypt($request->id);
        $servicer_job = ServicerJob::find($servicer_job_id);
        $user_id=$servicer_job->user_id;
        $gps_id=$servicer_job->gps_id;
        $vehicle=Vehicle::select('id')->where('gps_id',$gps_id)->first();
        $fitment_images=Document::select('path')->where('vehicle_id',$vehicle->id)->get();
        // dd($fitment_images['3']->path);
        $dealer=SubDealer::where('user_id',$user_id)->first();
        $trader=Trader::where('user_id',$user_id)->first();
        $root=Root::where('user_id',$user_id)->first();
        if($dealer){
            $dealer_trader=$dealer;
        }
        elseif($trader)
        {
            $dealer_trader=$trader;
        }
        else
        {
            $dealer_trader=$root;
        }
        $client_id=$servicer_job->client_id;
        $client = Client::find($client_id);
        $vehicle_servicer_job_log    =   (new VehicleGps())->getVehicleGpsLogBasedOnServicerJob($servicer_job_id);
        if($servicer_job == null){
           return view('Servicer::404');
        }
        $pdf = PDF::loadView('Servicer::installation-certificate-download',['servicer_job' => $servicer_job,'vehicle_servicer_job_log'=> $vehicle_servicer_job_log,'client' => $client,'dealer_trader'=>$dealer_trader,'fitment_images' => $fitment_images]);
        return $pdf->download('installation-certificate.pdf');
    }

    public function jobHistoryList(Request $request)
    {
        $key = ( isset($request->new_installation_search_key) ) ? $request->new_installation_search_key : null;
        return view('Servicer::completed-installation-history-list',['servicer_jobs'=> (new ServicerJob())->getCompletedInstallationList($key)]); 
    }

    public function ReinstallationJobHistoryList(Request $request)
    {
        $key = ( isset($request->new_installation_search_key) ) ? $request->new_installation_search_key : null;
        return view('Servicer::reinstallation-history-list',['servicer_jobs'=> (new ServicerJob())->getCompletedReinstallationList($key)]); 
       
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
             'job_date',
            'created_at',
            'status',
            'location',
            'gps_id'
        )
        ->where('servicer_id',$user_id)
        ->whereNotNull('job_complete_date')
         ->where('job_type',1)
        ->with('user:id,username')
        ->with('gps:id,imei,serial_no')
        ->with('clients:id,name')
        ->with('servicer:id,name')
        ->with('vehicle:id,register_number,gps_id')
        ->orderBy('job_complete_date','desc')
        ->where('status',3)
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


 public function getserviceJobsHistoryList()
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
            'job_date',
            'created_at',
            'status',
            'location',
            'gps_id'
        )
        ->where('servicer_id',$user_id)
        ->whereNotNull('job_complete_date')
         ->where('job_type',2)
        ->with('user:id,username')
        ->with('gps:id,imei,serial_no')
        ->with('clients:id,name')
        ->with('servicer:id,name')
        ->with('vehicle:id,register_number,gps_id')
         ->orderBy('job_complete_date','Desc')
         ->where('status',3)
        ->get();
        // dd($servicer_job);
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
         //    $latitude= $servicer_job->latitude;
         //    $longitude=$servicer_job->longitude;
         //    if(!empty($latitude) && !empty($longitude)){
         //        //Send request and receive json data by address
         //        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.config("eclipse.keys.googleMap").'&libraries=drawing&callback=initMap');
         //        $output = json_decode($geocodeFromLatLong);
         //        $status = $output->status;
         //        //Get address from json data
         //        $address = ($status=="OK")?$output->results[1]->formatted_address:'';
         //        //Return address of the given latitude and longitude
         //        if(!empty($address)){
         //            $location=$address;
         //            return $location;
         //        }
         //    }
         //    else
         //    {
         //        return "No Address";
         //    }
         // })
         ->addColumn('action', function ($servicer_job) {
           $b_url = \URL::to('/');
                return "
                <a href=".$b_url."/servicer-job-history/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";

        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function jobHistoryDetails(Request $request)
    {
        $decrypted          =   Crypt::decrypt($request->id);
        $servicer_job       =   ServicerJob::withTrashed()->where('id', $decrypted)->first();
        $client_id          =   $servicer_job->client_id;
        $vehicle_device     =   (new VehicleGps())->getVehicleGpsLogBasedOnGps($servicer_job->gps_id);
        if($servicer_job == null){
           return view('Servicer::404');
        }
        
        return view('Servicer::job-history-details',['servicer_job' => $servicer_job,'vehicle_device' => $vehicle_device]);
    }




    public function serviceJobHistoryDetails(Request $request)
    {
        $decrypted          =   Crypt::decrypt($request->id);
        $servicer_job       =   ServicerJob::withTrashed()->where('id', $decrypted)->first();
        $client_id          =   $servicer_job->client_id;
        $vehicle_device     =   (new VehicleGps())->getVehicleGpsLogBasedOnGps($servicer_job->gps_id);
        if($servicer_job == null){
           return view('Servicer::404');
        }
        return view('Servicer::service-job-history-details',['servicer_job' => $servicer_job,'vehicle_device' => $vehicle_device]);
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
    // function getPlaceLatLng($address){

    //     $data = urlencode($address);
    //     $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $data . "&sensor=false&key=".config('eclipse.keys.googleMap');
    //     $geocode_stats = file_get_contents($url);
    //     $output_deals = json_decode($geocode_stats);
    //     if ($output_deals->status != "OK") {
    //         return null;
    //     }
    //     if ($output_deals) {
    //         $latLng = $output_deals->results[0]->geometry->location;
    //         $lat = $latLng->lat;
    //         $lng = $latLng->lng;
    //         $locationData = ["latitude" => $lat, "logitude" => $lng];
    //         return $locationData;
    //     } else {
    //         return null;
    //     }
    // }
################################################################################


    //device details based on client selection in assign job page
    public function clientGpsList(Request $request)
    {
        $user           =   $request->user();
        $client_id      =   $request->client_id;
        if($client_id != 0)
        {
            $job_type   =   $request->job_type;
            $client     =   (new Client())->getClientDetailsWithClientId($client_id);
            $latitude   =   $client->latitude;
            $longitude  =   $client->longitude;
            $address    =   $client->location;
            if(!empty($address))
            {
                $location   =   $address;
            }
            else
            {
                $location   =   "No Address Found";
            }

            $gps_stocks     =   GpsStock::select('id',
                                                'gps_id',
                                                'client_id'
                                            )
                                            ->where('client_id',$client_id)
                                            ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                            })
                                            ->get();

            $stock_gps_id   =   [];
            foreach($gps_stocks as $stock_gps){
                $stock_gps_id[]     =   $stock_gps->gps_id;
            }
            
             $gps_transferItems     =   GpsTransferItems::select('id',
                                                'gps_id'
                                                
                                            )
                                         ->whereIn('gps_id',$stock_gps_id)
                                            ->orderBy('id','desc')
                                            ->groupBy('gps_id')
                                            ->get();

            $tansfer_items_gps_id   =   [];
            foreach($gps_transferItems as $gps_transferItem){
                $tansfer_items_gps_id[]     =   $gps_transferItem->gps_id;
            }
// dd($tansfer_items_gps_id);
            if($stock_gps_id)
            {
                $vehicle_device     =   Vehicle::select(
                                            'gps_id',
                                            'id',
                                            'register_number',
                                            'name'
                                        )
                                        ->where('client_id',$client_id)
                                        ->get();
                $single_gps     =   [];
                foreach($vehicle_device as $device){
                    $single_gps[]   =   $device->gps_id;
                }

                $servicer_jobs  =   ServicerJob::select(
                                        'gps_id',
                                        'servicer_id',
                                        'user_id',
                                        'client_id'
                                    )
                                    ->where('client_id',$client_id)
                                    ->get();
                $servicer_gps   =   [];
                foreach($servicer_jobs as $servicer_job){
                    $servicer_gps[]     =   $servicer_job->gps_id;
                }
                // dd($servicer_gps);
                // $devices=Gps::select('id','imei','serial_no')
                // ->whereIn('id',$stock_gps_id)
                // ->whereNotIn('id',$single_gps)
                // ->whereNotIn('id',$servicer_gps)
                // ->get();

                $reinstallation_needed_vehicles =   [];
                if($job_type == 1 )
                {
                    $devices=Gps::select('id','imei','serial_no')
                                ->whereIn('id',$stock_gps_id)
                                ->whereNotIn('id',$single_gps)
                                ->whereNotIn('id',$servicer_gps)
                                ->get();

                }
                else if($job_type == 3 )
                {
                    $devices    =   Gps::select('id','imei','serial_no')
                                        ->whereIn('id',$stock_gps_id)
                                        ->whereNotIn('id',$single_gps)
                                        ->whereNotIn('id',$servicer_gps)
                                        ->get();
                    $reinstallation_needed_vehicles    =   (new Vehicle())->getReinstallationNeededVehiclesBasedOnClient($client_id); 

                }
                else if($job_type==2)
                {
                    $devices=Gps::select('id','imei','serial_no')
                                ->whereIn('id',$tansfer_items_gps_id)
                                ->whereIn('id',$single_gps)
                                ->whereIn('id',$servicer_gps)
                                ->get();
                }else{
                 $devices=[];
                }
                // if($user->hasRole('sub_dealer')){
                if($devices)
                {
                    $response_data = array(
                        'status'    => 'client-gps',
                        'devices'   => $devices,
                        'location'  => $location,
                        'vehicles'  => $reinstallation_needed_vehicles,
                        'job_type'  => $job_type,
                        'code'      => 1
                    );
                }
                else{
                    $response_data = array(
                        'status'  => 'failed',
                        'message' => 'no devices are waiting for installation',
                        'location'  => $location,
                        'job_type'  => $job_type,
                        'code'    =>2
                    );
                }
            }
            else
            {
                $response_data = array(
                        'status'  => 'failed',
                        'message' => 'no gps transferred to this client',
                        'location'  => $location,
                        'job_type'  => $job_type,
                        'code'    =>2
                    );
            }
        }else
        {
            $response_data = array(
                        'status'  => 'failed',
                        'message' => 'failed',
                        'code'    =>0
                        );
        }
        return response()->json($response_data);

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
             'job_date',
            'created_at',
            'gps_id',
            'status'
        )
        ->where('user_id',$user_id)
        ->whereNotNull('job_complete_date')
        ->with('vehicleGpsWithGpsId.vehicle')
        ->with('user:id,username')
        ->with('gps:id,imei,serial_no')
        ->with('clients:id,name')
        ->with('servicer:id,name')
        ->orderBy('id','Desc')
        ->get();

        return DataTables::of($servicer_job)
        ->addIndexColumn()
         ->addColumn('job_type', function ($servicer_job) {
            if($servicer_job->job_type == 1)
            {
                return "Installation" ;
            }
            else if($servicer_job->job_type == 3)
            {
                return "Reinstallation" ;
            }
            else if($servicer_job->job_type == 2)
            {
                return "Service" ;
            }

         })
         ->addColumn('action', function ($servicer_job) {
           $b_url = \URL::to('/');
            if($servicer_job->job_type==1)
            {
                return "
                <a href=".$b_url."/job-history/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";
            }
            else if($servicer_job->job_type==3)
            {
                return "
                <a href=".$b_url."/job-history/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";
            }
            else if($servicer_job->job_type==2)
            {
                return "
                <a href=".$b_url."/servicer-job-history/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";
            }

        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

     public function servicerProfile()
    {
        $servicer_id = \Auth::user()->servicer->id;
        $servicer_user_id = \Auth::user()->id;
        $servicer = Servicer::withTrashed()->where('id', $servicer_id)->first();
        $user=User::find($servicer_user_id);
        if($servicer == null)
        {
           return view('Servicer::404');
        }
        return view('Servicer::servicer-profile',['servicer' => $servicer,'user' => $user]);
    }



     //for edit page of employee password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $servicer = Servicer::where('user_id', $decrypted)->first();
        // $dealer = Dealer::find($decrypted);
        if($servicer == null){
           return view('Servicer::404');
        }
        return view('Servicer::servicer-change-password',['servicer' => $servicer]);
    }
    //update password
    public function updatePassword(Request $request)
    {
        $servicer=User::find($request->id);
        if($servicer== null){
            return view('SubDealer::404');
        }
        $did=encrypt($servicer->id);
        // dd($request->password);
        $rules=$this->updatePasswordRule();
        $this->validate($request,$rules);
        $servicer->password=bcrypt($request->password);
        $servicer->save();
        $request->session()->flash('message','Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('servicer.change-password',$did));
    }

    public function servicerProfileEdit()
    {
        $servicer_id = \Auth::user()->servicer->id;
        $servicer_user_id = \Auth::user()->id;
        $servicer = Servicer::withTrashed()->where('id', $servicer_id)->first();
        $user=User::find($servicer_user_id);


        if($servicer == null)
        {
           return view('Servicer::404');
        }

        return view('Servicer::servicer-profile-edit',['servicer' => $servicer,'user' => $user]);
    }
     //update dealers details
    public function profileUpdate(Request $request)
    {
        $servicer = Servicer::where('user_id', $request->id)->first();
        if($servicer == null){
           return view('Client::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->rayfleetservicerProfileUpdateRules($servicer);
        }
        else if (strpos($url, $eclipse_key) == true) {
            $rules = $this->servicerProfileUpdateRules($servicer);
        }
        else
        {
           $rules = $this->servicerProfileUpdateRules($servicer);
        }

        $this->validate($request, $rules);
        $servicer->name = $request->name;
        $servicer->address = $request->address;
        $servicer->save();
        $user = User::find($request->id);
        $user->mobile = $request->phone_number;
        $user->email = $request->email;
        $user->save();
        $did = encrypt($user->id);
        // $subdealer->phone_number = $request->phone_number;
        // $did = encrypt($subdealer->id);
        $request->session()->flash('message', 'Service engineer details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('servicer.profile'));
    }

    public function pendingJob()
    {
        return view('Servicer::pending-job-list');
    }
     public function pendingJobList()
    {
        $user_id=\Auth::user()->servicer->id;
        // dd($user_id);
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
            // \DB::raw('Date(job_date) as job_date'),
            'job_date',
            'created_at',
            'location',
            'status'
        )
        ->where('servicer_id',$user_id)
        ->whereNull('job_complete_date')
        ->with('gps:id,imei,serial_no')
        ->with('user:id,username')
        ->with('clients:id,name')
        ->with('servicer:id,name')
        ->where('job_date','<',date('Y-m-d H:i:s'))
        ->orderBy('job_date','Desc')
        ->with('vehicle:id,register_number,gps_id')
        // ->where('status',2)
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
            if($servicer_job->status==0){
                return "<font color='red'>Cancelled</font>";
            }else
            {
                if($servicer_job->status==1)
                {
                    if($servicer_job->job_type==1)
                    {
                        return "
                     <a href=".$b_url."/job/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='Job completion'></i>Job Completion</a>";
                    }
                    else
                    {
                        return "
                        <a href=".$b_url."/servicejob/".Crypt::encrypt($servicer_job->id)."/servicedetails class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='Job completion'></i>Job Completion</a>";
                    }
                }

                else if($servicer_job->status==2)
                {
                    if($servicer_job->job_type==1)
                    {
                        return "
                     <a href=".$b_url."/job/".Crypt::encrypt($servicer_job->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='Job completion'></i>Job Completion</a>";
                    }
                    else
                    {
                        return "
                        <a href=".$b_url."/servicejob/".Crypt::encrypt($servicer_job->id)."/servicedetails class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='Job completion'></i>Job Completion</a>";
                    }
                }
                else
                {
                    return "<font color='red'>Cancelled</font>";
                }
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    public function getVehicleModels(Request $request)
    {
        $user = $request->user();
        $make_id=$request->make_id;
        $vehicle_models=VehicleModels::select('id','vehicle_make_id','name')
        ->where('vehicle_make_id',$make_id)
        ->get();
        if($vehicle_models)
        {
            $response_data = array(
                'status'  => 'vehicleModels',
                'vehicle_models' => $vehicle_models

            );
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


 //for service eng password change
    public function changeServicerPassword(Request $request)
        {
            $decrypted = Crypt::decrypt($request->id);
            $servicer = Servicer::where('user_id',$decrypted)->first();
            if($servicer == null)
            {
               return view('Servicer::404');
            }
            return view('Servicer::change-password-servicer',['servicer' => $servicer]);
        }

 //update password of service eng in common
    public function updateServicerPassword(Request $request)
    {
        $servicer=User::find($request->id);
        if($servicer== null){
            return view('Servicer::404');
        }
        $did=encrypt($servicer->id);
        $rules=$this->updatePasswordRule();
        $this->validate($request,$rules);
        $servicer->password=bcrypt($request->password);
        $servicer->save();
        $request->session()->flash('message','Password updated successfully!');
        $request->session()->flash('alert-class','alert-success');
        return redirect(route('servicer.list'));

    }


    public static function fcmPushNotification($device_id,$tttle,$message)
    {
        $api_key = 'AAAAgmOkdoQ:APA91bE2v6k93s_cXtcscgODZkDBFT2_D-6DpY_aPt_pwpvKJBHjSURcHrxh4TJfPoNPAOjmp8J7AEVQsNd7eAjr1HHSZ5quR4mz6JRgQtfaE47BYwrwrlVuTp8fJgfLDbmjWumfmVdF';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $title = $tttle;
        $body = json_encode($message,true);
        $n = [
            "to"=> $device_id,
            "data" => [
                "title" => $title,
                "content" => $body,
            ]
        ];
   
        $fields = array (
                'registration_ids' => array (
                        $device_id
                ),
                'data' => array (
                        "message" => $message
                )
        );
        $fields = json_encode ( $fields );
    
        $headers = array (
                'Authorization: key=' . $api_key,
                'Content-Type: application/json'
        );
    
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($n) );
    
        $result = curl_exec ( $ch );
        // echo $result;
        curl_close ( $ch );

        FcmLog::create([
            'user_device_id' => $device_id,
            'body' => $fields,
            'response' => $result
        ]);
    
    }

    public function clientJobList(Request $request)
    {
        $key = ( isset($request->new_service_search_key) ) ? $request->new_service_search_key : null;
        return view('Servicer::new-client-service-job-list',['servicer_jobs'=> (new ServicerJob())->getNewClientServiceList($key)]);  
  
    }
public function servicerProfileUpdateRules($servicer)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$servicer->user_id,
            'email' => 'required|string|unique:users,email,'.$servicer->user_id


        ];
        return  $rules;
    }
    public function rayfleetservicerProfileUpdateRules($servicer)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$servicer->user_id,
            'email' => 'required|string|unique:users,email,'.$servicer->user_id


        ];
        return  $rules;
    }
    public function clientProfileUpdateRules($client)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$client->user_id,
            'email' => 'required|string|unique:users,email,'.$client->user_id


        ];
        return  $rules;
    }


   public function updateChecklistRule()
    {
        $rules=[
             'checkbox_first_installation' => 'required',
             'checkbox_first_installation.*' => 'numeric',
              ];
        return $rules;
    }

    public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }
    public function servicerCreateRules()
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'address' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile'

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
            'engine_number' => 'required|unique:vehicles',
            'chassis_number' => 'required|unique:vehicles',
            'name' => 'required',
            'file' => 'required|mimes:jpeg,png|max:4096',
            'installation_photo' => 'required|mimes:jpeg,png|max:4096',
            'activation_photo' => 'required|mimes:jpeg,png|max:4096',
            'vehicle_photo' => 'required|mimes:jpeg,png|max:4096',
            // 'comment' => 'required',
            // 'driver'=>'required',
            'model'=>'required',
            'make'=>'required'



        ];
        return  $rules;
    }

    public function servicercompleteJobRulesForReinstallation()
    {
        $rules = [
            'vehicle_id' => 'required',
            'gps_id' => 'required',
            'client_id' => 'required',
            'servicer_job_id' => 'required',
            // 'comment' => 'required',
        ];
        return  $rules;
    }


}
