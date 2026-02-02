<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use SoftDeletes;   
    public $table = 'cd_designations'; 
	protected $fillable=[
		'name',
	];

   
}
