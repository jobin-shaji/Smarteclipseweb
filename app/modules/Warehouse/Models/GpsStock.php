<?php

namespace App\Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;
use DB;

class GpsStock extends Model
{
    use SoftDeletes;
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    protected $fillable=[ 'gps_id','inserted_by','dealer_id','subdealer_id','client_id','refurbished_status'];

    // gps 
    public function gps(){
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id')->withTrashed();
    }

    public function dealer()
    {
        return $this->hasone('App\Modules\Dealer\Models\Dealer','id','dealer_id')->withTrashed();
    } 

    public function subdealer()
    {
        return $this->hasone('App\Modules\SubDealer\Models\SubDealer','id','subdealer_id')->withTrashed();
    } 

    public function client()
    {
        return $this->belongsTo('App\Modules\Client\Models\Client','client_id','id')->withTrashed();
    }

    public function trader()
    {
        return $this->belongsTo('App\Modules\Trader\Models\Trader','trader_id','id')->withTrashed();
    }

    public function user()
    {
        return $this->hasone('App\Modules\User\Models\User','id','inserted_by');
    }

    public function manufacturer()
    {
        return $this->hasone('App\Modules\Root\Models\Root','user_id','inserted_by');
    }

    public function root()
    {
        return $this->hasone('App\Modules\Root\Models\Root','id','inserted_by');
    }

    public function deviceReturn()
    {
        return $this->hasone('App\Modules\DeviceReturn\Models\DeviceReturn','gps_id','gps_id')->where('status','!=',0);
    }

    public function getSingleGpsStockDetails($gps_id)
    {
        return self::select(
                    'id',
                    'gps_id',
                    'is_returned',
                    'returned_on'
                    )
                    ->where('gps_id',$gps_id)
                    ->first();
    }
    
    public function createRefurbishedGpsInStock($gps_id,$root_id)
    {
        return  self::create([
                        'gps_id'                =>  $gps_id,
                        'inserted_by'           =>  $root_id,
                        'refurbished_status'    =>  1
                    ]); 
    }

    public function getReturnedDeviceCountOfManufacturer($manufacturer_id,$from_date,$to_date)
    {
        return DB::table('gps_stocks')
                    ->leftJoin('roots', 'roots.id', '=', 'gps_stocks.inserted_by')
                    ->leftJoin('clients', 'clients.id', '=', 'gps_stocks.client_id')
                    ->leftJoin('dealers', 'dealers.id', '=', 'gps_stocks.dealer_id')
                    ->leftJoin('sub_dealers', 'sub_dealers.id', '=','gps_stocks.subdealer_id')
                    ->leftJoin('traders', 'traders.id', '=', 'gps_stocks.trader_id')
                    ->whereNull('gps_stocks.deleted_at')
                    ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                    ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                    ->where('gps_stocks.inserted_by', $manufacturer_id)
                    ->where('gps_stocks.is_returned', 1)
                    ->groupBy('gps_stocks.client_id')
                    ->select('roots.name as manufacturer_name',
                    'dealers.name as distributor_name',
                    'sub_dealers.name as dealer_name',
                    'traders.name as sub_dealer_name',
                    'clients.name as client_name',
                    DB::raw('COUNT(gps_stocks.gps_id) as count'))->get();
    }

