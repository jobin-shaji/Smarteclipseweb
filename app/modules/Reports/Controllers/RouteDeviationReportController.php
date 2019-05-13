<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\RouteDeviation;
use DataTables;
class RouteDeviationReportController extends Controller
{
    public function routeDeviationReport()
    {
        return view('Reports::route-deviation-report');  
    }  
    public function routeDeviationReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;;
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];
        $query =RouteDeviation::select(
            'id',
            'vehicle_id', 
            'route_id',    
            'latitude',
            'longitude',
            'deviating_time',
            'created_at'
        )
        ->with('vehicle:id,name,register_number')
        ->with('route:id,name')
        ->where('client_id',$client_id);
        if($from){
            $query = $query->whereBetween('created_at',[$from,$to]);
        }
        $route_deviation = $query->get();      
        return DataTables::of($route_deviation)
        ->addIndexColumn()
        ->addColumn('location', function ($route_deviation) {            
            $place=$route_deviation->latitude;
            return $place;
        })
        ->make();
    }

    // public function export(Request $request)
    // {
    //     return Excel::download(new etmCollectionReportExport($request->id), 'etmCollection-report.xlsx');
    // }
}