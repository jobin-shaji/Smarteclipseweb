<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\HarshBrakingReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Warehouse\Models\GpsStock;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class HarshBrakingReportController extends Controller
{
    public function harshBrakingReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::harsh-braking-report',['vehicles'=>$vehicles]);  
    } 
    public function harshBrakingReportList(Request $request)
    {

        $client= $request->data['client']; 
        $vehicle= $request->data['vehicle'];
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];   
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
        ->orderBy('id', 'desc')
        ->limit(1000);
        // if($vehicle==null)
        // {
        //     $query = $query->where('client_id',$client)
        //     ->where('alert_type_id',1)
        //     ->where('status',1);

        // }   
        if($vehicle==0 || $vehicle==null)
        {
            $gps_stocks=GpsStock::where('client_id',$client)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }
            $query = $query->whereIn('gps_id',$gps_list)
                            ->where('alert_type_id',1);
            if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to)); 
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }            
        }
        else
        {
            $vehicle=Vehicle::find($vehicle); 
            $query = $query->where('alert_type_id',1)->where('gps_id',$vehicle->gps_id);
            // ->where('status',1);
            if($from){
               $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        $alert = $query->get();      
        return DataTables::of($alert)
        ->addIndexColumn()
       
        ->addColumn('action', function ($alert) { 
         $b_url = \URL::to('/');             
            return "
            <a href=".$b_url."/alert/report/".Crypt::encrypt($alert->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
   
}
    public function export(Request $request)
    {
       return Excel::download(new HarshBrakingReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'harsh-braking-report.xlsx');
    } 
   
}