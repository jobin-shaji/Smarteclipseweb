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

use DataTables;
class ParkingReportController extends Controller
{
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
        $sleep=0;
        $time=0;
        $initial_time = 0;
        $previous_time =0;
        $previous_mode = 0;
        $vehicle_sleep=0;
        $vehicleGps=Vehicle::withTrashed()->find($vehicle); 
        $gps_modes=GpsModeChange::where('device_time','>=',$request->from_date)
           ->where('device_time','<=',$request->to_date)  
           ->where('gps_id',$vehicleGps->gps_id)
           ->get();
         // dd($gps_modes);
        foreach ($gps_modes as $mode) {
        if($initial_time == 0){
            $initial_time = $mode->device_time;
            $previous_time = $mode->device_time;
            $previous_mode = $mode->mode;
        }else{           
             if($mode->mode == "S"){
               $time = strtotime($mode->device_time) - strtotime($previous_time);
               $sleep= $sleep+$time;   
               // dd($halt) ;
               if($sleep<0)
               {
                $sleep="0";               
               }                                      
            }
        }
        $previous_time = $mode->device_time;
      }
     
      return response()->json([           
            'vehicle_name' => $vehicleGps->name,  
            'register_number' => $vehicleGps->register_number,   
            'sleep' => $this->timeFormate($sleep),          
            'status' => 'parking_report'           
        ]);           
    }
    public function export(Request $request)
    {
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