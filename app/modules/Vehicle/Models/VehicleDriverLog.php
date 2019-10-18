<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDriverLog extends Model
{
	protected $fillable = [
        'vehicle_id','from_driver_id','to_driver_id','client_id'
    ];

    // from driver
    public function Fromdriver(){
        return $this->hasOne('App\Modules\Driver\Models\Driver','id','from_driver_id');
    }

    // to driver
    public function Todriver(){
        return $this->hasOne('App\Modules\Driver\Models\Driver','id','to_driver_id');
    }

    // vehicle
    public function vehicle(){
    	return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id')->withTrashed();
    }
}
