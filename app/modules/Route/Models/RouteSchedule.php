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
}
