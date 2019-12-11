<?php 
namespace App\Modules\Configuration\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Configuration\Models\Configuration;
use App\Modules\Configuration\Models\ConfigurationVersion;

use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;
use DB;
use Config;
class ConfigurationController extends Controller {
    public function create()
    {
        $items = Configuration::all()->toArray(); 
        //echo '<pre>'.print_r($items, true).'</pre>';
       //die();
        // dd($items->value);
       return view('Configuration::configuration-create',['config'=> $items]);
    }
    public function save(Request $request)
    {
        if($request->user()->hasRole('root')){ 
            $plan=$request->plan_id; 

            $ac_status =  $this->congig_status($request->ac_status);  
            $anti_theft_mode =  $this->congig_status($request->anti_theft_mode);                        
            $api_access=$this->congig_status($request->api_access);    
            $client_domain=$this->congig_status($request->client_domain); 
            $client_logo=$this->congig_status($request->client_logo);             
            $custom_feature=$this->congig_status($request->custom_feature); 
            $daily_report_as_sms=$this->congig_status($request->daily_report_as_sms); 
            $daily_report_summary_to_reg_mail=$this->congig_status($request->daily_report_summary_to_reg_mail); 
            $database_backup=$this->congig_status($request->database_backup); 
            $driver_score=$this->congig_status($request->driver_score); 
            $emergency_alerts=$this->congig_status($request->emergency_alerts); 
            $fuel=$this->congig_status($request->fuel); 
            $geofence_count=$request->geofence_count; 
            $immobilizer=$this->congig_status($request->immobilizer); 
            $invoice=$this->congig_status($request->invoice); 
            $mobile_application=$this->congig_status($request->mobile_application); 
            $modify_design=$this->congig_status($request->modify_design); 
            $point_of_interest=$this->congig_status($request->point_of_interest); 
            $privillaged_support=$this->congig_status($request->privillaged_support); 
            $radar=$this->congig_status($request->radar); 
            $route_deviation_count=$request->route_deviation_count; 
            $share_in_web_app=$this->congig_status($request->share_in_web_app); 
            $towing_alert=$this->congig_status($request->towing_alert); 
            $white_list=$this->congig_status($request->white_list); 
            $route_playback_history_month=$request->route_playback_history_month; 
            $configuration_value=[];         
            $configuration_value=[
                    "fuel"=> $fuel,
                    "radar" =>$radar,
                    "invoice" =>$invoice, 
                    "ac_status" =>$ac_status, 
                    "api_access"=> $api_access, 
                    "white_list" =>$white_list, 
                    "client_logo"=> $client_logo, 
                    "immobilizer" =>$immobilizer, 
                    "driver_score" =>$driver_score, 
                    "towing_alert" =>$towing_alert, 
                    "client_domain" =>$client_domain, 
                    "modify_design"=> $modify_design, 
                    "custom_feature" =>$custom_feature, 
                    "geofence_count" =>$geofence_count, 
                    "anti_theft_mode" =>$anti_theft_mode, 
                    "database_backup"=> $database_backup, 
                    "emergency_alerts" =>$emergency_alerts, 
                    "share_in_web_app"=> $share_in_web_app, 
                    "point_of_interest"=> $point_of_interest, 
                    "mobile_application" =>$mobile_application, 
                    "daily_report_as_sms" =>$daily_report_as_sms, 
                    "privillaged_support"=> $privillaged_support, 
                    "route_deviation_count"=> $route_deviation_count, 
                    "route_playback_history_month"=> $route_playback_history_month, 
                    "daily_report_summary_to_reg_mail" => $daily_report_summary_to_reg_mail
                   ];

               $configuration = Configuration::select('value')->first();
               $value = json_decode($configuration->value, true);
               if($plan=='freebies'){
                $freebies=$configuration_value;

               }
               else{
                $freebies=$value['freebies'];

               }
               if($plan=='fundamental'){
                $fundamental=$configuration_value;

               }
               else{
                $fundamental=$value['fundamental'];

               }
                if($plan=='superior'){
                $superior=$configuration_value;

               }
               else{
                $superior=$value['superior'];

               }
               if($plan=='pro'){
                $pro=$configuration_value;

               }
               else{
                $pro=$value['pro'];

               }
               $config_data=['freebies'=>$freebies,
                             'fundamental'=>$fundamental,
                             'superior'=>$superior,
                              'pro'=>$pro
                           ];

                $config_data_json=json_encode($config_data,true);
                $save_config = Configuration::find(1);
                $save_config->value = $config_data_json;
                $save_config->date = date('Y-m-d');
                $save_config->version = $request->version;
                $save_config->save();
                if($save_config){
                  $gps = ConfigurationVersion::create([
                    'plan'=>$plan,
                    'version'=>$request->version       
                  ]); 
                }
                        
        }
        $request->session()->flash('message', 'New Configuration created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('configuration.create')); 
    }
    public function getConfiguration(Request $request)
    {  
        $version = ConfigurationVersion::where('plan',$request->name)->orderBy('id','desc')->first();         
        return response()->json([
                'version' => $version        
        ]);
    }


    function congig_status($status){
        if($status==true){
            return "true";
        }
        else{
            return "false";
        }
    }
}