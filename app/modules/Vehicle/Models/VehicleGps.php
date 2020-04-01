<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class VehicleGps extends Model
{

    public function vehicle()
    {
      return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id')->withTrashed();
    }

    public function getGpsDetailsBasedOnVehicle($vehicle_id)
    {
      return self::where('vehicle_id',$vehicle_id)->get();
    }

    public function getGpsDetailsBasedOnVehicleWithDates($vehicle_id,$from_date,$to_date)
    {
      return DB::select("SELECT gps_id
      FROM `vehicle_gps`
      WHERE vehicle_id = '$vehicle_id' AND
      (
        ( '$from_date' BETWEEN IF(date(gps_fitted_on) > '$from_date', '$from_date', date(gps_fitted_on)) AND date(gps_removed_on) )
          OR
          ( '$to_date' BETWEEN date(gps_fitted_on) AND IF(date(gps_removed_on) IS NULL, CURDATE(), date(gps_removed_on)) )
      )");
    }

    public function getGpsDetailsBasedOnVehiclesWithDates($vehicle_ids,$from_date,$to_date)
    {
      $vehicle_ids  = implode(',',$vehicle_ids);
      return DB::select("SELECT gps_id
      FROM `vehicle_gps`
      WHERE vehicle_id IN ('$vehicle_ids') AND
      (
        ( '$from_date' BETWEEN IF(date(gps_fitted_on) > '$from_date', '$from_date', date(gps_fitted_on)) AND date(gps_removed_on) )
          OR
          ( '$to_date' BETWEEN date(gps_fitted_on) AND IF(date(gps_removed_on) IS NULL, CURDATE(), date(gps_removed_on)) )
      )");
    }

    public function getGpsDetailsBasedOnVehicleWithSingleDate($vehicle_id,$search_date)
    {
      return DB::select("SELECT gps_id
      FROM `vehicle_gps`
      WHERE vehicle_id = '$vehicle_id' AND
      (
        ( '$search_date' BETWEEN IF(date(gps_fitted_on) > '$search_date', '$search_date', date(gps_fitted_on)) AND date(gps_removed_on) )
          OR
          ( '$search_date' BETWEEN date(gps_fitted_on) AND IF(date(gps_removed_on) IS NULL, CURDATE(), date(gps_removed_on)) )
      )");
    }

    public function getGpsDetailsBasedOnVehiclesWithSingleDate($vehicle_ids,$search_date)
    {
      $vehicle_ids  = implode(',',$vehicle_ids);
      return DB::select("SELECT gps_id
      FROM `vehicle_gps`
      WHERE vehicle_id IN ('$vehicle_ids') AND
      (
        ( '$search_date' BETWEEN IF(date(gps_fitted_on) > '$search_date', '$search_date', date(gps_fitted_on)) AND date(gps_removed_on) )
          OR
          ( '$search_date' BETWEEN date(gps_fitted_on) AND IF(date(gps_removed_on) IS NULL, CURDATE(), date(gps_removed_on)) )
      )");
    }

    public function getGpsDetailsBasedOnVehicleWithMonth($vehicle_id,$search_date)
    {
    
    }

    public function getYearAndMonthBasedOnVehicleId($vehicle_id)
    {
      return DB::select("SELECT gps_id, extract( YEAR_MONTH FROM gps_fitted_on) as gps_fitted_on, extract( YEAR_MONTH FROM IF (gps_removed_on IS NULL, CURDATE() , gps_removed_on)) as gps_removed_on
      FROM vehicle_gps WHERE vehicle_id = '$vehicle_id'");
    }
}
