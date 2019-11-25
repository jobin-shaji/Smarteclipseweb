<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Alert\Models\Alert;
class AlertReportExport implements FromView
{
	protected $alertReportExport;
	public function __construct($client,$alert_id,$vehicle_id,$from,$to)
    {   
          $VehicleGpss=Vehicle::select(
            'id',
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client)
        ->withTrashed()
        ->get();      
        $single_vehicle_gps = [];
        foreach($VehicleGpss as $VehicleGps){
            $single_vehicle_gps[] = $VehicleGps->gps_id;
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
            // ->orderBy('id', 'desc')
            ->orderBy('device_time', 'DESC')
            ->limit(1000);
          
       if($alert_id==0 && $vehicle_id==0)
       {  

            $query = $query->whereIn('gps_id',$single_vehicle_gps);
       }
       else if($alert_id!=0 && $vehicle_id==0 || $vehicle_id==null)
       {         
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('alert_type_id',$alert_id);
       }
       else if($alert_id==0 && $vehicle_id!=0)
       {
            $vehicle=Vehicle::withTrashed()->find($vehicle_id);
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('gps_id',$vehicle->gps_id);
            // ->where('status',1);
       }
       else
       {
            $vehicle=Vehicle::withTrashed()->find($vehicle_id);
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('alert_type_id',$alert_id)
            ->where('gps_id',$vehicle->gps_id);
            // ->where('status',1);
       }       
        if($from){
          $search_from_date=date("Y-m-d", strtotime($from));
          $search_to_date=date("Y-m-d", strtotime($to));
          $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
        }
         $this->alertReportExport = $query->get(); 
         // dd($this->alertReportExport);  
    }
    public function view(): View
	{
        return view('Exports::alert-report', [
	        'alertReportExport' => $this->alertReportExport
	    ]);
	}
    
}

