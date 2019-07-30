<?php

namespace App\Modules\smsUsage\Models;

use Illuminate\Database\Eloquent\Model;

class SmsStatus extends Model
{
    public function gps(){
    	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
}
