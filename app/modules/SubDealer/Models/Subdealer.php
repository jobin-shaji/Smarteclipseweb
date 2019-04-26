<?php

namespace App\Modules\SubDealer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SubDealer extends Model
{
   use SoftDeletes;
    
	protected $fillable=[
		'user_id','dealer_id','name','address','phone_number','email','status','created_by','deleted_by','deleted_at'
	];
}
