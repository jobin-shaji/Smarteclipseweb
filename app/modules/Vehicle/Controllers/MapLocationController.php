<?php

namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Ota\Models\OtaResponse;
use App\Modules\Vehicle\Models\VehicleRoute;
use App\Modules\Route\Models\RouteArea;
use App\Modules\Vehicle\Models\DocumentType;
use App\Modules\Vehicle\Models\VehicleDriverLog;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Ota\Models\GpsOta;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Driver\Models\Driver;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\KmUpdate;

use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Servicer\Models\ServicerJob;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use DataTables;
use Config;

class MapLocationController extends Controller {

    public function gpsMapLocation(Request $request)
    {
        $gps=Gps::all();
        return view('Vehicle::gps-location-tracker',['gps' => $gps]);
    }

    public function gpsMapLocationTrack(Request $request)
    {
        $gps_id=$request->gps_id;
        $from_date=date('Y-m-d H:i:s',strtotime($request->from_date));
        $to_date=date('Y-m-d H:i:s',strtotime($request->to_date));
        $track_data_with_all=GpsData::select('latitude as lat',
                      'longitude as lng'
                    )
                    ->where('gps_id',$gps_id)
                    ->whereBetween('device_time', array($from_date, $to_date))
                    ->get();
        $track_data_with_gpsfix=GpsData::select('latitude as lat',
                      'longitude as lng'
                    )
                    ->where('gps_id',$gps_id)
                    ->where('gps_fix',1)
                    ->whereBetween('device_time', array($from_date, $to_date))
                    ->get();
        $response_data = array(
                           'track_data_with_all' => $track_data_with_all,
                           'track_data_with_gpsfix' => $track_data_with_gpsfix
                        );
        return response()->json($response_data); 
    }

    public function gpsKmMapLocation(Request $request)
    {
        $gps=Gps::all();
        return view('Vehicle::gps-km-location-tracker',['gps' => $gps]);
    }
    public function gpsKmMapLocationTrack(Request $request)
    {
        $gps_id=$request->gps_id;
        $from_date=date('Y-m-d H:i:s',strtotime($request->from_date));
        $to_date=date('Y-m-d H:i:s',strtotime($request->to_date));
        $track_km_data=KmUpdate::select('lat',
          'lng',
          'km'
        )
        ->where('gps_id',$gps_id)
        ->whereBetween('device_time', array($from_date, $to_date))
        ->get();
        $response_data = array(
           'track_km_data' => $track_km_data
        );
        return response()->json($response_data); 
    }

