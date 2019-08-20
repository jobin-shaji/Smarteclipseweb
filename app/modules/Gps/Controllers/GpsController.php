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
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;

class GpsController extends Controller {
    //Display all gps
	public function gpsListPage()
    {
        return view('Gps::gps-list');
	}
	//returns gps as json 
    public function getGps()
    {
        $user_id=\Auth::user()->id;
        $gps = Gps::select(
            'id',
        	'imei',
            \DB::raw("DATE_FORMAT(manufacturing_date, '%d-%m-%Y') as manufacturing_date"),
            'e_sim_number',
            'brand',
            'model_name',
        	'version',
            'deleted_at'
        )
        ->withTrashed()
        ->where('user_id',$user_id)
        ->get();
        return DataTables::of($gps)
        ->addIndexColumn()
        ->addColumn('action', function ($gps) {
            $b_url = \URL::to('/');
            if($gps->deleted_at == null){
                // <a href=/gps/".Crypt::encrypt($gps->id)."/data class='btn btn-xs btn-info'><i class='glyphicon glyphicon-folder-open'></i> Data </a>
                return "
                <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=delGps(".$gps->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Delete
                </button>";
            }else{
                 return "
                <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=activateGps(".$gps->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Restore
                </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    //Display all transferred gps
    public function gpsTransferredListPage()
    {
        return view('Gps::gps-transferred-list');
    }

    //returns gps as json 
    public function getTransferredGps()
    {
        $user_id[]=\Auth::user()->id;
        $gps = Gps::select(
                'id',
                'imei',
                'manufacturing_date',
                'version',
                'e_sim_number',
                'brand',
                'model_name',
                'user_id',
                'deleted_at'
            )
                ->withTrashed()
                ->with('user:id,username')
                ->whereNotIn('user_id',$user_id)
                ->orWhere('user_id',null)
                ->get();
                
        return DataTables::of($gps)
            ->addIndexColumn()
            ->addColumn('user', function ($gps) {
                if($gps->user_id == null){
                    return "Transfer in progress";
                }else{
                    return $gps->user->username;
                }
            })
            ->addColumn('action', function ($gps) {
                $b_url = \URL::to('/');
                if($gps->deleted_at == null){
                    return "
                    <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/data class='btn btn-xs btn-info'><i class='glyphicon glyphicon-folder-open'></i> Data </a>
                    <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=delGps(".$gps->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                    </button>";
                }else{
                     return "
                    <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateGps(".$gps->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate
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
            'brand'=> $request->brand,
            'model_name'=> $request->model_name,
            'version'=> $request->version,
            'user_id' => $root_id,
            'status'=>1
        ]);
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
        $gps->brand = $request->brand;
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
        if($gps == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Gps does not exist'
            ]);
        }
        $gps->delete();
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
        if($gps==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Gps does not exist'
             ]);
        }

        $gps->restore();

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
    /////////////////////////New Arrivals-start//////////////////////////////////

    //Display new arrived dealer gps
    public function newGpsListPage()
    {
        return view('Gps::gps-new-arrival-list');
    } 

    //returns new arrived gps as json 
    public function getNewGps()
    {
        $user_id=\Auth::user()->id;
        $devices=GpsTransfer::select(
            'id',
            'from_user_id',
            'dispatched_on',
            'accepted_on'
        )
        ->with('fromUser:id,username')
        ->where('to_user_id',$user_id)
        ->with('gpsTransferItems')
        ->orderBy('id','DESC')
        ->get();
        return DataTables::of($devices)
            ->addIndexColumn()
            ->addColumn('count',function($gps_transfer){
                return $gps_transfer->gpsTransferItems->count();
             })
            ->addColumn('action', function ($devices) {
                $b_url = \URL::to('/');
                if($devices->accepted_on == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-info' data-toggle='tooltip' title='View  GPS'><i class='fas fa-eye'> View</i></a>
                    <button onclick=acceptGpsTransfer(".$devices->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Accept
                    </button>";
                }else{
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-success'  data-toggle='tooltip' title='View  GPS'><i class='fas fa-eye'></i> View </a>
                    <b style='color:#008000';>Accepted</b>";
                }
                
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //////////////////////////New Arrivals-end////////////////////////////////


    //////////////////////////GPS DEALER///////////////////////////////////

    //Display all dealer gps
    public function gpsDealerListPage()
    {
        return view('Gps::gps-dealer-list');
    } 

    //returns gps as json 
    public function getDealerGps()
    {
        $dealer_user_id=[];
        $dealer_user_id[]=\Auth::user()->id;
        $dealer_id=\Auth::user()->dealer->id;
        $sub_dealers = SubDealer::select(
                'id','user_id'
                )
                ->where('dealer_id',$dealer_id)
                ->get();
        $single_sub_dealers = [];
        $single_sub_dealers_user_id = [];
        foreach($sub_dealers as $sub_dealer){
            $single_sub_dealers[] = $sub_dealer->id;
            $single_sub_dealers_user_id[] = $sub_dealer->user_id;
        }
        $clients = Client::select(
                'id','user_id'
                )
                ->whereIn('sub_dealer_id',$single_sub_dealers)
                ->get();
        $single_clients_user_id = [];
        foreach($clients as $client){
            $single_clients_user_id[] = $client->user_id;
        }
        $dealer_subdealer_clients_group = array_merge($single_sub_dealers_user_id,$single_clients_user_id,$dealer_user_id);
        $gps = Gps::select(
                'id',
                'imei',
                'version',
                'brand',
                'model_name',
                'user_id',
                'deleted_at')
                ->withTrashed()
                ->whereIn('user_id',$dealer_subdealer_clients_group)
                ->with('user:id,username')
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
        $sub_dealer_user_id=[];
        $sub_dealer_user_id[]=\Auth::user()->id;
        $sub_dealer_id=\Auth::user()->subdealer->id;
        $clients = Client::select(
                'user_id'
                )
                ->where('sub_dealer_id',$sub_dealer_id)
                ->get();
        $single_clients_user_id = [];
        foreach($clients as $client){
            $single_clients_user_id[] = $client->user_id;
        }
        $subdealer_clients_group = array_merge($single_clients_user_id,$sub_dealer_user_id);
        $gps = Gps::select(
                'id',
                'imei',
                'version',
                'brand',
                'model_name',
                'user_id',
                'status',
                'deleted_at')
                ->withTrashed()
                ->whereIn('user_id',$subdealer_clients_group)
                ->with('user:id,username')
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->addColumn('action', function ($gps) {
                $b_url = \URL::to('/');
                if($gps->deleted_at == null){
                    if($gps->status == 1){ 
                        return "
                            <b style='color:#008000';>Active</b>
                            <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/status-log class='btn btn-xs btn-info'> Log </a>
                            <button onclick=deactivateGpsStatus(".$gps->id.") class='btn btn-xs btn-danger'></i>Deactivate</button>
                        ";
                        }else{ 
                        return "
                            <b style='color:#FF0000';>Inactive</b>
                            <a href=".$b_url."/gps/".Crypt::encrypt($gps->id)."/status-log class='btn btn-xs btn-info'> Log </a>
                            <button onclick=activateGpsStatus(".$gps->id.") class='btn btn-xs btn-success'> Activate </button>
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

    ///////////////////////////Gps Transfer////////////////////////////////

    // gps transfer list
    public function getList() 
    {
        return view('Gps::gps-transfer-list');
    }

    //gps transfer list data
    public function getListData() 
    {
        $user_id=\Auth::user()->id;
        $gps_transfer = GpsTransfer::select(
            'id', 
            'from_user_id', 
            'to_user_id',
            'dispatched_on',
            'accepted_on',
            'deleted_at'
            // \DB::raw('count(id) as count') 
        )
        ->with('fromUser:id,username')
        ->with('toUser:id,username')
        ->with('gpsTransferItems')
        ->where('from_user_id',$user_id)
        ->orderBy('id','DESC')
        ->withTrashed()
        ->get();
        return DataTables::of($gps_transfer)
        ->addIndexColumn()
        ->addColumn('count', function ($gps_transfer) 
        {
            return $gps_transfer->gpsTransferItems->count();
        })
        ->addColumn('action', function ($gps_transfer) 
        {
            $b_url = \URL::to('/');
            if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
            {
                return "
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=cancelGpsTransfer(".$gps_transfer->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
                </button>";
            }
            else if($gps_transfer->deleted_at != null){
                return "
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#FF0000';>Cancelled</b>";
            }
            else{
                return "
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#008000';>Transferred</b>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create root gps transfer
    public function createRootGpsTransfer(Request $request) 
    {
        $user = \Auth::user();
        $root = $user->root;
        $devices = Gps::select('id', 'imei','user_id')
                        ->where('user_id',$user->id)
                        ->get();
        $entities = $root->dealers;

        return view('Gps::root-gps-transfer', ['devices' => $devices,'entities' => $entities]);
    }

    //get scanned gps and check gps status
    public function getScannedGps(Request $request)
    {
        $device_imei=$request->imei;
        $user = \Auth::user();
        $device = Gps::select('id', 'imei','user_id')
                        ->where('user_id',$user->id)
                        ->where('imei',$device_imei)
                        ->first();
        if($device==null){
            return response()->json(array(
                'status' => 0,
                'title' => 'Error',
            ));
        }else{
            $gps_id=$device->id;
            $gps_imei=$device->imei;
            return response()->json(array(
                'status' => 1,
                'title' => 'success',
                'gps_id' => $gps_id,
                'gps_imei' => $gps_imei
            ));
        } 
    }

    //get address and mobile details based on dealer selection
    public function getDealerDetailsFromRoot(Request $request)
    {
        $dealer_user_id=$request->dealer_user_id;
        $dealer_user_detalis=User::find($dealer_user_id);
        $dealer_details = Dealer::select('id', 'name', 'address','user_id')
                        ->where('user_id',$dealer_user_id)
                        ->first();
        $dealer_name=$dealer_details->name;
        $dealer_address=$dealer_details->address;
        $dealer_mobile=$dealer_user_detalis->mobile;
        return response()->json(array(
              'response' => 'success',
              'dealer_name' => $dealer_name,
              'dealer_address' => $dealer_address,
              'dealer_mobile' => $dealer_mobile
        )); 
    }

    // proceed gps transfer for confirmation
    public function proceedRootGpsTransfer(Request $request) 
    {
        
        if($request->gps_id[0]==null){
            $rules = $this->gpsRootTransferRule();
        }else{
            $rules = $this->gpsRootTransferNullRule();
        }
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one qr code']);
        $dealer_user_id=$request->dealer_user_id;
        $dealer_name=$request->dealer_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $gps_array_list = $request->gps_id;
        $gps_array=explode(",",$gps_array_list[0]);
        $gps_list=[];
        foreach ($gps_array as $gps_id) {
            $gps_list[]=$gps_id;
        }
        $devices = Gps::select('id', 'imei')
                        ->whereIn('id',$gps_list)
                        ->get();
        return view('Gps::root-gps-transfer_proceed', ['dealer_user_id' => $dealer_user_id,'dealer_name' => $dealer_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);
    }

    // save root gps transfer/transfer gps from root to dealer
    public function proceedConfirmRootGpsTransfer(Request $request) 
    {
        $from_user_id = \Auth::user()->id;
        $gps_array = $request->gps_id;
        $to_user_id = $request->dealer_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $uniqid=uniqid();
        $order_number=$uniqid.date("Y-m-d h:i:s");
        if($gps_array){
            $gps_transfer = GpsTransfer::create([
              "from_user_id" => $from_user_id, 
              "to_user_id" => $to_user_id,
              "order_number" => $order_number,
              "scanned_employee_code" => $scanned_employee_code,
              "invoice_number" => $invoice_number,
              "dispatched_on" => date('Y-m-d H:i:s')
            ]);
            $last_id_in_gps_transfer=$gps_transfer->id;
        }
        if($last_id_in_gps_transfer){
            foreach ($gps_array as $gps_id) {
                $gps_transfer_item = GpsTransferItems::create([
                  "gps_id" => $gps_id, 
                  "gps_transfer_id" => $last_id_in_gps_transfer
                ]);
                if($gps_transfer_item){
                    //update gps table
                    $gps = Gps::find($gps_id);
                    $gps->user_id =null;
                    $gps->save();
                }
            }
        }
        $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
        $request->session()->flash('message', 'Gps Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('gps-transfer.label',$encrypted_gps_transfer_id));
    }

    // create dealer gps transfer
    public function createDealerGpsTransfer(Request $request) 
    {
        $user = \Auth::user();
        $dealer = $user->dealer;
        $devices = Gps::select('id', 'imei','user_id')
                        ->where('user_id',$user->id)
                        ->get();
        $entities = $dealer->subDealers()->with('user')->get();

        $entities = $entities->where('user.deleted_at',null);

        return view('Gps::dealer-gps-transfer', ['devices' => $devices, 'entities' => $entities]);
    }

    //get address and mobile details based on subdealer selection
    public function getSubDealerDetailsFromDealer(Request $request)
    {
        $sub_dealer_user_id=$request->sub_dealer_user_id;
        $sub_dealer_user_detalis=User::find($sub_dealer_user_id);
        $sub_dealer_details = SubDealer::select('id', 'name', 'address','user_id')
                        ->where('user_id',$sub_dealer_user_id)
                        ->first();
        $sub_dealer_name=$sub_dealer_details->name;
        $sub_dealer_address=$sub_dealer_details->address;
        $sub_dealer_mobile=$sub_dealer_user_detalis->mobile;
        return response()->json(array(
              'response' => 'success',
              'sub_dealer_name' => $sub_dealer_name,
              'sub_dealer_address' => $sub_dealer_address,
              'sub_dealer_mobile' => $sub_dealer_mobile
        )); 
    }

    // proceed gps transfer for confirmation
    public function proceedDealerGpsTransfer(Request $request) 
    {
        if($request->gps_id[0]==null){
            $rules = $this->gpsDealerTransferRule();
        }else{
            $rules = $this->gpsDealerTransferNullRule();
        }
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one qr code']);
        $sub_dealer_user_id=$request->sub_dealer_user_id;
        $sub_dealer_name=$request->sub_dealer_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $gps_array_list = $request->gps_id;
        $gps_array=explode(",",$gps_array_list[0]);
        $gps_list=[];
        foreach ($gps_array as $gps_id) {
            $gps_list[]=$gps_id;
        }
        $devices = Gps::select('id', 'imei')
                        ->whereIn('id',$gps_list)
                        ->get();
        return view('Gps::dealer-gps-transfer_proceed', ['sub_dealer_user_id' => $sub_dealer_user_id,'sub_dealer_name' => $sub_dealer_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);
    }

    // save dealer gps transfer/transfer gps from dealer to sub dealer
    public function proceedConfirmDealerGpsTransfer(Request $request) 
    {
        $from_user_id = \Auth::user()->id;
        $gps_array = $request->gps_id;
        $to_user_id = $request->sub_dealer_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $uniqid=uniqid();
        $order_number=$uniqid.date("Y-m-d h:i:s");
        if($gps_array){
            $gps_transfer = GpsTransfer::create([
              "from_user_id" => $from_user_id, 
              "to_user_id" => $to_user_id,
              "order_number" => $order_number,
              "scanned_employee_code" => $scanned_employee_code,
              "invoice_number" => $invoice_number,
              "dispatched_on" => date('Y-m-d H:i:s')
            ]);
            $last_id_in_gps_transfer=$gps_transfer->id;
        }
        if($last_id_in_gps_transfer){
            foreach ($gps_array as $gps_id) {
                $gps_transfer_item = GpsTransferItems::create([
                  "gps_id" => $gps_id, 
                  "gps_transfer_id" => $last_id_in_gps_transfer
                ]);
                if($gps_transfer_item){
                    //update gps table
                    $gps = Gps::find($gps_id);
                    $gps->user_id =null;
                    $gps->save();
                }
            }
        }
        $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
        $request->session()->flash('message', 'Gps Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('gps-transfer.label',$encrypted_gps_transfer_id));
    }

    // create sub dealer gps transfer
    public function createSubDealerGpsTransfer(Request $request) 
    {
        $user = \Auth::user();
        $sub_dealer=$user->subdealer;
        $devices = Gps::select('id', 'imei','user_id')
                        ->where('user_id',$user->id)
                        ->get();
        $entities = $sub_dealer->clients()->with('user')->get();

        $entities = $entities->where('user.deleted_at',null);

        return view('Gps::sub-dealer-gps-transfer', ['devices' => $devices, 'entities' => $entities]);
    }

    //get address and mobile details based on client selection
    public function getClientDetailsFromSubDealer(Request $request)
    {
        $client_user_id=$request->client_user_id;
        $client_user_detalis=User::find($client_user_id);
        $client_details = Client::select('id', 'name', 'address','user_id')
                        ->where('user_id',$client_user_id)
                        ->first();
        $client_name=$client_details->name;
        $client_address=$client_details->address;
        $client_mobile=$client_user_detalis->mobile;
        return response()->json(array(
              'response' => 'success',
              'client_name' => $client_name,
              'client_address' => $client_address,
              'client_mobile' => $client_mobile
        )); 
    }

    // proceed gps transfer for confirmation
    public function proceedSubDealerGpsTransfer(Request $request) 
    {
        if($request->gps_id[0]==null){
            $rules = $this->gpsSubDealerTransferRule();
        }else{
            $rules = $this->gpsSubDealerTransferNullRule();
        }
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one qr code']);
        $client_user_id=$request->client_user_id;
        $client_name=$request->client_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $gps_array_list = $request->gps_id;
        $gps_array=explode(",",$gps_array_list[0]);
        $gps_list=[];
        foreach ($gps_array as $gps_id) {
            $gps_list[]=$gps_id;
        }
        $devices = Gps::select('id', 'imei')
                        ->whereIn('id',$gps_list)
                        ->get();
        return view('Gps::sub-dealer-gps-transfer_proceed', ['client_user_id' => $client_user_id,'client_name' => $client_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);
    }

    // save dealer gps transfer/transfer gps from sub dealer to client
    public function proceedConfirmSubDealerGpsTransfer(Request $request) 
    {
        $from_user_id = \Auth::user()->id;
        $gps_array = $request->gps_id;
        $to_user_id = $request->client_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $uniqid=uniqid();
        $order_number=$uniqid.date("Y-m-d h:i:s");
        if($gps_array){
            $gps_transfer = GpsTransfer::create([
              "from_user_id" => $from_user_id, 
              "to_user_id" => $to_user_id,
              "order_number" => $order_number,
              "scanned_employee_code" => $scanned_employee_code,
              "invoice_number" => $invoice_number,
              "dispatched_on" => date('Y-m-d H:i:s'),
              "accepted_on" => date('Y-m-d H:i:s')
            ]);
            $last_id_in_gps_transfer=$gps_transfer->id;
        }
        if($last_id_in_gps_transfer){
            foreach ($gps_array as $gps_id) {
                $gps_transfer_item = GpsTransferItems::create([
                  "gps_id" => $gps_id, 
                  "gps_transfer_id" => $last_id_in_gps_transfer
                ]);
                if($gps_transfer_item){
                    //update gps table
                    $gps = Gps::find($gps_id);
                    $gps->user_id =$to_user_id;
                    $gps->save();
                }
            }
        }
        $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
        $request->session()->flash('message', 'Gps Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('gps-transfer.label',$encrypted_gps_transfer_id));
    }

    //view gps transfer list
    public function viewGpsTransfer(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$decrypted_id)
                        ->get();
        if($gps_items == null){
           return view('Gps::404');
        }
        $devices=array();
        foreach($gps_items as $gps_item){
            $single_gps= $gps_item->gps_id;
            $devices[]=Gps::select('id','imei','version','e_sim_number','brand','model_name')
                        ->where('id',$single_gps)
                        ->first();
        }
       return view('Gps::gps-list-view',['devices' => $devices]);
    }

    //accept transferred gps
    public function AcceptGpsTransfer(Request $request)
    {
        $user_id = \Auth::user()->id;
        $gps_transfer = GpsTransfer::find($request->id);
        if($gps_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred gps does not exist'
            ]);
        }
        $gps_transfer->accepted_on =date('Y-m-d H:i:s');
        $accept_gps=$gps_transfer->save();
        if($accept_gps){
            $gps_items = GpsTransferItems::select( 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer->id)
                        ->get();
            if($gps_items == null){
               return view('Gps::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = Gps::find($single_gps_id);
                $gps->user_id =$user_id;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps accepted successfully'
        ]);
    }

    //cancel gps transfer
    public function cancelGpsTransfer(Request $request){
        $user_id = \Auth::user()->id;
        $gps_transfer = GpsTransfer::find($request->id);
        if($gps_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred gps does not exist'
            ]);
        }
        $cancel_transfer=$gps_transfer->delete();
        if($cancel_transfer){
            $gps_items = GpsTransferItems::select( 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer->id)
                        ->get();
            if($gps_items == null){
               return view('Gps::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = Gps::find($single_gps_id);
                $gps->user_id =$user_id;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps transfer cancelled successfully'
        ]);
    }

    //label for transferred gps
    public function gpsTransferLabel(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $decrypted_id = Crypt::decrypt($request->id);
        if($request->user()->hasRole('root')){
            $gps_transfer = GpsTransfer::find($decrypted_id);
            $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                            ->where('gps_transfer_id',$decrypted_id)
                            ->get();
            $role_details = Dealer::select('id', 'name', 'address','user_id')
                                ->where('user_id',$gps_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            if($gps_transfer == null){
               return view('Gps::404');
            }
           return view('Gps::gps-transfer-label',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
        }else if($request->user()->hasRole('dealer')){
            $gps_transfer = GpsTransfer::find($decrypted_id);
            $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                            ->where('gps_transfer_id',$decrypted_id)
                            ->get();
            $role_details = SubDealer::select('id', 'name', 'address','user_id')
                                ->where('user_id',$gps_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            if($gps_transfer == null){
               return view('Gps::404');
            }
           return view('Gps::gps-transfer-label',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
        }else if($request->user()->hasRole('sub_dealer')){
            $gps_transfer = GpsTransfer::find($decrypted_id);
            $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                            ->where('gps_transfer_id',$decrypted_id)
                            ->get();
            $role_details = Client::select('id', 'name', 'address','user_id')
                                ->where('user_id',$gps_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            if($gps_transfer == null){
               return view('Gps::404');
            }
           return view('Gps::gps-transfer-label',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
        }
    }

    public function exportGpsTransferLabel(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $gps_transfer_id=$request->id;
        if($request->user()->hasRole('root')){
            $gps_transfer = GpsTransfer::find($gps_transfer_id);
            $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                            ->where('gps_transfer_id',$gps_transfer_id)
                            ->get();
            $role_details = Dealer::select('id', 'name', 'address','user_id')
                                ->where('user_id',$gps_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            view()->share('gps_transfer',$gps_transfer);
            $pdf = PDF::loadView('Exports::gps-transfer-label',['gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
            $headers = array(
                      'Content-Type'=> 'application/pdf'
                    );
            return $pdf->download('GPSTransferLabel.pdf',$headers);
        }else if($request->user()->hasRole('dealer')){
            $gps_transfer = GpsTransfer::find($gps_transfer_id);
            $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                            ->where('gps_transfer_id',$gps_transfer_id)
                            ->get();
            $role_details = SubDealer::select('id', 'name', 'address','user_id')
                                ->where('user_id',$gps_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            view()->share('gps_transfer',$gps_transfer);
            $pdf = PDF::loadView('Exports::gps-transfer-label',['gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
            $headers = array(
                      'Content-Type'=> 'application/pdf'
                    );
            return $pdf->download('GPSTransferLabel.pdf',$headers);
        }else if($request->user()->hasRole('sub_dealer')){
            $gps_transfer = GpsTransfer::find($gps_transfer_id);
            $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                            ->where('gps_transfer_id',$gps_transfer_id)
                            ->get();
            $role_details = Client::select('id', 'name', 'address','user_id')
                                ->where('user_id',$gps_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            view()->share('gps_transfer',$gps_transfer);
            $pdf = PDF::loadView('Exports::gps-transfer-label',['gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
            $headers = array(
                      'Content-Type'=> 'application/pdf'
                    );
            return $pdf->download('GPSTransferLabel.pdf',$headers);
        }
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
         $items = GpsData::all();  
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
           // <a href=".$b_url."/dealers/".Crypt::encrypt($items->id)."/change-password class='btn btn-xs btn-primary'>View</a>
            return "
          
             <button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdata($items->id)'>View </button> 
            ";
          
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




















    // root gps transfer rule
    public function gpsRootTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|unique:gps_transfers'
        ];
        return $rules;
    }

    // root gps transfer rule with null gps_id array
    public function gpsRootTransferNullRule(){
        $rules = [
          'gps_id' => 'required',
          'dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|unique:gps_transfers'
        ];
        return $rules;
    }


    // dealer gps transfer rule
    public function gpsDealerTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'sub_dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|unique:gps_transfers'
      ];
        return $rules;
    }

    // root gps transfer rule with null gps_id array
    public function gpsDealerTransferNullRule(){
        $rules = [
            'gps_id' => 'required',
            'sub_dealer_user_id' => 'required',
            'scanned_employee_code' => 'required',
            'invoice_number' => 'required|unique:gps_transfers'
        ];
        return $rules;
    }

    // sub dealer gps transfer rule
    public function gpsSubDealerTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'client_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|unique:gps_transfers'
        ];
        return $rules;
    }

    // root gps transfer rule with null gps_id array
    public function gpsSubDealerTransferNullRule(){
        $rules = [
            'gps_id' => 'required',
            'client_user_id' => 'required',
            'scanned_employee_code' => 'required',
            'invoice_number' => 'required|unique:gps_transfers'
        ];
        return $rules;
    }

    //validation for gps creation
    public function gpsCreateRules(){
        $rules = [
            'imei' => 'required|string|unique:gps|min:15|max:15',
            'manufacturing_date' => 'required',
            'e_sim_number' => 'required|string|unique:gps|min:11|max:11',
            'brand' => 'required',
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
            'brand' => 'required',
            'model_name' => 'required',
            'version' => 'required',
        ];
        return  $rules;
    } 



}