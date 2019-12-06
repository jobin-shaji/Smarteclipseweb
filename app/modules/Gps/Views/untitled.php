<?php
namespace App\Http\Traits;

use App\GpsData;
use App\Gps;
use App\Vehicle;
use App\AlertType;
use App\Alert;
use Queue;
use App\Jobs\AlertJob;
use App\Jobs\SendSms;
use App\GpsModeChange;
use App\OtaResponse;
use Carbon\Carbon;
use App\ClientAlertPoint;
use App\DriverBehaviour;
use App\Driver;
use Spatie\ArrayToXml\ArrayToXml;
use App\DailyKm;
use App\KmUpdate;
use App\OtaUpdate;
use App\VehicleDailyUpdate;

trait GpsDataProcessorTrait {

    public function processHlmData($vlt_data, $dt){

        $imei = substr($vlt_data,15,15);
        $date = substr($vlt_data,50,6);
        $time = substr($vlt_data,56,6);

        $gps = Gps::where('imei',$imei)->first();
        if($gps){
            $gps->battery_status=substr($vlt_data,36,3);
            $gps->save();
            if($gps->status == 0){
                return "device is inactive";
            }
            $status = GpsData::create([
                'gps_id' => $gps->id,
                'header' => substr($vlt_data,0,3),
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
                'device_time' => $this->getDateTime($date,$time),
                'created_at' => $dt,
                'updated_at' => $dt
            ]);
        }

    }

    public function processLgnData($vlt_data, $dt){
        $date = substr($vlt_data,56,6);
        $time = substr($vlt_data,62,6);
        $imei = substr($vlt_data,3,15);
        $gps = Gps::where('imei',$imei)->first();
        if($gps){
            if($gps->status == 0){
                return "device is inactive";
            }
            $status = GpsData::create([
                'gps_id' => $gps->id,
                'header' => substr($vlt_data,0,3),
                'imei' => substr($vlt_data,3,15),
                'activation_key' => substr($vlt_data,18,16),
                'latitude' => substr($vlt_data,34,10),
                'lat_dir' => substr($vlt_data,44,1),
                'longitude' => substr($vlt_data,45,10),
                'lon_dir' => substr($vlt_data,55,1),
                'date' => $date,
                'time' => $time,
                'speed' => substr($vlt_data,68,6),
                'vlt_data' => $vlt_data,
                'device_time' => $this->getDateTime($date,$time),
                'created_at' => $dt,
                'updated_at' => $dt
            ]);
        }

    }

    public function processNrmData($vlt_data, $dt){
        $imei = substr($vlt_data,3,15);
        $gps = Gps::where('imei',$imei)->first();
        $date = substr($vlt_data,22,6);
        $time = substr($vlt_data,28,6);
        $code = substr($vlt_data,18,2);
        $lat = substr($vlt_data,34,10);
        $lng = substr($vlt_data,45,10);
        $gps_fix = substr($vlt_data,21,1);
        $vehicle_mode = substr($vlt_data,95,1);
        $main_power_status = substr($vlt_data,94,1);
        $ignition = substr($vlt_data,93,1);
        $heading = substr($vlt_data,81,6);
        $gsm_signal_strength = substr($vlt_data,91,2);
        $device_time = $this->getDateTime($date,$time);
        $device_time = date("Y-m-d H:i:s"); 
        $speed=substr($vlt_data,75,6);
        $packet_status = substr($vlt_data,20,1);
        $no_of_satelites = substr($vlt_data,87,2);

        if($gps){
            $status = GpsData::create([
                'gps_id' => $gps->id,
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
                'vlt_data' => $vlt_data,
                'device_time' => $device_time,
                'created_at' => $dt,
                'updated_at' => $dt
            ]);

            $this->updateGpsPrams($gps,$vehicle_mode,$gps_fix,$lat,$lng,$device_time,$main_power_status,$ignition,$gsm_signal_strength,$heading,$speed, $no_of_satelites);
            $this->dispatchAlert($code,$gps,$lat,$lng,$device_time);

        }

    }


