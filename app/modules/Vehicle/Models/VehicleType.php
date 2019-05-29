<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{

	public $timestamps = false;
	
    protected $fillable = [
        'name','status','svg_icon','vehicle_scale','opacity','strokeWeight'
    ];

}
