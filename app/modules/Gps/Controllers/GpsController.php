<?php 


namespace App\Modules\Gps\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Gps\Models\GpsLocation;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsLog;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Gps\Models\VltData;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;

class GpsController extends Controller {

    public $cart;
    //Display all gps
	public function gpsListPage()
    {
        return view('Gps::gps-list');
	}
	//returns gps as json 
    public function getGps()
    {
        $user_id=\Auth::user()->id;
        $gps_stocks = GpsStock::select(
            'id',
        	'gps_id',
            'dealer_id',
            'deleted_at'
        )
        ->withTrashed()
        ->with('gps:id,imei,manufacturing_date,e_sim_number,batch_number,employee_code,model_name,version,deleted_at')
        ->where('dealer_id',null)
        ->get();
        return DataTables::of($gps_stocks)
        ->addIndexColumn()
        ->addColumn('action', function ($gps_stocks) {
            $b_url = \URL::to('/');
            if($gps_stocks->deleted_at == null){
                return "
                <a href=".$b_url."/gps/".Crypt::encrypt($gps_stocks->gps_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/gps/".Crypt::encrypt($gps_stocks->gps_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=delGps(".$gps_stocks->gps_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Delete
                </button>";
            }else{
                 return "
                <a href=".$b_url."/gps/".Crypt::encrypt($gps_stocks->gps_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/gps/".Crypt::encrypt($gps_stocks->gps_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=activateGps(".$gps_stocks->gps_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Restore
                </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    //for gps creation
    public function create()
    {
        return view('Gps::gps-create');
    }

    //upload gps details to database table
    public function save(Request $request)
    {
        $root_id=\Auth::user()->id;
        $maufacture= date("Y-m-d", strtotime($request->manufacturing_date));
       
        $rules = $this->gpsCreateRules();
        $this->validate($request, $rules);
        $gps = Gps::create([
            'imei'=> $request->imei,
            'manufacturing_date'=> date("Y-m-d", strtotime($request->manufacturing_date)),
            'e_sim_number'=> $request->e_sim_number,
            'batch_number'=> $request->batch_number,
            'employee_code'=> $request->employee_code,
            'model_name'=> $request->model_name,
            'version'=> $request->version,
            // 'user_id' => $root_id,
            'status'=>1
        ]);
        if($gps){
           $gps = GpsStock::create([
                'gps_id'=> $gps->id,
                'inserted_by' => $root_id
            ]); 
        }
        $request->session()->flash('message', 'New gps created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('gps.details',Crypt::encrypt($gps->id)));
    } 

    //view gps details
    public function details(Request $request)
    {

         \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $eid=$request->id;
        $decrypted_id = Crypt::decrypt($request->id);
        $gps = Gps::find($decrypted_id);
        if($gps == null){
           return view('Gps::404');
        }

        return view('Gps::gps-details',['gps' => $gps,'eid' => $eid]);
    } 

    //edit gps details
    public function edit(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $gps = Gps::find($decrypted_id);
        if($gps == null){
           return view('Gps::404');
        }
       return view('Gps::gps-edit',['gps' => $gps]);
    }

    //update gps details to database table
    public function update(Request $request){
        $gps = Gps::find($request->id);
        if($gps == null){
           return view('Gps::404');
        }
        $rules = $this->gpsUpdateRules($gps);
        $this->validate($request, $rules);

        $gps->imei = $request->imei;
        $gps->manufacturing_date = $request->manufacturing_date;
        $gps->e_sim_number = $request->e_sim_number;
        $gps->batch_number = $request->batch_number;
        $gps->employee_code = $request->employee_code;
        $gps->model_name = $request->model_name;
        $gps->version = $request->version;
        $gps->save();

        $encrypted_gps_id = encrypt($gps->id);
        $request->session()->flash('message', ' Gps updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('gps.edit',$encrypted_gps_id));  
    }

    // data of gps
    public function data(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        $gps = Gps::find($decrypted);
        if($gps == null){
           return view('Gps::404');
        }
       return view('Gps::gps-data-list',['gps' => $gps]);
    } 

    //delete gps details
    public function deleteGps(Request $request){
        $gps = Gps::find($request->uid);
        $gps_stock = GpsStock::where('gps_id',$request->uid)->first();
        if($gps == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Gps does not exist'
            ]);
        }
        $gps->delete();
        $gps_delete=$gps_stock->delete();
        if($gps_delete){
            $gps_stock->deleted_by = \Auth::user()->id;
            $gps_stock->save();
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps deactivated successfully'
        ]);
    }

    // restore gps 
    public function activateGps(Request $request)
    {
        $gps = Gps::withTrashed()->find($request->id);
        $gps_stock = GpsStock::withTrashed()->where('gps_id',$request->id)->first();
        if($gps==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Gps does not exist'
             ]);
        }

        $gps->restore();
        $gps_restore=$gps_stock->restore();
        if($gps_restore){
            $gps_stock->deleted_by = null;
            $gps_stock->save();
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps restored successfully'
        ]);
    }
////////////////////////////////////////////////////////////////////////////

    public function gpsDataCount(Request $request)
    {

        $user = $request->user();
        if($user->hasRole('root')){
            return response()->json([
                'gpscount' => $request->gps_id,  
                'gpsdatacounts' => GpsData::where('gps_id',$request->gps_id)->count(),               
                'status' => 'gpsdatacount'           
            ]);
        }    
    }

    //returns gps as json 
    public function getGpsData(Request $request)
    {
        $gps_id=$request->gps_id;                 
        $gps_data = GpsData::select(
            'client_id',
            'gps_id',
            'vehicle_id',
            'header',
            'vendor_id',
            'firmware_version',
            'imei',
            'update_rate_ignition_on',
            'update_rate_ignition_off',
            'battery_percentage',
            'low_battery_threshold_value',
            'memory_percentage',
            'digital_io_status',
            'analog_io_status',
            'activation_key',
            'latitude',
            'lat_dir',
            'longitude',
            'lon_dir',
            'date',
            'time',
            'speed',
            'alert_id',
            'packet_status',
            'gps_fix',
            'mcc',
            'mnc',
            'lac',
            'cell_id',
            'heading',
            'no_of_satelites',
            'hdop',
            'gsm_signal_strength',
            'ignition',
            'main_power_status',
            'vehicle_mode',
            'altitude',
            'pdop',
            'nw_op_name',
            'nmr',
            'main_input_voltage',
            'internal_battery_voltage',
            'tamper_alert',
            'digital_input_status',
            'digital_output_status',
            'frame_number',
            'checksum',
            'key1',
            'value1',
            'key2',
            'value2',
            'key3',
            'value3',
            'gf_id'
        )
        // ->with('client:id,name')
        ->with('gps:id')
        // ->with('vehicle:id,name')
        ->where('gps_id',$gps_id)
        ->get();
        return DataTables::of($gps_data)
        ->addIndexColumn()           
        ->make();
    }
    //////////////////////////GPS DEALER///////////////////////////////////

    //Display all dealer gps
    public function gpsDealerListPage()
    {
        return view('Gps::gps-dealer-list');
    } 

    //returns gps as json 
    public function getDealerGps()
    {
        $dealer_id=\Auth::user()->dealer->id;
        $gps = GpsStock::select(
                'id',
                'gps_id',
                'dealer_id',
                'subdealer_id',
                'deleted_at')
                ->withTrashed()
                ->where('dealer_id',$dealer_id)
                ->where('subdealer_id',null)
                ->with('gps')
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->make();
    }

    //////////////////////////GPS SUB DEALER///////////////////////////////////

    //Display all dealer gps
    public function gpsSubDealerListPage()
    {
        return view('Gps::gps-sub-dealer-list');
    } 

    //returns gps as json 
    public function getSubDealerGps()
    {
        $sub_dealer_id=\Auth::user()->subdealer->id;
        $gps_stock = GpsStock::select(
                'id',
                'gps_id',
                'dealer_id',
                'subdealer_id',
                'client_id',
                'deleted_at')
                ->withTrashed()
                ->with('gps')
                ->where('subdealer_id',$sub_dealer_id)
                ->get();
        return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('client', function ($gps_stock) {
                if($gps_stock->client_id==null){
                    return "Not Transferred";
                }else{
                    return $gps_stock->client->name;
                }
            })
            ->addColumn('action', function ($gps_stock) {
                $b_url = \URL::to('/');
                if($gps_stock->deleted_at == null){
                    if($gps_stock->gps->status == 1){ 
                        return "
                            <b style='color:#008000';>Active</b>
                            <a href=".$b_url."/gps/".Crypt::encrypt($gps_stock->gps_id)."/status-log class='btn btn-xs btn-info'> Log </a>
                            <button onclick=deactivateGpsStatus(".$gps_stock->gps_id.") class='btn btn-xs btn-danger'></i>Deactivate</button>
                        ";
                        }else{ 
                        return "
                            <b style='color:#FF0000';>Inactive</b>
                            <a href=".$b_url."/gps/".Crypt::encrypt($gps_stock->gps_id)."/status-log class='btn btn-xs btn-info'> Log </a>
                            <button onclick=activateGpsStatus(".$gps_stock->gps_id.") class='btn btn-xs btn-success'> Activate </button>
                        ";
                        }
                }else{
                     return ""; 
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //deactivate gps
    public function gpsStatusDeactivate(Request $request)
    {
        $user_id=\Auth::user()->id;
        $gps = Gps::find($request->id);
        if($gps == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Gps does not exist'
            ]);
        }
        $gps->status=0;
        $gps_status=$gps->save();
        if($gps_status){
            $gps = GpsLog::create([
                'gps_id'=> $gps->id,
                'status'=> 0,
                'user_id'=> $user_id
            ]);
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps deactivated successfully'
        ]);
    }
    // activate gps
    public function gpsStatusActivate(Request $request)
    {
        $user_id=\Auth::user()->id;
        $gps = Gps::find($request->id);
        if($gps==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Gps does not exist'
            ]);
        }
        $gps->status=1;
        $gps_status=$gps->save();
        if($gps_status){
            $gps = GpsLog::create([
                'gps_id'=> $gps->id,
                'status'=> 1,
                'user_id'=> $user_id
            ]);
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps activated successfully'
        ]);
    }

    public function viewStatusLog(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_logs = GpsLog::select(
                'id',
                'gps_id',
                'status',
                'user_id',
                'created_at')
                ->where('gps_id',$decrypted_id)
                ->with('gps:id,imei')
                ->get();
        return view('Gps::gps-status-log-view',['gps_logs' => $gps_logs]);
    }

    //////////////////////////GPS SUB DEALER///////////////////////////////////

    //Display all dealer gps
    public function gpsClientListPage()
    {
        return view('Gps::gps-client-list');
    } 
    //  public function gpsClientListPage()
    // {
    //     return view('Gps::list-client-gps');
    // } 

    //returns gps as json 
    public function getClientGps()
    {
        $client_id=\Auth::user()->id;
        $gps = Gps::select(
                'id',
                'imei',
                'version',
                'brand',
                'model_name',
                'deleted_at')
                ->withTrashed()
                ->where('user_id',$client_id)
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->make();
    }

    // gps user details
    public function userData(Request $request) 
    {
        $gps = Gps::find($request->gpsID);    
        $user = $gps->user;     
        return response()->json(array('response' => 'success', 'gps' => $gps , 'user' => $user));
    }

    public function allGpsDatas(Request $request){
        $items = GpsData::all()->sortByDesc('id');
        return view('Gps::alldata',['items' => $items]);
    }


    public function allgpsListPage()
    {
        $ota = OtaType::all();
        $gps = Gps::all();
        return view('Gps::alldata-list',['gps' => $gps,'ota' => $ota]);
    }
     public function getAllData(Request $request)
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


    public function vltdataListPage()
    {
        // $ota = OtaType::all();
        // $gps = Gps::all();
        return view('Gps::vltdata-list');
    }

     public function getVltData(Request $request)
    {
    
      
         $items = VltData::all();                
        return DataTables::of($items)
        ->addIndexColumn()        
         ->addColumn('forhuman', function ($items) {
                $forhuman=0;
                $forhuman=Carbon::parse($items->created_at)->diffForHumans();;
                return $forhuman;
             })
         ->addColumn('action', function ($items) {
               $b_url = \URL::to('/');
            return "
           <a href=".$b_url."/id/".Crypt::encrypt($items->id)."/pased class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View Details</a>
             ";  
             })
         ->rawColumns(['link', 'action'])
        
        ->make();
    }

    public function testKm(){
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sample.csv"');
        $data = array(
                'aaa,bbb,ccc,dddd',
                '123,456,789',
                '"aaa","bbb"'
        );

        $fp = fopen('php://output', 'wb');
        foreach ( $data as $line ) {
            $val = explode(",", $line);
            fputcsv($fp, $val);
        }
        fclose($fp);
        return $fp;
    }
    public function downloadGpsDataTransfer(Request $request){

        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $eid=$request->id;
        $decrypted_id = Crypt::decrypt($request->id);
        $gps = Gps::find($decrypted_id);
        
        if($gps == null){
           return view('Gps::404');
        }
        $pdf = PDF::loadView('Gps::gps-pdf-download',['gps' => $gps]);
        return $pdf->download('GpsData.pdf');

    }
    public function getGpsAllData(Request $request)
    {      
        $items = GpsData::find($request->id);
        return response()->json([
                'gpsData' => $items        
        ]);
                   
    }

    public function getGpsAllDataBth(Request $request){
      $items = GpsData::find($request->id);
      $items_data=$this->splitByBTH($items);
      $vltdata=$items->vlt_data;
        return response()->json([
                'gpsData' => $items_data        
        ]);  
    }

    public function splitByBTH($items){
        $vltdata=$items->vlt_data;
        $header=substr($vltdata,0,3);
        $imei=substr($vltdata, 3, 15);
        $count=substr($vltdata, 18, 3);
        $packet_removed_head=substr($vltdata,21);
        $alert_id = substr( $packet_removed_head,0,2);
        $status = $this->batchParse($alert_id,$packet_removed_head);

        $final = [];
        $final[] = array("packet"=>$status['packet'][0],"alert"=>$alert_id);

        while(strlen($status['batch']) > 0){        
            $alert_id = substr($status['batch'],0,2);
            $response = $this->batchParse($alert_id,$status['batch']);
            $status = $response;
            $final[] =array("packet"=>$status['packet'][0],"alert"=>$alert_id);
        }
       

        $string_data=$this->createOutputString($final,$vltdata);
        return $string_data;
    }

    public function batchParse($alert_id, $batch){
            $items = [];
            switch ($alert_id) {
            case '18':
                $size=83;
                $parsed = substr($batch,0,$size);
                $items[] = $parsed;
                $balanced_packet=substr($batch,$size);
                $final_packet=array('packet'=>$items,'batch'=>$balanced_packet);
                return $final_packet;
                break;
            case '19':
                $size=83;
                $parsed =substr($batch,0,$size);
                $items[] = $parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
               
                break;
            case '20':
                $size=83;
                $parsed = substr($batch,0,$size);
                $items[] = $parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
                break;
            case '21':
                $size=83;
                $parsed = substr($packet_start,0,$size);
                $items[] = $parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
                break;
            case '22':
                $size=78;
                $parsed = substr($batch,0,$size);
                $items[] = $parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
                break;
            case '25':
                $size=210;
                $parsed = substr($batch,0,$size);
                $items[] = $parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
                break;
            default:
                $size=78;
                $parsed = substr($batch,0,$size);
                $items[] = $parsed;
                $balanced_packet=substr($batch,$size);
                return array('packet'=>$items,'batch'=>$balanced_packet);
                break;

        }
    }






    public function createOutputString($items_data,$vltdata){
       
         $string="<tr><td colspan='3'>".$vltdata."</td></tr>";
         $string.="<tr><th>No</th><th>Alert ID</th><th>Packet</th></tr>";
         $i=1;

        foreach ($items_data as $item) {
           $string.="<tr><td> Packet".$i."</td><td>".$item['alert']."</td><td>".$item['packet']."</td></tr>";
           $i++;
        }
        return $string;
    }



    public function privacyPolicy()
    {
       
        return view('Gps::privacy-policy');
    }

    //for gps creation
    public function subscriptionSuccess()
    {       
        return view('Gps::subscription-success');
    }
    public function allBthData()
    {       
        return view('Gps::all-bth-data-list');
    }
     public function getAllBthData(Request $request)
    {
        $items = GpsData::where('header','BTH');         
        return DataTables::of($items)
            ->addIndexColumn()
            ->addColumn('count', function ($items) {
            $count=0;
            $count=strlen($items->vlt_data);
            return $count;
        })
        ->addColumn('forhuman', function ($items) {
            $forhuman=0;
            $forhuman=Carbon::parse($items->device_time)->diffForHumans();;
            return $forhuman;
        })
        ->addColumn('servertime', function ($items) {
            $servertime=0;
            $servertime=Carbon::parse($items->created_at)->diffForHumans();;
            return $servertime;
        })
        ->addColumn('action', function ($items) {
            $b_url = \URL::to('/');
            return "
            <button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdata($items->id)'>View </button> 
            ";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function pasedData(Request $request)
    {     
        $decrypted_id = Crypt::decrypt($request->id);
        $vltdata = VltData::find($decrypted_id); 
        $vltdata = $vltdata->vltdata;

        $imei=substr($vltdata, 3, 15);
        $count=substr($vltdata, 18, 3);
        $alert_id=substr($vltdata, 21, 2);
        $packet_status=substr($vltdata, 23, 1);
        $gps_fix=substr($vltdata, 24, 1);
        $date = substr($vlt_data,25,6);
        $time = substr($vlt_data,31,6);
        $latitude = substr($vlt_data,37,10);
        $lat_dir = substr($vlt_data,47,1);
        $longitude = substr($vlt_data,48,10);
        $lon_dir = substr($vlt_data,58,1);
        $mcc = substr($vlt_data,59,3);
        $mnc = substr($vlt_data,62,3);
        $lac = substr($vlt_data,65,4);
        $cell_id = substr($vlt_data,69,9);
        $speed = substr($vlt_data,78,6);
        $heading = substr($vlt_data,84,6);
        $no_of_satelites = substr($vlt_data,90,2);
        $hdop = substr($vlt_data,92,2);
        $gsm_signal_strength = substr($vlt_data,94,2);
        $ignition =substr($vlt_data,96,1);
        $main_power_status = substr($vlt_data,97,1);
        $vehicle_mode = substr($vlt_data,98,1);
        $next_alert_id = substr($vlt_data,99,2);
        // if($next_alert_id==[16,03,17,22,23,20,21])
        // {
        //     processCrtData($next_alert_id,$imei,$vlt_data,46);
        // } 
        // else if($next_alert_id==[13,14,15,09,18,19,06,04,05]) 
        // {
        //     processAltData($next_alert_id,$imei,$vlt_data,46);
        // }  
        return view('Gps::vlt-passed-data',['item' => $vltdata]);
    }

    public function processCrtData($next_alert_id, $imei, $vltdata, $pointer)
    {
        $header = "CRT";
        $imei = $imei;
        $alert_id = $next_alert_id;
        $packet_status = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $gps_fix = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $date = substr($vlt_data,$pointer,6);$pointer=$pointer+6;
        $time = substr($vlt_data,$pointer,6);$pointer=$pointer+6;
        $latitude = substr($vlt_data,$pointer,10);$pointer=$pointer+10;
        $lat_dir = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $longitude =substr($vlt_data,$pointer,10);$pointer=$pointer+10;
        $lon_dir = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $mcc = substr($vlt_data,$pointer,3);$pointer=$pointer+3;
        $mnc = substr($vlt_data,$pointer,3);$pointer=$pointer+3;
        $lac = substr($vlt_data,$pointer,4);$pointer=$pointer+4;
        $cell_id = substr($vlt_data,$pointer,9);$pointer=$pointer+9;
        $speed = substr($vlt_data,$pointer,6);$pointer=$pointer+6;
        $heading = substr($vlt_data,$pointer,6);$pointer=$pointer+6;
        $no_of_satelites = substr($vlt_data,$pointer,2);$pointer=$pointer+2;
        $hdop = substr($vlt_data,$pointer,2);$pointer=$pointer+2;
        $gsm_signal_strength = substr($vlt_data,$pointer,2);$pointer=$pointer+2;
        $ignition = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $main_power_status = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $vehicle_mode = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $gf_ide = substr($vlt_data,$pointer,5);$pointer=$pointer+5;
    }
    public function processAltData($next_alert_id, $imei, $vltdata, $pointer)
    {   
        $header = "ALT";
        $imei = $imei;
        $alert_id = $next_alert_id;
        $packet_status = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $gps_fix = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $date = substr($vlt_data,$pointer,6);$pointer=$pointer+6;
        $time = substr($vlt_data,$pointer,6);$pointer=$pointer+6;
        $latitude =substr($vlt_data,$pointer,10);$pointer=$pointer+10;
        $lat_dir = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $longitude = substr($vlt_data,$pointer,10);$pointer=$pointer+10;
        $lon_dir = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $mcc = substr($vlt_data,$pointer,3);$pointer=$pointer+3;
        $mnc = substr($vlt_data,$pointer,3);$pointer=$pointer+3;
        $lac =substr($vlt_data,$pointer,4);$pointer=$pointer+4;
        $cell_id = substr($vlt_data,$pointer,9);$pointer=$pointer+9;
        $speed = substr($vlt_data,$pointer,6);$pointer=$pointer+6;
        $heading = substr($vlt_data,$pointer,6);$pointer=$pointer+6;
        $no_of_satelites =substr($vlt_data,$pointer,2);$pointer=$pointer+2;
        $hdop = substr($vlt_data,$pointer,2);$pointer=$pointer+2;
        $gsm_signal_strength = substr($vlt_data,$pointer,2);$pointer=$pointer+2;
        $ignition = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $main_power_status = substr($vlt_data,$pointer,1);
        $vehicle_mode = substr($vlt_data,$pointer,1);$pointer=$pointer+1;
        $gf_ide = substr($vlt_data,$pointer,5);$pointer=$pointer+5;
     }
    
    //validation for gps creation
    public function gpsCreateRules(){
        $rules = [
            'imei' => 'required|string|unique:gps|min:15|max:15',
            'manufacturing_date' => 'required',
            'e_sim_number' => 'required|string|unique:gps|min:11|max:11',
            'batch_number' => 'required',
            'employee_code' => 'required',
            'model_name' => 'required',
            'version' => 'required'
        ];
        return  $rules;
    }

    //validation for gps updation
    public function gpsUpdateRules($gps){
        $rules = [
            'imei' => 'required|string|min:15|max:15|unique:gps,imei,'.$gps->id,
            'manufacturing_date' => 'required',
            'e_sim_number' => 'required|string|min:11|max:11|unique:gps,e_sim_number,'.$gps->id,
            'batch_number' => 'required',
            'employee_code' => 'required',
            'model_name' => 'required',
            'version' => 'required',
        ];
        return  $rules;
    } 



}