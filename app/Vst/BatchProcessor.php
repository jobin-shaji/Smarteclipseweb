<?php

namespace App\Vst;
use App\BthData;
use \Carbon\Carbon;
use App\Gps;


class BatchProcessor
{
	protected $bth;
	protected $imei;
	protected $header;

	public function processBth($bth)
    {

    	$this->bth = $bth;

        $packet = $this->bth;
        $this->header=substr($packet,0,3);
        $this->imei = substr($packet,3,15);

        $batch_log_count = substr($packet,18,3);
        $balance_packet = substr($packet,21);
        $packets=[];
        do
        {
            $return_array=$this->bthSlicer($balance_packet);
            $balance_packet=$return_array['balance_packet'];
            $packets[]=$return_array['packet'];
        }
        while (!empty($balance_packet));

        return $packets;

    }

    public function bthSlicer($balance_packet)
    {
    	$imei = $this->imei;
        $alert_id = substr($balance_packet,0,2);
        if($alert_id == "01" || $alert_id == "02") //NRM
        {
            $nrm_alert_id_to_mode = substr($balance_packet,0,78);
            $normal_packet="NRM".$imei.$nrm_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $date = substr($normal_packet,22,6);
            $time = substr($normal_packet,28,6);
            $device_time = getDateTime($date,$time);
            $chunk = [];
            $chunk["device_time"] = $device_time;
            $chunk["packet"] = $normal_packet;
            $return_array=[
                    'packet' => $chunk,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "10" || $alert_id == "11")//EPB
        {
            $epb_alert_id_to_mode = substr($balance_packet,0,78);
            $emergency_packet="EPB".$imei.$epb_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $date = substr($emergency_packet,22,6);
            $time = substr($emergency_packet,28,6);
            $device_time = getDateTime($date,$time);
            $chunk = [];
            $chunk["device_time"] = $device_time;
            $chunk["packet"] = $emergency_packet;
            $return_array=[
                    'packet' => $chunk,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "16" || $alert_id == "03" || $alert_id == "17" || $alert_id == "22" || $alert_id == "23")//CRT
        {
            $crt_alert_id_to_mode = substr($balance_packet,0,78);
            $critical_packet="CRT".$imei.$crt_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $date = substr($critical_packet,22,6);
            $time = substr($critical_packet,28,6);
            $device_time = getDateTime($date,$time);
            $chunk = [];
            $chunk["device_time"] = $device_time;
            $chunk["packet"] = $critical_packet;
            $return_array=[
                    'packet' => $chunk,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "20" || $alert_id == "21")//CRT
        {
            $crt_alert_id_to_mode = substr($balance_packet,0,83);
            $critical_packet="CRT".$imei.$crt_alert_id_to_mode;
            $balance_packet=substr($balance_packet,83);
            $date = substr($critical_packet,22,6);
            $time = substr($critical_packet,28,6);
            $device_time = getDateTime($date,$time);
            $chunk = [];
            $chunk["device_time"] = $device_time;
            $chunk["packet"] = $critical_packet;
            $return_array=[
                    'packet' => $chunk,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "13" || $alert_id == "14" || $alert_id == "15" || $alert_id == "06" || $alert_id == "04" || $alert_id == "05" || $alert_id == "09") //ALT
        {
            $alert_alert_id_to_mode = substr($balance_packet,0,78);
            $alert_packet="ALT".$imei.$alert_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $date = substr($alert_packet,22,6);
            $time = substr($alert_packet,28,6);
            $device_time = getDateTime($date,$time);
            $chunk = [];
            $chunk["device_time"] = $device_time;
            $chunk["packet"] = $alert_packet;
            $return_array=[
                    'packet' => $chunk,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "18" || $alert_id == "19") //ALT
        {
            $alert_alert_id_to_mode = substr($balance_packet,0,83);
            $alert_packet="ALT".$imei.$alert_alert_id_to_mode;
            $balance_packet=substr($balance_packet,83);
            $date = substr($alert_packet,22,6);
            $time = substr($alert_packet,28,6);
            $device_time = getDateTime($date,$time);;
            $chunk = [];
            $chunk["device_time"] = $device_time;
            $chunk["packet"] = $alert_packet;
            $return_array=[
                    'packet' => $chunk,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "25") //FUL
        {
            $alert_alert_id_to_mode = substr($balance_packet,0,210);
            $alert_packet="FUL".$imei.$alert_alert_id_to_mode;
            $balance_packet=substr($balance_packet,210);
            $date = substr($alert_packet,22,6);
            $time = substr($alert_packet,28,6);
            $device_time = getDateTime($date,$time);
            $chunk = [];
            $chunk["device_time"] = $device_time;
            $chunk["packet"] = $alert_packet;
            $return_array=[
                    'packet' => $chunk,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
    }
    
}
