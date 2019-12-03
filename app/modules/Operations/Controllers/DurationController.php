<?php
namespace App\Modules\Operations\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Operations\Models\Operations;
use App\Modules\Operations\Models\VehicleModels;
use App\Modules\Operations\Models\VehicleMake;
use App\Modules\User\Models\User;
use App\Modules\Gps\Models\Gps;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use DB;

class DurationController extends Controller {

    public function vehicleDuration()
    {
        $gps = Gps::all();
        return view('Operations::duration-view',['gps' => $gps]);
    }

    public function vehicleDurationList(Request $request)
    {
        $gps_id = $request->gps_id;
        $items = DB::table('vehicle_daily_updates')->where('gps_id',$gps_id)->get();
        $durations=[];
        foreach ($items as $value) {
            $ignition_on_duration_seconds=$value->ignition_on;
            $ignition_off_duration_seconds=$value->ignition_off;
            $moving_duration_seconds=$value->moving;
            $halt_duration_seconds=$value->halt;
            $sleep_duration_seconds=$value->sleep;
            $stop_duration_seconds=$value->stop ;
            $ac_on_duration_seconds=$value->ac_on ;
            $ac_off_duration_seconds=$value->ac_off;
            $ac_on_halt_duration_seconds=$value->ac_on_idle;

            //convert to H:i:s format
            $ignition_on_duration=$this->timeFormate($ignition_on_duration_seconds);
            $ignition_off_duration=$this->timeFormate($ignition_off_duration_seconds);
            $moving_duration=$this->timeFormate($moving_duration_seconds);
            $halt_duration=$this->timeFormate($halt_duration_seconds);
            $sleep_duration=$this->timeFormate($sleep_duration_seconds);
            $stop_duration=$this->timeFormate($stop_duration_seconds);
            $ac_on_duration=$this->timeFormate($ac_on_duration_seconds);
            $ac_off_duration=$this->timeFormate($ac_off_duration_seconds);
            $ac_on_halt_duration=$this->timeFormate($ac_on_halt_duration_seconds);

            $durations[]=array(
                        'km' =>$value->km,
                        'ignition_on_duration' =>$ignition_on_duration,
                        'ignition_off_duration' =>$ignition_off_duration,
                        'moving_duration' =>$moving_duration,
                        'halt_duration' =>$halt_duration,
                        'sleep_duration' =>$sleep_duration,
                        'stop_duration' =>$stop_duration,
                        'ac_on_duration' =>$ac_on_duration,
                        'ac_off_duration' =>$ac_off_duration,
                        'ac_on_halt_duration' =>$ac_on_halt_duration,
                        'date' =>$value->date,
                        );
        }
        return response()->json($durations); 
    }

    public function timeFormate($second)
    {
      $hours = floor($second / 3600);
      $mins = floor($second / 60 % 60);
      $secs = floor($second % 60);
      $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
      return $timeFormat;
    }


}
