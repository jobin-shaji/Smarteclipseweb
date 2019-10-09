<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TrackReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;

use DataTables;
class TrackingReportController extends Controller
{
    public function trackingReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
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
        ->with('gps.vehicle')
        ->limit(1000);     
        if($vehicle==0 || $vehicle==null)
        { 
            $gps_stocks=GpsStock::where('client_id',$client_id)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }        
            $query = $query->whereIn('gps_id',$gps_list)->groupBy('date')
            ->orderBy('id', 'desc');
        }
       else
        {
            $vehicle=Vehicle::find($vehicle); 
            $query = $query->where('gps_id',$vehicle->gps_id)->groupBy('date'); 
        }
               
        if($from){
            $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
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