<?php

namespace App\Modules\Geofence\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Geofence extends Model
{
	use SoftDeletes;    

	protected $fillable=[
		'user_id','cordinates','fence_type_id'
	];

	protected $casts = [
        'cordinates' => 'array'
    ];
	
}
