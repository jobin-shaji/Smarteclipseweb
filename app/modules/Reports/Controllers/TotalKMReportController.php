<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TotalKMReportExport;
use App\Exports\KMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\Gps;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsModeChange;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\Route\Models\RouteDeviation;
use App\Modules\Vehicle\Models\DailyKm;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\VehicleDataProcessorTrait;
use Carbon\Carbon;
use DataTables;

class TotalKMReportController extends Controller
{

    use VehicleDataProcessorTrait;

    public function totalKMReport()
    {
    	$client_id      =   \Auth::user()->client->id;
        $vehicles       =   (new Vehicle())->getVehicleListBasedOnClient($client_id);  
        return view('Reports::total-km-report',['vehicles'=>$vehicles]);  
    }  

    public function totalKMReportList(Request $request)
    {
        $vehicle_gps_ids                =   [];
        $total_km_details               =   [];
        $client_id                      =   \Auth::user()->client->id;
        $vehicle_id                     =   $request->data['vehicle_id'];
        if($vehicle_id != 0)
        {
            $vehicle_details            =   (new Vehicle())->getSingleVehicleDetailsBasedOnVehicleId($vehicle_id);
            $vehicle_gps_details        =   (new VehicleGps())->getGpsDetailsBasedOnVehicle($vehicle_id);
            foreach($vehicle_gps_details as $each_vehicle_gps)
            {
                $vehicle_gps_ids[]      =   $each_vehicle_gps->gps_id;
            }
            $km                         =   (new Gps())->getSumOfKmBasedOnGpsOfVehicle($vehicle_gps_ids);
            $total_km_details[]         =   [   'vehicle_name'              => $vehicle_details->name,
                                                'vehicle_register_number'   => $vehicle_details->register_number,
                                                'total_km'                  => $km                             
                                            ];
        }
        else
        {
            $vehicle_details            =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
            foreach($vehicle_details as $each_vehicle)
            {
                $vehicle_id             =   $each_vehicle->id; 
                $vehicle_gps_details    =   (new VehicleGps())->getGpsDetailsBasedOnVehicle($vehicle_id);
                foreach($vehicle_gps_details as $each_vehicle_gps)
                {
                    $vehicle_gps_ids[]  =   $each_vehicle_gps->gps_id;
                }
                $km                     =   (new Gps())->getSumOfKmBasedOnGpsOfVehicle($vehicle_gps_ids);
                $total_km_details[]     =   [   'vehicle_name'              => $each_vehicle->name,
                                                'vehicle_register_number'   => $each_vehicle->register_number,
                                                'total_km'                  => $km                             
                                            ];
            }
        }
        return DataTables::of($total_km_details)
        ->addIndexColumn()        
        ->addColumn('totalkm', function ($total_km_details) {
            $gps_km=$total_km_details['total_km'];
            $km=round($gps_km/1000);
            return $km;
        })
        ->make();
    }
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();
        return Excel::download(new TotalKMReportExport($request->id,$request->vehicle), 'Total-km-report.xlsx');
    } 



    public function kmReport()
    {
        $client_id=\Auth::user()->client->id;
         $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();    
        return view('Reports::km-report',['vehicles'=>$vehicles]);  
    } 

    public function kmReportList(Request $request)
    {
        $vehicle_id =$request->vehicle;
        $report_type =$request->report_type;
        $client_id=\Auth::user()->client->id;  
        $custom_from_date = $request->from_date;
        $custom_to_date = $request->to_date;
        $date_and_time = $this->getDateFromType($report_type, $custom_from_date, $custom_to_date);
        $vehicle_profile = $this->vehicleProfile($vehicle_id,$date_and_time,$client_id);
        return response()->json($vehicle_profile);
    }

    public function kmExport(Request $request)
    {
        ob_end_clean(); 
        ob_start();
        return Excel::download(new KMReportExport($request->id,$request->vehicle,$request->report_type), 'Km-report.xlsx');
    }
    
}

