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
use App\Http\Traits\VehicleDataProcessorTrait;
use DB;
use Carbon\Carbon;

use DataTables;
class TrackingReportController extends Controller
{
  use VehicleDataProcessorTrait;

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
      $vehicle_id =$request->vehicle;
      $report_type =$request->type;
      $client_id=\Auth::user()->client->id;  
      $date_and_time = $this->getDateFromType($report_type);
      $vehicle_profile = $this->vehicleProfile($vehicle_id,$date_and_time,$client_id);
      return response()->json([           
            'sleep' => $vehicle_profile['sleep'],  
            'motion' => $vehicle_profile['motion'],   
            'halt' => $vehicle_profile['halt'],          
            'status' => 'track_report'           
        ]);           
    }
    
    public function export(Request $request)
    {
        // dd($request->fromDate);    
        return Excel::download(new TrackReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'track-report.xlsx');
    }

    public function getDateFromType($report_type) 
    {
        if ($report_type == "1") 
        {
            $from_date = date('Y-m-d H:i:s', strtotime('today midnight'));
            $to_date = date('Y-m-d H:i:s');
        } else if ($report_type == "2") {
            $from_date = date('Y-m-d H:i:s', strtotime('yesterday midnight'));
            $to_date = date('Y-m-d H:i:s', strtotime("today midnight"));
        } else if ($report_type == "3") {
            $from_date = date('Y-m-d H:i:s', strtotime("-7 day midnight"));
            $to_date = date('Y-m-d H:i:s',strtotime("today midnight"));
        } else if ($report_type == "4") {
            $from_date = date('Y-m-d H:i:s', strtotime("-30 day midnight"));
            $to_date = date('Y-m-d H:i:s',strtotime("today midnight"));
        }
        $output_data = ["from_date" => $from_date, 
                        "to_date" => $to_date
                       ];
        return $output_data;
    }



}