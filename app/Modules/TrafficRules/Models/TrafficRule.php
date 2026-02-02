<?php

namespace App\Modules\TrafficRules\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class TrafficRule extends Model
{
    use SoftDeletes;
 
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    protected $fillable=[ 'country_id','state_id','speed'];

    public function country()
    {
    	return $this->hasOne('App\Modules\TrafficRules\Models\Country','id','country_id');
    }

    public function state()
    {
    	return $this->hasOne('App\Modules\TrafficRules\Models\State','id','state_id');
    }
}
