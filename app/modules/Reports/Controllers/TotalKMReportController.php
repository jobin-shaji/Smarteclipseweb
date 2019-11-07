<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\TotalKMReportExport;
use App\Exports\KMReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
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
        $single_vehicle_id = [];
        $client_id=\Auth::user()->client->id;       
        $vehicle =$request->data['vehicle'];
        $report_type =$request->data['report_type'];
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
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::where('client_id',$client_id)->withTrashed()->get();            
            foreach($vehicle_details as $vehicle_detail){
                $single_vehicle_id[] = $vehicle_detail->gps_id; 
            }
        }
         $query =DailyKm::select(
            'gps_id', 
            'date',  
            \DB::raw('SUM(km) as km')    
        )
        ->with('gps.vehicle')
        // ->with('alert')  
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
        if($report_type){            
            $query = $query->whereDate('date', '>=', $search_from_date)->whereDate('date', '<=', $search_to_date);
        }                     
        $km_report = $query->first();
        return response()->json([
                'dailykm' => $km_report,               
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
     public function kmExport(Request $request)
    {
       return Excel::download(new KMReportExport($request->id,$request->vehicle,$request->report_type), 'Km-report.xlsx');
    } 
}

