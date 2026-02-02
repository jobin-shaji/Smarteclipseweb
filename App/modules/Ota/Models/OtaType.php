<?php

namespace App\Modules\Ota\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtaType extends Model
{
    use SoftDeletes; 

    protected $fillable=[
		'name','code','default_value'
	];
}
