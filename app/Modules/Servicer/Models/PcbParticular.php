<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcbParticular extends Model
{
    
    protected $table='cd_pcb_particulars';
    protected $fillable = ['pcb_in_id', 'product_id', 'qty', 'price', 'gross', 'tax', 'total', 'is_renewal', 'msisdn', 'imsi1', 'imsi2', 'comments'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
