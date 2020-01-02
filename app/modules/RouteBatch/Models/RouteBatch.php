<?php

namespace App\Modules\RouteBatch\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RouteBatch extends Model
{
    use SoftDeletes; 

    protected $fillable=[
		'name','route_id','client_id'
	]; 

	// route
    public function route(){
    	return $this->hasOne('App\Modules\Route\Models\Route','id','route_id');
    }
}
