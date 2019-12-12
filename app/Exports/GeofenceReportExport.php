<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
class GeofenceReportExport implements FromView
{
	protected $geofenceReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {        
        if($vehicle==0)
        {
            $gps_stocks=GpsStock::where('client_id',$client)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }
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
            ->with('gps.vehicle')
            ->orderBy('device_time', 'DESC')
           ->whereIn('gps_id',$gps_list)
            ->whereIn('alert_type_id',[5,6])
            ->orderBy('device_time', 'DESC')
            ->limit(1000);           
        }
        else
        {
            $vehicle=Vehicle::withTrashed()->find($vehicle); 
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
            ->with('gps.vehicle')
            ->orderBy('device_time', 'DESC')
           ->whereIn('gps_id',$vehicle->gps_id)
            ->whereIn('alert_type_id',[5,6])
            ->orderBy('device_time', 'DESC')
            ->limit(1000);   
        }       
        if($from){
           $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
         $this->geofenceReportExport = $query->get(); 
         // dd($this->alertReportExport);  
    }
    public function view(): View
	{
        return view('Exports::geofence-report', [
	        'geofenceReportExport' => $this->geofenceReportExport
	    ]);
	}
    
}

