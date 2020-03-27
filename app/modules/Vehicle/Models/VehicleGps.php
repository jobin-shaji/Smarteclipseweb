<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleGps extends Model
{
    public function getGpsDetailsBasedOnVehicle($vehicle_id)
    {
      return self::select('id','vehicle_id','gps_id')
                  ->where('vehicle_id',$vehicle_id)
                  ->get();
    }
}
