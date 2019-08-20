<?php


namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Driver\Models\Driver;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Geofence\Models\Geofence;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\User\Models\User;

use DataTables;
use DB;
use Carbon\Carbon; 

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->hasRole('root')){
            return view('Dashboard::dashboard');  
        }
        else if(\Auth::user()->hasRole('dealer')){
            return view('Dashboard::dashboard');  
        }
        else if(\Auth::user()->hasRole('sub_dealer')){
            return view('Dashboard::dashboard');  
        }
         else if(\Auth::user()->hasRole('servicer')){
            return view('Dashboard::dashboard');  
        }
        else if(\Auth::user()->hasRole('client')){
            $client_id=\Auth::user()->client->id;
            $alerts = Alert::select(
                    'id',
                    'alert_type_id',
                    'vehicle_id',
                    'status',
                    'created_at')
                    ->with('alertType:id,code,description')
                    ->with('vehicle:id,name,register_number')
                    ->where('client_id',$client_id)
                    ->orderBy('id', 'desc')->take(5)
                    ->get();
            $vehicles = Vehicle::select('id','register_number')
                    ->where('client_id',$client_id)
                    // ->where('client_id',$client_id)
                    ->get();
            $single_vehicle = [];
            foreach($vehicles as $vehicle){
                $single_vehicle[] = $vehicle->id;
            }
            $expired_documents=Document::select([
                    'id',
                    'vehicle_id',
                    'document_type_id',
                    'expiry_date'
                    ])
                    ->with('vehicle:id,name,register_number')
                    ->with('documentType:id,name')
                    ->whereIn('vehicle_id',$single_vehicle)
                    ->whereDate('expiry_date', '<', date('Y-m-d'))
                    ->get();
            $expire_documents=Document::select([
                    'id',
                    'vehicle_id',
                    'document_type_id',
                    'expiry_date'
                    ])
                    ->with('vehicle:id,name,register_number')
                    ->with('documentType:id,name')
                    ->whereIn('vehicle_id',$single_vehicle)
                    ->whereBetween('expiry_date', [date('Y-m-d'), date('Y-m-d', strtotime("+10 days"))])
                    ->get();

                    $gps_data=GpsData::select([
                        'latitude as latitude',
                        'longitude as longitude' 
                    ])                    
                    ->whereIn('vehicle_id',$single_vehicle)
                    ->with('vehicle:id,name,register_number') 
                    ->groupBy('vehicle_id')
                    ->orderBy('id','desc')                 
                    ->get();
                    $user_id=\Auth::user()->id;
                     $get_gpss = Gps::select('id','imei','lat','lon')
                    ->whereNotNull('lat')
                    ->whereNotNull('lon')
                    ->where('user_id',$user_id)                        
                    ->get();
                     $single_gps = [];
                    foreach($get_gpss as $get_gps){
                        $single_gps[] = $get_gps->id;
                    }
                     $get_vehicles = Vehicle::select('id','register_number','name','gps_id')
                    ->where('client_id',$client_id)
                    ->whereIn('gps_id',$single_gps)
                    ->get();
                    // dd($get_vehicles->register_number);
            // dd($gps_data);
            return view('Dashboard::dashboard',['alerts' => $alerts,'expired_documents' => $expired_documents,'expire_documents' => $expire_documents,'vehicles' => $get_vehicles,'gps_data' => $gps_data]); 
        }        
    }
    public function dashCount(Request $request)
    {
        $user = $request->user();
        $dealers=Dealer::where('user_id',$user->id)->first();
        $subdealers=SubDealer::where('user_id',$user->id)->first();
        $client=Client::where('user_id',$user->id)->first();
       
        if($client)
        {


            $vehicles = Vehicle::select('id','register_number','name','gps_id')
                    ->where('client_id',$client->id)
                    ->get();

            $single_vehicle = [];
            foreach($vehicles as $vehicle){
                $single_vehicle[] = $vehicle->gps_id;
            }
// if(strtotime($mysql_timestamp) > strtotime("-30 minutes")) {
//  $this_is_new = true;
// }
         $currentDateTime=Date('Y-m-d H:i:s');
         $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));

        $moving=Gps::where('user_id',$user->id)->where('mode','M')
        ->whereNotNull('lat')
        ->whereNotNull('lon')
        ->where('device_time', '>=',$oneMinut_currentDateTime)
        ->where('device_time', '<=',$currentDateTime)
        ->whereIn('id',$single_vehicle)->count();

        $offline=Gps::where('user_id',$user->id)
        ->whereNotNull('lat')
        ->whereNotNull('lon')
        ->where('device_time', '<=',$oneMinut_currentDateTime)
        // ->where('device_time', '<=',$currentDateTime)
        ->whereIn('id',$single_vehicle)->count();

        $idle=Gps::where('user_id',$user->id)->where('mode','H')
        ->whereNotNull('lat')
        ->whereNotNull('lon')
        ->where('device_time', '>=',$oneMinut_currentDateTime)
        ->where('device_time', '<=',$currentDateTime)
        ->whereIn('id',$single_vehicle)->count();

        $stop=Gps::where('user_id',$user->id)->where('mode','S')
        ->whereNotNull('lat')
        ->whereNotNull('lon')
        ->where('device_time', '>=',$oneMinut_currentDateTime)
        ->where('device_time', '<=',$currentDateTime)
        ->whereIn('id',$single_vehicle)->count();

    }
        if($user->hasRole('root')){
            return response()->json([
                'gps' => Gps::where('user_id',$user->id)->count(), 
                'dealers' => Dealer::all()->count(), 
                'subdealers' => SubDealer::all()->count(),
                'clients' => Client::all()->count(),
                'vehicles' => Vehicle::all()->count(),
                'status' => 'dbcount'
            ]);
        }
        else if($user->hasRole('dealer')){
            $dealer_user_id=[];
            $dealer_user_id[]=$user->id;
            $dealer_id=$user->dealer->id;
            $sub_dealers = SubDealer::select(
                'id','user_id'
                )
                ->where('dealer_id',$dealer_id)
                ->get();
            $single_sub_dealers = [];
            $single_sub_dealers_user_id = [];
            foreach($sub_dealers as $sub_dealer){
                $single_sub_dealers[] = $sub_dealer->id;
                $single_sub_dealers_user_id[] = $sub_dealer->user_id;
            }
            $clients = Client::select(
                    'id','user_id'
                    )
                    ->whereIn('sub_dealer_id',$single_sub_dealers)
                    ->get();
            $single_clients_user_id = [];
            foreach($clients as $client){
                $single_clients_user_id[] = $client->user_id;
            }
            $dealer_subdealer_clients_group = array_merge($single_sub_dealers_user_id,$single_clients_user_id,$dealer_user_id);
            $subdealer_clients_group = array_merge($single_sub_dealers_user_id,$single_clients_user_id);
            $total_gps = Gps::withTrashed()
                ->whereIn('user_id',$dealer_subdealer_clients_group)
                ->count();
            $transferred_gps = Gps::withTrashed()
                ->whereIn('user_id',$subdealer_clients_group)
                ->count();
            return response()->json([
                'subdealers' => SubDealer::where('dealer_id',$dealers->id)->count(),
                'total_gps' => $total_gps,
                'transferred_gps' => $transferred_gps,
                'status' => 'dbcount'           
            ]);
        }
        else if($user->hasRole('sub_dealer')){
            $sub_dealer_user_id=[];
            $sub_dealer_user_id[]=$user->id;
            $sub_dealer_id=$user->subdealer->id;
            $clients = Client::select(
                    'user_id'
                    )
                    ->where('sub_dealer_id',$sub_dealer_id)
                    ->get();
            $single_clients_user_id = [];
            foreach($clients as $client){
                $single_clients_user_id[] = $client->user_id;
            }
            $subdealer_clients_group = array_merge($single_clients_user_id,$sub_dealer_user_id);
            $total_gps = Gps::withTrashed()
                ->whereIn('user_id',$subdealer_clients_group)
                ->count();
            $transferred_gps = Gps::withTrashed()
                ->whereIn('user_id',$single_clients_user_id)
                ->count();
            return response()->json([
                'clients' => Client::where('sub_dealer_id',$subdealers->id)->count(),
                'total_gps' => $total_gps,
                'transferred_gps' => $transferred_gps,
                'status' => 'dbcount'           
            ]);
        }
        else if($user->hasRole('client')){
            return response()->json([
                'gps' => Gps::where('user_id',$user->id)->count(),
                'vehicles' => Vehicle::where('client_id',$client->id)->count(),
                'geofence' => Geofence::where('user_id',$user->id)->count(),
                'moving' => $moving,
                'idle' => $idle,
                'stop' => $stop,
                'offline' => $offline,
                'status' => 'dbcount'           
            ]);
        }       
    }

    //emergency alert
    public function emergencyAlerts(Request $request)
    {
        if($request->user()->hasRole('client')){
            $client_id=\Auth::user()->client->id;
            $alerts = Alert::select(
                    'id',
                    'alert_type_id',
                    'vehicle_id',
                    'latitude',
                    'longitude',
                    'device_time')
                    ->with('vehicle:id,name,register_number,driver_id')
                    ->with('vehicle.driver')
                    ->where('client_id',$client_id)
                    ->where('alert_type_id',21)
                    ->where('status',0)
                    ->get();
            if(sizeof($alerts) == 0){
                $response=[
                    'status' => 'failed'
                ];
            }else{
                $vehicle_id = Crypt::encrypt($alerts[0]['vehicle_id']);
                $response = [
                    'status' => 'success',
                    'alerts' => $alerts,
                    'vehicle' => $vehicle_id
                ];
            }
            return response()->json($response);
        } 
    }

    // emergency alert verification
    public function verifyEmergencyAlert(Request $request)
    {
        $decrypted_vehicle_id = Crypt::decrypt($request->id); 
        $alerts = Alert::where('alert_type_id',21)
                ->where('status',0)
                ->where('vehicle_id',$decrypted_vehicle_id)
                ->get();
        if($alerts == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Alert does not exist'
            ]);
        }
        foreach ($alerts as $alert) {
            $alert->status = 1;
            $alert->save();
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert verified successfully'
        ]);
     }

    //get place namee
    public function getLocationFromLatLng(Request $request)
    {
        $latitude = $request->latitude; 
        $longitude = $request->longitude;
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
            }
            return response()->json($location); 
        }
    }

    public function getLocation(Request $request){
      
        $gps_data=GpsData::select([
            'latitude as latitude',
            'longitude as longitude' 
        ])                    
        ->where('vehicle_id',$request->id) 
        ->orderBy('id','desc')                 
        ->get();
      
        return response()->json($gps_data); 




    }

 public function vehicleDetails(Request $request){

        $address="";
        $gps = Gps::find($request->gps_id); 
        $network_status=$gps->network_status;
        $fuel_status=$gps->fuel_status;
        $speed=$gps->speed;
        $odometer=$gps->odometer;
        $mode=$gps->mode;
        $satelite=$gps->satllite;
        $latitude=$gps->lat;
        $longitude=$gps->lon;
        
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
            $output = json_decode($geocodeFromLatLong);         
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        }
        $battery_status=$gps->battery_status;
        if($network_status>=50)
        {
            $net_status="Good";
        }
        else if($network_status<50 || $network_status>=20)
        {
            $net_status="Average";
        }
        else
        {
            $net_status="poor";
        }
        if($mode=="M")
        {
            $vehcile_mode="Running";
        }
        else if($mode=="H")
        {
            $vehcile_mode="Idle";
        }
        else 
        {
            $vehcile_mode="Stopped";
        }
        if($gps){     
            $response_data = array(
                'status'  => 'vehicle_status',
                'network_status' => $net_status,
                'fuel_status' => $fuel_status.' L',
                'speed' => $speed.' Kmh',
                'odometer' => $odometer.' km',
                'mode' => $vehcile_mode,
                'satelite' => $satelite,
                'battery_status' => $battery_status.' V',
                'address' => $address
                // 'longitude' => $gps_data->longitude
            );
        }
        else{
                $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0);
             }
            
        return response()->json($response_data); 

    }

    public function vehicleList(Request $request)
    {
        $user = $request->user();       
        $client=Client::where('user_id',$user->id)->first();
        $query=Vehicle::select(
            'id',
            'name',
            'register_number',
            'client_id'
        )
        ->where('client_id',$client->id);
        $vehicles = $query->get();       
        return DataTables::of($vehicles)
        ->addIndexColumn()
         ->addColumn('km', function ($vehicles) {
               
                    return "-";               
            })
       ->make();
    }

    public function dashVehicleTrack(Request $request){
        $user = $request->user(); 
        $client=Client::where('user_id',$user->id)->first();
        // user list of vehicles
            $vehicles = Vehicle::select(
                'id',
                'register_number',
                'name',
                'gps_id'
             )
            ->where('client_id',$client->id)
            ->get();
        // user list of vehicles

        // userID list of vehicles
         $single_vehicle = [];
         foreach($vehicles as $vehicle){
            $single_vehicle[] = $vehicle->gps_id;
         } 
           $currentDateTime=Date('Y-m-d H:i:s');
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));
        // userID list of vehicles
         $vehiles_details=Gps::Select(
            'id',
            'lat',
            'lat_dir',
            'lon',
            'lon_dir',
            'mode',
            'device_time'
          )
        ->with('vehicle:gps_id,id,name,register_number')
        ->whereNotNull('mode')
        ->whereIn('id',$single_vehicle)        
        ->orderBy('id','desc')                 
        ->get(); 
        

        $response_track_data=$this->vehicleDataList($vehiles_details);
     
        if($response_track_data){     
                 $response_data = array(
                'user_data'  => $response_track_data,
                'status'=>'Status'
            );
        }
        else{
                $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0);
             }
        return response()->json($response_data); 
    }


     function vehicleDataList($vehiles_details){
        // dd($vehiles_details[0]->id);
         $vehicleTrackData=array();
        foreach ($vehiles_details as $vehicle_data) {
         $vehicle_ecrypt_id=Crypt::encrypt($vehicle_data->vehicle->id);
         $single_vehicle=Vehicle::find($vehicle_data->vehicle->id);
         $single_vehicle_type= $single_vehicle->vehicleType;

        $currentDateTime=Date('Y-m-d H:i:s');
        $device_time= $vehicle_data->device_time;
        $oneMinut_currentDateTime=date($currentDateTime,strtotime("-2 minutes"));
        $time_diff_minut=$this->twoDateTimeDiffrence($device_time,$oneMinut_currentDateTime);


         if($time_diff_minut<=2)
         {
            $modes=$vehicle_data->mode;
         }
         else
         {
           $modes= "O";
         }


         $vehicleTrackData[]=array(
                                    "id"=>$vehicle_data->id,
                                    "lat"=>$vehicle_data->lat,
                                    "lat_dir"=>$vehicle_data->lat_dir,
                                    "lon"=>$vehicle_data->lon,
                                    "lon_dir"=>$vehicle_data->lon_dir,
                                    "mode"=>$modes,
                                    "vehicle_id"=>$vehicle_ecrypt_id,
                                    "vehicle_name"=>$vehicle_data->vehicle->name,
                                    "register_number"=>$vehicle_data->vehicle->register_number,
                                    "vehicle_svg"=>$single_vehicle_type->svg_icon,
                                    "vehicle_scale"=>$single_vehicle_type->vehicle_scale,
                                    "opacity"=>$single_vehicle_type->opacity,
                                    "strokeWeight"=>$single_vehicle_type->strokeWeight,
                                    "device_time"=>$vehicle_data->device_time
                                    );
        
      }
      return $vehicleTrackData;
    }



    public function vehicleTrackList(Request $request)
    {
        $gpsID=$request->gps_id;     
        $user_data=Gps::Select('lat','lat_dir','lon','lon_dir')
                    ->where('id',$gpsID)                 
                    ->first();
           
        return response()->json($user_data); 
    }



    public function vehicleMode(Request $request)
    {
        $vehicle_mode=$request->vehicle_mode;
        $user = $request->user(); 
        $client=Client::where('user_id',$user->id)->first();
        // user list of vehicles
            $vehicles = Vehicle::select(
                'id',
                'register_number',
                'name',
                'gps_id'
             )
            ->where('client_id',$client->id)
            ->get();
       
        // userID list of vehicles
         $single_vehicle = [];
         foreach($vehicles as $vehicle){
            $single_vehicle[] = $vehicle->gps_id;
         }  

        $currentDateTime=Date('Y-m-d H:i:s');
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));
        // userID list of vehicles
