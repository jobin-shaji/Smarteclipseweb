<?php

namespace App\Vst;
use \Carbon\Carbon;
use App\GpsData;
use App\Gps;
use App\GpsBatchPointer;
use App\Alert;


class AckProcessor
{

	public $comma_seperated;
    public $imei;
    public $gps;
    public $date;
    public $time;
    public $end_char;
    public $end_pos;
    public $bad_response;
    public $response;
    public $code;
    public $lat;
    public $lng;
    public $vehicle_mode;
    public $gps_fix;
    public $main_power_status;
    public $ignition;
    public $gsm_signal_strength;
    public $heading;
    public $device_time;
    public $speed;
    public $packet_status;
    public $no_of_satelites;

	public function __construct($vlt_data)
    {

        $this->comma_seperated = substr($vlt_data,96);
        $this->imei = substr($vlt_data,3,15);
        // $this->gps = Gps::where('imei',$this->imei)->first();
        $this->date = substr($vlt_data,22,6);
        $this->time = substr($vlt_data,28,6);
        $this->end_char  = '*';
        $this->end_pos = strpos($vlt_data, $this->end_char);
        $this->bad_response = substr($vlt_data,97,$this->end_pos);
        $this->response = str_replace('*','',$this->bad_response);
        $this->code = substr($vlt_data,18,2);
        $this->lat = substr($vlt_data,34,10);
        $this->lng = substr($vlt_data,45,10);
        $this->vehicle_mode = substr($vlt_data,95,1);
        $this->gps_fix = substr($vlt_data,21,1);
        $this->main_power_status = substr($vlt_data,94,1);
        $this->ignition = substr($vlt_data,93,1);
        $this->gsm_signal_strength = substr($vlt_data,91,2);
        $this->heading = substr($vlt_data,81,6);
        $this->device_time = getDateTime($this->date,$this->time);
        $this->speed=substr($vlt_data,75,6);
        $this->packet_status = substr($vlt_data,20,1);
        $this->no_of_satelites = substr($vlt_data,87,2);
            
    }


}