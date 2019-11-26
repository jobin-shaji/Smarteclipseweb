<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\DailyKMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Warehouse\Models\GpsStock;
use DataTables;
class DailyKMReportController extends Controller
{
    public function dailyKMReport()
    {
    	$client_id=\Auth::user()->client->id;
    	$vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();        
        return view('Reports::daily-km-report',['vehicles'=>$vehicles]);  
    }  
    public function dailyKMReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $from = $request->data['from_date'];
        // $to = $request->data['to_date'];
        $search_from_date=date("Y-m-d", strtotime($from));
        // $search_to_date=date("Y-m-d", strtotime($to));
        // dd($from);
        $vehicle_id = $request->data['vehicle'];  
        $query =DailyKm::select(
            'gps_id', 
            'date',      
           'km'
        )
        ->with('gps.vehicle')    
        ->orderBy('id', 'desc');      
       
        if($vehicle_id==0 || $vehicle_id==null){
            $gps_stocks=GpsStock::where('client_id',$client_id)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }
            $query = $query->whereIn('gps_id',$gps_list);          
        }
        else{
            $vehicle=Vehicle::withTrashed()->find($vehicle_id); 
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
       return Excel::download(new DailyKMReportExport($request->id,$request->vehicle,$request->fromDate), 'Daily-km-report.xlsx');
    }
   
}