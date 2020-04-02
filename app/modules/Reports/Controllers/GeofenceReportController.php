<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\ExcelDocumentExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use DataTables;
class GeofenceReportController extends Controller
{
    public function geofenceReport()
    {
        $client_id      =   \Auth::user()->client->id;
        $vehicles       =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
        return view('Reports::geofence-report',['vehicles'=>$vehicles]);  
    }  
    public function geofenceReportList(Request $request)
    {
        $single_vehicle_gps_ids             =   []; 
        $client_id                          =   \Auth::user()->client->id;
        $from_date                          =   $request->from_date;
        $to_date                            =   $request->to_date;
        $vehicle_id                         =   $request->vehicle;
      
        if( $vehicle_id ==  0 || $vehicle_id   ==  null )
        {
            $vehicle_details                =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
            $vehicle_ids                    =   [];
            foreach($vehicle_details as $each_vehicle)
            {
                $vehicle_ids[]              =   $each_vehicle->id; 
            }  
            $vehicle_gps_ids                =   (new VehicleGps())->getGpsDetailsBasedOnVehiclesWithDates($vehicle_ids,$from_date,$to_date);
        }
        else
        {  
            $vehicle_gps_ids                =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithDates($vehicle_id,$from_date,$to_date);         
        }
        foreach($vehicle_gps_ids as $vehicle_gps_id)
        {
            $single_vehicle_gps_ids[]       =   $vehicle_gps_id->gps_id;
        }
        $query                              =   (new Alert())->getGeofenceAlerts($single_vehicle_gps_ids);        
        if($from_date)
        {
            $search_from_date               =   date("Y-m-d", strtotime($from_date));
            $search_to_date                 =   date("Y-m-d", strtotime($to_date));
            $query                          =   $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $geofence                           =   $query->get();   
        return DataTables::of($geofence)
        ->addIndexColumn()
        ->make();
    }

    /**
     * export geofence report as excel
     */
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();    
        return Excel::download(new ExcelDocumentExport(['SL.No','Vehicle Name','Registration Number','Address','Geofence Type','DateTime'],$this->getAlertsFromMicroService($request)), 'geofence-report.xlsx');
    }

    /**
     * get report view
    */
    public function getAlertsFromMicroService($request)
    {

        $filter         = [ 'user_id' => $request->user_id, 'alert_type' => ["18","19"] , 'vehicle_id' => $request->vehicle_id , 'start_date' => $request->start_date , 'end_date' => $request->end_date ,'limit' => 10000 ]; 
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
            $alerts[$key]['Geofence Type']      = $alert['alert_type']['description'];
            $alerts[$key]['DateTime']           = $alert['device_time'];       
        
        }
        return $alerts;
    }
}