<?php

namespace App\Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //

    protected $fillable=[ 'name','description','amount','country_id','year'];

    public function country()
    {
    	return $this->hasOne('App\Modules\TrafficRules\Models\Country','id','country_id');
    }
}
