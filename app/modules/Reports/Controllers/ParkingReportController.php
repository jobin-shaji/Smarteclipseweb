<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\ParkingReportExport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\Vehicle;
use DataTables;
class ParkingReportController extends Controller
{
    public function parkingReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::parking-report',['vehicles'=>$vehicles]);  
    } 
    public function parkingReportList(Request $request)
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
            
            'gf_id',
            'device_time',
            \DB::raw('sum(distance) as distance')
        )
        ->with('vehicle:id,name,register_number')
        ->where('vehicle_mode','S');
            
        if($vehicle==0 || $vehicle==null )
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
            $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $track_report = $query->get();     
        return DataTables::of($track_report)
        ->addIndexColumn()         
        ->addColumn('sleep', function ($track_report) {  
            $v_mode=$track_report->sleep->where('vehicle_mode','S')->count(); 
            $sleep= gmdate("H:i:s",$v_mode);                   
            return $sleep;
        })        
        ->make();
    }
    public function export(Request $request)
    {
       return Excel::download(new ParkingReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Parking-report.xlsx');
    }
   
}