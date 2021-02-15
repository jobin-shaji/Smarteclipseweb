<?php

namespace App\Modules\DeviceReassign\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceReassignHistory extends Model
{
    protected $fillable=[
		'gps_id','imei','reassign_type_id','reassign_from','reassign_to','reassigned_on'
    ];
    
    public function insertReassignedHistory($gps_id, $imei, $reassign_type_id, $reassign_from, $reassign_to, $reassigned_on)
	{
		return self::create([
			'gps_id'            =>  $gps_id,
			'imei'              =>  $imei,
			'reassign_type_id'  =>  $reassign_type_id,
			'reassign_from'     =>  $reassign_from,
			'reassign_to'       =>  $reassign_to,
			'reassigned_on'     =>  $reassigned_on
		]);
	}
}
