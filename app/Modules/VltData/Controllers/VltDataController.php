<?php
namespace App\Modules\VltData\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\VltData\Models\VltData;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Ota\Models\OtaResponse;
use App\Http\Traits\MqttTrait;

class VltDataController extends Controller
{
    CONST VLT_DTA_HEADER_NORMAL                 =   'NRM';
    CONST VLT_DTA_HEADER_FULL                   =   'FUL';
    CONST VLT_DTA_HEADER_EMERGENCY              =   'EPB';
    CONST VLT_DTA_HEADER_CRITICAL               =   'CRT';
    CONST VLT_DTA_HEADER_BATCH                  =   'BTH';
    CONST VLT_DTA_HEADER__OTA_ACKNOWLEDGMENT    =   'ACK';
    CONST VLT_DTA_HEADER_ACKNOWLEDGMENT         =   'AVK';
    CONST VLT_DTA_HEADER_HEALTH                 =   'HLM';
    CONST VLT_DTA_HEADER_LOGIN                  =   'LGN';
    CONST VLT_DTA_HEADER_ALERT                  =   'ALT';
    /**
     * 
     * 
     *
     */
    use MqttTrait;
    /**
     *
     */
    public $imei;

    /**
     *
     *
     */
    public $header;

    /**
     *
     *
     */
    public $search_key;
    /**
     *
     *
     */

    public function __construct()
    {
        $this->topic    = 'cmd';
    }

    /**
     *
     *
     */
    public function unprocessedDataView(Request $request)
    {
        $imei_list          = (new Gps())->getImeiList();
        $gps_header_list    = self::getVltDataHeaders();
        $data               = [];
        // params
        $this->imei         = ( isset($request->imei) ) ? $request->imei : '';
        $this->header       = ( isset($request->header) ) ? $request->header : '';
        $this->search_key   = ( isset($request->search_key) ) ? $request->search_key : '';
        $this->vltDate      = ( isset($request->vltDate) ) ?date("Ymd", strtotime($request->vltDate)) : date('Ymd');
        // $search_from_date=;
        // filters
        $filters            = [
            'imei'          => $this->imei,
            'header'        => $this->header,
            'search_key'    => $this->search_key,
            'vltDate'       =>( isset($request->vltDate) ) ?$request->vltDate : date('d-m-Y')
        ];

        if( ($this->imei != '') || ($this->header != '') )
        {
            // dd($this->vltDate);
            $data           = (new VltData())->getUnprocessedVltData($this->imei, $this->header, $this->search_key,$this->vltDate);
        }
        // dd($data);
        // $data=[];
        return view('VltData::unprocessed-list', [ 'imei_list' => $imei_list, 'headers' => $gps_header_list, 'data' => $data, 'filters' => $filters ]);
    }

    /**
     *
     *
     */
    public function getGpsIdFromImei(Request $request)
    {
        $imei           =   $request->imei;
        $gps_data     =   (new Gps())->getGpsId($imei );
        if($gps_data == null)
        {
            $response    =  array(
                'status'    =>  0,
                'message'   =>  'failed'
            );
        }
        else
        {
            $response    =  array(
                'status'        =>  1,
                'message'       =>  'success',
                'gps_id'        =>  $gps_data->id
            );
        }
        return response()->json($response);
    }

    /**
     *
     *
     */
    public function consoleDataView(Request $request)
    {
        $imei_serial_no_list    = (new Gps())->getImeiList();
        $data                   = [];
        // params
        $this->imei             = ( isset($request->imei) ) ? $request->imei : '';

        // filters
        $filters    = [
            'imei'  => $this->imei
        ];

        if( $this->imei != '' )
        {
            $data   = (new VltData())->getProcessedVltData($this->imei);
        }

        return view('VltData::console-list', [ 'imei_serial_no_list' => $imei_serial_no_list, 'data' => $data, 'filters' => $filters ]);
    }

