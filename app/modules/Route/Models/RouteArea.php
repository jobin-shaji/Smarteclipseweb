<?php

namespace App\Modules\Route\Models;

use Illuminate\Database\Eloquent\Model;

class RouteArea extends Model
{
    // route fillable data
	protected $fillable = [
        'route_id','latitude','longitude'
    ];
}
