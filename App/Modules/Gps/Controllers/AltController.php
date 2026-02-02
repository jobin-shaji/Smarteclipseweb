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

class AltController extends Controller {

    
 public function AltListPage()
    {
        return view('Gps::alt-data-list');
    }
    public function getAltAllData(Request $request)
    {
      $packet=$request->content;
      $header=substr($packet,0,3);
      if($header == "ALT")
      {

      	return response()->json([ 'data' => $this->processAltData($packet)]);
      }
    }

    public function processAltData($vlt_data){
        $imei = substr($vlt_data,3,15);
       
        $code = substr($vlt_data,18,2);
        $date = substr($vlt_data,22,6);
        $time = substr($vlt_data,28,6);
        $lat = substr($vlt_data,34,10);
        $lng = substr($vlt_data,45,10);
        $vehicle_mode = substr($vlt_data,95,1);
        $gps_fix = substr($vlt_data,21,1);
        $main_power_status = substr($vlt_data,94,1);
        $ignition = substr($vlt_data,93,1);
        $gsm_signal_strength = substr($vlt_data,91,2);
        $heading = substr($vlt_data,81,6);
        $speed=substr($vlt_data,75,6);
        $device_time = $this->getDateTime($date,$time);
        $packet_status = substr($vlt_data,20,1);
        $no_of_satelites = substr($vlt_data,89,2);

        $array=[];
        $array=array(
        
                'header' => substr($vlt_data,0,3),
                'imei' => $imei,
                'alert_id' => $code,
                'packet_status' => substr($vlt_data,20,1),
                'gps_fix' => $gps_fix,
                'date' => $date,
                'time' => $time,
                'latitude' => $lat,
                'lat_dir' => substr($vlt_data,44,1),
                'longitude' => $lng,
                'lon_dir' => substr($vlt_data,55,1),
                'mcc' => substr($vlt_data,56,3),
                'mnc' => substr($vlt_data,59,3),
                'lac' => substr($vlt_data,62,4),
                'cell_id' => substr($vlt_data,66,9),
                'speed' => substr($vlt_data,75,6),
                'heading' => $heading,
                'no_of_satelites' => substr($vlt_data,87,2),
                'hdop' => substr($vlt_data,89,2),
                'gsm_signal_strength' => $gsm_signal_strength,
                'ignition' => $ignition,
                'main_power_status' => $main_power_status,
                'vehicle_mode' => $vehicle_mode,
                // 'response' => $response,
                'vlt_data' => $vlt_data,
                'device_time' => $device_time
              
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