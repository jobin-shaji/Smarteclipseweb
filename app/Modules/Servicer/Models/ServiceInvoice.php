<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInvoice extends Model
{
    
    protected $fillable = ['servicein_id', 'amount', 'gst', 'total', 'status', 'payment_method', 'reference_number', 'reference_image'];
}
