<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleGps extends Model
{
    public function getGpsDetailsBasedOnVehicle($vehicle_id)
    {
      return self::where('vehicle_id',$vehicle_id)->get();
    }

    public function getGpsDetailsBasedOnVehicleWithDates($vehicle_id,$from_date,$to_date)
    {
      return self::select("SELECT gps_id FROM `vehicle_gps` where vehicle_id =:vehicle_id and 
      date(gps_fitted_on) >=:from_date and IF( date(gps_removed_on) IS NULL,
       date('to_date'), date(gps_removed_on)) <=:to_date",['from_date' => $from_date,'to_date' => $to_date,'vehicle_id' => $vehicle_id]);
    }

    public function getGpsDetailsBasedOnVehiclesWithDates($vehicle_ids,$from_date,$to_date)
    {
      return self::select("SELECT gps_id FROM `vehicle_gps` where vehicle_id =:vehicle_id and 
      date(gps_fitted_on) >=:from_date and IF( date(gps_removed_on) IS NULL,
       date('to_date'), date(gps_removed_on)) <=:to_date",['from_date' => $from_date,'to_date' => $to_date,'vehicle_id' => $vehicle_ids]);
    }

    public function getGpsDetailsBasedOnVehicleWithSingleDate($vehicle_id,$search_date)
    {

    }

    public function getGpsDetailsBasedOnVehiclesWithSingleDate($vehicle_id,$search_date)
    {
      
    }
}
