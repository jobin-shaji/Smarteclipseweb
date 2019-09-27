<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\GeofenceReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
use DataTables;
class GeofenceReportController extends Controller
{
    public function geofenceReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::geofence-report',['vehicles'=>$vehicles]);  
    }  
    public function geofenceReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $from = $request->from_date;
        $to = $request->to_date;
        $vehicle = $request->vehicle;
      
        if($vehicle==0 || $vehicle==null)
        {
            $gps_stocks=GpsStock::where('client_id',$client_id)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }
            $query =GpsData::select(
                'id',
                'gps_id',
                'alert_id',    
                'device_time'
            )
            ->with('gps.vehicle')
            ->with('alert:id,code,description')
            ->whereIn('gps_id',$gps_list)
            ->whereIn('alert_id',[18,19,20,21]);
        }
        else
        {
            $vehicle=Vehicle::find($vehicle); 
            $query =GpsData::select(
                'id', 
                'alert_id',    
                'device_time'
            )
            ->with('gps.vehicle')
            ->with('alert:id,code,description')
            ->whereIn('alert_id',[18,19,20,21])
            ->where('gps_id',$vehicle->gps_id);
        }       
        if($from){
            // $query = $query->whereBetween('device_time',[$from,$to]);
            $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $geofence = $query->get();      
        return DataTables::of($geofence)
        ->addIndexColumn()
        ->make();
    }
     public function export(Request $request)
    {
        // dd($request->fromDate);    
        return Excel::download(new GeofenceReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'geofence-report.xlsx');
    }
}