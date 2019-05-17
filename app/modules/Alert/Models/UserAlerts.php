<?php

namespace App\Modules\Alert\Models;

use Illuminate\Database\Eloquent\Model;

class UserAlerts extends Model
{
	protected $fillable=[
		'client_id','alert_id','status'
	];
    
}
