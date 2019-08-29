<?php

namespace App\Modules\ClassDivision\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassDivision extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'name','class_id','school_id'
	];	

	// class
    public function class(){
    	return $this->hasOne('App\Modules\SchoolClass\Models\SchoolClass','id','class_id');
    }
}

