<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceParticular extends Model
{
    
    protected $table='cd_service_particulars';
    protected $fillable = ['service_in_id', 'product_id', 'qty', 'price', 'gross', 'tax', 'total', 'is_renewal', 'msisdn', 'imsi1', 'imsi2', 'comments'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
