<?php

namespace App\Modules\Ksrtc\Models;

use Illuminate\Database\Eloquent\Model;

class KsrtcCmcInvoice extends Model
{
    protected $table = 'abc_ksrtc_cmc_invoices';

    protected $fillable = [
        'period_id',
        'invoice_no',
        'invoice_date',
        'amount',
        'device_count',
        'file_path',
        'original_name',
    ];


    public function period()
    {
        return $this->belongsTo(KsrtcCmcPeriod::class, 'period_id');
    }
}
