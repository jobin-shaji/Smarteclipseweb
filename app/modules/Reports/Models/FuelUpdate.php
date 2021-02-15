<?php

namespace App\Modules\Reports\Models;
use Illuminate\Support\Facades\DB;

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
     public function kmUpdate(){
        // return $this->hasMany('App\Modules\Vehicle\Models\KmUpdate','gps_id','gps_id');
         return $this->hasMany('App\Modules\Vehicle\Models\KmUpdate','gps_id','gps_id');
      // ->whereIn('alert_type_id',[1,12,13,14,15,16]);
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
        // ->where('created_at', $date)      
        ->orderBy('created_at', 'ASC')
        ->with('kmUpdate:gps_id,km,device_time')
        ->with('vehicleGps.vehicle');
    }
    public function getkmFuelDetailsForReport($gps_ids,$date)
    {
     return $query= DB::table('fuel_updates')
        ->join('km_updates', function ($join) {
            $join->on('fuel_updates.gps_id', '=', 'km_updates.gps_id')
                 ->on('km_updates.device_time','=', 'fuel_updates.created_at');
        })
        // ->select('fuel_updates.gps_id','fuel_updates.created_at','fuel_updates.percentage','km_updates.km as km')      
        ->whereIn('fuel_updates.gps_id', $gps_ids)
        ->whereDate('fuel_updates.created_at', $date)
        ->get();
       
    }

}
