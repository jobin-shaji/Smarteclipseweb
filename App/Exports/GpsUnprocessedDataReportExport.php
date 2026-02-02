<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Gps\Models\Gps;
use App\Modules\VltData\Models\VltData;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsConfiguration;
class GpsUnprocessedDataReportExport implements FromView
{
	protected $gpsUnprocessedDataReportExport;
	public function __construct($imei,$date)
    {
        $date = date('Y-m-d',strtotime($date));
        $datas = (new VltData())->getUnprocessedVltDataDownload($imei, $date);
        $this->gpsUnprocessedDataReportExport = $datas;
    }
    public function view(): View
	{
       return view('Exports::gps-unprocessed-data-report', [
            'gpsUnprocessedDataReportExport' => $this->gpsUnprocessedDataReportExport
        ]);
	}

}

