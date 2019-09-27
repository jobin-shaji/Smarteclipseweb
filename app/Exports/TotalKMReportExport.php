<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
class TotalKMReportExport implements FromView
{
	protected $totalkmReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {   
         if($vehicle!=0)
        {
            $vehicle_details =Vehicle::find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::where('client_id',$client_id)->get(); 
            $single_vehicle_id = [];
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
            'gf_id',
            'device_time'
            // \DB::raw('sum(distance) as distance')
        )
        ->with('gps.vehicle');
       if($vehicle==0 || $vehicle==null)
       {
            $query = $query->whereIn('gps_id',$single_vehicle_id)
            ->groupBy('gps_id');
       }
       else
       {
            $query = $query->where('gps_id',$single_vehicle_ids)
            ->groupBy('gps_id');      
       }             
        if($from){
            $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $this->totalkmReportExport = $query->get();          
    }
    public function view(): View
	{
       return view('Exports::total-km-report', [
            'totalkmReportExport' => $this->totalkmReportExport
        ]);
	}
    
}

