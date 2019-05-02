<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;



class GpsTransfer extends Model
{
	// fillable fields
    protected $fillable=[
		'gps_id','from_user_id','to_user_id','transfer_date'
	];

	//join user table with gps table
    public function gps()
    {
    	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }

	//join user table with gps table
    public function fromUser()
    {
    	return $this->hasOne('App\Modules\User\Models\User','id','from_user_id');
    }

    //join user table with gps table
    public function toUser()
    {
    	return $this->hasOne('App\Modules\User\Models\User','id','to_user_id');
    }
}
