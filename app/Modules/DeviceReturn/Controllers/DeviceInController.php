<?php
namespace App\Modules\DeviceReturn\Controllers;
use Illuminate\Http\Request;
use App\Modules\Servicer\Models\AppSettings;
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
use App\Modules\Servicer\Models\Complaint;
use Carbon\Carbon;
use App\Modules\Servicer\Models\ServiceCenter;
use App\Modules\Servicer\Models\ServiceParticular;
use App\Modules\Servicer\Models\Component;
use App\Modules\Servicer\Models\ServiceIn;
use App\Modules\Servicer\Models\PcbIn;
use App\Modules\Servicer\Models\PcbComment;
use App\Modules\Servicer\Models\PcbTransfer;
use App\Modules\Employee\Models\Department;

use App\Modules\VltData\Models\VltData;
use DataTables;
use DB;

class DeviceInController extends Controller 
{
    /**
     * 
     * 
     */
    public function create(Request $request)
    {
        $servicer_id        =   \Auth::user()->servicer->id;
        $servicer           =   Servicer::where('id',$servicer_id)->first();
        $date=Date('Y-m-d');
        $serviceCenter = ServiceCenter::get();
        $complaint_type = Complaint::get();
        $service_in = ServiceIn::get();
        if (count($service_in) != 0) {
            $EntryNumber = $this->entry($service_in->last()->id);
        } else {
            $EntryNumber = 'SRV-0001';
        }
        if (count($service_in) != 0) {
            $EntryNumber = $this->entry($service_in->last()->id);
        } else {
            $EntryNumber = 'SRV-0001';
        }
        $imei=$request->imei??"";
         $imeis=array();
        if($imei){
            $imeis=Gps::where('imei', 'like', '%'.$imei.'%') ->get();
         }

      //  $imeis = Gps::get();
        return view('DeviceReturn::device-in-create',['serviceCenter'=>$serviceCenter,'complaint_type' => $complaint_type, 'entry_no' => $EntryNumber, 'imeis' => $imeis]);
    }

    public function entry($id)
    {
        $val = $id + 1;
        $EntryNumber = "SRV-000" . $val;

        return $EntryNumber;
    }

    /**
     * 
     * 
     * 
     */
    public function save(Request $request)
    {

        $date=Date('Y-m-d');
       
        if ($request->warranty == '') {
            $warranty = 0;
        } else {
            $warranty = 1;
        }
        if ($request->is_renewal == '') {
            $renewal = 0;
        } else {
            $renewal = 1;
        }
        if ($request->is_dealer == 'Dealer') {
            $is_dealer = 1;
        } else {
            $is_dealer = 0;
        }

        $re = AppSettings::findorfail(1);

        if ($request->is_dealer == 'Dealer' && $request->is_renewal == true) {

            $toto = $re->DealerRenewAmount;
        } else if ($request->is_dealer == 'Customer' && $request->is_renewal == true) {
            $toto = $re->CusomerRenewAmount;
        } else {
            $toto = 0;
        }
        $service = new ServiceIn();
        $service->date = Carbon::parse($date)->toDateTimeString();
        $service->installation_date = Carbon::parse($date)->toDateTimeString();
        $service->service_center_id = $request->service_center_id;
        $service->status = 'servicein';
        $service->warranty = $warranty;
        $service->is_renewal = $renewal;
        $service->is_dealer = $is_dealer;
        $service->vehicle_no = $request->vehicle_no;
        $service->total = $toto;
        $service->serial_no = $request->slno;
        $service->entry_no = $request->entry_no;
        $service->imei = $request->imei;
        $service->customer_name = $request->customername;
        $service->address = $request->address;
        $service->customermobile = $request->customermobile;
        $service->dealermobile = $request->dealermobile;
        $service->dealer_name = $request->dealername;
        $service->complaint_type = $request->complaint_type;
        $service->comments = $request->comments;
        $service->msisdn = $request->msisdn;
        $service->sim1 = $request->sim1;
        $service->sim2 = $request->sim2;
        $save = $service->save();
        $message = "Dear Customer,
        Your GPS device has been received for service.
        VST Mobility Solutions.";
        $template_id = "1107166788618155856";
        if ($save) {
          //  (new SendSmsController)->sendmessage($message, $request->customermobile, $template_id);
        }

        return redirect(route('devicein')); 
    }

    /**
     * 
     * 
     */
    public function deviceListPage()
    {
        return view('DeviceReturn::device-in-list');   
    } 
    
    

    ///pcvb

