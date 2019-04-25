<?php

namespace App\Modules\EtmTransfer\Models;

use Illuminate\Database\Eloquent\Model;



class EtmTransfer extends Model
{
	// fillable fields
    protected $fillable=[
		'etmID','from_depot','to_depot','tarnferDate','state'
	];
   // state selection

   // from depot details from Etm transfer
	public function fromDepotDetails(){
	
		return $this->hasOne('App\Modules\Depot\Models\Depot','id','from_depot');
	}
   // to depot details from Etm transfer
	public function toDepotDetails(){
		
		return $this->hasOne('App\Modules\Depot\Models\Depot','id','to_depot');
	}

	// etm details from etm transfer
	public function etmDetails(){
	  return $this->hasOne('App\Modules\Etm\Models\Etm','id','etmID');	
	}
}
