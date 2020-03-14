<?php

namespace App\Modules\TrafficRules\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable=[ 'latitude','longitude','speed', 'name'];

    /**
     * 
     * 
     */
    public function state()
    {
        return $this->hasOne('App\Modules\TrafficRules\Models\State','id','state_id');
    }

    /**
     * 
     * 
     */
    public function getCityGeoCodes($city_id = null)
    {
        return self::select('latitude','longitude')->where('id',$city_id)->first();
    }
}
