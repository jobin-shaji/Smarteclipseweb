<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;


class FormanyDriverReportExport implements FromView
{
	protected $FormanyDriverReportExport;
	public function __construct($client,$from,$to)
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
        ->with('vehicle:id,name,register_number')
        ->where('client_id',$client)
        ->where('status',1);
        if($from)
        {
            $query = $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        $this->FormanyDriverReportExport = $query->get();
    } 
    public function view(): View
	{
	    return view('Exports::formany-driver-report', [
	        'FormanyDriverReportExport' => $this->FormanyDriverReportExport
	    ]);
	}    
}

