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

class PacketSplitController extends Controller {

    
 public function packetSplitListPage()
    {
        return view('Gps::packet-data-list');
    }
    public function getPacketAllData(Request $request)
    {
      $packet=$request->content;
      $header=substr($packet,0,3);
      if($header == "NRM")
      {

      	return response()->json([ 'data' => $this->processNrmData($packet)]);
      }
    }

    public function processNrmData($vlt_data){
    	$header = substr($vlt_data,0,3);
        $imei = substr($vlt_data,3,15);
        $date = substr($vlt_data,22,6);
        $time = substr($vlt_data,28,6);
        $code = substr($vlt_data,18,2);
        $packet_status = substr($vlt_data,20,1);
        $lat = substr($vlt_data,34,10);
        $lat_dir = substr($vlt_data,44,1);
        $lng = substr($vlt_data,45,10);
        $lon_dir = substr($vlt_data,55,1);
        $gps_fix = substr($vlt_data,21,1);
        $vehicle_mode = substr($vlt_data,95,1);
        $main_power_status = substr($vlt_data,94,1);
        $ignition = substr($vlt_data,93,1);
        $heading = substr($vlt_data,81,6);
        $gsm_signal_strength = substr($vlt_data,91,2);
        $speed=substr($vlt_data,75,6);
        $no_of_satelites = substr($vlt_data,87,2);
        $mcc = substr($vlt_data,56,3);
        $mnc = substr($vlt_data,59,3);
        $lac = substr($vlt_data,62,4);
        $cell_id = substr($vlt_data,66,9);
        $hdop = substr($vlt_data,89,2);
        $device_time = $this->getDateTime($date,$time);
        $array=[];
        $array=array(
        	  'header' => $header,
        	   'imei'=>$imei,
                'date' => $date,
                'time' => $time,
                'code' => $code,
                 'packet_status'=>$packet_status,
                'latitude' => $lat,
                'lat_dir' =>   $lat_dir,
                'longitude' => $lng,
                'lon_dir' =>  $lon_dir,
                'mcc' =>$mcc,
                'mnc' => $mnc,
                'lac' => $lac,
                'cell_id' => $cell_id,
                'speed' => $speed,
                'heading' => $heading,
                'no_of_satelites' => $no_of_satelites,
                'hdop' =>  $hdop,
                'gsm_signal_strength' => $gsm_signal_strength,
                'ignition' => $ignition,
                'main_power_status' => $main_power_status,
                'vehicle_mode' => $vehicle_mode,
                'device_time' => $device_time,
                'vlt_data' => $vlt_data
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