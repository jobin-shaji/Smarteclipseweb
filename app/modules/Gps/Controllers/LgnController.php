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

class LgnController extends Controller {

    
 public function lgnSplitListPage()
    {
        return view('Gps::lgn-data-list');
    }
    public function getLgnAllData(Request $request)
    {
      $packet=$request->content;
      $header=substr($packet,0,3);
      if($header == "LGN")
      {

      	return response()->json([ 'data' => $this->processLgnData($packet)]);
      }
    }

    public function processLgnData($vlt_data){
    	$header = substr($vlt_data,0,3);
        $date = substr($vlt_data,56,6);
        $time = substr($vlt_data,62,6);
        $imei = substr($vlt_data,3,15);
      
        $lat = substr($vlt_data,34,10);
        $lat_dir = substr($vlt_data,44,1);
        $lng = substr($vlt_data,45,10);
        $lon_dir = substr($vlt_data,55,1);
        $activation_key = substr($vlt_data,18,16);
        $device_time = $this->getDateTime($date,$time);
        $array=[];
        $array=array(
        	   'header' => $header,
        	    'imei'=>$imei,
                'activation_key' =>  $activation_key,
                'date' => $date,
                'time' => $time,
                'latitude' => $lat,
                'lat_dir' =>   $lat_dir,
                'longitude' => $lng,
                'lon_dir' =>  $lon_dir,
                'speed' => substr($vlt_data,68,6),
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