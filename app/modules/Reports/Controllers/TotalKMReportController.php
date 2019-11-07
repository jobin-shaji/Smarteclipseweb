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

use App\Modules\Vehicle\Models\DailyKm;
use Carbon\Carbon;

use DataTables;
class TotalKMReportController extends Controller
{
    public function totalKMReport()
    {
    	$client_id=\Auth::user()->client->id;
    	 $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();    
        return view('Reports::total-km-report',['vehicles'=>$vehicles]);  
    }  

    public function totalKMReportList(Request $request)
    {
        $single_vehicle_id = [];
        $client_id=\Auth::user()->client->id;
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];
        $vehicle =$request->data['vehicle'];
        $search_from_date=date("Y-m-d", strtotime($from));
        $search_to_date=date("Y-m-d", strtotime($to));
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::where('client_id',$client_id)->withTrashed()->get();            foreach($vehicle_details as $vehicle_detail){
                $single_vehicle_id[] = $vehicle_detail->gps_id; 

            }
        }
         $query =DailyKm::select(
            'gps_id', 
            'date',  
            \DB::raw('SUM(km) as km')    
           // 'km'
        )
        ->with('gps.vehicle') 
        ->groupBy('gps_id')   
        ->orderBy('id', 'desc');             
         if($vehicle==0 || $vehicle==null)
        {        
            $query = $query->whereIn('gps_id',$single_vehicle_id);           
        }
        else
        {
            $query = $query->where('gps_id',$single_vehicle_ids)
            ->groupBy('gps_id');               
        }   
        if($from){            
            $query = $query->whereDate('date', '>=', $search_from_date)->whereDate('date', '<=', $search_to_date);
        }                     
        $totalkm_report = $query->get();
        return DataTables::of($totalkm_report)
        ->addIndexColumn()        
        ->addColumn('totalkm', function ($totalkm_report) {
          $gps_km=$totalkm_report->km;
          $km=round($gps_km/1000);
            return $km;
        })
        ->make();
    }
    public function export(Request $request)
    {
       return Excel::download(new TotalKMReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Total-km-report.xlsx');
    } 



    public function kmReport()
    {
        $client_id=\Auth::user()->client->id;
         $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();    
        return view('Reports::km-report',['vehicles'=>$vehicles]);  
    } 

    public function kmReportList(Request $request)
    {
        $sleep=0;
        $halt=0;
        $motion=0;
        $offline=0;
        $time=0;
        $initial_time = 0;
        $previous_time =0;
        $previous_mode = 0;
        $vehicle_sleep=0;
        $single_vehicle_id = [];
        $client_id=\Auth::user()->client->id;       
        $vehicle =$request->vehicle;
        $report_type =$request->report_type;
        if($report_type==1)
        {
            $search_from_date=date('Y-m-d');
            $search_to_date=date('Y-m-d');
        }
        else if($report_type==2)
        {
            $search_from_date=date('Y-m-d',strtotime("-1 days"));
            $search_to_date=date('Y-m-d',strtotime("-1 days"));
        }
        else if($report_type==3)
        {
            $search_from_date=date('Y-m-d',strtotime("-7 days"));
            $search_to_date=date('Y-m-d');
            
        }
        else if($report_type==4)
        {           
            $search_from_date=date('Y-m-d',strtotime("-30 days"));
            $search_to_date=date('Y-m-d');
            
        } 
        $single_vehicle_id =  $this->VehicleGPs($vehicle);  
        $km_report =  $this->dailyKmReport($client_id,$vehicle,$search_from_date,$search_to_date,$single_vehicle_id);
        // dd($km_report);
        $gps_modes=GpsModeChange::where('device_time','>=',$search_from_date)
        ->where('device_time','<=',$search_to_date)  
        ->where('gps_id',$single_vehicle_id)
        ->orderBy('device_time','asc')
        ->get();
        foreach ($gps_modes as $mode) {
        if($initial_time == 0){
            $initial_time = $mode->device_time;
            $previous_time = $mode->device_time;
            $previous_mode = $mode->mode;
        }else{
            if($mode->mode == "S"){
               $time = strtotime($mode->device_time) - strtotime($previous_time);
                $sleep= $sleep+$time; 
                if($sleep<0)
                {
                    $sleep="0";                   
                }                
            }
            else if($mode->mode == "M"){
               $time = strtotime($mode->device_time) - strtotime($previous_time);
               $motion= $motion+$time;  
                if($motion<0)
               {
                $motion="0";                
               }                                
            }
            else if($mode->mode == "H"){
               $time = strtotime($mode->device_time) - strtotime($previous_time);
               $halt= $halt+$time;   
               // dd($halt) ;
              if($halt<0)
              {
                $halt="0";               
              }  
                                    
            }
        }
        $previous_time = $mode->device_time;
      }

       $alerts =Alert::select(
            'id',
            'alert_type_id', 
            'device_time',    
            'gps_id', 
            'latitude',
            'longitude', 
            'status'
        )
        ->with('alertType:id,description')
        ->where('gps_id',$single_vehicle_id)
        ->get();
dd($alerts);
        return response()->json([
            'dailykm' => $km_report, 
            'sleep' => $this->timeFormate($sleep),  
            'motion' => $this->timeFormate($motion),   
            'halt' => $this->timeFormate($halt),                
            'status' => 'kmReport'           
        ]);

    //     $response_data = array(
    //             'status'  => 'success',
    //             'message' => 'success',
    //             'code'    =>1,                              
    //             'polyline' => $playback,
    //             'markers' => $playbackData,
                
    //         );
    //     }else{
    //         $response_data = array(
    //             'status'  => 'failed',
    //             'message' => 'failed',
    //             'code'    =>0
    //         );
    //     }

    
    // return response()->json($response_data); 



        // return DataTables::of($km_report)
        // ->addIndexColumn()        
        // ->addColumn('totalkm', function ($km_report) {
        //   $gps_km=$km_report->km;
        //   $km=round($gps_km/1000);
        //     return $km;
        // })
        // ->make();
    }
    function VehicleGPs($vehicle){       
        $vehicle_details =Vehicle::withTrashed()->find($vehicle);
       return  $single_vehicle_id = $vehicle_details->gps_id;
       
    }

    function dailyKmReport($client_id,$vehicle,$search_from_date,$search_to_date,$single_vehicle_id){
         $query =DailyKm::select(
            'gps_id', 
            'date',  
            \DB::raw('SUM(km) as km')    
        )
        ->with('gps.vehicle')
        ->groupBy('gps_id')   
        ->orderBy('id', 'desc');             
         if($vehicle==0 || $vehicle==null)
        {        
            $query = $query->whereIn('gps_id',$single_vehicle_id);           
        }
        else
        {
            $query = $query->where('gps_id',$single_vehicle_id)
            ->groupBy('gps_id');               
        }   
        if($search_from_date){            
            $query = $query->whereDate('date', '>=', $search_from_date)->whereDate('date', '<=', $search_to_date);
        }                     
         return $km_report = $query->first();  
    }
    
    function timeFormate($second){
      $hours = floor($second / 3600);
      $mins = floor($second / 60 % 60);
      $secs = floor($second % 60);
      $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
      return $timeFormat;
    }


     public function kmExport(Request $request)
    {
       return Excel::download(new KMReportExport($request->id,$request->vehicle,$request->report_type), 'Km-report.xlsx');
    } 
}

