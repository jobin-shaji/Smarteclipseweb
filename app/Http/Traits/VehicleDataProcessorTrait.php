<?php

namespace App\Http\Traits;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Gps\Models\GpsModeChange;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\Route\Models\RouteDeviation;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Vehicle\Models\VehicleDailyUpdate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait VehicleDataProcessorTrait{


    public function timeFormate($second)
    {
      $hours        =   floor($second / 3600);
      $mins         =   floor($second / 60 % 60);
      $secs         =   floor($second % 60);
      $timeFormat   =   sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
      return $timeFormat;
    }

    function getDateFromType($searchType, $custom_from_date, $custom_to_date) 
    {
        if ($searchType == "1") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime('today midnight'));
            $to_date        =   date('Y-m-d H:i:s');
            $appDate        =   date('Y-m-d');
        } 
        else if ($searchType == "2") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime('yesterday midnight'));
            $to_date        =   date('Y-m-d H:i:s', strtotime("yesterday 23:59:59"));
            $appDate        =   date('Y-m-d', strtotime("yesterday midnight"));
        } 
        else if ($searchType == "3") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-7 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
            $appDate        =   date('Y-m-d', strtotime("-7 day midnight")) . " " . date('Y-m-d', strtotime("yesterday 23:59:59"));
        } 
        else if ($searchType == "4") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime($custom_from_date));
            $to_date        =   date('Y-m-d H:i:s', strtotime($custom_to_date));
            $appDate        =   date('Y-m-d H:i:s', strtotime($custom_from_date)) . " " . date('Y-m-d H:i:s', strtotime($custom_to_date));
        }
        else if ($searchType == "5") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-30 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
            $appDate        =   date('Y-m-d', strtotime("-30 day midnight")) . " " . date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        else if ($searchType == "6") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-60 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
            $appDate        =   date('Y-m-d', strtotime("-60 day midnight")) . " " . date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        else if ($searchType == "7") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-120 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
            $appDate        =   date('Y-m-d', strtotime("-120 day midnight")) . " " . date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        else if ($searchType == "8") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-180 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
            $appDate        =   date('Y-m-d', strtotime("-180 day midnight")) . " " . date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        $output_data        =   [   "from_date" => $from_date, 
                                    "to_date" => $to_date, 
                                    "appDate" => $appDate
                                ];
        return $output_data;
    }

    public function vehicleDailyUpdates($gps_ids,$from_date,$to_date)
    {
        $vehicle_durations          =   (new VehicleDailyUpdate())->getVehicleDurationsBasedOnDates($gps_ids,$from_date,$to_date); 
        $ignition_on_time           =   $this->timeFormate($vehicle_durations->ignition_on);
        $ignition_off_time          =   $this->timeFormate($vehicle_durations->ignition_off);
        $moving_time                =   $this->timeFormate($vehicle_durations->moving);
        $halt_time                  =   $this->timeFormate($vehicle_durations->halt);
        $sleep_time                 =   $this->timeFormate($vehicle_durations->sleep);
        $stop_time                  =   $this->timeFormate($vehicle_durations->stop);
        $ac_on_time                 =   $this->timeFormate($vehicle_durations->ac_on);
        $ac_off_time                =   $this->timeFormate($vehicle_durations->ac_off);
        $ac_on_idle_time            =   $this->timeFormate($vehicle_durations->ac_on_idle);
        $durations                  =   array(
                                            "ignition_on_time" => $ignition_on_time,
                                            "ignition_off_time" => $ignition_off_time, 
                                            "moving_time" => $moving_time, 
                                            "halt_time" => $halt_time,  
                                            "sleep_time" => $sleep_time, 
                                            "stop_time" => $stop_time, 
                                            "ac_on_time" => $ac_on_time, 
                                            "ac_off_time" => $ac_off_time, 
                                            "ac_on_idle_time" => $ac_on_idle_time
                                        );
        return $durations;
    }

    public function vehicleProfile($vehicle_id, $date_and_time, $client_id, $maximum_allowed_time_in_hours)
    {
        $single_vehicle_gps_ids         =   [];     
        //$single_vehicle_gps_id        =   $this->vehicleGps($vehicle_id);
        $from_date                      =   date('Y-m-d', strtotime($date_and_time['from_date']));
        $to_date                        =   date('Y-m-d', strtotime($date_and_time['to_date']));
        $vehicle_gps_ids                =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithDates($vehicle_id,$from_date,$to_date);
        foreach($vehicle_gps_ids as $vehicle_gps_id)
        {
            $single_vehicle_gps_ids[]   =   $vehicle_gps_id->gps_id;
        }
        $total_km                       =   $this->vehicleTotalKilometres($from_date, $to_date, $single_vehicle_gps_ids);       
        //getting durations from vehicle daily update table
        $vehicle_daily_updates          =   $this->vehicleDailyUpdates($single_vehicle_gps_ids,$from_date,$to_date);
        
        // workaround for ignition durations
        $ignition_on_duration           =   $vehicle_daily_updates['ignition_on_time'];
        $ignition_off_duration          =   $vehicle_daily_updates['ignition_off_time'];
        
        $sum_of_ignition_durations      =   $this->calculateSumOfDurations([$ignition_on_duration, $ignition_off_duration]);

        if( $sum_of_ignition_durations['hours'] > $maximum_allowed_time_in_hours )
        {
            if($ignition_on_duration > $ignition_off_duration)
            {
                $ignition_on_duration   =   $this->calculateDeviationFromMaximumAllowedDuration($ignition_off_duration, $maximum_allowed_time_in_hours);
            }
            else
            {
                $ignition_off_duration  =   $this->calculateDeviationFromMaximumAllowedDuration($ignition_on_duration, $maximum_allowed_time_in_hours);
            }
        }

        // workaround for vehicle status durations
        $vehicle_status_durations       =   $this->maskVehicleStatusDurationOverflow([ 
                                                'm'     =>  $vehicle_daily_updates['moving_time'],
                                                'h'     =>  $vehicle_daily_updates['halt_time'],
                                                's'     =>  $vehicle_daily_updates['sleep_time']
                                            ], $maximum_allowed_time_in_hours);

        // workaround for stop durations
        $stop_time_parts                =   explode(':', $vehicle_daily_updates['stop_time']);
        if( $stop_time_parts[0] >  $maximum_allowed_time_in_hours)
        {
            $stop_time                  =   $maximum_allowed_time_in_hours.':'.$stop_time_parts[1].':'.$stop_time_parts[2];
        }
        else
        {
            $stop_time                  =   $vehicle_daily_updates['stop_time'];
        }

        $alerts                         =   (new Alert())->getAlertsDetailsForVehicleReport($single_vehicle_gps_ids,$from_date,$to_date);        
        $route_deviation                =   (new RouteDeviation())->getCountOfRouteDeviatingRecords($vehicle_id,$client_id,$from_date,$to_date);
        $vehicle_profile                =   array();
        $vehicle_profile                =   array(
                                                'engine_on_duration'        =>  $vehicle_daily_updates['ignition_on_time'],
                                                'engine_off_duration'       =>  $vehicle_daily_updates['ignition_off_time'],
                                                'sum_of_ignition_durations' => $sum_of_ignition_durations, // debug purpose
                                                'maximum_allowed_time_in_hours' => $maximum_allowed_time_in_hours, // debug purpose
                                                'engine_on_duration1'       =>  $vehicle_daily_updates['ignition_on_time'], // debug purpose
                                                'engine_off_duration1'      =>  $vehicle_daily_updates['ignition_off_time'], // debug purpose
                                                'ac_on_duration'            =>  $vehicle_daily_updates['ac_on_time'],
                                                'ac_off_duration'           =>  $vehicle_daily_updates['ac_off_time'],
                                                'ac_halt_on_duration'       =>  $vehicle_daily_updates['ac_on_idle_time'],
                                                'sleep'                     =>  $vehicle_status_durations['s'],  
                                                'motion'                    =>  $vehicle_status_durations['m'], 
                                                'halt'                      =>  $vehicle_status_durations['h'], 
                                                'vehicle_status_durations_old' => [ 
                                                    'sleep'                  => $vehicle_daily_updates['sleep_time'],
                                                    'motion'                 => $vehicle_daily_updates['moving_time'],
                                                    'halt'                   => $vehicle_daily_updates['halt_time']
                                                ] , // debug purpose
                                                'stop_duration'             =>  $stop_time,
                                                'stop_duration_old'         =>  $vehicle_daily_updates['stop_time'], // debug purpose
                                                'sudden_acceleration'       =>  $alerts->where('alert_type_id',2)->count(), 
                                                'harsh_braking'             =>  $alerts->where('alert_type_id',1)->count(),               
                                                'main_battery_disconnect'   =>  $alerts->where('alert_type_id',11)->count(),               
                                                'accident_impact'           =>  $alerts->where('alert_type_id',14)->count(),  
                                                'zig_zag'                   =>  $alerts->where('alert_type_id',3)->count(), 
                                                'over_speed'                =>  $alerts->where('alert_type_id',12)->count(),  
                                                'user_alert'                =>  $alerts->count(),
                                                'geofence_entry'            =>  $alerts->where('alert_type_id',5)->count(),
                                                'geofence_exit'             =>  $alerts->where('alert_type_id',6)->count(),
                                                'geofence_entry_overspeed'  =>  $alerts->where('alert_type_id',15)->count(),
                                                'geofence_exit_overspeed'   =>  $alerts->where('alert_type_id',16)->count(),
                                                'route_deviation'           =>  $route_deviation,    
                                                'dailykm'                   =>  strval($total_km),          
                                                'status'                    =>  'kmReport'           
                                            );
        return $vehicle_profile;

    }
     /**
     * 
     * 
     */
    public function calculateSumOfDurations($durations = [])
    {
        $seconds        =   0;
        foreach($durations as $duration)
        {
          list($hour,$minute,$second) = explode(':', $duration);
          $seconds += (($hour * 3600) + ($minute * 60) + $second);
        }
        $hours          =   floor($seconds / 3600);
        $seconds        -=  $hours*3600;
        $minutes        =   floor($seconds / 60);
        $seconds        -=  $minutes*60;
        // return
        return ['hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds];
    }
    /**
     * 
     * 
     */
    public function calculateDifferenceOfDurations($time1, $time2)
    {
        // $start          =   new DateTime($time1);
        // $end            =   new DateTime($time2);
        // $interval       =   $start->diff($end);
        // return $interval->format('%H:%I:%S'); 
        $start      = strtotime($time1);
        $end        = strtotime($time2);
        $diff       = abs($end - $start) / 3600;
        return gmdate("H:i:s", $diff);
    }

    /**
     * 
     * 
     */
    public function calculateDeviationFromMaximumAllowedDuration($time, $maximum_allowed_time_in_hours)
    {
        $time_parts   = explode(':', $time);     
        return ($maximum_allowed_time_in_hours - $time_parts[0]).':'.(60 - $time_parts[1]).':'.(60 - $time_parts[2]);
    }

    /**
     * 
     * 
     */
    public function maskVehicleStatusDurationOverflow($durations = [], $maximum_allowed_time_in_hours)
    {
        asort($durations);
        $maximum_allowed_time_in_hours  =    $maximum_allowed_time_in_hours.':59:59';
        $sum_of_durations               =    '00:00:00';
        foreach($durations as $key => $duration)
        {
            $sum_of_iteration           =   $this->calculateSumOfDurations([$sum_of_durations, $durations[$key]]);
            if( $sum_of_iteration['hours'] <= explode(':', $maximum_allowed_time_in_hours)[0] )
            {
                // do nothing;
            }
            else
            {
                // corrected durations = max allowed time - sum of iterations
                $durations[$key]        =   $this->calculateDifferenceOfDurations($maximum_allowed_time_in_hours, $sum_of_durations);
                $sum_of_iteration       =   $this->calculateSumOfDurations([
                    $sum_of_durations, 
                    $durations[$key]
                ]);
            }
            $sum_of_durations           =   $sum_of_iteration['hours'].':'.$sum_of_iteration['minutes'].':'.$sum_of_iteration['seconds'];
        }
        return $durations;
    }

    /**
     * 
     * 
     * 
     */
    public function vehicleTotalKilometres($from_date, $to_date, $gps_ids)
    {
        $total_km_in_meter          =   (new DailyKm())->vehicleTotalKilometres($from_date, $to_date, $gps_ids);
        //convert meter to kilometer
        $total_km_in_kilometer      =   round($total_km_in_meter)/1000;
        return round($total_km_in_kilometer);
    }
    /**
     * 
     * 
     * 
     */
    public function vehicleGps($vehicle_id){       
       
        $vehicle_details    =   Vehicle::select('id','gps_id')
                                        ->where('id',$vehicle_id)
                                        ->withTrashed()
                                        ->first();
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