    public function pcbListPage()
    {
        return view('DeviceReturn::pcb-in-list');   
    } 


    public function getPcbList()
    {

        if( \Auth::user()->operations){
            $operation_id=\Auth::user()->operations->id;
            $service_center_id=\Auth::user()->operations->service_center_id;
            $service_in = PcbIn::orderby('created_at', 'desc')->where('service_center_id',$service_center_id)->where('status', '!=', 'cancelled')->where('status', '!=', 'delivered')->get();
       
        }else{
            $service_in = PcbIn::orderby('created_at', 'desc')->where('status', '!=', 'cancelled')->where('status', '!=', 'delivered')->get();
       
        }
      return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('status', function ($service_in) { 
          
         if($service_in->status=="servicein"){
                return "service In";
            }
            else if($service_in->status=="sendtodelivery")
            {
                return "sendtodelivery";
            }
            else 
            {
                return "completed";
            }
                        
        })
            
        ->addColumn('action', function ($service_in){
            $b_url = \URL::to('/');
            if($service_in->status == "servicein")
            {
                return "
                <a href=".$b_url."/view-pcb-in/".Crypt::encrypt($service_in->id)."   class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                 </button>
                 <a data-toggle='modal' data-target='#myModal' onclick='setvalue(".$service_in->id.")' class='btn btn-light-grey btn-xs text-black'><i class='fa fa-paper-plane' aria-hidden='true'></i></a>
                 ";
            }
            else
            {
                return "
                <a href=".$b_url."/view-pcb-in/".Crypt::encrypt($service_in->id)."   class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
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
    public function getDeviceList()
    {

        if( \Auth::user()->operations){
            $operation_id=\Auth::user()->operations->id;
            $service_center_id=\Auth::user()->operations->service_center_id;
            $service_in = ServiceIn::orderby('created_at', 'desc')->where('service_center_id',$service_center_id)->where('status', '!=', 'cancelled')->where('status', '!=', 'delivered')->get();
       
        }else{
            $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', '!=', 'cancelled')->where('status', '!=', 'delivered')->get();
       
        }
      return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('status', function ($service_in) { 
          
         if($service_in->status=="servicein"){
                return "Device In";
            }
            else if($service_in->status=="sendtodelivery")
            {
                return "Send to Delivery";
            }
            else if($service_in->status=="sendtoservice")
            {
                return "Send to Service";
            }
            else if($service_in->status=="sendtocustomercare")
            {
                return "Customer Care";
            }
            else if($service_in->status=="customerapproved")
            {
                return "Customer Approved";
            }
            else 
            {
                return ucfirst($service_in->status);
            }
                        
        })
            
        ->addColumn('action', function ($service_in){
            $b_url = \URL::to('/');
            if($service_in->status == "servicein")
            {
                return "
                <a href=".$b_url."/view-device-in/".Crypt::encrypt($service_in->id)."   class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                 </button>
                 <a data-toggle='modal' data-target='#myModal' onclick='setvalue(".$service_in->id.")' class='btn btn-light-grey btn-xs text-black'><i class='fa fa-paper-plane' aria-hidden='true'></i></a>
                 ";
            }
            else
            {
                return "
                <a href=".$b_url."/view-device-in/".Crypt::encrypt($service_in->id)."   class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
        
    }
    /**
     * device return details view
     * 
     */
    public function getdeviceReturnListView(Request $request)
    {
        $decrypted_device_return_id     =   Crypt::decrypt($request->id); 
        $device_return_details          =   (new DeviceReturn())->getSingleDeviceReturnDetailsWithTrashedItem($decrypted_device_return_id); 
        if($device_return_details == null)
        {
            return view('DeviceReturn::404');
        }
        return view('DeviceReturn::device-return-servicer-view',['device_return_details' => $device_return_details]);
    }

    /**
     * 
     * 
     * 
     */
    public function selectVehicle(Request $request)
    {
        $client_id                              =   $request->client_id;
        $device_returned_with_submitted_status  =   DeviceReturn::select('gps_id')
                                                        ->where('client_id',$client_id)
                                                        ->where('status','!=',1)
                                                        ->pluck('gps_id');
        $non_returned_device_vehicles           =   (new Vehicle())->getNonReturnedDeviceVehiclesOfClient($client_id,$device_returned_with_submitted_status);
        if($non_returned_device_vehicles == null)
        {
            return response()->json([
                'vehicle' => '',
                'message' => 'no vehicle found'
            ]);
        }else
        {
            return response()->json([
                    'vehicle' => $non_returned_device_vehicles,
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
                'message' => 'not a logged in service engineer'
            ]);
        }
        else if($device_return->status  == 2)
        {
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Device return request is already accepted'
            ]);
        }
        else if($device_return->status  == 0)
        {
            $device_return->status=1;
            $device_return->save();
            $device_return=$device_return->delete();
            return response()->json([
                'status' => 1,
                'title' => 'Success',
                'message' => 'Device return request Cancelled successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Something went wrong!'
            ]);
        }
    }
    /**
     * Accept device return
     * 
     */
    public function acceptDeviceReturn(Request $request)
    {
        $device_return                  =   (new DeviceReturn())->getSingleDeviceReturnDetails($request->id);
        if($device_return)
        {
            if($device_return->status       ==   0)
            {
                $device_return->status      =   2;
                $device_return->save();
            
                $gps_data                   =   (new Gps())->getGpsDetails($device_return->gps_id);
                $gps_data_in_stock          =   (new GpsStock())->getSingleGpsStockDetails($device_return->gps_id);
                $gps_in_vehicle             =   (new Vehicle())->getSingleVehicleDetailsBasedOnGps($device_return->gps_id);

                //old data stored in a variable for creating new row
                $imei                       =   $gps_data->imei;
                $serial_no                  =   $gps_data->serial_no;
                $imei_split_position        =   strpos($imei,"-RET");
                $serial_no_split_position   =   strpos($serial_no,"-RET");
                if($imei_split_position)
                {
                    $imei                   =   substr($imei,0,$imei_split_position);
                }
                if($serial_no_split_position)
                {
                    $serial_no              =   substr($serial_no,0,$serial_no_split_position);
                }
                $gps_find_imei_and_slno     =   (new Gps())->getCountBasedOnImeiAndSerialNo($imei,$serial_no); 
                $imei_incremented           =   $imei."-RET-".$gps_find_imei_and_slno;
                $serial_no_incremented      =   $serial_no."-RET-". $gps_find_imei_and_slno;
                
                //To update returned status in gps table
                $gps_data->imei             =   $imei_incremented;
                $gps_data->serial_no        =   $serial_no_incremented;
                $gps_data->is_returned      =   1;
                $gps_data->save();

                //To update returned status in gps stock table
                $gps_data_in_stock->is_returned      =    1;
                $gps_data_in_stock->returned_on      =    date('Y-m-d H:i:s');
                $gps_data_in_stock->save();

                //To update returned status in vehicle table
                $gps_in_vehicle->is_returned                    =    1;
                $gps_in_vehicle->is_reinstallation_job_created  =    0;
                $gps_in_vehicle->save();         

                //Update gps removed date on vehicle gps log table
                $vehicle_gps_log                    =   (new VehicleGps())->getVehicleGpsLog($gps_in_vehicle->id,$device_return->gps_id);
                $vehicle_gps_log->gps_removed_on    =   date('Y-m-d H:i:s');
                $vehicle_gps_log->save();

                //delete all assigned geofences of returned vehicle
                $is_deleted_assigned_vehicle_geofence   =   (new VehicleGeofence())->getGeofenceAssignedVehicleDatas($gps_in_vehicle->id);

                //To update imei in vlt data table
                $vlt_Data                               =    (new VltData())->vltDataImeiUpdation($imei,$imei_incremented);     
                
                //To update imei in vlt data archived table
                DB::table('vlt_data_archived')->where('imei',$imei)->update([
                        'imei' =>  $imei_incremented,
                    ]);

                //To update imei in gps data table
                $gps_data_tables                    =   (new GpsData())->getGpsDataTable();
                foreach($gps_data_tables as $table_name)
                {
                    DB::table($table_name->table_name)->where('imei',$imei)->update([
                        'imei' =>  $imei_incremented,
                    ]);
                }

                //To update returned status in gps transfer items table
                $gps_in_transfer_items      =   (new GpsTransferItems())->updateReturnStatusInTrasferItem($device_return->gps_id);
                $manufacturer_details       =   (new Root())->getManufacturerDetails(\Auth::user()->root->id);
                $activity                   =   'Manufacturer ('.$manufacturer_details->name.') accepted the device return '.$device_return->return_code;
                (new DeviceReturnHistory())->addHistory($device_return->id, $activity);

                return response()->json([
                    'status' => 1,
                    'title' => 'Success',
                    'message' => 'Device return request accepted successfully'
                ]);
            }
            else if($device_return->status       ==   2)
            {
                return response()->json([
                    'status' => 2,
                    'title' => 'Failed',
                    'message' => 'Device return request is already accepted'
                ]);
            }
            else if($device_return->status       ==   1)
            {
                return response()->json([
                    'status' => 3,
                    'title' => 'Failed',
                    'message' => 'Device return request is already cancelled'
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 0,
                    'title' => 'Failed',
                    'message' => 'Something went wrong!'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status' => 3,
                'title' => 'Failed',
                'message' => 'Device return request is already cancelled'
            ]);
        }
        
        
        
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
            if($device_return->status == 0)
            {
                return "Submitted";
            }
            else if($device_return->status == 1)
            {
                return "Cancelled";
            } 
            else if($device_return->status == 2)
            {
                return "Accepted";
            }        
        })
        ->addColumn('action', function ($device_return) { 
            if($device_return->status == 1)
            {
                return "
                <a href=/device-return/".Crypt::encrypt($device_return->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            }
            else
            {
                return "
                <a href=/device-return-detail-view/".Crypt::encrypt($device_return->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            }
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

        $device_to_gps_table        =   (new Gps())->createRefurbishedGps($imei,$serial_no,$manufacturing_date,$icc_id,$imsi,$e_sim_number,$batch_number,$employee_code,$model_name,$version);
        $root_id                    =   \Auth::user()->root->id;
        if($device_to_gps_table)
        {
            (new GpsStock())->createRefurbishedGpsInStock($device_to_gps_table->id,$root_id);
            $stock_summary          =   (new DeviceReturnHistory())->addHistory($device_return_id, $activity);
            if($stock_summary)
            {
                (new DeviceReturnHistory())->addHistory($device_return_id, $custom_activity);
            }
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

    public function ViewServiceIn($id)
    {
        $id= Crypt::decrypt($id);
      
        $servicein = ServiceIn::with(['type'])->with(['particulars', 'particulars.products'])->findorfail($id);
        $products = Component::get();
        $appsettings = AppSettings::findorfail(1);
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }
        return view('DeviceReturn::viewdevicein')->with(['servicein' => $servicein, 'products' => $products, 'renewalcharge' => $renewalcharge]);
    }



    public function ViewPCBIN($id)
    {

        $department_id= \Auth::user()->employee->department_id;
        $id= Crypt::decrypt($id);
        $servicein = PcbIn::with(['type'])->with(['particulars', 'particulars.products'])->findorfail($id);
        $products = Component::get();
        $appsettings = AppSettings::findorfail(1);
        $department = Department::orderby('created_at', 'desc')->where('parent_id','!=','')->get();
        //$department = Department::orderby('created_at', 'desc')->get();
        $comments = PcbComment::orderby('created_at', 'desc')->where('pcb_id',$id)->get();
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }
        return view('DeviceReturn::viewpcbin')->with(['servicein' => $servicein, 'products' => $products,
        'department'=>$department,'comments'=>$comments,'emp_depart'=>$department_id]);
    }




    public function Status(Request $request)
    {
        $id=$request->id;
        $status=$request->status;
        $service = ServiceIn::findorfail($id);
        $service->status = $status;
        $status = $service->save();
        if ($status) {
            return response()->json(['status' => true, 'message' => 'Status Changed']);
        } else {
            return response()->json(['status' => false, 'message' => 'Somthing Went Wrong']);
        }
    }


    public function productionindex()
    {
        return view('DeviceReturn::device-service-list');   
    }

    public function GetIndexProduction()
    {

        if( \Auth::user()->operations){
            $operation_id=\Auth::user()->operations->id;
            $service_center_id=\Auth::user()->operations->service_center_id;
            $service_in = ServiceIn::orderby('created_at', 'desc')->where('service_center_id',$service_center_id)->whereIn('status', ['sendtoservice','customerapproved','completed'])->get();
       
        }else{
            $service_in = ServiceIn::orderby('created_at', 'desc')->whereIn('status', ['sendtoservice','customerapproved','completed'])->get();
       
        }
      return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('status', function ($service_in) { 
          
         if($service_in->status=="sendtoservice"){
                return "Service";
            }
            else if($service_in->status=="sendtodelivery")
            {
                return "sendtodelivery";
            }
            else 
            {
                return $service_in->status;
            }
                        
        })
            
        ->addColumn('action', function ($service_in){
            $b_url = \URL::to('/');
            if($service_in->status == "sendtoservice")
            {
                return "
                <a href=".$b_url."/view-device-in/".Crypt::encrypt($service_in->id)." class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                 </button>
                 <a style='margin-left:3%;' class='btn btn-primary'  href=".$b_url."/add-products-view/".$service_in->id." 'type='button'>Add</a>";
                 
            }
            else
            {
                return "
                <a href=".$b_url."/view-device-in/".Crypt::encrypt($service_in->id)."class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function AddProductsView($id)
    {
        $servicein = ServiceIn::with(['type'])->with(['particulars', 'particulars.products'])->findorfail($id);
        $products = Component::get();
       
        $appsettings = AppSettings::findorfail(1);
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }

        return view('DeviceReturn::addcomponentsview',['servicein' => $servicein, 'products' => $products, 'renewalcharge' => $renewalcharge]);
   
       // return view('DeviceReturn::addcomponentsview')->with();
    }
    public function getproduct($id)
    {
        $product = Component::findorfail($id);
        return $product;
    }
    public function select2products(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $employees = Component::orderby('name', 'asc')->select('id', 'name')->limit(5)->get();
        } else {
            $employees = Component::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($employees as $employee) {
            $response[] = array(
                "id" => $employee->id,
                "text" => $employee->name
            );
        }
        return response()->json($response);
    }

    public function AddProducts($id, Request $request)
    {
        $servicein = ServiceIn::findorfail($id);
        $servicein->status='sendtodelivery';
        $servicein->save();
        $del = ServiceParticular::where('service_in_id', $id);

        if (count($del->get()) != 0) {
            try {
                ServiceParticular::where('service_in_id', $id)->delete();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        $i = 0;
        $totaltotal = 0;
        $totaltax = 0;
        $totalgross = 0;
        if ($request->productids != '') {
            foreach ($request->productids as $ids) {

                $products = Component::findorfail($ids);
                $particular = new ServiceParticular();
                $particular->service_in_id = $id;
                $particular->product_id = $ids;
                $particular->qty = $request->quantity[$i];
                $particular->comments = $request->comments[$i];
                $particular->price = $products->price;
                $particular->gross = $products->price * $request->quantity[$i];
                $particular->tax = $products->gst * $request->quantity[$i];
                $particular->total = ($products->price * $request->quantity[$i]) + ($products->gst * $request->quantity[$i]);
                $particular->save();
                $totaltotal += ($products->price * $request->quantity[$i]) + ($products->gst * $request->quantity[$i]);

                $totaltax += $products->gst * $request->quantity[$i];
                $totalgross += $products->price * $request->quantity[$i];
                $i++;
            }
        }
        $re = AppSettings::findorfail(1);
        $servicein = ServiceIn::findorfail($id);
        if ($servicein->is_dealer == true && $servicein->is_renewal == true) {

            $toto = $totaltotal + $re->DealerRenewAmount;
        } else if ($servicein->is_dealer == false && $servicein->is_renewal == true) {
            $toto = $totaltotal + $re->CusomerRenewAmount;
        } else {
            $toto = $totaltotal;
        }
        $servicein->total = $toto;

        // $servicein->total = $totaltotal;
        $servicein->tax = $totaltax;
        $servicein->gross = $totalgross;
        $servicein->save();
        return redirect('device-service');
    }
    public function pcbTransfer(Request $request)
    {
        
        $emp_department_id= \Auth::user()->employee->department_id;
        $id=$request->id;
        $servicein = PcbIn::findorfail($id);
        
        $comments=$request->comments??'';
        $department_id=$request->department_id??'';
        $pcbcomment = new PcbComment();
        $pcbcomment->pcb_id = $id;
        $pcbcomment->comments =$comments;
        $pcbcomment->employee_id =  \Auth::user()->employee->id;

      
        $pcbcomment->save();
        if( $emp_department_id==199 && $servicein->status=="requested" ){
            $servicein->quote_total=$request->quote_total??'';
            $servicein->save();

            $dataArray = array(
                "mongo_id "=>$servicein->mongo_id,
                "quote_total"=>$request->quote_total
            );
            //$result=$this->nodefunction($dataArray);
            //api for pcb design
            
        }
        
        $pcbtransfer = new PcbTransfer();
        $pcbtransfer->pcb_id = $id;
        $pcbtransfer->department_id =$department_id;
        $pcbtransfer->save();
        return redirect('pcbin');
    }
    public function nodefunction($dataArray){

        $url = "https://esim.vstmobility.com/api/insert";
 
        $new_data = json_encode($dataArray);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Content-Length: " . strlen($new_data)
            ],
            CURLOPT_POSTFIELDS => $new_data,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return  curl_error($ch);
        } else {
          return $response;
        }    

    }


}
