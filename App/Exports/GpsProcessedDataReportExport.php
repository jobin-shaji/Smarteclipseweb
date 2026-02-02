<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Gps\Models\Gps;
use App\Modules\VltData\Models\VltData;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsConfiguration;
class GpsProcessedDataReportExport implements FromView
{
	protected $gpsProcessedDataReportExport;
	public function __construct($imei,$date)
    { 
        $date = date('Y-m-d',strtotime($date));
        $datas = (new VltData())->getProcessedVltDataDownload($imei, $date); 
        $this->gpsProcessedDataReportExport = $datas;          
    }
    public function view(): View
	{
       return view('Exports::gps-processed-data-report', [
            'gpsProcessedDataReportExport' => $this->gpsProcessedDataReportExport
        ]);
	}
    
}

