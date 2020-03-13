<?php
namespace App\Modules\DeviceReturn\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use App\Modules\Root\Models\Root;
use Illuminate\Support\Facades\Crypt;
use App\Modules\DeviceReturn\Models\DeviceReturn;
use App\Modules\DeviceReturn\Models\DeviceReturnHistory;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Trader\Models\Trader;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\VltData\Models\VltData;
use DataTables;
use DB;

class DeviceReturnController extends Controller 
{
    /**
     * 
     * 
     */
    public function create()
    {
        $servicer_id        =   \Auth::user()->servicer->id;
        $servicer           =   Servicer::where('id',$servicer_id)->first();
        if($servicer->sub_dealer_id == null && $servicer->trader_id == null) 
        {
            $client         =   Client::orderBy('name')->get();
        }
        else if($servicer->trader_id != null&& $servicer->sub_dealer_id== null)
        {
            $trader_id      =   $servicer->trader_id;
            $client         =   Client::where('trader_id',$trader_id)->get();
            
        } 
        else if($servicer->trader_id == null && $servicer->sub_dealer_id!= null)
        {
            $client         =   Client::where('sub_dealer_id',$servicer->sub_dealer_id)->get();
    
        }
        return view('DeviceReturn::device-return-create',['client'=>$client]);
    }

