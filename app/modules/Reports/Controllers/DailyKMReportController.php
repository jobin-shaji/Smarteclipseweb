<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\DailyKMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Warehouse\Models\GpsStock;
use DataTables;
class DailyKMReportController extends Controller
{
    public function dailyKMReport()
    {
    	$client_id      =   \Auth::user()->client->id;
    	$vehicles       =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
        return view('Reports::daily-km-report',['vehicles'=>$vehicles]);  
    }  
    public function dailyKMReportList(Request $request)
    {
        $single_vehicle_gps_ids     =   []; 
        $client_id                  =   \Auth::user()->client->id;
        $date                       =   $request->date;
        $search_date                =   date("Y-m-d", strtotime($date));
        $vehicle_id                 =   $request->vehicle;  
        if($vehicle_id != 0)
        {
            $vehicle_gps_ids        =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithSingleDate($vehicle_id,$search_date); 
        }
        else
        {
            $vehicle_details        =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
            $vehicle_ids            =   [];
            foreach($vehicle_details as $each_vehicle)
            {
                $vehicle_ids[]      =   $each_vehicle->id; 
            }  
            $vehicle_gps_ids        =   (new VehicleGps())->getGpsDetailsBasedOnVehiclesWithSingleDate($vehicle_ids,$search_date);
        }




        $query =DailyKm::select(
            'gps_id', 
            'date',      
           'km'
        )
        ->with('gps.vehicle')    
        ->orderBy('id', 'desc');      
       
        if($vehicle_id==0 || $vehicle_id==null){
            $gps_stocks=GpsStock::select('id','client_id','gps_id')->where('client_id',$client_id)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }
            $query = $query->whereIn('gps_id',$gps_list);          
        }
        else{
           
            $vehicle    =   Vehicle::select('id','gps_id')
                                    ->where('id',$vehicle_id)
                                    ->withTrashed()
                                    ->first();
            $query = $query->where('gps_id',$vehicle->gps_id);            
        }  
        if($from){            
            $query = $query->whereDate('date', $search_from_date);
        }                     
        $dailykm_report = $query->get(); 
        // dd($dailykm_report);    
        return DataTables::of($dailykm_report)
        ->addIndexColumn()        
       ->addColumn('totalkm', function ($dailykm_report) {
          $gps_km=$dailykm_report->km;
          $km=round($gps_km/1000);
            return $km;
        })
        ->make();
    }
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();
        return Excel::download(new DailyKMReportExport($request->id,$request->vehicle,$request->fromDate), 'Daily-km-report.xlsx');
    }
   
}