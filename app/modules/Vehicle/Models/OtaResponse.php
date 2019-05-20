<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class OtaResponse extends Model
{
    // ota response  fillable data
	protected $fillable = [
        'client_id','vehicle_id','imei', 'response', 'status'
    ];

}
