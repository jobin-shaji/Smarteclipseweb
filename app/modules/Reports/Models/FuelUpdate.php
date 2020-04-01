<?php

namespace App\Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;

class FuelUpdate extends Model
{
	// gps 
    public function gps(){
    	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }

    public function vehicleGps(){
		return $this->hasOne('App\Modules\Vehicle\Models\VehicleGps','gps_id','gps_id');
	}

    public function getFuelDetailsForReport($gps_ids)
    {
        return self::select(
            'id',
            'gps_id',
            'percentage',
            'created_at'
        )
        ->whereIn('gps_id', $gps_ids)
        ->orderBy('created_at', 'ASC')
        ->with('vehicleGps.vehicle');
    }
}
