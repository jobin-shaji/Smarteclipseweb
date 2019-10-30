<?php 


namespace App\Modules\Warehouse\Controllers;

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

class WarehouseController extends Controller {

    /////////////////////////New Arrivals-start//////////////////////////////////

    //Display new arrived dealer gps
    public function newGpsDealerListPage()
    {
        return view('Warehouse::gps-dealer-new-arrival-list');
    } 

    //returns new arrived gps as json 
    public function getNewGpsDealer()
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
                    <button onclick=acceptDealerGpsTransfer(".$devices->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Accept
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

    //Display new arrived sub dealer gps
    public function newGpsSubDealerListPage()
    {
        return view('Warehouse::gps-sub-dealer-new-arrival-list');
    } 

    //returns new arrived gps as json 
    public function getNewGpsSubDealer()
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
                    <button onclick=acceptSubDealerGpsTransfer(".$devices->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Accept
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

    ///////////////////////////Gps Transfer////////////////////////////////

    // gps transfer list - root
    public function getRootList() 
    {
        return view('Warehouse::gps-transfer-root-list');
    }

    //gps transfer list data - root
    public function getRootListData() 
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
                <button onclick=cancelRootGpsTransfer(".$gps_transfer->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
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
        $devices = GpsStock::select('id', 'gps_id','dealer_id')
                        ->with('gps')
                        ->where('dealer_id',null)
                        ->get();
        $entities = $root->dealers;

        return view('Warehouse::root-gps-transfer', ['devices' => $devices,'entities' => $entities]);
    }

    //get scanned gps and check gps status
    public function getScannedGps(Request $request)
    {
        $device_serial_no=$request->serial_no;
        $user = \Auth::user();
        $user_stock_devices=[];
        if($user->hasRole('root'))
        {
            $stock_devices = GpsStock::select('id', 'gps_id','dealer_id')
                            ->where('dealer_id',null)->get();
        }else if($user->hasRole('dealer')){
            $dealer_id=$user->dealer->id;
            $stock_devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id')
                            ->where('dealer_id',$dealer_id)->where('subdealer_id',null)->get();
        }else if($user->hasRole('sub_dealer')){
            $subdealer_id=$user->subdealer->id;
            $stock_devices = GpsStock::select('id', 'gps_id','subdealer_id','client_id')
                            ->where('subdealer_id',$subdealer_id)->where('client_id',null)->get();
        }
        foreach($stock_devices as $device){
            $user_stock_devices[] = $device->gps_id;
        }
        $device = Gps::select('id', 'serial_no','batch_number','employee_code')
                        ->whereIn('id',$user_stock_devices)
                        ->where('serial_no',$device_serial_no)
                        ->first();
        if($device==null){
            return response()->json(array(
                'status' => 0,
                'title' => 'Error',
            ));
        }else{
            $gps_id=$device->id;
            $gps_serial_no=$device->serial_no;
            $gps_batch_number=$device->batch_number;
            $gps_employee_code=$device->employee_code;
            return response()->json(array(
                'status' => 1,
                'title' => 'success',
                'gps_id' => $gps_id,
                'gps_serial_no' => $gps_serial_no,
                'gps_batch_number' => $gps_batch_number,
                'gps_employee_code' => $gps_employee_code
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
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one QR code']);
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
        $devices = Gps::select('id', 'serial_no')
                        ->whereIn('id',$gps_list)
                        ->get();
        return view('Warehouse::root-gps-transfer_proceed', ['dealer_user_id' => $dealer_user_id,'dealer_name' => $dealer_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);
    }

    // save root gps transfer/transfer gps from root to dealer
    public function proceedConfirmRootGpsTransfer(Request $request) 
    {
        $from_user_id = \Auth::user()->id;
        $gps_array = $request->gps_id;
        $to_user_id = $request->dealer_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $transferred_devices=[];
        $transfer_inprogress_devices = GpsStock::select('gps_id')->where('dealer_id',0)->whereIn('gps_id',$gps_array)->get();
        foreach ($transfer_inprogress_devices as $devices) {
            $transferred_devices[]=$devices->gps_id;
        }
        if($transferred_devices){
            $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps.transfer.root'));
        }else{
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
                        //update gps stock table
                        $gps = GpsStock::where('gps_id',$gps_id)->first();
                        $gps->dealer_id =0;
                        $gps->save();
                    }
                }
            }
            $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
            $request->session()->flash('message', 'Gps Transfer successfully completed!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer.label',$encrypted_gps_transfer_id));
        }
        
    }

    // gps transfer list - dealer
    public function getDealerList() 
    {
        return view('Warehouse::gps-transfer-dealer-list');
    }

    //gps transfer list data - dealer
    public function getDealerListData() 
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
                <button onclick=cancelDealerGpsTransfer(".$gps_transfer->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
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

    // create dealer gps transfer
    public function createDealerGpsTransfer(Request $request) 
    {
        $user = \Auth::user();
        $dealer = $user->dealer;
        $dealer_id = $user->dealer->id;
        $devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id')
                        ->with('gps')
                        ->where('dealer_id',$dealer_id)
                        ->where('subdealer_id',null)
                        ->get();
        $entities = $dealer->subDealers()->with('user')->get();

        $entities = $entities->where('user.deleted_at',null);

        return view('Warehouse::dealer-gps-transfer', ['devices' => $devices, 'entities' => $entities]);
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
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one QR code']);
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
        $devices = Gps::select('id', 'serial_no')
                        ->whereIn('id',$gps_list)
                        ->get();
        return view('Warehouse::dealer-gps-transfer_proceed', ['sub_dealer_user_id' => $sub_dealer_user_id,'sub_dealer_name' => $sub_dealer_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);
    }

    // save dealer gps transfer/transfer gps from dealer to sub dealer
    public function proceedConfirmDealerGpsTransfer(Request $request) 
    {
        $dealer_id=\Auth::user()->dealer->id;
        $from_user_id = \Auth::user()->id;
        $gps_array = $request->gps_id;
        $to_user_id = $request->sub_dealer_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $transferred_devices=[];
        $transfer_inprogress_devices = GpsStock::select('gps_id')->where('dealer_id',$dealer_id)->where('subdealer_id',0)->whereIn('gps_id',$gps_array)->get();
        foreach ($transfer_inprogress_devices as $devices) {
            $transferred_devices[]=$devices->gps_id;
        }
        if($transferred_devices){
            $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-dealer.create'));
        }else{
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
                        //update gps stock table
                        $gps = GpsStock::where('gps_id',$gps_id)->first();
                        $gps->subdealer_id =0;
                        $gps->save();
                    }
                }
            }
            $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
            $request->session()->flash('message', 'Gps Transfer successfully completed!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer.label',$encrypted_gps_transfer_id));
        }
    }

