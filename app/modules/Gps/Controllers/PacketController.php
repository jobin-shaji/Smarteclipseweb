<?php 


namespace App\Modules\Gps\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Gps\Models\GpsLocation;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\User\Models\User;

class PacketController extends Controller {

    public function processGpsData(Request $request){

    	$vlt_data  = $request->vltdata;
        $header =substr($vlt_data,0,4);

        switch ($header) {
        	case 'NRM':
        		$this->processNrmData($vlt_data);
        		break;
        	case 'HLM':
        		$this->processHlmData($vlt_data);
        		break;
        	case 'LGN':
        		$this->processLgnData($vlt_data);
        		break;
        	case 'FUL':
        		$this->processFulData($vlt_data);
        		break;
        	case 'ACK':
        		$this->processAckData($vlt_data);
        		break;
        	case 'ALT':
        		$this->processAltData($vlt_data);
        		break;
        	case 'CRT'
        		$this->processCrtData($vlt_data);
        		break;
        	case 'EPB'
        		$this->processEpbData($vlt_data);
        		break;
        	case 'BTH'
        		$this->processBthData($vlt_data);
        		break;
        	
        	default:
        		# code...
        		break;
        }

    }


    public function processHlmData($vlt_data){

        $header=substr($vlt_data,2,3);
        $vendor_id=substr($vlt_data,5,6);
        $firmware_version=substr($vlt_data,11,6);
        $imei=substr($vlt_data,17,15);
        $update_rate_ignition_on = substr($vlt_data,32,3);
        $update_rate_ignition_off = substr($vlt_data,35,3);
        $battery_percentage = substr($vlt_data,38,3);
        $low_battery_threshold_value = substr($vlt_data,41,3);
        $memory_percentage = substr($vlt_data,44,3);
        $digital_io_status = substr($vlt_data,47,6);
        $analog_io_status = substr($vlt_data,53,8);
    }

    public function processLgnData($vlt_data){

        $header = substr($vlt_data,2,3);
        $imei = substr($vlt_data,5,15);
        $activation_key = substr($vlt_data,20,16);
        $latitude = substr($vlt_data,36,10);
        $lat_dir = substr($vlt_data,46,1);
        $longitude = substr($vlt_data,47,10);
        $lon_dir = substr($vlt_data,57,1);
        $date = substr($vlt_data,58,6);
        $time = substr($vlt_data,64,6);
        $speed = substr($vlt_data,70,6);

    }

    public function processNrmPacket($vlt_data){

        $header = substr($vlt_data,2,3);
        $imei = substr($vlt_data,5,15);
        $alert_id = substr($vlt_data,20,2);
        $packet_status = substr($vlt_data,22,1);
        $gps_fix = substr($vlt_data,23,1);
        $date = substr($vlt_data,24,6);
        $time = substr($vlt_data,30,6);
        $latitude = substr($vlt_data,36,10);
        $lat_dir = substr($vlt_data,46,1);
        $longitude = substr($vlt_data,47,10);
        $lon_dir = substr($vlt_data,57,1);
        $mcc = substr($vlt_data,58,3);
        $mnc = substr($vlt_data,61,3);
        $lac = substr($vlt_data,64,4);
        $cell_id = substr($vlt_data,68,9);
        $speed = substr($vlt_data,77,6);
        $heading = substr($vlt_data,83,6);
        $no_of_satelites = substr($vlt_data,89,2);
        $hdop = substr($vlt_data,91,2);
        $gsm_signal_strength = substr($vlt_data,93,2);
        $ignition = substr($vlt_data,95,1);
        $main_power_status = substr($vlt_data,96,1);
        $vehicle_mode = substr($vlt_data,97,1);

    }


    public function processFulData($vlt_data){

        $header = substr($vlt_data,2,3);
        $imei = substr($vlt_data,5,15);
        $alert_id = substr($vlt_data,20,2);
        $packet_status = substr($vlt_data,22,1);
        $gps_fix = substr($vlt_data,23,1);
        $date = substr($vlt_data,24,6);
        $time = substr($vlt_data,30,6);
        $latitude = substr($vlt_data,36,10);
        $lat_dir = substr($vlt_data,46,1);
        $longitude = substr($vlt_data,47,10);
        $lon_dir = substr($vlt_data,57,1);
        $mcc = substr($vlt_data,58,3);
        $mnc = substr($vlt_data,61,3);
        $lac = substr($vlt_data,64,4);
        $cell_id = substr($vlt_data,68,9);
        $speed = substr($vlt_data,77,6);
        $heading = substr($vlt_data,83,6);
        $no_of_satelites = substr($vlt_data,89,2);
        $hdop = substr($vlt_data,91,2);
        $gsm_signal_strength = substr($vlt_data,93,2);
        $ignition = substr($vlt_data,95,1);
        $main_power_status = substr($vlt_data,96,1);
        $vehicle_mode = substr($vlt_data,97,1);
        $vendor_id = substr($vlt_data,98,6);
        $firmware_version = substr($vlt_data,104,6);
        $vehicle_register_num = substr($vlt_data,110,16);
        $altitude = substr($vlt_data,126,7);
        $pdop = substr($vlt_data,133,2);
        $network_operator_name = substr($vlt_data,135,9);
        $nmr = substr($vlt_data,144,60);
        $main_input_voltage = substr($vlt_data,204,5);
        $internal_battery_voltage = substr($vlt_data,209,5);
        $tamper_alert = substr($vlt_data,214,1);
        $digital_input_status = substr($vlt_data,215,4);
        $digital_output_status = substr($vlt_data,219,2);
        $frame_num = substr($vlt_data,221,6);
        $checksum = substr($vlt_data,227,8);

    }

