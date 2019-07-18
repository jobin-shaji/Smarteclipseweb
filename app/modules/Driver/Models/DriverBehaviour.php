<?php

namespace App\Modules\Driver\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class DriverBehaviour extends Model
{
     use SoftDeletes;    
	protected $fillable=[
		'vehicle_id','driver_id','gps_id','alert_id','points','deleted_at'
	];
	public function vehicle(){
	 return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id')->withTrashed();
	}

	public function gps(){
	  return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id')->withTrashed();
	}

	public function client(){
	  return $this->hasOne('App\Modules\Client\Models\Client','id','client_id');
	}

	public function alert(){
	  return $this->hasOne('App\Modules\Alert\Models\Alert','id','alert_id');
	}
	public function driver(){
	  return $this->hasOne('App\Modules\Driver\Models\Driver','id','driver_id');
	}
}
