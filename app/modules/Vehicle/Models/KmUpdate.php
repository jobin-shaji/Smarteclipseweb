<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class KmUpdate extends Model
{
     protected $fillable = [
        'gps_id','km','lat','lng','device_time'
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];
     public function getKmDetailsForReport($gps_ids,$date)
    {
        return self::select(
            'id',
            'gps_id',
            'km',
            'device_time'
        )
        ->whereIn('gps_id', $gps_ids)       
        ->whereDate('device_time', $date);
    }
}


