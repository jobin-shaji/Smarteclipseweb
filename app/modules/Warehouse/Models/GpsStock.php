<?php

namespace App\Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class GpsStock extends Model
{
    use SoftDeletes;
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

}
