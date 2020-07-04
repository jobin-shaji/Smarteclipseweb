<?php
namespace App\Modules\TripReport\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\TripReport\Models\ClientTripReportSubscription;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TripReportController extends Controller 
{

    /**
     * 
     * 
     */
    public function getVehicleTripReportConfig(Request $request)
    {
        $vehicle_trip_config_details    =  [];
        $plan_type                      = ( isset($request->plan) ) ? $request->plan : null;
        $client_id                      = ( isset($request->client) ) ? $request->client : null;
        if( !is_null($client_id))  
        {
            $client_id = ( ($client_id != 'all') ) ? decrypt($client_id) : $client_id;
        } 
        if($client_id != null)
        {
            $vehicle_trip_config_details= (new ClientTripReportSubscription())->getVehicleTripConfigDetails($plan_type, $client_id);
            //$plan_type                  = (new Client())->getClientDetailsWithClientId($client_id)->user->role;
        }
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

}