    // gps transfer list - dealer
    public function getSubDealerList() 
    {
        return view('Warehouse::gps-transfer-subdealer-list');
    }

    //gps transfer list data - dealer
    public function getSubDealerListData() 
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
            return "
            <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
            <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <b style='color:#008000';>Transferred</b>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create sub dealer gps transfer
    public function createSubDealerGpsTransfer(Request $request) 
    {
        $user = \Auth::user();
        $sub_dealer=$user->subdealer;
        $subdealer_id=$sub_dealer->id;
        $devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id','client_id')
                        ->with('gps')
                        ->where('subdealer_id',$subdealer_id)
                        ->where('client_id',null)
                        ->get();
        $entities = $sub_dealer->clients()->with('user')->get();

        $entities = $entities->where('user.deleted_at',null);

        return view('Warehouse::sub-dealer-gps-transfer', ['devices' => $devices, 'entities' => $entities]);
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
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one QR code']);
        $client_user_id=$request->client_user_id;
        $client = Client::where('user_id',$client_user_id)->first();
        $client_id=$client->id;
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
        $devices = Gps::select('id', 'serial_no')
                        ->whereIn('id',$gps_list)
                        ->get();
        return view('Warehouse::sub-dealer-gps-transfer_proceed', ['client_user_id' => $client_user_id,'client_id' => $client_id,'client_name' => $client_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);
    }

    // save dealer gps transfer/transfer gps from sub dealer to client
    public function proceedConfirmSubDealerGpsTransfer(Request $request) 
    {
        $subdealer_id=\Auth::user()->subdealer->id;
        $from_user_id = \Auth::user()->id;
        $gps_array = $request->gps_id;
        $to_user_id = $request->client_user_id;
        $client_id = $request->client_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $transferred_devices=[];
        $transfer_inprogress_devices = GpsStock::select('gps_id')->where('subdealer_id',$subdealer_id)->whereNotIn('client_id',['null'])->whereIn('gps_id',$gps_array)->get();
        foreach ($transfer_inprogress_devices as $devices) {
            $transferred_devices[]=$devices->gps_id;
        }
        if($transferred_devices){
            $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-sub-dealer.create'));
        }else{
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
                        //update gps stock table
                        $gps = GpsStock::where('gps_id',$gps_id)->first();
                        $gps->client_id =$client_id;
                        $gps->save();
                    }
                }
            }
            $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
            $request->session()->flash('message', 'Gps Transfer successfully completed!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer.label',$encrypted_gps_transfer_id));
        }
    }

    //view gps transfer list
    public function viewGpsTransfer(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$decrypted_id)
                        ->get();
        if($gps_items == null){
           return view('Warehouse::404');
        }
        $devices=array();
        foreach($gps_items as $gps_item){
            $single_gps= $gps_item->gps_id;
            $devices[]=Gps::select('id','imei','serial_no','icc_id','imsi','version','e_sim_number','batch_number','employee_code','model_name')
                        ->where('id',$single_gps)
                        ->first();
        }
       return view('Warehouse::gps-list-view',['devices' => $devices]);
    }

    //accept transferred gps in dealer
    public function AcceptGpsDealerTransfer(Request $request)
    {
        $dealer_id = \Auth::user()->dealer->id;
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
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->dealer_id =$dealer_id;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps accepted successfully'
        ]);
    }

    //accept transferred gps in sub dealer
    public function AcceptGpsSubDealerTransfer(Request $request)
    {
        $subdealer_id = \Auth::user()->subdealer->id;
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
               return view('Warehouse::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->subdealer_id =$subdealer_id;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps accepted successfully'
        ]);
    }

    //cancel root gps transfer
    public function cancelRootGpsTransfer(Request $request){
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
               return view('Warehouse::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->dealer_id =null;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps transfer cancelled successfully'
        ]);
    }

    //cancel dealer gps transfer
    public function cancelDealerGpsTransfer(Request $request){
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
               return view('Warehouse::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->subdealer_id =null;
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
               return view('Warehouse::404');
            }
           return view('Warehouse::gps-transfer-label',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
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
               return view('Warehouse::404');
            }
           return view('Warehouse::gps-transfer-label',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
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
               return view('Warehouse::404');
            }
           return view('Warehouse::gps-transfer-label',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
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

    // root gps transfer rule
    public function gpsRootTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u|unique:gps_transfers'
        ];
        return $rules;
    }

    // root gps transfer rule with null gps_id array
    public function gpsRootTransferNullRule(){
        $rules = [
          'gps_id' => 'required',
          'dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u|unique:gps_transfers'
        ];
        return $rules;
    }


    // dealer gps transfer rule
    public function gpsDealerTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'sub_dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u|unique:gps_transfers'
      ];
        return $rules;
    }

    // root gps transfer rule with null gps_id array
    public function gpsDealerTransferNullRule(){
        $rules = [
            'gps_id' => 'required',
            'sub_dealer_user_id' => 'required',
            'scanned_employee_code' => 'required',
            'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u|unique:gps_transfers'
        ];
        return $rules;
    }

    // sub dealer gps transfer rule
    public function gpsSubDealerTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'client_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u|unique:gps_transfers'
        ];
        return $rules;
    }

    // root gps transfer rule with null gps_id array
    public function gpsSubDealerTransferNullRule(){
        $rules = [
            'gps_id' => 'required',
            'client_user_id' => 'required',
            'scanned_employee_code' => 'required',
            'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u|unique:gps_transfers'
        ];
        return $rules;
    }

}