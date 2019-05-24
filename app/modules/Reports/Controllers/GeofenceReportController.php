<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use DataTables;
class GeofenceReportController extends Controller
{
    public function geofenceReport()
    {
        return view('Reports::geofence-report');  
    }  
    public function geofenceReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];
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
        if($from){
            $query = $query->whereBetween('device_time',[$from,$to]);
        }
        $geofence = $query->get();      
        return DataTables::of($geofence)
        ->addIndexColumn()
        ->make();
    }
    // public function export(Request $request)
    // {
    //     return Excel::download(new etmCollectionReportExport($request->id), 'etmCollection-report.xlsx');
    // }
}