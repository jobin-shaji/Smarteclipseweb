<?php
namespace App\Modules\Gps\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GpsOrder extends Model
{

	protected $table = 'gps_orders';

    protected $fillable=[
        'order_id',
        'gps_id',
        'delivery_name',
        'delivery_address',
        'vat_amount',
        'total_amount',
        'vat_percentage',
        'payment_type',
        'payment_status',
        'order_status',
        'ordid',
        'order_type',
        'sales_by',
       
    ];

    // dealer
   
    public function gps()
    {
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
    public function vehicle()
    {
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','gps_id')->withTrashed();
    }
    public function salesUser()
    {
        return $this->belongsTo('App\Modules\User\Models\User','sales_by','id');
    }

   
    public function getTrackData($from_date = null,$to_date = null,$gps_ids = null,$start_offset = null,$limit = null,$gps_data_table = null)
    {
        $gps_data_table ='gps_history';
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
                    //->where('device_time', '<=', $to_date)
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

    public function getSumOfKmBasedOnGpsOfVehicle($vehicle_gps_ids)
    {
        return self::select('id','distance as km')
                    ->whereIn('gps_id',$vehicle_gps_ids)
                    ->sum('distance');
    }

    // delete gps data
    public function deleteGpsData($gps_id = null,$table_name = null)
    {
        return DB::table($table_name)
                ->where('gps_id', $gps_id)
                ->delete(); 
    }

    public function fetchYesterdaysRecordsOfVehicleDevice($imei)
    {
        $this->setTable('gps_data_'.date('Ymd',strtotime("-1 days")));

        return self::select('imei', 'latitude', 'longitude', 'vehicle_mode', 'device_time','header')
                    ->where('imei', $imei)
                    ->whereNotIn('header',['HLM','LGN'])
                    ->whereDate('device_time',date('Y-m-d',strtotime("-1 days")))
                    ->orderBy('device_time','asc')
                    ->get();
    }

    public function fetchDateWiseRecordsOfVehicleDevice($imei, $table, $trip_date)
    {
        $this->setTable($table);

        return self::select('imei', 'latitude', 'longitude', 'vehicle_mode', 'device_time','header')
                    ->where('imei', $imei)
                    ->whereNotIn('header',['HLM','LGN'])
                    ->whereDate('device_time',date('Y-m-d',strtotime($trip_date)))
                    ->orderBy('device_time','asc')
                    ->get();
    }

    public function getGpsLastPacket($gps_id)
    {
       
        return self::select(
                'id',
                'device_time'
            )
            ->whereIn('gps_id',$gps_id)
            ->first();
    }
}
