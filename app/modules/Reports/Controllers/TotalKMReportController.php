<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TotalKMReportExport;
use App\Exports\KMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsModeChange;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\Route\Models\RouteDeviation;
use App\Modules\Vehicle\Models\DailyKm;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;
class TotalKMReportController extends Controller
{
    public function totalKMReport()
    {
    	$client_id=\Auth::user()->client->id;
    	 $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();    
        return view('Reports::total-km-report',['vehicles'=>$vehicles]);  
    }  

    public function totalKMReportList(Request $request)
    {
        $single_vehicle_id = [];
        $client_id=\Auth::user()->client->id;
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];
        $vehicle =$request->data['vehicle'];
        $search_from_date=date("Y-m-d", strtotime($from));
        $search_to_date=date("Y-m-d", strtotime($to));
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::where('client_id',$client_id)->withTrashed()->get();            foreach($vehicle_details as $vehicle_detail){
                $single_vehicle_id[] = $vehicle_detail->gps_id; 

            }
        }
         $query =DailyKm::select(
            'gps_id', 
            'date',  
            \DB::raw('SUM(km) as km')    
           // 'km'
        )
        ->with('gps.vehicle') 
        ->groupBy('gps_id')   
        ->orderBy('id', 'desc');             
         if($vehicle==0 || $vehicle==null)
        {        
            $query = $query->whereIn('gps_id',$single_vehicle_id);           
        }
        else
        {
            $query = $query->where('gps_id',$single_vehicle_ids)
            ->groupBy('gps_id');               
        }   
        if($from){            
            $query = $query->whereDate('date', '>=', $search_from_date)->whereDate('date', '<=', $search_to_date);
        }                     
        $totalkm_report = $query->get();
        return DataTables::of($totalkm_report)
        ->addIndexColumn()        
        ->addColumn('totalkm', function ($totalkm_report) {
          $gps_km=$totalkm_report->km;
          $km=round($gps_km/1000);
            return $km;
        })
        ->make();
    }
    public function export(Request $request)
    {
       return Excel::download(new TotalKMReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Total-km-report.xlsx');
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
        $sleep=0;
        $halt=0;
        $motion=0;
        $offline=0;
        $time=0;
        $initial_time = 0;
        $previous_time =0;
        $previous_mode = 0;
        $vehicle_sleep=0;
        $single_vehicle_id = [];
        $client_id=\Auth::user()->client->id;       
        $vehicle =$request->vehicle;
        $report_type =$request->report_type;
        $single_vehicle_id =  $this->VehicleGPs($vehicle);
       
        $engine_status=$this->engineStatus($single_vehicle_id,$report_type);
        
        if($report_type==1)
        {
            $search_from_date=date('Y-m-d');
            $search_to_date=date('Y-m-d');
        }
        else if($report_type==2)
        {
            $search_from_date=date('Y-m-d',strtotime("-1 days"));
            $search_to_date=date('Y-m-d',strtotime("-1 days"));
        }
        else if($report_type==3)
        {
            $search_from_date=date('Y-m-d',strtotime("-7 days"));
            $search_to_date=date('Y-m-d');
            
        }
        else if($report_type==4)
        {           
            $search_from_date=date('Y-m-d',strtotime("-30 days"));
            $search_to_date=date('Y-m-d');
            
        }   
        $km_report =  $this->dailyKmReport($client_id,$vehicle,$search_from_date,$search_to_date,$single_vehicle_id);
        $gps_modes=GpsModeChange::where('device_time','>=',$search_from_date)
        ->where('device_time','<=',$search_to_date)  
        ->where('gps_id',$single_vehicle_id)
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

       $alerts =Alert::select(
            'id',
            'alert_type_id', 
            'device_time',    
            'gps_id', 
            'latitude',
            'longitude', 
            'status'
        )
        ->where('gps_id',$single_vehicle_id)
        ->whereDate('device_time', '>=', $search_from_date)
        ->whereDate('device_time', '<=', $search_to_date)
        ->get();
        $user_alert = UserAlerts::select(
            'alert_id'
        )
        ->where('client_id',$client_id)
        ->where('status',1)
        ->get();
        $alert_id = [];
        foreach($user_alert as $user_alert){
            $alert_id[] = $user_alert->alert_id;
        }

        $route_deviation =RouteDeviation::select(
            'id',
            'vehicle_id', 
            'deviating_time'
        )
        ->where('vehicle_id',$vehicle)       
        ->where('client_id',$client_id)
        ->whereDate('deviating_time', '>=', $search_from_date)
        ->whereDate('deviating_time', '<=', $search_to_date)
        ->count();


        // dd($alerts->whereIn('id',$alert_id));
        return response()->json([
            'engine_on_duration' => $engine_status['engine_on_time'],
            'engine_off_duration' => $engine_status['engine_off_time'],
            'dailykm' => $km_report, 
            'sleep' => $this->timeFormate($sleep),  
            'motion' => $this->timeFormate($motion),   
            'halt' => $this->timeFormate($halt), 
            'sudden_acceleration' => $alerts->where('alert_type_id',2)->count(), 
            'harsh_braking' => $alerts->where('alert_type_id',1)->count(),               
            'main_battery_disconnect' => $alerts->where('alert_type_id',11)->count(),               
            'accident_impact' => $alerts->where('alert_type_id',14)->count(),  
            'zig_zag' => $alerts->where('alert_type_id',3)->count(), 
            'over_speed' => $alerts->where('alert_type_id',12)->count(),  
            'user_alert' => $alerts->whereIn('alert_type_id',$alert_id)->count(),
            'geofence' => $alerts->whereIn('alert_type_id',[18,19,20,21])->count(),
            'route_deviation' => $route_deviation,             
            'status' => 'kmReport'           
        ]);

    //     $response_data = array(
    //             'status'  => 'success',
    //             'message' => 'success',
    //             'code'    =>1,                              
    //             'polyline' => $playback,
    //             'markers' => $playbackData,
                
    //         );
    //     }else{
    //         $response_data = array(
    //             'status'  => 'failed',
    //             'message' => 'failed',
    //             'code'    =>0
    //         );
    //     }

    
    // return response()->json($response_data); 



        // return DataTables::of($km_report)
        // ->addIndexColumn()        
        // ->addColumn('totalkm', function ($km_report) {
        //   $gps_km=$km_report->km;
        //   $km=round($gps_km/1000);
        //     return $km;
        // })
        // ->make();
    }
    function VehicleGPs($vehicle){       
        $vehicle_details =Vehicle::withTrashed()->find($vehicle);
       return  $single_vehicle_id = $vehicle_details->gps_id;
       
    }

    function dailyKmReport($client_id,$vehicle,$search_from_date,$search_to_date,$single_vehicle_id){
         $query =DailyKm::select(
            'gps_id', 
            'date',  
            \DB::raw('SUM(km) as km')    
        )
        ->with('gps.vehicle')
        ->groupBy('gps_id')   
        ->orderBy('id', 'desc');             
         if($vehicle==0 || $vehicle==null)
        {        
            $query = $query->whereIn('gps_id',$single_vehicle_id);           
        }
        else
        {
            $query = $query->where('gps_id',$single_vehicle_id)
            ->groupBy('gps_id');               
        }   
        if($search_from_date){            
            $query = $query->whereDate('date', '>=', $search_from_date)->whereDate('date', '<=', $search_to_date);
        }                     
         return $km_report = $query->first();  
    }
    
    function timeFormate($second){
      $hours = floor($second / 3600);
      $mins = floor($second / 60 % 60);
      $secs = floor($second % 60);
      $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
      return $timeFormat;
    }


    public function kmExport(Request $request)
    {
       return Excel::download(new KMReportExport($request->id,$request->vehicle,$request->report_type), 'Km-report.xlsx');
    }

    function engineStatus($gps_id,$report_type)
    { 
        $dates=$this->getDateFromType($report_type);
        $from_date=$dates['from_date'];
        $to_date=$dates['to_date'];
        $first_log=GpsData::select('id','ignition','device_time')->where('device_time', '>=', $from_date)->where('device_time', '<=', $to_date)->where('gps_id',$gps_id)->orderBy('device_time')->first();
        $last_log=GpsData::select('id','ignition','device_time')->whereDate('device_time', '>=', $from_date)->whereDate('device_time', '<=', $to_date)->where('gps_id',$gps_id)->latest('device_time')->first();
        $balance_log=DB::select('SELECT id,ignition,device_time FROM
                            ( SELECT (@statusPre <> ignition) AS statusChanged
                                 , ignition, device_time,id
                                 , @statusPre := ignition
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE device_time >=:from_date AND device_time <=:to_date  AND gps_id=:gps_id ORDER BY device_time 
                          ) AS good
                        WHERE statusChanged',['from_date' => $from_date,'to_date' => $to_date,'gps_id' => $gps_id]);
        $engine_on_time=0;
        $engine_off_time=0;
        if($balance_log)
        {
            $i=0;
            foreach ($balance_log as $item) {
                if($i==0){
                    $first_device_time=$first_log->device_time;
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }else{
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }
                $last_item_device_time=$item->device_time;
                $last_ignition=$item->ignition;
                $i++;
            }
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($last_ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }else if($first_log != null && $balance_log==null)
        {
            $first_device_time=$first_log->device_time;
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($first_log->ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }
        $engine_on_hours = floor($engine_on_time / 3600);
        $engine_on_mins = floor($engine_on_time / 60 % 60);
        $engine_on_secs = floor($engine_on_time % 60); 
        $engine_off_hours = floor($engine_off_time / 3600);
        $engine_off_mins = floor($engine_off_time / 60 % 60);
        $engine_off_secs = floor($engine_off_time % 60); 
        $engine_on_time = sprintf('%02d:%02d:%02d', $engine_on_hours, $engine_on_mins, $engine_on_secs);
        $engine_off_time = sprintf('%02d:%02d:%02d', $engine_off_hours, $engine_off_mins, $engine_off_secs);
        $engine_status = array(
                "engine_on_time" => $engine_on_time, 
                "engine_off_time" => $engine_off_time
                );
        return $engine_status;
    }
    

    function acStatus($gps_id,$report_type)
    { 
        $dates=$this->getDateFromType($report_type);
        $from_date=$dates['from_date'];
        $to_date=$dates['to_date'];
        $first_log=GpsData::select('id','ignition','device_time')->where('device_time', '>=', $from_date)->where('device_time', '<=', $to_date)->where('gps_id',$gps_id)->orderBy('device_time')->first();
        $last_log=GpsData::select('id','ignition','device_time')->whereDate('device_time', '>=', $from_date)->whereDate('device_time', '<=', $to_date)->where('gps_id',$gps_id)->latest('device_time')->first();
        $balance_log=DB::select('SELECT id,ignition,device_time FROM
                            ( SELECT (@statusPre <> ignition) AS statusChanged
                                 , ignition, device_time,id
                                 , @statusPre := ignition
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE device_time >=:from_date AND device_time <=:to_date  AND gps_id=:gps_id ORDER BY device_time 
                          ) AS good
                        WHERE statusChanged',['from_date' => $from_date,'to_date' => $to_date,'gps_id' => $gps_id]);
        $engine_on_time=0;
        $engine_off_time=0;
        if($balance_log)
        {
            $i=0;
            foreach ($balance_log as $item) {
                if($i==0){
                    $first_device_time=$first_log->device_time;
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }else{
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }
                $last_item_device_time=$item->device_time;
                $last_ignition=$item->ignition;
                $i++;
            }
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($last_ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }else if($first_log != null && $balance_log==null)
        {
            $first_device_time=$first_log->device_time;
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($first_log->ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }
        $engine_on_hours = floor($engine_on_time / 3600);
        $engine_on_mins = floor($engine_on_time / 60 % 60);
        $engine_on_secs = floor($engine_on_time % 60); 
        $engine_off_hours = floor($engine_off_time / 3600);
        $engine_off_mins = floor($engine_off_time / 60 % 60);
        $engine_off_secs = floor($engine_off_time % 60); 
        $engine_on_time = sprintf('%02d:%02d:%02d', $engine_on_hours, $engine_on_mins, $engine_on_secs);
        $engine_off_time = sprintf('%02d:%02d:%02d', $engine_off_hours, $engine_off_mins, $engine_off_secs);
        $engine_status = array(
                "engine_on_time" => $engine_on_time, 
                "engine_off_time" => $engine_off_time
                );
        return $engine_status;
    }





    function getDateFromType($report_type) 
    {
        if ($report_type == "1") 
        {
            $from_date = date('Y-m-d H:i:s', strtotime('today midnight'));
            $to_date = date('Y-m-d H:i:s');
        } else if ($report_type == "2") {
            $from_date = date('Y-m-d H:i:s', strtotime('yesterday midnight'));
            $to_date = date('Y-m-d H:i:s', strtotime("today midnight"));
        } else if ($report_type == "3") {
            $from_date = date('Y-m-d H:i:s', strtotime("-7 day midnight"));
            $to_date = date('Y-m-d H:i:s',strtotime("today midnight"));
        } else if ($report_type == "4") {
            $from_date = date('Y-m-d H:i:s', strtotime("-30 day midnight"));
            $to_date = date('Y-m-d H:i:s',strtotime("today midnight"));
        }
        $output_data = ["from_date" => $from_date, 
                        "to_date" => $to_date
                       ];
        return $output_data;
     }

}

