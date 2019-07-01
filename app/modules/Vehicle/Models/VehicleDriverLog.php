<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDriverLog extends Model
{
	protected $fillable = [
        'vehicle_id','from_driver_id','to_driver_id','client_id'
    ];
}
