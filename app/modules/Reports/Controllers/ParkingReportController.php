<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\ParkingReportExport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsModeChange;
use App\Http\Traits\VehicleDataProcessorTrait;

use DataTables;
class ParkingReportController extends Controller
{
  use VehicleDataProcessorTrait;
  
    public function parkingReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();
        return view('Reports::parking-report',['vehicles'=>$vehicles]);  
    } 
    public function parkingReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;;
        $from = $request->from_date;
        $to = $request->to_date;
        $vehicle = $request->vehicle;
        $vehicleGps=Vehicle::withTrashed()->find($vehicle); 
        $from_date = date('Y-m-d H:i:s', strtotime($from));
        $to_date = date('Y-m-d H:i:s', strtotime($to.' 23:59:59'));
        $date_and_time=array('from_date' => $from_date, 'to_date' => $to_date);
        $vehicle_profile = $this->vehicleProfile($vehicle,$date_and_time,$client_id);
        return response()->json([           
            'vehicle_name' => $vehicleGps->name,  
            'register_number' => $vehicleGps->register_number,   
            'sleep' => $vehicle_profile['sleep'],          
            'status' => 'parking_report'           
        ]);         
    }
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();
        return Excel::download(new ParkingReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Parking-report.xlsx');
    }
    function timeFormate($second){
      $hours = floor($second / 3600);
      $mins = floor($second / 60 % 60);
      $secs = floor($second % 60);
      $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
      return $timeFormat;
    }
   
}