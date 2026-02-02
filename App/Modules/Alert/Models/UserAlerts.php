<?php

namespace App\Modules\Alert\Models;

use Illuminate\Database\Eloquent\Model;

class UserAlerts extends Model
{
	protected $fillable=[
		'client_id','alert_id','status'
	];
    public function alertType(){
	  return $this->hasOne('App\Modules\Alert\Models\AlertType','id','alert_id');
	}
}

