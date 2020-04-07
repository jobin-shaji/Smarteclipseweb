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

    public function saveCommandsToDevice($gps_id = null, $command = '')
    {
        return self::create([
            'gps_id'    => $gps_id,
            'response'  => trim($command)
        ]);
    }

    public function writeCommandToDevice($imei,$command)
    {
        $pending_commands_to_device     =   Redis::get($imei);
        if($pending_commands_to_device)
        {
            $command                    =   $pending_commands_to_device.','.trim($command);    
        }
        return Redis::set( $imei, trim($command));
    }
}
