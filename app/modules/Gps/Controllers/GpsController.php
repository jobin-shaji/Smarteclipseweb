<?php 


namespace App\Modules\Gps\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Gps\Models\GpsLocation;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Gps\Models\VltData;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
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
                'name',
            	'imei',
            	'manufacturing_date',
                'brand',
                'model_name',
            	'version',
                'deleted_at')
                ->withTrashed()
                ->where('user_id',$user_id)
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->addColumn('action', function ($gps) {
                if($gps->deleted_at == null){
                    // <a href=/gps/".Crypt::encrypt($gps->id)."/data class='btn btn-xs btn-info'><i class='glyphicon glyphicon-folder-open'></i> Data </a>
                    return "
                    <a href=/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=delGps(".$gps->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                    </button>";
                }else{
                     return "
                    <a href=/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateGps(".$gps->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate
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
                'name',
                'imei',
                'manufacturing_date',
                'version',
                'user_id',
                'deleted_at')
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
                if($gps->deleted_at == null){
                    return "
                    <a href=/gps/".Crypt::encrypt($gps->id)."/data class='btn btn-xs btn-info'><i class='glyphicon glyphicon-folder-open'></i> Data </a>
                    <a href=/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=delGps(".$gps->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                    </button>";
                }else{
                     return "
                    <a href=/gps/".Crypt::encrypt($gps->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/gps/".Crypt::encrypt($gps->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
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
        $rules = $this->gpsCreateRules();
        $this->validate($request, $rules);
        $gps = Gps::create([
            'name'=> $request->name,
            'imei'=> $request->imei,
            'manufacturing_date'=> date("Y-m-d", strtotime($request->manufacturing_date)),
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
        $decrypted_id = Crypt::decrypt($request->id);
        $gps = Gps::find($decrypted_id);
        if($gps == null){
           return view('Gps::404');
        }
       return view('Gps::gps-details',['gps' => $gps]);
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

        $gps->name = $request->name;
        $gps->imei = $request->imei;
        $gps->manufacturing_date = $request->manufacturing_date;
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
            'message' => 'Gps deleted successfully'
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
        ->with('gps:id,name')
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
                            ->orderBy('id','DESC')
                            ->get();
        return DataTables::of($devices)
            ->addIndexColumn()
            ->addColumn('action', function ($devices) {
                if($devices->accepted_on == null)
                {
                    return "
                    <a href=/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View Gps </a>
                    <button onclick=acceptGpsTransfer(".$devices->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Accept
                    </button>";
                }else{
                    return "
                    <a href=/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View Gps </a>
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
        $dealer_user_id=\Auth::user()->id;
        $gps = Gps::select(
                'id',
                'name',
                'imei',
                'version',
                'deleted_at')
                ->withTrashed()
                ->where('user_id',$dealer_user_id)
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
        $sub_dealer_id=\Auth::user()->id;
        $gps = Gps::select(
                'id',
                'name',
                'imei',
                'version',
                'deleted_at')
                ->withTrashed()
                ->where('user_id',$sub_dealer_id)
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->make();
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
                'name',
                'imei',
                'version',
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
        $gps_transfer = GpsTransfer::select('id', 'from_user_id', 'to_user_id','dispatched_on','accepted_on','deleted_at')
            ->with('fromUser:id,username')
            ->with('toUser:id,username')
            ->where('from_user_id',$user_id)
            ->withTrashed()
            ->get();
        return DataTables::of($gps_transfer)
        ->addIndexColumn()
        ->addColumn('action', function ($gps_transfer) {
            if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
            {
                return "
                <a href=/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=cancelGpsTransfer(".$gps_transfer->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
                </button>";
            }
            else if($gps_transfer->deleted_at != null){
                return "
                <a href=/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#FF0000';>Cancelled</b>";
            }
            else{
                 return "
                <a href=/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#008000';>Transferred</b>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create gps transfer
    public function createGpsTransfer(Request $request) 
    {
        if($request->user()->hasRole('root')){
            $user = \Auth::user();
            $root = $user->root;
            $devices = Gps::select('id', 'name', 'imei','user_id')
                            ->where('user_id',$user->id)
                            ->get();
            $entities = $root->dealers;
        }else if($request->user()->hasRole('dealer')){
            $user = \Auth::user();
            $dealer = $user->dealer;
            $devices = Gps::select('id', 'name', 'imei','user_id')
                            ->where('user_id',$user->id)
                            ->get();
            $entities = $dealer->subDealers;
        }else if($request->user()->hasRole('sub_dealer')){
            $user = \Auth::user();
            $sub_dealer=$user->subdealer;
            $devices = Gps::select('id', 'name', 'imei','user_id')
                            ->where('user_id',$user->id)
                            ->get();
            $entities = $sub_dealer->clients;
        }
        
        return view('Gps::gps-transfer', ['devices' => $devices, 'entities' => $entities]);
    }
    // save gps transfer
    public function saveGpsTransfer(Request $request) 
    {
        $from_user_id = \Auth::user()->id;
        $rules = $this->gpsTransferRule();
        $this->validate($request, $rules);
        $gps_array = $request->gps_id;
        $to_user_id = $request->to_user_id;
        if($gps_array){
            $gps_transfer = GpsTransfer::create([
              "from_user_id" => $from_user_id, 
              "to_user_id" => $to_user_id,
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
        
        $request->session()->flash('message', 'Gps Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('gps-transfers'));
    }

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
            $devices[]=Gps::select('id','name','imei','version')
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

    // gps transfer rule
    public function gpsTransferRule() {
        $rules = [
          'gps_id' => 'required',
          'from_user_id' => 'nullable',
          'to_user_id' => 'required'];
        return $rules;
    }

    //validation for gps creation
    public function gpsCreateRules(){
        $rules = [
            'name' => 'required',
            'imei' => 'required|string|min:15|unique:gps',
            'manufacturing_date' => 'required',
            'brand' => 'required',
            'model_name' => 'required',
            'version' => 'required'
        ];
        return  $rules;
    }

    //validation for gps updation
    public function gpsUpdateRules($gps){
        $rules = [
            'name' => 'required',
            'imei' => 'required|string|min:15|unique:gps,imei,'.$gps->id,
            'manufacturing_date' => 'required',
            'version' => 'required',
        ];
        return  $rules;
    } 



}