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
  public function dealer()
  {
  	return $this->belongsTo('App\Modules\Dealer\Models\Dealer');
  }  
  public function user()
  {
    return $this->belongsTo('App\Modules\User\Models\User');
  }
}

