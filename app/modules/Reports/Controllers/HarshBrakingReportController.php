<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class HarshBrakingReportController extends Controller
{
    public function harshBrakingReport()
    {
        return view('Reports::harsh-braking-report');  
    } 
    public function harshBrakingReportList(Request $request)
    {
        $client= $request->client;
         // $alert_id= $request->alertID;
        
        $from = $request->from_date;
        $to = $request->to_date;
      
       
            $query =Alert::select(
            'id',
            'alert_type_id', 
            'device_time',    
            'vehicle_id',
            'gps_id',
            'client_id',  
            'latitude',
            'longitude', 
            'status'
        )
        ->with('alertType:id,description')
        ->with('vehicle:id,name,register_number')
        ->where('client_id',$client)
        ->where('alert_type_id',1)
        ->where('status',1);
           
        if($from){
            $query = $query->whereDate('device_time', '>=', $from)->whereDate('device_time', '<=', $to);
        }
        $alert = $query->get();   

        return DataTables::of($alert)
        ->addIndexColumn()
        ->addColumn('location', function ($alert) {
         $latitude= $alert->latitude;
         $longitude=$alert->longitude;          
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
         })
         ->addColumn('action', function ($alert) {              
                    return "
                    <a href=/alert/report/".Crypt::encrypt($alert->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
                })
            ->rawColumns(['link', 'action'])
        ->make();
    } 
   
}