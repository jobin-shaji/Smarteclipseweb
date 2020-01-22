<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
class MonitoringReportExport implements FromView
{
	protected $MonitoringReportExport;
	public function __construct($client)
    {       
        // $query =Alert::select(
        //     'id',
        //     'alert_type_id', 
        //     'device_time',    
        //     'gps_id',
        //     'latitude',
        //     'longitude', 
        //     'status'
        // )
        // ->orderBy('id','desc')
        // ->first(); 
        // $this->MonitoringReportExport = $query;  

    }

    public function view(): View
	{
       return view('Exports::monitoring-report');
	}
    
}