    public function processAckData($vlt_data){

        $header = substr($vlt_data,2,3);
        $imei = substr($vlt_data,5,15);
        $alert_id = substr($vlt_data,20,2);
        $packet_status = substr($vlt_data,22,1);
        $gps_fix = substr($vlt_data,23,1);
        $date = substr($vlt_data,24,6);
        $time = substr($vlt_data,30,6);
        $latitude = substr($vlt_data,36,10);
        $lat_dir = substr($vlt_data,46,1);
        $longitude = substr($vlt_data,47,10);
        $lon_dir = substr($vlt_data,57,1);
        $mcc = substr($vlt_data,58,3);
        $mnc = substr($vlt_data,61,3);
        $lac = substr($vlt_data,64,4);
        $cell_id = substr($vlt_data,68,9);
        $speed = substr($vlt_data,77,6);
        $heading = substr($vlt_data,83,6);
        $no_of_satelites = substr($vlt_data,89,2);
        $hdop = substr($vlt_data,91,2);
        $gsm_signal_strength = substr($vlt_data,93,2);
        $ignition = substr($vlt_data,95,1);
        $main_power_status = substr($vlt_data,96,1);
        $vehicle_mode = substr($vlt_data,97,1);
        $comma_seperated = substr($vlt_data,98);

        $key_pairs = explode(",",$comma_seperated);
        $pu = $key_pairs[0];
        $sl = $key_pairs[1];
        $ou = $key_pairs[2];
        $ou = str_replace("*","",$ou);

    }

    public function processAltData($vlt_data){

        $header = substr($vlt_data,2,3);
        $imei = substr($vlt_data,5,15);
        $alert_id = substr($vlt_data,20,2);
        $packet_status = substr($vlt_data,22,1);
        $gps_fix = substr($vlt_data,23,1);
        $date = substr($vlt_data,24,6);
        $time = substr($vlt_data,30,6);
        $latitude = substr($vlt_data,36,10);
        $lat_dir = substr($vlt_data,46,1);
        $longitude = substr($vlt_data,47,10);
        $lon_dir = substr($vlt_data,57,1);
        $mcc = substr($vlt_data,58,3);
        $mnc = substr($vlt_data,61,3);
        $lac = substr($vlt_data,64,4);
        $cell_id = substr($vlt_data,68,9);
        $speed = substr($vlt_data,77,6);
        $heading = substr($vlt_data,83,6);
        $no_of_satelites = substr($vlt_data,89,2);
        $hdop = substr($vlt_data,91,2);
        $gsm_signal_strength = substr($vlt_data,93,2);
        $ignition = substr($vlt_data,95,1);
        $main_power_status = substr($vlt_data,96,1);
        $vehicle_mode = substr($vlt_data,97,1);
        $gf_id = substr($vlt_data,98,5);

    }

    public function processCrtData($vlt_data){

        $header = substr($vlt_data,2,3);
        $imei = substr($vlt_data,5,15);
        $alert_id = substr($vlt_data,20,2);
        $packet_status = substr($vlt_data,22,1);
        $gps_fix = substr($vlt_data,23,1);
        $date = substr($vlt_data,24,6);
        $time = substr($vlt_data,30,6);
        $latitude = substr($vlt_data,36,10);
        $lat_dir = substr($vlt_data,46,1);
        $longitude = substr($vlt_data,47,10);
        $lon_dir = substr($vlt_data,57,1);
        $mcc = substr($vlt_data,58,3);
        $mnc = substr($vlt_data,61,3);
        $lac = substr($vlt_data,64,4);
        $cell_id = substr($vlt_data,68,9);
        $speed = substr($vlt_data,77,6);
        $heading = substr($vlt_data,83,6);
        $no_of_satelites = substr($vlt_data,89,2);
        $hdop = substr($vlt_data,91,2);
        $gsm_signal_strength = substr($vlt_data,93,2);
        $ignition = substr($vlt_data,95,1);
        $main_power_status = substr($vlt_data,96,1);
        $vehicle_mode = substr($vlt_data,97,1);
        $gf_id = substr($vlt_data,98,5);

    }

    public function processEpbData($vlt_data){

        $header = substr($vlt_data,2,3);
        $imei = substr($vlt_data,5,15);
        $alert_id = substr($vlt_data,20,2);
        $packet_status = substr($vlt_data,22,1);
        $gps_fix = substr($vlt_data,23,1);
        $date = substr($vlt_data,24,6);
        $time = substr($vlt_data,30,6);
        $latitude = substr($vlt_data,36,10);
        $lat_dir = substr($vlt_data,46,1);
        $longitude = substr($vlt_data,47,10);
        $lon_dir = substr($vlt_data,57,1);
        $mcc = substr($vlt_data,58,3);
        $mnc = substr($vlt_data,61,3);
        $lac = substr($vlt_data,64,4);
        $cell_id = substr($vlt_data,68,9);
        $speed = substr($vlt_data,77,6);
        $heading = substr($vlt_data,83,6);
        $no_of_satelites = substr($vlt_data,89,2);
        $hdop = substr($vlt_data,91,2);
        $gsm_signal_strength = substr($vlt_data,93,2);
        $ignition = substr($vlt_data,95,1);
        $main_power_status = substr($vlt_data,96,1);
        $vehicle_mode = substr($vlt_data,97,1);
        
    }

}