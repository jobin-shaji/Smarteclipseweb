<?php

namespace App\Modules\Complaint\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintComment extends Model
{
    protected $fillable=[
		'complaint_id','ticket_code','comment'
	];
}
