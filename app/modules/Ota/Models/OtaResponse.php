<?php

namespace App\Modules\Ota\Models;

use Illuminate\Database\Eloquent\Model;

class OtaResponse extends Model
{
    // ota response  fillable data
	protected $fillable = [
        'gps_id', 'response','operations_id'
    ];


public function sendOtaResponse($gps_id = null, $command = '')
    {
        return self::create([
            'gps_id'    => $gps_id,
            'response'  => $command
        ]);
    }
}
