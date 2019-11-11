<?php 
namespace App\Modules\GpsConfig\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
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
        return view('Gps::gps-config-list',['gps' => $gps]);
    }
    public function getAllGpsConfig(Request $request)
    {
    
        if($request->gps){
         $items = GpsData::where('gps_id',$request->gps);  
        }else{
         $items = GpsData::limit(10000);  
        }
        return DataTables::of($items)
        ->addIndexColumn()
         ->addColumn('count', function ($items) {
                $count=0;
                $count=strlen($items->vlt_data);
                return $count;
             })
         ->addColumn('forhuman', function ($items) {
                $forhuman=0;
                $forhuman=Carbon::parse($items->device_time)->diffForHumans();
                return $forhuman;
             })
         ->addColumn('servertime', function ($items) {
                $servertime=0;
                 $servertime=Carbon::parse($items->created_at)->diffForHumans();
                return $servertime;
             })
         ->addColumn('action', function ($items) {
             $b_url = \URL::to('/');
           // <a href=".$b_url."/dealers/".Crypt::encrypt($items->id)."/change-password class='btn btn-xs btn-primary'>View</a>

             $contains = Str::contains($items, 'BTH');
             if($contains){
                     return "<button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdataBTHList($items->id)'>Batch Log </button>"; 
                    
                  }else{
                       return "<button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdata($items->id)'>View </button>";
                      }
                
          
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }


    
}