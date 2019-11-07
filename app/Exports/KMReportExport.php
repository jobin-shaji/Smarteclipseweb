<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\DailyKm;

class KMReportExport implements FromView
{
	protected $kmReportExport;
	public function __construct($client,$vehicle,$report_type)
    {   
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
            $vehicle_details =Vehicle::where('client_id',$client)->withTrashed()->get();            
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
        ->groupBy('gps_id')   
        ->orderBy('id', 'desc');             
         if($vehicle==0)
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
        $this->kmReportExport = $query->get();   

    }
    public function view(): View
	{
        // dd($this->totalkmReportExport); 
       return view('Exports::km-report', [
            'kmReportExport' => $this->kmReportExport
        ]);
	}
    
}

