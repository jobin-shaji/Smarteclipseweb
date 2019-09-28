<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
class ParkingReportExport implements FromView
{
	protected $parkingReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {   
        $single_vehicle_id = []; 
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::where('client_id',$client_id)->get();             
            foreach($vehicle_details as $vehicle_detail){
                $single_vehicle_id[] = $vehicle_detail->gps_id; 

            }
        }  
        $query =GpsData::select(
            'gps_id',
            'header',
            'vendor_id',
            'firmware_version',
            'imei',
            'update_rate_ignition_on',
            'update_rate_ignition_off',
            'battery_percentage',
            'low_battery_threshold_value',
            'memory_percentage',
            'digital_io_status',
            'analog_io_status',
            'activation_key',
            'latitude',
            'lat_dir',
            'longitude',
            'lon_dir',
            'date',
            'time',
            'speed',
            'alert_id',
            'packet_status',
            'gps_fix',
            'mcc',
            'mnc',
            'lac',
            'cell_id',
            'heading',
            'no_of_satelites',
            'hdop',
            'gsm_signal_strength',
            'ignition',
            'main_power_status',
            'vehicle_mode',
            'altitude',
            'pdop',
            'nw_op_name',
            'nmr',
            'main_input_voltage',
            'internal_battery_voltage',
            'tamper_alert',
            'digital_input_status',
            'digital_output_status',
            'frame_number',
            'checksum',
            'key1',
            'value1',
            'key2',
            'value2',
            'key3',
            'value3',
            'gf_id',
            'device_time',
            \DB::raw('sum(distance) as distance')
        )
        ->with('gps.vehicle');     
        if($vehicle==0 || $vehicle==null )
       {         
            $query = $query->whereIn('gps_id',$single_vehicle_id)
            ->groupBy('date');
       }
       else
       {
        $query = $query->where('gps_id',$single_vehicle_ids)
           ->groupBy('date'); 
       }
        if($from){
            $query = $query->whereDate('device_time', '>=', $from)->whereDate('device_time', '<=', $to);
        }
        $this->parkingReportExport = $query->get();          
    }
    public function view(): View
	{
       return view('Exports::parking-report', [
            'parkingReportExport' => $this->parkingReportExport
        ]);
	}
    
}

