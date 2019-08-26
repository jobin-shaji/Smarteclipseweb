<?php
namespace App\Modules\Client\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Client extends Model
{
  use SoftDeletes;    
	protected $fillable=[
		'user_id','sub_dealer_id','name','address','latitude','longitude','created_by','deleted_by','deleted_at','country_id','state_id','city_id'
	];	  
  public function subdealer()
  {
    return $this->belongsTo('App\Modules\SubDealer\Models\SubDealer','sub_dealer_id','id')->withTrashed();
  } 
  public function user()
  {
    return $this->belongsTo('App\Modules\User\Models\User')->withTrashed();
  }
  public function driver_points(){
      return $this->hasMany('App\Modules\Client\Models\ClientAlertPoint','client_id','id')
      ->whereIn('alert_type_id',[1,12,13,14,15,16]);
  }

  public function all_driver_points(){
      return $this->hasMany('App\Modules\Client\Models\ClientAlertPoint','client_id','id');
  }
  // // client
  // public function subDealer()
  // {
  //   return $this->hasOne('App\Modules\SubDealer\Models\SubDealer','id','sub_dealer_id');
  // }

  
}

