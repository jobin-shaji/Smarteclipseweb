<?php

namespace App\Modules\DeviceReturn\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceReturnHistory extends Model
{
    protected $fillable = ['device_return_id', 'activity'];

    /**
     * 
     * 
     */
    public function addHistory($device_return_id, $activity = '')
    {
        return self::create([
            'device_return_id'  => $device_return_id,
            'activity'          => $activity
        ]);
    }

    /**
     * 
     */
    public function getTransferHistory($device_return_id)
    {
        return self::select('activity', 'created_at')->where('device_return_id',$device_return_id)->orderBy('created_at','desc')->get();
    }
}
