<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class KsrtcCmc extends Model
{
   
    protected $table='ksrtc_cmc';
    protected $fillable=[ 
        'total_gps', 
        'gps_ids', 
        'imeis',
        'vehicle_nos',
        'validity_date', 
        'renew_date', 
        'is_renewd', 
        ];
    
}
