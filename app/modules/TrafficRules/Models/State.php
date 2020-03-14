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
}
