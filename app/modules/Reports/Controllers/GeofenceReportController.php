<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\GeofenceReportExport;
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
        $single_vehicle_gps_ids             =   ['5'];
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
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();   
        return Excel::download(new GeofenceReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'geofence-report.xlsx');
    }
}