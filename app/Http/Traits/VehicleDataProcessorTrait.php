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
        $vehicle_durations          =   VehicleDailyUpdate::select(
                                            \DB::raw('sum(ignition_on) as ignition_on'),
                                            \DB::raw('sum(ignition_off) as ignition_off'),
                                            \DB::raw('sum(moving) as moving'),
                                            \DB::raw('sum(halt) as halt'),
                                            \DB::raw('sum(sleep) as sleep'),
                                            \DB::raw('sum(stop) as stop'),
                                            \DB::raw('sum(ac_on) as ac_on'),
                                            \DB::raw('sum(ac_off) as ac_off'),
                                            \DB::raw('sum(ac_on_idle) as ac_on_idle')
                                        )
                                        ->where('date', '>=', $from_date)
                                        ->where('date', '<=', $to_date)
                                        ->whereIn('gps_id',$gps_ids)
                                        ->first();
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

    public function vehicleProfile($vehicle_id,$date_and_time,$client_id)
    {
        $single_vehicle_gps_ids         =   [];     
        //$single_vehicle_gps_id        =   $this->vehicleGps($vehicle_id);
        $from_date                      =   date('Y-m-d', strtotime($date_and_time['from_date']));
        $to_date                        =   date('Y-m-d', strtotime($date_and_time['to_date']));
        $single_vehicle_gps_ids         =   $this->vehicleGpsBasedOnDate($vehicle_id,$from_date,$to_date);
        $total_km                       =   $this->vehicleTotalKilometres($from_date, $to_date, $single_vehicle_gps_ids);       
        //getting durations from vehicle daily update table
        $vehicle_daily_updates          =   $this->vehicleDailyUpdates($single_vehicle_gps_ids,$from_date,$to_date);
        
        $alerts                         =   (new Alert())->getAlertsDetailsForVehicleReport($single_vehicle_gps_ids,$from_date,$to_date);        
        $route_deviation                =   (new RouteDeviation())->getCountOfRouteDeviatingRecords($vehicle_id,$client_id,$from_date,$to_date);
        $vehicle_profile                =   array();
        $vehicle_profile                =   array(
                                                'engine_on_duration'        =>  $vehicle_daily_updates['ignition_on_time'],
                                                'engine_off_duration'       =>  $vehicle_daily_updates['ignition_off_time'],
                                                'ac_on_duration'            =>  $vehicle_daily_updates['ac_on_time'],
                                                'ac_off_duration'           =>  $vehicle_daily_updates['ac_off_time'],
                                                'ac_halt_on_duration'       =>  $vehicle_daily_updates['ac_on_idle_time'],
                                                'sleep'                     =>  $vehicle_daily_updates['sleep_time'],  
                                                'motion'                    =>  $vehicle_daily_updates['moving_time'],   
                                                'halt'                      =>  $vehicle_daily_updates['halt_time'], 
                                                'stop_duration'             =>  $vehicle_daily_updates['stop_time'], 
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
    public function vehicleGpsBasedOnDate($vehicle_id,$from_date,$to_date)
    {
        $vehicle_gps_ids            =   [];
        $vehicle_gps_details        =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithDates($vehicle_id,$from_date,$to_date);
        //dd(DB::select("SELECT gps_id FROM `vehicle_gps` where vehicle_id=4 and date(gps_fitted_on) >= '2020-03-24' and IF( date(gps_removed_on) IS NULL, date('2020-03-24') - INTERVAL 1 DAY, date(gps_removed_on)) <= '2020-03-24'"));
        return ['5'];
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