<?php

namespace App\Modules\Operations\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyLog extends Model
{
    use SoftDeletes;
	protected $fillable=[
		'gps_id','lat','lng','alert_type_id','device_time','verified_by','verified_at'
	];
}
