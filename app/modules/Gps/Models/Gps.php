<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use App\Scopes\DeleteScope;

class Gps extends Model
{  
    use SoftDeletes;
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    // protected $encryptable = [
    //     'code',
    //     'keys',
    //     'allergies'
    // ];

    protected $fillable=[ 'serial_no','icc_id','imsi','imei','manufacturing_date','e_sim_number','batch_number','model_name','version','user_id','status','device_time','employee_code','refurbished_status'];

    public function vehicleGps()
    {
        return $this->hasOne('App\Modules\Vehicle\Models\VehicleGps');
    }
    
    /**
     * 
     * 
     * 
     */
    public function getEimeiAttribute() 
    {  
        return Crypt::encrypt($this->imei);
    }

    //join user table with gps table
    public function user()
    {
        return $this->belongsTo('App\Modules\User\Models\User','user_id');
    }

    public function transfers()
    {
        return $this->hasMany('App\Modules\Gps\Models\GpsTransfer');
    }


    public function gpsdata()
    {
        return $this->hasMany('App\Modules\Gps\Models\GpsData','gps_id','id')->orderBy('id', 'desc');
    }

    // vehicle gps
    public function vehicle(){
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','id')->withTrashed();
    }

    public function emergencylogs(){
        return $this->hasOne('App\Modules\Operations\Models\EmergencyLog','gps_id','id')->withTrashed();
    }

    public function employee(){
        return $this->hasOne('App\Modules\Employee\Models\Employee','id','employee_code')->withTrashed();
    }

    public function gpsStock()
    {
        return $this->hasOne('App\Modules\Warehouse\Models\GpsStock','gps_id','id');
    }

    public function ota()
    {
        return $this->hasMany('App\Modules\Ota\Models\OtaUpdates','gps_id','id');
    }
    public function device_return(){
        return $this->hasOne('App\Modules\DeviceReturn\Models\DeviceReturn','gps_id','id')->withTrashed();
    }
    /**
     * 
     * 
     * 
     */

    public function getEmergencyalerts()
    {
        return self::select('emergency_status','tilt_status','id','lat','lon','imei','serial_no','e_sim_number')
                    ->with('vehicle','vehicle.client')
                    ->with('emergencylogs')
                    ->where('emergency_status',1)
                    ->orWhere('tilt_status',1)
                    ->get();
    }

    /**
     *
     *
     *
     */
    public function getTransferredGpsDetails($transferred_gps_device_ids, $search_key = '')
    {
        $query = self::select('imei','serial_no','icc_id','imsi','version','e_sim_number','batch_number','employee_code','model_name','is_returned');
        if($search_key != '')
        {
            $query = $query->where('imei','LIKE','%'.$search_key."%");
        }
        return $query->whereIn('id',$transferred_gps_device_ids)->paginate(10);
    }

    /**
     *
     *
     */
    public function getImeiList()
    {
        return self::select('imei', 'serial_no')->get();
    }
    /**
     *
     *
     */
    public function getGpsId($imei)
    {
        return self::select('id')->where('imei',$imei)->first();
    }
    /**
     *
     *
     *
     */
    public function getGpsDetails($gps_id)
    {
        return self::select(
                    'id',
                    'imei',
                    'serial_no',
                    'manufacturing_date',
                    'icc_id',
                    'imsi',
                    'e_sim_number',
                    'batch_number',
                    'employee_code',
                    'model_name',
                    'version',
                    'is_returned'
                    )
                    ->where('id',$gps_id)
                    ->first();
    }

