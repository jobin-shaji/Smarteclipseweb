<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TrackReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsModeChange;


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
            \DB::raw('DATE(device_time) as device_time'),
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
            // $M_mode =  $this->modeTime($from,$to,$track_report->gps_id); 

                
            $query = $query->whereIn('gps_id',$gps_list)->groupBy('date')
            ->orderBy('id', 'desc');
        }
       else
        {
            $vehicle=Vehicle::withTrashed()->find($vehicle); 
            $query = $query->where('gps_id',$vehicle->gps_id)->groupBy('date'); 
        }
               
        if($from)
         {
            $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);

                // $M_mode =  $this->modeTime($from,$to,$track_report->gps_id); 
         }
        $track_report = $query->get();  

        // dd($track_report);  

        return DataTables::of($track_report)
        ->addIndexColumn()
        ->addColumn('motion', function ($track_report) { 
         // dd($from);  
            // $M_mode =  $this->modeTime($from,$to,$track_report->gps_id);    

           $v_mode=$track_report->sleep->where('vehicle_mode','M')->count();
           $motion= gmdate("H:i:s",$M_mode);          
            
            return $v_mode;           
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

    public function modeTime(){
      $from="2019-10-23 10:10:10";
      $to="2019-10-26 10:10:10";
      $gps_id=5;
      $sleep=0;
      $halt=0;
      $motion=0;
      $offline=0;
      $initial_time = 0;
      $previus_time =0;
      $previud_mode = 0;

      $gps_modes=GpsModeChange::where('device_time','>=',$from)
                                   ->where('device_time','<=',$to)  
                                   ->where('gps_id',$gps_id)
                                   ->get();
      foreach ($gps_modes as $mode) {
        if($initial_time == 0){
            $initial_time = $mode->device_time;
            $previus_time = $mode->device_time;
            $previud_mode = $mode->mode;
        }else{
            if($mode->mode == "S"){
               $time = strtotime($mode->device_time) - strtotime($previus_time);
               echo date('Y-m-d', strtotime($time));
               echo "<br>";
                $sleep = $sleep+$time;
            }
        }

        $previus_time = $mode->device_time;
      }
                               
    }
}