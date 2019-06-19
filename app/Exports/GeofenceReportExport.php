<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Vehicle\Models\Vehicle;
class GeofenceReportExport implements FromView
{
	protected $geofenceReportExport;
	public function __construct($client,$vehicle,$from,$to)
    {        
       if($vehicle==0)
        {
            $query =GpsData::select(
                'id',
                'vehicle_id', 
                'alert_id',    
                'device_time'
            )
            ->with('vehicle:id,name,register_number')
            ->with('alert:id,code,description')
            ->whereIn('alert_id',[18,19,20,21])
            ->where('client_id',$client);
        }
        else
        {
            $query =GpsData::select(
                'id',
                'vehicle_id', 
                'alert_id',    
                'device_time'
            )
            ->with('vehicle:id,name,register_number')
            ->with('alert:id,code,description')
            ->whereIn('alert_id',[18,19,20,21])
            ->where('client_id',$client)
            ->where('vehicle_id',$vehicle);
        }       
        if($from){
            $query = $query->whereBetween('device_time',[$from,$to]);
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