    public function getReturnedDeviceDetailsOfManufacturer($manufacturer_id, $from_date, $to_date, $search_key,$download_type)
    {
        $query  =   DB::table('gps_stocks')
                        ->leftJoin('roots', 'roots.id', '=', 'gps_stocks.inserted_by')
                        ->leftJoin('clients', 'clients.id', '=', 'gps_stocks.client_id')
                        ->leftJoin('dealers', 'dealers.id', '=', 'gps_stocks.dealer_id')
                        ->leftJoin('sub_dealers', 'sub_dealers.id', '=','gps_stocks.subdealer_id')
                        ->leftJoin('traders', 'traders.id', '=', 'gps_stocks.trader_id')
                        ->leftJoin('gps', 'gps.id', '=', 'gps_stocks.gps_id')
                        ->leftJoin('device_returns', 'device_returns.gps_id', '=', 'gps_stocks.gps_id')
                        ->leftJoin('servicers', 'servicers.id', '=', 'device_returns.servicer_id')
                        ->whereNull('gps_stocks.deleted_at')
                        ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                        ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                        ->where('gps_stocks.inserted_by', $manufacturer_id)
                        ->where('gps_stocks.is_returned', 1)
                        ->groupBy('gps_stocks.gps_id')
                        ->orderBy('gps_stocks.returned_on','desc')
                        ->select('roots.name as manufacturer_name',
                        'dealers.name as distributor_name',
                        'sub_dealers.name as dealer_name',
                        'traders.name as sub_dealer_name',
                        'clients.name as client_name',
                        'gps.imei as imei',
                        'gps.serial_no as serial_number',
                        'servicers.name as servicer_name',
                        DB::raw('DATE_FORMAT(gps_stocks.returned_on, "%Y-%m-%d") as returned_on'));
                        if( $search_key != null )
                        {
                            $query->where(function($query) use($search_key){
                                $query = $query->whereDate('gps_stocks.returned_on','like','%'.$search_key.'%')
                                            ->orWhere('gps.serial_no','like','%'.$search_key.'%')
                                            ->orWhere('gps.imei','like','%'.$search_key.'%')
                                            ->orWhere('roots.name','like','%'.$search_key.'%')
                                            ->orWhere('dealers.name','like','%'.$search_key.'%')
                                            ->orWhere('sub_dealers.name','like','%'.$search_key.'%')
                                            ->orWhere('traders.name','like','%'.$search_key.'%')
                                            ->orWhere('clients.name','like','%'.$search_key.'%')
                                            ->orWhere('servicers.name','like','%'.$search_key.'%');
                            });  
                        }
        if($download_type == null)  
        {
            return $query->paginate(5);
        }
        else
        {
            return $query->get();
        }
        
    }

    public function getReturnedDeviceCountOfDistributor($distributor_id,$from_date,$to_date)
    {
        return DB::table('gps_stocks')
                    ->leftJoin('clients', 'clients.id', '=', 'gps_stocks.client_id')
                    ->leftJoin('dealers', 'dealers.id', '=', 'gps_stocks.dealer_id')
                    ->leftJoin('sub_dealers', 'sub_dealers.id', '=','gps_stocks.subdealer_id')
                    ->leftJoin('traders', 'traders.id', '=', 'gps_stocks.trader_id')
                    ->whereNull('gps_stocks.deleted_at')
                    ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                    ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                    ->where('gps_stocks.dealer_id', $distributor_id)
                    ->where('gps_stocks.is_returned', 1)
                    ->groupBy('gps_stocks.client_id')
                    ->select('dealers.name as distributor_name',
                    'sub_dealers.name as dealer_name',
                    'traders.name as sub_dealer_name',
                    'clients.name as client_name',
                    DB::raw('COUNT(gps_stocks.gps_id) as count'))->get();
    }

