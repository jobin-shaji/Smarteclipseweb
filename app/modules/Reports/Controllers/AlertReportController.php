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
        
        $AlertType=AlertType::select('id','code','description')
        // ->whereIn('id',$alert_id)
        ->whereNotIn('id',[17,18,23,24])
        // ->whereNotIn('id',[17,18,23,24])       
        ->get();
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();
        $user=\Auth::user();         
        return view('Reports::alert-report',['Alerts'=>$AlertType,'vehicles'=>$vehicles]); 
    } 
    public function alertReportList(Request $request)
    {
        
        $client= \Auth::user()->client->id;
        $alert_id= $request->alert;
        $vehicle_id= $request->vehicle;       
        $from = $request->fromDate;
        $to = $request->toDate;
         // dd($from);
        $user=\Auth::user();  
        $VehicleGpss=Vehicle::select(
            'id',
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client)
        ->withTrashed()
        ->get();     
        $single_vehicle_gps = [];
        foreach($VehicleGpss as $VehicleGps){
            $single_vehicle_gps[] = $VehicleGps->gps_id;
        }
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
        ->orderBy('device_time', 'DESC')
        ->whereNotIn('alert_type_id',[17,18,23,24]);
        // ->whereNotIn('alert_type_id',[17,18,23,24]);
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
            $vehicle=Vehicle::withTrashed()->find($vehicle_id);
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('gps_id',$vehicle->gps_id);
       }
       else
       {
            $vehicle=Vehicle::withTrashed()->find($vehicle_id);
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('alert_type_id',$alert_id)
            ->where('gps_id',$vehicle->gps_id);
       }       
        if($from){
          $search_from_date=date("Y-m-d", strtotime($from));
          $search_to_date=date("Y-m-d", strtotime($to));
          $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $alert = $query->paginate(15);
        $user_alert = UserAlerts::select(
            'alert_id'
        )
        ->where('client_id',$client)
        ->where('status',1)
        ->get();
        $user_alert_id = [];
        foreach($user_alert as $user_alert){
            $user_alert_id[] = $user_alert->alert_id;
        }

        $AlertType=AlertType::select('id','code','description')
        ->whereIn('id',$user_alert_id)
        ->whereNotIn('id',[17,18,23,24])        
        ->get();
         $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client)
        ->withTrashed()
        ->get();
        return view('Reports::alert-report',['Alerts'=>$AlertType,'vehicles'=>$vehicles,'alertReports'=>$alert,'alert_id'=>$alert_id,'vehicle_id'=>$vehicle_id,'from'=>$from,'to'=>$to]); 
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
    }
}