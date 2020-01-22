<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\Gps;

class MonitoringReportExport implements FromView
{
	protected $MonitoringReportExport;
	public function __construct($client,$vehicle_id)
    {    
        $this->data = (new Vehicle())->getVehicleDetails($vehicle_id);                   
    }

    public function view(): View
	{

       return view('Exports::monitoring-report', [
            'monitoringReportExport' => $this->data
        ]);
	}
    
}

