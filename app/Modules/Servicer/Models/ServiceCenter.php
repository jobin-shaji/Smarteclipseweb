<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCenter extends Model
{
    protected $fillable = ['name', 'address', 'location', 'country_id', 'state_id', 'city_id','latitude','longitude'];

    public function operations()
    {
        return $this->hasMany('App\Modules\Operations\Models\Operations','service_center_id','id');
    }
}
