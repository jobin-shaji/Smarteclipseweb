<?php
namespace App\Modules\TripReport\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\TripReport\Models\ClientTripReportSubscription;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\TripReport\Models\TripReportConfiguration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

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
    /**
     * 
     * fetch vehicles based on client
     * 
     */
    public function getVehiclesBasedOnClient(Request $request)
    {     
        $vehicles           =   (new Vehicle())->getVehiclesOfSelectedClient(Crypt::decrypt($request->client_id));        
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
    public function vehicletripreportsave(Request $request)
    {        
        $client_id = Crypt::decrypt($request->client_id);  
        $startDate = date('Y-m-d',strtotime($request->startDate));
        $toDate = date('Y-m-d',strtotime($request->toDate));
        $vehicle_configuration      = (new ClientTripReportSubscription())->getClientConfiguration($client_id,$request->vehicle_id, $startDate,$toDate);       
        if($vehicle_configuration->count()==0)
        {
            $plan_of_client             = (new Client())->getClientDetailsWithClientId($client_id)->user->role;
            $trip_report_config = TripReportConfiguration::select(
                'number_of_report_per_month',
                'backup_days',
                'free_vehicle'
            )
            ->where('plan_id', $plan_of_client)
            ->first();  
            $client_trip_report_subscription     =   (new ClientTripReportSubscription())->clientVehcileTripReportConfiguration($client_id,$request->vehicle_id,$startDate,$toDate,json_encode($trip_report_config));
            $request->session()->flash('message', 'Vehicle configuration added successfully'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('vehicle-trip-report-config')); 
        }
        else{
            $request->session()->flash('message', $vehicle_configuration->first()->vehicles->name.' Already  configured between '.$request->startDate.' and '.$request->toDate); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('vehicle-trip-report-config')); 
        }
    }

}