    public function processFulData($vlt_data, $dt){
        $imei = substr($vlt_data,3,15);
        $gps = Gps::where('imei',$imei)->first();
        $date = substr($vlt_data,22,6);
        $time = substr($vlt_data,28,6);
        $code = substr($vlt_data,18,2);
        $lat = substr($vlt_data,34,10);
        $lng = substr($vlt_data,45,10);
        $vehicle_mode = substr($vlt_data,95,1);
        $gps_fix = substr($vlt_data,21,1);
        $main_power_status = substr($vlt_data,94,1);
        $ignition = substr($vlt_data,93,1);
        $gsm_signal_strength = substr($vlt_data,91,2);
        $heading = substr($vlt_data,81,6);
        $device_time = $this->getDateTime($date,$time);
        $speed=substr($vlt_data,75,6);
        $packet_status = substr($vlt_data,20,1);
        $no_of_satelites = substr($vlt_data,87,2);

        if($gps){
            $status = GpsData::create([ 
                'gps_id' => $gps->id,
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
                'vendor_id' => substr($vlt_data,96,6),
                'firmware_version' => substr($vlt_data,102,6),
                'vehicle_register_num' => substr($vlt_data,108,16),
                'altitude' => substr($vlt_data,124,7),
                'pdop' => substr($vlt_data,131,2),
                'nw_op_name' => substr($vlt_data,133,6),
                'nmr' => substr($vlt_data,139,60),
                'main_input_voltage' => substr($vlt_data,199,5),
                'internal_battery_voltage' => substr($vlt_data,204,5),
                'tamper_alert' => substr($vlt_data,209,1),
                'digital_io_status' => substr($vlt_data,210,4),
                'frame_number' => substr($vlt_data,214,6),
                'checksum' => substr($vlt_data,220,8),
                'vlt_data' => $vlt_data,
                'device_time' => $device_time,
                'created_at' => $dt,
                'updated_at' => $dt
            ]);


            $this->updateGpsPrams($gps,$vehicle_mode,$gps_fix,$lat,$lng,$device_time,$main_power_status,$ignition,$gsm_signal_strength,$heading,$speed, $no_of_satelites);
            $this->dispatchAlert($code,$gps,$lat,$lng,$device_time);

        }

    }

    public function processAckData($vlt_data, $dt){
        $comma_seperated = substr($vlt_data,96);
        $imei = substr($vlt_data,3,15);
        $gps = Gps::where('imei',$imei)->first();
        $date = substr($vlt_data,22,6);
        $time = substr($vlt_data,28,6);
        $end_char  = '*';
        $end_pos = strpos($vlt_data, $end_char);
        $bad_response = substr($vlt_data,97,$end_pos);
        $response = str_replace('*','',$bad_response);
        $code = substr($vlt_data,18,2);
        $lat = substr($vlt_data,34,10);
        $lng = substr($vlt_data,45,10);
        $vehicle_mode = substr($vlt_data,95,1);
        $gps_fix = substr($vlt_data,21,1);
        $main_power_status = substr($vlt_data,94,1);
        $ignition = substr($vlt_data,93,1);
        $gsm_signal_strength = substr($vlt_data,91,2);
        $heading = substr($vlt_data,81,6);
        $device_time = $this->getDateTime($date,$time);
        $speed=substr($vlt_data,75,6);
        $packet_status = substr($vlt_data,20,1);
        $no_of_satelites = substr($vlt_data,87,2);

        if($gps){

            $items = $this->ackParser($response, $gps, $device_time);
            $ack_fields = [ 
                'gps_id' => $gps->id,
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
                'response' => $response,
                'vlt_data' => $vlt_data,
                'device_time' => $device_time,
                'created_at' => $dt,
                'updated_at' => $dt 
            ];

            if(array_key_exists("BTP",$items)){
                 $ack_fields["battery_percentage "] = $items["BTP"];
            }
            if(array_key_exists("FUE",$items)){
                 $ack_fields["fuel"] = $items["FUE"];
            }
            if(array_key_exists("SPD",$items)){
                 $ack_fields["speed"] = $items["SPD"];
            }
            if(array_key_exists("IGN",$items)){
                 $ack_fields["ignition"] = $items["IGN"];
            }
            if(array_key_exists("AC",$items)){
                 $ack_fields["ac_status"] = $items["AC"];
            }
            $status = GpsData::create($ack_fields);

            $this->updateGpsPrams($gps,$vehicle_mode,$gps_fix,$lat,$lng,$device_time,$main_power_status,$ignition,$gsm_signal_strength,$heading,$speed, $no_of_satelites); 

            $this->dispatchAlert($code,$gps,$lat,$lng,$device_time);

        }

    }


