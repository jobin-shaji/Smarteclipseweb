<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GpsWarranty extends Model
{
    use SoftDeletes;

    protected $fillable=[ 
        'gps_id',
        'period_from',
        'period_to',
        'expired_on',
        'expired_reason'
    ];

    public function gps()
    {
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
}
