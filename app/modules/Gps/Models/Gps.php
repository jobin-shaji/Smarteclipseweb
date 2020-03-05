<?php

namespace App\Modules\Gps\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class Gps extends Model
{
	use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    // protected $encryptable = [
    //     'code',
    //     'keys',
    //     'allergies'
    // ];

    protected $fillable=[ 'serial_no','icc_id','imsi','imei','manufacturing_date','e_sim_number','batch_number','model_name','version','user_id','status','device_time','employee_code'];

    //join user table with gps table
    public function user()
    {
        return $this->belongsTo('App\Modules\User\Models\User','user_id');
    }

    public function transfers()
    {
        return $this->hasMany('App\Modules\Gps\Models\GpsTransfer');
    }
    

    public function gpsdata()
    {
        return $this->hasMany('App\Modules\Gps\Models\GpsData','gps_id','id')->orderBy('id', 'desc');
    }

    // vehicle gps
    public function vehicle(){
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','id')->withTrashed();
    }

    public function employee(){
        return $this->hasOne('App\Modules\Employee\Models\Employee','id','employee_code')->withTrashed();
    }

    public function gpsStock()
    {
        return $this->hasOne('App\Modules\Warehouse\Models\GpsStock','gps_id','id');
    }

    public function ota()
    {
        return $this->hasMany('App\Modules\Ota\Models\OtaUpdates','gps_id','id');
    }
    /**
     * 
     * 
     * 
     */
    public function getEmergencyalerts()
    {
        return self::select('emergency_status','tilt_status','id','lat','lon','imei','serial_no','e_sim_number')
                    ->with('vehicle','vehicle.client')
                    ->where('emergency_status',1)
                    ->orWhere('tilt_status',1)
                    ->get();
    }

    /**
     * 
     * 
     * 
     */
    public function getTransferredGpsDetails($transferred_gps_device_ids, $search_key = '')
    {
        $query = self::select('imei','serial_no','icc_id','imsi','version','e_sim_number','batch_number','employee_code','model_name','is_returned');
        if($search_key != '')
        {
            $query = $query->where('imei','LIKE','%'.$search_key."%");
        }
        return $query->whereIn('id',$transferred_gps_device_ids)->paginate(10);
    }

    /**
     * 
     * 
     */
    public function getImeiList()
    {
        return self::select('imei', 'serial_no')->get();
    }
    /**
     * 
     * 
     */
    public function getGpsId($imei)
    {
        return self::select('id')->where('imei',$imei)->first();
    }
}
