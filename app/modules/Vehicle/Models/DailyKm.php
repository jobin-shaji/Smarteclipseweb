<?php

namespace App\Modules\Vehicle\Models;
use Illuminate\Database\Eloquent\Model;

class DailyKm extends Model
{
   
    public $timestamps = false;

    protected $fillable = [
        'gps_id','km','date'
    ];

   /**
     * 
     * 
     */
    public function gps()
    {
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }

   /**
     * 
     * 
     */
    public function vehicle()
    {
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','gps_id')->withTrashed();
    }

   /**
     * 
     * 
     */
    public function alert()
    {
        return $this->hasMany('App\Modules\Alert\Models\Alert','gps_id','gps_id');
    }

   /**
     * 
     * 
     */
    public function updateDailyKilometre($gps_id, $value)
    {
       return self::where('gps_id',$gps_id)->where('date',date("Y-m-d"))->update(['km'=> $value]);
    }

   /**
     * 
     * 
     */
    public function vehicleGps(){
		return $this->hasOne('App\Modules\Vehicle\Models\VehicleGps','gps_id','gps_id');
	}

    /**
     * 
     * 
     */
    public function vehicleTotalKilometres($from_date, $to_date, $gps_ids)
    {
        return self::whereIn('gps_id', $gps_ids)
            ->where('date', '>=', $from_date)
            ->where('date', '<=', $to_date)
            ->sum('km');
    }

    /**
     * 
     * 
     */
    public function getDailyKmBasedOnDateAndGps($gps_ids, $search_date)
    {
        return self::whereIn('gps_id', $gps_ids)
            ->where('date', $search_date)
            ->with('vehicleGps.vehicle')
            ->get();
    }

     /**
     * 
     * 
     */
    public function getDailyKmBasedOnFromDateAndToDateGps($gps_ids,$from_date,$to_date)
    {
        return self::whereIn('gps_id',$gps_ids)
            ->where('date', '>=', $from_date)
            ->where('date', '<=', $to_date)
            ->with('vehicleGps.vehicle')
            ->get();

    }
    /**
     * 
     * 
     */

    public function getSumOfKmForFuelReportBasedOnDate($gps_ids,$date)
    {
        return self::select(
            'km',
            'date'
        )
        ->whereIn('gps_id', $gps_ids)
        ->whereDate('date',$date)
        ->sum('km');
    }

     /**
     * 
     * 
     */
    public function getSumOfKmForFuelReportBasedOnMonth($gps_ids,$month)
    {
        return self::select(
            'km',
            'date'
        )
        ->whereIn('gps_id', $gps_ids)
        ->whereRaw('MONTH(date) = ?',[$month])
        ->sum('km');
    }

     /**
     * 
     * 
     */
    public function updateDailyKm($total_distance, $gps_id, $trip_date)
    {
        $daily_km = self::firstOrNew(array('gps_id' => $gps_id, 'date' => $trip_date));
        $daily_km->km = $total_distance;
        $daily_km->save();
    }
}

