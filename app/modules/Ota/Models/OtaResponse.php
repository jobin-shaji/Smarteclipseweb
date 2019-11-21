<?php

namespace App\Modules\Ota\Models;

use Illuminate\Database\Eloquent\Model;

class OtaResponse extends Model
{
    // ota response  fillable data
	protected $fillable = [
        'gps_id', 'response','operations_id'
    ];

}
