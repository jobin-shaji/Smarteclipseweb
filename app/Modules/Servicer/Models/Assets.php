<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
  
    protected $table='cd_assets';
    protected $fillable=['asset_code','name','description','status','total'];




}
