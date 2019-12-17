<?php 
namespace App\Modules\GpsConfig\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsConfiguration;
use Illuminate\Support\Str;
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
        $datas = GpsData::select('gps_id','imei','vlt_data','device_time','created_at')->where('gps_id',$gps_id)->whereDate('created_at',$date)->get();  
        return response()->json($datas); 
    }
    
}