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
        // dd($request->imei);
        // $data  =   (new Gps())->getDeviceHierarchyDetails($request->imei);
        $device  =   (new Gps())->getDeviceDetails($request->imei);
        // dd($device);
        return view('DeviceReassign::device-reassign-create',['datalist'=>$device]);
    }
    /**
     * 
     * 
     * 
     */

    public function getGpsCount(Request $request)
    {
        $gps_data = GpsData::select(
            'id'
        )
        ->where('imei',$request->imei)
        ->count();
        return $gps_data;
    }

    public function getVltCount(Request $request)
    {
        $vlt_data = VltData::select(
            'id'
        )
        ->where('imei',$request->imei)
        ->count();
        return $vlt_data;
    }
    
    public function getDeviceList(Request $request)
    {
        $device  =   (new Gps())->getDeviceDetails($request->imei);
        return DataTables::of($device)
        ->addIndexColumn()
        ->addColumn('sub_dealer', function ($device) { 
            if($device->gpsStock->trader_id != NULL)
            {
                return $device_return->gpsStock->trader->name;
            }
            else
            {
                return "--";
            }        
        })
         ->addColumn('sub_dealer_id', function ($device) { 
            if($device->gpsStock->trader_id != NULL)
            {
                return $device_return->gpsStock->trader-trader_id;
            }
            else
            {
                return "--";
            }        
        })
        ->addColumn('dealer', function ($device) { 
            if($device->gpsStock->subdealer_id != NULL)
            {
                return $device->gpsStock->subdealer->name;
            }
            else 
            {
                return "--";
            }        
        })
        ->addColumn('dealer_id', function ($device) { 
            if($device->gpsStock->subdealer_id != NULL)
            {
                return $device->gpsStock->subdealer_id;
            }
                  
        })
        ->addColumn('distributor', function ($device) { 
            if($device->gpsStock->dealer_id != NULL)
            {
                return $device->gpsStock->dealer->name;
            }
            else 
            {
                return "--";
            }        
        })
        ->addColumn('distributor_id', function ($device) { 
            if($device->gpsStock->dealer_id != NULL)
            {
                return $device->gpsStock->dealer_id;
            }
                   
        })
         ->addColumn('client', function ($device) { 
            if($device->gpsStock->client_id != NULL)
            {
                return $device->gpsStock->client->name;
            }
            else 
            {
                return "--";
            }        
        })
         ->addColumn('client_id', function ($device) { 
            if($device->gpsStock->client_id != NULL)
            {
                return $device->gpsStock->client_id;
            }
                  
        })
         ->addColumn('manufacturer', function ($device) { 
            if($device->gpsStock->inserted_by != NULL)
            {
                return $device->gpsStock->user->username;
            }
            else 
            {
                return "--";
            }        
        })
         ->addColumn('manufacturer_id', function ($device) {             
                return $device->gpsStock->user->id;        
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
}
