<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vehicle extends Model
{
    use SoftDeletes;

    // vehicle fillable data
	protected $fillable = [
        'name','register_number','gps_id','driver_id', 'vehicle_type_id', 'e_sim_number','status','client_id','servicer_job_id','engine_number','chassis_number'
    ];

    // vehicle type of vehicle
    public function vehicleType(){
    	return $this->hasOne('App\Modules\Vehicle\Models\VehicleType','id','vehicle_type_id');
    }



    // driver
    public function driver(){
        return $this->hasOne('App\Modules\Driver\Models\Driver','id','driver_id');
    }

    // client
    public function client(){
        return $this->hasOne('App\Modules\Client\Models\Client','id','client_id');
    }

    public function vehicleRoute()
    {
        return $this->hasMany('App\Modules\Vehicle\Models\VehicleRoute','vehicle_id','id');
    }
    public function gps(){
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }


}