    public function engineStatusToday()
    { 
        $gps_id=5;
        $first_log=GpsData::select('id','ignition','device_time')->whereDate('device_time', '=', date('Y-m-d'))->where('gps_id',$gps_id)->orderBy('device_time')->first();
        $last_log=GpsData::select('id','ignition','device_time')->whereDate('device_time', '=', date('Y-m-d'))->where('gps_id',$gps_id)->latest('device_time')->first();
        $balance_log=DB::select('SELECT id,ignition,device_time FROM
                            ( SELECT (@statusPre <> ignition) AS statusChanged
                                 , ignition, device_time,id
                                 , @statusPre := ignition
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE DATE(device_time) = CURDATE() AND gps_id=:gps_id ORDER BY device_time 
                          ) AS good
                        WHERE statusChanged',['gps_id' => $gps_id]);
        $engine_on_time=0;
        $engine_off_time=0;
        if($balance_log)
        {
            $i=0;
            foreach ($balance_log as $item) {
                if($i==0){
                    $first_device_time=$first_log->device_time;
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }else{
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }
                $last_item_device_time=$item->device_time;
                $last_ignition=$item->ignition;
                $i++;
            }
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($last_ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }else if($first_log != null && $balance_log==null)
        {
            $first_device_time=$first_log->device_time;
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($first_log->ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }
        $engine_on_hours = floor($engine_on_time / 3600);
        $engine_on_mins = floor($engine_on_time / 60 % 60);
        $engine_on_secs = floor($engine_on_time % 60); 
        $engine_off_hours = floor($engine_off_time / 3600);
        $engine_off_mins = floor($engine_off_time / 60 % 60);
        $engine_off_secs = floor($engine_off_time % 60); 
        $engine_on_time = sprintf('%02d:%02d:%02d', $engine_on_hours, $engine_on_mins, $engine_on_secs);
        $engine_off_time = sprintf('%02d:%02d:%02d', $engine_off_hours, $engine_off_mins, $engine_off_secs);
    }

    public function engineStatusYesterday()
    { 
        $gps_id=5;
        $yesterday=date('Y-m-d',strtotime("-1 days"));
        $first_log=GpsData::select('id','ignition','device_time')->whereDate('device_time', '=', $yesterday)->where('gps_id',$gps_id)->orderBy('device_time')->first();
        $last_log=GpsData::select('id','ignition','device_time')->whereDate('device_time', '=', $yesterday)->where('gps_id',$gps_id)->latest('device_time')->first();
        $balance_log=DB::select('SELECT id,ignition,device_time FROM
                            ( SELECT (@statusPre <> ignition) AS statusChanged
                                 , ignition, device_time,id
                                 , @statusPre := ignition
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE DATE(device_time) = DATE(NOW() - INTERVAL 1 DAY) AND gps_id=:gps_id ORDER BY device_time 
                          ) AS good
                        WHERE statusChanged',['gps_id' => $gps_id]);
        $engine_on_time=0;
        $engine_off_time=0;
        if($balance_log)
        {
            $i=0;
            foreach ($balance_log as $item) {
                if($i==0){
                    $first_device_time=$first_log->device_time;
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }else{
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }
                $last_item_device_time=$item->device_time;
                $last_ignition=$item->ignition;
                $i++;
            }
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($last_ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }else if($first_log != null && $balance_log==null)
        {
            $first_device_time=$first_log->device_time;
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($first_log->ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }
        $engine_on_hours = floor($engine_on_time / 3600);
        $engine_on_mins = floor($engine_on_time / 60 % 60);
        $engine_on_secs = floor($engine_on_time % 60); 
        $engine_off_hours = floor($engine_off_time / 3600);
        $engine_off_mins = floor($engine_off_time / 60 % 60);
        $engine_off_secs = floor($engine_off_time % 60); 
        $engine_on_time = sprintf('%02d:%02d:%02d', $engine_on_hours, $engine_on_mins, $engine_on_secs);
        $engine_off_time = sprintf('%02d:%02d:%02d', $engine_off_hours, $engine_off_mins, $engine_off_secs);
    }

    public function engineStatusLastSevenDays()
    { 
        $gps_id=5;
        $seventh_day_before_current_day=date('Y-m-d',strtotime("-6 days"));
        $first_log=GpsData::select('id','ignition','device_time')->whereDate('device_time', '>=', $seventh_day_before_current_day)->where('gps_id',$gps_id)->orderBy('device_time')->first();
        $last_log=GpsData::select('id','ignition','device_time')->whereDate('device_time', '>=', $seventh_day_before_current_day)->where('gps_id',$gps_id)->latest('device_time')->first();
        $balance_log=DB::select('SELECT id,ignition,device_time FROM
                            ( SELECT (@statusPre <> ignition) AS statusChanged
                                 , ignition, device_time,id
                                 , @statusPre := ignition
                            FROM gps_data
                               , (SELECT @statusPre:=NULL) AS d
                            WHERE DATE(device_time) >= DATE(NOW() - INTERVAL 7 DAY) AND gps_id=:gps_id ORDER BY device_time 
                          ) AS good
                        WHERE statusChanged',['gps_id' => $gps_id]);
        $engine_on_time=0;
        $engine_off_time=0;
        if($balance_log)
        {
            $i=0;
            foreach ($balance_log as $item) {
                if($i==0){
                    $first_device_time=$first_log->device_time;
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }else{
                    $item_device_time=$item->device_time;
                    $ignition=$item->ignition;
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $item_device_time);
                    $diff_in_minutes = $to->diffInSeconds($from);
                    if($ignition==0){
                        $engine_on_time=$engine_on_time+$diff_in_minutes;
                    }else{
                        $engine_off_time=$engine_off_time+$diff_in_minutes;
                    }
                }
                $last_item_device_time=$item->device_time;
                $last_ignition=$item->ignition;
                $i++;
            }
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $last_item_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($last_ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }else if($first_log != null && $balance_log==null)
        {
            $first_device_time=$first_log->device_time;
            $last_device_time=$last_log->device_time;
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $first_device_time);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $last_device_time);
            $diff_in_minutes = $to->diffInSeconds($from);
            if($first_log->ignition==0){
                $engine_off_time=$engine_off_time+$diff_in_minutes;
            }else{
                $engine_on_time=$engine_on_time+$diff_in_minutes;
            }
        }
        $engine_on_hours = floor($engine_on_time / 3600);
        $engine_on_mins = floor($engine_on_time / 60 % 60);
        $engine_on_secs = floor($engine_on_time % 60); 
        $engine_off_hours = floor($engine_off_time / 3600);
        $engine_off_mins = floor($engine_off_time / 60 % 60);
        $engine_off_secs = floor($engine_off_time % 60); 
        $engine_on_time = sprintf('%02d:%02d:%02d', $engine_on_hours, $engine_on_mins, $engine_on_secs);
        $engine_off_time = sprintf('%02d:%02d:%02d', $engine_off_hours, $engine_off_mins, $engine_off_secs);
    }
}
