<?php

namespace App\Modules\Client\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAlertPoint extends Model
{
    protected $fillable=[
		'alert_type_id','client_id','driver_point'
	];

	// alert type 
    public function alertType(){
    	return $this->hasOne('App\Modules\Alert\Models\AlertType','id','alert_type_id');
    }	
}
