<?php
namespace App\Modules\Client\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Client extends Model
{
  use SoftDeletes;    
	protected $fillable=[
		'user_id','sub_dealer_id','name','address','created_by','deleted_by','deleted_at'
	];	
  

  //  public function subdealer()
  // {
  //   return $this->belongsTo('App\Modules\SubDealer\Models\SubDealer','sub_dealer_id','id');
  // } 

  public function user()
  {
    return $this->belongsTo('App\Modules\User\Models\User');
  }

  // // client
  // public function subDealer()
  // {
  //   return $this->hasOne('App\Modules\SubDealer\Models\SubDealer','id','sub_dealer_id');
  // }
}

