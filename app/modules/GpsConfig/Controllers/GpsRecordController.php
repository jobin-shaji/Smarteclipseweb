<?php
namespace App\Modules\GpsConfig\Controllers;

use App\Exports\GpsUnprocessedDataReportExport;
use App\Exports\GpsProcessedDataReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\VltData\Models\VltData;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsConfiguration;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;
use DB;
use Config;

class GpsRecordController extends Controller {

    public function gpsDateWiseRecord(Request $request)
    {
        $imei_serial_no_list    = (new Gps())->getImeiList();
        $data                   = [];
        // params
        $this->imei             = ( isset($request->imei) ) ? $request->imei : '';
        $this->date             = ( isset($request->date) ) ? date('Y-m-d', strtotime($request->date)) : '';

        // filters
        $filters    = [
            'imei'  => $this->imei,
            'date'  => $this->date
        ];

        if( $this->imei != '' && $this->date != '' )
        {
            $data   = (new VltData())->getProcessedVltData($this->imei, $this->date);
        }
        
        return view('GpsConfig::gps-daily-record', [ 'imei_serial_no_list' => $imei_serial_no_list, 'data' => $data, 'filters' => $filters ]);
    }

    public function exportProcessedData(Request $request)
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new GpsProcessedDataReportExport($request->imei,$request->date), 'gps-processed-data-report.xlsx');
    }

    public function gpsUnprocessedDateWiseRecord()
    {
        $gps = Gps::all();
        return view('GpsConfig::gps-unprocessed-daily-record',['gps' => $gps]);
    }
    public function gpsUnprocessedDateWiseRecordList(Request $request)
    {
        $gps_id = $request->gps_id;
        $gps = Gps::find($gps_id);
        $date = date('Y-m-d',strtotime($request->date));
        $datas = VltData::select('imei','vltdata','created_at')->where('imei',$gps->imei)->whereDate('created_at',$date)->orderBy('created_at','asc')->get();
        return response()->json($datas);
    }

    public function exportUnprocessedData(Request $request)
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new GpsUnprocessedDataReportExport($request->gps_id,$request->date), 'gps-unprocessed-data-report.xlsx');
    }

}