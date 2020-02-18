<?php

namespace App\Modules\Operations\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class VehicleModels extends Model
{
    use SoftDeletes;
	protected $fillable=[
		'name','vehicle_make_id','fuel_min','fuel_25','fuel_50','fuel_75','fuel_max'
	];
	public function vehicleMake()
  	{
    	return $this->hasOne('App\Modules\Operations\Models\VehicleMake','id','vehicle_make_id');
  	}
}
