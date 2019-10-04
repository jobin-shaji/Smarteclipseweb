<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\DailyKMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Warehouse\Models\GpsStock;
use DataTables;
class DailyKMReportController extends Controller
{
    public function dailyKMReport()
    {
    	$client_id=\Auth::user()->client->id;
    	$vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        
        return view('Reports::daily-km-report',['vehicles'=>$vehicles]);  
    }  
    public function dailyKMReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];

        $vehicle_id = $request->data['vehicle'];  
       

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
            // 'device_time',
            \DB::raw('DATE(device_time) as date'),
            \DB::raw('sum(distance) as distance')
        )
        ->with('gps.vehicle')
        ->groupBy('date')
        ->orderBy('id', 'desc')        
        ->limit(10);
        if($vehicle_id==0 || $vehicle_id==null){
            $gps_stocks=GpsStock::where('client_id',$client_id)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }
            $query = $query->whereIn('gps_id',$gps_list);
            if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)
                ->whereDate('device_time', '<=', $search_to_date);
            }    
        }else{
            $vehicle=Vehicle::find($vehicle_id); 
            $query = $query->where('gps_id',$vehicle->gps_id);
            if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)
                ->whereDate('device_time', '<=', $search_to_date);
            }
        }                  
        $dailykm_report = $query->get();     

        return DataTables::of($dailykm_report)
        ->addIndexColumn()        
        ->addColumn('km', function ($dailykm_report) { 
            $earthRadius = 6371000;
            $lat_from=floatval($dailykm_report->first()->latitude);
            $lng_from=floatval($dailykm_report->first()->longitude);
            $lat_to=floatval($dailykm_report->latitude);
            $lng_to=floatval($dailykm_report->longitude);
            // dd($lat_from.",".$lng_from.",".$lat_to.",".$lng_to);
            $latFrom = deg2rad($lat_from);
            $lonFrom = deg2rad($lng_from);
            $latTo = deg2rad($lat_to);
            $lonTo = deg2rad($lng_to);
            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;
            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
            return $angle * $earthRadius;                            
        })
        ->make();
    }
    public function export(Request $request)
    {
       return Excel::download(new DailyKMReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Daily-km-report.xlsx');
    }
   
}