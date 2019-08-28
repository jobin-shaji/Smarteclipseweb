<?php

namespace App\Modules\BusHelper\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusHelper extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'name','mobile'
	];
}
