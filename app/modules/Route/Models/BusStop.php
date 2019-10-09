<?php

namespace App\Modules\Route\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusStop extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','route_id','latitude','longitude','client_id'
    ];

    public function route(){
        return $this->hasOne('App\Modules\Route\Models\Route','id','route_id');
    }

}
