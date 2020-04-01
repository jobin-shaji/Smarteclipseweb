<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\AccidentImpactAlertReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class AccidentImpactAlertReportController extends Controller
{
    public function accidentImpactAlertReport()
    {
        $client_id          =   \Auth::user()->client->id;
        $vehicles           =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
        return view('Reports::accident-impact-alert-report',['vehicles'=>$vehicles]);  
    }  
    public function accidentImpactAlertReportList(Request $request)
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
        $query                          =   (new Alert())->getAccidentImpactAlerts($single_vehicle_gps_ids); 
        if($from_date)
        {
            $search_from_date           =   date("Y-m-d", strtotime($from_date));
            $search_to_date             =   date("Y-m-d", strtotime($to_date));
            $query                      =   $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $accidentimpactalert            =   $query->get();   
        return DataTables::of($accidentimpactalert)
        ->addIndexColumn()
        // ->addColumn('action', function ($accidentimpactalert) {   
        //     $b_url = \URL::to('/');           
        //     return "
        //     <a href=".$b_url."/alert/report/".Crypt::encrypt($accidentimpactalert->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
        // })
        // ->rawColumns(['link', 'action'])
        ->make();
    }
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();
        return Excel::download(new AccidentImpactAlertReportExport($request->id,$request->vehicle_id,$request->fromDate,$request->toDate), 'Accident-Impact-Alert-report.xlsx');
    } 

   
}