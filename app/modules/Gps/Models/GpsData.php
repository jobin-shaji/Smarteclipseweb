<?php

namespace App\Modules\Gps\Models;
use Illuminate\Database\Eloquent\Model;

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
}
