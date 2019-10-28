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
        $initial_time = 0;
        $previus_time =0;
        $previud_mode = 0;
        $vehicle_sleep=0;
        $vehicleGps=Vehicle::withTrashed()->find($vehicle); 
        $gps_modes=GpsModeChange::where('device_time','>=',$from)
           ->where('device_time','<=',$to)  
           ->where('gps_id',$vehicleGps->gps_id)
           ->get();

        foreach ($gps_modes as $mode) {
        if($initial_time == 0){
            $initial_time = $mode->device_time;
            $previus_time = $mode->device_time;
            $previud_mode = $mode->mode;
        }else{
            if($mode->mode == "S"){
               $time = strtotime($mode->device_time) - strtotime($previus_time);
               //  date('Y-m-d', strtotime($time));
               // echo "<br>";
                $sleep= $sleep+$time;
                $vehicle_sleep= gmdate("H:i:s",$sleep);                  
            }
            if($mode->mode == "M"){
               $time = strtotime($mode->device_time) - strtotime($previus_time);
               //  date('Y-m-d', strtotime($time));
               // echo "<br>";
                $sleep= $sleep+$time;
                $vehicle_motion= gmdate("H:i:s",$sleep);                  
            }
        }
        $previus_time = $mode->device_time;
      }
      return response()->json([           
            'sleep' => $vehicle_sleep,  
            'motion' => $vehicle_motion,   
            'halt' => $vehicle_motion,          

            'status' => 'track_report'           
        ]);           
    // dd($vehicle_sleep);
        // $query =GpsData::select(
        //     'gps_id',           
        //     'imei',           
        //     'latitude',            
        //     'longitude',           
        //     'date',
        //     'time',
        //     'speed',
        //     'alert_id',                    
        //     'vehicle_mode',           
        //     \DB::raw('DATE(device_time) as device_time'),
        //     \DB::raw('sum(distance) as distance')
        // )
        // ->with('gps.vehicle')
        // ->limit(1000);     
        // if($from)
        // {           
        //     $vehicle=Vehicle::withTrashed()->find($vehicle); 
        //     $search_from_date=date("Y-m-d", strtotime($from));
        //     $search_to_date=date("Y-m-d", strtotime($to));
        //     $query = $query->where('gps_id',$vehicle->gps_id)->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date)->groupBy('date');       
                 
        //  }
        // $track_report = $query->get();  
        
    }
    public function export(Request $request)
    {
        // dd($request->fromDate);    
        return Excel::download(new TrackReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'track-report.xlsx');
    }

    public function modeTime(){
      $from="2019-10-23 10:10:10";
      $to="2019-10-26 10:10:10";
      $gps_id=5;
      $sleep=0;
      $halt=0;
      $motion=0;
      $offline=0;
      $initial_time = 0;
      $previus_time =0;
      $previud_mode = 0;

      $gps_modes=GpsModeChange::where('device_time','>=',$from)
                                   ->where('device_time','<=',$to)  
                                   ->where('gps_id',$gps_id)
                                   ->get();
      foreach ($gps_modes as $mode) {
        if($initial_time == 0){
            $initial_time = $mode->device_time;
            $previus_time = $mode->device_time;
            $previud_mode = $mode->mode;
        }else{
            if($mode->mode == "S"){
               $time = strtotime($mode->device_time) - strtotime($previus_time);
               echo date('Y-m-d', strtotime($time));
               echo "<br>";
                $sleep = $sleep+$time;
            }
        }

        $previus_time = $mode->device_time;
      }
                               
    }
}