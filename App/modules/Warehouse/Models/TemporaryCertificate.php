<?php

namespace App\Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryCertificate extends Model
{
    protected $fillable=[ 'user_id','details','is_active'];
}
