<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vehicle extends Model
{
    use SoftDeletes;

   // vehicle fillable data
	protected $fillable = [
        'register_number', 'vehicle_type_id', 'vehicle_occupancy','speed_limit','depot_id','status','state_id'
    ];

    // vehicle type of vehicle
    public function vehicleType(){
    	return $this->hasOne('App\Modules\Vehicle\Models\VehicleType','id','vehicle_type_id');
    }
    
    // depot of vehicle
    public function vehicleDepot(){
    	return $this->hasOne('App\Modules\Depot\Models\Depot','id','depot_id');
    }
}
