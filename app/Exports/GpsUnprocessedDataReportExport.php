<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\VltData;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsConfiguration;
class GpsUnprocessedDataReportExport implements FromView
{
	protected $gpsUnprocessedDataReportExport;
	public function __construct($gps_id,$date)
    {  
        $gps = Gps::find($gps_id);
        $date = date('Y-m-d',strtotime($date));
        $datas = VltData::select('imei','vltdata','created_at')->where('imei',$gps->imei)->whereDate('created_at',$date)->orderBy('created_at','asc')->get(); 
        $this->gpsUnprocessedDataReportExport = $datas;          
    }
    public function view(): View
	{
       return view('Exports::gps-unprocessed-data-report', [
            'gpsUnprocessedDataReportExport' => $this->gpsUnprocessedDataReportExport
        ]);
	}
    
}

