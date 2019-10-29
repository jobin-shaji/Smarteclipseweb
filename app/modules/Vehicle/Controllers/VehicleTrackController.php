<?php

namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Ota\Models\OtaResponse;
use App\Modules\Vehicle\Models\VehicleRoute;
use App\Modules\Route\Models\RouteArea;
use App\Modules\Vehicle\Models\DocumentType;
use App\Modules\Vehicle\Models\VehicleDriverLog;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Ota\Models\GpsOta;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Driver\Models\Driver;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Servicer\Models\ServicerJob;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use DataTables;

class VehicleTrackController extends Controller {
    
   

 

    /////////////////////////////Vehicle Tracker/////////////////////////////
    public function location(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);
        $get_vehicle=Vehicle::find($decrypted_id);
        $vehicle_type=VehicleType::find($get_vehicle->vehicle_type_id);  
        $track_data=Gps::select('lat as latitude',
                              'lon as longitude'
                              )         
                              ->where('id',$get_vehicle->gps_id)
                              ->first();   
        if($track_data==null)
        {
            return view('Vehicle::location-error');
        }
        else if($track_data->latitude==null || $track_data->longitude==null)
        {
            return view('Vehicle::location-error');
        }
        else
        {
            $latitude=$track_data->latitude;
            $longitude= $track_data->longitude;
        }
        return view('Vehicle::vehicle-tracker',['Vehicle_id' => $decrypted_id,'vehicle_type' => $vehicle_type,'latitude' => $latitude,'longitude' => $longitude] );
    }
    public function locationTrack(Request $request)
    {
        $get_vehicle=Vehicle::find($request->id);
        $currentDateTime=Date('Y-m-d H:i:s');
        // $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-10 minutes"));
        $offline="Offline";
        $track_data=Gps::select('lat as latitude',
                      'lon as longitude',
                      'heading as angle',
                      'mode as vehicleStatus',
                      'speed',
                      'battery_status',
                      'device_time as dateTime',
                      'main_power_status as power',
                      'ignition as ign',
                      'gsm_signal_strength as signalStrength'
                      )
                    ->where('device_time', '>=',$oneMinut_currentDateTime)
                    ->where('device_time', '<=',$currentDateTime)
                    ->where('id',$get_vehicle->gps_id)
                    ->first();

        $minutes=0;
        if($track_data == null){
            $track_data = Gps::select('lat as latitude',
                              'lon as longitude',
                              'heading as angle',
                              'speed',
                              'battery_status',
                              'device_time as dateTime',
                              'main_power_status as power',
                              'ignition as ign',
                              'gsm_signal_strength as signalStrength',
                              \DB::raw("'$offline' as vehicleStatus")
                              )
                              ->where('id',$get_vehicle->gps_id)
                              ->first();
           $minutes   = Carbon::createFromTimeStamp(strtotime($track_data->dateTime))->diffForHumans();
        }
 
        if($track_data){
            $plcaeName=$this->getPlacenameFromLatLng($track_data->latitude,$track_data->longitude);
            $snapRoute=$this->LiveSnapRoot($track_data->latitude,$track_data->longitude);
            $reponseData=array(
                        "latitude"=>$snapRoute['lat'],
                        "longitude"=>$snapRoute['lng'],
                        "angle"=>$track_data->angle,
                        "vehicleStatus"=>$track_data->vehicleStatus,
                        "speed"=>ltrim($track_data->speed,'0'),
                        "dateTime"=>$track_data->dateTime,
                        "power"=>$track_data->power,
                        "ign"=>$track_data->ign,
                        "battery_status"=>ltrim($track_data->battery_status,'0'),
                        "signalStrength"=>$track_data->signalStrength,
                        "last_seen"=>$minutes,
                        "fuel"=>"",
                        "ac"=>"",
                        "place"=>$plcaeName,
                        "fuelquantity"=>""
                      );


            $response_data = array('status'  => 'success',
                           'message' => 'success',
                           'code'    =>1,
                           'vehicle_type' => $get_vehicle->vehicleType->name,
                           'client_name' => $get_vehicle->client->name,
                           'vehicle_reg' => $get_vehicle->register_number,
                           'vehicle_name' => $get_vehicle->name,
                           'liveData' => $reponseData
                            );

        }else{
            $response_data = array('status'  => 'failed',
                           'message' => 'failed',
                            'code'    =>0);
        }
             // dd($response_data['liveData']['ign']);
        return response()->json($response_data); 
    }


    function distanceCalculation($lat1, $lon1, $lat2, $lon2) {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      return ($miles * 1.609344);
    }
//
    // servicer vehicle create




  
    function getPlacenameFromLatLng($latitude,$longitude){
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo'); 
            $output = json_decode($geocodeFromLatLong);
             
         
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude

            if(!empty($address)){
                return $address;
            }else{
                return false;
            }
        }else{
            return false;   
        }
    }
/////////////// snap root for live data///////////////////////////////////
    function LiveSnapRoot($b_lat, $b_lng) {
        $lat = $b_lat;
        $lng = $b_lng;
        $route = $lat . "," . $lng;
        $url = "https://roads.googleapis.com/v1/snapToRoads?path=" . $route . "&interpolate=true&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo";
        $geocode_stats = file_get_contents($url);
        $output_deals = json_decode($geocode_stats);
        if (isset($output_deals->snappedPoints)) {
            $outPut_snap = $output_deals->snappedPoints;
            // var_dump($output_deals);
            if ($outPut_snap) {
                foreach ($outPut_snap as $ldata) {
                    $lat = $ldata->location->latitude;
                    $lng = $ldata->location->longitude;
                }
            }
        }
        $userData = ["lat" => $lat, "lng" => $lng];
        return $userData;

    }
/////////////// snap root for live data///////////////////////////////////

}
