<?php

namespace App\Modules\Route\Models;

use Illuminate\Database\Eloquent\Model;

class RouteDeviation extends Model
{
    public function vehicle()
    {
    	return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id')->withTrashed();
    }

    public function route()
    {
    	return $this->hasOne('App\Modules\Route\Models\Route','id','route_id');
    }

    public function getCountOfRouteDeviatingRecords($vehicle_id,$client_id,$from_date,$to_date)
    {
        return self::select(
                        'id',
                        'vehicle_id', 
                        'deviating_time'
                    )
                    ->where('vehicle_id',$vehicle_id)       
                    ->where('client_id',$client_id)
                    ->whereDate('deviating_time', '>=', $from_date)
                    ->whereDate('deviating_time', '<=', $to_date)
                    ->count();
    }
    
}
