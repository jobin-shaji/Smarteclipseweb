<?php

namespace App\Modules\DeviceReturn\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeviceReturn extends Model
{
	use SoftDeletes;    
  protected $fillable=[
		'id','gps_id','servicer_id','type_of_issues','status','comments','created_at','updated_at','deleted_at'
	];

	public function gps()
	{
  	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
	}
    public function servicer()
	{
  	return $this->hasOne('App\Modules\Servicer\Models\Servicer','id','servicer_id');
	}
    
}

