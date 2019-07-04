<?php

namespace App\Modules\Gps\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class Gps extends Model
{
	use SoftDeletes;
 

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    // protected $encryptable = [
    //     'code',
    //     'keys',
    //     'allergies'
    // ];

    protected $fillable=[ 'name','imei','manufacturing_date','brand','model_name','version','user_id','status'];

    //join user table with gps table
    public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id');
    }

    public function transfers()
    {
    	return $this->hasMany('App\Modules\Gps\Models\GpsTransfer');
    }
    
    public function vehicle()
    {
     return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','id')->withTrashed();
    }
     public function gpsdata()
    {
        return $this->hasMany('App\Modules\Gps\Models\GpsData','gps_id','id')->orderBy('id', 'desc');
    }
}
