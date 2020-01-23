<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;



use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\Gps;

class MonitoringReportExport implements FromView, ShouldAutoSize, WithEvents
{
	protected $MonitoringReportExport;
	public function __construct($client,$vehicle_id,$report_type)
    {    
        $this->report_type=$report_type;
        $this->data = (new Vehicle())->getVehicleDetails($vehicle_id);
    }
    public function view(): View
	{
       return view('Exports::monitoring-report', [
            'monitoringReportExport' => $this->data,
            'report_type' => $this->report_type
        ]);
	}



    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
    
}

