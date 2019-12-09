<?php 
namespace App\Modules\Configuration\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Configuration\Models\Configuration;
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
        $items = Configuration::all(); 
       return view('Configuration::configuration-create',['config'=> $items]);
    }
    public function save(Request $request)
    {
        if($request->user()->hasRole('root')){ 
             $plan_id=$request->plan_id; 
             dd($plan_id);
            $ac_status=$request->ac_status; 
            $anti_theft_mode=$request->anti_theft_mode; 
            $api_access=$request->api_access; 
            $client_domain=$request->client_domain; 
            $client_logo=$request->client_logo; 
            $custom_feature=$request->custom_feature; 
            $daily_report_as_sms=$request->daily_report_as_sms; 
            $daily_report_summary_to_reg_mail=$request->daily_report_summary_to_reg_mail; 
            $database_backup=$request->database_backup; 
            $driver_score=$request->driver_score; 
            $emergency_alerts=$request->emergency_alerts; 
            $fuel=$request->fuel; 
            $geofence_count=$request->geofence_count; 
            $immobilizer=$request->immobilizer; 
            $invoice=$request->invoice; 
            $mobile_application=$request->mobile_application; 
            $modify_design=$request->modify_design; 
            $point_of_interest=$request->point_of_interest; 
            $privillaged_support=$request->privillaged_support; 
            $radar=$request->radar; 
            $route_deviation_count=$request->route_deviation_count; 
            $share_in_web_app=$request->share_in_web_app; 
            $towing_alert=$request->towing_alert; 
            $white_list=$request->white_list; 
            $route_playback_history_month=$request->route_playback_history_month; 



            $dealer = Configuration::create([
                'name' => $request->name,
                'value'=>$request->config,
                'code' => $request->code,            
              
            ]);
        }
        $request->session()->flash('message', 'New Configuration created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('configuration.create')); 
    }
    public function getConfiguration(Request $request)
    {  
        $items = Configuration::find(1);  
        
        return response()->json([
                'config' => $items        
        ]);
    }
}