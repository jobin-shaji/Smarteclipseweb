<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleOta extends Model
{
    // vehicle fillable data
	protected $fillable = [
        'client_id','vehicle_id','PU', 'EU', 'EM','EO','ED','APN','ST','SL','HBT','HAT','RTT','LBT','VN','UR','URS','URE','URF','URH','VID','FV','DSL','HT','M1','M2','M3','GF','OM','OU'
    ];

    // vehicle 
    public function vehicle(){
    	return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id');
    }
}