    /**
     *
     *
     */
    public static function getVltDataHeaders()
    {
        return [
            self::VLT_DTA_HEADER_NORMAL,
            self::VLT_DTA_HEADER_FULL,
            self::VLT_DTA_HEADER_EMERGENCY,
            self::VLT_DTA_HEADER_CRITICAL,
            self::VLT_DTA_HEADER_BATCH,
            self::VLT_DTA_HEADER__OTA_ACKNOWLEDGMENT,
            self::VLT_DTA_HEADER_ACKNOWLEDGMENT,
            self::VLT_DTA_HEADER_HEALTH,
            self::VLT_DTA_HEADER_LOGIN,
            self::VLT_DTA_HEADER_ALERT
        ];
    }
    /**
     *
     *
     */
    public function consoleDataPacketView(Request $request)
    {
        $vlt_data_id    =   $request->vlt_data_id;
        $imei           =   $request->imei;
        $vlt_data       =   $request->vlt_data;
        $gps_data       =   (new Gps())->getGpsId($imei);
        $header=substr($vlt_data,0,3);

        if($header == "ACK"  || $header == "AVK" )
        {
        $data=$this->processAckData($vlt_data);

        }elseif($header == "ALT")
        {

        $data = $this->processAltData($vlt_data);
        }
        elseif($header == "CRT")
        {

        $data = $this->processCrtData($vlt_data);
        } elseif($header == "EPB")
        {

        $data = $this->processEpbData($vlt_data);
        }
        elseif($header == "FUL")
        {

        $data = $this->processFULData($vlt_data);
        }
        elseif($header == "HLM")
        {

        $data = $this->processHlmData($vlt_data);
        }
        elseif($header == "LGN")
        {

        $data = $this->processLgnData($vlt_data);
        }
        elseif($header == "NRM")
        {

        $data = $this->processNrmData($vlt_data);
        }
        elseif($header == "BTH")
        {
        $imei = substr($vlt_data,3,15);
        $batch_log_count = substr($vlt_data,18,3);
        $balance_packet = substr($vlt_data,21);
        $packets=[];
        do
        {
            $return_array   =   $this->batchPacketSplitting($imei,$balance_packet);
            $balance_packet =   $return_array['balance_packet'];
            $packets[]      =   $return_array['packet'];
        }
        while (!empty($balance_packet));
        $packets['header']="BTH";
        $data           =   $packets;

        }
        else{
        $data = null;
        }
        if($data == null)
        {
            $response    =  array(
                'status'    =>  0,
                'message'   =>  'failed',
                'gps_id'    =>  $gps_data->id
            );
        }
        else
        {
            $response    =  array(
                'status'        =>  1,
                'message'       =>  'success',
                'data'   =>  $data,
                'gps_id'    =>  $gps_data->id
            );
        }
        return response()->json($response);
    }
    /**
     *
     *
    */

    public function processAckData($vlt_data)
    {
        $comma_seperated = substr($vlt_data,96);
        $imei = substr($vlt_data,3,15);
        $date = substr($vlt_data,22,6);
        $time = substr($vlt_data,28,6);
        $end_char  = '*';
        $end_pos = strpos($vlt_data, $end_char);
        $bad_response = substr($vlt_data,96,$end_pos);

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
                'response' => $response,
                'vlt_data' => $vlt_data,
                'response' => $response,
                'comma_seperated'=>$comma_seperated,
                'device_time' => $device_time
            );
            return $array;

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
    public function processCrtData($vlt_data)
    {
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
        $heading = substr($vlt_data,81,6);
        $gsm_signal_strength = substr($vlt_data,91,2);
        $device_time = $this->getDateTime($date,$time);
        $speed=substr($vlt_data,75,6);
        $packet_status = substr($vlt_data,20,1);
        $no_of_satelites = substr($vlt_data,87,2);

        $array=[];
        $array=array(
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
              );
             return $array;

    }

