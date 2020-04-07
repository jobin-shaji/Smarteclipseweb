<?php
namespace App\Modules\Reports\Controllers;

// alertReportExport
use Illuminate\Http\Request;
use App\Exports\ExcelDocumentExport;
use App\Exports\AlertMsReportExport;
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
        return view('Reports::alert-report-ms',['Alerts'=>$AlertType,'vehicles'=>$vehicles]); 
    } 
    public function alertReportList(Request $request)
    {
        
        $client         = \Auth::user()->client->id;
        $alert_id       = $request->alert;
        $vehicle_id     = $request->vehicle;       
        $from           = $request->fromDate;
        $to             = $request->toDate;
        //  dd($from);
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
            // $vehicle=Vehicle::withTrashed()->find($vehicle_id);
            $vehicle=Vehicle::select('id','gps_id','name','register_number')
                    ->where('id',$vehicle_id)
                    ->withTrashed()
                    ->first();
            $query = $query->where('gps_id',$vehicle->gps_id);            
       }
       else
       {
           
            $vehicle=Vehicle::select('id','gps_id','name','register_number')
                    ->where('id',$vehicle_id)
                    ->withTrashed()
                    ->first();
            $query = $query->where('alert_type_id',$alert_id)
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
        $get_alerts=Alert::select('id','latitude','alert_type_id','longitude','gps_id')->where('id',$decrypted_id)->with('gps.vehicle')->first();
        $alert_icon  =  AlertType:: select(['description',
            'path'])->where('id',$get_alerts->alert_type_id)->first(); 
        $get_vehicle=Vehicle::select(['id','register_number',
            'vehicle_type_id','gps_id'])->where('id',$get_alerts->gps->vehicle->id)->first();
            // dd($get_vehicle);
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
    
    /**
     * export geofence report as excel
     */
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();    
        return Excel::download(new ExcelDocumentExport(['SL.No','Vehicle Name','Registration Number','Address','Alert Type','DateTime'],$this->getAlertsFromMicroService($request)), 'geofence-report.xlsx');
    }

    /**
     * get report view
    */
    public function getAlertsFromMicroService($request)
    {

        $filter         = [ 'user_id' => $request->user_id, 'alert_type' => $request->alert_type , 'vehicle_id' => $request->vehicle_id , 'start_date' => $request->start_date , 'end_date' => $request->end_date ,'limit' => 10000 ]; 
        $client 	    = new \GuzzleHttp\Client();
        $response 	    = $client->request('POST',config('eclipse.urls.ms_alerts').'/alert-report', ['json' => $filter]);
        $responseBody   = $response->getBody();
        $responseData   = json_decode($responseBody->getContents(),true);
        $alerts         = [];   
        foreach ($responseData['data']['alerts'] as $key => $alert) 
        {
        
            $alerts[$key]['SL.No']              = $key + 1;
            $alerts[$key]['Vehicle Name']       = $alert['gps']['connected_vehicle_name'];
            $alerts[$key]['Registration Number']= $alert['gps']['connected_vehicle_registration_number'];
            $alerts[$key]['Address']            = $alert['address'];
            $alerts[$key]['Alert Type']      = $alert['alert_type']['description'];
            $alerts[$key]['DateTime']           = $alert['device_time'];       
        
        }
        return $alerts;
    }
   

    public function alertMapView(Request $request,$ms_alert_id)
    {
        return view('Reports::alert-tracker-ms',[ 'ms_alert_id' => $ms_alert_id ] );      

    }
}