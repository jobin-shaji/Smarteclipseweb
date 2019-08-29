<?php

namespace App\Modules\SchoolClass\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'name','school_id'
	];	
}
