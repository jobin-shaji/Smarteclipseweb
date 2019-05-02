<?php
namespace App\Modules\Client\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Client extends Model
{
  use SoftDeletes;    
	protected $fillable=[
		'user_id','sub_dealer_user_id','name','address','created_by','deleted_by','deleted_at'
	];	
  
   public function subdealer()
  {
    return $this->belongsTo('App\Modules\SubDealer\Models\SubDealer');
  } 
  public function user()
  {
    return $this->belongsTo('App\Modules\User\Models\User');
  }
}

