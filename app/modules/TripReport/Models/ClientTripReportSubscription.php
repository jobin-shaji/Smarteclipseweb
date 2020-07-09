<?php

namespace  App\Modules\TripReport\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientTripReportSubscription extends Model
{
    protected $fillable=[
		'client_id','vehicle_id','configuration','start_date','end_date','configuration','last_generated_on'
    ];
    /**
     * vehicle
     */
    public function vehicles()
    {
      return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id');
    }
    /**
     * 
     * 
     */
    public function getVehicleTripConfigDetails($plan_type, $client_id)
    {
        $query  =   DB::table('client_trip_report_subscriptions as subscriptions')
                        ->join('clients', 'subscriptions.client_id', '=', 'clients.id')
                        ->join('users', 'users.id', '=', 'clients.user_id')
                        ->join('vehicles', 'subscriptions.vehicle_id', '=', 'vehicles.id')
                        ->select('subscriptions.configuration as configuration','subscriptions.start_date as start_date','subscriptions.end_date as end_date','clients.name as client_name',
                        'vehicles.name as vehicle_name','vehicles.register_number as veh_reg_no','users.role as role','subscriptions.id as id');
                        if($client_id != 'all')
                        {
                            $query->where(function($query) use($client_id){
                                $query = $query->where('subscriptions.client_id',$client_id);
                            });   
                        }
                        if($plan_type != null || $plan_type === 0)
                        {
                            $query->where(function($query) use($plan_type){
                                $query = $query->where('users.role',$plan_type);
                            }); 
                        }
        return $query->paginate(10);
    }

    public function clientVehcileTripReportConfiguration($client_id,$vehicle_id,$start_date,$end_date,$plan)
    {
        // dd($plan);
        return self::Create([
        'client_id'     => $client_id,
        'vehicle_id'    => $vehicle_id,
        'start_date'    => $start_date,     
        'end_date'      => $end_date,
        'configuration' => $plan     

      ]);
    }

    /**
     * vehicle configuration between dates
     */
    public function getClientConfiguration($client_id,$vehicle_id,$startDate,$toDate)
    {
        return self::where('client_id', $client_id)
        ->where('vehicle_id',$vehicle_id)
        ->with('vehicles:id,name')
        ->where(function($query) use ($startDate , $toDate) {
            $query->where(function($query) use ($startDate , $toDate) {
                $query->whereDate('start_date', '>=',$startDate);
                $query->whereDate('end_date', '<=', $toDate);
            })
            ->orWhere(function($query) use ($startDate , $toDate) {
                $query->whereDate('start_date', '<=',$startDate);
                $query->whereDate('end_date', '>=', $toDate);
            })
            ->orWhereBetween('start_date',[$startDate, $toDate])
            ->orWhereBetween('end_date',[$startDate, $toDate]);
        })
        ->get();
    }
    /** */
    public function deleteTripReportSubscription($id,$date)
    {
        return $query=self::where('id', $id)->whereDate('start_date', '>',$date)->whereDate('end_date', '>',$date)->count();
    }

    /**
     * 
     * @author  PMS
     * 
     */

     public function getSubscribedVehicles($date)
     {
        return self::with('vehicles:id,name,gps_id')
                    ->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date)
                    ->get();
     }

     /**
      * @author PMS
      */
     public function updateSubscriptionPlan($subscription_id,$data)
     {
        return self::where('id', $subscription_id)
                     ->update($data);
     }
    
}
