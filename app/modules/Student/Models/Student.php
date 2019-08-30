<?php

namespace App\Modules\Student\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'code','name','gender','class_id','division_id','parent_name','email','route_batch_id','nfc','address','mobile','latitude','longitude','password','client_id'
	];	

	public function class(){
		return $this->hasOne('App\Modules\SchoolClass\Models\SchoolClass','id','class_id');
	}

	public function division(){
		return $this->hasOne('App\Modules\ClassDivision\Models\ClassDivision','id','division_id');
	}

	public function routeBatch(){
		return $this->hasOne('App\Modules\Student\Models\RouteBatch','id','route_batch_id');
	}
}
