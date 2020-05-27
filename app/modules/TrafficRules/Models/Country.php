<?php

namespace App\Modules\TrafficRules\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * 
     * Get country
     * 
     */
    public function getCountryDetails(){
        return self::select('id','name')->where('id',101)->get();
    }
}
