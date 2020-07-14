<?php

namespace  App\Modules\TripReport\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;



class TripReportSubscriptionVehicles extends Model
{
    use SoftDeletes;    
    protected $fillable=[
		'client_trip_report_subscription_id','vehicle_id','attached_on','detached_on','expired_on','report_last_generated_on'
    ];	

    public function addSubscriptionVehicles($data)
    {
        return self::create($data);
    }
    public function getSubscriptionVehicles($id)
    {
        return self::where('client_trip_report_subscription_id',$id)
                     ->withTrashed()
                     ->orderBy('detached_on','ASC')
                     ->get();
    }
    /**
     * vehicle
     * @author PMS
     */
    public function vehicles()
    {
      return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id');
    }

     /**
     * subscriptions
     * @author PMS
     */
    public function subscriptions()
    {
      return $this->hasOne('App\Modules\TripReport\Models\ClientTripReportSubscription','id','client_trip_report_subscription_id');
    }

    /**
     * 
     * @author  PMS
     * 
     */

    public function getSubscribedVehicles($date)
    {
       return self::with('vehicles:id,name,gps_id')
                   ->where('attached_on', '<=', $date)
                   ->where('expired_on', '>=', $date)
                   ->whereNull('detached_on')
                   ->get();
    }
     /**
     * 
     * @author  PMS
     * 
     */
    public function updateGeneratedDetails($id,$data)
    {
      return self::where('id', $id)
                  ->update($data);
    }
    /** */
    public function deleteTripReportVehicleSubscription($id)
    {
        return self::where('id', $id)
        ->update(['detached_on' => date('Y-m-d'),'deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function getSubscriptionVehicleIds($subscription)
    {
      $query = "select id,name from vehicles 
      where client_id =".$subscription->client_id." AND id NOT IN(
      select trsv.vehicle_id AS vehicle_id  FROM `trip_report_subscription_vehicles` AS trsv
      LEFT JOIN vehicles AS vh ON vh.id =trsv.vehicle_id
      WHERE vh.client_id =".$subscription->client_id."
      AND
      (
       ('".$subscription->start_date."' > trsv.attached_on AND '".$subscription->end_date."' < trsv.expired_on)
        OR (trsv.attached_on BETWEEN '".$subscription->start_date."' AND '".$subscription->end_date."')
         OR (trsv.expired_on BETWEEN '".$subscription->start_date."' AND '".$subscription->end_date."')
       )
       GROUP BY trsv.vehicle_id
      )";
      
       return DB::select($query);
    }

    /**
     * 
     * @author PMS
     */

     public function getSubscriptionVehiclesCount($id)
     {
      return self::
        where('client_trip_report_subscription_id',$id)
      ->whereNull('detached_on')
      ->count();
     }

    public function findActiveVehicles($subscription_id)
    {
      return self::where('client_trip_report_subscription_id',$subscription_id)
                   ->whereNull('detached_on')
                   ->count();

    }
    
}
