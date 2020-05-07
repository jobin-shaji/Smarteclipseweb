<?php

namespace App\Modules\Vehicle\Models;
use Illuminate\Database\Eloquent\Model;

class VehicleDailyUpdate extends Model
{
     protected $fillable=[  'gps_id' ,'km','ignition_on','ignition_off','moving','sleep','halt','stop','ac_on','ac_off','ac_on_idle','top_speed','date'];
    public function getVehicleDurationsBasedOnDates($gps_ids,$from_date,$to_date)
    {
        return self::select(
            \DB::raw('sum(ignition_on) as ignition_on'),
            \DB::raw('sum(ignition_off) as ignition_off'),
            \DB::raw('sum(moving) as moving'),
            \DB::raw('sum(halt) as halt'),
            \DB::raw('sum(sleep) as sleep'),
            \DB::raw('sum(stop) as stop'),
            \DB::raw('sum(ac_on) as ac_on'),
            \DB::raw('sum(ac_off) as ac_off'),
            \DB::raw('sum(ac_on_idle) as ac_on_idle')
        )
        ->where('date', '>=', $from_date)
        ->where('date', '<=', $to_date)
        ->whereIn('gps_id',$gps_ids)
        ->first();
    }
    
}

