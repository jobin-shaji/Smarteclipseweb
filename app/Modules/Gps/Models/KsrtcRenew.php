<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class KsrtcRenew extends Model
{
   
    protected $table='ksrtc_renew';
    protected $fillable=[ 
        'cmc_id', 
        'from_date', 
        'to_date',
        'total_amount',
        'gst_amount',
        'order_id',
        'ordid'
        ];
    
}
