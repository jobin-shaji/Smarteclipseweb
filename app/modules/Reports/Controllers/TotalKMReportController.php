<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TotalKMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
use DataTables;
class TotalKMReportController extends Controller
{
    public function totalKMReport()
    {
    	$client_id=\Auth::user()->client->id;
    	 $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();    
        return view('Reports::total-km-report',['vehicles'=>$vehicles]);  
    }  

    public function totalKMReportList(Request $request)
    {
        $single_vehicle_id = [];
        $client_id=\Auth::user()->client->id;
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];
        $vehicle =$request->data['vehicle'];
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::where('client_id',$client_id)->withTrashed()->get();            foreach($vehicle_details as $vehicle_detail){
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
        ->with('gps.vehicle')
        ->limit(1000);
        if($vehicle==0 || $vehicle==null || $from==null || $to==null)
        {        
            $query = $query->whereIn('gps_id',$single_vehicle_id)
            ->groupBy('gps_id');            
        }
        else if($vehicle==0 || $vehicle==null)
        {        
            $query = $query->whereIn('gps_id',$single_vehicle_id);           
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
       
        $totalkm_report = $query->get(); 

        return DataTables::of($totalkm_report)
        ->addIndexColumn()        
        ->addColumn('km', function ($totalkm_report) { 
        $earthRadius = 6371000;
        $lat_from=floatval($totalkm_report->first()->latitude);
        $lng_from=floatval($totalkm_report->first()->longitude);
        $lat_to=floatval($totalkm_report->latitude);
        $lng_to=floatval($totalkm_report->longitude);
        // dd($lat_from.",".$lng_from.",".$lat_to.",".$lng_to);
        $latFrom = deg2rad($lat_from);
        $lonFrom = deg2rad($lng_from);
        $latTo = deg2rad($lat_to);
        $lonTo = deg2rad($lng_to);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return round($angle * $earthRadius,2);                            
            
        })
        ->make();
    }
    public function export(Request $request)
    {
       return Excel::download(new TotalKMReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Total-km-report.xlsx');
    } 
}