<?php
namespace App\Modules\Dealer\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Dealer extends Model
{
    use SoftDeletes;    
	protected $fillable=[
		'user_id','name','root_id','address','phone_number','email','status','created_by','deleted_by','deleted_at'
	];
	// users of a depot
	public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id','id')->withTrashed();
    }

    // root
  	public function root()
  	{
    	return $this->hasOne('App\Modules\Root\Models\Root','id','root_id');
  	}

    public function subDealers(){
      return $this->hasMany('App\Modules\SubDealer\Models\SubDealer');
	}
	
	public function getDistributorsOfManufacturer($manufacturer_id)
	{
		return self::select('id','user_id')->whereIn('root_id',$manufacturer_id)->withTrashed()->get();
	}

	public function checkUserIdIsInDistributorTable($user_id)
	{
		return self::select('name')->where('user_id',$user_id)->first();
	}

    
}
