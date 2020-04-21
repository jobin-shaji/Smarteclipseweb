<?php

namespace App\Modules\Driver\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DB;

class DriverVehicleHistory extends Model
{
    use SoftDeletes;    
	protected $fillable=[
		'vehicle_id','driver_id','from_date','to_date'
	];
	 public function getGpsDetailsBasedOnVehicleWithSingleDate($driver_id,$vehicle_id,$search_date)
    {
    	return $query = DB::table('driver_vehicle_histories')
        ->join('vehicles', 'driver_vehicle_histories.vehicle_id', '=', 'vehicles.id')
        ->select('vehicles.gps_id as gps_id')
        ->where('vehicle_id',$vehicle_id)
        // ->where('driver_id',$driver_id)
        ->whereDate('from_date', '>=', $search_date)->whereDate('to_date', '<=', $search_date)       
       	->get();
     
    }
}
