<?php

namespace App\Modules\SubDealer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subdealer extends Model
{
    use SoftDeletes;
    
	protected $fillable=[
		'name','address','phone_number','username','password','status','created_by','deleted_by','deleted_at'
	];

}
