<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsEmployeeAssign extends Model
{

    protected $table='asset_employee_assign';
    protected $fillable = ['asset_id', 'employee_id'];

    
}
