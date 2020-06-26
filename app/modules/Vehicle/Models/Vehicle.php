<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    public function gpsStock()
    {
      return $this->hasOne('App\Modules\Warehouse\Models\GpsStock', 'gps_id', 'gps_id'); 
    }
    
    /**
     * 
    * 
    */
    public function getVehicleList($key = null)
    {
        $query = DB::table('vehicles')
        ->join('gps', 'vehicles.gps_id', '=', 'gps.id')
        ->join('clients', 'vehicles.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('servicer_jobs', 'vehicles.servicer_job_id', '=', 'servicer_jobs.id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=', 'servicers.id')
        ->join('gps_stocks','vehicles.gps_id', '=', 'gps_stocks.gps_id')
        ->join('dealers','gps_stocks.dealer_id', '=', 'dealers.id')
        ->join('sub_dealers','gps_stocks.subdealer_id', '=', 'sub_dealers.id')
        ->leftJoin('traders','gps_stocks.trader_id', '=', 'traders.id')
        ->join('users as distributor', 'distributor.id', '=', 'dealers.user_id')
        ->join('users as dealer', 'dealer.id', '=', 'sub_dealers.user_id')
        ->join('users as servicer', 'servicer.id', '=', 'servicers.user_id')
        ->leftJoin('users as trader', 'trader.id', '=', 'traders.user_id')
        ->select('vehicles.name as vehicle_name', 
          'vehicles.id', 'gps.imei', 
          'servicer_jobs.job_complete_date', 
          'clients.name as client_name',
          'users.username as user_name', 
          'users.mobile as mobile_number', 
          'servicers.name as servicer_name',
          'dealers.name as distributor_name', 
          'sub_dealers.name as dealer_name',
          'traders.name as sub_dealer_name',
          'distributor.mobile as distributor_mobile',
          'dealer.mobile as dealer_mobile',
          'trader.mobile as sub_dealer_mobile',
          'servicer.mobile as servicer_mobile'
        );
        // search filters
        if( $key != null )
        {
            $query = $query->where('vehicles.name','like','%'.$key.'%')
                ->orWhere('clients.name','like','%'.$key.'%')
                ->orWhere('gps.imei','like','%'.$key.'%')
                ->orWhere('dealers.name','like','%'.$key.'%')
                ->orWhere('sub_dealers.name','like','%'.$key.'%')
                ->orWhere('servicers.name','like','%'.$key.'%')
                ->orWhere('users.mobile','like','%'.$key.'%');
        }
       // dd($query->toSql());
        // response
        return $query->orderBy('servicer_jobs.job_complete_date', 'desc')->paginate(10);
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
        ->with(['gps.ota' => function($q){
          return $q->orderBy('device_time', 'desc');
        }])
        ->with('vehicleType')
        ->with('vehicleModels.vehicleMake')
        ->with('jobs', 'jobs.servicer')
        ->with('client.state')
        ->with('client.country')
        ->with('client.user')
        ->with('client.city')
        ->with('client.subdealer')
        ->with('driver')
        ->with('gpsStock','gpsStock.subdealer')
        ->with('alerts','alerts.alertType')
        ->with(['alerts' => function($q){
          return $q->orderBy('alerts.device_time', 'desc');
        }])
        ->where('id',$vehicle_id)->first();
    }
    public function getAlertList()
    {
      $query = DB::table('vehicles')
        ->join('gps', 'vehicles.gps_id', '=', 'gps.id')
        ->join('alerts', 'vehicles.gps_id', '=', 'alerts.gps_id')
        ->join('alert_types', 'alerts.alert_type_id', '=', 'alert_types.id')
        ->select('alert_types.description as alert',
                  'vehicles.name as vehicle_name',
                  'vehicles.register_number as register_number',
                  'gps.imei as imei',
                  'alerts.latitude as lat',
                  'alerts.longitude as lon',
                  'alerts.created_at as date'
          );
        
        // response
        return $query->orderBy('alerts.created_at', 'desc')->paginate(10);
    }

    public function getSingleVehicleDetailsBasedOnGps($gps_id)
    {
        return self::where('gps_id',$gps_id)
                    ->with('driver')
                    ->with('vehicleType:id,name')
                    ->with('vehicleModels')
                    ->with('vehicleModels.vehicleMake')
                    ->withTrashed()
                    ->first();
    }

    //get vehicle list based on client
    public function getVehicleListBasedOnClient($client_id)
    {
      return self::select(
                      'id',
                      'name',
                      'register_number',
                      'gps_id',
                      'client_id',
                      'driver_id',
                      'vehicle_type_id',
                      'deleted_at',
                      'is_returned'
                      )
                    ->withTrashed()
                    ->where('client_id',$client_id)
                    ->with('vehicleType:id,name')
                    ->with('driver:id,name')
                    ->with('gps:id,imei,serial_no')
                    ->get();
    }

    public function getSingleVehicleDetailsBasedOnVehicleId($vehicle_id)
    {
      return self::where('id',$vehicle_id)
                  ->withTrashed()
                  ->first();
    }

    public function getChoosedVehicleForReinstallation($vehicle_id)
    {
      return self::select('id','is_returned','is_reinstallation_job_created')
                  ->where('id',$vehicle_id)
                  ->where('is_returned',1)
                  ->where('is_reinstallation_job_created',0)
                  ->first();
    }

    public function getReturnedGpsVehiclesUnderClient($client_id)
    {
      return self::where('client_id',$client_id)
                  ->where('is_returned',1)
                  ->get();
    }

    public function getReinstallationNeededVehiclesBasedOnClient($client_id)
    {
      return self::select('id','name','register_number','client_id','is_returned','is_reinstallation_job_created')
                  ->where('client_id',$client_id)
                  ->where('is_returned',1)
                  ->where('is_reinstallation_job_created',0)
                  ->get();
    }

    public function checkAlreadytJobCreatedForVehicle($vehicle_id)
    {
      return self::where('id',$vehicle_id)
                  ->where('is_returned',1)
                  ->where('is_reinstallation_job_created',1)
                  ->count();
    }

    public function getNonReturnedDeviceVehiclesOfClient($client_id,$device_returned_with_submitted_status)
    {
      return self::where('client_id',$client_id)
                  ->with('gps')
                  ->where(function ($query) {
                    $query->where('is_returned', '=', 0)
                    ->orWhere('is_returned', '=', NULL);
                    })
                  ->where(function ($query) {
                    $query->where('is_reinstallation_job_created', '=', 0)
                    ->orWhere('is_reinstallation_job_created', '=', NULL);
                    })
                  ->whereNotIn('gps_id',$device_returned_with_submitted_status)
                  ->get();
    }

    public function checkVehicleIsNotReturnedOrReassigned($gps_id)
    {
      //check vehicle reassigned or returned
      $is_vehicle_exists      =   self::select('id')
                                        ->where('gps_id',$gps_id)
                                        ->where(function ($query) {
                                          $query->where('is_returned', '=', 0)
                                          ->orWhere('is_returned', '=', NULL);
                                          })->count();
      return $is_vehicle_exists;
    }
    /**
     * 
     */
    public function getVehiclesOfSelectedClient($client_id)
    {
      return self::select('id','name','register_number','client_id')
                  ->withTrashed()
                  ->where('client_id',$client_id)
                  ->get();
    }
    /**
     * 
     */
    public function getAllVehiclesOfAllClients()
    {
      return self::select('id','name','register_number','client_id')
                  ->withTrashed()
                  ->get();
    }

    /**
     * 
     * 
     */
    public function getAllVehiclesWithUnreturnedGps()
    {
      return self::where(function ($query) {
                      $query->where('is_returned', '=', 0)
                      ->orWhere('is_returned', '=', NULL);
                  })
                  ->pluck('gps_id');
    }

    /**
     * 
     * 
     */
    public function getClientIdOfVehicle($gps_id)
    {
      return self::select('client_id')->where('gps_id', $gps_id)->first();
    }
}
