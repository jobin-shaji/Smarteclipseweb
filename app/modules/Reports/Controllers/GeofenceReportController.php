<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\GeofenceReportExport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use App\Modules\Gps\Models\GpsData;
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
            
            $query =GpsData::select(
                'id',
                'vehicle_id', 
                'alert_id',    
                'device_time'
            )
            ->with('vehicle:id,name,register_number')
            ->with('alert:id,code,description')
            ->whereIn('alert_id',[18,19,20,21])
            ->where('client_id',$client_id);
        }
        else
        {
            $query =GpsData::select(
                'id',
                'vehicle_id', 
                'alert_id',    
                'device_time'
            )
            ->with('vehicle:id,name,register_number')
            ->with('alert:id,code,description')
            ->whereIn('alert_id',[18,19,20,21])
            ->where('client_id',$client_id)
            ->where('vehicle_id',$vehicle);
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