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
	
	 // // users of a depot
  // public function dealer()
  // {
  //      return $this->belongsToMany('\App\Modules\Dealer\Models\Dealer','sub_dealers','user_id','dealer_id')->withPivot('id');
  // }

    public function dealer()
    {
    	return $this->hasOne('App\Modules\Dealer\Models\Dealer','user_id','dealer_id');
    }




}
