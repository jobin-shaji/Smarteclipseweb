<?php

namespace App\Modules\Vehicle\Models;
use Illuminate\Database\Eloquent\Model;
class DailyKm extends Model
{
   protected $fillable = [
        'gps_id','km','date'
    ];
    public function gps()
    {
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
    public function vehicle()
    {
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','gps_id')->withTrashed();
    }
}

