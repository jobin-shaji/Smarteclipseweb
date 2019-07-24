<?php 


namespace App\Modules\Sos\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Sos\Models\Sos;
use App\Modules\Sos\Models\SosTransfer;
use App\Modules\Sos\Models\SosTransferItems;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\Ota\Models\OtaType;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;


class SosController extends Controller {
    //Display all sos
	public function sosListPage()
    {
        return view('Sos::sos-list');
	}
	//returns sos as json 
    public function getSos()
    {
        $user_id=\Auth::user()->id;
        $sos = Sos::select(
            'id',
        	'imei',
        	'manufacturing_date',
            'brand',
            'model_name',
        	'version',
            'deleted_at'
        )
        ->withTrashed()
        ->where('user_id',$user_id)
        ->get();
        return DataTables::of($sos)
        ->addIndexColumn()
        ->addColumn('action', function ($sos) {
            $b_url = \URL::to('/');
            if($sos->deleted_at == null){
                // <a href=/sos/".Crypt::encrypt($sos->id)."/data class='btn btn-xs btn-info'><i class='glyphicon glyphicon-folder-open'></i> Data </a>
                return "
                <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=delSos(".$sos->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                </button>";
            }else{
                 return "
                <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=activateSos(".$sos->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate
                </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    //Display all transferred sos
    public function sosTransferredListPage()
    {
        return view('Sos::sos-transferred-list');
    }

    //returns sos as json 
    public function getTransferredSos()
    {
        $user_id[]=\Auth::user()->id;
        $sos = Sos::select(
                'id',
                'imei',
                'manufacturing_date',
                'version',
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
                
        return DataTables::of($sos)
            ->addIndexColumn()
            ->addColumn('user', function ($sos) {
                if($sos->user_id == null){
                    return "Transfer in progress";
                }else{
                    return $sos->user->username;
                }
            })
            ->addColumn('action', function ($sos) {
                $b_url = \URL::to('/');
                if($sos->deleted_at == null){
                    return "
                    <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/data class='btn btn-xs btn-info'><i class='glyphicon glyphicon-folder-open'></i> Data </a>
                    <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=delSos(".$sos->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                    </button>";
                }else{
                     return "
                    <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=".$b_url."/sos/".Crypt::encrypt($sos->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateSos(".$sos->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate
                    </button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //for sos creation
    public function create()
    {
        return view('Sos::sos-create');
    }

    //upload sos details to database table
    public function save(Request $request)
    {
        $root_id=\Auth::user()->id;
        $maufacture= date("Y-m-d", strtotime($request->manufacturing_date));
       
        $rules = $this->sosCreateRules();
        $this->validate($request, $rules);
        $sos = Sos::create([
            'imei'=> $request->imei,
            'manufacturing_date'=> date("Y-m-d", strtotime($request->manufacturing_date)),
            'brand'=> $request->brand,
            'model_name'=> $request->model_name,
            'version'=> $request->version,
            'user_id' => $root_id,
            'status'=>1
        ]);
        $request->session()->flash('message', 'New sos button created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('sos.details',Crypt::encrypt($sos->id)));
    } 

    //view sos details
    public function details(Request $request)
    {

         \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $eid=$request->id;
        $decrypted_id = Crypt::decrypt($request->id);
        $sos = Sos::find($decrypted_id);
        if($sos == null){
           return view('Sos::404');
        }

        return view('Sos::sos-details',['sos' => $sos,'eid' => $eid]);
    } 

    //edit sos details
    public function edit(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $sos = Sos::find($decrypted_id);
        if($sos == null){
           return view('Sos::404');
        }
       return view('Sos::sos-edit',['sos' => $sos]);
    }

    //update sos details to database table
    public function update(Request $request){
        $sos = Sos::find($request->id);
        if($sos == null){
           return view('Sos::404');
        }
        $rules = $this->sosUpdateRules($sos);
        $this->validate($request, $rules);

        $sos->imei = $request->imei;
        $sos->manufacturing_date = $request->manufacturing_date;
        $sos->brand = $request->brand;
        $sos->model_name = $request->model_name;
        $sos->version = $request->version;
        $sos->save();

        $encrypted_sos_id = encrypt($sos->id);
        $request->session()->flash('message', ' Sos updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('sos.edit',$encrypted_sos_id));  
    }

    //delete sos details
    public function deleteSos(Request $request){
        $sos = Sos::find($request->uid);
        if($sos == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Sos does not exist'
            ]);
        }
        $sos->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Sos deleted successfully'
        ]);
    }

    // restore sos 
    public function activateSos(Request $request)
    {
        $sos = Sos::withTrashed()->find($request->id);
        if($sos==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Sos does not exist'
             ]);
        }

        $sos->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Sos restored successfully'
        ]);
    }

    /////////////////////////New Arrivals-start//////////////////////////////////

    //Display new arrived dealer sos
    public function newSosListPage()
    {
        return view('Sos::sos-new-arrival-list');
    } 

    //returns new arrived sos as json 
    public function getNewSos()
    {
        $user_id=\Auth::user()->id;
        $devices=SosTransfer::select(
            'id',
            'from_user_id',
            'dispatched_on',
            'accepted_on'
        )
        ->with('fromUser:id,username')
        ->where('to_user_id',$user_id)
        ->with('sosTransferItems')
        ->orderBy('id','DESC')
        ->get();
        return DataTables::of($devices)
            ->addIndexColumn()
            ->addColumn('count',function($sos_transfer){
                return $sos_transfer->sosTransferItems->count();
             })
            ->addColumn('action', function ($devices) {
                $b_url = \URL::to('/');
                if($devices->accepted_on == null)
                {
                    return "
                    <a href=".$b_url."/sos-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-info' data-toggle='tooltip' title='View  Sos'><i class='fas fa-eye'> View</i></a>
                    <button onclick=acceptSosTransfer(".$devices->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Accept
                    </button>";
                }else{
                    return "
                    <a href=".$b_url."/sos-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-success'  data-toggle='tooltip' title='View Sos'><i class='fas fa-eye'></i> View </a>
                    <b style='color:#008000';>Accepted</b>";
                }
                
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //////////////////////////New Arrivals-end////////////////////////////////


    //////////////////////////SOS DEALER///////////////////////////////////

    //Display all dealer sos
    public function sosDealerListPage()
    {
        return view('Sos::sos-dealer-list');
    } 

    //returns sos as json 
    public function getDealerSos()
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
        $sos = Sos::select(
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
        return DataTables::of($sos)
            ->addIndexColumn()
            ->make();
    }

    //////////////////////////SOS SUB DEALER///////////////////////////////////

    //Display all dealer sos
    public function sosSubDealerListPage()
    {
        return view('Sos::sos-sub-dealer-list');
    } 

    //returns sos as json 
    public function getSubDealerSos()
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
        $sos = Sos::select(
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
        return DataTables::of($sos)
            ->addIndexColumn()
            ->make();
    }

    //////////////////////////SOS CLIENT///////////////////////////////////

    //Display all dealer sos
    public function sosClientListPage()
    {
        return view('Sos::sos-client-list');
    } 

    //returns sos as json 
    public function getClientSos()
    {
        $client_id=\Auth::user()->id;
        $sos = Sos::select(
                'id',
                'imei',
                'version',
                'brand',
                'model_name',
                'deleted_at')
                ->withTrashed()
                ->where('user_id',$client_id)
                ->get();
        return DataTables::of($sos)
            ->addIndexColumn()
            ->make();
    }

    ///////////////////////////Sos Transfer////////////////////////////////

    // sos transfer list
    public function getList() 
    {
        return view('Sos::sos-transfer-list');
    }

    //sos transfer list data
    public function getListData() 
    {
        $user_id=\Auth::user()->id;
        $sos_transfer = SosTransfer::select(
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
        ->with('sosTransferItems')
        ->where('from_user_id',$user_id)
        ->orderBy('id','DESC')
        ->withTrashed()
        ->get();
        return DataTables::of($sos_transfer)
        ->addIndexColumn()
        ->addColumn('count', function ($sos_transfer) 
        {
            return $sos_transfer->sosTransferItems->count();
        })
        ->addColumn('action', function ($sos_transfer) 
        {
            $b_url = \URL::to('/');
            if($sos_transfer->accepted_on == null && $sos_transfer->deleted_at == null)
            {
                return "
                <a href=".$b_url."/sos-transfer/".Crypt::encrypt($sos_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                <a href=".$b_url."/sos-transfer/".Crypt::encrypt($sos_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=cancelSosTransfer(".$sos_transfer->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
                </button>";
            }
            else if($sos_transfer->deleted_at != null){
                return "
                <a href=".$b_url."/sos-transfer/".Crypt::encrypt($sos_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#FF0000';>Cancelled</b>";
            }
            else{
                return "
                <a href=".$b_url."/sos-transfer/".Crypt::encrypt($sos_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                <a href=".$b_url."/sos-transfer/".Crypt::encrypt($sos_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#008000';>Transferred</b>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create root sos transfer
    public function createRootSosTransfer(Request $request) 
    {
        $user = \Auth::user();
        $root = $user->root;
        $devices = Sos::select('id', 'imei','user_id')
                        ->where('user_id',$user->id)
                        ->get();
        $entities = $root->dealers;

        return view('Sos::root-sos-transfer', ['devices' => $devices,'entities' => $entities]);
    }

    //get scanned sos and check sos status
    public function getScannedSos(Request $request)
    {
        $device_imei=$request->imei;
        $user = \Auth::user();
        $device = Sos::select('id', 'imei','user_id')
                        ->where('user_id',$user->id)
                        ->where('imei',$device_imei)
                        ->first();
        if($device==null){
            return response()->json(array(
                'status' => 0,
                'title' => 'Error',
            ));
        }else{
            $sos_id=$device->id;
            $sos_imei=$device->imei;
            return response()->json(array(
                'status' => 1,
                'title' => 'success',
                'sos_id' => $sos_id,
                'sos_imei' => $sos_imei
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

    // proceed sos transfer for confirmation
    public function proceedRootSosTransfer(Request $request) 
    {
        $rules = $this->sosRootTransferRule();
        $this->validate($request, $rules);
        $dealer_user_id=$request->dealer_user_id;
        $dealer_name=$request->dealer_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $scanned_employee_code=$request->scanned_employee_code;
        $sos_array_list = $request->sos_id;
        $sos_array=explode(",",$sos_array_list[0]);
        $sos_list=[];
        foreach ($sos_array as $sos_id) {
            $sos_list[]=$sos_id;
        }
        $devices = Sos::select('id', 'imei')
                        ->whereIn('id',$sos_list)
                        ->get();
        return view('Sos::root-sos-transfer_proceed', ['dealer_user_id' => $dealer_user_id,'dealer_name' => $dealer_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code,'devices' => $devices]);
    }

    // save root sos transfer/transfer sos from root to dealer
    public function proceedConfirmRootSosTransfer(Request $request) 
    {
        $from_user_id = \Auth::user()->id;
        $sos_array = $request->sos_id;
        $to_user_id = $request->dealer_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $uniqid=uniqid();
        $order_number=$uniqid.date("Y-m-d h:i:s");
        if($sos_array){
            $sos_transfer = SosTransfer::create([
              "from_user_id" => $from_user_id, 
              "to_user_id" => $to_user_id,
              "order_number" => $order_number,
              "scanned_employee_code" => $scanned_employee_code,
              "dispatched_on" => date('Y-m-d H:i:s')
            ]);
            $last_id_in_sos_transfer=$sos_transfer->id;
        }
        if($last_id_in_sos_transfer){
            foreach ($sos_array as $sos_id) {
                $sos_transfer_item = SosTransferItems::create([
                  "sos_id" => $sos_id, 
                  "sos_transfer_id" => $last_id_in_sos_transfer
                ]);
                if($sos_transfer_item){
                    //update sos table
                    $sos = Sos::find($sos_id);
                    $sos->user_id =null;
                    $sos->save();
                }
            }
        }
        $encrypted_sos_transfer_id = encrypt($sos_transfer->id);
        $request->session()->flash('message', 'Sos Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('sos-transfer.label',$encrypted_sos_transfer_id));
    }

    // create dealer sos transfer
    public function createDealerSosTransfer(Request $request) 
    {
        $user = \Auth::user();
        $dealer = $user->dealer;
        $devices = Sos::select('id', 'imei','user_id')
                        ->where('user_id',$user->id)
                        ->get();
        $entities = $dealer->subDealers;

        return view('Sos::dealer-sos-transfer', ['devices' => $devices, 'entities' => $entities]);
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

    // proceed sos transfer for confirmation
    public function proceedDealerSosTransfer(Request $request) 
    {
        $rules = $this->sosDealerTransferRule();
        $this->validate($request, $rules);
        $sub_dealer_user_id=$request->sub_dealer_user_id;
        $sub_dealer_name=$request->sub_dealer_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $scanned_employee_code=$request->scanned_employee_code;
        $sos_array_list = $request->sos_id;
        $sos_array=explode(",",$sos_array_list[0]);
        $sos_list=[];
        foreach ($sos_array as $sos_id) {
            $sos_list[]=$sos_id;
        }
        $devices = Sos::select('id', 'imei')
                        ->whereIn('id',$sos_list)
                        ->get();
        return view('Sos::dealer-sos-transfer_proceed', ['sub_dealer_user_id' => $sub_dealer_user_id,'sub_dealer_name' => $sub_dealer_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code,'devices' => $devices]);
    }

    // save dealer sos transfer/transfer sos from dealer to sub dealer
    public function proceedConfirmDealerSosTransfer(Request $request) 
    {
        $from_user_id = \Auth::user()->id;
        $sos_array = $request->sos_id;
        $to_user_id = $request->sub_dealer_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $uniqid=uniqid();
        $order_number=$uniqid.date("Y-m-d h:i:s");
        if($sos_array){
            $sos_transfer = SosTransfer::create([
              "from_user_id" => $from_user_id, 
              "to_user_id" => $to_user_id,
              "order_number" => $order_number,
              "scanned_employee_code" => $scanned_employee_code,
              "dispatched_on" => date('Y-m-d H:i:s')
            ]);
            $last_id_in_sos_transfer=$sos_transfer->id;
        }
        if($last_id_in_sos_transfer){
            foreach ($sos_array as $sos_id) {
                $sos_transfer_item = SosTransferItems::create([
                  "sos_id" => $sos_id, 
                  "sos_transfer_id" => $last_id_in_sos_transfer
                ]);
                if($sos_transfer_item){
                    //update sos table
                    $sos = Sos::find($sos_id);
                    $sos->user_id =null;
                    $sos->save();
                }
            }
        }
        $encrypted_sos_transfer_id = encrypt($sos_transfer->id);
        $request->session()->flash('message', 'Sos Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('sos-transfer.label',$encrypted_sos_transfer_id));
    }

    // create sub dealer sos transfer
    public function createSubDealerSosTransfer(Request $request) 
    {
        $user = \Auth::user();
        $sub_dealer=$user->subdealer;
        $devices = Sos::select('id', 'imei','user_id')
                        ->where('user_id',$user->id)
                        ->get();
        $entities = $sub_dealer->clients;

        return view('Sos::sub-dealer-sos-transfer', ['devices' => $devices, 'entities' => $entities]);
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

    // proceed sos transfer for confirmation
    public function proceedSubDealerSosTransfer(Request $request) 
    {
        $rules = $this->sosSubDealerTransferRule();
        $this->validate($request, $rules);
        $client_user_id=$request->client_user_id;
        $client_name=$request->client_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $scanned_employee_code=$request->scanned_employee_code;
        $sos_array_list = $request->sos_id;
        $sos_array=explode(",",$sos_array_list[0]);
        $sos_list=[];
        foreach ($sos_array as $sos_id) {
            $sos_list[]=$sos_id;
        }
        $devices = Sos::select('id', 'imei')
                        ->whereIn('id',$sos_list)
                        ->get();
        return view('Sos::sub-dealer-sos-transfer_proceed', ['client_user_id' => $client_user_id,'client_name' => $client_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code,'devices' => $devices]);
    }

    // save dealer sos transfer/transfer sos from sub dealer to client
    public function proceedConfirmSubDealerSosTransfer(Request $request) 
    {
        $from_user_id = \Auth::user()->id;
        $sos_array = $request->sos_id;
        $to_user_id = $request->client_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $uniqid=uniqid();
        $order_number=$uniqid.date("Y-m-d h:i:s");
        if($sos_array){
            $sos_transfer = SosTransfer::create([
              "from_user_id" => $from_user_id, 
              "to_user_id" => $to_user_id,
              "order_number" => $order_number,
              "scanned_employee_code" => $scanned_employee_code,
              "dispatched_on" => date('Y-m-d H:i:s')
            ]);
            $last_id_in_sos_transfer=$sos_transfer->id;
        }
        if($last_id_in_sos_transfer){
            foreach ($sos_array as $sos_id) {
                $sos_transfer_item = SosTransferItems::create([
                  "sos_id" => $sos_id, 
                  "sos_transfer_id" => $last_id_in_sos_transfer
                ]);
                if($sos_transfer_item){
                    //update sos table
                    $sos = Sos::find($sos_id);
                    $sos->user_id =null;
                    $sos->save();
                }
            }
        }
        $encrypted_sos_transfer_id = encrypt($sos_transfer->id);
        $request->session()->flash('message', 'Sos Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('sos-transfer.label',$encrypted_sos_transfer_id));
    }

    //view sos transfer list
    public function viewSosTransfer(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $sos_items = SosTransferItems::select('id', 'sos_transfer_id', 'sos_id')
                        ->where('sos_transfer_id',$decrypted_id)
                        ->get();
        if($sos_items == null){
           return view('Sos::404');
        }
        $devices=array();
        foreach($sos_items as $sos_item){
            $single_sos= $sos_item->sos_id;
            $devices[]=Sos::select('id','imei','version','brand','model_name')
                        ->where('id',$single_sos)
                        ->first();
        }
       return view('Sos::sos-list-view',['devices' => $devices]);
    }

    //accept transferred sos
    public function AcceptSosTransfer(Request $request)
    {
        $user_id = \Auth::user()->id;
        $sos_transfer = SosTransfer::find($request->id);
        if($sos_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred sos does not exist'
            ]);
        }
        $sos_transfer->accepted_on =date('Y-m-d H:i:s');
        $accept_sos=$sos_transfer->save();
        if($accept_sos){
            $sos_items = SosTransferItems::select( 'sos_id')
                        ->where('sos_transfer_id',$sos_transfer->id)
                        ->get();
            if($sos_items == null){
               return view('Sos::404');
            }
            $devices=array();
            foreach($sos_items as $sos_item){
                $single_sos_id= $sos_item->sos_id;
                //update sos table
                $sos = Sos::find($single_sos_id);
                $sos->user_id =$user_id;
                $sos->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Sos accepted successfully'
        ]);
    }

    //cancel sos transfer
    public function cancelSosTransfer(Request $request){
        $user_id = \Auth::user()->id;
        $sos_transfer = SosTransfer::find($request->id);
        if($sos_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred sos does not exist'
            ]);
        }
        $cancel_transfer=$sos_transfer->delete();
        if($cancel_transfer){
            $sos_items = SosTransferItems::select( 'sos_id')
                        ->where('sos_transfer_id',$sos_transfer->id)
                        ->get();
            if($sos_items == null){
               return view('Sos::404');
            }
            $devices=array();
            foreach($sos_items as $sos_item){
                $single_sos_id= $sos_item->sos_id;
                //update sos table
                $sos = Sos::find($single_sos_id);
                $sos->user_id =$user_id;
                $sos->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Sos transfer cancelled successfully'
        ]);
    }

    //label for transferred sos
    public function sosTransferLabel(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $decrypted_id = Crypt::decrypt($request->id);
        if($request->user()->hasRole('root')){
            $sos_transfer = SosTransfer::find($decrypted_id);
            $sos_items = SosTransferItems::select('id', 'sos_transfer_id', 'sos_id')
                            ->where('sos_transfer_id',$decrypted_id)
                            ->get();
            $role_details = Dealer::select('id', 'name', 'address','user_id')
                                ->where('user_id',$sos_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            if($sos_transfer == null){
               return view('Sos::404');
            }
           return view('Sos::sos-transfer-label',['sos_transfer' => $sos_transfer,'sos_items' => $sos_items,'role_details' => $role_details,'user_details' => $user_details]);
        }else if($request->user()->hasRole('dealer')){
            $sos_transfer = SosTransfer::find($decrypted_id);
            $sos_items = SosTransferItems::select('id', 'sos_transfer_id', 'sos_id')
                            ->where('sos_transfer_id',$decrypted_id)
                            ->get();
            $role_details = SubDealer::select('id', 'name', 'address','user_id')
                                ->where('user_id',$sos_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            if($sos_transfer == null){
               return view('Sos::404');
            }
           return view('Sos::sos-transfer-label',['sos_transfer' => $sos_transfer,'sos_items' => $sos_items,'role_details' => $role_details,'user_details' => $user_details]);
        }else if($request->user()->hasRole('sub_dealer')){
            $sos_transfer = SosTransfer::find($decrypted_id);
            $sos_items = SosTransferItems::select('id', 'sos_transfer_id', 'sos_id')
                            ->where('sos_transfer_id',$decrypted_id)
                            ->get();
            $role_details = Client::select('id', 'name', 'address','user_id')
                                ->where('user_id',$sos_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            if($sos_transfer == null){
               return view('Sos::404');
            }
           return view('Sos::sos-transfer-label',['sos_transfer' => $sos_transfer,'sos_items' => $sos_items,'role_details' => $role_details,'user_details' => $user_details]);
        }
    }

    public function exportSosTransferLabel(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $sos_transfer_id=$request->id;
        if($request->user()->hasRole('root')){
            $sos_transfer = SosTransfer::find($sos_transfer_id);
            $sos_items = SosTransferItems::select('id', 'sos_transfer_id', 'sos_id')
                            ->where('sos_transfer_id',$sos_transfer_id)
                            ->get();
            $role_details = Dealer::select('id', 'name', 'address','user_id')
                                ->where('user_id',$sos_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            view()->share('sos_transfer',$sos_transfer);
            $pdf = PDF::loadView('Exports::sos-transfer-label',['sos_items' => $sos_items,'role_details' => $role_details,'user_details' => $user_details]);
            $headers = array(
                      'Content-Type'=> 'application/pdf'
                    );
            return $pdf->download('pdfview.pdf',$headers);
        }else if($request->user()->hasRole('dealer')){
            $sos_transfer = SosTransfer::find($sos_transfer_id);
            $sos_items = SosTransferItems::select('id', 'sos_transfer_id', 'sos_id')
                            ->where('sos_transfer_id',$sos_transfer_id)
                            ->get();
            $role_details = SubDealer::select('id', 'name', 'address','user_id')
                                ->where('user_id',$sos_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            view()->share('sos_transfer',$sos_transfer);
            $pdf = PDF::loadView('Exports::sos-transfer-label',['sos_items' => $sos_items,'role_details' => $role_details,'user_details' => $user_details]);
            $headers = array(
                      'Content-Type'=> 'application/pdf'
                    );
            return $pdf->download('pdfview.pdf',$headers);
        }else if($request->user()->hasRole('sub_dealer')){
            $sos_transfer = SosTransfer::find($sos_transfer_id);
            $sos_items = SosTransferItems::select('id', 'sos_transfer_id', 'sos_id')
                            ->where('sos_transfer_id',$sos_transfer_id)
                            ->get();
            $role_details = Client::select('id', 'name', 'address','user_id')
                                ->where('user_id',$sos_transfer->to_user_id)
                                ->first();
            $user_details = User::select('id', 'mobile')
                                ->where('id',$role_details->user_id)
                                ->first();
            view()->share('sos_transfer',$sos_transfer);
            $pdf = PDF::loadView('Exports::sos-transfer-label',['sos_items' => $sos_items,'role_details' => $role_details,'user_details' => $user_details]);
            $headers = array(
                      'Content-Type'=> 'application/pdf'
                    );
            return $pdf->download('pdfview.pdf',$headers);
        }
    }

    public function downloadSosDataTransfer(Request $request){

        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $eid=$request->id;
        $decrypted_id = Crypt::decrypt($request->id);
        $sos = Sos::find($decrypted_id);
        
        if($sos == null){
           return view('Sos::404');
        }

        $pdf = PDF::loadView('Sos::sos-pdf-download',['sos' => $sos]);
        return $pdf->download('abcd.pdf');

    }

    // root sos transfer rule
    public function sosRootTransferRule(){
        $rules = [
          'sos_id' => 'required',
          'dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',];
        return $rules;
    }

    // dealer sos transfer rule
    public function sosDealerTransferRule(){
        $rules = [
          'sos_id' => 'required',
          'sub_dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',];
        return $rules;
    }

    // sub dealer sos transfer rule
    public function sosSubDealerTransferRule(){
        $rules = [
          'sos_id' => 'required',
          'client_user_id' => 'required',
          'scanned_employee_code' => 'required',];
        return $rules;
    }

    //validation for sos creation
    public function sosCreateRules(){
        $rules = [
            'imei' => 'required|numeric|min:15|unique:sos',
            'manufacturing_date' => 'required',
            'brand' => 'required',
            'model_name' => 'required',
            'version' => 'required'
        ];
        return  $rules;
    }

    //validation for sos updation
    public function sosUpdateRules($sos){
        $rules = [
            'imei' => 'required|numeric|min:15|unique:sos,imei,'.$sos->id,
            'manufacturing_date' => 'required',
            'brand' => 'required',
            'model_name' => 'required',
            'version' => 'required',
        ];
        return  $rules;
    } 

}