<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;



class GpsTransfer extends Model
{
	// fillable fields
    protected $fillable=[
		'gps_id','from_user','to_user','transfer_date'
	];

 //   // from depot details from Etm transfer
	// public function fromDepotDetails(){
	
	// 	return $this->hasOne('App\Modules\Depot\Models\Depot','id','from_depot');
	// }
 //   // to depot details from Etm transfer
	// public function toDepotDetails(){
		
	// 	return $this->hasOne('App\Modules\Depot\Models\Depot','id','to_depot');
	// }

	// // etm details from etm transfer
	// public function etmDetails(){
	//   return $this->hasOne('App\Modules\Etm\Models\Etm','id','etmID');	
	// }
}
