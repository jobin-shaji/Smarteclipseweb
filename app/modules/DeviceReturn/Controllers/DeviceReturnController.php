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
        $rules                      =   $this->device_return_create_rules();
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
        $imei                       =   $gps_data->imei;
        $serial_no                  =   $gps_data->serial_no;
        $manufacturing_date         =   $gps_data->manufacturing_date;
        $icc_id                     =   $gps_data->icc_id;
        $imsi                       =   $gps_data->imsi;
        $e_sim_number               =   $gps_data->e_sim_number;
        $batch_number               =   $gps_data->batch_number;
        $employee_code              =   $gps_data->employee_code;
        $model_name                 =   $gps_data->model_name;
        $version                    =   $gps_data->version;
    
        $imei_RET                   =   $gps_data->imei."-RET-" ;
        $serial_no_RET              =   $gps_data->serial_no."-RET-" ;
        $gps_find_imei_and_slno     =   Gps::where('imei', 'like','%'.$imei_RET.'%')
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

        //To update imei in gps data table
        // $gps_data                   =   GpsData::where('imei',$imei)->update([
        //                                     'imei' =>  $imei_incremented,
        //                                 ]);
                
        //To update imei in vlt data table
        $vlt_Data                   =   VltData::where('imei',$imei)->update([
                                            'imei' =>  $imei_incremented,
                                        ]);
        //To update imei in vlt data archived table
        DB::table('vlt_data_archived')->where('imei',$imei)->update([
                'imei' =>  $imei_incremented,
            ]);

        //To update returned status in gps transfer items table
        $gps_in_transfer_items      =   GpsTransferItems::where('gps_id',$device_return->gps_id)->update([
                                            'is_returned' =>  1,
                                        ]);
        $manufacturer_details       =   (new Root())->getManufacturerDetails(\Auth::user()->root->id);
        $activity                   =   'Manufacturer ('.$manufacturer_details->name.') accepted the device return '.$device_return->return_code;
        (new DeviceReturnHistory())->addHistory($device_return->id, $activity);

        //to create new row with returned gps
        // $gps    =   Gps::create([
        //                 'serial_no'         =>  $serial_no,
        //                 'icc_id'            =>  $icc_id,
        //                 'imsi'              =>  $imsi,
        //                 'imei'              =>  $imei,
        //                 'manufacturing_date'=>  $manufacturing_date,
        //                 'e_sim_number'      =>  $e_sim_number,
        //                 'batch_number'      =>  $batch_number,
        //                 'model_name'        =>  $model_name,
        //                 'version'           =>  $version,
        //                 'employee_code'     =>  $employee_code,
        //                 'status'            =>  1
        //             ]); 
        //to get user id of manufacture
        // $root_id    =   \Auth::user()->id;
        // $gps_stock  =   GpsStock::create([
        //                     'gps_id'=> $gps->id,
        //                     'inserted_by' => $root_id
        //                 ]); 
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
        $device_return_history_details  =   (new DeviceReturnHistory())->getTransferHistory($decrypted_device_return_id); 
        return view('DeviceReturn::device-return-view',['device_return_details' => $device_return_details, 'device_return_history_details' => $device_return_history_details]);
    }

    public function device_return_create_rules()
    {
        $rules = 
        [
            'gps_id'            => 'required',       
            'type_of_issues'    =>  'required',
            'comments'          => 'required|max:500'
        ];
        return  $rules;
    }
}
