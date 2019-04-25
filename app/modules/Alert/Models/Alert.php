<?php

namespace App\Modules\Alert\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
	public function vehicle(){
	 return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id');
	}

	public function stage(){
	  return $this->hasOne('App\Modules\Stage\Models\Stage','id','stage_id');
	}

	public function waybill(){
	  return $this->hasOne('App\Modules\WayBill\Models\Waybill','id','waybill_id');

	}
}
