<?php
namespace App\Modules\Reports\Controllers;

use App\Exports\IdleReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Gps\Models\GpsModeChange;
use App\Http\Traits\VehicleDataProcessorTrait;
use DataTables;
use DateTime;

class IdleReportController extends Controller
{
    use VehicleDataProcessorTrait;

    public function idleReport()
    {
        $client_id          =   \Auth::user()->client->id;
        $vehicles           =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
        return view('Reports::idle-report',['vehicles'=>$vehicles]);  
    } 
    /**
     * 
     * 
     */
    public function numberOfHoursBetweenDates($from_date, $to_date)
    {
        // $date1  = new DateTime($from_date);
        // $date2  = new DateTime($to_date);

        // $diff   = $date2->diff($date1);

        // $hours  = $diff->h;
        // $hours  = $hours + ($diff->days*24);
        $timestamp1 = strtotime($from_date);
        $timestamp2 = strtotime($to_date);
        $hours      = abs($timestamp2 - $timestamp1)/(60*60);
        return $hours;
    }
    /**
     * 
     * 
     */
    public function idleReportList(Request $request)
    {
        $client_id          =   \Auth::user()->client->id;;
        $from_date          =   $request->from_date;
        $to_date            =   $request->to_date;
        $vehicle_id         =   $request->vehicle;
        $vehicle_details    =   (new Vehicle())->getSingleVehicleDetailsBasedOnVehicleId($vehicle_id);
        $date_and_time      =   array('from_date' => $from_date, 'to_date' => $to_date);
        $max_hours          =   $this->numberOfHoursBetweenDates($date_and_time['from_date'], $date_and_time['to_date']);
        $vehicle_profile    =   $this->vehicleProfile($vehicle_id, $date_and_time, $client_id ,$max_hours);
        return response()->json([           
            'vehicle_name'      =>  $vehicle_details->name,  
            'register_number'   =>  $vehicle_details->register_number,   
            'halt'              =>  $vehicle_profile['halt'],          
            'status'            =>  'idle_report'           
        ]);           
    }
    public function export(Request $request)
    {
        ob_end_clean(); 
        ob_start();
        return Excel::download(new IdleReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Idle-report.xlsx');
    }   
}