<?php

namespace App\Http\Traits;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsModeChange;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\Route\Models\RouteDeviation;
use App\Modules\Vehicle\Models\DailyKm;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait VehicleDataProcessorTrait{


    public function timeFormate($second){
      $hours = floor($second / 3600);
      $mins = floor($second / 60 % 60);
      $secs = floor($second % 60);
      $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
      return $timeFormat;
    }

	public function engineStatus($gps_id,$from_date,$to_date)
    { 
        $first_log=GpsData::select('id','ignition','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->orderBy('device_time')
                ->first();
        $last_log=GpsData::select('id','ignition','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->latest('device_time')
                ->first();
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
                    if($ignition==1){
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
                    if($ignition==1){
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
        $engine_on_time = $this->timeFormate($engine_on_time);
        $engine_off_time = $this->timeFormate($engine_off_time);
        $engine_status = array(
                "engine_on_time" => $engine_on_time, 
                "engine_off_time" => $engine_off_time
                );
        return $engine_status;
    }

	public function trackingMode($gps_id,$from_date,$to_date)
    {
        $sleep=0;
        $halt=0;
        $moving=0;
        $time=0;
        $initial_time = 0;
        $previous_time =0;
        $previous_mode = 0;
        $first_log=GpsData::select('id','vehicle_mode','device_time')             
                ->where('device_time','>=',$from_date)
                ->where('device_time','<=',$to_date) 
                ->where('gps_id',$gps_id)
                ->orderBy('device_time')
                ->first();
        $balance_log=DB::select('SELECT id,gps_id,vehicle_mode,device_time FROM
                            ( SELECT (@statusPre <> vehicle_mode) AS statusChanged
                                 , id,gps_id,vehicle_mode,device_time
                                 , @statusPre := vehicle_mode
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE device_time >=:from_date AND device_time <=:to_date  AND gps_id=:gps_id ORDER BY device_time 
                          ) AS good
                        WHERE statusChanged',['from_date' => $from_date,'to_date' => $to_date,'gps_id' => $gps_id]);
        $last_log=GpsData::select('id','vehicle_mode','device_time')                 
                ->where('gps_id',$gps_id)
                ->where('device_time','>=',$from_date)
                ->where('device_time','<=',$to_date) 
                ->latest('device_time')
                ->first();
        if($first_log != null){
            $initial_time = 1;
            $initial_time = $first_log->device_time;
            $previus_time = $first_log->device_time;
            $previud_mode = $first_log->vehicle_mode;
        }
        if($balance_log){
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
        $output_data = ["total_moving" => $total_moving, 
                        "total_halt" => $total_halt,
                        "total_sleep" => $total_sleep
                       ];
        return $output_data;
    }

	public function acStatus($gps_id,$from_date,$to_date)
    { 
        $first_log=GpsData::select('id','ac_status','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->orderBy('device_time')
                ->first();
        $last_log=GpsData::select('id','ac_status','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->latest('device_time')
                ->first();
        $balance_log=DB::select('SELECT id,ac_status,device_time FROM
                          ( SELECT (@statusPre <> ac_status) AS statusChanged
                               , ac_status, device_time,id
                               , @statusPre := ac_status
                          FROM gps_data
                             , (SELECT @statusPre:=NULL) AS d
                          WHERE device_time >=:from_date AND device_time <=:to_date  AND gps_id=:gps_id ORDER BY device_time 
                        ) AS good
                      WHERE statusChanged',['from_date' => $from_date,'to_date' => $to_date,'gps_id' => $gps_id]);
       
        $ac_on_time=0;
        $ac_off_time=0;
        if($balance_log)
        {
            $i=0;
            foreach ($balance_log as $item) {
                if($i==0){
                    $first_device_time=$first_log->device_time;
                    $item_device_time=$item->device_time;
                    $ac_status=$item->ac_status;                  
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ac_status==1){
                        $ac_on_time=$ac_on_time+$diff_in_minutes;
                    }else{
                        $ac_off_time=$ac_off_time+$diff_in_minutes;
                    }
                }else{
                    $item_device_time=$item->device_time;
                    $ac_status=$item->ac_status;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ac_status==1){
                        $ac_on_time=$ac_on_time+$diff_in_minutes;
                    }else{
                        $ac_off_time=$ac_off_time+$diff_in_minutes;
                    }
                }
                $last_item_device_time=$item->device_time;
                $last_ac_status=$item->ac_status;
                $i++;
            }
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($last_ac_status==0){
                $ac_off_time=$ac_off_time+$diff_in_minutes;
            }else{
                $ac_on_time=$ac_on_time+$diff_in_minutes;
            }
        }else if($first_log != null && $balance_log==null)
        {
            $first_device_time=$first_log->device_time;
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($first_log->ac_status==0){
                $ac_off_time=$ac_off_time+$diff_in_minutes;
            }else{
                $ac_on_time=$ac_on_time+$diff_in_minutes;
            }
        }
        $ac_on_time = $this->timeFormate($ac_on_time);
        $ac_off_time = $this->timeFormate($ac_off_time);
        $ac_status = array(
              "ac_on_time" => $ac_on_time, 
              "ac_off_time" => $ac_off_time
              );
        return $ac_status;
    }

    public function haltAcStatus($gps_id,$from_date,$to_date)
    { 
        $first_log=GpsData::select('id','ac_status','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->where('vehicle_mode','H')
                ->orderBy('device_time')
                ->first();
        $last_log=GpsData::select('id','ac_status','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->where('vehicle_mode','H')
                ->latest('device_time')
                ->first();
        $balance_halt_log=DB::select('SELECT id,ac_status,device_time FROM
                          ( SELECT (@statusPre <> ac_status) AS statusChanged
                               , ac_status, device_time,id
                               , @statusPre := ac_status
                          FROM gps_data
                             , (SELECT @statusPre:=NULL) AS d
                          WHERE device_time >=:from_date AND device_time <=:to_date  AND gps_id=:gps_id AND vehicle_mode="H" ORDER BY device_time 
                        ) AS good
                      WHERE statusChanged',['from_date' => $from_date,'to_date' => $to_date,'gps_id' => $gps_id]);
      	$ac_on_time=0;
      	$ac_off_time=0;
      	if($balance_halt_log)
      	{
          	$i=0;
          	foreach ($balance_halt_log as $item) {
              	if($i==0){
                  	$first_device_time=$first_log->device_time;
                  	$item_device_time=$item->device_time;
                  	$ac_status=$item->ac_status;
                 	$from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
                  	$to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                  	$diff_in_minutes = $to->diffInSeconds($from);
                  	if($ac_status==1){
                      $ac_on_time=$ac_on_time+$diff_in_minutes;
                  	}else{
                      $ac_off_time=$ac_off_time+$diff_in_minutes;
                  	}
              	}else{
                  	$item_device_time=$item->device_time;
                  	$ac_status=$item->ac_status;
                  	$from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
                  	$to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                  	$diff_in_minutes = $to->diffInSeconds($from);
                  	if($ac_status==1){
                      	$ac_on_time=$ac_on_time+$diff_in_minutes;
                  	}else{
                      	$ac_off_time=$ac_off_time+$diff_in_minutes;
                  	}
              	}
              	$last_item_device_time=$item->device_time;
              	$last_ac_status=$item->ac_status;
              	$i++;
          	}
          	$last_device_time=$last_log->device_time;
          	$from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
          	$to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
          	$diff_in_minutes = $to->diffInSeconds($from);
          	if($last_ac_status==0){
              	$ac_off_time=$ac_off_time+$diff_in_minutes;
          	}else{
              	$ac_on_time=$ac_on_time+$diff_in_minutes;
          	}
      	}else if($first_log != null && $balance_halt_log==null)
      	{
          	$first_device_time=$first_log->device_time;
          	$last_device_time=$last_log->device_time;
          	$from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
          	$to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
          	$diff_in_minutes = $to->diffInSeconds($from);
          	if($first_log->ac_status==0){
              	$ac_off_time=$ac_off_time+$diff_in_minutes;
          	}else{
            	$ac_on_time=$ac_on_time+$diff_in_minutes;
          	}
      	}
      	$ac_on_time = $this->timeFormate($ac_on_time);
      	$ac_halt_status = array(
        	"ac_on_time" => $ac_on_time 
      	);
      	return $ac_halt_status;
    }

    public function vehicleProfile($vehicle_id,$date_and_time,$client_id)
    {
    	$sleep=0;
        $halt=0;
        $moving=0;
        $offline=0;
        $time=0;
        $initial_time = 0;
        $previous_time =0;
        $previous_mode = 0;
        $vehicle_sleep=0;
        $single_vehicle_gps_id = [];     
        $single_vehicle_gps_id =  $this->vehicleGps($vehicle_id);
        $from_date_time = date('Y-m-d H:i:s', strtotime($date_and_time['from_date']));
        $to_date_time = date('Y-m-d H:i:s', strtotime($date_and_time['to_date']));
        $from_date = date('Y-m-d', strtotime($date_and_time['from_date']));
        $to_date = date('Y-m-d', strtotime($date_and_time['to_date']));
        $tracking_mode = $this->trackingMode($single_vehicle_gps_id,$from_date_time,$to_date_time);
        $engine_status=$this->engineStatus($single_vehicle_gps_id,$from_date_time,$to_date_time);
        $ac_status=$this->acStatus($single_vehicle_gps_id,$from_date_time,$to_date);
        $halt_status=$this->haltAcStatus($single_vehicle_gps_id,$from_date_time,$to_date_time);      
        $km_report =  $this->dailyKmReport($client_id,$vehicle_id,$from_date,$to_date,$single_vehicle_gps_id);       
        $alerts =Alert::select(
	            'id',
	            'alert_type_id', 
	            'device_time',    
	            'gps_id', 
	            'latitude',
	            'longitude', 
	            'status'
	        )
	        ->where('gps_id',$single_vehicle_gps_id)
	        ->whereDate('device_time', '>=', $from_date)
	        ->whereDate('device_time', '<=', $to_date)
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
        ->where('vehicle_id',$vehicle_id)       
        ->where('client_id',$client_id)
        ->whereDate('deviating_time', '>=', $from_date)
        ->whereDate('deviating_time', '<=', $to_date)
        ->count();

        return array(
            'engine_on_duration' => $engine_status['engine_on_time'],
            'engine_off_duration' => $engine_status['engine_off_time'],
            'ac_on_duration' => $ac_status['ac_on_time'],
            'ac_off_duration' => $ac_status['ac_off_time'],
            'ac_halt_on_duration' => $halt_status['ac_on_time'],
            'dailykm' => $km_report, 
            'sleep' => $tracking_mode['total_sleep'],  
            'motion' => $tracking_mode['total_moving'],   
            'halt' => $tracking_mode['total_halt'], 
            'sudden_acceleration' => $alerts->where('alert_type_id',2)->count(), 
            'harsh_braking' => $alerts->where('alert_type_id',1)->count(),               
            'main_battery_disconnect' => $alerts->where('alert_type_id',11)->count(),               
            'accident_impact' => $alerts->where('alert_type_id',14)->count(),  
            'zig_zag' => $alerts->where('alert_type_id',3)->count(), 
            'over_speed' => $alerts->where('alert_type_id',12)->count(),  
            'user_alert' => $alerts->whereIn('alert_type_id',$alert_id)->count(),
            'geofence_entry' => $alerts->where('alert_type_id',5)->count(),
            'geofence_exit' => $alerts->where('alert_type_id',6)->count(),
            'geofence_entry_overspeed' => $alerts->where('alert_type_id',15)->count(),
            'geofence_exit_overspeed' => $alerts->where('alert_type_id',16)->count(),
            'route_deviation' => $route_deviation,             
            'status' => 'kmReport'           
        );

    }

    public function vehicleGps($vehicle_id){       
        $vehicle_details =Vehicle::withTrashed()->find($vehicle_id);
       	return  $single_vehicle_gps_id = $vehicle_details->gps_id;
    }

    public function dailyKmReport($client_id,$vehicle_id,$search_from_date,$search_to_date,$single_vehicle_gps_id)
    {
        $query =DailyKm::select(
            'gps_id', 
            'date',  
            \DB::raw('SUM(km) as km')    
        )
	        ->with('gps.vehicle')
	        ->groupBy('gps_id')   
	        ->orderBy('id', 'desc');             
        if($vehicle_id==0 || $vehicle_id==null)
        {        
            $query = $query->whereIn('gps_id',$single_vehicle_gps_id);           
        }
        else
        {
            $query = $query->where('gps_id',$single_vehicle_gps_id)
            ->groupBy('gps_id');               
        }   
        if($search_from_date){            
            $query = $query->whereDate('date', '>=', $search_from_date)->whereDate('date', '<=', $search_to_date);
        }                     
        return $km_report = $query->first();  
    }




}