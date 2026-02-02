<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'password','username','name','code','mobile','email','designation_id','department_id','user_id'
	];

	public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id','id')->withTrashed();
	}
	public function department()
    {
    	return $this->belongsTo('App\Modules\Employee\Models\Department','department_id','id');
	}

	public function designation()
    {
    	return $this->belongsTo('App\Modules\Employee\Models\Designation','designation_id','id');
	}

}
