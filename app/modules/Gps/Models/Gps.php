<?php

namespace App\Modules\Gps\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class Gps extends Model
{
	use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    protected $fillable=[ 'name','imei','manufacturing_date','version','status'];

    //join user table with gps table
    public function dealer()
    {
    	return $this->belongsTo('App\Modules\Dealer\Models\Dealer','dealer_id');
    }
}
