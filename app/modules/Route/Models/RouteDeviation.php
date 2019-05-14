<?php

namespace App\Modules\Route\Models;

use Illuminate\Database\Eloquent\Model;

class RouteDeviation extends Model
{
    public function vehicle(){
    	return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id');
    }

    public function route(){
    	return $this->hasOne('App\Modules\Route\Models\Route','id','route_id');
    }
    
}
