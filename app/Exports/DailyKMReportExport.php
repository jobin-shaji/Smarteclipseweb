<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\DailyKm;

class DailyKMReportExport implements FromView
{
	protected $dailykmReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {  
        $search_from_date=date("Y-m-d", strtotime($from));
        $search_to_date=date("Y-m-d", strtotime($to));
        // dd($from);
        $query =DailyKm::select(
            'gps_id', 
            'date',      
           'km'
        )
        ->with('gps.vehicle')    
        ->orderBy('id', 'desc');      
       
        if($vehicle_id==0 || $vehicle_id==null){
            $gps_stocks=GpsStock::where('client_id',$client)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }
            $query = $query->whereIn('gps_id',$gps_list);          
        }
        else{
            $vehicle=Vehicle::withTrashed()->find($vehicle_id); 
            $query = $query->where('gps_id',$vehicle->gps_id);            
        }  
        if($from){            
            $query = $query->whereDate('date', '>=', $search_from_date)->whereDate('date', '<=', $search_to_date);
        }                     
        $this->dailykmReportExport = $query->get();          
    }
    public function view(): View
	{
       return view('Exports::daily-km-report', [
            'dailykmReportExport' => $this->dailykmReportExport
        ]);
	}
    
}

