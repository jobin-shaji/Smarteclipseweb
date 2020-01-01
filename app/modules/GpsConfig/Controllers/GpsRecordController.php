<?php 
namespace App\Modules\GpsConfig\Controllers;

use App\Exports\GpsUnprocessedDataReportExport;
use App\Exports\GpsProcessedDataReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\VltData;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsConfiguration;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;
use DB;
use Config;

class GpsRecordController extends Controller {

    public function gpsDateWiseRecord()
    {
        $gps = Gps::all();
        return view('GpsConfig::gps-daily-record',['gps' => $gps]);
    }
    public function gpsDateWiseRecordList(Request $request)
    {
        $gps_id = $request->gps_id;
        $date = date('Y-m-d',strtotime($request->date));
        $datas = GpsData::select('gps_id','imei','vlt_data','device_time','created_at')->where('gps_id',$gps_id)->whereDate('created_at',$date)->orderBy('created_at','asc')->get();  
        return response()->json($datas); 
    }

    public function exportProcessedData(Request $request)
    {
       return Excel::download(new GpsProcessedDataReportExport($request->gps_id,$request->date), 'gps-processed-data-report.xlsx');
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
       return Excel::download(new GpsUnprocessedDataReportExport($request->gps_id,$request->date), 'gps-unprocessed-data-report.xlsx');
    } 
    
}