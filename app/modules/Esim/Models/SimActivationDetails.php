<?php
namespace App\Modules\Esim\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon AS Carbon;

class SimActivationDetails extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'imei','gps_id','msisdn','iccid','imsi','puk','activated_on','expire_on','business_unit_name','product_status'
	];
	public function updateEsimDetails($esim_details)
	{
		return self::create([
			"imei"					=> (isset($esim_details->imsi)) ? $esim_details->imsi :"",
			"gps_id"				=> 1,
			"msisdn"				=> (isset($esim_details->msisdn)) ? $esim_details->msisdn :"",
			"iccid"					=> (isset($esim_details->iccid)) ? $esim_details->iccid :"",
			"imsi"					=> (isset($esim_details->imsi)) ? $esim_details->imsi : "" ,
			"puk"					=> (isset($esim_details->puk)) ? $esim_details->puk :"",
			"product_type"			=> (isset($esim_details->product_type)) ? $esim_details->product_type :"",
			"activated_on"			=> (isset($esim_details->activation_date)) ? Carbon::parse($esim_details->activation_date)->format('Y-m-d') : null,
			"expire_on"				=> (isset($esim_details->activation_date)) ? Carbon::parse((Carbon::parse($esim_details->activation_date)->format('Y-m-d')))->addYear() : null,
			"business_unit_name"	=> (isset($esim_details->business_unit_name)) ? $esim_details->business_unit_name :"",
			"product_status"		=> (isset($esim_details->product_status)) ? $esim_details->product_status :""
		]);
	}
	public function getSimActivationList()
	{
		return self::select(
			'id',
			'imei',
			'msisdn',
			'iccid',
			'imsi',
			'puk',
			'product_type',
			'activated_on',
			'expire_on',
			'business_unit_name',
			'product_status'
		)->paginate(20);
	}
	public function getSimActivationDetails($id)
	{
		return self::select(
			'id',
			'imei',
			'msisdn',
			'iccid',
			'imsi',
			'puk',
			'product_type',
			'activated_on',
			'expire_on',
			'business_unit_name',
			'product_status',
			'gps_id'
		)
		->with('gps')
		->first();
	}

	public function gps()
    {
      return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id')->withTrashed();
    }
}
