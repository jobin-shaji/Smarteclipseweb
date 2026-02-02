<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Route\Models\RouteDeviation;
use App\Modules\Vehicle\Models\Vehicle;
class RouteDeviationReportExport implements FromView
{
	protected $routeDeviationReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {  
        // dd($from);
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
        ->with('route:id,name');
        if($from==null || $to=null)
        {
             $query = $query->where('client_id',$client);
        }   
        else if($vehicle==0)
        {
            $query = $query->where('client_id',$client);
            if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
               
                $query = $query->whereBetween('deviating_time',[$search_from_date,$search_to_date]);
            }
        }
        else
        {
            $query = $query->where('vehicle_id',$vehicle)       
            ->where('client_id',$client);
            if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
               
                $query = $query->whereBetween('deviating_time',[$search_from_date,$search_to_date]);
            }  
        }        
        

         $this->routeDeviationReportExport = $query->get(); 
         // dd($this->trackReportExport);
         // dd($this->alertReportExport);  
    }
    public function view(): View
	{
       return view('Exports::route-deviation-report', [
            'routeDeviationReportExport' => $this->routeDeviationReportExport
        ]);
	}
    
}

