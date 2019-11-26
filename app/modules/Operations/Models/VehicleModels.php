<?php

namespace App\Modules\Operations\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModels extends Model
{
    
	protected $fillable=[
		'vehicle_model','fuel_min','fuel_max'
	];
}
