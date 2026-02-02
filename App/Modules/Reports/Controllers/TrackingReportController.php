<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TrackReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Gps\Models\GpsModeChange;
use App\Http\Traits\VehicleDataProcessorTrait;
use DB;
use Carbon\Carbon;
use DataTables;
use DateTime;

class TrackingReportController extends Controller
{
    use VehicleDataProcessorTrait;

    public function trackingReport()
    {
        $client_id          =   \Auth::user()->client->id;
        $vehicles           =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
        return view('Reports::tracking-report',['vehicles'=>$vehicles]);  
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
    public function trackReportList(Request $request)
    {
        $vehicle_id         =   $request->vehicle;
        $report_type        =   $request->type;
        $client_id          =   \Auth::user()->client->id;  
        $date_and_time      =   $this->getDateFromType($report_type);
        $max_hours          =   $this->numberOfHoursBetweenDates($date_and_time['from_date'], $date_and_time['to_date']);
        $vehicle_profile    =   $this->vehicleProfile($vehicle_id, $date_and_time, $client_id, $max_hours);
        return response()->json([           
            'sleep'         =>  $vehicle_profile['sleep'],  
            'motion'        =>  $vehicle_profile['motion'],   
            'halt'          =>  $vehicle_profile['halt'],          
            'status'        =>  'track_report'           
        ]);           
    }

    public function getDateFromType($report_type) 
    {
        if ($report_type == "1") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime('today midnight'));
            $to_date        =   date('Y-m-d H:i:s');
        } 
        else if ($report_type == "2") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime('yesterday midnight'));
            $to_date        =   date('Y-m-d H:i:s', strtotime("yesterday 23:59:59"));
        } 
        else if ($report_type == "3") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-7 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        else if ($report_type == "5") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-30 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        else if ($report_type == "6") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-60 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        else if ($report_type == "7") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-120 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        else if ($report_type == "8") 
        {
            $from_date      =   date('Y-m-d H:i:s', strtotime("-180 day midnight"));
            $to_date        =   date('Y-m-d H:i:s',strtotime("yesterday 23:59:59"));
        }
        $output_data = ["from_date" =>  $from_date, 
                        "to_date"   =>  $to_date
                       ];
        return $output_data;
    }



}