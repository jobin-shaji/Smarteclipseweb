<?php

namespace App\Modules\Route\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use SoftDeletes;

    // route fillable data
	protected $fillable = [
        'name','client_id'
    ];

    public function routeArea()
    {
        return $this->hasMany('App\Modules\Route\Models\RouteArea','id','route_id');
    }
}
