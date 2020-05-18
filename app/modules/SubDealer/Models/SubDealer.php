<?php
namespace App\Modules\SubDealer\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SubDealer extends Model
{
  use SoftDeletes;    
	protected $fillable=[
		'user_id','dealer_id','name','address','status','created_by','deleted_by','deleted_at'
	];	
   
  // public function dealer()
  // {
  //   return $this->belongsTo('App\Modules\Dealer\Models\Dealer');
  // } 

  public function user()
  {
    return $this->belongsTo('App\Modules\User\Models\User')->withTrashed();
  }

  // dealer
  public function dealer()
  {
    return $this->hasOne('App\Modules\Dealer\Models\Dealer','id','dealer_id')->withTrashed();
  }

  public function clients(){
      return $this->hasMany('App\Modules\Client\Models\Client')->withTrashed();
  }

  public function traders(){
    return $this->hasMany('App\Modules\Trader\Models\Trader')->withTrashed();
  }

  public function getDealersOfDistributers($distributor_ids)
	{
		return self::select('id','user_id','name','dealer_id')->whereIn('dealer_id',$distributor_ids)->with('dealer')->withTrashed()->get();
  }

  public function checkUserIdIsInDealerTable($user_id)
	{
		return self::select('name')->where('user_id',$user_id)->first();
  }
  
  public function getDealerDetails($dealer_id)
	{
		return self::select('id','name','dealer_id')->where('id',$dealer_id)->with('dealer')->first();
	}
  
}

