<?php

namespace App\Modules\DataUsage\Models;

use Illuminate\Database\Eloquent\Model;

class DailyDataUsage extends Model
{
	// gps
    public function gps(){
    	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }


}
