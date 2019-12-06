<?php

namespace App\Modules\Configuration\Models;
use Illuminate\Database\Eloquent\Model;
class Configuration extends Model
{
   protected $fillable=[
		'name','value','code'
	];
}
