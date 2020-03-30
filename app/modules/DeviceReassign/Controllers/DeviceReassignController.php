<?php
namespace App\Modules\DeviceReassign\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use App\Modules\Root\Models\Root;
use Illuminate\Support\Facades\Crypt;
use App\Modules\DeviceReturn\Models\DeviceReturn;
use App\Modules\DeviceReturn\Models\DeviceReturnHistory;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Trader\Models\Trader;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\VltData\Models\VltData;

use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\VehicleDailyUpdate;
use App\Modules\Complaint\Models\Complaint;
use App\Modules\Vehicle\Models\DailyKm;

use DataTables;
use DB;

class DeviceReassignController extends Controller 
{
    /**
     * 
     * 
     */
    public function create()
    {
        return view('DeviceReassign::device-reassign-create');
    }
    /**
     * 
     */

    public function hierarchylist(Request $request)
    {
        $data  =   (new Gps())->getDeviceHierarchyDetails($request->imei);
        return view('DeviceReassign::device-reassign-create',['data'=>$data]);
    }
    /**
     * 
     * 
     * 
     */

    public function getGpsCount(Request $request)
    {      
        return response()->json([
        'gps_data'                      =>  GpsData::select('id')->where('gps_id',$request->gps)->count(),
        'vlt_data'                      =>  VltData::select('id')->where('imei',$request->imei)->count(),
        'alert'                         =>  Alert::select('id')->where('gps_id',$request->gps)->count(),
        'vehicle_daily_updates'         =>  VehicleDailyUpdate::select('id')->where('gps_id',$request->gps)->count(),
        'daily_km'                      => DailyKm::select('id')->where('gps_id',$request->gps)->count(),
        'complaints'                    =>  Complaint::select('id')->where('gps_id',$request->gps)->count()        
        ]);
        // return $gps_data;
    }
    public function reassignUpdate(Request $request)
    { 
        $reassign_type_id=$request->reassign_type_id;
        $imei=$request->imei;
        $gps=$request->gps;
        dd($reassign_type_id);
        if($reassign_type_id==4){
            $gps_stock = GpsStock::Select('id','client_id','gps_id')->where('gps_id',$request->gps)->update('client_id',null);
        }
        // $alert_type = AlertType::find($request->uid);
        // $alert_type->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert Type deleted successfully'
        ]);
    }

   
}
