<?php

namespace App\Modules\Sales\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salesman extends Model
{
    use SoftDeletes;    
	protected $fillable=[
		'user_id','name','root_id','address','phone_number','email','status','created_by','deleted_by','deleted_at'
    ];
    public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id','id')->withTrashed();
  }
  
  /**
   * getSalesmanDetails
   */
  public function getSalesmanDetails($salesman_id)
	{
		return self::select('id','name','root_id')->where('id',$salesman_id)->with('root')->first();
  }
   /**
   * root id
   */
  public function root()
  {
    return $this->hasOne('App\Modules\Root\Models\Root','id','root_id');
  }

}
