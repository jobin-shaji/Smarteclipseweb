<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;

class GpsTransferItems extends Model
{
    // fillable fields
    protected $fillable=['gps_transfer_id','gps_id'];

    //join user table with gps table
    public function gps()
    {
    	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
    
}
