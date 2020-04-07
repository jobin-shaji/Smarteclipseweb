<?php

namespace App\Modules\Ota\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

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
            'response'  => trim($command)
        ]);
    }

    public function writeCommandToRedis($imei,$command)
    {
        $existing_value     =   Redis::get($imei);
        if($existing_value)
        {
            $command        =  $existing_value.','.trim($command);    
        }
        return Redis::set( $imei, trim($command));
    }
}
