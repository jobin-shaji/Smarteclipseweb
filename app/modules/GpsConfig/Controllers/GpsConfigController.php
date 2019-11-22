<?php 
namespace App\Modules\GpsConfig\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsConfiguration;


use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;
use DB;
use Config;

class GpsConfigController extends Controller {

    public function gpsConfigListPage()
    {
        $gps = Gps::all();
        return view('GpsConfig::gps-config-list',['gps' => $gps]);
    }
    public function getAllGpsConfig(Request $request)
    {
        if($request->gps_id){
            $items = Gps::find($request->gps_id);  
        }else{
            $items = Gps::all();  
        }
        return response()->json($items); 
    }
    public function allGpsConfigListPage()
    {
        $gps = Gps::all();
        return view('GpsConfig::all-gps-config-list',['gps' => $gps]);
    }
    public function getAllGpsConfigList(Request $request)
    {
        if($request->gps_id){
            $items = GpsConfiguration::where('gps_id',$request->gps_id)->first();  
        }
     
        return response()->json($items); 
    }
    public function gpsConfigListPagePublic()
    {
        $gps = Gps::all();
        return view('GpsConfig::gps-config-list-public',['gps' => $gps]);
    }
    public function getAllGpsConfigPublic(Request $request)
    {
        if($request->gps_id){
            $items = Gps::find($request->gps_id);  
        }else{
            $items = Gps::all();  
        }
        return response()->json($items); 
    }

    
}