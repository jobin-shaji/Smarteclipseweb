<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Esim extends Model
{
   
    protected $table='esim1';
    protected $fillable=['ICCID', 
        'Primary_TSP_MSISDN', 
        'Fallback_TSP_MSISDN', 
        'Primary_TSP_Name', 
        'Fallback_TSP_Name', 
        'Primary_TSP_Validity', 
        'Fallback_TSP_Validity'];
    
}
