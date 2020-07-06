<?php

namespace  App\Modules\TripReport\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientTripReportSubscription extends Model
{
    protected $fillable=[
		'client_id','vehicle_id','configuration','start_date','end_date'
    ];
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
                        'vehicles.name as vehicle_name','vehicles.register_number as veh_reg_no','users.role as role');
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
}
