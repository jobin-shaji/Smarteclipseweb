<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
class GeofenceReportController extends Controller
{
    public function geofenceReport()
    {
        return view('Reports::geofence-report');  
    }  
    // public function etmCollectionReportList(Request $request)
    // {
    //     $depot=$request->data['depot'];
    //     $from = $request->data['from_date'];
    //     $to = $request->data['to_date'];
    //     $query =Waybill::select(
    //         'id',
    //         'code', 
    //         'vehicle_id',    
    //         'driver_id',
    //         'conductor_id',
    //         'etm_id',  
    //         'date'
    //     )
    //     ->with('etm:id,name,imei')
    //     ->where('depot_id',$depot)
    //     ->with('tripsWithAmount');
    //     if($from){
    //         $query = $query->whereBetween('date',[$from,$to]);
    //     }
    //     $etm_collection = $query->get();      
    //     return DataTables::of($etm_collection)
    //     ->addIndexColumn()
    //     ->addColumn('income', function ($etm_collection) {            
    //         $income=$etm_collection->tripsWithAmount->sum('total_collection_amount');
    //         return $income;
    //     })
    //     ->make();
    // }
    // public function export(Request $request)
    // {
    //     return Excel::download(new etmCollectionReportExport($request->id), 'etmCollection-report.xlsx');
    // }
}