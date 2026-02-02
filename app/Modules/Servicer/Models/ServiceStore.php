<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceStore extends Model
{

     
    protected $table='cd_stores';
    protected $fillable = ['name', 'address', 'location', 'country_id', 'state_id', 'city_id','latitude','longitude'];

   }
