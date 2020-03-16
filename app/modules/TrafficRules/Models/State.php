<?php

namespace App\Modules\TrafficRules\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * 
     * 
     */
    public function country()
    {
        return $this->hasOne('App\Modules\TrafficRules\Models\Country','id','country_id');
    }
    /**
     * 
     * get state
     */
    public function getStateDetails($country_id){
        return self::select('id','name','country_id')->where('country_id',$country_id)->get();
    }
}
