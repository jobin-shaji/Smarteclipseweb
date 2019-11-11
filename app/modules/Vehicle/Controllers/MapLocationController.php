<?php

namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Ota\Models\OtaResponse;
use App\Modules\Vehicle\Models\VehicleRoute;
use App\Modules\Route\Models\RouteArea;
use App\Modules\Vehicle\Models\DocumentType;
use App\Modules\Vehicle\Models\VehicleDriverLog;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Ota\Models\GpsOta;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Driver\Models\Driver;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Servicer\Models\ServicerJob;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use DataTables;
use Config;

class MapLocationController extends Controller {
    
    public function vehicleMapLocation(Request $request)
    {
        $decrypted_gps_id = Crypt::decrypt($request->id);
        $gps=Gps::find($decrypted_gps_id);
        return view('Vehicle::map-location-tracker',['gps' => $gps]);
    }

    public function vehicleMapLocationTrack(Request $request)
    {
        $client_id=$request->client;
        $gps_id=$request->gps_id;
        $from_date=date('Y-m-d H:i:s',strtotime($request->from_date));
        $to_date=date('Y-m-d H:i:s',strtotime($request->to_date));
        $track_data=GpsData::select('latitude as lat',
                      'longitude as lng'
                    )
                    ->where('gps_id',$gps_id)
                    ->whereBetween('device_time', array($from_date, $to_date))
                    ->get();
        $track_data_with_gpsfix=GpsData::select('latitude as lat',
          'longitude as lng'
        )
        ->where('gps_id',$gps_id)
        ->where('gps_fix',1)
        ->whereBetween('device_time', array($from_date, $to_date))
        ->get();
        return response()->json($track_data); 
    }
   
}
