<?php 
namespace App\Modules\Gps\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsConfiguration;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;
use DB;
use Config;

class HlmController extends Controller {

    
 public function HlmSplitListPage()
    {
        return view('Gps::hlm-data-list');
    }
    public function getHlmAllData(Request $request)
    {
      $packet=$request->content;
      $header=substr($packet,0,3);
      if($header == "HLM")
      {

      	return response()->json([ 'data' => $this->processHlmData($packet)]);
      }
    }

    public function processHlmData($vlt_data){
    	$header = substr($vlt_data,0,3);
        $imei = substr($vlt_data,15,15);
        $date = substr($vlt_data,50,6);
        $time = substr($vlt_data,56,6);
        $device_time = $this->getDateTime($date,$time);
        $array=[];
        $array=array(
        	   'header' => $header,
        	   'vendor_id' => substr($vlt_data,3,6),
                'firmware_version' => substr($vlt_data,9,6),
                'imei' => substr($vlt_data,15,15),
                'update_rate_ignition_on' => substr($vlt_data,30,3),
                'update_rate_ignition_off' => substr($vlt_data,33,3),
                'battery_percentage' => substr($vlt_data,36,3),
                'low_battery_threshold_value' => substr($vlt_data,39,2),
                'memory_percentage' => substr($vlt_data,41,3),
                'digital_io_status' => substr($vlt_data,44,4),
                'analog_io_status' => substr($vlt_data,48,2),
                'vlt_data' => $vlt_data,
                'date' => $date,
                'time' => $time,
                'device_time' =>$device_time
                
              );
             return $array;

    }

    public function getDateTime($date,$time){
        $d = substr($date,0,2);
        $m = substr($date,2,2);
        $y = substr($date,4,4);
        $h = substr($time,0,2);
        $mi = substr($time,2,2);
        $s = substr($time,4,2);
        $device_time = '20'.$y.'-'.$m.'-'.$d.' '.$h.':'.$mi.':'.$s;
        return $device_time;
    }
    
}