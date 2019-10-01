<?php
namespace App\Modules\Reports\Controllers;

// alertReportExport
use Illuminate\Http\Request;
use App\Exports\AlertReportExport;

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
use Carbon\Carbon;


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

        $user=\Auth::user();
        $user_role=$user->roles->where('name','==','client')->first()->name;
        $fromDate=$this->checkRoleAlert($user_role);
        return view('Reports::alert-report',['Alerts'=>$AlertType,'vehicles'=>$vehicles,'from_date'=>$fromDate->format('d-m-Y')]); 
    } 
    public function alertReportList(Request $request)
    {
        // $client= $request->client;
        $client= \Auth::user()->client->id;
        $alert_id= $request->alertID;
        $vehicle_id= $request->vehicle_id;
        // dd($client);
        $from = $request->from_date;
        $to = $request->to_date;
        $user=\Auth::user();
        $user_role=$user->roles->where('name','==','client')->first()->name;
        $check_role_in_playback=$this->checkRolePlayback($user_role,$from);
        if($check_role_in_playback=="failed"){
         $response_data = array(
            'status'  => 'wrong_date',
            'message' => 'wrong_date',
            'polyline' => "wrong_date",
            'code'    =>0
        );
         return response()->json($response_data);
        }

        $VehicleGpss=Vehicle::select(
            'id',
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client)
        ->get();     
        $single_vehicle_gps = [];
        foreach($VehicleGpss as $VehicleGps){
            $single_vehicle_gps[] = $VehicleGps->gps_id;
        }
        // dd($VehicleGpss);
        $query =Alert::select(
            'id',
            'alert_type_id',
            'device_time',   
            'gps_id',
            'latitude',
            'longitude',
            'status'
        )
        ->with('alertType:id,description')
        ->with('gps.vehicle')
        ->orderBy('id', 'desc')
        ->limit(1000);
       if($alert_id==0 && $vehicle_id==0)
       {  

            $query = $query->whereIn('gps_id',$single_vehicle_gps);
       }
       else if($alert_id!=0 && $vehicle_id==0 || $vehicle_id==null)
       {         
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('alert_type_id',$alert_id);
       }
       else if($alert_id==0 && $vehicle_id!=0)
       {
            $vehicle=Vehicle::find($vehicle_id);
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('gps_id',$vehicle->gps_id);
            // ->where('status',1);
       }
       else
       {
            $vehicle=Vehicle::find($vehicle_id);
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('alert_type_id',$alert_id)
            ->where('gps_id',$vehicle->gps_id);
            // ->where('status',1);
       }       
        if($from){
          $search_from_date=date("Y-m-d", strtotime($from));
          $search_to_date=date("Y-m-d", strtotime($to));
          $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $alert = $query->get(); 
        // dd($alert);
        return DataTables::of($alert)
        ->addIndexColumn()
    //     ->addColumn('location', function ($alert) {
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
       
    // }
    //      })
         ->addColumn('action', function ($alert) {
         $b_url = \URL::to('/');              
                    return "
                    <a href=".$b_url."/alert/report/".Crypt::encrypt($alert->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
                })
            ->rawColumns(['link', 'action'])
        ->make();
    }
    public function location(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);
        $get_alerts=Alert::where('id',$decrypted_id)->with('gps.vehicle')->first();
        $alert_icon  =  AlertType:: select(['description',
            'path'])->where('id',$get_alerts->alert_type_id)->first(); 
        $get_vehicle=Vehicle::select(['id','register_number',
            'vehicle_type_id'])->where('id',$get_alerts->gps->vehicle->id)->first();
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
        return Excel::download(new AlertReportExport($request->id,$request->alert,$request->vehicle,$request->fromDate,$request->toDate), 'Alert-report.xlsx');
        // dd($request->$gps_id);
        // $gps_id=$request->$request;  
  
    }

    public function checkRoleAlert($role){
       if($role=="fundamental"){
            $from_date=Carbon::now()->subMonth(2);
         }else if($role=="superior"){
            $from_date=Carbon::now()->subMonth(4);
         }else if($role=="pro"){
             $from_date=Carbon::now()->subMonth(6);
         }else{
           $from_date=Carbon::now()->subMonth(1);
         }
        
         return $from_date;
    }

    // ---validate  date-----------------
    public function checkRolePlayback($role,$user_from_date){
       if($role=="fundamental"){
            $from_date=Carbon::now()->subMonth(2);
         }else if($role=="superior"){
            $from_date=Carbon::now()->subMonth(4);
         }else if($role=="pro"){
             $from_date=Carbon::now()->subMonth(6);
         }else{
           $from_date=Carbon::now()->subMonth(1);
         }
        
         if(Carbon::parse($from_date) <= Carbon::parse($user_from_date)){
            $return="Success";
         }else{
            $return="failed";
         }
         return $return;
    }
    // ---validate  date-----------------


}