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
use DB;


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
        $from = date('Y-m-d H:i:s', strtotime($request->from_date));
        $to = date('Y-m-d H:i:s', strtotime($request->to_date));
      
        $vehicle = $request->vehicle;
        $sleep=0;
        $halt=0;
        $moving=0;
        $offline=0;
        $initial_time = 0;
        $previus_time =0;
        $previud_mode = 0;
        $vehicleGps=Vehicle::withTrashed()->find($vehicle); 
        $gps_id=$vehicleGps->gps_id;
        $first_log=GpsData::select('id','vehicle_mode','device_time')             
       ->where('device_time','>=',$from)
       ->where('device_time','<=',$to) 
       ->where('gps_id',$gps_id)
       ->orderBy('device_time')
       ->first();
       $balance_log=DB::select('SELECT id,gps_id,vehicle_mode,device_time FROM
                            ( SELECT (@statusPre <> vehicle_mode) AS statusChanged
                                 , ignition, vehicle_mode,device_time,gps_id,id
                                 , @statusPre := vehicle_mode
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE gps_id='.$gps_id.'
                              AND
                              device_time between "'.$from .'" and "'. $to .'"
                             ORDER BY device_time
                          ) AS good
                        WHERE statusChanged');
       // dd($gps_id);
        $last_log=GpsData::select('id','vehicle_mode','device_time')                    
        ->where('gps_id',$gps_id)
        ->where('device_time','>=',$from)
        ->where('device_time','<=',$to) 
        ->latest('device_time')
        ->first();
         if($first_log != null){
            $initial_time = 1;
            $initial_time = $first_log->device_time;
            $previus_time = $first_log->device_time;
            $previud_mode = $first_log->vehicle_mode;
          }
         foreach ($balance_log as $mode) {
          if($initial_time == 0)
          {
              $initial_time = $mode->device_time;
              $previus_time = $mode->device_time;
              $previud_mode = $mode->vehicle_mode;
          }else{
              if($mode->vehicle_mode == "S"){
                  $time = strtotime($mode->device_time) - strtotime($previus_time);
                  $sleep = $sleep+$time;
              }else if($mode->vehicle_mode == "H"){
                 $time = strtotime($mode->device_time) - strtotime($previus_time);
                 $halt = $halt+$time; 
              }else if($mode->vehicle_mode == "M"){
                 $time = strtotime($mode->device_time) - strtotime($previus_time);
                 $moving = $moving+$time; 
              }
          }
          $previus_time = $mode->device_time;
        }      
      if($last_log != null){
       if($last_log->vehicle_mode == "S"){
            $time = strtotime($last_log->device_time) - strtotime($previus_time);
            $sleep = $sleep+$time;
          }else if($last_log->vehicle_mode == "H"){
             $time = strtotime($last_log->device_time) - strtotime($previus_time);
             $halt = $halt+$time; 
          }else if($last_log->vehicle_mode == "M"){
             $time = strtotime($last_log->device_time) - strtotime($previus_time);
             $moving = $moving+$time; 
          }
       }
       if($sleep < 0){$sleep =0;}
       $total_sleep=$this->timeFormate($sleep);

      if($halt< 0){$halt=0;}
      $total_halt=$this->timeFormate($halt);
    
      if($moving< 0){$moving=0;}
      $total_moving=$this->timeFormate($moving);
      return response()->json([           
            'sleep' => $total_sleep,  
            'motion' => $total_moving,   
            'halt' => $total_halt,          
            'status' => 'track_report'           
        ]);           
    }
    public function modeTimeSummery($from,$to,$gps_id){
      $sleep=0;
      $halt=0;
      $moving=0;
      $offline=0;
      $initial_time = 0;
      $previus_time =0;
      $previud_mode = 0;

      // $gps_modes=GpsModeChange::where('device_time','>=',$from)
      //                           ->where('device_time','<=',$to) 
      //                           ->where('gps_id',$gps_id)
      //                           ->orderBY('device_time','asc')
      //                           ->get();


  
      $first_log=GpsData::select('id','vehicle_mode','device_time')
             
                         ->where('device_time','>=',$from)
                         ->where('device_time','<=',$to) 
                         ->where('gps_id',$gps_id)
                         ->orderBy('device_time')
                         ->first();


      $balance_log=DB::select('SELECT id,gps_id,vehicle_mode,device_time FROM
                            ( SELECT (@statusPre <> vehicle_mode) AS statusChanged
                                 , ignition, vehicle_mode,device_time,gps_id,id
                                 , @statusPre := vehicle_mode
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE gps_id='.$gps_id.'
                              AND
                              device_time between "'.$from .'" and "'. $to .'"
                             ORDER BY device_time
                          ) AS good
                        WHERE statusChanged');

       $last_log=GpsData::select('id','vehicle_mode','device_time')
                     
                        ->where('gps_id',$gps_id)
                        ->where('device_time','>=',$from)
                        ->where('device_time','<=',$to) 
                        ->latest('device_time')
                        ->first();



     if($first_log != null){
      $initial_time = 1;
      $initial_time = $first_log->device_time;
      $previus_time = $first_log->device_time;
      $previud_mode = $first_log->vehicle_mode;
     }


      foreach ($balance_log as $mode) {
        if($initial_time == 0)
        {
            $initial_time = $mode->device_time;
            $previus_time = $mode->device_time;
            $previud_mode = $mode->vehicle_mode;
        }else{
            if($mode->vehicle_mode == "S"){
                $time = strtotime($mode->device_time) - strtotime($previus_time);
                $sleep = $sleep+$time;
            }else if($mode->vehicle_mode == "H"){
               $time = strtotime($mode->device_time) - strtotime($previus_time);
               $halt = $halt+$time; 
            }else if($mode->vehicle_mode == "M"){
               $time = strtotime($mode->device_time) - strtotime($previus_time);
               $moving = $moving+$time; 
            }
        }

        $previus_time = $mode->device_time;
      }


      if($last_log != null){
       if($last_log->vehicle_mode == "S"){
            $time = strtotime($last_log->device_time) - strtotime($previus_time);
            $sleep = $sleep+$time;
          }else if($last_log->vehicle_mode == "H"){
             $time = strtotime($last_log->device_time) - strtotime($previus_time);
             $halt = $halt+$time; 
          }else if($last_log->vehicle_mode == "M"){
             $time = strtotime($last_log->device_time) - strtotime($previus_time);
             $moving = $moving+$time; 
          }
       }

      if($sleep < 0){$sleep =0;}
       $total_sleep=$this->timeFormate($sleep);

      if($halt< 0){$halt=0;}
      $total_halt=$this->timeFormate($halt);
    
      if($moving< 0){$moving=0;}
      $total_moving=$this->timeFormate($moving);
    

      $travel_summery=["idle"=>$total_halt,
                       "running"=>$total_moving,
                       "stop"=>$total_sleep,
                       "inactive" => 0
                      ];
     return $travel_summery;                    
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