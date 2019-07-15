<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;

class GpsLog extends Model
{
    protected $fillable=[ 'gps_id','status','user_id'];

    //join user table with gps table
    public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id');
    }
}
