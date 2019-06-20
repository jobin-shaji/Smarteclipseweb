<?php
namespace App\Modules\Reports\Controllers;

use App\Exports\AlertReportExport;

// alertReportExport
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\AlertType;
use App\Modules\Alert\Models\UserAlerts;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Geofence\Models\Geofence;
use App\Modules\Gps\Models\GpsData;

use DataTables;
use Auth;

class AlertReportController extends Controller
{
    public function alertReport()
    {
        $client_id=\Auth::user()->client->id;
        $user_alert = UserAlerts::select(
            'alert_id'
        )
        ->where('client_id',$client_id)
        ->where('status',1)
        ->get();
        $alert_id = [];
        foreach($user_alert as $user_alert){
            $alert_id[] = $user_alert->alert_id;
        }
        $AlertType=AlertType::select('id','code','description')
        ->whereIn('id',$alert_id)
        ->get();
        // $client_id=\Auth::user()->client->id;
         $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::alert-report',['Alerts'=>$AlertType,'vehicles'=>$vehicles]);  
    }  
    public function alertReportList(Request $request)
    {
        $client= $request->client;
        $alert_id= $request->alertID;
        $vehicle_id= $request->vehicle_id;            
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
        ->with('vehicle:id,name,register_number');
       if($alert_id==0 && $vehicle_id==0)
       {         
            $query = $query->where('client_id',$client)
            ->where('status',1);
       }
       else if($alert_id!=0 && $vehicle_id==0)
       {          
            $query = $query->where('client_id',$client)
            ->where('alert_type_id',$alert_id)
            ->where('status',1);
       }
       else if($alert_id==0 && $vehicle_id!=0)
       {
            $query = $query->where('client_id',$client)
            ->where('vehicle_id',$vehicle_id)
            ->where('status',1);
       }
       else
       {
            $query = $query->where('client_id',$client)
            ->where('alert_type_id',$alert_id)
            ->where('vehicle_id',$vehicle_id)
            ->where('status',1);
       }        
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
    public function location(Request $request){
      $decrypted_id = Crypt::decrypt($request->id);
      $get_alerts=Alert::find($decrypted_id);
       $alert_icon  =  AlertType:: select(['description',
            'path'])->where('id',$get_alerts->alert_type_id)->first();  
      $get_vehicle=Vehicle::select(['register_number',
            'vehicle_type_id'])->where('id',$get_alerts->vehicle_id)->first();                    
      return view('Reports::alert-tracker',['alert_id' => $decrypted_id,'alertmap' => $get_alerts,'alert_icon' => $alert_icon,'get_vehicle' => $get_vehicle] );       
    }

     public function alertmap(Request $request){  
       $alert_cord  =  Alert:: select(['latitude',
            'longitude'])->where('id',$request->id)->first();  
            return response()->json([
                'alertmap' => $alert_cord,                
                'status' => 'alerts'
            ]);
    }
    public function export(Request $request)
    {
        // dd($request->fromDate);    
        return Excel::download(new AlertReportExport($request->id,$request->alert,$request->vehicle,$request->fromDate,$request->toDate), 'alert-report.xlsx');
    }
    

}