    public function processEpbData($vlt_data){
        $imei = substr($vlt_data,3,15);
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

        $array=[];
        $array=array(
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
                'device_time' => $device_time
              );
             return $array;

    }
    public function processFulData($vlt_data){
    	$imei = substr($vlt_data,3,15);
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
        $array=[];
        $array=array(

                'header' => substr($vlt_data,0,3),
                'imei' => $imei,
                'alert_id' =>$code,
                'packet_status' =>substr($vlt_data,20,1),
                'gps_fix' =>$gps_fix,
                'date' =>$date,
                'time' =>$time,
                'latitude' =>$lat,
                'lat_dir' =>substr($vlt_data,44,1),
                'longitude' =>$lng,
                'lon_dir' =>substr($vlt_data,55,1),
                'mcc' =>substr($vlt_data,56,3),
                'mnc' =>substr($vlt_data,59,3),
                'lac' =>substr($vlt_data,62,4),
                'cell_id' =>substr($vlt_data,66,9),
                'speed' =>substr($vlt_data,75,6),
                'heading' =>$heading,
                'no_of_satelites' =>substr($vlt_data,87,2),
                'hdop' =>substr($vlt_data,89,2),
                'gsm_signal_strength' =>$gsm_signal_strength,
                'ignition' =>$ignition,
                'main_power_status' =>$main_power_status,
                'vehicle_mode' =>$vehicle_mode,
                'vendor_id' =>substr($vlt_data,96,6),
                'firmware_version' => substr($vlt_data,102,6),
                'vehicle_register_num' =>substr($vlt_data,108,16),
                'altitude' =>substr($vlt_data,124,7),
                'pdop' =>substr($vlt_data,131,2),
                'nw_op_name' =>substr($vlt_data,133,6),
                'nmr' =>substr($vlt_data,139,60),
                'main_input_voltage' =>substr($vlt_data,199,5),
                'internal_battery_voltage' =>substr($vlt_data,204,5),
                'tamper_alert' =>substr($vlt_data,209,1),
                'digital_io_status' =>substr($vlt_data,210,4),
                'frame_number' =>substr($vlt_data,214,6),
                'checksum' =>substr($vlt_data,220,8),
                'vlt_data' =>$vlt_data,
                'device_time' =>$device_time
           );
             return $array;

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
        	  'header' =>$header,
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
                 'gps_fix' => $gps_fix,
                'vlt_data' => $vlt_data
              );
             return $array;

    }
    public function batchPacketSplitting($imei,$balance_packet)
    {
        $alert_id = substr($balance_packet,0,2);
        if($alert_id == "01" || $alert_id == "02") //NRM
        {
            $nrm_alert_id_to_mode = substr($balance_packet,0,78);
            $normal_packet="NRM".$imei.$nrm_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $return_array=[
                    'packet' => $normal_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "10" || $alert_id == "11")//EPB
        {
            $epb_alert_id_to_mode = substr($balance_packet,0,78);
            $emergency_packet="EPB".$imei.$epb_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $return_array=[
                    'packet' => $emergency_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "16" || $alert_id == "03" || $alert_id == "17" || $alert_id == "22" || $alert_id == "23")//CRT
        {
            $crt_alert_id_to_mode = substr($balance_packet,0,78);
            $critical_packet="CRT".$imei.$crt_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $return_array=[
                    'packet' => $critical_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "20" || $alert_id == "21")//CRT
        {
            $crt_alert_id_to_mode = substr($balance_packet,0,83);
            $critical_packet="CRT".$imei.$crt_alert_id_to_mode;
            $balance_packet=substr($balance_packet,83);
            $return_array=[
                    'packet' => $critical_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "13" || $alert_id == "14" || $alert_id == "15" || $alert_id == "06" || $alert_id == "04" || $alert_id == "05" || $alert_id == "09") //ALT
        {
            $alert_alert_id_to_mode = substr($balance_packet,0,78);
            $alert_packet="ALT".$imei.$alert_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $return_array=[
                    'packet' => $alert_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "18" || $alert_id == "19") //ALT
        {
            $alert_alert_id_to_mode = substr($balance_packet,0,83);
            $alert_packet="ALT".$imei.$alert_alert_id_to_mode;
            $balance_packet=substr($balance_packet,83);
            $return_array=[
                    'packet' => $alert_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "25") //FUL
        {
            $alert_alert_id_to_mode = substr($balance_packet,0,210);
            $alert_packet="FUL".$imei.$alert_alert_id_to_mode;
            $balance_packet=substr($balance_packet,210);
            $return_array=[
                    'packet' => $alert_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
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
    public function setOtaInConsole(Request $request)
    {
        $gps_id             =   $request->gps_id;
        $command            =   $request->command;
        $response           =   (new OtaResponse())->saveCommandsToDevice($gps_id,$command);
        if($response)
        {
            $gps_details                    =   (new Gps())->getGpsDetails($gps_id);
            $is_command_write_to_device     =   (new OtaResponse())->writeCommandToDevice($gps_details->imei,$command);
            if($is_command_write_to_device)
            {
                $this->topic                    =   $this->topic.'/'.$gps_details->imei;
                $is_mqtt_publish                =   $this->mqttPublish($this->topic, $command);
                if ($is_mqtt_publish === true) 
                {
                    return response()->json([
                        'status' => 1,
                        'title' => 'Success',
                        'message' => 'Command send successfully'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => 0,
                        'title' => 'Error',
                        'message' => 'Try again!!'
                    ]);
                }
            }
            
        }
        else
        {
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Try again!!'
            ]);
        }
    }
}