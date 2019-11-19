<?php

namespace App\Modules\Operations\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operations extends Model
{
    use SoftDeletes;    
	protected $fillable=[
		'user_id','name','root_id','address','phone_number','email','status','created_by','deleted_by','deleted_at'
	];
}
