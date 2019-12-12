<?php 
namespace App\Modules\Gps\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
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

class BatchController extends Controller {

    public function batchListPage()
    {
        return view('Gps::batch-data-list');
    }

    public function getBatchAllData(Request $request)
    {
        $packet=$request->content;
        $header=substr($packet,0,3);
        $imei = substr($packet,3,15);
        $batch_log_count = substr($packet,18,3);
        $balance_packet = substr($packet,21);
        $packets=[];
        do
        {
            $return_array=$this->batchPacketSplitting($imei,$balance_packet);
            $balance_packet=$return_array['balance_packet'];
            $packets[]=$return_array['packet'];
        }
        while (!empty($balance_packet));
        return response()->json($packets);
    }

    public function batchPacketSplitting($imei,$balance_packet)
    {
        $alert_id = substr($balance_packet,0,2);
        if($alert_id == "01") //NRM
        {
            $nrm_alert_id_to_mode = substr($balance_packet,0,78);
            $normal_packet="NRM".$imei.$nrm_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $return_array=[
                    'packet' => $normal_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "10" || $alert_id == "11")//EPB
        {
            $epb_alert_id_to_mode = substr($balance_packet,0,78);
            $emergency_packet="EPB".$imei.$epb_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $return_array=[
                    'packet' => $emergency_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "16" || $alert_id == "03" || $alert_id == "17" || $alert_id == "22" || $alert_id == "23")//CRT
        {
            $crt_alert_id_to_mode = substr($balance_packet,0,78);
            $critical_packet="CRT".$imei.$crt_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $return_array=[
                    'packet' => $critical_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "20" || $alert_id == "21")//CRT
        {
            $crt_alert_id_to_mode = substr($balance_packet,0,83);
            $critical_packet="CRT".$imei.$crt_alert_id_to_mode;
            $balance_packet=substr($balance_packet,83);
            $return_array=[
                    'packet' => $critical_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "13" || $alert_id == "14" || $alert_id == "15" || $alert_id == "06" || $alert_id == "04" || $alert_id == "05" || $alert_id == "09") //ALT
        {
            $alert_alert_id_to_mode = substr($balance_packet,0,78);
            $alert_packet="ALT".$imei.$alert_alert_id_to_mode;
            $balance_packet=substr($balance_packet,78);
            $return_array=[
                    'packet' => $alert_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
        else if($alert_id == "18" || $alert_id == "19") //ALT
        {
            $alert_alert_id_to_mode = substr($balance_packet,0,83);
            $alert_packet="ALT".$imei.$alert_alert_id_to_mode;
            $balance_packet=substr($balance_packet,83);
            $return_array=[
                    'packet' => $alert_packet,
                    'balance_packet' => $balance_packet
                    ];
            return $return_array;
        }
    }

    
}