    public function getCountBasedOnImeiAndSerialNo($imei,$serial_no)
    {
        return self::select('imei','serial_no')
                    ->where('imei', 'like','%'.$imei.'%')
                    ->where('serial_no', 'like', '%'.$serial_no.'%')
                    ->count();
    }
    /**
     *
     *to create new row with gps
     *
     */
    public function createRefurbishedGps($imei,$serial_no,$manufacturing_date,$icc_id,$imsi,$e_sim_number,$batch_number,$employee_code,$model_name,$version)
    {
        
        return  self::create([
                        'serial_no'             =>  $serial_no,
                        'icc_id'                =>  $icc_id,
                        'imsi'                  =>  $imsi,
                        'imei'                  =>  $imei,
                        'manufacturing_date'    =>  $manufacturing_date,
                        'e_sim_number'          =>  $e_sim_number,
                        'batch_number'          =>  $batch_number,
                        'model_name'            =>  $model_name,
                        'version'               =>  $version,
                        'employee_code'         =>  $employee_code,
                        'status'                =>  1,
                        'refurbished_status'    =>  1
                    ]); 
    }
    public function getDeviceDetails($imei)
    {
        return self::select(
            'id',
            'imei',
            'serial_no',
            'manufacturing_date',
            'icc_id',
            'imsi',
            'e_sim_number',
            'batch_number',
            'employee_code',
            'model_name',
            'version',
            'is_returned'
        )
        ->where('imei',$imei)
        ->with('gpsStock:id,gps_id,dealer_id,subdealer_id,client_id,trader_id,inserted_by')                   
        // ->with('gpsStock:trader')                   

        ->get();
       
    }

    public function getDeviceHierarchyDetails($imei)
    {
        return self::where('imei',$imei) 
        ->with('vehicle')
        ->with('gpsStock:id,gps_id,dealer_id,subdealer_id,client_id,trader_id,inserted_by')
        ->with('gpsStock.root:id,name')
        ->with('gpsStock.dealer:id,name')
        ->with('gpsStock.subdealer:id,name')
        ->with('gpsStock.trader:id,name')
        ->with('gpsStock.client:id,name')           
        ->first();
    }
    /**
     *
     *sum of km based on vehicle gps
     *
     */
    public function getSumOfKmBasedOnGpsOfVehicle($vehicle_gps_ids)
    {
        return self::select('id','km')
                    ->whereIn('id',$vehicle_gps_ids)
                    ->sum('km');
    }

     /**
     * 
     * 
     * 
     */
    public function updateEsimNumbers($imsi, $msisdn)
    {
        return self::select('id','imei','e_sim_number')->where('imsi', $imsi)
        // ->update([
        //     'e_sim_number'  => $msisdn
        // ])
        ->first();
    }

    /**
     * 
     *  update odometer
     * 
     */
    public function updateOdometer($gps_id, $total_distance)
    {
        $gps = self::find($gps_id);
        $gps->km = $gps->km + $total_distance;
        $gps->save();
    }

    /**
     * 
     * 
     */
    public function getAllOfflineDevices($offline_date_time, $device_type = null,$download_type = null , $gps_id_of_active_vehicles = null, $main_power_status = null, $firmware_version = null ,$search_key=null)
    {
        $result =   self::select('id', 'imei', 'serial_no', 'firmware_version', 'main_power_status', 'device_time')
                    // ->with('vehicleGps')
                    ->with('vehicleGps.vehicle.client')
                    ->with('gpsStock.client')
                    ->where(function ($query) {
                        $query->where('is_returned', '=', 0)
                        ->orWhere('is_returned', '=', NULL);
                    });
                    if( $device_type == config("eclipse.DEVICE_STATUS.TAGGED") )
                    {
                        $result->whereIn('id', $gps_id_of_active_vehicles)
                                ->where('device_time', '<=' ,$offline_date_time);
                    }
                    else if( $device_type == config("eclipse.DEVICE_STATUS.UNTAGGED") )
                    {
                        $result->whereNotIn('id', $gps_id_of_active_vehicles)
                                ->where('device_time', '<=' ,$offline_date_time);
                    }
                    else if( $device_type == config("eclipse.DEVICE_STATUS.NOT_YET_ACTIVATED") )
                    {
                        $result->where('device_time', '=' ,NULL);
                    }
                    else
                    {
                        $result->where(function ($query) use($offline_date_time) {
                            $query->where('device_time', '=' ,NULL)
                            ->orWhere('device_time', '<=' ,$offline_date_time);
                        });
                    }
                    if( $main_power_status == config("eclipse.MAIN_POWER_STATUS.CONNECTED") )
                    {
                        $result->where('main_power_status', '=' ,config("eclipse.MAIN_POWER_STATUS.CONNECTED"));
                    }
                    else if( $main_power_status == config("eclipse.MAIN_POWER_STATUS.DISCONNECTED") )
                    {
                        $result->where('main_power_status', '=' ,config("eclipse.MAIN_POWER_STATUS.DISCONNECTED"));
                    }
                    if( $firmware_version != null )
                    {
                        $result->where('firmware_version','like','%'.$firmware_version.'%');
                    } 
                    if( $search_key != null )
                    {
                        $result->where(function($query) use($search_key){
                            $result = $query->Where('serial_no','like','%'.$search_key.'%')
                            ->orWhere('imei','like','%'.$search_key.'%');                
                        });  
                    }  
        if($download_type == 'pdf')
        {
            return $result;   
        }else
        {
            return $result->paginate(10);   
        }     
    }

