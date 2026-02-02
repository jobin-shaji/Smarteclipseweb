<?php

namespace App\Modules\Ota\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GpsOta extends Model
{
    use SoftDeletes; 

    protected $fillable=[
		'gps_id','ota_type_id','value'
	];

	// ota type 
    public function otaType(){
    	return $this->hasOne('App\Modules\Ota\Models\OtaType','id','ota_type_id');
    }
}
