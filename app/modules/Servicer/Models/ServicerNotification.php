<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ServicerNotification extends Model
{
	 use SoftDeletes;

	 protected $fillable = ['servicer_id', 'title','data','service_job_id'];
    
}

