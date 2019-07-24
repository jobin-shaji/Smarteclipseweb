<?php

namespace App\Modules\Sos\Models;

use Illuminate\Database\Eloquent\Model;

class SosTransferItems extends Model
{
    // fillable fields
    protected $fillable=['sos_transfer_id','sos_id'];

    //join user table with gps table
    public function sos()
    {
    	return $this->hasOne('App\Modules\Sos\Models\Sos','id','sos_id');
    }
     public function sostransfer()
    {
    	return $this->hasOne('App\Modules\Sos\Models\Sos','id','sos_id');
    }
}
