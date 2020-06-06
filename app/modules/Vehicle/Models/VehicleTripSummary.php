<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleTripSummary extends Model
{
    protected $fillable = [
        'vehicle_id','client_id','report_url','distance'
    ];

    public function addNewReport($client_id, $vehicle_id, $report_url, $distance, $trip_date)
    {
        return self::create([
            'client_id'       =>  $client_id,
            'vehicle_id'      =>  $vehicle_id,
            'report_url'      =>  $report_url,
            'distance'        =>  $distance,
            'trip_date'       =>  $trip_date
        ]);
    }

}


