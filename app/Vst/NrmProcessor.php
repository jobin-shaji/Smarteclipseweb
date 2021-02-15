<?php

namespace App\Vst;
use \Carbon\Carbon;
use App\GpsData;
use App\Gps;
use App\GpsBatchPointer;


class NrmProcessor
{

    public $imei;
    public $gps;
    public $date;
    public $time;
    public $code;
    public $lat;
    public $lng;
    public $gps_fix;
    public $vehicle_mode;
    public $main_power_status;
    public $ignition;
    public $heading;
    public $gsm_signal_strength;
    public $device_time;
    public $speed;
    public $packet_status;


	public function __construct($vlt_data)
    {
		
        $this->imei = substr($vlt_data,3,15);
        // $this->gps = Gps::where('imei',$this->imei)->first();
        $this->date = substr($vlt_data,22,6);
        $this->time = substr($vlt_data,28,6);
        $this->code = substr($vlt_data,18,2);
        $this->lat = substr($vlt_data,34,10);
        $this->lng = substr($vlt_data,45,10);
        $this->gps_fix = substr($vlt_data,21,1);
        $this->vehicle_mode = substr($vlt_data,95,1);
        $this->main_power_status = substr($vlt_data,94,1);
        $this->ignition = substr($vlt_data,93,1);
        $this->heading = substr($vlt_data,81,6);
        $this->gsm_signal_strength = substr($vlt_data,91,2);
        $this->device_time = getDateTime($this->date, $this->time);
        $this->speed=substr($vlt_data,75,6);
        $this->packet_status = substr($vlt_data,20,1);
        $this->no_of_satelites = substr($vlt_data,87,2);

    }

}