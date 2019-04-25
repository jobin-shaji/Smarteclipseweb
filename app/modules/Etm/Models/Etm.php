<?php

namespace App\Modules\Etm\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class Etm extends Model
{
	use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    protected $fillable=[ 'name','imei','purchase_date','version','status','depot_id' ];

    //join depot table with etm table
    public function depot()
    {
    	return $this->hasOne('App\Modules\Depot\Models\Depot','id','depot_id');
    }


    public function waybill(){
    	return $this->hasOne('App\Modules\WayBill\Models\Waybill','etm_id','id')->where('status',0);
    }

    public function deviceInfo()
    {
        return $this->hasMany('App\Modules\Etm\Models\DeviceInfo','etm_id','id');
    }

    
}
