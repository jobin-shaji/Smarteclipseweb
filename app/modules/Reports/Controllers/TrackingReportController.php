<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TrackReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsModeChange;


use DataTables;
class TrackingReportController extends Controller
{
    public function trackingReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();
        return view('Reports::tracking-report',['vehicles'=>$vehicles]);  
    }  
    public function trackReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $from = date('Y-m-d', strtotime($request->from_date));
        $to = date('Y-m-d', strtotime($request->to_date));
        $vehicle = $request->vehicle;
        $sleep=0;
        $halt=0;
        $motion=0;
        $offline=0;
        $time=0;
        $initial_time = 0;
        $previous_time =0;
        $previous_mode = 0;
        $vehicle_sleep=0;

        $vehicleGps=Vehicle::withTrashed()->find($vehicle); 

        $gps_modes=GpsModeChange::where('device_time','>=',$request->from_date)
           ->where('device_time','<=',$request->to_date)  
           ->where('gps_id',$vehicleGps->gps_id)
           ->orderBy('device_time','asc')
           ->get();

        foreach ($gps_modes as $mode) {
        if($initial_time == 0){
            $initial_time = $mode->device_time;
            $previous_time = $mode->device_time;
            $previous_mode = $mode->mode;
        }else{
            if($mode->mode == "S"){
               $time = strtotime($mode->device_time) - strtotime($previous_time);
                $sleep= $sleep+$time; 
                 if($sleep<0)
                {
                    $sleep="0";                   
                }                
            }
            else if($mode->mode == "M"){
               $time = strtotime($mode->device_time) - strtotime($previous_time);
               $motion= $motion+$time;  
                if($motion<0)
               {
                $motion="0";
                
               }  
                              
            }
            else if($mode->mode == "H"){
               $time = strtotime($mode->device_time) - strtotime($previous_time);
               $halt= $halt+$time;   
               // dd($halt) ;
              if($halt<0)
              {
                $halt="0";               
              }  
                                    
            }
        }
        $previous_time = $mode->device_time;
      }
     
      return response()->json([           
            'sleep' => $this->timeFormate($sleep),  
            'motion' => $this->timeFormate($motion),   
            'halt' => $this->timeFormate($halt),          
            'status' => 'track_report'           
        ]);           
    }
    public function export(Request $request)
    {
        // dd($request->fromDate);    
        return Excel::download(new TrackReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'track-report.xlsx');
    }
    function timeFormate($second){
      $hours = floor($second / 3600);
      $mins = floor($second / 60 % 60);
      $secs = floor($second % 60);
      $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
      return $timeFormat;
    }


}