    public function getReturnedDeviceDetailsOfDistributor($distributor_id, $from_date, $to_date, $search_key,$download_type)
    {
        $query  =   DB::table('gps_stocks')
                        ->leftJoin('clients', 'clients.id', '=', 'gps_stocks.client_id')
                        ->leftJoin('dealers', 'dealers.id', '=', 'gps_stocks.dealer_id')
                        ->leftJoin('sub_dealers', 'sub_dealers.id', '=','gps_stocks.subdealer_id')
                        ->leftJoin('traders', 'traders.id', '=', 'gps_stocks.trader_id')
                        ->leftJoin('gps', 'gps.id', '=', 'gps_stocks.gps_id')
                        ->leftJoin('device_returns', 'device_returns.gps_id', '=', 'gps_stocks.gps_id')
                        ->leftJoin('servicers', 'servicers.id', '=', 'device_returns.servicer_id')
                        ->whereNull('gps_stocks.deleted_at')
                        ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                        ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                        ->where('gps_stocks.dealer_id', $distributor_id)
                        ->where('gps_stocks.is_returned', 1)
                        ->groupBy('gps_stocks.gps_id')
                        ->orderBy('gps_stocks.returned_on','desc')
                        ->select('dealers.name as distributor_name',
                        'sub_dealers.name as dealer_name',
                        'traders.name as sub_dealer_name',
                        'clients.name as client_name',
                        'gps.imei as imei',
                        'gps.serial_no as serial_number',
                        'servicers.name as servicer_name',
                        DB::raw('DATE_FORMAT(gps_stocks.returned_on, "%Y-%m-%d") as returned_on'));
                        if( $search_key != null )
                        {
                            $query->where(function($query) use($search_key){
                                $query = $query->whereDate('gps_stocks.returned_on','like','%'.$search_key.'%')
                                            ->orWhere('gps.serial_no','like','%'.$search_key.'%')
                                            ->orWhere('gps.imei','like','%'.$search_key.'%')
                                            ->orWhere('dealers.name','like','%'.$search_key.'%')
                                            ->orWhere('sub_dealers.name','like','%'.$search_key.'%')
                                            ->orWhere('traders.name','like','%'.$search_key.'%')
                                            ->orWhere('clients.name','like','%'.$search_key.'%')
                                            ->orWhere('servicers.name','like','%'.$search_key.'%');
                            });  
                        }  
        if($download_type == null)  
        {
            return $query->paginate(5);
        }
        else
        {
            return $query->get();
        }
    }

    public function getReturnedDeviceCountOfDealer($dealer_id,$from_date,$to_date)
    {
        return DB::table('gps_stocks')
                    ->leftJoin('clients', 'clients.id', '=', 'gps_stocks.client_id')
                    ->leftJoin('sub_dealers', 'sub_dealers.id', '=','gps_stocks.subdealer_id')
                    ->leftJoin('traders', 'traders.id', '=', 'gps_stocks.trader_id')
                    ->whereNull('gps_stocks.deleted_at')
                    ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                    ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                    ->where('gps_stocks.subdealer_id', $dealer_id)
                    ->where('gps_stocks.is_returned', 1)
                    ->groupBy('gps_stocks.client_id')
                    ->select('sub_dealers.name as dealer_name',
                    'traders.name as sub_dealer_name',
                    'clients.name as client_name',
                    DB::raw('COUNT(gps_stocks.gps_id) as count'))->get();
    }

    public function getReturnedDeviceDetailsOfDealer($dealer_id, $from_date, $to_date, $search_key,$download_type)
    {
        $query  =   DB::table('gps_stocks')
                        ->leftJoin('clients', 'clients.id', '=', 'gps_stocks.client_id')
                        ->leftJoin('sub_dealers', 'sub_dealers.id', '=','gps_stocks.subdealer_id')
                        ->leftJoin('traders', 'traders.id', '=', 'gps_stocks.trader_id')
                        ->leftJoin('gps', 'gps.id', '=', 'gps_stocks.gps_id')
                        ->leftJoin('device_returns', 'device_returns.gps_id', '=', 'gps_stocks.gps_id')
                        ->leftJoin('servicers', 'servicers.id', '=', 'device_returns.servicer_id')
                        ->whereNull('gps_stocks.deleted_at')
                        ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                        ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                        ->where('gps_stocks.subdealer_id', $dealer_id)
                        ->where('gps_stocks.is_returned', 1)
                        ->groupBy('gps_stocks.gps_id')
                        ->orderBy('gps_stocks.returned_on','desc')
                        ->select('sub_dealers.name as dealer_name',
                        'traders.name as sub_dealer_name',
                        'clients.name as client_name',
                        'gps.imei as imei',
                        'gps.serial_no as serial_number',
                        'servicers.name as servicer_name',
                        DB::raw('DATE_FORMAT(gps_stocks.returned_on, "%Y-%m-%d") as returned_on'));
                        if( $search_key != null )
                        {
                            $query->where(function($query) use($search_key){
                                $query = $query->whereDate('gps_stocks.returned_on','like','%'.$search_key.'%')
                                            ->orWhere('gps.serial_no','like','%'.$search_key.'%')
                                            ->orWhere('gps.imei','like','%'.$search_key.'%')
                                            ->orWhere('sub_dealers.name','like','%'.$search_key.'%')
                                            ->orWhere('traders.name','like','%'.$search_key.'%')
                                            ->orWhere('clients.name','like','%'.$search_key.'%')
                                            ->orWhere('servicers.name','like','%'.$search_key.'%');
                            });  
                        }  
        if($download_type == null)  
        {
            return $query->paginate(5);
        }
        else
        {
            return $query->get();
        }
    }

