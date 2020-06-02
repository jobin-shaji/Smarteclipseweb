<?php
namespace App\Modules\Gps\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GpsData extends Model
{

     protected $table = 'gps_data';

    protected $fillable=[
        'client_id',
        'gps_id',
        'vehicle_id',
        'header',
        'vendor_id',
        'firmware_version',
        'imei',
        'update_rate_ignition_on',
        'update_rate_ignition_off',
        'battery_percentage',
        'low_battery_threshold_value',
        'memory_percentage',
        'digital_io_status',
        'analog_io_status',
        'activation_key',
        'latitude',
        'lat_dir',
        'longitude',
        'lon_dir',
        'date',
        'time',
        'speed',
        'alert_id',
        'packet_status',
        'gps_fix',
        'mcc',
        'mnc',
        'lac',
        'cell_id',
        'heading',
        'no_of_satelites',
        'hdop',
        'gsm_signal_strength',
        'ignition',
        'main_power_status',
        'vehicle_mode',
        'altitude',
        'pdop',
        'nw_op_name',
        'nmr',
        'main_input_voltage',
        'internal_battery_voltage',
        'tamper_alert',
        'digital_input_status',
        'digital_output_status',
        'vehicle_register_num',
        'frame_number',
        'checksum',
        'key1',
        'value1',
        'key2',
        'value2',
        'key3',
        'value3',
        'gf_id',
        'device_time'
    ];

    // dealer
    public function client()
    {
    return $this->hasOne('App\Modules\Client\Models\Client','id','client_id');
    }
    public function gps()
    {
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
    public function vehicle()
    {
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','gps_id')->withTrashed();
    }
    public function alert()
    {
        return $this->hasOne('App\Modules\Alert\Models\AlertType','code','alert_id');
    }
    public function sleep()
    {
       return $this->hasMany('App\Modules\Gps\Models\GpsData','date','date');
    }
    public function vehicleGps()
    {
        return $this->belongsToMany('App\Modules\Gps\Models\GpsData', 'vehicle_gps',  'vehicle_id' ,'gps_id')->withPivot('id');
    }
    public function dailyKm()
    {
        return $this->hasOne('App\Modules\Vehicle\Models\DailyKm','gps_id','gps_id');
    }
    public function vlt_data()
    {
        return $this->hasOne('App\Modules\VltData\Models\VltData','id','vlt_data');
    }
    
    // public function kmUpdates()
    // {
    //    return $this->hasMany('App\Modules\Vehicle\Models\KmUpdate','gps_id','gps_id')->where('device_time');
    // }
    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    public function checkIfTableExistInDataBase($gps_data_table)
    {
        return DB::select("SELECT TABLE_NAME AS table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".config('eclipse.database_name')."' and TABLE_NAME like '$gps_data_table'");
    }
    
    public function getCountGpsData($from_date = null,$to_date = null,$gps_ids =null,$gps_data_table = null)
    {
        return DB::table($gps_data_table)
                ->where('device_time', '>=', $from_date)
                ->where('device_time', '<=', $to_date)
                ->whereIn('gps_id', $gps_ids)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('gps_fix',1)
                ->orderBy('device_time', 'asc')
                ->count(); 
    }
    public function getTrackData($from_date = null,$to_date = null,$gps_ids = null,$start_offset = null,$limit = null,$gps_data_table = null)
    {
        return DB::table($gps_data_table)
                    ->select('id',
                            'latitude as latitude',
                            'longitude as longitude',
                            'lat_dir as latitude_dir',
                            'lon_dir as longitude_dir',
                            'heading as angle',
                            'vehicle_mode as vehicleStatus',
                            'speed',
                            'device_time as dateTime')
                    ->where('device_time', '>=', $from_date)
                    ->where('device_time', '<=', $to_date)
                    ->whereIn('gps_id', $gps_ids)
                    ->offset($start_offset)
                    ->limit($limit)
                    ->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->where('gps_fix',1)
                    ->orderBy('device_time', 'asc')
                    ->get();        
    }

    public function getCountGpsDataByGpsId($gps_id = null,$table_name = null)
    {
        return DB::table($table_name)
                ->where('gps_id', $gps_id)
                ->count();
    }

    // get all GpsData Table
    public function getGpsDataTable()
    {

        return DB::select("SELECT TABLE_NAME AS table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".config('eclipse.database_name')."' and TABLE_NAME like 'gps_data_20%'");
    }

    // get both gps data and gps data archived Table
    public function getGpsDataAndGpsDataArchivedTable()
    {

        return DB::select("SELECT TABLE_NAME AS table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".config('eclipse.database_name')."' and TABLE_NAME like 'gps_data%'");
    }

    // delete gps data
    public function deleteGpsData($gps_id = null,$table_name = null)
    {
        return DB::table($table_name)
                ->where('gps_id', $gps_id)
                ->delete(); 
    }
}
