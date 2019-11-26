<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TotalKMReportExport;
use App\Exports\KMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\Gps;

use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsModeChange;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\Route\Models\RouteDeviation;
use App\Modules\Vehicle\Models\DailyKm;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\VehicleDataProcessorTrait;
use Carbon\Carbon;
use DataTables;

class TotalKMReportController extends Controller
{

    use VehicleDataProcessorTrait;

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
        // $from = $request->data['from_date'];
        // $to = $request->data['to_date'];
        $vehicle =$request->data['vehicle'];
        // $search_from_date=date("Y-m-d", strtotime($from));
        // $search_to_date=date("Y-m-d", strtotime($to));
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
         $query =Gps::select(
            'id', 
             'km'
        )
        ->with('vehicle') 
        ->orderBy('id', 'desc');             
         if($vehicle==0 || $vehicle==null)
        {        
            $query = $query->whereIn('id',$single_vehicle_id);           
        }
        else
        {
            $query = $query->where('id',$single_vehicle_ids);               
        }   
        // if($from){            
        //     $query = $query->whereDate('date', '>=', $search_from_date)->whereDate('date', '<=', $search_to_date);
        // }                     
        $totalkm_report = $query->get();
        return DataTables::of($totalkm_report)
        ->addIndexColumn()        
        ->addColumn('totalkm', function ($totalkm_report) {
          $gps_km=$totalkm_report->km;
          $km=round($gps_km/1000);
            return $km;
        })
        ->make();
    }
    public function export(Request $request)
    {
       return Excel::download(new TotalKMReportExport($request->id,$request->vehicle), 'Total-km-report.xlsx');
    } 



    public function kmReport()
    {
        $client_id=\Auth::user()->client->id;
         $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();    
        return view('Reports::km-report',['vehicles'=>$vehicles]);  
    } 

    public function kmReportList(Request $request)
    {
        $vehicle_id =$request->vehicle;
        $report_type =$request->report_type;
        $client_id=\Auth::user()->client->id;  
        $custom_from_date = $request->from_date;
        $custom_to_date = $request->to_date;
        $date_and_time = $this->getDateFromType($report_type, $custom_from_date, $custom_to_date);
        $vehicle_profile = $this->vehicleProfile($vehicle_id,$date_and_time,$client_id);
        return response()->json($vehicle_profile);
    }

    public function kmExport(Request $request)
    {
       return Excel::download(new KMReportExport($request->id,$request->vehicle,$request->report_type), 'Km-report.xlsx');
    }
    
}

