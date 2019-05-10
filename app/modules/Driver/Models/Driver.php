<?php

namespace App\Modules\Driver\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class Driver extends Model
{
   use SoftDeletes;    
	protected $fillable=[
		'name','address','mobile','client_user_id','deleted_at'
	];
}
