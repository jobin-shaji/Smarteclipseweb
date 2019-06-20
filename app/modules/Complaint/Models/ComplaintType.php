<?php

namespace App\Modules\Complaint\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplaintType extends Model
{
	use SoftDeletes; 
	   
    protected $fillable=[
		'name','complaint_category'
	];

}
