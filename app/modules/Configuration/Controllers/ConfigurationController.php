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
        $items = Configuration::where('code','plan')->get()->toArray(); 
        //echo '<pre>'.print_r($items, true).'</pre>';
       //die();
        // dd($items->value);
       return view('Configuration::configuration-create',['config'=> $items]);
    }
    public function save(Request $request)
    {
        if($request->user()->hasRole('root')){ 
            $plan=$request->plan_id; 
            $plan_name=$request->plan_name; 
            $fields = [
              "fuel",
              "radar",
              "invoice", 
              "ac_status", 
              "api_access", 
              "white_list", 
              "client_logo", 
              "immobilizer", 
              "driver_score", 
              "towing_alert", 
              "client_domain", 
              "modify_design", 
              "custom_feature", 
              "geofence_count", 
              "anti_theft_mode", 
              "database_backup", 
              "emergency_alerts", 
              "share_in_web_app", 
              "point_of_interest", 
              "mobile_application", 
              "daily_report_as_sms", 
              "privillaged_support", 
              "route_deviation_count", 
              "route_playback_history_month", 
              "daily_report_summary_to_reg_mail"
            ];
            $field_values = [];
            foreach($fields as $each_field)
            {
              
              $field_values[$each_field] = ( ctype_digit($request->{$each_field}) ) ? (int)$request->{$each_field} : $this->congig_status($request->{$each_field});
            }
            $configuration = Configuration::where('code', 'plan')->first();
            $old_configuration_value = json_decode($configuration->value);
            $old_configuration_value[$plan]->configuration = $field_values; 
            $save_config = Configuration::find(1);

            // dd($field_values);
            $save_config->value = json_encode($old_configuration_value,true);
            $save_config->date = date('Y-m-d');
            $save_config->version = $request->version;
            $save_config->save();
            if($save_config){
              $gps = ConfigurationVersion::create([
                'plan'=>$plan_name,
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
        if($status=='true'){
            return true;
        }
        else{
            return false;
        }
    }
}