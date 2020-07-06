<?php
namespace App\Modules\TripReport\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\TripReport\Models\ClientTripReportSubscription;
use App\Modules\Vehicle\Models\Vehicle;
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
     * 
     * 
     */
    public function getVehiclesBasedOnClient(Request $request)
    {
        $client_id = Crypt::decrypt($request->client_id);       
        $vehicles           =   (new Vehicle())->getVehiclesOfSelectedClient($client_id);        
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

    public function vehicletripreportsave(Request $request)
    {        
        $client_id = Crypt::decrypt($request->client_id);  
        $vehicle_id=$request->vehicle_id; 
        $startDate = date('Y-m-d',strtotime($request->startDate));
        $toDate = date('Y-m-d',strtotime($request->toDate));
        $configuration = ClientTripReportSubscription::where('client_id', $client_id)
        ->where('vehicle_id', $vehicle_id)
        ->whereDate('start_date', '>=', $startDate)
        ->whereDate('end_date', '<=', $toDate)
        ->first();
        if($configuration)
        {
            $client_trip_report_subscription     =   (new ClientTripReportSubscription())->clientTripReportSubscription($current_date);
            $request->session()->flash('message', 'New Configuration created successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('vehicle-trip-report-config')); 
        }
        else{
            $request->session()->flash('message', 'New Configuration created successfully!'); 
            $request->session()->flash('alert-class', 'alert-danger'); 
            return redirect(route('vehicle-trip-report-config')); 
        }

        // dd($configuration);
        //     $fields = [
        //       "fuel",
        //       "radar",
        //       "invoice", 
        //       "ac_status", 
        //       "api_access", 
        //       "white_list", 
        //       "client_logo", 
        //       "immobilizer", 
        //       "driver_score", 
        //       "towing_alert", 
        //       "client_domain", 
        //       "modify_design", 
        //       "custom_feature", 
        //       "geofence_count", 
        //       "anti_theft_mode", 
        //       "database_backup", 
        //       "emergency_alerts", 
        //       "share_in_web_app", 
        //       "point_of_interest", 
        //       "mobile_application", 
        //       "daily_report_as_sms", 
        //       "privillaged_support", 
        //       "route_deviation_count", 
        //       "route_playback_history_month", 
        //       "daily_report_summary_to_reg_mail"
        //     ];
        //     $field_values = [];
        //     foreach($fields as $each_field)
        //     {
              
        //       $field_values[$each_field] = ( ctype_digit($request->{$each_field}) ) ? (int)$request->{$each_field} : $this->congig_status($request->{$each_field});
        //     }
        //     $configuration = Configuration::where('code', 'plan')->first();
        //     $old_configuration_value = json_decode($configuration->value);
        //     $old_configuration_value[$plan]->configuration = $field_values; 
        //     $save_config = Configuration::find(1);

        //     // dd($field_values);
        //     $save_config->value = json_encode($old_configuration_value,true);
        //     $save_config->date = date('Y-m-d');
        //     $save_config->version = $request->version;
        //     $save_config->save();
        //     if($save_config){
        //       $gps = ConfigurationVersion::create([
        //         'plan'=>$plan_name,
        //         'version'=>$request->version       
        //       ]); 
        //     }
                        
       
        // $request->session()->flash('message', 'New Configuration created successfully!'); 
        // $request->session()->flash('alert-class', 'alert-success'); 
        // return redirect(route('configuration.create')); 
    }

}