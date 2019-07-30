<?php

namespace App\Modules\Alert\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
	protected $fillable=[
		'alert_type_id','device_time','vehicle_id','gps_id','client_id','latitude','longitude','status'
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

	public function alertType(){
	  return $this->hasOne('App\Modules\Alert\Models\AlertType','id','alert_type_id');
	}

}
