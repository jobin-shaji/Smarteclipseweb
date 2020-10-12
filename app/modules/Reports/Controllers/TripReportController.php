<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleTripSummary;
use App\Modules\Client\Models\Client;
use App\Http\Traits\VehicleDataProcessorTrait;
use App\Modules\Alert\Models\Alert;
use DB;
use File;
use Carbon\Carbon;
use App\Modules\Vehicle\Models\KmUpdate;
use DataTables;
use DateTime;
use DateInterval;
use DatePeriod;
class TripReportController extends Controller
{
  use VehicleDataProcessorTrait;

    public function TripReportView()
    {
        $trips = [];
        $vehicles = \Auth::user()->client->vehicles;
        return view('Reports::trip-report',compact('trips','vehicles'));
    }

    public function tripReport(Request $request)
    {

        $rules = $this->tripReortRules();
        
        $this->validate($request, $rules);  

        $id = $request->vehicle;
        $date = $request->date;

        $alerts = Alert::where('gps_id', $id)->whereIn('alert_type_id',[19,20])->whereDate('device_time',$date)->orderBy('device_time')->get();

        $trips = [];

        $i=0;

        foreach ($alerts as $item) {
            if($item->alert_type_id == 19)
            {
                $trips[$i]["on"] = $item->device_time;
                $trips[$i]["on location"] = $item->latitude.','.$item->longitude;
            }
            else if($item->alert_type_id == 20)
            {
                $trips[$i]["off"] = $item->device_time;
                $trips[$i]["off location"] = $item->latitude.','.$item->longitude;
                $i++;
            }     

        }


        for($i=0;$i<count($trips);$i++)
        {
            if( ( !isset($trips[$i]["off"]) ) || ( !isset($trips[$i]["on"]) ) )
            {
                $trips[$i]["km"] = "--";
            }
            else
            {
                $trips[$i]["km"] = KmUpdate::where('gps_id',$id)->where('device_time','>',$trips[$i]["on"] )->where('device_time','<',$trips[$i]["off"] )->sum('km');
            }

            if(!isset($trips[$i]["on"]))
            {
                $trips[$i]["on"] = "--";
                $trips[$i]["on location"] = "--";
            }
            else if(!isset($trips[$i]["off"]))
            {
                $trips[$i]["off"] = "--";
                $trips[$i]["off location"]  = "--";
            }

        }

        $vehicles = \Auth::user()->client->vehicles;

        return view('Reports::trip-report',compact('vehicles','trips'));

    }  
    public function TripReportDownload()
    {
         $vehicles = \Auth::user()->client->vehicles;
        return view('Reports::trip-report-download-list',['vehicles'=>$vehicles]);
    }
    public function TripReportDownloadList(Request $request)
    {
        $vehicle_id=$request->vehicle;
        // dd($vehicle_id);
        $client_id=\Auth::user()->client->id;
        $tripdate=$request->tripDate;
        $from_date=date("Y-m-d", strtotime($tripdate));         
        $vehicles = \Auth::user()->client->vehicles;
        $path='documents/trip_report/'. $client_id.'/'.$vehicle_id.'/'.$from_date;
       if(!File::exists($path)) {
         $files="";
         $request->session()->flash('message', 'invalid date and vehicle!');
            $request->session()->flash('alert-class', 'alert-success');
         return view('Reports::trip-report-download-list',['vehicles'=>$vehicles,'tripdate'=>$tripdate,'vehicle_id'=>$vehicle_id]);
    // path does not exist
        }else{
            $files = File::allFiles('documents/trip_report/'. $client_id.'/'.$vehicle_id.'/'.$from_date);
        return view('Reports::trip-report-download-list',['files'=>$files,'vehicles'=>$vehicles,'tripdate'=>$tripdate,'vehicle_id'=>$vehicle_id]);
        }
    }

    public function tripReortRules()
    {
        $rules = [
            'vehicle' => 'required',
            'date' => 'required'
        ];
        return  $rules;
    }
    /**
     * 
     * trip report view in manufacturer -START
     * 
     */
    public function tripReportInManufacturer()
    {
        $get_all_clients    =   (new Client())->getIdNameAndMobileNoOfAllClients();
        return view('Reports::trip-report-view-in-manufacturer',['clients'=>$get_all_clients, 'client_id'=>'', 'vehicle_id'=>'', 'from_date'=>'', 'to_date'=>'', 'trip_reports'=>[]]);
    }

      /**
     * 
     * trip report view in client -START
     * 
     */
    public function tripReportInClient()
    {
        $vehicles    =   \Auth::user()->client->vehicles;
        return view('Reports::trip-report-client',['vehicles'=> $vehicles, 'vehicle_id'=>'', 'from_date'=>'', 'to_date'=>'', 'trip_reports'=>[]]);
    }

