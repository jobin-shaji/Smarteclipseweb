<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\GeofenceReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;

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
        ->withTrashed()
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
            $query =Alert::select(          
                'id',
                'alert_type_id',
                'device_time',   
                'gps_id',
                'latitude',
                'longitude',
                'status'
            )
            ->with('alertType:id,description')
            ->with('gps.vehicle')
            ->orderBy('device_time', 'DESC')
           ->whereIn('gps_id',$gps_list)
            ->whereIn('alert_type_id',[5,6])
            ->orderBy('device_time', 'DESC')
            ->limit(1000);           
        }
        else
        {
            $vehicle=Vehicle::withTrashed()->find($vehicle); 
            $query =Alert::select(          
                'id',
                'alert_type_id',
                'device_time',   
                'gps_id',
                'latitude',
                'longitude',
                'status'
            )
            ->with('alertType:id,description')
            ->with('gps.vehicle')
            ->orderBy('device_time', 'DESC')
           ->whereIn('gps_id',$vehicle->gps_id)
            ->whereIn('alert_type_id',[5,6])
            ->orderBy('device_time', 'DESC')
            ->limit(1000);           
        }       
        if($from){
            // $query = $query->whereBetween('device_time',[$from,$to]);
            $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
        $geofence = $query->get();  
        // dd($geofence) ;  
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