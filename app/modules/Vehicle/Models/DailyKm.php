<?php

namespace App\Modules\Vehicle\Models;
use Illuminate\Database\Eloquent\Model;
class DailyKm extends Model
{
  public $timestamps = false;

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
     public function alert()
    {
        return $this->hasMany('App\Modules\Alert\Models\Alert','gps_id','gps_id');
    }

    public function updateDailyKilometre($gps_id, $value)
    {
       return self::where('gps_id',$gps_id)->where('date',date("Y-m-d"))->update(['km'=> $value]);
    }
    /**
     * 
     * 
     */
    public function vehicleTotalKilometres($from_date, $to_date, $gps_id)
    {
        return self::where('gps_id', $gps_id)
            ->where('date', '>=', $from_date)
            ->where('date', '<=', $to_date)
            ->sum('km');
    }
}

