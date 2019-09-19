<?php
namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleGps extends Model
{
    protected $fillable=['vehicle_id','gps_id','user_id'];

    // gps
    public function gps(){
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id')->withTrashed();
    }
     public function vehicle(){
        return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id')->withTrashed();
    }
}
