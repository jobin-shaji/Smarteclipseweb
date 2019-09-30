<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Alert\Models\Alert;
class AlertReportExport implements FromView
{
	protected $alertReportExport;
	public function __construct($client,$alert,$vehicle,$from,$to)
    {   
          $VehicleGpss=Vehicle::select(
            'id',
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client)
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
            ->orderBy('id', 'desc')
            ->limit(1000);
        if($alert==0  && $vehicle ==0)
        {
          
             $query = $query->whereIn('gps_id',$single_vehicle_gps);
            // ->where('status',1);
        }
        else if($alert!=0 && $vehicle==0 )
        {          
           $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('alert_type_id',$alert_id);
            // ->where('status',1);
        }
        else if($alert==0 && $vehicle!=0)
        {
            $query =  $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('vehicle_id',$vehicle);
            // ->where('status',1);
        }
       else
       {
            $query = $query->whereIn('gps_id',$single_vehicle_gps)
            ->where('alert_type_id',$alert)
            ->where('vehicle_id',$vehicle);
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

