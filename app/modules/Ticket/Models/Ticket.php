<?php

namespace App\Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable=[
		'code','client_id','status'
	];
}
