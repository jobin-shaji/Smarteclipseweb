<?php

namespace App\Modules\DeviceReturn\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceReturn extends Model
{
	use SoftDeletes;    
	protected $fillable=[
		'id','return_code','gps_id','servicer_id','client_id','type_of_issues','status','comments','created_at','updated_at','deleted_at'
	];

	public function gpsReturnedCount($gps_id)
	{
		return self::select('id')->where('gps_id',$gps_id)->where('status',0)->count();
	}

	public function gpsReturnCodeCount($return_code)
	{
		return self::select('id')->where('return_code',$return_code)->count();
	}

	public function createNewDeviceForReturn($return_code,$gps_id,$type_of_issues,$comments,$servicer_id,$client_id)
	{
		return self::create([
			'return_code'       =>  $return_code,
			'gps_id'            =>  $gps_id,
			'type_of_issues'    =>  $type_of_issues,
			'comments'          =>  $comments,
			'status'            =>  0,
			'servicer_id'       =>  $servicer_id,
			'client_id'         =>  $client_id
		]);
	}

	public function gps()
	{
		return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
	}

	public function servicer()
	{
		return $this->hasOne('App\Modules\Servicer\Models\Servicer','id','servicer_id');
	}

	public function client()
	{
		return $this->hasOne('App\Modules\Client\Models\Client','id','client_id');
	}

	public function getDeviceReturnDetailsForRootList()
	{
		return self::select(
					'id', 
					'return_code',
					'gps_id',                      
					'type_of_issues',
					'comments',                                        
					'created_at',
					'servicer_id',
					'status',
					'deleted_at')
					->with('gps:id,imei,serial_no')
					->with('servicer:id,name,sub_dealer_id,trader_id')
					->orderBy('id','desc')
					->withTrashed()
					->get();
	}

	public function getDeviceReturnListBasedOnServiceEngineer($servicer_id)
	{
		return self::select(
			'id', 
			'return_code',    
			'gps_id',                      
			'type_of_issues',
			'comments',                                        
			'created_at',
			'servicer_id',
			'status',
			'deleted_at'
		)
		->withTrashed()
		->with('gps:id,imei,serial_no')
		->orderBy('id','desc')
		->where('servicer_id',$servicer_id)
		->get();
	}

	public function getSingleDeviceReturnDetails($device_return_id)
	{
		return self::select(
					'id', 
					'return_code',
					'gps_id',                      
					'type_of_issues',
					'status',
					'comments',                                        
					'client_id',
					'servicer_id',
					'created_at')
					->where('id',$device_return_id)
					->first();
	}

	public function getSingleDeviceReturnDetailsWithTrashedItem($device_return_id)
	{
		return self::select(
					'id', 
					'return_code',
					'gps_id',                      
					'type_of_issues',
					'status',
					'comments',                                        
					'client_id',
					'servicer_id',
					'created_at')
					->withTrashed()
					->where('id',$device_return_id)
					->first();
	}

	public function getDeviceReassignDetails($gps_id)
	{
		return self::select(
					'id', 
					'return_code',
					'gps_id',                      
					'type_of_issues',
					'comments',                                        
					'created_at',
					'servicer_id',
					'status')
					->where('gps_id',$gps_id)
					->with('gps:id,imei,serial_no')
					->with('servicer:id,name,sub_dealer_id,trader_id')
					->where('status', '!=' , 1)
					->orderBy('id','desc')
					->get();
	}

	public function isDeviceReturnRequested($gps_id)
	{
		return self::select('gps_id')
			->where('gps_id',$gps_id)
			->where('status', '!=' , 1)
			->count();
	}
    
}

