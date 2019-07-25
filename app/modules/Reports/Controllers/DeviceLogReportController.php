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
use Auth;
use DataTables;
class DeviceLogReportController extends Controller {
    public function logReport ()
    {
        return view('Reports::log-report');
    }   
    public function logReportList(Request $request)
    { 
       $subdealer=\Auth::user()->id;
        $from = $request->from_date;
        $to = $request->to_date;
       $gps_logs = GpsLog::select(
            'id',
            'gps_id',
            'status',
            'user_id',
            'created_at'
        )  
        ->where('user_id',$subdealer)              
        ->with('gps:id,imei')
        ->with('user:id,username');
        if($from)
        {
             $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $gps_logs = $gps_logs->whereDate('created_at', '>=', $search_from_date)
                ->whereDate('created_at', '<=', $search_to_date);
        }
        $gps_logs=$gps_logs->get(); 
       
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
