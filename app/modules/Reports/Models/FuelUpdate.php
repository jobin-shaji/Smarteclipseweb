<?php

namespace App\Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;

class FuelUpdate extends Model
{
	// gps 
    public function gps(){
    	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
}