    /**
     * 
     * 
     * 
     */
    public function getVehiclesBasedOnClient(Request $request)
    {
        $client_id              =   $request->client_id;
        if($client_id == "0")
        {
            $vehicles           =   (new Vehicle())->getAllVehiclesOfAllClients();
        }
        else
        {
            $vehicles           =   (new Vehicle())->getVehiclesOfSelectedClient($client_id);
        }
        if($vehicles == null)
        {
            return response()->json([
                'vehicles' => '',
                'message' => 'no vehicle found'
            ]);
        }else
        {
            return response()->json([
                    'vehicles' => $vehicles,
                    'message' => 'success'
            ]);
        }
    }
    /**
     *
     * 
     */
    public function getDetailsOfTripReportInManufacturer(Request $request)
    {
        $client_id          =   $request->client_id;
        $vehicle_id         =   $request->vehicle_id;
        $from_date          =   date("Y-m-d", strtotime($request->from_date));
        $to_date            =   date("Y-m-d", strtotime($request->to_date));
        
        // $trip_report_dates  =   $this->createDatesInBetween($from_date, $to_date);
        // $trip_reports       =   [];

        // foreach($trip_report_dates as $each_date)
        // {
        //     $directory = 'tripreports/'.$client_id.'/'.$vehicle_id.'/'.$each_date;
        //     if( is_dir($directory) )
        //     {
        //         foreach (glob($directory."/*.pdf") as $each_trip_report_file)
        //         {
        //             array_push($trip_reports, [
        //                 'path'      => $directory.'/'.basename($each_trip_report_file),
        //                 'filename'  => basename($each_trip_report_file),
        //                 'date'      => $each_date
        //             ]);
        //         }
        //     }
        // }
        
        if($client_id == "0" && $vehicle_id == "0")
        {
            $clients            =   (new Client())->getIdNameAndMobileNoOfAllClients();
            $client_ids         =   [];
            foreach($clients as $each_client)
            {
                $client_ids[]   =   $each_client->id;
            }
            $vehicles           =   (new Vehicle())->getAllVehiclesOfAllClients();
            foreach($vehicles as $each_vehicle)
            {
                $vehicle_ids[]  =   $each_vehicle->id;
            }
        }
        else if($client_id == "0" && $vehicle_id != "0")
        {
            $clients            =   (new Client())->getIdNameAndMobileNoOfAllClients();
            $client_ids         =   [];
            foreach($clients as $each_client)
            {
                $client_ids[]   =   $each_client->id;
            }
            $vehicle_ids        =   [$vehicle_id];
        }
        else if($client_id != "0" && $vehicle_id == "0")
        {
            $client_ids         =   [$client_id];
            $vehicles           =   (new Vehicle())->getAllVehiclesOfAllClients();
            foreach($vehicles as $each_vehicle)
            {
                $vehicle_ids[]  =   $each_vehicle->id;
            }
        }
        else
        {
            $client_ids         =   [$client_id];
            $vehicle_ids        =   [$vehicle_id];
        }
        $trip_reports       =   (new VehicleTripSummary())->getTripDetailsBetweenTwoDates($client_ids, $vehicle_ids, $from_date, $to_date);
        $get_all_clients    =   (new Client())->getIdNameAndMobileNoOfAllClients();
        return view('Reports::trip-report-view-in-manufacturer',['clients'=>$get_all_clients, 'client_id'=>$client_id, 'vehicle_id'=>$vehicle_id, 'from_date'=>$from_date, 'to_date'=>$to_date,'trip_reports'=>$trip_reports ]);
    }

    /**
     *
     * 
     */
    public function getDetailsOfTripReportInClient(Request $request)
    {
        $vehicle_id         =   $request->vehicle_id;
        $from_date          =   date("Y-m-d", strtotime($request->from_date));
        $to_date            =   date("Y-m-d", strtotime($request->to_date));
        
        // $trip_report_dates  =   $this->createDatesInBetween($from_date, $to_date);
        // $trip_reports       =   [];

        // foreach($trip_report_dates as $each_date)
        // {
        //     $directory = 'tripreports/'.$client_id.'/'.$vehicle_id.'/'.$each_date;
        //     if( is_dir($directory) )
        //     {
        //         foreach (glob($directory."/*.pdf") as $each_trip_report_file)
        //         {
        //             array_push($trip_reports, [
        //                 'path'      => $directory.'/'.basename($each_trip_report_file),
        //                 'filename'  => basename($each_trip_report_file),
        //                 'date'      => $each_date
        //             ]);
        //         }
        //     }
        // }
        

        if($vehicle_id == "0")
        {
            $vehicles           =   \Auth::user()->client->vehicles;
            foreach($vehicles as $each_vehicle)
            {
                $vehicle_ids[]  =   $each_vehicle->id;
            }
        }
        else
        {
            $vehicle_ids        =   [$vehicle_id];
        }

        $trip_reports       =   (new VehicleTripSummary())->getTripDetailsBetweenTwoDates([\Auth::user()->client->id], $vehicle_ids, $from_date, $to_date);

        return view('Reports::trip-report-client',['vehicles'=> \Auth::user()->client->vehicles, 'vehicle_id'=>$vehicle_id, 'from_date'=>$from_date, 'to_date'=>$to_date,'trip_reports'=>$trip_reports ]);
    }
  
    /**
     * 
     * 
     */
    // private function createDatesInBetween($from, $to)
    // {
    //     $dates = [];
    //     if($from != null && $to != null )
    //     {
    //         $begin      =   new DateTime($from);
    //         $end        =   new DateTime($to);
    //         $end        =   $end->modify('+1 day');
    //         $interval   =   DateInterval::createFromDateString('1 day');
    //         $period     =   new DatePeriod($begin, $interval, $end);
    //         foreach ($period as $dt)
    //         {
    //             array_push($dates, $dt->format("Y-m-d"));
    //         }
    //     }
    //     return $dates;
    // }

}