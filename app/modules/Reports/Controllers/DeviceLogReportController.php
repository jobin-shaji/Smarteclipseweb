<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Models\ClientAlertPoint;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Alert\Models\AlertType;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;

use App\Modules\Gps\Models\GpsLog;
use DataTables;
class DeviceLogReportController extends Controller {
    public function logReport ()
    {
        return view('Reports::log-report');
    }   
    public function logReportList(Request $request)
    {
        $subdealer=$request->client;
        dd($subdealer);
       $gps_logs = GpsLog::select(
            'id',
            'gps_id',
            'status',
            'user_id',
            'created_at'
        )  
        ->where('user_id',$subdealer)              
        ->with('gps:id,name,imei')
        ->with('user:id,username')
        ->get();
        return DataTables::of($gps_logs)
        ->addIndexColumn()
          ->addColumn('status', function ($gps_logs) {
            if($gps_logs->status==0)
            {
                 return "Deactivated";
            }
            else
            {
                return "Activated";
            }
                 
         })
        ->rawColumns(['link'])
        ->make();
    }
   

  #####################################################
}
