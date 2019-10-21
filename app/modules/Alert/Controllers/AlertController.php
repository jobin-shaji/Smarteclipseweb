<?php 

namespace App\Modules\Alert\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\AlertType;
use App\Modules\Alert\Models\UserAlerts;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsData;
use Illuminate\Support\Facades\DB;
use DataTables;

class AlertController extends Controller {

    //Display all alerts
	public function alerts()
    {
         
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
                    ->where('client_id',$client_id)
                    ->get();
        $userAlert = UserAlerts::select(
                'id',
                'client_id',
                'alert_id',
                'status'
               )
            ->with('alertType:id,code,description')                
            ->where('client_id',$client_id)           
            ->get();   
            // dd($userAlert);           
		return view('Alert::alert-list',['vehicles'=>$vehicles,'userAlerts'=>$userAlert]);
	}

	//returns alerts as json 
    public function alertsList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $alert_id= $request->alert_id;
        $vehicle_id= $request->vehicle_id;            
        $from = $request->from_date;
        $to = $request->to_date;
          // dd($alert_id);
        $VehicleGpss=Vehicle::select(
            'id',
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client_id)
        ->get();      
        $single_vehicle_gps = [];
        foreach($VehicleGpss as $VehicleGps){
            $single_vehicle_gps[] = $VehicleGps->gps_id;
        }
        
        $alert = Alert::select(
                'id',
                'alert_type_id',
                'device_time',
                'gps_id',
                'latitude',
                'longitude',
                'status',
                'created_at')
                ->with('alertType:id,code,description')
                ->with('gps.vehicle')
                ->with('gps:id,imei')
                ->orderBy('id', 'desc')
                ->limit(1000);
                // ->with('client:id,name');
                if($alert_id==null && $vehicle_id==null)
                { 
                   $alert =$alert->whereIn('gps_id',$single_vehicle_gps)
                    ->where('status',0);
                }
                else
                {
                  
                    $alert =$alert->whereIn('gps_id',$single_vehicle_gps)
                    ->where('alert_type_id',$alert_id)
                    ->where('status',0);
                    if($from){
                      $search_from_date=date("Y-m-d", strtotime($from));                      
                      $search_to_date=date("Y-m-d", strtotime($to));
                      $alert = $alert->whereDate('device_time', '>=', $search_from_date)
                      ->whereDate('device_time', '<=', $search_to_date);
                    }                   
                } 
                $alert =$alert->get();
                return DataTables::of($alert)
                ->addIndexColumn()
        //      ->addColumn('address', function ($alert) {
        //          $latitude=$alert->latitude;
        //         $longitude=$alert->longitude;
        //     if(!empty($latitude) && !empty($longitude)){
        //     //Send request and receive json data by address
        //     $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
        //     $output = json_decode($geocodeFromLatLong);         
        //     $status = $output->status;
        //     //Get address from json data
        //     $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        // }


        //     return  $address ;
        // })
            // ->addColumn('location', function ($alert) {
            //      $latitude= $alert->latitude;
            //      $longitude=$alert->longitude;          
            //     if(!empty($latitude) && !empty($longitude)){
            //         //Send request and receive json data by address
            //         $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
            //         $output = json_decode($geocodeFromLatLong);         
            //         $status = $output->status;
            //         //Get address from json data
            //         $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //         //Return address of the given latitude and longitude
            //         if(!empty($address)){
            //              $location=$address;
            //         return $location;
                        
            //         }
                