    /**
     * 
     * 
     */
    public function getDeviceOnlineReport($online_limit_date,$current_time,$vehicle_status=null,$device_status=null,$gps_ids=null,$search_key=null,$download_type=null)
    {
        $query = self::select( 
            'id',
            'imei',
            'serial_no',
            'mode'
        )
        ->with('vehicleGps.vehicle.client')
        ->with('gpsStock.client')
        ->whereBetween('device_time',[$online_limit_date,$current_time])   
        ->where(function ($query) {
            $query->where('is_returned', '=', 0)
            ->orWhere('is_returned', '=', NULL);
        });
        
        ( $vehicle_status == null ) ? $query : $query->where('mode', $vehicle_status); 
        if($device_status == config("eclipse.DEVICE_STATUS.TAGGED"))
        {
            $query = $query->whereIN('id',$gps_ids);
        }
        else if($device_status == config("eclipse.DEVICE_STATUS.UNTAGGED"))
        {
            $query = $query->whereNotIn('id',$gps_ids);
        }
        if( $search_key != null )
        {
            $query->where(function($query) use($search_key){
                $query = $query->Where('serial_no','like','%'.$search_key.'%')
                ->orWhere('imei','like','%'.$search_key.'%');                
            });  
        }  
        if($download_type == 'pdf')
        {
            return $query;   
        }else
        {
            return $query->paginate(10);   
        }    
    }
    /**
     * online offline Report count
     */
    public function getDeviceOnlineCount($online_limit_date,$current_time)
    {
        return $query = self::select('id')
        ->whereBetween('device_time',[$online_limit_date,$current_time])   
        ->where(function ($query) {
            $query->where('is_returned', '=', 0)
            ->orWhere('is_returned', '=', NULL);
        })
        ->count();
    }
    public function getDeviceOfflineCount($online_limit_date)
    {
        return $query = self::select('id')
        ->where(function ($query) {
            $query->where('is_returned', '=', 0)
            ->orWhere('is_returned', '=', NULL);
        })
        ->where(function ($query) use($online_limit_date) {
            $query->where('device_time', '=', NULL)
            ->orWhere('device_time', '<=', $online_limit_date);
        })
        ->count();
    }

    /**
     * 
     * 
     */
    public function getDeviceDetailsBasedOnImei($imei)
    {
        return self::where('imei',$imei)->first();
    }

    /**
     * 
     * 
     */
    public function manufacturedDeviceCount()
    {
        return self::select('id')
                ->where('refurbished_status',0)
                ->count();
    }

    /**
     * 
     * 
     */
    public function refurbishedDevicesInAllDevices()
    {
        return self::select('id')
                ->where('refurbished_status',1)
                ->count();
    }
    public function getGpsLastPacket($gps_id)
    {
       
        return self::select(
                'id',
                'device_time'
            )
            ->whereIn('id',$gps_id)
            ->first();
    }