    public function getReturnedDeviceCountOfSubDealer($trader_id,$from_date,$to_date)
    {
        return DB::table('gps_stocks')
                    ->leftJoin('clients', 'clients.id', '=', 'gps_stocks.client_id')
                    ->leftJoin('traders', 'traders.id', '=', 'gps_stocks.trader_id')
                    ->whereNull('gps_stocks.deleted_at')
                    ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                    ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                    ->where('gps_stocks.trader_id', $trader_id)
                    ->where('gps_stocks.is_returned', 1)
                    ->groupBy('gps_stocks.client_id')
                    ->select('traders.name as sub_dealer_name',
                    'clients.name as client_name',
                    DB::raw('COUNT(gps_stocks.gps_id) as count'))->get();
    }

    public function getReturnedDeviceDetailsOfSubDealer($trader_id, $from_date, $to_date, $search_key,$download_type)
    {
        $query  =   DB::table('gps_stocks')
                        ->leftJoin('clients', 'clients.id', '=', 'gps_stocks.client_id')
                        ->leftJoin('traders', 'traders.id', '=', 'gps_stocks.trader_id')
                        ->leftJoin('gps', 'gps.id', '=', 'gps_stocks.gps_id')
                        ->leftJoin('device_returns', 'device_returns.gps_id', '=', 'gps_stocks.gps_id')
                        ->leftJoin('servicers', 'servicers.id', '=', 'device_returns.servicer_id')
                        ->whereNull('gps_stocks.deleted_at')
                        ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                        ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                        ->where('gps_stocks.trader_id', $trader_id)
                        ->where('gps_stocks.is_returned', 1)
                        ->groupBy('gps_stocks.gps_id')
                        ->orderBy('gps_stocks.returned_on','desc')
                        ->select('traders.name as sub_dealer_name',
                        'clients.name as client_name',
                        'gps.imei as imei',
                        'gps.serial_no as serial_number',
                        'servicers.name as servicer_name',
                        DB::raw('DATE_FORMAT(gps_stocks.returned_on, "%Y-%m-%d") as returned_on'));
                        if( $search_key != null )
                        {
                            $query->where(function($query) use($search_key){
                                $query = $query->whereDate('gps_stocks.returned_on','like','%'.$search_key.'%')
                                            ->orWhere('gps.serial_no','like','%'.$search_key.'%')
                                            ->orWhere('gps.imei','like','%'.$search_key.'%')
                                            ->orWhere('traders.name','like','%'.$search_key.'%')
                                            ->orWhere('clients.name','like','%'.$search_key.'%')
                                            ->orWhere('servicers.name','like','%'.$search_key.'%');
                            });  
                        }  
        if($download_type == null)  
        {
            return $query->paginate(5);
        }
        else
        {
            return $query->get();
        }
    }

    public function getReturnedDeviceManufactureDate($manufacturer_id,$from_date,$to_date)
    {
        return DB::table('gps_stocks')
                    ->leftJoin('gps', 'gps.id', '=', 'gps_stocks.gps_id')
                    ->whereDate('gps_stocks.returned_on', '>=' , $from_date)
                    ->whereDate('gps_stocks.returned_on', '<=' , $to_date)
                    ->where('gps_stocks.inserted_by', $manufacturer_id)
                    ->where('gps_stocks.is_returned', 1)
                    ->groupBy('gps.manufacturing_date')
                    ->orderBy(DB::raw('COUNT(gps_stocks.gps_id)'),'desc')
                    ->select('gps.manufacturing_date as manufacturing_date',
                    DB::raw('COUNT(gps_stocks.gps_id) as count'))->get();
    }

}
