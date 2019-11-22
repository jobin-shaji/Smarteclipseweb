<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Route\Models\RouteDeviation;
use App\Modules\Vehicle\Models\Vehicle;
class HarshBrakingReportExport implements FromView
{
	protected $harshBrakingReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {  
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
        ->with('gps.vehicle');
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
            $vehicle=Vehicle::withTrashed()->find($vehicle); 
            $query = $query->where('alert_type_id',1)->where('gps_id',$vehicle->gps_id);
            // ->where('status',1);
            if($from){
               $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        $this->harshBrakingReportExport = $query->get();          
    }
    public function view(): View
	{
       return view('Exports::harsh-Braking-report', [
            'harshBrakingReportExport' => $this->harshBrakingReportExport
        ]);
	}
    
}

