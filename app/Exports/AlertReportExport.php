<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
class AlertReportExport implements FromView
{
	protected $alertReportExport;
	public function __construct($client,$from,$to)
    {      
        // if($alert==0)
        // {
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
            ->with('vehicle:id,name,register_number')
            ->where('client_id',$client)
            ->where('status',1);
       // }
       // else
       // {
       //      $query =Alert::select(
       //      'id',
       //      'alert_type_id', 
       //      'device_time',    
       //      'vehicle_id',
       //      'gps_id',
       //      'client_id',  
       //      'latitude',
       //      'longitude', 
       //      'status'
       //  )
       //  ->with('alertType:id,description')
       //  ->with('vehicle:id,name,register_number')
       //  ->where('client_id',$client)
       //  ->where('alert_type_id',$alert)
       //  ->where('status',1);
       // }        
        if($from){
            $query = $query->whereDate('device_time', '>=', $from)->whereDate('device_time', '<=', $to);
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