    public function processAltData($vlt_data, $dt){
        $imei = substr($vlt_data,3,15);
        $gps = Gps::where('imei',$imei)->first();
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

        if($gps){
            $status = GpsData::create([ 
                'gps_id' => $gps->id,
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
                'gf_id' => substr($vlt_data,96,5),
                'vlt_data' => $vlt_data,
                'device_time' => $device_time,
                'created_at' => $dt,
                'updated_at' => $dt
            ]); 

            $this->updateGpsPrams($gps,$vehicle_mode,$gps_fix,$lat,$lng,$device_time,$main_power_status,$ignition,$gsm_signal_strength,$heading,$speed, $no_of_satelites); 

            $this->dispatchAlert($code,$gps,$lat,$lng,$device_time);

        }

    }

    public function processCrtData($vlt_data, $dt){
        $imei = substr($vlt_data,3,15);
        $gps = Gps::where('imei',$imei)->first();
        $code = substr($vlt_data,18,2);
        $date = substr($vlt_data,22,6);
        $time = substr($vlt_data,28,6);
        $lat = substr($vlt_data,34,10);
        $lng = substr($vlt_data,45,10);
        $vehicle_mode = substr($vlt_data,95,1);
        $gps_fix = substr($vlt_data,21,1);
        $main_power_status = substr($vlt_data,94,1);
        $ignition = substr($vlt_data,93,1);
        $heading = substr($vlt_data,81,6);
        $gsm_signal_strength = substr($vlt_data,91,2);
        $device_time = $this->getDateTime($date,$time);
        $speed=substr($vlt_data,75,6);
        $packet_status = substr($vlt_data,20,1);
        $no_of_satelites = substr($vlt_data,87,2);

        if($gps){
            $status = GpsData::create([ 
                'gps_id' => $gps->id,
                'header' => substr($vlt_data,0,3),
                'imei' => substr($vlt_data,3,15),
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
                'gf_id' => substr($vlt_data,96,5),
                'vlt_data' => $vlt_data,
                'device_time' => $device_time,
                'created_at' => $dt,
                'updated_at' => $dt,
            ]);


            $this->updateGpsPrams($gps,$vehicle_mode,$gps_fix,$lat,$lng,$device_time,$main_power_status,$ignition,$gsm_signal_strength,$heading,$speed, $no_of_satelites); 

            $this->dispatchAlert($code,$gps,$lat,$lng,$device_time);

        }
    }

    public function processEpbData($vlt_data, $dt){
        $imei = substr($vlt_data,3,15);
        $gps = Gps::where('imei',$imei)->first();
        $date = substr($vlt_data,22,6);
        $time = substr($vlt_data,28,6);
        $code = substr($vlt_data,18,2);
        $lat = substr($vlt_data,34,10);
        $lng = substr($vlt_data,45,10);
        $vehicle_mode = substr($vlt_data,95,1);
        $gps_fix = substr($vlt_data,21,1);
        $main_power_status = substr($vlt_data,94,1);
        $ignition = substr($vlt_data,93,1);
        $gsm_signal_strength = substr($vlt_data,91,2);
        $heading = substr($vlt_data,81,6);
        $device_time = $this->getDateTime($date,$time);
        $speed=substr($vlt_data,75,6);
        $packet_status = substr($vlt_data,20,1);
        $no_of_satelites = substr($vlt_data,87,2);

        if($gps){
            $status = GpsData::create([ 
                'gps_id' => $gps->id,
                'header' => substr($vlt_data,0,3),
                'imei' => substr($vlt_data,3,15),
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
                'vlt_data' => $vlt_data,
                'device_time' => $device_time,
                'created_at' => $dt,
                'updated_at' => $dt
            ]); 

            $this->updateGpsPrams($gps,$vehicle_mode,$gps_fix,$lat,$lng,$device_time,$main_power_status,$ignition,$gsm_signal_strength,$heading,$speed, $no_of_satelites); 

            $this->dispatchAlert($code,$gps,$lat,$lng,$device_time);

        }

    }

    public function processBthData($vlt_data, $dt){

        $imei = substr($vlt_data,3,15);
        $gps = Gps::where('imei',$imei)->first();
        if($gps){
            $response = $this->splitBth($vlt_data, $gps, $dt);
            return $response;
        }else{
            return "Gps not registered ".$imei;
        }

    }