    /**
     * 
     * 
     */
    public function getAllDevicesList()
    {
        return self::select(
            'id',
            'serial_no',
            'imei',
            'imsi',
            'icc_id',
            'batch_number',
            'employee_code',
            'manufacturing_date',
            'e_sim_number',
            'model_name',
            'version',
            'deleted_at',
            'refurbished_status',
            'is_returned'
        )
        ->orderBy('id','DESC')
        ->withTrashed();
    }
    /**
     * 
     * 
     */
    public function getDistributorOfflineDevices($offline_date_time, $device_type = null,$download_type = null , $distributor_all_gps_id = null ,$search_key=null,$active_vehicles_gps_id=null)
    {
        $result =   self::select('id', 'imei', 'serial_no','main_power_status', 'device_time')
                    // ->with('vehicleGps')
                    ->with('vehicleGps.vehicle.client')
                    ->with('gpsStock.client')
                    ->whereIn('id', $distributor_all_gps_id)
                    ->where(function ($query) {
                        $query->where('is_returned', '=', 0)
                        ->orWhere('is_returned', '=', NULL);
                    });
                    if( $device_type == config("eclipse.DEVICE_STATUS.TAGGED") )
                    {
                        $result->whereIn('id', $active_vehicles_gps_id)
                                ->where('device_time', '<=' ,$offline_date_time);
                    }
                    else if( $device_type == config("eclipse.DEVICE_STATUS.UNTAGGED") )
                    {
                        $result->whereNotIn('id', $active_vehicles_gps_id)
                                ->where('device_time', '<=' ,$offline_date_time);
                    }
                    else if( $device_type == config("eclipse.DEVICE_STATUS.NOT_YET_ACTIVATED") )
                    {
                        $result->where('device_time', '=' ,NULL);
                    }
                    else
                    {
                        $result->where(function ($query) use($offline_date_time) {
                            $query->where('device_time', '=' ,NULL)
                            ->orWhere('device_time', '<=' ,$offline_date_time);
                        });
                    }
                    if( $search_key != null )
                    {
                        $result->where(function($query) use($search_key){
                            $result = $query->Where('serial_no','like','%'.$search_key.'%')
                            ->orWhere('imei','like','%'.$search_key.'%');                
                        });  
                    }  
        if($download_type == 'pdf')
        {
            return $result;   
        }else
        {
            return $result->paginate(10);   
        }     
    }

     /**
     * 
     * 
     */
    public function getDistributorDeviceOnlineReport($online_limit_date,$current_time,$vehicle_status=null,$device_status=null,$active_vehicles_gps_id=null,$search_key=null,$download_type=null,$distributor_all_gps_id=null)
    {
        $query = self::select( 
            'id',
            'imei',
            'serial_no',
            'mode'
        )
        ->with('vehicleGps.vehicle.client')
        ->with('gpsStock.client')
        ->whereBetween('device_time',[$online_limit_date,$current_time])   
        ->where(function ($query) {
            $query->where('is_returned', '=', 0)
            ->orWhere('is_returned', '=', NULL);
        });
        
        ( $vehicle_status == null ) ? $query : $query->where('mode', $vehicle_status); 
        if($device_status == config("eclipse.DEVICE_STATUS.TAGGED"))
        {
            $query = $query->whereIN('id',$active_vehicles_gps_id);
        }
        else if($device_status == config("eclipse.DEVICE_STATUS.UNTAGGED"))
        {
            $query = $query->whereNotIn('id',$active_vehicles_gps_id)
            ->whereIN('id',$distributor_all_gps_id);
        }
        if( $search_key != null )
        {
            $query->where(function($query) use($search_key){
                $query = $query->Where('serial_no','like','%'.$search_key.'%')
                ->orWhere('imei','like','%'.$search_key.'%');                
            });  
        }  
        if($download_type == 'pdf')
        {
            return $query;   
        }else
        {
            return $query->paginate(10);   
        }    
    }
    
}
