<?php

namespace App\Modules\Alert\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
	protected $fillable=[
		'alert_type_id','device_time','vehicle_id','gps_id','client_id','latitude','longitude','status'
	];
	public function vehicle(){
	 return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','gps_id')->withTrashed();
	}

	public function clientAlertPoint(){
	 	return $this->hasOne('App\Modules\Client\Models\ClientAlertPoint','alert_type_id','alert_type_id')->where('client_id',\Auth::user()->client->id);
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

	public function vehicleGps(){
		return $this->hasOne('App\Modules\Vehicle\Models\VehicleGps','gps_id','gps_id');
	}

	public function getGeofenceAlerts($gps_ids)
	{
		return 	self::select(          
					'id',
					'alert_type_id',
					'device_time',   
					'gps_id',
					'latitude',
					'longitude',
					'status'
				)
				->with('alertType:id,description')
				->with('vehicleGps.vehicle')
				->whereIn('gps_id',$gps_ids)
				->whereIn('alert_type_id',[5,6])
				->orderBy('device_time', 'DESC')
				->limit(1000);  
	}

	public function getOverspeedAlerts($gps_ids)
	{
		return 	self::select(          
					'id',
					'alert_type_id',
					'device_time',   
					'gps_id',
					'latitude',
					'longitude',
					'status'
				)
				->with('alertType:id,description')
				->with('vehicleGps.vehicle')
				->whereIn('gps_id',$gps_ids)
				->where('alert_type_id',12)
				->orderBy('device_time', 'DESC')
				->limit(1000);  
	}

	public function getSuddenAccelerationAlerts($gps_ids)
	{
		return 	self::select(          
					'id',
					'alert_type_id',
					'device_time',   
					'gps_id',
					'latitude',
					'longitude',
					'status'
				)
				->with('alertType:id,description')
				->with('vehicleGps.vehicle')
				->whereIn('gps_id',$gps_ids)
				->where('alert_type_id',2)
				->orderBy('device_time', 'DESC')
				->limit(1000);  
	}

	public function getAccidentImpactAlerts($gps_ids)
	{
		return 	self::select(          
					'id',
					'alert_type_id',
					'device_time',   
					'gps_id',
					'latitude',
					'longitude',
					'status'
				)
				->with('alertType:id,description')
				->with('vehicleGps.vehicle')
				->whereIn('gps_id',$gps_ids)
				->where('alert_type_id',14)
				->orderBy('device_time', 'DESC')
				->limit(1000);  
	}

	public function getMainBatteryDisconnectAlerts($gps_ids)
	{
		return 	self::select(          
					'id',
					'alert_type_id',
					'device_time',   
					'gps_id',
					'latitude',
					'longitude',
					'status'
				)
				->with('alertType:id,description')
				->with('vehicleGps.vehicle')
				->whereIn('gps_id',$gps_ids)
				->where('alert_type_id',11)
				->orderBy('device_time', 'DESC')
				->limit(1000);  
	}

	public function getRashTurningAlerts($gps_ids)
	{
		return 	self::select(          
					'id',
					'alert_type_id',
					'device_time',   
					'gps_id',
					'latitude',
					'longitude',
					'status'
				)
				->with('alertType:id,description')
				->with('vehicleGps.vehicle')
				->whereIn('gps_id',$gps_ids)
				->where('alert_type_id',3)
				->orderBy('device_time', 'DESC')
				->limit(1000);  
	}

	public function getAlertsDetailsForVehicleReport($single_vehicle_gps_ids,$from_date,$to_date)
	{
		return 	self::select(
					'id',
					'alert_type_id', 
					'device_time',    
					'gps_id', 
					'latitude',
					'longitude', 
					'status'
				)
				->whereIn('gps_id',$single_vehicle_gps_ids)
				->whereNotIn('alert_type_id',[17,18,23,24])
				->whereDate('device_time', '>=', $from_date)
				->whereDate('device_time', '<=', $to_date)
				->get(); 
	}

	public function getHarshBreakingAlerts($gps_ids)
	{
		return 	self::select(          
					'id',
					'alert_type_id',
					'device_time',   
					'gps_id',
					'latitude',
					'longitude',
					'status'
				)
				->with('alertType:id,description')
				->with('vehicleGps.vehicle')
				->whereIn('gps_id',$gps_ids)
				->where('alert_type_id',1)
				->orderBy('device_time', 'DESC')
				->limit(1000);  
	}

}
