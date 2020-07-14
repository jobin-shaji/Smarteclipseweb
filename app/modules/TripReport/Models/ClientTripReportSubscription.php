<?php

namespace  App\Modules\TripReport\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class ClientTripReportSubscription extends Model
{
    protected $fillable=[
		'client_id','subscription_id','configuration','start_date','end_date','configuration','number_of_vehicles','number_of_reports_generated'
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
                        ->orderBy('id','desc')
                        ->select(
                            'subscriptions.configuration as configuration',
                            'subscriptions.start_date as start_date',
                            'subscriptions.end_date as end_date',
                            'clients.name as client_name',
                            'users.role as role',
                            'subscriptions.id as id',
                            'subscriptions.subscription_id',
                            'subscriptions.number_of_vehicles',
                            'subscriptions.number_of_reports_generated'

                        );
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

    public function saveTripReportSubscription($client_id,$subscription_start_date,$subscription_end_date,$total_number_of_report,$subscribed_vehicle_count,$plan)
    {

        return self::Create([
        'client_id'                   => $client_id,
        'subscription_id'             => "TRP".date('ymdhms').''.mt_rand(10,99),
        'start_date'                  => $subscription_start_date,     
        'end_date'                    => $subscription_end_date,
        'number_of_vehicles'          => $subscribed_vehicle_count ,
        'number_of_reports_generated' => $total_number_of_report,
        'configuration'               => $plan 
      ]);
    }

    /**
     * vehicle configuration between dates
     * 
     */
    public function getClientConfiguration($request)
    {
        return self::where('client_id', $request->client_id)
                    ->where('number_of_vehicles', $request->number_of_vehicle)
                    ->where('start_date', date('Y-m-d',strtotime($request->start_date)))
                    ->where('end_date', date('Y-m-d',strtotime($request->end_date)))
                    ->get();
    }
    /** */
    public function deleteTripReportSubscription($id)
    {
        return self::find($id);
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

     public function getTripSubscription($id)
     {
        return self::find($id);

     }

     /**
      * @author PMS
      */
     public function updateSubscriptionPlan($subscription_id,$data)
     {
        return self::where('id', $subscription_id)
                     ->update($data);
     }

     /**
      * @author PMS
      */
      public function getAllActiveSubscription($client_id,$start_date,$end_date)
      {

        $query = "select 
                  id,
                  client_id,
                  subscription_id,
                  configuration,
                  number_of_vehicles,
                  number_of_reports_generated,
                  start_date,
                  end_date 
                  from client_trip_report_subscriptions 
                  where 
                  client_id =".$client_id."
                  AND
                  (
                  ('".date('Y-m-d',strtotime($start_date))."' > start_date AND '".$end_date."' < end_date)
                    OR (start_date BETWEEN '".date('Y-m-d',strtotime($start_date))."' AND '".$end_date."')
                    OR (end_date BETWEEN '".date('Y-m-d',strtotime($start_date))."' AND '".$end_date."')
                  )";
         return DB::select($query);
      }
    
}
