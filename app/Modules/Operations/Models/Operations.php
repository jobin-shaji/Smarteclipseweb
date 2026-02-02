<?php

namespace App\Modules\Operations\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operations extends Model
{
    use SoftDeletes;    
	protected $fillable=[
		'user_id','name','root_id','address','phone_number','email','status','service_center_id','created_by','deleted_by','deleted_at'
	];
	public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id','id')->withTrashed();
	}
	public function center()
    {
    	return $this->belongsTo('App\Modules\Servicer\Models\ServiceCenter','service_center_id','id');
	}

	/**
	 * 
	 * 
	 */
    public function root(){
        return $this->hasOne('App\Modules\Root\Models\Root', 'id', 'root_id');
    }
	
	/**
	 * 
	 * 
	 */
	public function getOperatorDetails($operator_id)
	{
		return self::select('id','name','root_id')->where('id',$operator_id)->with('root')->first();
	}
}
