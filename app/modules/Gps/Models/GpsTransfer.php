<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class GpsTransfer extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

	// fillable fields
    protected $fillable=['from_user_id','to_user_id','dispatched_on','accepted_on'];

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

    public function gpsTransferItems()
    {
        return $this->hasMany('App\Modules\Gps\Models\gpsTransferItems','gps_transfer_id','id');
    }
}
