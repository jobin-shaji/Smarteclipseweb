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
                ->whereIn('vehicle_mode',['H','S','M'])
                ->orderBy('device_time')
                ->first();
        $last_log=GpsData::select('id','ignition','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->whereIn('vehicle_mode',['H','S','M'])
                ->latest('device_time')
                ->first();
        $balance_log=DB::select('SELECT id,ignition,device_time FROM
                            ( SELECT (@statusPre <> ignition) AS statusChanged
                                 , ignition, device_time,id
                                 , @statusPre := ignition
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE device_time >=:from_date AND device_time <=:to_date  AND gps_id=:gps_id AND vehicle_mode IN ("M", "S", "H") ORDER BY device_time 
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
    	$first_log=GpsData::select('id','vehicle_mode','device_time')             
                ->where('device_time','>=',$from_date)
                ->where('device_time','<=',$to_date) 
                ->where('gps_id',$gps_id)
                ->whereIn('vehicle_mode',['H','S','M'])
                ->orderBy('device_time')
                ->first();
        $balance_log=DB::select('SELECT id,gps_id,vehicle_mode,device_time FROM
                            ( SELECT (@statusPre <> vehicle_mode) AS statusChanged
                                 , id,gps_id,vehicle_mode,device_time
                                 , @statusPre := vehicle_mode
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE device_time >=:from_date AND device_time <=:to_date  AND gps_id=:gps_id AND vehicle_mode IN ("H", "S", "M") ORDER BY device_time 
                          ) AS good
                        WHERE statusChanged',['from_date' => $from_date,'to_date' => $to_date,'gps_id' => $gps_id]);
        $last_log=GpsData::select('id','vehicle_mode','device_time')                 
                ->where('gps_id',$gps_id)
                ->whereIn('vehicle_mode',['H','S','M'])
                ->where('device_time','>=',$from_date)
                ->where('device_time','<=',$to_date) 
                ->latest('device_time')
                ->first();
        $motion_time=0;
        $halt_time=0;
        $sleep_time=0;
        if($balance_log)
        {
            $i=0;
            foreach ($balance_log as $item) {
                if($i==0){
                    $first_device_time=$first_log->device_time;
                    $first_vehicle_mode=$first_log->vehicle_mode;
                    $item_device_time=$item->device_time;
                    $item_vehicle_mode=$item->vehicle_mode;

                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($item_vehicle_mode== "M"){
                    	if($first_vehicle_mode == "S"){
                    		$sleep_time=$sleep_time+$diff_in_minutes;
                    	}else if($first_vehicle_mode == "H"){
                    		$halt_time=$halt_time+$diff_in_minutes;
                    	}
                        
                    }else if($item_vehicle_mode== "S"){
                    	if($first_vehicle_mode == "M"){
                    		$motion_time=$motion_time+$diff_in_minutes;
                    	}else if($first_vehicle_mode == "H"){
                    		$halt_time=$halt_time+$diff_in_minutes;
                    	}
                    }else if($item_vehicle_mode== "H"){
                    	if($first_vehicle_mode == "M"){
                    		$motion_time=$motion_time+$diff_in_minutes;
                    	}else if($first_vehicle_mode == "S"){
                    		$sleep_time=$sleep_time+$diff_in_minutes;
                    	}
                    }
                }else{
                    $item_device_time=$item->device_time;
                    $item_vehicle_mode=$item->vehicle_mode;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($item_vehicle_mode== "M"){
                    	if($last_item_vehicle_mode == "S"){
                    		$sleep_time=$sleep_time+$diff_in_minutes;
                    	}else if($last_item_vehicle_mode == "H"){
                    		$halt_time=$halt_time+$diff_in_minutes;
                    	}
                        
                    }else if($item_vehicle_mode== "S"){
                    	if($last_item_vehicle_mode == "M"){
                    		$motion_time=$motion_time+$diff_in_minutes;
                    	}else if($last_item_vehicle_mode == "H"){
                    		$halt_time=$halt_time+$diff_in_minutes;
                    	}
                    }else if($item_vehicle_mode== "H"){
                    	if($last_item_vehicle_mode == "M"){
                    		$motion_time=$motion_time+$diff_in_minutes;
                    	}else if($last_item_vehicle_mode == "S"){
                    		$sleep_time=$sleep_time+$diff_in_minutes;
                    	}
                    }
                }
                $last_item_device_time=$item->device_time;
                $last_item_vehicle_mode=$item->vehicle_mode;
                $i++;
            }
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($last_item_vehicle_mode== "M"){
                $motion_time=$motion_time+$diff_in_minutes;	          
            }else if($item_vehicle_mode== "S"){
            	$sleep_time=$sleep_time+$diff_in_minutes;
            }else if($item_vehicle_mode== "H"){
            	$halt_time=$halt_time+$diff_in_minutes;
            }
        }else if($first_log != null && $balance_log==null)
        {
            $first_device_time=$first_log->device_time;
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($first_log->vehicle_mode== "M"){
                $motion_time=$motion_time+$diff_in_minutes;	    
            }else if($first_log->vehicle_mode== "S"){
            	$sleep_time=$sleep_time+$diff_in_minutes;
            }else if($first_log->vehicle_mode== "H"){
            	$halt_time=$halt_time+$diff_in_minutes;
            }
        }
        $sleep_time=$this->timeFormate($sleep_time);
        $halt_time=$this->timeFormate($halt_time);
        $motion_time=$this->timeFormate($motion_time);
        $output_data = ["total_moving" => $motion_time, 
                        "total_halt" => $halt_time,
                        "total_sleep" => $sleep_time
                       ];
        return $output_data;
    }

	public function acStatus($gps_id,$from_date,$to_date)
    { 
        $first_log=GpsData::select('id','ac_status','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->whereIn('vehicle_mode',['H','S','M'])
                ->orderBy('device_time')
                ->first();
        $last_log=GpsData::select('id','ac_status','device_time')
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->where('gps_id',$gps_id)
                ->whereIn('vehicle_mode',['H','S','M'])
                ->latest('device_time')
                ->first();
        $balance_log=DB::select('SELECT id,ac_status,device_time FROM
                          ( SELECT (@statusPre <> ac_status) AS statusChanged
                               , ac_status, device_time,id
                               , @statusPre := ac_status
                          FROM gps_data
                             , (SELECT @statusPre:=NULL) AS d
                          WHERE device_time >=:from_date AND device_time <=:to_date  AND gps_id=:gps_id AND vehicle_mode IN ("M", "S", "H") ORDER BY device_time 
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
                    if($ac_status==0){
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
                    if($ac_status==0){
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
                  	if($ac_status==0){
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
                  	if($ac_status==0){
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

    function getDateFromType($searchType, $custom_from_date, $custom_to_date) 
    {
        if ($searchType == "1") 
        {
            $from_date = date('Y-m-d H:i:s', strtotime('today midnight'));
            $to_date = date('Y-m-d H:i:s');
            $appDate = date('Y-m-d');
        } else if ($searchType == "2") {
            $from_date = date('Y-m-d H:i:s', strtotime('yesterday midnight'));
            $to_date = date('Y-m-d H:i:s', strtotime("today midnight"));
            $appDate = date('Y-m-d', strtotime("yesterday midnight"));
        } else if ($searchType == "3") {
            $from_date = date('Y-m-d H:i:s', strtotime("-7 day midnight"));
            $to_date = date('Y-m-d H:i:s',strtotime("today midnight"));
            $appDate = date('Y-m-d', strtotime("-7 day midnight")) . " " . date('Y-m-d');
        } else if ($searchType == "4") {
            $from_date = date('Y-m-d H:i:s', strtotime($custom_from_date));
            $to_date = date('Y-m-d H:i:s', strtotime($custom_to_date));
            $appDate = date('Y-m-d H:i:s', strtotime($custom_from_date)) . " " . date('Y-m-d H:i:s', strtotime($custom_to_date));
        }else if ($searchType == "5") {
            $from_date = date('Y-m-d H:i:s', strtotime("-30 day midnight"));
            $to_date = date('Y-m-d H:i:s',strtotime("today midnight"));
        }
        $output_data = ["from_date" => $from_date, 
                        "to_date" => $to_date, 
                        "appDate" => $appDate
                       ];
        return $output_data;
    }

    public function vehicleProfile($vehicle_id,$date_and_time,$client_id)
    {
        $single_vehicle_gps_id = [];     
        $single_vehicle_gps_id =  $this->vehicleGps($vehicle_id);
        $from_date_time = date('Y-m-d H:i:s', strtotime($date_and_time['from_date']));
        $to_date_time = date('Y-m-d H:i:s', strtotime($date_and_time['to_date']));
        $from_date = date('Y-m-d', strtotime($date_and_time['from_date']));
        $to_date = date('Y-m-d', strtotime($date_and_time['to_date']));
        $tracking_mode = $this->trackingMode($single_vehicle_gps_id,$from_date_time,$to_date_time);
        $engine_status=$this->engineStatus($single_vehicle_gps_id,$from_date_time,$to_date_time);
        $ac_status=$this->acStatus($single_vehicle_gps_id,$from_date_time,$to_date_time);
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
        $vehicle_profile = array();
        $vehicle_profile = array(
            'engine_on_duration' => $engine_status['engine_on_time'],
            'engine_off_duration' => $engine_status['engine_off_time'],
            'ac_on_duration' => $ac_status['ac_on_time'],
            'ac_off_duration' => $ac_status['ac_off_time'],
            'ac_halt_on_duration' => $halt_status['ac_on_time'],
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
            'dailykm' => $km_report,          
            'status' => 'kmReport'           
        );

        return $vehicle_profile;

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