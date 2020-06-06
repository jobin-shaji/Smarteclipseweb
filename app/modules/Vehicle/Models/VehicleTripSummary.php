<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleTripSummary extends Model
{
    protected $fillable = [
        'vehicle_id','client_id','report_url','distance','trip_date'
    ];

    public function addNewReport($client_id, $vehicle_id, $report_url, $distance, $trip_date)
    {
        $report = self::create([
            'client_id'       =>  $client_id,
            'vehicle_id'      =>  $vehicle_id,
            'report_url'      =>  $report_url,
            'distance'        =>  $distance,
            'trip_date'       =>  $trip_date
        ]);

    }
    /*
    *
    * 
    */
    public function client(){
        return $this->hasOne('App\Modules\Client\Models\Client','id','client_id')->withTrashed();
    }
    /*
    *
    * 
    */
    public function vehicle(){
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id')->withTrashed();
    }
    /*
    *
    * 
    */
    public function getTripDetailsBetweenTwoDates($client_ids, $vehicle_ids, $from_date, $to_date)
    {
        return self::whereIn('client_id',$client_ids)
                    ->whereIn('vehicle_id',$vehicle_ids)
                    ->with('client:id,name')
                    ->with('vehicle:id,name,register_number')
                    ->where('trip_date', '>=' , $from_date)
                    ->where('trip_date', '<=' , $to_date)
                    ->get();
    }
}


