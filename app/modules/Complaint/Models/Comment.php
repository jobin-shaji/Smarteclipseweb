<?php

namespace App\Modules\Complaint\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
		'user_id','comment'
	];
}
