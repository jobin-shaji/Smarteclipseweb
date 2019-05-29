<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Alert\Models\Alert;

use DataTables;
class AlertReportController extends Controller
{
    public function alertReport()
    {
        return view('Reports::alert-report');  
    }  
    public function alertReportList(Request $request)
    {
        $client= $request->client;
        
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
        ->where('status',1);

        // ->with('tripsWithAmount');
        if($from){
            $query = $query->whereDate('device_time', '>=', $from)->whereDate('device_time', '<=', $to);
            // $query = $query->whereBetween('device_time',[$from,$to]);
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
        ->make();
    }
    // public function export(Request $request)
    // {
    //     return Excel::download(new etmCollectionReportExport($request->id), 'etmCollection-report.xlsx');
    // }
}