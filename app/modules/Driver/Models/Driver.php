<?php

namespace App\Modules\Driver\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class Driver extends Model
{
   use SoftDeletes;    
	protected $fillable=[
		'name','address','mobile','client_id','points','deleted_at'
	];

	public function alerts(){
		return $this->hasMany('App\Modules\Driver\Models\DriverBehaviour');
	}

	public function validateDriver($driver_id)
	{
		return self::where('id',$driver_id)->first();
	}

	public function getDriverListBasedOnClient($client_id)
  {
    return self::select(
        'id',
        'name',
        'address',
        'mobile',
        'client_id',
        'points',
        'deleted_at'
      )
      ->withTrashed()
      ->where('client_id',$client_id)
      ->get();
  }

  /**
   * 
   * 
   */
  public function getDriverDetails($driver_id)
  {
    return self::withTrashed()->where('id',$driver_id)->first();
  }
}
