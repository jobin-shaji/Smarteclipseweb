<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TotalKMReportExport;
use App\Exports\KMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
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

class DurationReportController extends Controller
{

    use VehicleDataProcessorTrait;

    public function durationReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();    
        return view('Reports::duration-report',['vehicles'=>$vehicles]);  
    } 

    public function durationReportList(Request $request)
    {
        $vehicle_id =$request->vehicle;
        $date =$request->date;
        $client_id=\Auth::user()->client->id;  
        
        $tracking_mode = $this->trackingMode($vehicle_id,$date_and_time,$client_id);
        return response()->json($vehicle_profile);
    }

}

