<?php

namespace App\Modules\Dealer\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
	public $timestamps = false;

    protected $fillable=[
		'type','status'
	];


}
