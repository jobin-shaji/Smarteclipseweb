<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TrackReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;

use DataTables;
class TrackingReportController extends Controller
{
    public function trackingReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::tracking-report',['vehicles'=>$vehicles]);  
    }  
    public function trackReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;;
        $from = $request->from_date;
        $to = $request->to_date;
        $vehicle = $request->vehicle;
        $query =GpsData::select(
            'client_id',
            'gps_id',
            'vehicle_id',
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
        ->with('vehicle:id,name,register_number');     
        if($vehicle==0)
       {         
            $query = $query->where('client_id',$client_id)
            ->groupBy('date');
       }
       else
       {
        $query = $query->where('client_id',$client_id)
            ->where('vehicle_id',$vehicle)
            ->groupBy('date'); 
       }
               
        if($from){
            $query = $query->whereDate('device_time', '>=', $from)->whereDate('device_time', '<=', $to);
        }
        $track_report = $query->get();     
        return DataTables::of($track_report)
        ->addIndexColumn()
         ->addColumn('motion', function ($track_report) {                    
            $M_mode=$track_report->sleep->where('vehicle_mode','M')->count();
           $motion= gmdate("H:i:s",$M_mode);          
            
            return $motion;           
        })
        ->addColumn('sleep', function ($track_report) {  
            $v_mode=$track_report->sleep->where('vehicle_mode','S')->count(); 
             $sleep= gmdate("H:i:s",$v_mode);         
          
            return $sleep;
        })
         ->addColumn('halt', function ($track_report) {  
            $H_mode=$track_report->sleep->where('vehicle_mode','H')->count();
            $halt= gmdate("H:i:s",$H_mode);           
           
            return $halt;
        })
         ->addColumn('ac_on', function ($track_report) {                    
            $ac_on=0;
            return $ac_on;
        })
        ->addColumn('ac_off', function ($track_report) {                    
            $ac_off=0;
            return $ac_off;
        })
        ->addColumn('km', function ($track_report) {                    
            $km='-';
            return $km;
        })
        ->make();
    }
    public function export(Request $request)
    {
        // dd($request->fromDate);    
        return Excel::download(new TrackReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'track-report.xlsx');
    }
}