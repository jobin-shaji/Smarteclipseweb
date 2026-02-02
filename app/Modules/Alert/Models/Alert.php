<?php

namespace App\Modules\Alert\Models;
use DateTime;
use Carbon\Carbon; 
use DB;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
	protected $fillable=[
		'alert_type_id','device_time','gps_id','latitude','longitude','status'
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
	 return $this->belongsTo(AlertType::class, 'alert_type_id');
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

	public function getAlertByBetweenDatetime($gps_id,$start_date)
    {

       
       return  self::where('gps_id',$gps_id)
                ->where('device_time','>=',new DateTime($start_date))
               // ->where('device_time','<=',new DateTime($request->end_date))
                ->get()  ;   
            
    }

	public function getAlertReport($request,$gps_id)
    {
        $per_page   = ( $request->limit ) ? $request->limit  : 10;
        $alert      = self::with(['vehicle','alertType'])->where('gps_id',$gps_id);
        if((isset($request->vehicle_id)) && (!empty($request->vehicle_id)))
        {
           // $alert      =  $alert->where('vehicle_id',$request->vehicle_id);
		   // $alert      = self::where('gps_id',$gps_id);
        }
        if((isset($request->alert_type)) && (!empty($request->alert_type)) && ($request->alert_type != 'all'))
        {
            
            if(is_array($request->alert_type))
            {
                $alert      =  $alert->whereIn('alert_type.code',$request->alert_type);
            }else
            {
                $alert      =  $alert->where('alert_type.code',$request->alert_type);
            }
        }
       
        if((isset($request->start_date)) && (!empty($request->start_date)))
        {
            $alert      =  $alert->where('device_time','>=',new DateTime($request->start_date.' 00:00:00'));
           
        }
        if((isset($request->end_date)) && (!empty($request->end_date)))
        {
            $alert      =  $alert->where('device_time','<=',new DateTime($request->end_date.' 23:59:59'));
           
        }
        $result      = $alert->orderByDesc('device_time')->paginate($per_page);
        $result->withPath(url("/").'/alert-report');
        return [ 'alerts'       => $result->items() ,
                'total_pages'   => (int)ceil($result->total()/$result->perPage()),
                'per_page'      => $per_page,
                'link'          => (string)$result->render(),
                'page'          => ( $request->page ) ? $request->page : 1,
        
        ];
    }

}
