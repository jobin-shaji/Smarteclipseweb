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
}


