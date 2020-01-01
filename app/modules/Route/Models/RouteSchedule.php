<?php

namespace App\Modules\Route\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RouteSchedule extends Model
{
    use SoftDeletes;

    // route fillable data
	protected $fillable = [
        'route_batch_id','route_id','vehicle_id','driver_id','helper_id','client_id'
    ];

    // route batch
    public function routeBatch(){
        return $this->hasOne('App\Modules\RouteBatch\Models\RouteBatch','id','route_batch_id');
    }

    // route
    public function route(){
        return $this->hasOne('App\Modules\Route\Models\Route','id','route_id');
    }

    // vehicle
    public function vehicle(){
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id');
    }

    // driver
    public function driver(){
        return $this->hasOne('App\Modules\Driver\Models\Driver','id','driver_id');
    }

    // helper
    public function helper(){
        return $this->hasOne('App\Modules\BusHelper\Models\BusHelper','id','helper_id');
    }
}
