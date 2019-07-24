<?php

namespace App\Modules\Sos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class Sos extends Model
{
    use SoftDeletes;
 
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    protected $fillable=[ 'imei','manufacturing_date','brand','model_name','version','user_id','status'];

    //join user table with sos table
    public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id');
    }

    public function transfers()
    {
    	return $this->hasMany('App\Modules\Sos\Models\SosTransfer');
    }
    
}