    public function splitBth($bth, $gps, $dt){
        $vltdata=$bth;
        $header=substr($vltdata,0,3);
        $imei=substr($vltdata, 3, 15);
        $count=substr($vltdata, 18, 3);
        $packet_removed_head=substr($vltdata,21);
        $alert_id = substr( $packet_removed_head,0,2);
        $status = $this->batchParse($alert_id,$packet_removed_head, $imei);

        $final = [];
        $final[] = array("packet"=>$status['packet'][0]);

        while(strlen($status['batch']) > 0){        
            $alert_id = substr($status['batch'],0,2);
            $response = $this->batchParse($alert_id,$status['batch'],$imei);
            $status = $response;
            $final[] =array("packet"=>$status['packet'][0]);
        }

        foreach ($final as $item) {
            $vltdata = $item['packet'];
            \App\Http\Controllers\HttpGpsController::processGpsData($vltdata, $dt) ;
        }

    }

    public function batchParse($alert_id, $batch, $imei){
            $items = [];
            if(in_array($alert_id, array(18))){   
                $size=83;
                $header = "ALT";
                $parsed = substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                $final_packet=array('packet'=>$items,'batch'=>$balanced_packet);
                return $final_packet;
            }else if(in_array($alert_id, array(19))){
                $size=83;
                $header = "ALT";
                $parsed =substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
            }else if(in_array($alert_id, array(20))){
                $size=83;
                $header = "CRT";
                $parsed = substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
            }else if (in_array($alert_id, array(21))){
                $size=83;
                $header = "CRT";
                $parsed = substr($packet_start,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
            }else if(in_array($alert_id, array(22))){
                $size=78;
                $header = "CRT";
                $parsed = substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
            }else if(in_array($alert_id, array(25))){
                $size=210;
                $header = "FUL";
                $parsed = substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);               
            }else if(in_array($alert_id, array(16,03,17,23))){
                $size=78;
                $header = "CRT";
                $parsed = substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
            }else if(in_array($alert_id, array("09",13,14,15,18,19,"06","04","05"))){
                $size=78;
                $header = "ALT";
                $parsed = substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
            }else if(in_array($alert_id, array("01"))){
                $size=78;
                $header = "NRM";
                $parsed = substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
            }else if(in_array($alert_id, array(10,11))){
                $size=78;
                $header = "EPB";
                $parsed = substr($batch,0,$size);
                $items[] = $header.$imei.$parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
            }
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


    public static function updateGpsPrams($gps,$vehicle_mode,$gps_fix,$lat,$lng,$device_time,$main_power_status,$ignition,$gsm_signal_strength,$heading,$speed, $no_of_satellites){

                if(strtotime($device_time) > strtotime($gps->device_time))
                {

                    if($gps->device_time){
                        $gps_updates = VehicleDailyUpdate::where('gps_id',$gps->id)->where('date',date('Y-m-d'))->first();
                        if($gps_updates){

                            if($gps->ignition == 1 || $gps->ignition == 0 ){
                                $ign_dur = GpsDataProcessorTrait::igDuration($gps->ignition,$gps->device_time,$device_time);
                                $key = key($ign_dur);
                                $gps_updates->$key = $gps_updates->$key + $ign_dur[$key];
                            }
                            if($gps->ac_status == 1 || $gps->ac_status == 0){
                                $ac_dur = GpsDataProcessorTrait::acDuration($gps->ac_status,$gps->mode,$gps->device_time,$device_time);
                                $key = key($ac_dur);
                                $gps_updates->$key = $gps_updates->$key + $ac_dur[$key];
                            }

                            if($gps->mode){
                                $mode_dur = GpsDataProcessorTrait::vehicleDuration($gps->mode,$gps->device_time,$gps->speed,$gps->ignition,$device_time);
                                $key = key($mode_dur);
                                $gps_updates->$key = $gps_updates->$key + $mode_dur[$key];
                            }

                            $gps_updates->save();

                        }else{
                            $gps_updates = new VehicleDailyUpdate;

                            $gps_updates->gps_id = $gps->id;

                            if($gps->ignition == 1 || $gps->ignition == 0 ){
                                $ign_dur = GpsDataProcessorTrait::igDuration($gps->ignition,$gps->device_time,$device_time);
                                $key = key($ign_dur);
                                $gps_updates->$key = $ign_dur[$key];
                            }
                            if($gps->ac_status == 1 || $gps->ac_status == 0){
                                $ac_dur = GpsDataProcessorTrait::acDuration($gps->ac_status,$gps->mode,$gps->device_time,$device_time);
                                $key = key($ac_dur);
                                $gps_updates->$key = $ac_dur[$key];
                            }
                            if($gps->mode){
                                $mode_dur = GpsDataProcessorTrait::vehicleDuration($gps->mode,$gps->device_time,$gps->speed,$gps->ignition,$device_time);
                                $key = key($mode_dur);
                                $gps_updates->$key = $mode_dur[$key];
                            }
                            $gps_updates->date = date('Y-m-d');

                            $gps_updates->save();

                        }

                    }
                    if($gps_fix){
                        if($vehicle_mode == "M"){
                            if($gps->lat){
                                $km = GpsDataProcessorTrait::updateKm($lat, $lng, $gps->lat, $gps->lon, $gps->id, $device_time, $speed);
                                $gps->km = $gps->km + $km;

                                $daily_km = DailyKm::where('gps_id',$gps->id)->where('date', date("Y-m-d"))->first();
                                if($daily_km){
                                    $daily_km->km = $daily_km->km + $km;
                                    $daily_km->save();
                                }else{
                                    DailyKm::create([
                                        'gps_id' => $gps->id,
                                        'km' => $km,
                                        'date' => date("Y-m-d")
                                    ]);
                                }
                            }

                            if($speed > 0){
                                $gps->heading = $heading;
                            }
                        }
                        $gps->lat= $lat;
                        $gps->lon = $lng;
                        $gps->speed = $speed;
                        $gps->device_time = $device_time;
                        $gps->no_of_satellites = $no_of_satellites;
                    }

                    $gps->mode = $vehicle_mode;
                    $gps->main_power_status = $main_power_status;
                    $gps->ignition = $ignition;
                    $gps->gsm_signal_strength = $gsm_signal_strength;

                    if($vehicle_mode == "M" && $ignition == 0){
                         $gps->mode = "H";
                    }
                    $gps->save();  
            }             
    }

    public static function vehicleDuration($server_mode,$server_device_time,$server_speed,$server_ignition,$device_device_time){
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $server_device_time);
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $device_device_time);
        $diff_in_seconds = $to->diffInSeconds($from);
        $mode_status=[];
        if($server_mode == "M"){
            if($server_speed <= 0 &&  $server_ignition == 1)
            {
                $mode_status['stop'] = $diff_in_seconds;
            }
            else if($server_ignition == 0)
            {
                $mode_status['stop'] = $diff_in_seconds;
            }
            else if($server_speed > 0 &&  $server_ignition == 1)
            {
                $mode_status['moving'] = $diff_in_seconds;
            }
        }else if($server_mode == "H"){
            $mode_status['halt'] = $diff_in_seconds;
        }else if($server_mode == "S"){
            $mode_status['sleep'] = $diff_in_seconds;
        }
        return $mode_status;
    }


    public static function igDuration($server_ignition, $server_device_time, $device_device_time){
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $server_device_time);
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $device_device_time);
        $diff_in_seconds = $to->diffInSeconds($from);
        $engine_status=[];
        if($server_ignition == 1){
            $engine_status['ignition_on'] = $diff_in_seconds;
        }else if($server_ignition == 0){
            $engine_status['ignition_off'] = $diff_in_seconds;
        }
        return $engine_status;
    }

    public static function acDuration($server_ac, $server_vehicle_mode, $server_device_time, $device_device_time)
    {
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $server_device_time);
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $device_device_time);
        $diff_in_sec = $to->diffInSeconds($from);
        $ac_status=[];
        if($server_ac == 0){
            $ac_status['ac_off']= $diff_in_sec;
        }else{
            if($server_vehicle_mode == "H" || $server_vehicle_mode == "S")
            {
                //add to ac halt on time
                $ac_status['ac_on_idle']  = $diff_in_sec;
            }
            else
            {
                $ac_status['ac_on']= $diff_in_sec;
            }
        }
     return $ac_status;
    }

    public function dispatchAlert($code,$gps,$lat,$lng,$device_time){

        $alert_type = AlertType::where('code',(int)$code)->first();
        $alert = Alert::create([
                    'alert_type_id' => $alert_type->id,
                    'device_time' => $device_time,
                    'gps_id' => $gps->id,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'status' => 0
                ]);
        if($code == 10){
            if($gps->emergency_status == 0){
                // $message = "Your vehicle ".$vehicle->register_number." In an emergency situation http://gpsvst.vehiclest.com";
                // $mobile = $vehicle->client->user->mobile;
                // Queue::push(new AlertJob($code,$gps->imei,$lat,$lng,$device_time));
                // Queue::push(new SendSms($mobile,$message));
                $gps->emergency_status = 1;
                $gps->save();
            }
        }else if($code == 11) {
            $gps->emergency_status = 0;
            $gps->save();
        }

        if($gps->vehicle){
            $critical_alerts = array(1,12,13,14,15,16);
            if (in_array($alert_type->id, $critical_alerts)) {

               $vehicle = $gps->vehicle;

               $points = ClientAlertPoint::where('client_id',$vehicle->client->id)->where('alert_type_id',$alert_type->id)->first(); 

               if($vehicle->driver){
                   $driver = Driver::find($vehicle->driver->id);
                   $driver->points = $driver->points - $points->driver_point;
                   $driver->save();

                   DriverBehaviour::create([
                    'vehicle_id' => $vehicle->id,
                    'driver_id' => $driver->id,
                    'gps_id' =>  $gps->id,
                    'alert_id' => $alert->id,
                    'points' => $points->driver_point
                   ]);
               }
            } 
        }

    }


    public function ackParser($data, $gps, $device_time){

        $fields = [];

        $params = explode (",", $data);
        // $gps_config = GpsConfiguration::where('gps_id',$gps_id)->first();

        foreach($params as $item){
            $attribute = explode (":", $item);
            if($attribute[0] ==  "BTP"){
                $fields["BTP"] = $attribute[1];
            }else if($attribute[0] ==  "FUE"){
                $fields["FUE"] = $attribute[1];
            }else if($attribute[0] ==  "SPD"){  
                $fields["SPD"] = $attribute[1];
            }else if($attribute[0] ==  "IGN"){
                $fields["IGN"] = $attribute[1];
            }else if($attribute[0] ==  "AC"){
                $fields["AC"] = $attribute[1];
            }

            // $key = $attribute[0];
            // $gps_config->$key= $attribute[1];

            OtaUpdate::create([
                'gps_id' => $gps->id,
                'header' => $attribute[0],
                'value' => $attribute[1],
                'device_time' => $device_time
            ]);
        }

        // $gps_config->save();
        if(strtotime($device_time) > strtotime($gps->device_time))
        {
            $items = explode (",", $data);
            foreach($items as $item){
                $attribute = explode (":", $item);
                if($attribute[0] ==  "BTP"){
                    $gps->battery_status = $attribute[1];
                }else if($attribute[0] ==  "FUE"){
                    $gps->fuel_status = $attribute[1];
                }else if($attribute[0] ==  "SPD"){  
                    $gps->speed = $attribute[1];
                }else if($attribute[0] ==  "IGN"){
                    $gps->ignition = $attribute[1];
                }else if($attribute[0] ==  "AC"){
                    $gps->ac_status = $attribute[1];
                }              
            }
            $gps->save();
            // $gps_config->save();
        }

        return $fields;
    }

    public static function updateKm($new_lat, $new_lng, $old_lat, $old_lng, $gps_id, $device_time, $speed){

        $array = [
            'trk' => [
                'trkseg' => [ 
                        'trkpt' => ['_attributes' => ['lat' => $new_lat, 'lon' => $new_lng]],
                        'trkpt' => ['_attributes' => ['lat' => $old_lat, 'lon' => $old_lng]],
                            ]
            ]
        ];

        $result = ArrayToXml::convert($array, [
            'rootElementName' => 'gpx',
            '_attributes' => [
                'version' => '1.0',
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                'xmlns' => 'http://www.topografix.com/GPX/1/0',
                'xsi:schemaLocation' => 'http://www.topografix.com/GPX/1/0 http://www.topografix.com/GPX/1/0/gpx.xsd',
            ],
        ], true, 'UTF-8');

        $client = new \GuzzleHttp\Client(['base_uri' => 'https://rme.api.here.com']);

        $resp = $client->request('POST', '/2/matchroute.json?app_id=pTDh57IDvFztTZUGw15X&app_code=673-fZdOmD_oJnCMZ_ko-g', ['body' => $result]);

        $points = (string) $resp->getBody();

        $points = json_decode($points, true);

        $km =0;

        foreach ($points  as $key => $value) {
            if($key == "RouteLinks"){
                foreach ($value as $key => $value) {
                    $km = $km + $value['linkLength'];
                }
            }
        }


        KmUpdate::create([
            'gps_id' => $gps_id,
            'km' => $km,
            'lat' => $new_lat,
            'lng' => $new_lng,
            'device_time' => $device_time,
            'speed' => $speed
        ]);

        return $km;

    }


}
