<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\ExcelDocumentExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Warehouse\Models\GpsStock;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class HarshBrakingReportController extends Controller
{
    public function harshBrakingReport()
    {
        $client_id                      =   \Auth::user()->client->id;
        $vehicles                       =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
        return view('Reports::harsh-braking-report',['vehicles'=>$vehicles]);  
    } 
    public function harshBrakingReportList(Request $request)
    {
        $single_vehicle_gps_ids         =   []; 
        $client_id                      =   $request->client;
        $vehicle_id                     =   $request->vehicle;
        $from_date                      =   $request->from_date;
        $to_date                        =   $request->to_date;
        if($vehicle_id != 0)
        {
            $vehicle_gps_ids            =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithDates($vehicle_id,$from_date,$to_date);         
        }
        else
        {
            $vehicle_details            =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
            $vehicle_ids                =   [];
            foreach($vehicle_details as $each_vehicle)
            {
                $vehicle_ids[]          =   $each_vehicle->id; 
            }  
            $vehicle_gps_ids            =   (new VehicleGps())->getGpsDetailsBasedOnVehiclesWithDates($vehicle_ids,$from_date,$to_date);
        }
        foreach($vehicle_gps_ids as $vehicle_gps_id)
        {
            $single_vehicle_gps_ids[]   =   $vehicle_gps_id->gps_id;
        }
        $query                          =   (new Alert())->getHarshBreakingAlerts($single_vehicle_gps_ids); 
        if($from_date)
        {
            $search_from_date           =   date("Y-m-d", strtotime($from_date));
            $search_to_date             =   date("Y-m-d", strtotime($to_date));
            $query                      =   $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $harsh_breking_alerts           =   $query->get();       
        return DataTables::of($harsh_breking_alerts)
        ->addIndexColumn()
        // ->addColumn('action', function ($harsh_breking_alerts) { 
        //  $b_url = \URL::to('/');             
        //     return "
        //     <a href=".$b_url."/alert/report/".Crypt::encrypt($harsh_breking_alerts->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
        // })
        // ->rawColumns(['link', 'action'])
        ->make();
   
    }

    /**
     * export geofence report as excel
     */
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();    
        return Excel::download(new ExcelDocumentExport(['SL.No','Vehicle Name','Registration Number','Address','DateTime'],$this->getAlertsFromMicroService($request)), 'geofence-report.xlsx');
    }

    /**
     * get report view
    */
    public function getAlertsFromMicroService($request)
    {

        $filter         = [ 'user_id' => $request->user_id, 'alert_type' => "13" , 'vehicle_id' => $request->vehicle_id , 'start_date' => $request->start_date , 'end_date' => $request->end_date ,'limit' => 10000 ]; 
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
            $alerts[$key]['DateTime']           = $alert['device_time'];       
        
        }
        return $alerts;
    }
   
}