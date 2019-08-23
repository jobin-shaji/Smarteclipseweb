<?php

namespace App\Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class Subscription extends Model
{
    use SoftDeletes;
 
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    protected $fillable=[ 'plan_id','country_id','amount'];

    public function country()
    {
    	return $this->hasOne('App\Modules\TrafficRules\Models\Country','id','country_id');
    }

    public function plan()
    {
    	return $this->hasOne('App\Modules\Subscription\Models\Plan','id','plan_id');
    }
}