if($vehicle_mode=='O')
{
    $vehiles_details=Gps::Select(
            'id',
            'lat',
            'lat_dir',
            'lon',
            'lon_dir',
            'mode',
            'device_time'
          )
        ->with('vehicle:gps_id,id,name,register_number')
        ->whereIn('id',$single_vehicle)      
        ->whereNotNull('lat') 
        ->whereNotNull('lon') 
        
        ->where('device_time', '<=',$oneMinut_currentDateTime)
        // ->where('device_time', '<=',$currentDateTime)        
        // ->where('mode',$vehicle_mode)        
        ->orderBy('id','desc')                 
        ->get(); 

}
else
{
    $vehiles_details=Gps::Select(
            'id',
            'lat',
            'lat_dir',
            'lon',
            'lon_dir',
            'mode',
            'device_time'
          )
        ->with('vehicle:gps_id,id,name,register_number')
        ->whereIn('id',$single_vehicle)       
        ->where('device_time', '>=',$oneMinut_currentDateTime)
        ->where('device_time', '<=',$currentDateTime)        
        ->where('mode',$vehicle_mode)
        ->whereNotNull('lat') 
        ->whereNotNull('lon')         
        ->orderBy('id','desc')                 
        ->get(); 
}
         
        $response_track_data=$this->vehicleDataList($vehiles_details);
     
        if($response_track_data){     
                 $response_data = array(
                'user_data'  => $response_track_data,
                'status'=>'Status'
            );
        }
        else{
                $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0);
             }
        return response()->json($response_data); 
            
       
    }

     public function locationSearch(Request $request)
    {
         $lat=$request->lat;
         $lng=$request->lng; 
         $radius=$request->radius;
         $user = $request->user(); 
         $client=Client::where('user_id',$user->id)->first();
        // user list of vehicles
            $vehicles = Vehicle::select(
                'id',
                'register_number',
                'name',
                'gps_id'
             )
            ->where('client_id',$client->id)
            ->get();
        // user list of vehicles

        // userID list of vehicles
         $single_vehicle = [];
         foreach($vehicles as $vehicle){
            $single_vehicle[] = $vehicle->gps_id;
         }

        $vehicle_by_search=Gps::select('gps.id' ,'gps.lat','gps.lat_dir','gps.lon','gps.mode','device_time'
        ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
        * cos(radians(gps.lat)) 
        * cos(radians(gps.lon) - radians(" . $lng . ")) 
        + sin(radians(" .$lat. ")) 
        * sin(radians(gps.lat))) AS distance"))
        ->groupBy("gps.id")
        ->having('distance','<=',$radius)
        ->with('vehicle:gps_id,id,name,register_number')
       ->whereIn('id',$single_vehicle)    
        ->get();

        $response_track_data=$this->vehicleDataList($vehicle_by_search);        
       if($response_track_data){     
                 $response_data = array(
                'user_data'  => $response_track_data,
                'status'=>'success'
            );
       }else{
                $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0);
             }
        return response()->json($response_data); 
    }

    function twoDateTimeDiffrence($date1,$date2){
        $date1 = strtotime($date1);  
        $date2 = strtotime($date2);  
        $diff = abs($date2 - $date1); 
        $minutes = round($diff/60);
        return $minutes;
    }

