<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Database\Eloquent\Factories\HasFactory;

class Otp extends Model
{
   

    protected $table='otps';
    protected $fillable=['mobile', 'otp','expires_at'];
    
}
