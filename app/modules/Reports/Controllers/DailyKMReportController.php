<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\DailyKMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Warehouse\Models\GpsStock;
use DataTables;
class DailyKMReportController extends Controller
{
    public function dailyKMReport()
    {
    	$client_id                      =   \Auth::user()->client->id;
    	$vehicles                       =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
        return view('Reports::daily-km-report',['vehicles'=>$vehicles]);  
    }  
    public function dailyKMReportList(Request $request)
    {
        $single_vehicle_gps_ids         =    []; 
        $client_id                      =    \Auth::user()->client->id;
        $date                           =    $request->date;
        $from_date                      =    $request->from_date;
        $to_date                        =    $request->to_date;
        $vehicle_id                     =    $request->vehicle;  
        
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

        $dailykm_report                 =   (new DailyKm())->getDailyKmBasedOnFromDateAndToDateGps($single_vehicle_gps_ids,$from_date,$to_date);   

        return DataTables::of($dailykm_report)
        ->addIndexColumn()        
        ->addColumn('totalkm', function ($dailykm_report) {
            $gps_km                     =   $dailykm_report->km;
            $km                         =   round($gps_km/1000);
            return $km;
        })
        ->make();
    }
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();
        return Excel::download(new DailyKMReportExport($request->id,$request->vehicle_id,$request->from_date,$request->to_date), 'Daily-km-report.xlsx');
    }
   
}