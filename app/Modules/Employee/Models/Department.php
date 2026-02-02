<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;   
    public $table = 'cd_departments'; 
	protected $fillable=[
		'name','role_id'
	];

   
}
