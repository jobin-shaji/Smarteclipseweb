<?php

namespace App\Modules\Ksrtc\Models;

use Illuminate\Database\Eloquent\Model;

class KsrtcCmcPeriod extends Model
{
    protected $table = 'abc_ksrtc_cmc_periods';

    protected $fillable = [
        'client_id',
        'period_start',
        'period_end',
        'title',
    ];

    public function invoices()
    {
        return $this->hasMany(KsrtcCmcInvoice::class, 'period_id');
    }
}
