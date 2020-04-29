<?php
namespace App\Modules\Client\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Client extends Model
{
  use SoftDeletes; 

	protected $fillable=[
		'user_id','sub_dealer_id','name','address','latitude','longitude','created_by','deleted_by','deleted_at','country_id','state_id','city_id','trader_id','latest_user_updates',
    'location'];
    
  public function subdealer()
  {
    return $this->belongsTo('App\Modules\SubDealer\Models\SubDealer','sub_dealer_id','id')->withTrashed();
  } 

  public function trader()
  {
    return $this->belongsTo('App\Modules\Trader\Models\Trader','trader_id','id')->withTrashed();
  } 

  public function user()
  {
    return $this->belongsTo('App\Modules\User\Models\User')->withTrashed();
  }
  public function driver_points(){
      return $this->hasMany('App\Modules\Client\Models\ClientAlertPoint','client_id','id')
      ->whereIn('alert_type_id',[1,12,13,14,15,16]);
  }

  public function all_driver_points()
  {
    return $this->hasMany('App\Modules\Client\Models\ClientAlertPoint','client_id','id');
  }

  public function vehicles() 
  {
    return $this->hasMany('App\Modules\Vehicle\Models\Vehicle', 'client_id')->whereNull('deleted_at')->orderBy('id', 'desc');
  } 

  public function state()
  {
    return $this->hasOne('App\Modules\TrafficRules\Models\State','id','state_id');
  }

  public function country()
  {
    return $this->hasOne('App\Modules\TrafficRules\Models\Country','id','country_id');
  }

  public function city()
  {
    return $this->hasOne('App\Modules\TrafficRules\Models\City','id','city_id');
  }

  public function getClientDetailsWithClientId($client_id)
	{
		return self::where('id',$client_id)->first();
	}

  public function getClientDetails($user_id)
  {
    return self::select('user_id','latitude','longitude','location','name','address','city_id')->with('user:id,mobile,email')->with('city.state.country')->withTrashed()->where('user_id', $user_id)->first();
  }

  public function getDetailsOfClientsUnderSubDealer($sub_dealer_id)
  {
    return self::select('id','name')->where('sub_dealer_id',$sub_dealer_id)->orderBy('created_at', 'DESC')->get();
  }

  public function getDetailsOfClientsWithReturnedVehicleGpsUnderSubDealer($sub_dealer_id)
  {
    return DB::select("SELECT clients.id,clients.name FROM clients LEFT JOIN vehicles ON vehicles.client_id = clients.id
    WHERE vehicles.is_returned = 1 AND vehicles.is_reinstallation_job_created = 0 AND clients.sub_dealer_id = '$sub_dealer_id' GROUP BY clients.id");
  }

  public function getDetailsOfClientsUnderTrader($trader_id)
  {
    
    return self::select('id','name')->where('trader_id',$trader_id)->orderBy('created_at', 'DESC')->get();
  }

  public function getDetailsOfClientsWithReturnedVehicleGpsUnderTrader($trader_id)
  {
    return DB::select("SELECT clients.id,clients.name FROM clients LEFT JOIN vehicles ON vehicles.client_id = clients.id
    WHERE vehicles.is_returned = 1 AND vehicles.is_reinstallation_job_created = 0 AND clients.trader_id = '$trader_id' GROUP BY clients.id");
  }

  public function getDetailsOfAllClients()
  {
    return self::select('id','name')->orderBy('created_at', 'DESC')->get();
  }

  public function getDetailsOfClientsWithReturnedVehicleGps()
  {
    return DB::select("SELECT clients.id,clients.name FROM clients LEFT JOIN vehicles ON vehicles.client_id = clients.id
    WHERE vehicles.is_returned = 1 AND vehicles.is_reinstallation_job_created = 0  GROUP BY clients.id");
  }

  public function getClientsOfDealers($dealer_ids)
	{
		return self::select('id','user_id')->whereIn('sub_dealer_id',$dealer_ids)->whereNull('trader_id')->withTrashed()->get();
  }

  public function getClientsOfSubDealers($sub_dealer_ids)
	{
		return self::select('id','user_id')->whereIn('trader_id',$sub_dealer_ids)->whereNull('sub_dealer_id')->withTrashed()->get();
  }

  public function checkUserIdIsInClientTable($user_id)
  {
    return self::select('name')->where('user_id',$user_id)->first();
  }

  



  
}

