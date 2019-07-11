<?php


namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleGeofence extends Model
{
   use SoftDeletes;

	// vehicle geofence fillable data
	protected $fillable = [
        'vehicle_id','geofence_id','date_from', 'date_to', 'status','client_id'
    ];

    public function vehicle(){
	 return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id')->withTrashed();
	}
	 public function vehicleGeofence(){
	 return $this->hasOne('App\Modules\Geofence\Models\Geofence','id','geofence_id')->withTrashed();
	}
}
