<?php

namespace App\Modules\Dealer\Models;
use Illuminate\Database\Eloquent\Model;

class EmployeeDesignation extends Model
{
	public $timestamps = false;

    protected $fillable=[
		'designation','status'
	];

}
