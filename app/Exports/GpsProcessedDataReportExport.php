<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\VltData;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsConfiguration;
class GpsProcessedDataReportExport implements FromView
{
	protected $gpsProcessedDataReportExport;
	public function __construct($gps_id,$date)
    {  
        $date = date('Y-m-d',strtotime($date));
        $datas = GpsData::select('gps_id','imei','vlt_data','device_time','created_at')->where('gps_id',$gps_id)->whereDate('created_at',$date)->orderBy('created_at','asc')->get(); 
        $this->gpsProcessedDataReportExport = $datas;          
    }
    public function view(): View
	{
       return view('Exports::gps-processed-data-report', [
            'gpsProcessedDataReportExport' => $this->gpsProcessedDataReportExport
        ]);
	}
    
}

