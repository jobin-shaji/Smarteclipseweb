<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
class AlertReportExport implements FromView
{
	protected $alertReportExport;
	public function __construct($client,$alert,$vehicle,$from,$to)
    {   
         
        $query =Alert::select(
                'id',
                'alert_type_id', 
                'device_time',    
                'vehicle_id',
                'gps_id',
                'client_id',  
                'latitude',
                'longitude', 
                'status'
            )
            ->with('alertType:id,description')
            ->with('vehicle:id,name,register_number');
        if($alert==0  && $vehicle ==0)
        {
          
            $query = $query->where('client_id',$client);
            // ->where('status',1);
        }
        else if($alert!=0 && $vehicle==0)
        {          
            $query = $query->where('client_id',$client)
            ->where('alert_type_id',$alert);
            // ->where('status',1);
        }
        else if($alert==0 && $vehicle!=0)
        {
            $query = $query->where('client_id',$client)
            ->where('vehicle_id',$vehicle);
            // ->where('status',1);
        }
       else
       {
            $query = $query->where('client_id',$client)
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

