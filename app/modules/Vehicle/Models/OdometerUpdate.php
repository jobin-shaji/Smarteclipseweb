<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class OdometerUpdate extends Model
{
    protected $fillable = [
        'gps_id','vehicle_id','old_odometer','new_odometer','edited_at','updated_by'
    ];
}
