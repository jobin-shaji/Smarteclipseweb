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
        return $this->hasone('App\Modules\Dealer\Models\Dealer','id','dealer_id')->withTrashed();
    } 

    public function subdealer()
    {
        return $this->hasone('App\Modules\SubDealer\Models\SubDealer','id','subdealer_id')->withTrashed();
    } 

    public function client()
    {
        return $this->belongsTo('App\Modules\Client\Models\Client','client_id','id')->withTrashed();
    }

    public function trader()
    {
        return $this->belongsTo('App\Modules\Trader\Models\Trader','trader_id','id')->withTrashed();
    }

    public function user()
    {
        return $this->hasone('App\Modules\User\Models\User','id','inserted_by');
    }

    public function manufacturer()
    {
        return $this->hasone('App\Modules\Root\Models\Root','user_id','inserted_by');
    }

    public function deviceReturn()
    {
        return $this->hasone('App\Modules\DeviceReturn\Models\DeviceReturn','gps_id','gps_id')->where('status','!=',0);
    }

    public function getSingleGpsStockDetails($gps_id)
    {
        return self::select(
                    'id',
                    'gps_id',
                    'is_returned'
                    )
                    ->where('gps_id',$gps_id)
                    ->first();
    }
    
    public function createNewGpsInStock($gps_id,$root_id)
    {
        return  self::create([
                        'gps_id'                =>  $gps_id,
                        'inserted_by'           =>  $root_id,
                        'refurbished_status'    =>  1
                    ]); 
    }

}
