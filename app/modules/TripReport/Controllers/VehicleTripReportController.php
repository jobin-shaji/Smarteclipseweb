<?php
namespace App\Modules\TripReport\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\TripReport\Models\ClientTripReportSubscription;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\TripReport\Models\TripReportConfiguration;
use  App\Modules\TripReport\Models\TripReportSubscriptionVehicles;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehicleTripReportController extends Controller 
{

    /**
     * 
     * 
     */
    public function getVehicleTripReportConfig(Request $request)
    {
        $vehicle_trip_config_details    =  [];
        $plan_type                      = ( isset($request->plan) ) ? $request->plan : null;
       
        $client_id                      = ( isset($request->client) ) ? $request->client : 'all';
        if( !is_null($client_id))  
        {
            
            $client_id = ( ($client_id != 'all') ) ? decrypt($client_id) : $client_id;
        } 
        if($client_id != null)
        {
            $vehicle_trip_config_details= (new ClientTripReportSubscription())->getVehicleTripConfigDetails($plan_type, $client_id);
        }

        // dd($vehicle_trip_config_details);
        $client_details                 = (new Client())->getDetailsOfAllClients();
        return view('TripReport::vehicle-trip-report-config-list',['client_details' => $client_details ,'vehicle_trip_config_details' => $vehicle_trip_config_details, 'plan_type' => $plan_type, 'client_id' => $client_id]);
   
    }

    /**
     * 
     * 
     */
    public function getPlanOfEndUser(Request $request)
    {
        $client_id                      = ( $request->client_id != 'all' ) ? decrypt($request->client_id) : $request->client_id;
        if($client_id != 'all')
        {
            $plan_of_client             = (new Client())->getClientDetailsWithClientId($client_id)->user->role;
            $plan_names                 = array_column(config('eclipse.PLANS'), 'NAME', 'ID');
            $plan_type                  = [
                                            'ID'    => $plan_of_client,
                                            'NAME'  => $plan_names[$plan_of_client],
                                        ];
        }
        else
        {
            $plan_type                  = config('eclipse.PLANS');
        }
        return response()->json(array('client_id' => $client_id, 'plan_type' => $plan_type));
    }
    /**
     * 
     * fetch vehicles based on client
     * 
     */
    public function getVehiclesBasedOnClient(Request $request)
    {     
        $vehicles    =   (new Vehicle())->getVehiclesOfSelectedClient(Crypt::decrypt($request->client_id));        
        if($vehicles == null)
        {
            return response()->json([
                'vehicles' => '',
                'message' => 'no vehicle found'
            ]);
        }else
        {
            return response()->json([
                    'vehicles' => $vehicles,
                    'message' => 'success'
            ]);
        }
    }

    /**
     * vehicle trip report configuration save
     */
    public function saveTripReportSubscription(Request $request)
    {      
        $vehicle_trip_config_details    =  [];
        $client_id                      = Crypt::decrypt($request->client_id);  
        $vehicle_configuration          = (new ClientTripReportSubscription())->getClientConfiguration($request);       
        if($vehicle_configuration->count()==0)
        {
            $plan_of_client                 = (new Client())->getClientDetailsWithClientId($client_id)->user->role;
            $trip_report_config             = TripReportConfiguration::select(
                'number_of_report_per_month',
                'backup_days',
                'free_vehicle'
            )
            ->where('plan_id', $plan_of_client)
            ->first(); 
             
            $all_subscription_vehicles_count    = (new TripReportSubscriptionVehicles())->getAllSubscriptionVehiclesCount($client_id);
            if($all_subscription_vehicles_count < $trip_report_config->free_vehicle)
            {
                if($request->number_of_vehicle >= $trip_report_config->free_vehicle)
                {
                    $subscribed_vehicle_count = $request->number_of_vehicle - $trip_report_config->free_vehicle;
                }else{
                    $subscribed_vehicle_count = 0;
                }
            }else{
                $subscribed_vehicle_count     =   $request->number_of_vehicle;
            }
            
           
            $subscribed_month               =  $request->number_of_month;
            $subscription_start_date        =  (new Carbon($request->start_date))->format('Y-m-d');
            $subscription_end_date          =  (new Carbon($request->start_date))->addMonths($subscribed_month)->format('Y-m-d');
            $number_of_subscribed_vehicles  =  $request->number_of_vehicle;
            
            // total report = (number_of_reports_per_month*number_of_subscribed_vehicle)*number_of_month
            $total_number_of_report         =  ($trip_report_config->number_of_report_per_month * $number_of_subscribed_vehicles)*$subscribed_month;
           
            $client_trip_report_subscription     =   (new ClientTripReportSubscription())->saveTripReportSubscription($client_id, $subscription_start_date,$subscription_end_date,$total_number_of_report,$subscribed_vehicle_count,json_encode($trip_report_config)); 
            $request->session()->flash('message', 'Vehicle configuration added successfully'); 
            $request->session()->flash('alert-class', 'callout-success'); 
            return redirect(route('vehicle-trip-report-config')); 
        }
        else{
            $request->session()->flash('message', $vehicle_configuration->first()->vehicles->name.' Already  configured between '.$request->startDate.' and '.$request->toDate); 
            $request->session()->flash('alert-class', 'callout-danger'); 
            return redirect(route('vehicle-trip-report-config')); 
        }
    }
    /**
     * vehicle trip report configuration delete
     */
    public function tripReportSubscriptionDelete(Request $request)
    {  
 
        $subscription         =   (new ClientTripReportSubscription())->deleteTripReportSubscription(Crypt::decrypt($request->id));
        if($subscription != null)
        {
            $subscription->delete();            
            $request->session()->flash('message', 'Trip report subscription deleted successfully'); 
            $request->session()->flash('alert-class', 'callout-success'); 
            return redirect(route('vehicle-trip-report-config')); 
        }
        else
        {
            $request->session()->flash('message', 'Something went wrong'); 
            $request->session()->flash('alert-class', 'callout-danger'); 
            return redirect(route('vehicle-trip-report-config')); 

        } 
    }

    /**
     * 
     * @author PMS
     * trip report subscription vehicles
     */
    public function tripReportSubscriptionVehiclesList(Request $request)
    {
     
        $subscription         =   (new ClientTripReportSubscription())->getTripSubscription(Crypt::decrypt($request->id));
        if($subscription != null)
        {
            $subscription_vehicle               = (new TripReportSubscriptionVehicles())->getSubscriptionVehicleIds($subscription);
            $subscription_vehicle_count         = (new TripReportSubscriptionVehicles())->getSubscriptionVehiclesCount($subscription->id);
            $subscription_vehicle_list          = (new TripReportSubscriptionVehicles())->getSubscriptionVehicles($subscription->id);
            $all_subscription_vehicles_count    = (new TripReportSubscriptionVehicles())->getAllSubscriptionVehiclesCount($subscription->client_id);
            $free_vehicle_count_from_plan       = isset((json_decode($subscription->configuration))->free_vehicle) ? (json_decode($subscription->configuration))->free_vehicle : 0;
            $available_free_vehicle             = 0;
            if($free_vehicle_count_from_plan >  $all_subscription_vehicles_count)
            {
                $available_free_vehicle         = $free_vehicle_count_from_plan - $all_subscription_vehicles_count;
            }
            return view('TripReport::trip-report-vehicles',
            [
                'subscription'              => $subscription,
                'vehicles'                  => $subscription_vehicle,
                'subscription_list'         => $subscription_vehicle_list,
                'vehicle_count'             => $subscription_vehicle_count,
                'free_vehicle'              => $available_free_vehicle
            ]);
        }else{

            $request->session()->flash('message', 'Something went wrong'); 
            $request->session()->flash('alert-class', 'callout-danger'); 
            return redirect(route('vehicle-trip-report-config'));
        }

    }

    public function saveVehicleSubscription(Request $request)
    {

        $subscription         =   (new ClientTripReportSubscription())->getTripSubscription($request->id);
        if($subscription != null)
        {

           $add_vehicle_to_subscription = (new TripReportSubscriptionVehicles())->addSubscriptionVehicles([
                'client_trip_report_subscription_id'  => $subscription->id,
                'vehicle_id'    => $request->vehicle_id,
                'attached_on'   => date('Y-m-d'),
                'expired_on'    => $subscription->end_date
           ]);
           $request->session()->flash('message', 'Vehicle added successfully'); 
           $request->session()->flash('alert-class', 'callout-success'); 
            return back();
        }else{
            
            $request->session()->flash('message', 'Something went wrong'); 
            $request->session()->flash('alert-class', 'callout-danger'); 
            return back();
        }
    }

    /**
     *  trip report vehicle delete
     */
    public function tripReportVehicleDelete(Request $request)
    {         
        $subscription_vehicle_list     = (new TripReportSubscriptionVehicles())->deleteTripReportVehicleSubscription(Crypt::decrypt($request->id));
        $request->session()->flash('message', 'Trip report subscription deleted successfully'); 
        $request->session()->flash('alert-class', 'callout-success'); 
        return back();       
    }


    /**
     * 
     * @author PMS
     * Validation in subscription
     */

    public function getSubscriptionValidation(Request $request)
    {
        $client_id              =  Crypt::decrypt($request->client_id);
        $start_date             =  $request->start_date;
        $subscribed_month       =  $request->number_of_month;
        $end_date               =  (new Carbon($request->start_date))->addMonths($subscribed_month)->format('Y-m-d');
        $number_of_vehicle      =  $request->number_of_vehicle;
        $subscriptions          =  (new ClientTripReportSubscription())->getAllActiveSubscription($client_id,$start_date,$end_date);
        $active_subscription    =  []; 

            foreach ($subscriptions as $item)
            {
                $subscribed_vehicles =  $item->number_of_vehicles;
                $count_of_vehicle    =  (new TripReportSubscriptionVehicles())->findActiveVehicles($item->id);

                    
                    if($subscribed_vehicles > $count_of_vehicle)
                    {
                        $active_subscription[] = [
                            "id"                                  => Crypt::encrypt($item->id),
                            "subscription_id"                     => $item->subscription_id,
                            "number_of_vehicles"                  => $item->number_of_vehicles,
                            "number_of_vehicles_added"            => $count_of_vehicle,
                            "remaining_subscription_vehicles"     => $item->number_of_vehicles - $count_of_vehicle,
                            "start_date"                          => $item->start_date,
                            "expired_on"                          => $item->end_date

                        ];
                    }
            }
            if(sizeof($active_subscription) > 0)
            {
                return json_encode([
                    "status"  => "success",
                    "data"    => $active_subscription
                ]);
            }else{
                return json_encode([
                    "status"  => "failed",
                    "data"    => []
                ]);
            }
                
       
    }

}