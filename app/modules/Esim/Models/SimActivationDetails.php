<?php
namespace App\Modules\Esim\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon AS Carbon;

class SimActivationDetails extends Model
{
    use SoftDeletes;   

	protected $fillable=[
		'imei','gps_id','msisdn','iccid','imsi','puk','activated_on','expire_on','business_unit_name','product_status','product_type'
	];
	public function updateEsimDetails($esim_details,$gps_details)
	{
		 $result=self::select(
			'id',
			'imei',
			'gps_id'
		)
		->where('gps_id',$gps_details->id)
		->count();
		if($result==0)
		{
			return self::create([
				"imei"					=> (isset($gps_details->imei)) ? $gps_details->imei :"",
				"gps_id"				=> (isset($gps_details->id)) ? $gps_details->id :"",
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
		else{
			return self::where('gps_id',$gps_details->id)->update([
				"imei"					=> (isset($gps_details->imei)) ? $gps_details->imei :"",
				"gps_id"				=> (isset($gps_details->id)) ? $gps_details->id :"",
				"msisdn"				=> (isset($esim_details->msisdn)) ? $esim_details->msisdn :"",
				"iccid"					=> (isset($esim_details->iccid)) ? $esim_details->iccid :"",
				"imsi"					=> (isset($esim_details->imsi)) ? $esim_details->imsi : "" ,
				"puk"					=> (isset($esim_details->puk)) ? $esim_details->puk :"",
				"product_type"			=> (isset($esim_details->product_type)) ? $esim_details->product_type :"",
				"activated_on"			=> (isset($esim_details->activation_date)) ? Carbon::parse($esim_details->activation_date)->format('Y-m-d') : null,
				"expire_on"				=> (isset($esim_details->activation_date)) ? Carbon::parse((Carbon::parse($esim_details->activation_date)->format('Y-m-d')))->addYear() : null,
				"business_unit_name"	=> (isset($esim_details->business_unit_name)) ? $esim_details->business_unit_name :"",
				"product_status"		=> (isset($esim_details->product_status)) ? $esim_details->product_status :""				
			]) ;       
		}
		
	}
	public function getSimActivationList($search_key=null,$from_date=null,$to_date=null,$download_type=null)
	{
		$result =  self::select(
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
		->with('gps');
		if( $search_key != null )
		{
			$result->where(function($query) use($search_key){
				$result = $query->Where('imei','like','%'.$search_key.'%')
				->orWhere('msisdn','like','%'.$search_key.'%')
				->orWhere('iccid','like','%'.$search_key.'%');                
			});  
		} 
		if($from_date != null && $to_date != null)
		{
			$result = $result->whereDate('expire_on', '>=', $from_date)
			->whereDate('expire_on', '<=', $to_date);   
		}
		if($download_type == null)  
        {
            return $result->paginate(10);
        }
        else
        {
            return $result->get();
        }
		// return $result->paginate(10);
	}
	public function getSimActivationgps_idDetails($id)
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
		->where('id',$id)
		->first();
	}

	public function gps()
    {
      return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id')->withTrashed();
	}
	public function compareEsimDetails($esim_details)
	{
		return self::select(
			'msisdn',
			'iccid',
			'imsi',
			'puk'
		)
		->where('msisdn',$esim_details->msisdn)
		->where('imsi',$esim_details->imsi)
		->first();
		
	}

	public function roleBasedCount()
	{
	
		$query = "SELECT 
        us.role,
        COUNT(sad.id) as count
        FROM `sim_activation_details` AS sad
        INNER JOIN vehicles as v ON v.gps_id = sad.gps_id
        INNER JOIN clients as cl ON cl.id = v.client_id
        INNER JOIN users as us ON us.id = cl.user_id
        GROUP BY us.role";
		return DB::select($query);
	}
}
