<?php
namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleGps extends Model
{
    protected $fillable=['vehicle_id','gps_id','user_id'];

}