public function notification(Request $request)
{


          $user = $request->user();  
           $client=Client::where('user_id',$user->id)->first();
           $client_id=$client->id;
           
       
            $vehicles = Vehicle::select('id','register_number')
                    ->where('client_id',$client_id)
                    ->get();
            $single_vehicle = [];
            foreach($vehicles as $vehicle){
                $single_vehicle[] = $vehicle->id;
            }
            $expired_documents=Document::select([
                'id',
                'vehicle_id',
                'document_type_id',
                'expiry_date'
            ])
            ->with('vehicle:id,name,register_number')
            ->with('documentType:id,name')
            ->whereIn('vehicle_id',$single_vehicle)
            ->whereDate('expiry_date', '<', date('Y-m-d'))
            ->get();
            // $expire_documents=Document::select([
            //     'id',
            //     'vehicle_id',
            //     'document_type_id',
            //     'expiry_date'
            // ])
            // ->with('vehicle:id,name,register_number')
            // ->with('documentType:id,name')
            // ->whereIn('vehicle_id',$single_vehicle)
            // ->whereBetween('expiry_date', [date('Y-m-d'), date('Y-m-d', strtotime("+10 days"))])
            // ->get();
             $expire_documents=Document::select([
                'id',
                'vehicle_id',
                'document_type_id',
                'expiry_date'
            ])
            ->with('vehicle:id,name,register_number')
            ->with('documentType:id,name')
            ->whereIn('vehicle_id',$single_vehicle)
            ->where('expiry_date','>=', [date('Y-m-d')])
            ->orderBy('expiry_date','DESC')
            ->take(5)
            ->get();
       if($user->hasRole('client')){
            return response()->json([            
                'expired_documents' => $expired_documents,
                'expire_documents' => $expire_documents,
                'status' => 'notification'           
            ]);
        }  




}

  public function rootGpsSale(Request $request)
    {
        // dd($request->id);
        $root_id=\Auth::user()->root->id;

            $gps_transfers = GpsTransfer::select('id',
                'from_user_id',
                'to_user_id'
            )
            ->where('from_user_id', $root_id)
            ->whereNotNull('accepted_on')
            ->get();
            $gps_transfer_id = [];
            foreach($gps_transfers as $gps_transfer){
                $gps_transfer_id[] = $gps_transfer->id;
            }
            
            $gps = GpsTransferItems::select(
                'id',
                'gps_transfer_id',
                'gps_id',
                \DB::raw('date_format(created_at, "%M") as month'),
                \DB::raw('count(date_format(created_at, "%M")) as count')             
            )
            ->with('gps:id,imei')
            ->with('gpsTransfer:id,imei')
            ->whereIn('gps_transfer_id',$gps_transfer_id)
             ->orderBy("month","DESC") 
            ->groupBy("month")  
            ->get(); 
            // dd($gps);
          // $gps = GpsTransfer::select(
          //       'id',
          //       'from_user_id',
          //       'to_user_id',
          //       \DB::raw('date_format(accepted_on, "%M") as month'),
          //       \DB::raw('count(date_format(accepted_on, "%M")) as count')               
          //   )
          //   // ->with('gps:id,imei')
          //   ->with('gpsTransferItems:id')
          //   ->where('from_user_id', $root_id)
          //   ->whereNotNull('accepted_on')
          //   ->orderBy("month","DESC") 
          //   ->groupBy("month")  
          //   ->get();
        $gps_month = [];
        $gps_count = [];
        foreach($gps as $gps_sale){
            $gps_count[] = $gps_sale->count;
            $gps_month[] = $gps_sale->month;
        }
        $gps_sale=array(
                    "gps_count"=>$gps_count,
                    "gps_month"=>$gps_month
                );
        return response()->json($gps_sale); 
    }


  public function rootGpsUsers(Request $request)
    {
        // dd($request->id);
        $root_id=\Auth::user()->root->id;       
        $dealer=Dealer::all()->count();
        $sub_dealer=SubDealer::all()->count();
        $client=Client::all()->count();

        
        $gps_user=array(
                    "dealer"=>$dealer,
                    "sub_dealer"=>$sub_dealer,
                    "client"=>$client                   
                );
        return response()->json($gps_user); 
    }

    public function dealerGpsSale(Request $request)
    {
        $user_id=\Auth::user()->id;

        $gps_transfers = GpsTransfer::select('id',
                'from_user_id',
                'to_user_id'
            )
            ->where('from_user_id', $user_id)
            ->whereNotNull('accepted_on')
            ->get();
            $gps_transfer_id = [];
            foreach($gps_transfers as $gps_transfer){
                $gps_transfer_id[] = $gps_transfer->id;
            }
            
            $gps = GpsTransferItems::select(
                'id',
                'gps_transfer_id',
                'gps_id',
                \DB::raw('date_format(created_at, "%M") as month'),
                \DB::raw('count(date_format(created_at, "%M")) as count')             
            )
            ->with('gps:id,imei')
            ->with('gpsTransfer:id,imei')
            ->whereIn('gps_transfer_id',$gps_transfer_id)
             ->orderBy("month","DESC") 
            ->groupBy("month")  
            ->get(); 
        $gps_month = [];
        $gps_count = [];
        foreach($gps as $gps_sale){
            $gps_count[] = $gps_sale->count;
            $gps_month[] = $gps_sale->month;
        }
        $dealer_gps_sale=array(
                    "gps_count"=>$gps_count,
                    "gps_month"=>$gps_month
                );
        return response()->json($dealer_gps_sale); 
    }

