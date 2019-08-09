<?php

namespace App\Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'name','address','mobile'
	];	
}
