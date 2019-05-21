<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleRoute extends Model
{
	use SoftDeletes;

	// vehicle route fillable data
	protected $fillable = [
        'vehicle_id','route_id','date_from', 'date_to', 'status','client_id'
    ];
    
    // route
    public function route(){
    	return $this->hasOne('App\Modules\Route\Models\Route','id','route_id');
    }
}
