<?php

namespace App\Modules\Gps\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        ->with('vehicle:id,gps_id')
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
     * esim updation
     * 
     */
    public function updateEsimNumbers($imsi, $msisdn)
    {
        return self::where('imsi', $imsi)->update([
            'e_sim_number'  => $msisdn
        ]);
    }
    public function getDeviceOnlineReport($online_limit_date,$current_time,$vehicle_status=null,$device_status=null,$gps_ids=null)
    {
        $query = self::select( 
            'id',
            'imei',
            'serial_no',
            'mode'
        )
        ->with('vehicleGps.vehicle.client')
        ->whereBetween('device_time',[$online_limit_date,$current_time])   
        ->where(function ($query) {
            $query->where('is_returned', '=', 0)
            ->orWhere('is_returned', '=', NULL);
        });
        ( $vehicle_status == null ) ? $query : $query->where('mode', $vehicle_status); 
        if($device_status == 1)
        {
            $query = $query->whereIN('id',$gps_ids);
        }
        else if($device_status == 2)
        {
            $query = $query->whereNotIn('id',$gps_ids);
        }  
        return $query->paginate(10);
    }
    /**
     * online offline Report count
     */
    public function getDeviceOnlineCount($online_limit_date,$current_time)
    {
        return $query = self::select()
        ->with('vehicleGps.vehicle.client')
        ->whereBetween('device_time',[$online_limit_date,$current_time])   
        ->where(function ($query) {
            $query->where('is_returned', '=', 0)
            ->orWhere('is_returned', '=', NULL);
        })
       ->get()->count();
       
    }
    public function getDeviceOfflineCount($online_limit_date)
    {
        return $query = self::select()
        ->with('vehicleGps.vehicle.client')
        ->where('device_time')   
        ->where(function ($query) {
            $query->where('is_returned', '=', 0)
            ->orWhere('is_returned', '=', NULL);
        })
        ->where('device_time', '>=', $online_limit_date)
        ->get()->count();
       
    }
    
}