////////Dealer GPS User

    public function dealerGpsUsers(Request $request)
    {
        // dd($request->id);
        $dealer_id=\Auth::user()->dealer->id; 
        $subdealer = SubDealer::select('id','name')
        ->where('dealer_id',$dealer_id)
        ->count();  
        $sub_dealers = SubDealer::select('id','name')
        ->where('dealer_id',$dealer_id)
        ->get();
        $single_sub_dealer = [];
        foreach($sub_dealers as $sub_dealer){
            $single_sub_dealer[] = $sub_dealer->id;
        }

        $client = Client::select('id','name')
        ->whereIn('sub_dealer_id',$single_sub_dealer)
        ->count();         
        $dealer_gps_user=array(
                   
                    "sub_dealer"=>$subdealer,
                    "client"=>$client                   
                );
        return response()->json($dealer_gps_user); 
    }

    //////Sub Dealer GPS Count
     public function subDealerGpsSale(Request $request)
    {
        // dd($request->id);
        $user_id=\Auth::user()->id;
         $gps_transfers = GpsTransfer::select('id',
                'from_user_id',
                'to_user_id'
            )
            ->where('from_user_id', $user_id)
            ->whereNotNull('accepted_on')
            ->get();
            $gps_transfer_id = [];
            foreach($gps_transfers as $gps_transfer){
                $gps_transfer_id[] = $gps_transfer->id;
            }
            
            $gps = GpsTransferItems::select(
                'id',
                'gps_transfer_id',
                'gps_id',
                \DB::raw('date_format(created_at, "%M") as month'),
                \DB::raw('count(date_format(created_at, "%M")) as count')             
            )
            ->with('gps:id,imei')
            ->with('gpsTransfer:id,imei')
            ->whereIn('gps_transfer_id',$gps_transfer_id)
             ->orderBy("month","DESC") 
            ->groupBy("month")  
            ->get(); 
        // $gps = GpsTransfer::select(
        //     'id',
        //     'from_user_id',
        //     'to_user_id',
        //     \DB::raw('date_format(accepted_on, "%M") as month'),
        //     \DB::raw('count(date_format(accepted_on, "%M")) as count')               
        // )
        // ->with('gpsTransferItems:id')
        // ->where('from_user_id', $user_id)
        // ->orderBy("month","DESC") 
        // ->groupBy("month")  
        // ->get();
        $gps_month = [];
        $gps_count = [];
        foreach($gps as $gps_sale){
            $gps_count[] = $gps_sale->count;
            $gps_month[] = $gps_sale->month;
        }
        $sub_dealer_gps_sale=array(
            "gps_count"=>$gps_count,
            "gps_month"=>$gps_month
        );
        return response()->json($sub_dealer_gps_sale); 
    }
    //Sub Delaer gps users
    public function subDealerGpsUsers(Request $request)
    {
       
        $sub_dealer_id=\Auth::user()->subDealer->id;
        $clients = Client::select('id','name','address','user_id')
        ->where('sub_dealer_id',$sub_dealer_id)
        ->get();
  
         $single_client = [];
         $client_count=[];
         $client_name=[];
        foreach($clients as $client){
             $client_name[] = $client->name;
            $single_client[] = $client->user_id;
        }
        $users=User::select('id')
        ->whereIn('id',$single_client)
        ->get();
        $user_gps = [];
        foreach($users as $user){
            $user_gps[] = $user->id;
        }
        $gps = Gps::select(
           'user_id',           
            \DB::raw('count(id) as count')               
        )
        ->whereIn('user_id', $user_gps)
        ->groupBy("user_id")  
        ->get();
        $gps_month = [];
        $gps_count = [];
        foreach($gps as $gps_sale){
            $gps_count[] = $gps_sale->count;
            $gps_month[] = $gps_sale->month;
        }
        $sub_dealer_gps_sale=array(
            "client"=>$client_name,
            "gps_count"=>$gps_count,
            "gps_month"=>$gps_month
        );
        return response()->json($sub_dealer_gps_sale); 
    }
 
}
