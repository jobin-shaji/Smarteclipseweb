<?php

namespace App\Modules\Student\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'code','name','address','mobile','latitude','longitude','school_id'
	];	

	public function school(){
		return $this->hasOne('App\Modules\School\Models\School','id','school_id');
	}
}
