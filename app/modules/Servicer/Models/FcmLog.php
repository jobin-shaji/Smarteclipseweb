<?php

namespace App\Modules\Servicer\Models;
use Illuminate\Database\Eloquent\Model;

class FcmLog extends Model
{
	 protected $fillable=[ 'user_device_id','body','response'];
}