    /**
     * 
     * 
     * 
     */
    public function save(Request $request)
    {
        $servicer_id                =   \Auth::user()->servicer->id;
        $rules                      =   $this->deviceReturnCreateRules();
        $this->validate($request, $rules);

        $existing_gps_return_count  =   (new DeviceReturn())->gpsReturnedCount($request->gps_id);
        if($existing_gps_return_count > 0)
        {
            $request->session()->flash('message', 'Device already returned!'); 
            $request->session()->flash('alert-class', 'alert-danger'); 
        }
        else
        {
            $return_code                    =   'RT'.date('ymdhis');
            //to check return code is already exists in table
            $existing_return_code_count     =   (new DeviceReturn())->gpsReturnCodeCount($return_code);
            if($existing_return_code_count  > 0)
            {
                $return_code                =   'RT'.date('ymdhis').($existing_return_code_count+1);
            }
            $device_return                  =   (new DeviceReturn())->createNewDeviceForReturn($return_code,$request->gps_id,$request->type_of_issues,$request->comments,$servicer_id,$request->client_id);
            // add to history
            if($device_return)
            {
                $servicer_details           =   (new Servicer())->getServicerDetails($servicer_id);
                $client_details             =   (new Client())->getClientDetails($request->client_id);
                $gps_details                =   (new Gps())->getGpsDetails($request->gps_id);
                $servicer_name              =   $servicer_details->name;
                $gps_imei                   =   $gps_details->imei;
                $gps_serial_number          =   $gps_details->serial_no;
                $client_name                =   $client_details->name;
                $activity                   =   $servicer_name.' returned the device '.$gps_imei.'(IMEI), '.$gps_serial_number.'(Serial Number)'.' for the client '.$client_name;
                (new DeviceReturnHistory())->addHistory($device_return->id, $activity);
            }
            $request->session()->flash('message', 'New device return request registered successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
        }         
        return redirect(route('device')); 
    }

    /**
     * 
     * 
     */
    public function DeviceReturnListPage()
    {
        return view('DeviceReturn::device-return-list');   
    }  

    /**
     * 
     * 
     * 
     */
    public function getDeviceList()
    {
        $device_return = DeviceReturn::select(
                'id', 
                'gps_id',                      
                'type_of_issues',
                'comments',                                        
                'created_at',
                'servicer_id',
                'status',
                'deleted_at'
            )
            ->withTrashed()
            ->with('gps:id,imei,serial_no')
            ->orderBy('id','desc');
            $servicer_id        =   \Auth::user()->servicer->id;
            $device_return      =   $device_return->where('servicer_id',$servicer_id)->get();
            return DataTables::of($device_return)
            ->addIndexColumn()
            ->addColumn('comments', function ($device_return) { 
                $str            =   mb_strimwidth("$device_return->comments", 0, 20, "...");
                return $str;
            })
            ->addColumn('type_of_issues', function ($device_return) { 
                if($device_return->type_of_issues==0)
                {
                    return "Hardware";
                }
                else 
                {
                    return "software";
                }
            })
            ->addColumn('status', function ($device_return) { 
                if($device_return->status == 1 && $device_return->deleted_at != NULL ){
                    return "Cancelled";
                }
                else if($device_return->status==0){
                    return "Submitted";
                }
                else
                {
                    return "Accepted";
                }
                            
            })
                
            ->addColumn('action', function ($device_return){
                if($device_return->status == 0)
                {
                    return "
                    <button onclick=cancelDeviceReturn(".$device_return->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
                    </button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
        
    }

    /**
     * 
     * 
     * 
     */
    public function selectVehicle(Request $request)
    {
        $client_id=$request->client_id;
        $device_gps_id=DeviceReturn::select('gps_id')
                    ->where('client_id',$client_id)
                    ->where('status','!=',1)
                    ->pluck('gps_id');
        $vehicle=GpsStock::select(
                            'gps_id',
                            'client_id')
                    ->with('gps')
                    ->where('client_id',$client_id)
                    ->whereNotIn('gps_id',$device_gps_id)
                    ->with('deviceReturn:gps_id,status')
                    ->get();
        if($vehicle== null){
            return response()->json([
                'vehicle' => '',
                'message' => 'no vehicle found'
            ]);
        }else
        {
            return response()->json([
                    'vehicle' => $vehicle,
            ]);
        }
    }
    /**
     * 
     * 
     */
    public function cancelDeviceReturn(Request $request)
    {
        $device_return      =   DeviceReturn::find($request->id);
        $servicer_id        =   \Auth::user()->servicer->id;

        if($device_return->servicer_id  != $servicer_id)
        {
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'not a logged in servicer'
            ]);
        }
        else
        {
            $device_return->status=1;
            $device_return->save();
            $device_return=$device_return->delete();
            return response()->json([
                'status' => 1,
                'title' => 'Success',
                'message' => 'Device return Cancelled successfully'
            ]);
        }
    }
    /**
     * Accept device return
     * 
     */
    public function acceptDeviceReturn(Request $request)
    {
        $device_return              =   (new DeviceReturn())->getSingleDeviceReturnDetails($request->id);
        $device_return->status      =   2;
        $device_return->save();
        $gps_data                   =   (new Gps())->getGpsDetails($device_return->gps_id);
        $gps_data_in_stock          =   (new GpsStock())->getSingleGpsStockDetails($device_return->gps_id);
        $gps_in_vehicle             =   (new Vehicle())->getSingleVehicleDetailsBasedOnGps($device_return->gps_id)->first();

        //old data stored in a variable for creating new row
        $imei                       =    $gps_data->imei;
        $serial_no                  =    $gps_data->serial_no;
        $imei_RET                   =    $gps_data->imei."-RET-" ;
        $serial_no_RET              =    $gps_data->serial_no."-RET-" ;
        $gps_find_imei_and_slno     =    Gps::where('imei', 'like','%'.$imei_RET.'%')
                                        ->where('serial_no', 'like', '%'.$serial_no_RET.'%')
                                        ->count();        
        $increment_value            =    $gps_find_imei_and_slno +1;
        $imei_incremented           =    $imei."-RET-"."".$increment_value;
        $serial_no_incremented      =    $serial_no."-RET-"."". $increment_value;
        
        //To update returned status in gps table
        $gps_data->imei             =    $imei_incremented;
        $gps_data->serial_no        =    $serial_no_incremented;
        $gps_data->is_returned      =    1;
        $gps_data->save();

        //To update returned status in gps stock table
        $gps_data_in_stock->is_returned      =    1;
        $gps_data_in_stock->save();

        //To update returned status in vehicle table
        $gps_in_vehicle->is_returned         =    1;
        $gps_in_vehicle->save();         
                
        //To update imei in vlt data table
        $vlt_Data                            =    (new VltData())->vltDataImeiUpdation($imei,$imei_incremented);     
        
        //To update imei in vlt data archived table
        DB::table('vlt_data_archived')->where('imei',$imei)->update([
                'imei' =>  $imei_incremented,
            ]);

        //To update returned status in gps transfer items table
        $gps_in_transfer_items      =   (new GpsTransferItems())->updateReturnStatusInTrasferItem($device_return->gps_id);
        $manufacturer_details       =   (new Root())->getManufacturerDetails(\Auth::user()->root->id);
        $activity                   =   'Manufacturer ('.$manufacturer_details->name.') accepted the device return '.$device_return->return_code;
        (new DeviceReturnHistory())->addHistory($device_return->id, $activity);

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Device return Accepted successfully'
            ]);
        
    }
    /**
     * for device return list in root
     * 
     */
    public function deviceReturnRootHistoryList()
    {
        return view('DeviceReturn::device-return-root-history-list');
    }
    public function getdeviceReturnRootHistoryList()
    {
        $device_return  =   (new DeviceReturn())->getDeviceReturnDetailsForRootList();
        return DataTables::of($device_return)
        ->addIndexColumn()
        ->addColumn('sub_dealer', function ($device_return) { 
            if($device_return->servicer->sub_dealer_id == NULL && $device_return->servicer->trader_id != NULL)
            {
                return $device_return->servicer->Trader->name;
            }
            else
            {
                return "--";
            }        
        })
        ->addColumn('dealer', function ($device_return) { 
            if($device_return->servicer->sub_dealer_id != NULL && $device_return->servicer->trader_id == NULL)
            {
                return $device_return->servicer->subDealer->name;
            }
            else if($device_return->servicer->sub_dealer_id == NULL && $device_return->servicer->trader_id != NULL)
            {
                return $device_return->servicer->Trader->subDealer->name;
            }
            else 
            {
                return "--";
            }        
        })
        ->addColumn('distributor', function ($device_return) { 
            if($device_return->servicer->sub_dealer_id != NULL && $device_return->servicer->trader_id == NULL)
            {
                return $device_return->servicer->subDealer->dealer->name;
            }
            else if($device_return->servicer->sub_dealer_id == NULL && $device_return->servicer->trader_id != NULL)
            {
                return $device_return->servicer->Trader->subDealer->dealer->name;
            }
            else 
            {
                return "--";
            }        
        })
        ->addColumn('status', function ($device_return) { 
            if($device_return->status==0)
            {
                return "Submitted";
            }
            else{
                return "Accepted";
            }        
        })
        ->addColumn('action', function ($device_return) { 
            return "
            <a href=/device-return-detail-view/".Crypt::encrypt($device_return->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    
    /**
     * device return details view
     * 
     */
    public function deviceReturnDetailView(Request $request)
    {
        $decrypted_device_return_id     =   Crypt::decrypt($request->id); 
        $device_return_details          =   (new DeviceReturn())->getSingleDeviceReturnDetails($decrypted_device_return_id); 
        if($device_return_details == null)
        {
            return view('DeviceReturn::404');
        }
        $returned_imei                  =   $device_return_details->gps->imei;
        $original_imei                  =   substr($returned_imei, 0, strpos($returned_imei, '-'));
        $to_check_imei_exists           =   (new Gps())->getGpsId($original_imei);
        $device_return_history_details  =   (new DeviceReturnHistory())->getTransferHistory($decrypted_device_return_id); 
        return view('DeviceReturn::device-return-view',['device_return_details' => $device_return_details, 'device_return_history_details' => $device_return_history_details , 'to_check_imei_exists' => $to_check_imei_exists]);
    }

    public function addNewActivity(Request $request)
    {
        $device_return_id               =   $request->device_return_id;
        $activity                       =   $request->activity;
        $add_activity                   =   (new DeviceReturnHistory())->addHistory($device_return_id, $activity);
        if($add_activity)
        {
            $response    =  array(
                'status'        =>  1,
                'message'       =>  'Added note successfully'
            );
        }
        else
        {
            $response    =  array(
                'status'    =>  0,
                'message'   =>  'Something went wrong!'
            );
        }
        return response()->json($response);
    }

    public function addToStockInDeviceReturn(Request $request)
    {
        $device_return_id       =   Crypt::decrypt($request->id);
        $device_return_details  =   (new DeviceReturn())->getSingleDeviceReturnDetails($device_return_id);
        return view('DeviceReturn::add-returned-device-to-stock',['device_return_details' => $device_return_details]);
    }

    public function proceedReturnedDeviceToStock(Request $request)
    {
        $rules                      =   $this->gpsCreateRules();
        $this->validate($request, $rules); 
        $device_return_id           =   $request->device_return_id;
        $return_code                =   $request->return_code;
        $imei                       =   $request->imei;
        $serial_no                  =   $request->serial_no;
        $manufacturing_date         =   date('Y-m-d', strtotime($request->manufacturing_date));
        $icc_id                     =   $request->icc_id;
        $imsi                       =   $request->imsi;
        $e_sim_number               =   $request->e_sim_number;
        $batch_number               =   $request->batch_number;
        $employee_code              =   $request->employee_code;
        $model_name                 =   $request->model_name;
        $version                    =   $request->version;
        $activity                   =   $request->activity;
        $custom_activity            =   'Refurbished device added to stock by '.$employee_code.' and '.$return_code.' is closed';

        $device_to_gps_table        =   (new Gps())->createNewGps($imei,$serial_no,$manufacturing_date,$icc_id,$imsi,$e_sim_number,$batch_number,$employee_code,$model_name,$version);
        $root_id                    =   \Auth::user()->root->id;
        if($device_to_gps_table)
        {
            (new GpsStock())->createNewGpsInStock($device_to_gps_table->id,$root_id);
            (new DeviceReturnHistory())->addHistory($device_return_id, $activity);
            (new DeviceReturnHistory())->addHistory($device_return_id, $custom_activity);
        }
        $request->session()->flash('message', 'GPS added to stock successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('device.return.detail.view',Crypt::encrypt($device_return_id)));
    }

    public function deviceReturnCreateRules()
    {
        $rules = 
        [
            'gps_id'            => 'required',       
            'type_of_issues'    =>  'required',
            'comments'          => 'required|max:500'
        ];
        return  $rules;
    }

    //validation for gps creation
    public function gpsCreateRules()
    {
        $rules = [
            'employee_code'     => 'required', 
            'activity'          => 'required'         
        ];
        return  $rules;
    }
}
