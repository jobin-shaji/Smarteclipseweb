<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Vehicle\Models\Vehicle;
use App\Http\Traits\VehicleDataProcessorTrait;
use App\Modules\Alert\Models\Alert;
use DB;
use Carbon\Carbon;
use App\Modules\Vehicle\Models\KmUpdate;
use DataTables;
class TripReportController extends Controller
{
  use VehicleDataProcessorTrait;

    public function tripReport(Request $request)
    {
        // $id = decrypt($id);
        $id = $request->id;

       $alerts = Alert::where('gps_id', $id)->whereIn('alert_type_id',[19,20])->whereDate('device_time','2020-02-19')->orderBy('device_time')->get();

       $trips = [];

       $i=0;

        foreach ($alerts as $item) {
            if($item->alert_type_id == 19)
            {
                $trips[$i]["on"] = $item->device_time;
                $trips[$i]["on location"] = $item->latitude.','.$item->longitude;
            }
            else if($item->alert_type_id == 20)
            {
                $trips[$i]["off"] = $item->device_time;
                $trips[$i]["off location"] = $item->latitude.','.$item->longitude;
                $i++;
            }     

        }


        for($i=0;$i<count($trips);$i++)
        {
            if( ( !isset($trips[$i]["off"]) ) || ( !isset($trips[$i]["on"]) ) )
            {
                $trips[$i]["km"] = "--";
            }
            else
            {
                $trips[$i]["km"] = KmUpdate::where('gps_id',$id)->where('device_time','>',$trips[$i]["on"] )->where('device_time','<',$trips[$i]["off"] )->sum('km');
            }

            if(!isset($trips[$i]["on"]))
            {
                $trips[$i]["on"] = "--";
                $trips[$i]["on location"] = "--";
            }
            else if(!isset($trips[$i]["off"]))
            {
                $trips[$i]["off"] = "--";
                $trips[$i]["off location"]  = "--";
            }

        }


        return view('Reports::trip-report',compact('trips'));

    }  

}