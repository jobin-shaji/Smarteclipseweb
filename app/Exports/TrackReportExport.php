<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
class TrackReportExport implements FromView
{
	protected $trackReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {  

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
            'device_time',
            \DB::raw('sum(distance) as distance')
        )
        ->with('gps.vehicle');     
        if($vehicle==0)
        {         
            $gps_stocks=GpsStock::where('client_id',$client)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }        
            $query = $query->whereIn('gps_id',$gps_list)->groupBy('date');        }
       else
        {
            $vehicle=Vehicle::withTrashed()->find($vehicle); 
            $query = $query->where('gps_id',$vehicle->gps_id)->groupBy('date'); 
        }      
        if($from){
             $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }

         $this->trackReportExport = $query->get(); 
         // dd($this->trackReportExport);
         // dd($this->alertReportExport);  
    }
    public function view(): View
	{
       return view('Exports::track-report', [
            'trackReportExport' => $this->trackReportExport
        ]);
	}
    
}

