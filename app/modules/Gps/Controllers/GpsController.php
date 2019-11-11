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
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Gps\Models\GpsModeChange;

use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;
use DB;
use Config;

class GpsController extends Controller {

    public $cart;
    //Display gps in stock
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
        ->orderBy('id','desc')
        ->withTrashed()
        ->with('gps:id,imei,serial_no,manufacturing_date,e_sim_number,batch_number,employee_code,model_name,version,deleted_at')
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
                <button onclick=delGps(".$gps_stocks->gps_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                </button>";
            }else{
                 return "
                <button onclick=activateGps(".$gps_stocks->gps_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Restore
                </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    //Display all gps list
    public function allgpsList()
    {
        return view('Gps::all-gps-list');
    }
    //returns gps as json 
    public function getAllgpsList()
    {
        $gps = Gps::select(
            'id',
            'serial_no',
            'imei',
            'imsi',
            'icc_id',
            'batch_number',
            'employee_code',
            'manufacturing_date',
            'e_sim_number',
            'model_name',
            'version',
            'deleted_at'
        )
        ->withTrashed()
        ->get();
        return DataTables::of($gps)
        ->addIndexColumn()
        ->addColumn('action', function ($gps) {
            $b_url = \URL::to('/');
            if($gps->deleted_at == null){
                return "
                <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                ";
            }else{
                 return "";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    //for gps creation
    public function create()
    {
        $gps = Gps::select('id', 'imei','serial_no','manufacturing_date')
        ->whereNull('manufacturing_date')
        ->get();
        return view('Gps::gps-create',['devices'=>$gps]);
    }

    //get address and mobile details based on dealer selection
    public function getGpsDetailsFromRoot(Request $request)
    {

        $gps_id=$request->gps_id;       
        $gps_details=Gps::select('id','serial_no','icc_id','imsi','imei','manufacturing_date','e_sim_number','batch_number','model_name','version','status','device_time','employee_code')
        // ->with('employee:id,code')
        ->where('id',$gps_id)
        ->first();
        
        $imei=$gps_details->imei;
        $model_name=$gps_details->model_name;
        $version=$gps_details->version;
        $icc_id=$gps_details->icc_id;
        $imsi=$gps_details->imsi;
        $batch_number=$gps_details->batch_number;
        $employee_code=$gps_details->employee_code;
        // $brand=$gps_details->version;        
        return response()->json(array(
            'response' => 'success',
            'imei' => $imei,
            'model_name' => $model_name,
            'icc_id' => $icc_id,
            'imsi' => $imsi,
            'batch_number' => $batch_number,
            'employee_code' => $employee_code,
            // 'brand' => $brand,
            'version' => $version
        )); 
    }
    //upload gps details to database table
    public function save(Request $request)
    {
        $root_id=\Auth::user()->id;
        $maufacture= date("Y-m-d", strtotime($request->manufacturing_date));
        // $gps = Gps::find($request->serial_no); 
        // // dd($gps);
        // if($gps == null){
        //    return view('Gps::404');
        // }
        $rules = $this->gpsCreateRules();
        $this->validate($request, $rules);  

        // $gps->manufacturing_date = $maufacture;
        // $gps->e_sim_number = $request->e_sim_number;       
        // $gps->save();

        $gps = Gps::create([
            'serial_no'=>$request->serial_no,
            'icc_id'=>$request->icc_id,
            'imsi'=>$request->imsi,
            'imei'=>$request->imei,
            'manufacturing_date'=>$maufacture,
            'e_sim_number'=>$request->e_sim_number,
            'batch_number'=>$request->batch_number,
            'model_name'=>$request->model_name,
            'version'=>$request->version,
            'employee_code'=>$request->employee_code,
            'status'=>1
            ]); 
        
        if($gps){
           $gps_stock = GpsStock::create([
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

        $gps->serial_no = $request->serial_no;
        $gps->imei = $request->imei;
        $gps->icc_id = $request->icc_id;
        $gps->imsi = $request->imsi;
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
        return redirect(route('gps.details',$encrypted_gps_id));  
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
            ->addColumn('action', function ($gps) {
            $b_url = \URL::to('/');
            if($gps->deleted_at == null){
                return "<a href=".$b_url."/gps/".Crypt::encrypt($gps->gps_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            }
        })
        ->rawColumns(['link', 'action'])
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
                            <a href=".$b_url."/gps/".Crypt::encrypt($gps_stock->gps_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
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
     ////////////////////Root location///////////////////
     /////////////////////////////Vehicle Tracker/////////////////////////////
    public function rootlocation(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);
        // $get_vehicle=Vehicle::find($decrypted_id);
        $vehicle_type=VehicleType::find(1);  
        $track_data=Gps::select('lat as latitude',
                              'lon as longitude'
                              )         
                              ->where('id',$decrypted_id)
                              ->first();   
        if($track_data==null)
        {
            return view('Gps::location-error');
        }
        else if($track_data->latitude==null || $track_data->longitude==null)
        {
            return view('Gps::location-error');
        }
        else
        {
            $latitude=$track_data->latitude;
            $longitude= $track_data->longitude;
        }
        return view('Gps::gps-tracker',['gps_id' => $decrypted_id,'vehicle_type' => $vehicle_type,'latitude' => $latitude,'longitude' => $longitude] );
    }
    public function rootlocationTrack(Request $request)
    {
        $currentDateTime=Date('Y-m-d H:i:s');
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time')."")); 
        $connection_lost_time = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time').""));
        $offline="Offline";
        $signal_strength="Connection Lost";
        $track_data=GpsData::select('latitude as latitude',
                      'longitude as longitude',
                      'heading as angle',
                      'vehicle_mode as vehicleStatus',
                      'imei',
                      'speed',
                      'battery_percentage',
                      'device_time as dateTime',
                      'main_power_status as power',
                      'ignition as ign',
                      'gps_id',
                      'gsm_signal_strength as signalStrength'
                      )
                    ->where('device_time', '>=',$oneMinut_currentDateTime)
                    ->where('gps_id',$request->id)
                    ->latest('device_time')
                    ->first();
        $minutes=0;
        if($track_data == null){
            $track_data = GpsData::select('latitude as latitude',
                              'longitude as longitude',
                              'heading as angle',
                              'speed',
                              'imei',
                              'battery_percentage',
                              'device_time as dateTime',
                              'main_power_status as power',
                              'ignition as ign',
                              'gsm_signal_strength as signalStrength',
                              'gps_id',
                              \DB::raw("'$signal_strength' as signalStrength"),
                              \DB::raw("'$offline' as vehicleStatus")
                              )
                              ->where('gps_id',$request->id)
                              ->latest('device_time')
                              ->first();
            $minutes   = Carbon::createFromTimeStamp(strtotime($track_data->dateTime))->diffForHumans();
        }

        if($track_data){
            $plcaeName=$this->getPlacenameFromLatLng($track_data->latitude,$track_data->longitude);
            $snapRoute=$this->LiveSnapRoot($track_data->latitude,$track_data->longitude);
            if(floatval($track_data->angle) <= 0)
            {
                $h_track_data = GpsData::
                   select('heading','gps_id','device_time')
                        ->where('gps_id',$track_data->gps_id)
                        ->where('heading','!=','00.000')
                        ->whereNotNull('heading')
                        ->latest('device_time')
                        ->first();
              
                $angle=$h_track_data->heading; 
            }
            else
            {
                $angle=$track_data->angle;
            }
            $reponseData=array(
                        "latitude"=>$snapRoute['lat'],
                        "longitude"=>$snapRoute['lng'],
                        "angle"=>$track_data->angle,
                        "vehicleStatus"=>$track_data->vehicleStatus,
                        "speed"=>round($track_data->speed),
                        "dateTime"=>$track_data->dateTime,
                        "power"=>$track_data->power,
                        "imei"=>$track_data->imei,
                        "ign"=>$track_data->ign,
                        "battery_status"=>round($track_data->battery_percentage),
                        "signalStrength"=>$track_data->signalStrength,
                        "connection_lost_time"=>$connection_lost_time,
                        "last_seen"=>$minutes,
                        "fuel"=>"",
                        "ac"=>"",
                        "place"=>$plcaeName,
                        "fuelquantity"=>""
                      );

            $response_data = array('status'  => 'success',
                           'message' => 'success',
                           'code'    =>1,
                           'vehicle_type' => 'car',
                           'client_name' => 'vst',
                           'vehicle_reg' => '',
                           'vehicle_name' => 'gps',
                           'liveData' => $reponseData
                            );
        }else{
            $response_data = array('status'  => 'failed',
                           'message' => 'failed',
                            'code'    =>0);
        }
        return response()->json($response_data); 
    }
    // --------------------------------------------------------------------------------
    function getPlacenameFromLatLng($latitude,$longitude){
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo'); 
            $output = json_decode($geocodeFromLatLong);
             
         
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude

            if(!empty($address)){
                return $address;
            }else{
                return false;
            }
        }else{
            return false;   
        }
    }


    // --------------playback page-------------------------------------
    public function playbackPage(){ 
       return view('Gps::gps-playback-window'); 

    }
     public function playbackPageData(Request $request){ 
      $gps_id=$request->gps_id;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
      $vehicle=Gps::find($gps_id);
      if($vehicle==null){
             $data = array('status' => 'failed',
                           'message' => 'GPS doesnot exist',
                           'code'=>0);
        return response()->json($data);
       }

        $gpsData=GpsData::select('latitude','longitude')
        ->where('gps_id',$gps_id)
        ->whereNotNull('latitude')
        ->whereNotNull('longitude');
        if($start_date)
        {
            $gpsData = $gpsData->where('device_time', '>=', $start_date)
            ->where('device_time', '<=', $end_date);
        }
        $gpsData = $gpsData->orderBy('device_time','asc')
        ->get();
        if($gpsData){
        $response_data = array('status'  => 'success',
                                'message' => 'success',
                                'locations'=>$gpsData,
                                'code'    =>1
                                );
          }else{
          $response_data = array('status'  => 'failed',
                                'message' => 'failed',
                                'code'    =>0);
          }
        
        return response()->json($response_data); 
    }
    
/////////////// snap root for live data///////////////////////////////////
    function LiveSnapRoot($b_lat, $b_lng) {
        $lat = $b_lat;
        $lng = $b_lng;
        $route = $lat . "," . $lng;
        $url = "https://roads.googleapis.com/v1/snapToRoads?path=" . $route . "&interpolate=true&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo";
        $geocode_stats = file_get_contents($url);
        $output_deals = json_decode($geocode_stats);
        if (isset($output_deals->snappedPoints)) {
            $outPut_snap = $output_deals->snappedPoints;
            // var_dump($output_deals);
            if ($outPut_snap) {
                foreach ($outPut_snap as $ldata) {
                    $lat = $ldata->location->latitude;
                    $lng = $ldata->location->longitude;
                }
            }
        }
        $userData = ["lat" => $lat, "lng" => $lng];
        return $userData;

    }
    
    public function travelSummery(){
        $gps = Gps::all();
        $summery=array();
        $total_data=array('sleep' =>0,  
                          'motion' =>0,   
                          'halt' =>0
                        ); 
        return view('Gps::travel-summery',['gps' => $gps,'summery'=>$summery,'full_summery'=>$total_data]);
    }

    public function travelSummeryData(Request $request){
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $gps_id=$request->gps_id;

        $gps = Gps::all();

        $sleep=0;
        $halt=0;
        $motion=0;
        $time=0;
        $initial_time=0;
        $previous_time=0;
        $previous_mode=0;
        $vehicle_sleep=0;
        $previous_id=0;

        $summery=array(); 
        $gps_mode_change=GpsModeChange::
                                    where('device_time','>=',$from_date)
                                  ->where('device_time','<=',$to_date)
                                  ->where('gps_id',$gps_id)
                                  ->orderBy('device_time','asc')
                                  ->get();

                     
        foreach ($gps_mode_change as $changes) 
         {
         if($initial_time == 0){


            $initial_time = $changes->device_time;

            $previous_time = $changes->device_time;
            $previous_mode = $changes->mode;
            $previous_id=$changes->id;
          }else{

           
            if($changes->mode == "S"){
               $time = strtotime($changes->device_time) - strtotime($previous_time);
                $sleep= $sleep+$time; 
                 if($sleep<0)
                {
                    $sleep="0";                   
                }                
          }else if($changes->mode == "M"){
               $time = strtotime($changes->device_time) - strtotime($previous_time);
               $motion= $motion+$time;  
                if($motion<0)
               {
                $motion="0";
                
               }  
                              
            }
            else if($changes->mode == "H"){
               $time = strtotime($changes->device_time) - strtotime($previous_time);
               $halt= $halt+$time;   
               // dd($halt) ;
               if($halt<0)
               {
                $halt="0";               
               }  
                                    
            }
              $date1 = strtotime($previous_time);  
              $date2 = strtotime($changes->device_time);
              $diff = abs($date2 - $date1); 
              $seconds = $this->timeFormate(floor($diff)); 
      
              $summery[]=array(
                                'id'=>$previous_id,
                                'mode'=>$previous_mode,
                                'device_time'=>$previous_time,
                                'first'=>$previous_time,
                                'second'=>$changes->device_time,
                                'timedifference'=>$seconds
                              ); 

          } 
        $previous_time = $changes->device_time;
        $previous_mode=$changes->mode;
                                    
      }    

       $total_data=array('sleep' => $this->timeFormate($sleep),  
                          'motion' => $this->timeFormate($motion),   
                          'halt' => $this->timeFormate($halt)
                        ); 


        return view('Gps::travel-summery',['gps' => $gps,'summery'=>$summery,'full_summery'=>$total_data]);
    }
    // time
    function timeFormate($second){
      $hours = floor($second / 3600);
      $mins = floor($second / 60 % 60);
      $secs = floor($second % 60);
      $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
      return $timeFormat;
    }



     public function allgpsDataListPage()
    {
        $ota = OtaType::all();
        $gps = Gps::all();
        $items = GpsData::orderBy('device_time', 'DESC')->limit(20)->get(); 
        $last_data = GpsData::orderBy('device_time', 'DESC')->first();
        // dd($gps_data);
        return view('Gps::allgpsdata-list',['gps' => $gps,'ota' => $ota,'items'=>$items,'last_data'=>$last_data]);
    }
    public function getAllGpsData(Request $request)
    {
    
        if($request->gps!=0){
        $items = GpsData::where('gps_id',$request->gps)->orderBy('device_time', 'DESC')->limit(20)->get();  
         $last_data = GpsData::where('gps_id',$request->gps)->orderBy('device_time', 'DESC')->first();
        }else{
         $items = GpsData::orderBy('device_time', 'DESC')->limit(20)->get();  
          $last_data = GpsData::orderBy('device_time', 'DESC')->first();
        }    
// dd($items);
        return response()->json([
                'last_data' => $last_data,
                'items' => $items,               
                'status' => 'gpsdatavalue'
            ]);
    }



















    //validation for gps creation
    public function gpsCreateRules(){
        $rules = [
            'serial_no' => 'required|unique:gps',           
            'manufacturing_date' => 'required',           
            'e_sim_number' => 'required|string|unique:gps|min:11|max:11',
            'icc_id' => 'required|string|unique:gps',
            'imsi' => 'required|string|unique:gps',
            'imei' => 'required|string|unique:gps|min:15|max:15',
            'batch_number' => 'required',
            'model_name' => 'required',
            'version' => 'required',
            'employee_code' => 'required',          
        ];
        return  $rules;
    }

    //validation for gps updation
    public function gpsUpdateRules($gps){
        $rules = [
            'serial_no' => 'required|unique:gps,serial_no,'.$gps->id,
            'imei' => 'required|string|min:15|max:15|unique:gps,imei,'.$gps->id,
            'manufacturing_date' => 'required',
            'icc_id' => 'required',
            'imsi' => 'required',
            'e_sim_number' => 'required|string|min:11|max:11|unique:gps,e_sim_number,'.$gps->id,
            'batch_number' => 'required',
            'employee_code' => 'required',
            'model_name' => 'required',
            'version' => 'required',
        ];
        return  $rules;
    } 



}