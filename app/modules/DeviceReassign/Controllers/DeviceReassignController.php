<?php
namespace App\Modules\DeviceReassign\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use App\Modules\Root\Models\Root;
use Illuminate\Support\Facades\Crypt;
use App\Modules\DeviceReturn\Models\DeviceReturn;
use App\Modules\DeviceReturn\Models\DeviceReturnHistory;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Trader\Models\Trader;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\VltData\Models\VltData;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\VehicleDailyUpdate;
use App\Modules\Complaint\Models\Complaint;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Vehicle\Models\VehicleDriverLog;
use App\Modules\Vehicle\Models\VehicleGeofence;
use Illuminate\Support\Facades\DB;
use DataTables;

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
        'daily_km'                      =>  DailyKm::select('id')->where('gps_id',$request->gps)->count(),
        'complaints'                    =>  Complaint::select('id')->where('gps_id',$request->gps)->count(),
        // 'vehicle_geofence'              =>  VehicleGeofence::select('id')->where('vehicle_id',$request->vehicle)->count(),
        'vehicle_geofence'              =>  DB::table('vehicle_geofences')->select('id')->where('vehicle_id',$request->vehicle)->count(),
        'vehicle_driver_logs'           =>  VehicleDriverLog::select('id')->where('vehicle_id',$request->vehicle)->count()
        ]);
        // return $gps_data;
    }
    public function reassignUpdate(Request $request)
    { 
        $reassign_type_id   =   $request->reassign_type_id;
        $vehicle            =   $request->vehicle;
        $imei               =   $request->imei;
        $gps                =   $request->gps;
        $dealer_id          =   $request->dealer;
        $subdealer_id       =   $request->subdealer;
        $trader_id          =   $request->trader;
        $client_id          =   $request->client;
        $client             =   Client::select('user_id')->where('id',$client_id)->first();
        $trader             =   Trader::select('user_id')->where('id',$trader_id)->first();
        $subdealer          =   SubDealer::select('user_id')->where('id',$subdealer_id)->first();
        $dealer             =   Dealer::select('user_id')->where('id',$dealer_id)->first();
        $gps_transfer_items =   GpsTransferItems::select('gps_transfer_id')->where('gps_id',$gps)->get();
        $gps_transfer_id    =   [];
        foreach ($gps_transfer_items as $each_transfer_item)
        {
            $gps_transfer_id [] = $each_transfer_item->gps_transfer_id;
        }
        Gps::where('imei',$imei)->update(['mode' => null, 'lat' => null, 'lat_dir' => null, 'lon' => null, 'lon_dir' => null, 'network_status' => null, 'fuel_status' => null, 'speed' => null, 'odometer' => null, 'no_of_satellites' => null, 'battery_status' => null, 'heading' => null, 'device_time' => null, 'main_power_status' => null, 'ignition' => null, 'gsm_signal_strength' => null, 'emergency_status' => null, 'ac_status' => null, 'gps_fix_on' => null, 'calibrated_on' => null, 'login_on' => null, 'batch_status' => null, 'queue_status' => null, 'stop_status' => null, 'is_returned' => null, 'tilt_status'=> 0, 'overspeed_status'=> 0, 'km'=> 0, 'test_status'=> 0]);
        Alert::where('gps_id',$gps)->delete();
        GpsData::where('gps_id',$gps)->delete();
        VehicleDailyUpdate::where('gps_id',$gps)->delete();
        Complaint::where('gps_id',$gps)->delete();
        DailyKm::where('gps_id',$gps)->delete();
        VltData::where('imei',$imei)->delete();
        DB::table('servicer_jobs')->where('gps_id',$gps)->delete();
        if($reassign_type_id == 4 || $reassign_type_id == 3)
        {
            GpsStock::where('gps_id',$gps)->update(['client_id' => null]);
            if($reassign_type_id == 4)
            {
                $gps_transfer_log =  GpsTransfer::select('id') 
                ->whereIn('id', $gps_transfer_id)           
                ->where('from_user_id',$trader->user_id)
                ->where('to_user_id',$client->user_id)
                ->first();
                $gps_transfer_id = $gps_transfer_log->id;             
                $count_of_transfer_item = GpsTransferItems::select('id')
                                        ->where('gps_transfer_id',$gps_transfer_id)
                                        ->count();
                if($count_of_transfer_item == 1)
                {
                    // Delete $gps_transfer_log
                    GpsTransfer::where('id',$gps_transfer_log->id)->forceDelete();
                    // Delete  row in gps_transfer_item 
                    GpsTransferItems::where('gps_transfer_id',$gps_transfer_id)
                    ->where('gps_id', $gps)
                    ->delete();
                }
                else
                {
                    // Delete  row in gps_transfer_item 
                    GpsTransferItems::where('gps_transfer_id',$gps_transfer_id)->where('gps_id', $gps)->delete();
                }
                $vehiclegps_count = VehicleGps::select('id')
                                    ->where('vehicle_id',$vehicle)
                                    ->count();
                if($vehiclegps_count == 1)
                {
                    VehicleDriverLog::where('vehicle_id',$request->vehicle)->delete();
                    DB::table('vehicles')->where('gps_id',$gps)->delete();
                    DB::table('vehicle_geofences')->where('vehicle_id',$vehicle)->delete();
                    // VehicleGeofence::where('vehicle_id',$vehicle)->delete();
                    // ServicerJob::where('gps_id',$gps)->delete();
                    // Vehicle::where('gps_id',$request->gps)->delete();
                    DB::table('vehicle_gps')->where('vehicle_id',$request->vehicle)->delete();
                }
                else
                {
                    $vehicles_gps = VehicleGps::select('id','vehicle_id','gps_id','servicer_job_id')->where('vehicle_id',$vehicle)->orderBy('gps_fitted_on', 'desc')->first();
                    $vehicles_gps->delete();
                    $vehiclegps_data = VehicleGps::select('id','vehicle_id','gps_id','servicer_job_id')->where('vehicle_id',$vehicle)->orderBy('gps_fitted_on', 'desc')->get();
                    DB::table('vehicles')->where('id', $vehiclegps_data->vehicle_id)
                    ->update(['gps_id' => $vehiclegps_data->gps_id,'servicer_job_id' => $vehiclegps_data->servicer_job_id]);
                }
                return response()->json([
                    'status' => 1,
                    'title' => 'Success',
                    'message' => 'Reassigned to Subdealer successfully'
                ]);

            }
            elseif($reassign_type_id == 3)
            {
                $gps_transfer_log =  GpsTransfer::select('id') 
                ->whereIn('id', $gps_transfer_id)           
                ->where('from_user_id',$subdealer->user_id)
                ->where('to_user_id',$client->user_id)
                ->first();
                $gps_transfer_id = $gps_transfer_log->id; 
                
                $count_of_transfer_item = GpsTransferItems::select('id')
                                        ->where('gps_transfer_id',$gps_transfer_id)
                                        ->count();
                if($count_of_transfer_item == 1)
                {
                    // Delete $gps_transfer_log
                    GpsTransfer::where('id',$gps_transfer_log->id)->delete();
                    // Delete  row in gps_transfer_item 
                    GpsTransferItems::where('gps_transfer_id',$gps_transfer_id)->where('gps_id', $gps)->delete();
                }
                else
                {
                    // Delete  row in gps_transfer_item 
                    GpsTransferItems::where('gps_transfer_id',$gps_transfer_id)->where('gps_id', $gps)->delete();
                }
                $vehiclegps_count = VehicleGps::select('id')
                                    ->where('vehicle_id',$vehicle)
                                    ->count();
                if($vehiclegps_count == 1)
                {
                    VehicleDriverLog::where('vehicle_id',$request->vehicle)->delete();
                    DB::table('vehicles')->where('gps_id',$gps)->delete();
                    DB::table('vehicle_geofences')->where('vehicle_id',$vehicle)->delete();
                    // VehicleGeofence::where('vehicle_id',$vehicle)->delete();
                    // ServicerJob::where('gps_id',$gps)->delete();
                    // Vehicle::where('gps_id',$request->gps)->delete();
                    DB::table('vehicle_gps')->where('vehicle_id',$request->vehicle)->delete();
                }
                else
                {
                    $vehicles_gps = VehicleGps::select('id','vehicle_id','gps_id','servicer_job_id')->where('vehicle_id',$vehicle)->orderBy('gps_fitted_on', 'desc')->first();
                    $vehicles_gps->delete();
                    $vehiclegps_data = VehicleGps::select('id','vehicle_id','gps_id','servicer_job_id')->where('vehicle_id',$vehicle)->orderBy('gps_fitted_on', 'desc')->get();
                    DB::table('vehicles')->where('id', $vehiclegps_data->vehicle_id)
                    ->update(['gps_id' => $vehiclegps_data->gps_id,'servicer_job_id' => $vehiclegps_data->servicer_job_id]);
                }
                return response()->json([
                    'status' => 1,
                    'title' => 'Success',
                    'message' => 'Reassigned to Dealer successfully'
                ]);
            }
        }
        else
        {
            VehicleDriverLog::where('vehicle_id',$request->vehicle)->delete();
            DB::table('vehicles')->where('gps_id',$gps)->delete();
            DB::table('vehicle_geofences')->where('vehicle_id',$request->vehicle)->delete();
            DB::table('vehicle_gps')->where('vehicle_id',$request->vehicle)->delete();
            // VehicleGeofence::where('vehicle_id',$vehicle)->delete();
            // ServicerJob::where('gps_id',$gps)->delete();
            // Vehicle::where('gps_id',$request->gps)->delete();
            if($reassign_type_id == 2)
            {
                GpsStock::where('gps_id',$gps)->update(['trader_id' => null]);
                $gps_transfer_log =  GpsTransfer::select('id') 
                ->whereIn('id', $gps_transfer_id)           
                ->where('from_user_id',$subdealer->user_id)
                ->where('to_user_id',$trader->user_id)
                ->first();
                $gps_transfer_id = $gps_transfer_log->id;            
                $count_of_transfer_item = GpsTransferItems::select('id')
                ->where('gps_transfer_id',$gps_transfer_id)
                ->count();
                if($count_of_transfer_item == 1)
                {
                    // Delete $gps_transfer_log
                    GpsTransfer::where('id',$gps_transfer_log->id)->delete();
                    // Delete  row in gps_transfer_item 
                    GpsTransferItems::where('gps_transfer_id',$gps_transfer_id)->where('gps_id', $gps)->delete();
                }
                else
                {
                    // Delete  row in gps_transfer_item 
                    GpsTransferItems::where('gps_transfer_id',$gps_transfer_id)->where('gps_id', $gps)->delete();
                }
                return response()->json([
                    'status' => 1,
                    'title' => 'Success',
                    'message' => 'Reassigned to Dealer successfully'
                ]);
            }
            elseif($reassign_type_id == 1)
            {
                GpsStock::where('gps_id',$gps)->update(['subdealer_id' => null]);
                $gps_transfer_log =  GpsTransfer::select('id') 
                ->whereIn('id', $gps_transfer_id)           
                ->where('from_user_id',$dealer->user_id)
                ->where('to_user_id',$subdealer->user_id)
                ->first();
                $gps_transfer_id = $gps_transfer_log->id; 
                
                $count_of_transfer_item = GpsTransferItems::select('id')
                                        ->where('gps_transfer_id',$gps_transfer_id)
                                        ->count();
                if($count_of_transfer_item == 1)
                {
                    // Delete $gps_transfer_log
                    GpsTransfer::where('id',$gps_transfer_log->id)->delete();
                    // Delete  row in gps_transfer_item 
                    GpsTransferItems::where('gps_transfer_id',$gps_transfer_id)->where('gps_id', $gps)->delete();
                }
                else
                {
                    // Delete  row in gps_transfer_item 
                    GpsTransferItems::where('gps_transfer_id',$gps_transfer_id)->where('gps_id', $gps)->delete();
                }
                return response()->json([
                    'status' => 1,
                    'title' => 'Success',
                    'message' => 'Reassigned to Distributor successfully'
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 1,
                    'title' => 'Success',
                    'message' => 'Something went wrong!!!'
                ]); 
            }
        }
    }

   
}
