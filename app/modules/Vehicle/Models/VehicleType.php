<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{

	public $timestamps = false;
	
    protected $fillable = [
        'name','status','svg_icon','vehicle_scale','opacity','strokeWeight','online_icon','offline_icon','ideal_icon','sleep_icon','web_online_icon','web_offline_icon','web_ideal_icon','web_sleep_icon'
    ];

}
