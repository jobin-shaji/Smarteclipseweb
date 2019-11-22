<?php
namespace App\Modules\Ota\Models;
use Illuminate\Database\Eloquent\Model;
class OtaUpdates extends Model
{
    protected $fillable = [
        'gps_id', 'header','value','device_time'
    ]; 
}
