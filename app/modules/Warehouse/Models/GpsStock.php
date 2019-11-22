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

    protected $fillable=[ 'gps_id','inserted_by','dealer_id','subdealer_id','client_id'];

    // gps 
    public function gps(){
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id')->withTrashed();
    }

    public function dealer()
    {
        return $this->hasone('App\Modules\Dealer\Models\Dealer','id','dealer_id');
    } 

    public function subdealer()
    {
        return $this->hasone('App\Modules\SubDealer\Models\SubDealer','id','subdealer_id');
    } 

    public function client()
    {
        return $this->hasone('App\Modules\Client\Models\Client','id','client_id');
    }
    public function user()
    {
        return $this->hasone('App\Modules\User\Models\User','id','inserted_by');
    }

}
