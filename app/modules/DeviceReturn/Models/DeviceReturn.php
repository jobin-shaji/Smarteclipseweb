<?php

namespace App\Modules\DeviceReturn\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceReturn extends Model
{
  protected $fillable=[
		'id','gps_id','servicer_id','type_of_issues','comments','created_at','updated_at','deleted_at'
	];

	public function gps()
	{
  	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
	}

}