            //     }
            // })
            ->addColumn('action', function ($alert) {
                // <button onclick=VerifyAlert(".$alert->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Verify'><i class='fa fa-check' ></i></button>
                 $b_url = \URL::to('/');
            return "
             <a href=".$b_url."/alert/report/".Crypt::encrypt($alert->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // alert verification
    public function verifyAlert(Request $request)
    {
        $alert = Alert::find($request->id);
        if($alert == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Alert does not exist'
            ]);
        }
        $alert->status = 1;
        $alert->save();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert verified successfully'
        ]);
     }

    //alert creation page
    public function create()
    {
       return view('Alert::alert-type-create');
    }
     //upload alert details to database table
    public function save(Request $request)
    {
        $rules = $this->alert_rules();
        $this->validate($request, $rules);
        $file=$request->path;
        $getFileExt   = $file->getClientOriginalExtension();
        $uploadedFile =   time().'.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'alerts';
        $file->move($destinationPath,$uploadedFile);

        $alert_type = AlertType::create([
            'code' => $request->code,
            'description' => $request->description,  
            'driver_point' => $request->driver_point,  
            'path' => $uploadedFile,             
            'status' => 1,               
        ]);

        $request->session()->flash('message', 'New Alert Type created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('alert-type/create')); 
    }
     //Display alert details 
    public function alertListPage()
    {
        return view('Alert::alert-type-list');
    }
     //returns alert as json 
    public function getAlertTypes()
    {
        $alert_type = AlertType::select(
            'id', 
            'code',                      
            'description',
            'driver_point',
            'path',       
            'deleted_at'
        )
        ->withTrashed()        
        ->get();
        return DataTables::of($alert_type)
        ->addIndexColumn()
        ->addColumn('image', function ($alert_type) {
            return "
           <img src='alerts/".$alert_type->path."' alt='Logo' style='height: 100px; width: 100px;' > ";          
        })
        ->addColumn('action', function ($alert_type) {
             $b_url = \URL::to('/');
            if($alert_type->deleted_at == null){ 
            return "
           
            <a href=".$b_url."/alert-type/".Crypt::encrypt($alert_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/alert-type/".Crypt::encrypt($alert_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
            <button onclick=delAlertType(".$alert_type->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
            }else{ 
            return "
            <button onclick=activateAlertType(".$alert_type->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link','image', 'action'])
        ->make();
    }
     //alert details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        
        $alert_type = AlertType::select(
            'id', 
            'code',                      
            'description',  
            'driver_point',              
            'deleted_at'
        )
        ->withTrashed()
        ->where('id',$decrypted)
        ->get();
        if($alert_type == null){
            return view('Alert::404');
        }
        return view('Alert::alert-type-details',['alert_type' => $alert_type]);
    }
    //for edit page of Alert Type
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        $alert_type = AlertType::select(
            'id', 
            'code',                      
            'description',
            'driver_point',
            'path',                                                       
            'deleted_at'
        )
        ->withTrashed()       
        ->where('id',$decrypted)
        ->get();
        if($alert_type == null){
            return view('Alert::404');
        }
        return view('Alert::alert-type-edit',['alert_type' => $alert_type]);
    }
     //update alert Type 
    public function update(Request $request)
    { 
       $alert_type = AlertType::where('id', $request->id)->first();
        if($alert_type == null){
           return view('Alert::404');
        } 
        $rules = $this->alertUpdateRules($alert_type);
        $this->validate($request, $rules);
        $file=$request->path;
        if($file!=null)
        {
            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;      
            $destinationPath = 'alerts';
            $file->move($destinationPath,$uploadedFile);
            $alert_type->path = $uploadedFile;
        }
        $alert_type->code = $request->code;
        $alert_type->description = $request->description;
        $alert_type->driver_point = $request->driver_point;
        $alert_type->save();      
        $did = encrypt($alert_type->id);
        $request->session()->flash('message', 'Alert Type updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('alert-types')); 
       
        // return redirect(route('alert.types.edit',$did));  
    }
     //delete alert details from table
    public function deleteAlertType(Request $request)
    {
        $alert_type = AlertType::find($request->uid);
        if($alert_type == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Alert Type does not exist'
            ]);
        }
        $alert_type->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert Type deleted successfully'
        ]);
    }
     // restore alert
    public function activateAlertType(Request $request)
    {
        $alert_type = AlertType::withTrashed()->find($request->id);
        if($alert_type==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Alert type does not exist'
            ]);
        }
        $alert_type->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert type restored successfully'
        ]);
    }//



       //Display all alerts
    public function packet()
    {
        $devices=Gps::select('id','imei')                
                ->get();
       
        return view('Alert::packet-list',['devices'=>$devices]);
    }

    //Alert Notification
    public function notification(Request $request)
    {
        $user = $request->user();  
        $client=Client::where('user_id',$user->id)->first();
        $client_id=$client->id;
        $VehicleGpss=Vehicle::select(
            'id',
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client_id)
        ->get();      
        $single_vehicle_gps = [];
        foreach($VehicleGpss as $VehicleGps){
            $single_vehicle_gps[] = $VehicleGps->gps_id;
        }
         
        $alert = Alert::select(
            'id',
            'alert_type_id',
            'device_time',
            'gps_id',
            'latitude',
            'longitude',
            'status',
            'created_at'
        )
        ->with('alertType:id,code,description')
        ->with('vehicle:id,name,register_number')
        ->with('gps:id,imei')
        ->with('client:id,name')
        ->whereIn('gps_id',$single_vehicle_gps)
        ->where('status',0)
        ->orderBy('id','DESC')
        ->limit(4)
        ->get();
        if($user->hasRole('client')){
            return response()->json([                          
                'alert' => $alert,
                'status' => 'alertNotification'           
            ]);
        }  
    }


    function notificationAlertCount()
    {
        $user=\Auth::user();
        if($user->hasRole('client')){
        $client_id=\Auth::user()->client->id;
        $VehicleGpss=Vehicle::select(
            'id',
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client_id)
        ->get();      
        $single_vehicle_gps = [];
        foreach($VehicleGpss as $VehicleGps){
            $single_vehicle_gps[] = $VehicleGps->gps_id;
        }
        
        $alert = Alert::select('id','gps_id')
        ->whereIn('gps_id',$single_vehicle_gps)
        ->where('status',0)
        ->get()
        ->count();
            return response()->json([                          
                'notification_count' => $alert,
                'status' => 'success'           
            ]);
        }else{
           return response()->json([                          
                'status' => 'failed'           
            ]);   
        }  
    }


     //alert create rules 
    public function alert_rules(){
        $rules = [
            'code' => 'required|unique:alert_types',
            'description' => 'required',
            'driver_point' => 'required|numeric',
            'path' => 'required|mimes:jpg,jpeg,png|max:20000'
            
        ];
        return  $rules;
    }
    //validation for alert updation
    public function alertUpdateRules($alert_type)
    {
        $rules = [
            'code' => 'required|unique:alert_types,code,'.$alert_type->id,
            'description' => 'required',
            'driver_point' => 'required'   
        ];
        return  $rules;
    }
}