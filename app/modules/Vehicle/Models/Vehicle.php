<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vehicle extends Model
{
    use SoftDeletes;

   // vehicle fillable data
	protected $fillable = [
        'name','register_number','gps_id', 'vehicle_type_id', 'e_sim_number','status','client_id'
    ];

    // vehicle type of vehicle
    public function vehicleType(){
    	return $this->hasOne('App\Modules\Vehicle\Models\VehicleType','id','vehicle_type_id');
    }
    
    // gps
    public function gps(){
    	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }

    // client
    public function client(){
        return $this->hasOne('App\Modules\Client\Models\Client','id','client_id');
    }
}
