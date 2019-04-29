<?php

namespace App\Modules\SubDealer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SubDealer extends Model
{
   use SoftDeletes;
    
	protected $fillable=[
		'user_id','dealer_id','name','address','phone_number','email','status','created_by','deleted_by','deleted_at'
	];
	
    // public function dealer()
    // {
    // 	return $this->belongsTo('App\Modules\Dealer\Models\Dealer','dealer_id','user_id');
    // }
     public function dealer()
    {
      return $this->hasone('App\Modules\Dealer\Models\Dealer','user_id','dealer_id');
    }
    public function user()
    {
      return $this->belongsTo('App\Modules\User\Models\User','user_id','id');
    }





}
