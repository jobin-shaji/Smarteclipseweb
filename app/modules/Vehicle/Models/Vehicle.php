<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vehicle extends Model
{
    use SoftDeletes;

    // vehicle fillable data
	protected $fillable = [
        'name','register_number','gps_id','driver_id', 'vehicle_type_id', 'e_sim_number','status','client_id','servicer_job_id','engine_number','chassis_number','model_id'
    ];

    // vehicle type of vehicle
    public function vehicleType(){
    return $this->hasOne('App\Modules\Vehicle\Models\VehicleType','id','vehicle_type_id');
    }

    // driver
    public function driver(){
        return $this->hasOne('App\Modules\Driver\Models\Driver','id','driver_id')->withTrashed();
    }

    // client
    public function client(){
        return $this->hasOne('App\Modules\Client\Models\Client','id','client_id');
    }

    public function vehicleRoute()
    {
        return $this->hasMany('App\Modules\Vehicle\Models\VehicleRoute','vehicle_id','id');
    }
    public function gps(){
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
     
     public function vehicleModels()
     {
      return $this->hasOne('App\Modules\Operations\Models\VehicleModels','id','model_id');
     }

     public function servicerjob()
     {
      return $this->hasOne('App\Modules\Servicer\Models\ServicerJob','id','servicer_job_id');
     }

    public function jobs()
    {
      return $this->hasMany('App\Modules\Servicer\Models\ServicerJob', 'gps_id', 'gps_id');
    }  

    public function alerts()
    {
      return $this->hasMany('App\Modules\Alert\Models\Alert', 'gps_id', 'gps_id'); 
    }
    
    /**
     * 
    * 
    */
    public function getVehicleList()
    {
        return self::select(
            'id',
            'name',
            'servicer_job_id',
            'client_id',
            'gps_id')
        ->with('gps')
        ->with('servicerjob')
        ->with('client')
        ->paginate(10);
    }

    /**
     * 
     * 
     */
    public function getVehicleDetails($vehicle_id)
    {
      return self::select(
            'id',
            'name',
            'vehicle_type_id',
            'model_id',
            'client_id',
            'driver_id',
            'status',
            'engine_number',
            'chassis_number',
            'theft_mode',
            'towing',
            'emergency_status',
            'created_at',
            'servicer_job_id',
            'gps_id',
            'register_number')
        ->with('gps')
        ->with('vehicleType')
        ->with('vehicleModels.vehicleMake')
        ->with('jobs', 'jobs.servicer')
        ->with('client.state')
        ->with('client.country')
        ->with('client.city')
        ->with('client.subdealer')
        ->with('driver')
        ->with('alerts','alerts.alertType')
        ->where('id',$vehicle_id)->first();
    }
    
}
