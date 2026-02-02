<?php

namespace App\Modules\Servicer\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Servicer extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'sales_id','address','status','type','user_id','sub_dealer_id','trader_id'
    ];

    public function sales()
      {
        return $this->belongsTo('App\Modules\Sales\Models\Salesman','id','id')->withTrashed();
      }
    public function user()
    {
    return $this->belongsTo('App\Modules\User\Models\User')->withTrashed();
    }

    // with sub dealer table
    public function subDealer()
    {
        return $this->hasOne('App\Modules\SubDealer\Models\SubDealer','id','sub_dealer_id')->withTrashed();
    }

    // with sub dealer table
    public function Trader()
    {
        return $this->hasOne('App\Modules\Trader\Models\Trader','id','trader_id')->withTrashed();
    }

    public function getServicerDetails($servicer_id)
	{
		return self::select('name')->where('id',$servicer_id)->first();
    }
    
    public function devices(){
		return $this->hasMany('App\Modules\Servicer\Models\UserDevice');
	}


}
