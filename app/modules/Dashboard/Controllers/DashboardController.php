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
        }else if(\Auth::user()->hasRole('client')){
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


                     $get_vehicles = Vehicle::select('id','register_number','name','gps_id')
                    ->where('client_id',$client_id)
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
        $vehicles = Vehicle::select('id','register_number','name','gps_id')
                    ->where('client_id',$client->id)
                    ->get();

            $single_vehicle = [];
            foreach($vehicles as $vehicle){
                $single_vehicle[] = $vehicle->gps_id;
            }

        $moving=Gps::where('user_id',$user->id)->where('mode','M')->whereIn('id',$single_vehicle)->count();
        $idle=Gps::where('user_id',$user->id)->where('mode','H')->whereIn('id',$single_vehicle)->count();
        $stop=Gps::where('user_id',$user->id)->where('mode','S')->whereIn('id',$single_vehicle)->count();
        if($user->hasRole('root')){
            return response()->json([
                'gps' => Gps::all()->count(), 
                'dealers' => Dealer::all()->count(), 
                'subdealers' => SubDealer::all()->count(),
                'clients' => Client::all()->count(),
                'vehicles' => Vehicle::all()->count(),
                'status' => 'dbcount'
            ]);
        }
        else if($user->hasRole('dealer')){
            return response()->json([
                'subdealers' => SubDealer::where('dealer_id',$dealers->id)->count(),
                'gps' => Gps::where('user_id',$user->id)->count(),
                'status' => 'dbcount'           
            ]);
        }
        else if($user->hasRole('sub_dealer')){
            return response()->json([
                'clients' => Client::where('sub_dealer_id',$subdealers->id)->count(),
                'gps' => Gps::where('user_id',$user->id)->count(),
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
                'status' => 'dbcount'           
            ]);
        }       
    }

    //driver score
    public function driverScore(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $drivers = Driver::select(
                'id',
                'name',
                'points')
                ->where('client_id',$client_id)
                ->get();
        $single_driver_name = [];
        $single_driver_point = [];
        foreach($drivers as $driver){
            $single_driver_name[] = $driver->name;
            $single_driver_point[] = $driver->points;
        }
        $score=array(
                    "drive_data"=>$single_driver_name,
                    "drive_score"=>$single_driver_point
                );
        return response()->json($score); 
    }

    //emergency alert
    public function emergencyAlerts(Request $request)
    {
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
        $vehicle_id = Crypt::encrypt($alerts[0]['vehicle_id']);
        $response = [
            'alerts' => $alerts,
            'vehicle' => $vehicle_id
        ];
        return response()->json($response); 
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
        // userID list of vehicles
         $vehiles_details=Gps::Select(
            'id',
            'lat',
            'lat_dir',
            'lon',
            'lon_dir',
            'mode'
          )
        ->with('vehicle:gps_id,id,name,register_number')
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
         $vehicleTrackData=array();
        foreach ($vehiles_details as $vehicle_data) {
         $vehicle_ecrypt_id=Crypt::encrypt($vehicle_data->vehicle->id);
         $single_vehicle=Vehicle::find($vehicle_data->vehicle->id);
         $single_vehicle_type= $single_vehicle->vehicleType;

         $vehicleTrackData[]=array(
                                    "id"=>$vehicle_data->id,
                                    "lat"=>$vehicle_data->lat,
                                    "lat_dir"=>$vehicle_data->lat_dir,
                                    "lon"=>$vehicle_data->lon,
                                    "lon_dir"=>$vehicle_data->lon_dir,
                                    "mode"=>$vehicle_data->mode,
                                    "vehicle_id"=>$vehicle_ecrypt_id,
                                    "vehicle_name"=>$vehicle_data->vehicle->name,
                                    "register_number"=>$vehicle_data->vehicle->register_number,
                                    "vehicle_svg"=>$single_vehicle_type->svg_icon,
                                    "vehicle_scale"=>$single_vehicle_type->vehicle_scale,
                                    "opacity"=>$single_vehicle_type->opacity,
                                    "strokeWeight"=>$single_vehicle_type->strokeWeight
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
        // user list of vehicles

        // userID list of vehicles
         $single_vehicle = [];
         foreach($vehicles as $vehicle){
            $single_vehicle[] = $vehicle->gps_id;
         } 
        // userID list of vehicles
         $vehiles_details=Gps::Select(
            'id',
            'lat',
            'lat_dir',
            'lon',
            'lon_dir',
            'mode'
          )
        ->with('vehicle:gps_id,id,name,register_number')
        ->whereIn('id',$single_vehicle)  
        ->where('mode',$vehicle_mode)        
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

     public function locationSearch(Request $request)
    {
         $lat=$request->lat;
         $lon=$request->lon;  



       $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lon)) + sin(radians($lat)) * sin(radians(latitude))))";



    // return $query
        $distance=Gps::select('lat','lat_dir','lon','lon_dir')
        ->selectRaw("{$haversine} AS distance")
        ->whereRaw("{$haversine} < ?", 100)
        ->get();
        dd($distance);
// SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) 
//     * cos( radians( long ) - radians(-122) ) + sin( radians(37) ) * sin(radians(lat)) ) ) AS distance 
// FROM myTable
// HAVING distance < 50
// ORDER BY distance 

        $user_data=Gps::Select('lat','lat_dir','lon','lon_dir')
                    ->where('lat',$lat)
                    ->where('lon',$lon)                
                    ->get();
            dd($user_data);        
        return response()->json(["lat"=>$lat,"lon"=>$lon]); 
    }


}
