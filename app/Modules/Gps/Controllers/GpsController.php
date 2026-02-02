<?php
namespace App\Modules\Gps\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Imports\KsrtcImport;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\Otp;
use App\Modules\Gps\Models\KsrtcCmc;
use App\Modules\Gps\Models\KsrtcRenew;

use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Gps\Models\GpsLocation;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\Esim;
use App\Modules\Gps\Models\GpsLog;
use App\Modules\Gps\Models\GpsWarranty;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Gps\Models\VltData;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use App\Modules\Subscription\Models\Plan;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Gps\Models\GpsModeChange;
use App\Modules\Ota\Models\OtaResponse;
use App\Modules\Ota\Models\OtaUpdates;
use App\Modules\Gps\Models\GpsConfiguration;
use App\Modules\Gps\Models\GpsOrder;
use App\Modules\Esim\Models\SimActivationDetails;
use App\Modules\Esim\Models\EsimUploadFile;



use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\MqttTrait;
use DataTables;
use DB;
use Config;
use App\Modules\Servicer\Models\ServiceIn;

class GpsController extends Controller {

    /**
     * 
     * 
     *
     */
    use MqttTrait;
    /**
     * 
     * 
     *
     */
    public function __construct()
    {
        $this->topic    = 'cmd';
    }

    public $cart;
    //Display gps in stock
	public function gpsListPage()
    {
        return view('Gps::gps-list');
	}
	//returns gps as json
    public function getGps(Request $request){
        $new_device             =   $request->new_device;
        $refurbished_device     =   $request->refurbished_device;
        $user_id                =   \Auth::user()->id;
        $gps_stocks             =   GpsStock::select(
                                        'id',
                                        'gps_id',
                                        'dealer_id',
                                        'deleted_at'
                                )
                                ->orderBy('id','desc')
                                ->withTrashed()
                                ->with('gps:id,imei,serial_no,manufacturing_date,e_sim_number,batch_number,employee_code,model_name,version,deleted_at')
                                ->where('dealer_id',null);
        if($new_device == '1' && $refurbished_device == '1')
        {
            $gps_stocks->get();
        }
        else if($new_device == '1' && $refurbished_device == '0'){
            $gps_stocks->where('refurbished_status',0)->get();
        }
        else if($new_device == '0' && $refurbished_device == '1'){
            $gps_stocks->where('refurbished_status',1)->get();
        }
        return DataTables::of($gps_stocks)
        ->addIndexColumn()
        ->addColumn('action', function ($gps_stocks) {
            $b_url = \URL::to('/');
            if($gps_stocks->deleted_at == null){
                return "
                <a href=".$b_url."/gps/".Crypt::encrypt($gps_stocks->gps_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/gps/".Crypt::encrypt($gps_stocks->gps_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                ";
            }else{
                 return " <a href=".$b_url."/gps/".Crypt::encrypt($gps_stocks->gps_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
               ";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    //Display all gps list
    public function allgpsList()
    {

      // $data=$this->invisbleAPI('KL352111');

       //print_r($data);
//die;
       //$this->cmcParsing();die;
        return view('Gps::all-gps-list');
    }
    //returns gps as json
    public function getAllgpsList(Request $request)
    {
        $all_devices=[];
        if(\Auth::user()->hasRole('Driver')){
            $user_id= \Auth::user()->id;
            $vehicles = Vehicle::select('id','register_number','name','gps_id')
        ->where('driver_id',$user_id)->first();
        if($vehicles){
                $all_devices         = Gps::find($vehicles->gps_id);
            }
            
        }else{
                $manufactured_device =  $request->manufactured_device;
                $refurbished_device  =  $request->refurbished_device;
                $all_devices         =  (new Gps())->getAllDevicesList();
                if($manufactured_device == '1' && $refurbished_device == '1')
                {
                    $all_devices->get();
                }
                else if($manufactured_device == '1' && $refurbished_device == '0')
                {
                    $all_devices->where('gps_summery.refurbished_status',0)->get();
                }
                else if($manufactured_device == '0' && $refurbished_device == '1')
                {
                    $all_devices->where('gps_summery.refurbished_status',1)->get();
                }

                
        }
        return DataTables::of($all_devices)
       
        ->addIndexColumn()

       ->editColumn('dealer', function ($all_devices) {
            if($all_devices->distributor_name!=""){
                 return $all_devices->distributor_name??"";
            }
            else{
                return "No Distributor";
            }
           // return "No Distributor";
        })
        ->editColumn('subdealer', function ($all_devices) {
            if($all_devices->dealer_name){
                return $all_devices->dealer_name??"";
            }else{
                return "No Dealers";
            }
        })

        ->editColumn('vehicle_number', function ($all_devices) {
            if($all_devices->vehicle_no){
                 return $all_devices->vehicle_no??"";
                }
                else{
                    return "No Vehicle";
                }
        })
        ->editColumn('mob_app', function ($all_devices) {
            if($all_devices->mob_app){
                 return 'Yes'??"";
               // return $all_devices->employee_code??"";
                }
                else{
                    return "Not Applied";
                  /// return $all_devices->employee_code??"";
                }
        })

         
        ->editColumn('client', function ($all_devices) {
            if($all_devices->client_name){
                return $all_devices->client_name??"";
                }
                else{
                    return "No End user";
                }
        })
        ->addColumn('action', function ($all_devices) {
            $b_url = \URL::to('/');$b="";
            if($all_devices->deleted_at == null){
                $b.= "
                <a href=".$b_url."/gps/".Crypt::encrypt($all_devices->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <a href=".$b_url."/gps/".Crypt::encrypt($all_devices->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>";
             }
            
//            if($all_devices->pay_status){
                $b.= "<a href='#' data-id='".$all_devices->id."' data-toggle='modal' data-target='#stockModal' class='btn btn-success btn-sm'>Attach Certificate</a>";
 
                if($all_devices->warrenty_certificate){

                   // $path = 'uploads/'.$all_devices->warrenty_certificate;

                   $b.= "<a href=".$b_url."/uploads/".$all_devices->warrenty_certificate." class='btn btn-success btn-sm' download>Download Certificate</a>";
                   $b.="<a href=".$b_url."/download-invoice/".$all_devices->id." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Invoice'>Download Invoice </a>";
                  
                 
                   //$b.= "<a href='".$all_devices->warrenty_certificate."' class='btn btn-success btn-sm' download>Download Certificate</a>";
     
  //              }
            }
            
             return $b;
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
        $rules = $this->gpsCreateRules();
        $this->validate($request, $rules);

        // $gps->manufacturing_date = $maufacture;
        // $gps->e_sim_number = $request->e_sim_number;
        // $gps->save();

        $gps = Gps::create([
            'serial_no'=>$request->serial_no,
            'icc_id'=>$request->icc_id,
            'icc_id1'=>$request->icc_id1,
            'imsi'=>$request->imsi,
            'imei'=>$request->imei,
            'manufacturing_date'=>$maufacture,
            'provider1'=>$request->e_sim_number,
            'provider2'=>$request->provider2,
            'e_sim_number'=>$request->e_sim_number,
            'e_sim_number1'=>$request->e_sim_number1,
            'batch_number'=>$request->batch_number,
            'model_name'=>$request->model_name,
            'version'=>$request->version,
            'employee_code'=>$request->employee_code,
            'vehicle_no'=>$request->vehicle_no??"",
            'validity'=>$request->validity??"",
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
        $gps->icc_id1 = $request->icc_id1;
        $gps->imsi = $request->imsi;
        $gps->manufacturing_date = $request->manufacturing_date;
        $gps->provider1 = $request->provider1;
        $gps->provider2	 = $request->provider2	;
        $gps->e_sim_number = $request->e_sim_number;
        $gps->e_sim_number1 = $request->e_sim_number1;
        $gps->batch_number = $request->batch_number;
        $gps->employee_code = $request->employee_code;
        $gps->model_name = $request->model_name;
        $gps->vehicle_no = $request->vehicle_no??"";
        $gps->validity = $request->validity??"";
        $gps->installation_date_new = $request->installation_date_new??"";
        if($request->installation_date_new){
           $validty= date("Y-m-d", strtotime("+".$request->installation_date_new));
           $validty=date('Y-m-d', strtotime($validty. ' + 720 days'));
           $gps->validity_date =  $validty;
        }
        
        $gps->version = $request->version;
        $gps->save();

        $encrypted_gps_id = encrypt($gps->id);
        $request->session()->flash('message', ' GPS updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('gps.details',$encrypted_gps_id));
    }



    public function updatePayment(Request $request){
        $gps = Gps::find($request->id);
        if($gps == null){
           return view('Gps::404');
        }
        $rules = $this->gpsUpdateRules($gps);
        $this->validate($request, $rules);
        $ordid=1666;
        $latestOrder = GpsOrder::orderBy('ordid','DESC')->first();
        
        if( $latestOrder ){
            $ordid= $latestOrder->ordid + 1;
            $orderno = 'VIOT/2024-'.date("Y").'/'. $ordid;
           
        }else{
            $orderno = 'VIOT/2024-'.date("Y").'/1666';
        }

        $validty= date("Y-m-d", strtotime("+".$request->validity));
        $validty=date('Y-m-d', strtotime($validty. ' + 90 days'));
        $gps->serial_no = $request->serial_no;
        $gps->imei = $request->imei;
        $gps->icc_id = $request->icc_id;
        $gps->icc_id1 = $request->icc_id1;
        $gps->imsi = $request->imsi;
        $gps->manufacturing_date = $request->manufacturing_date;
        $gps->provider1 = $request->provider1;
        $gps->provider2	 = $request->provider2	;
        $gps->e_sim_number = $request->e_sim_number;
        $gps->e_sim_number1 = $request->e_sim_number1;
        $gps->batch_number = $request->batch_number;
        $gps->employee_code = $request->employee_code;
        $gps->model_name = $request->model_name;
        $gps->vehicle_no = $request->vehicle_no??"";
        $gps->validity = $request->validity??"";
        $gps->mob_app = $request->mob_app??"";
        $gps->plan_id = $request->plan_id??"";
        $gps->renewed_by = $request->renewed_by??"";

        $gps->pay_method = $request->pay_method??"";
        $gps->amount = $request->amount??0;
        if ($request->hasFile('screen_shot')) {
           
            $filePath = $request->file('screen_shot')->store('uploads', 'public');
            $gps->pay_screen_shot = $filePath;
        }
        $gps->pay_status = 1;
        $gps->pay_date = Date('Y-m-d');
        $gps->validity_date =$validty;
        $gps->save();
        
        // Mark auto-assignment as completed if exists
        try {
            if (class_exists('App\Modules\Sales\Controllers\RenewalAutomationController')) {
                $renewalController = new \App\Modules\Sales\Controllers\RenewalAutomationController();
                $renewalController->markGpsCompleted($gps->id);
            }
        } catch (\Exception $e) {
            \Log::warning("Failed to mark GPS {$gps->id} as completed in auto-assignment: " . $e->getMessage());
        }
        
        $encrypted_gps_id = encrypt($gps->id);
        $dataArray = array(
            "ICCID"=>$request->icc_id,
		  "Primary_TSP_MSISDN"=>$request->e_sim_number,
		  "Fallback_TSP_MSISDN"=>$request->e_sim_number1,
		  "Primary_TSP_Name"=> $request->provider1,
		  "Fallback_TSP_Name"=> $request->provider2,
		  "Primary_TSP_Validity"=> $validty,
		  "Fallback_TSP_Validity"=> $validty,
        );
      // print_r($dataArray);die;
       

      //  print_r($result);die;

        

           $esims=  Esim::where('ICCID',$request->icc_id)->delete();

        
            $esim= new Esim();
            $esim->ICCID=$request->icc_id;
            $esim->Primary_TSP_MSISDN=$request->e_sim_number;
            $esim->Fallback_TSP_MSISDN=$request->e_sim_number1;
            $esim->Primary_TSP_Name=$request->provider1;
            $esim->Fallback_TSP_Name=$request->provider2;
            $esim->Primary_TSP_Validity=$validty;
            $esim->Fallback_TSP_Validity=$validty;
            $esim->save();

    //gps order table 
//VIOT/24-25/
          
           
   
            $order= new GpsOrder();
            $order->order_id = $orderno;
            $order->gps_id = $gps->id;
            $order->delivery_name = ($request->dealer_name)?$request->dealer_name:$request->delivery_name;
            $order->delivery_address = ($request->customer_address)?$request->customer_address:$request->dealer_address;
            $order->total_amount = $request->amount??0;
            $order->payment_status = 1;
            $order->ordid =$ordid;
            $order->sales_by = auth()->id();
            $order->save();

       /* }else{

            $esims->Primary_TSP_Validity=$validty;
            $esims->Fallback_TSP_Validity=$validty;
            $esims->save();
           // $result=$this->nodefunction($dataArray);
        }*/
        
           
       
       // $request->session()->flash('message', ' GPS Esim Updated successfully!');
       //$request->session()->flash('message',  $result);
      
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
    /*
     This Function not used in any route
     #HIDE
    
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
    */

    //returns gps as json
    /*
    This Function not used in any route
     #HIDE
    
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
     */
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
                'trader_id',
                'client_id',
                'deleted_at')
                ->withTrashed()
                ->with('gps')
                ->with('client')
                ->with('trader')
                ->where('subdealer_id',$sub_dealer_id)
                ->get();
        return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('trader', function ($gps_stock) {
                if($gps_stock->trader_id==null){
                    return "--";
                }else{
                    return ( is_object($gps_stock->trader) ) ? $gps_stock->trader->name : '';
                }
            })
            ->addColumn('client', function ($gps_stock) {
                if($gps_stock->client_id==null){
                    return "--";
                }else{
                    return ( is_object($gps_stock->client) ) ? $gps_stock->client->name : '';
                }
            })
            ->addColumn('status', function ($gps_stock) {
                if($gps_stock->client_id===null && $gps_stock->trader_id===null){
                    return "Not Transferred";
                }else if($gps_stock->client_id===null && $gps_stock->trader_id===0){
                    return "Awaiting Confirmation";
                }else if($gps_stock->client_id===0 && $gps_stock->trader_id===null){
                    return "Awaiting Confirmation";
                }else{
                    return "Transferred";
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

    //Display gps in stock of sub dealer
    public function gpsInStockSubDealerPage()
    {
        return view('Gps::gps-in-stock-sub-dealer-list');
    }

    //returns gps in stock of sub dealer as json
    public function getSubDealerGpsInStock()
    {
        $sub_dealer_id=\Auth::user()->subdealer->id;
        $gps_stock = GpsStock::select(
                'id',
                'gps_id'
                )
                ->withTrashed()
                ->with('gps')
                ->whereNull('trader_id')
                ->whereNull('client_id')
                ->where('subdealer_id',$sub_dealer_id)
                ->get();
        return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('action', function ($gps_stock) {
                $b_url = \URL::to('/');
                if($gps_stock->deleted_at == null){
                    return "
                        <a href=".$b_url."/gps/".Crypt::encrypt($gps_stock->gps_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
                }else{
                    return "";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //Display gps in stock of trader
    public function gpsInStockTraderPage()
    {
        return view('Gps::gps-in-stock-trader-list');
    }

    //returns gps in stock of trader as json
    public function getTraderGpsInStock()
    {
        $trader_id=\Auth::user()->trader->id;
        $gps_stock = GpsStock::select(
                'id',
                'gps_id'
                )
                ->withTrashed()
                ->with('gps')
                ->whereNull('client_id')
                ->where('trader_id',$trader_id)
                ->get();
        return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('action', function ($gps_stock) {
                $b_url = \URL::to('/');
                if($gps_stock->deleted_at == null){
                    return "
                        <a href=".$b_url."/gps/".Crypt::encrypt($gps_stock->gps_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
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

    /////////////////////////GPS TRADER-START//////////////////////////////////

    //All devices list in trader
    public function gpsTraderListPage()
    {
        return view('Gps::gps-trader-list');
    }

    //returns gps list as json
    public function getTraderGps()
    {
        $trader_id=\Auth::user()->trader->id;
        $gps_stock = GpsStock::select(
                'id',
                'gps_id',
                'dealer_id',
                'subdealer_id',
                'trader_id',
                'client_id',
                'deleted_at')
                ->withTrashed()
                ->with('gps')
                ->with('client')
                ->where('trader_id',$trader_id)
                ->get();
        return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('client', function ($gps_stock) {
                if($gps_stock->client_id==null){
                    return "--";
                }else{
                    return ( is_object($gps_stock->client) ) ? $gps_stock->client->name : '';
                }
            })
            ->addColumn('status', function ($gps_stock) {
                if($gps_stock->client_id===null){
                    return "Not Transferred";
                }else if($gps_stock->client_id===0){
                    return "Awaiting Confirmation";
                }else{
                    return "Transferred";;
                }
            })
            ->addColumn('action', function ($gps_stock) {
                $b_url = \URL::to('/');
                if($gps_stock->deleted_at == null){
                    if($gps_stock->gps->status == 1){
                        return "
                            <b style='color:#008000';>Active</b>
                            <a href=".$b_url."/gps-trader/".Crypt::encrypt($gps_stock->gps_id)."/status-log class='btn btn-xs btn-info'> Log </a>
                            <a href=".$b_url."/gps/".Crypt::encrypt($gps_stock->gps_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                            <button onclick=deactivateGpsStatusFromTrader(".$gps_stock->gps_id.") class='btn btn-xs btn-danger'></i>Deactivate</button>
                        ";
                        }else{
                        return "
                            <b style='color:#FF0000';>Inactive</b>
                            <a href=".$b_url."/gps-trader/".Crypt::encrypt($gps_stock->gps_id)."/status-log class='btn btn-xs btn-info'> Log </a>
                            <button onclick=activateGpsStatusFromTrader(".$gps_stock->gps_id.") class='btn btn-xs btn-success'> Activate </button>
                        ";
                        }
                }else{
                     return "";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //deactivate gps from trader
    public function gpsInTraderStatusDeactivate(Request $request)
    {
        $user_id=\Auth::user()->id;
        $gps = Gps::find($request->id);
        if($gps == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'GPS does not exist'
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
            'message' => 'GPS deactivated successfully'
        ]);
    }
    // activate gps from trader
    public function gpsInTraderStatusActivate(Request $request)
    {
        $user_id=\Auth::user()->id;
        $gps = Gps::find($request->id);
        if($gps==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'GPS does not exist'
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
            'message' => 'GPS activated successfully'
        ]);
    }

    public function viewTraderStatusLog(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $user_id=\Auth::user()->id;
        $gps_logs = GpsLog::select(
                'id',
                'gps_id',
                'status',
                'user_id',
                'created_at')
                ->where('gps_id',$decrypted_id)
                ->where('user_id',$user_id)
                ->with('gps:id,imei')
                ->get();
        return view('Gps::gps-status-log-view',['gps_logs' => $gps_logs]);
    }

    /////////////////////////GPS TRADER-END////////////////////////////////////

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

    /*
     This Function not used in any route
     #HIDE
    public function allGpsDatas(Request $request)
    {
        $items = GpsData::all()->sortByDesc('id');
        return view('Gps::alldata',['items' => $items]);
    }
    */

    /*
    #HIDE
    public function allgpsListPage()
    {
        $ota      = OtaType::all();
        $gps      = Gps::select('id','imei')->get();
        $gps_data = GpsData::select('id','header')->groupBy('header')->get();
        return view('Gps::alldata-list',['gps' => $gps,'ota' => $ota,'gpsDatas' => $gps_data]);
    }
    */
    /*
    #HIDE
    public function getAllData(Request $request)
    {

        if($request->gps && $request->header){

         $items = GpsData::where('gps_id',$request->gps)->where('header',$request->header)->limit(500);
        }
        else if($request->gps){
         $items = GpsData::where('gps_id',$request->gps)->limit(500);
        }
        else if($request->header){
            $items = GpsData::where('header',$request->header)->limit(500);
        }
        else{
         $items = GpsData::limit(500);
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
             $hlm_contains = Str::contains($items, 'HLM');
             $lgn_contains = Str::contains($items, 'LGN');

             if($contains){
                     return "<button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdataBTHList($items->id)'>Batch Log </button>";
                  }
                  else if($hlm_contains || $lgn_contains){
                    return "<button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdataHLMList($items->id)'>HLM/LGN </button>";
                  }
                    else{
                       return "<button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdata($items->id)'>View </button>";
                      }


        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    */


    public function vltdataListPage()
    {
         $gps= Gps::select('id','imei')->get();
         $gps_data = VltData::select('id','header')->groupBy('header')->get();
        return view('Gps::vltdata-list',['gps' => $gps,'gpsDatas' => $gps_data]);
    }
    public function publicVltdataListPage()
    {
        $gps= Gps::select('id','imei')->get();
        $gps_data = VltData::select('id','header')->groupBy('header')->get();
        return view('Gps::public-vltdata-list',['gps' => $gps,'gpsDatas' => $gps_data]);
    }

    public function getVltData(Request $request)
    {

        if($request->gps && $request->header){

         $items = VltData::where('imei',$request->gps)->where('header',$request->header)->limit(500);
        }
        else if($request->gps){
         $items = VltData::where('imei',$request->gps)->limit(500);
        }
        else if($request->header){
            $items = VltData::where('header',$request->header)->limit(500);
        }
        else{
         $items = VltData::limit(500);
        }

         // $items = VltData::all();
        return DataTables::of($items)
        ->addIndexColumn()
         ->addColumn('forhuman', function ($items) {
                $forhuman=0;
                $forhuman=Carbon::parse($items->created_at)->diffForHumans();;
                return $forhuman;
             })
         // ->addColumn('action', function ($items) {
         //       $b_url = \URL::to('/');
         //    return "
         //   <a href=".$b_url."/id/".Crypt::encrypt($items->id)."/pased class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View Details</a>
         //     ";
         //     })
         // ->rawColumns(['link', 'action'])

        ->make();
    }



    public function getPublicVltData(Request $request)
    {
        if($request->gps && $request->header){
         $items = VltData::where('imei',$request->gps)->where('header',$request->header)->orderBy('id','desc')->limit(500);
        }
        else if($request->gps){
         $items = VltData::where('imei',$request->gps)->orderBy('id','desc')->limit(500);
        }
        else if($request->header){
            $items = VltData::where('header',$request->header)->orderBy('id','desc')->limit(500);
        }
        else{
         $items = VltData::orderBy('id','desc')->limit(500);
        }

         // $items = VltData::all();
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

    public function downloadPF(Request $request){

       
        $decrypted_id =$request->id;
        $gps = Gps::find($decrypted_id);

        if($gps == null){
           return view('Gps::404');
        }

        $path = public_path('uploads/' . $gps->warrenty_certificate);

            if (file_exists($path)) {
                return response()->download($path);
            } else {
                abort(404);
            }

    }

    /*
     #HIDE
    public function getGpsAllData(Request $request)
    {
        $items = GpsData::find($request->id);
        return response()->json([
                'gpsData' => $items
        ]);

    }
    */

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
       $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        if (strpos($url, $rayfleet_key) == true)
         {
          return view('Gps::rayfleet-privacy-policy');
         }else{
           return view('Gps::privacy-policy');
         }
    }

    //for gps creation
    public function subscriptionSuccess()
    {
        return view('Gps::subscription-success');
    }
    /*
    #HIDE
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
    */
    public function pasedData(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $vltdata = VltData::find($decrypted_id);
        $vlt_data = $vltdata->vltdata;

        $imei=substr($vlt_data, 3, 15);
        $count=substr($vlt_data, 18, 3);
        $alert_id=substr($vlt_data, 21, 2);
        $packet_status=substr($vlt_data, 23, 1);
        $gps_fix=substr($vlt_data, 24, 1);
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
        $connection_lost_time_motion = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_motion').""));
        $connection_lost_time_halt = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_halt').""));
        $connection_lost_time_sleep = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_sleep').""));
        $offline="Offline";
        $signal_strength="Connection Lost";
        $track_data=Gps::select('lat as latitude',
                      'lon as longitude',
                      'heading as angle',
                      'mode as vehicleStatus',
                      'imei',
                      'ac_status',
                      'speed',
                      'fuel_status',
                      'battery_status as battery_percentage',
                      'device_time as dateTime',
                      'main_power_status as power',
                      'ignition as ign',
                      'id',
                      'gsm_signal_strength as signalStrength'
                      )
                    ->where('device_time', '>=',$oneMinut_currentDateTime)
                    ->where('id',$request->id)
                    ->first();
        $minutes=0;
        if($track_data == null){
            $track_data = Gps::select('lat as latitude',
                              'lon as longitude',
                              'heading as angle',
                              'ac_status',
                              'speed',
                              'fuel_status',
                              'imei',
                              'battery_status as battery_percentage',
                              'device_time as dateTime',
                              'main_power_status as power',
                              'ignition as ign',
                              'gsm_signal_strength as signalStrength',
                              'id',
                              \DB::raw("'$signal_strength' as signalStrength"),
                              \DB::raw("'$offline' as vehicleStatus")
                              )
                              ->where('id',$request->id)
                              ->first();
            $minutes   = Carbon::createFromTimeStamp(strtotime($track_data->dateTime))->diffForHumans();
        }

        if($track_data){
            $connection_lost_time_minutes   = Carbon::createFromTimeStamp(strtotime($track_data->dateTime))->diffForHumans();
            // $plcaeName=$this->getPlacenameFromLatLng($track_data->latitude,$track_data->longitude);
            $snapRoute=$this->LiveSnapRoot($track_data->latitude,$track_data->longitude);
            $fuel_status="0"."%";
            $ac_status =$track_data->ac_status;
            if($ac_status == 1){
                $ac_status="ON";
            }else{
                $ac_status="OFF";
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
                        "connection_lost_time_motion"=>$connection_lost_time_motion,
                        "connection_lost_time_halt"=>$connection_lost_time_halt,
                        "connection_lost_time_sleep"=>$connection_lost_time_sleep,
                        "last_seen"=>$minutes,
                        "connection_lost_time_minutes"=>$connection_lost_time_minutes,
                        "fuel"=>$fuel_status,
                        "ac"=>$ac_status,
                        // "place"=>$plcaeName,
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
    function getAddress(Request $request){
        if(!empty($request->latitude) && !empty($request->longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($request->latitude).','.trim($request->longitude).'&sensor=false&key='.config('eclipse.keys.googleMap'));
            $output = json_decode($geocodeFromLatLong);
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude
            if(!empty($address)){
                return $address;
            }else{
                return "no address";
            }
        }else{
            return "No address";
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
        $url = "https://roads.googleapis.com/v1/snapToRoads?path=" . $route . "&interpolate=true&key=".config('eclipse.keys.googleMap');
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

        $gps = Gps::select('id','imei')->get();
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
        $gps = Gps::select('id','imei')->get();


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
        $gps_mode_change=GpsModeChange::select('device_time','gps_id','mode','id')
                                  ->where('device_time','>=',$from_date)
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


    /*
    #HIDE
    public function allgpsDataListPage()
    {
        $ota = OtaType::all();
        $gps = Gps::select('id','imei','serial_no')->get();
        // $items = GpsData::orderBy('created_at', 'DESC')->limit(20)->get();
        // $last_data = GpsData::orderBy('created_at', 'DESC')->first();
        // dd($gps_data);
        return view('Gps::allgpsdata-list',['gps' => $gps,'ota' => $ota]);
    }

    */
    /*
    #HIDE
    public function allPublicgpsDataListPage()
    {
        $ota = OtaType::all();
        $gps = Gps::select('id','imei','serial_no')->get();

        // $items = GpsData::orderBy('created_at', 'DESC')->limit(20)->get();
        // $last_data = GpsData::orderBy('created_at', 'DESC')->first();
        // dd($gps_data);
        return view('Gps::allgpsdata-list-public',['gps' => $gps,'ota' => $ota]);
    }
    */
    /*
    #HIDE
    public function getAllGpsData(Request $request)
    {
         $forhuman=0;
        if($request->gps){
            $items = GpsData::where('gps_id',$request->gps)->orderBy('created_at', 'DESC')->limit(20)->get();
            $last_data = GpsData::where('gps_id',$request->gps)->orderBy('created_at', 'DESC')->first();
            if($last_data)
            {
                $forhuman=Carbon::parse($last_data->created_at)->diffForHumans();
            }
            return response()->json([
                    'last_data' => $last_data,
                    'items' => $items,
                    'last_updated' => $forhuman,
                    'status' => 'gpsdatavalue'
            ]);
        }
    }
    */
    /*
    #HIDE
    public function getPublicAllGpsData(Request $request)
    {
         $forhuman=0;
        if($request->gps){
            $items = GpsData::where('gps_id',$request->gps)->orderBy('created_at', 'DESC')->limit(20)->get();
            $last_data = GpsData::where('gps_id',$request->gps)->orderBy('created_at', 'DESC')->first();
            if($last_data)
            {
                $forhuman=Carbon::parse($last_data->created_at)->diffForHumans();
            }
            return response()->json([
                'last_data' => $last_data,
                'items' => $items,
                'last_updated' => $forhuman,
                'status' => 'gpsdatavalue'
            ]);
        }
    }
    */
    public function getGpsAllDataHlm(Request $request)
    {
        $items = GpsData::find($request->id);
        return response()->json([
                'gpsData' => $items
        ]);
    }

    public function setOtaInConsole(Request $request)
    {
        $gps_id             =   $request->gps_id;
        $command            =   $request->command;
        $response           =   (new OtaResponse())->saveCommandsToDevice($gps_id,$command);
        if($response)
        {
            $gps_details                        =   (new Gps())->getGpsDetails($gps_id);
            $is_command_write_to_device         =   (new OtaResponse())->writeCommandToDevice($gps_details->imei,$command);
            if($is_command_write_to_device)
            {
                $this->topic                    =   $this->topic.'/'.$gps_details->imei;
                $is_mqtt_publish                =   $this->mqttPublish($this->topic, $command);
                if ($is_mqtt_publish === true) 
                {
                    return response()->json([
                        'status' => 1,
                        'title' => 'Success',
                        'message' => 'Command send successfully'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => 0,
                        'title' => 'Error',
                        'message' => 'Try again!!'
                    ]);
                }
            }
        }
        else
        {
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Try again!!'
            ]);
        }
    }


    //////////////////////////

    public function operationsSetOtaInConsole(Request $request)
    {
        $gps_id         =   $request->gps_id;
        $operations_id  =   \Auth::user()->operations->id;
        $command        =   $request->command;
        $ota            =   $request->ota;
        $ota_response   =   $ota.$command;
        $response       =   (new OtaResponse())->saveCommandsToDevice($gps_id,$ota_response);
        
        if($response){
            $gps_details                        =   (new Gps())->getGpsDetails($gps_id);
            $is_command_write_to_device         =   (new OtaResponse())->writeCommandToDevice($gps_details->imei,$ota_response);
            if($is_command_write_to_device)
            {
                $this->topic                    =   $this->topic.'/'.$gps_details->imei;
                $is_mqtt_publish                =   $this->mqttPublish($this->topic, $ota_response);
                if ($is_mqtt_publish === true) 
                {
                    return response()->json([
                        'status' => 1,
                        'title' => 'Success',
                        'message' => 'Command send successfully'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => 0,
                        'title' => 'Error',
                        'message' => 'Try again!!'
                    ]);
                }
            }
        }else{
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Try again!!'
            ]);
        }
    }
//////////Gps stock creation usig serial number////////////////


    public function createStock()
    {
        $gps = Gps::select('id', 'imei','serial_no','manufacturing_date')
        ->whereNull('manufacturing_date')
        ->get();
        return view('Gps::gps-stock-create',['devices'=>$gps]);
    }

        //upload gps details to database table
    public function saveStock(Request $request)
    {
        $user_id=\Auth::user()->id;
        $maufacture= date("Y-m-d", strtotime($request->manufacturing_date));
        // dd($request->serial_no);
        // $gps = Gps::where('id',$request->serial_no)->first();
        // if($gps == null){
        //    return view('Gps::404');
        // }
        $rules = $this->gpsStockCreateRules();
        $this->validate($request, $rules);
        $gps_id= $request->serial_no;
        $gps = Gps::find($gps_id);
        $gps_stock = GpsStock::select('id','gps_id')->where('gps_id',$gps_id)->first();
        if($gps_stock==null)
        {
            $gps->manufacturing_date = $maufacture;
            $gps->e_sim_number = $request->e_sim_number;
            $gps->save();
            if($gps){
               $gps_stock = GpsStock::create([
                    'gps_id'=> $gps->id,
                    'inserted_by' => $user_id
                ]);
            }
            $request->session()->flash('message', 'New gps created successfully!');
            $request->session()->flash('alert-class', 'alert-success');
             // return redirect(route('gps.details',Crypt::encrypt($gps->id)));
            return redirect(route('gps.stock'));
        }
        else{


            $request->session()->flash('message', 'Already added to stock!');
             $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps.stock'));
        }


    }


    public function otaResponseListPage()
    {
        $gps = Gps::select('id','imei','serial_no')->get();
        return view('Gps::ota-response-list',['gps' => $gps]);
    }
     public function getOtaResponseAllData(Request $request)
    {
        if($request->gps){
         $items = OtaResponse::select('response','sent_at','verified_at')->where('gps_id',$request->gps)->limit(500);
        }

        return DataTables::of($items)
        ->addIndexColumn()

        ->rawColumns(['link', 'action'])
        ->make();
    }
   
    public function allpublicgpsListPage(Request $request)
    {
        $gps = Gps::select('id','imei','serial_no')->get();
        $ota = OtaType::select('code','name')->get();
        $gps_data = GpsData::select('id','header')->groupBy('header')->get();
        // dd($header);
        return view('Gps::public-alldata-list',['gps' => $gps,'ota' => $ota,'gpsDatas' => $gps_data]);
    }
  
    public function getPublicAllData(Request $request)
    {
        if($request->gps && $request->header){

         $items = GpsData::where('gps_id',$request->gps)->where('header',$request->header)->orderBy('id','desc')->limit(500);
        }
        else if($request->gps){
         $items = GpsData::where('gps_id',$request->gps)->orderBy('id','desc')->limit(500);
        }
        else if($request->header){
            $items = GpsData::where('header',$request->header)->orderBy('id','desc')->limit(500);
        }
        else{
         $items = GpsData::orderBy('id','desc')->limit(500);
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
             $hlm_contains = Str::contains($items, 'HLM');
             $lgn_contains = Str::contains($items, 'LGN');

             if($contains){
                     return "<button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdataBTHList($items->id)'>Batch Log </button>";
                  }
                  else if($hlm_contains || $lgn_contains){
                    return "<button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdataHLMList($items->id)'>HLM/LGN </button>";
                  }
                    else{
                       return "<button type='button' class='btn btn-primary btn-info' data-toggle='modal'  onclick='getdata($items->id)'>View </button>";
                      }


        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    

    public function gpsReport()
    {
        return view('Gps::gps-report');
    }
     public function gpsReportList(Request $request)
    {
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];
        $query =Gps::select(
            'serial_no',
            'icc_id','icc_id1','e_sim_number1','provider1','provider2','validity',
            'imsi','imei','manufacturing_date','e_sim_number','batch_number','model_name','version','status','device_time','employee_code','created_at'
        );
        if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('manufacturing_date', '>=', $search_from_date)->whereDate('manufacturing_date', '<=', $search_to_date);
            }
      $gps = $query->get();
      // dd($gps);
        return DataTables::of($gps)
        ->addIndexColumn()

        ->make();
    }




    public function combinedGpsReport()
    {
        return view('Gps::combined-gps-report');
    }
    public function combinedGpsReportList(Request $request)
    {
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];
        $query =Gps::select(
            'serial_no',
            'icc_id',
            'imsi','imei','manufacturing_date','e_sim_number','batch_number','model_name','version','status','device_time','employee_code',
           \DB::raw('count(date_format(created_at, "Y-m-d")) as count'),
            \DB::raw('DATE(created_at) as date')
        )
        ->groupBy('date');
        if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('created_at', '>=', $search_from_date)->whereDate('created_at', '<=', $search_to_date);
            }
      $gps = $query->get();
    return DataTables::of($gps)
    ->addIndexColumn()
    ->make();
    }


    public function otaUpdatesListPage()
    {
        $gps = Gps::select('id','imei','serial_no')->get();
        return view('Gps::ota-updates-list',['gps' => $gps]);
    }
    public function getOtaUpdatesAllData(Request $request)
    {
        if($request->gps){
         $items = OtaUpdates::where('gps_id',$request->gps)->limit(500);
        }

        return DataTables::of($items)
        ->addIndexColumn()
        ->rawColumns(['link', 'action'])
        ->make();
    }








    public function stockReport()
    {
        return view('Gps::stock-report');
    }
     public function stockReportList(Request $request)
    {
        $from = ($request->data['from_date'])?$request->data['from_date']:Date('YY-MM-DD');
        $query =Gps::select(
             'id','manufacturing_date','imei','e_sim_number','serial_no','icc_id','imsi',
             'provider1','provider2','icc_id1','validity','e_sim_number1'
        )
        ->with('gpsStock:gps_id,inserted_by,created_at')
        ->with('gpsStock.user:id,username');
        if($from){
                $to =  ($request->data['to_date'])?$request->data['to_date']:Date('YY-MM-DD');
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('manufacturing_date', '>=', $search_from_date)->whereDate('manufacturing_date', '<=', $search_to_date);
            }
        $stock = $query->get();
        return DataTables::of($stock)
        ->addIndexColumn()
        ->make();
    }




    public function combinedStockReport()
    {
        return view('Gps::combined-stock-report');
    }
    public function combinedReportList(Request $request)
    {
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];

        $query =GpsStock::select(
            'gps_id',
           \DB::raw('count(date_format(created_at, "Y-m-d")) as count'),
            \DB::raw('DATE(created_at) as date')
        )
        ->groupBy('date');

         $query =Gps::select(
             'id',
             DB::raw('count(date_format(manufacturing_date, "Y-m-d")) as count'),
            \DB::raw('DATE(manufacturing_date) as date')
        )
         ->groupBy('date');

        if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('manufacturing_date', '>=', $search_from_date)->whereDate('manufacturing_date', '<=', $search_to_date);
            }
      $stock = $query->get();
    return DataTables::of($stock)
    ->addIndexColumn()
    ->make();
    }

    public function selectOtaParamByGps(Request $request){
        $gps_id=$request->gps_id;
        $ota_data=GpsConfiguration::where('gps_id',$gps_id)->first();
        if($ota_data){
          return response()->json([
                'status' => 1,
                'title' => 'Success',
                'ota'=>$ota_data,
                'message' => 'success'
         ]);
        }else{
        //     $request->session()->flash('message', 'Try again');
        // $request->session()->flash('alert-class', 'alert-success');
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Try again!!'
            ]);
        }
         return redirect(route('set.ota.operations'));
    }

     public function setOtaInUnprocessed(Request $request)
    {
        $imei               =   $request->imei;
        $gps                =   Gps::select('imei','id')->where('imei',$imei)->first();
        $gps_id             =   $gps->id;
        $command            =   $request->command;
        $response           =   (new OtaResponse())->saveCommandsToDevice($gps_id,$command);
        
        if($response){
            $is_command_write_to_device         =   (new OtaResponse())->writeCommandToDevice($imei,$command);
            if($is_command_write_to_device)
            {
                $this->topic                    =   $this->topic.'/'.$imei;
                $is_mqtt_publish                =   $this->mqttPublish($this->topic, $command);
                if ($is_mqtt_publish === true) 
                {
                    return response()->json([
                        'status' => 1,
                        'title' => 'Success',
                        'message' => 'Command send successfully'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => 0,
                        'title' => 'Error',
                        'message' => 'Try again!!'
                    ]);
                }
            }
        }else{
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Try again!!'
            ]);
        }
    }
    public function operationsSetOtaListPage()
    {
        $gps = Gps::select('id','imei','serial_no')->get();
        return view('Gps::set-ota',['devices' => $gps]);
    }
    public function setOtaInConsoleOperations(Request $request)
    {
        $rules              =   $this->otaCreateRules();
        $this->validate($request, $rules);
        $gps_id             =   $request->gps_id;
        $command            =   $request->command;
        $operations_id      =   \Auth::user()->operations->id;
        $response           =   (new OtaResponse())->saveCommandsToDevice($gps_id,$command);
        if($response){
            $gps_details                        =   (new Gps())->getGpsDetails($gps_id);
            $is_command_write_to_device         =   (new OtaResponse())->writeCommandToDevice($gps_details->imei,$command);
            if($is_command_write_to_device)
            {
                $this->topic                    =   $this->topic.'/'.$gps_details->imei;
                $is_mqtt_publish                =   $this->mqttPublish($this->topic, $command);
                if ($is_mqtt_publish === true) 
                {
                    return response()->json([
                        'status' => 1,
                        'title' => 'Success',
                        'message' => 'Command send successfully'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => 0,
                        'title' => 'Error',
                        'message' => 'Try again!!'
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Try again!!'
            ]);
        }

        return redirect(route('set.ota.operations'));
    }

    //Returned GPS List in root
    public function getReturnedGps()
    {
        return view('Gps::returned-gps-list');
    }

    public function getReturnDeviceList(Request $request)
    {
        if(\Auth::user()->hasRole('dealer|root|client'))
        {
            $decrypted_id = Crypt::decrypt($request->id);
            $gps      =   Gps::withTrashed()
                ->where('id',$decrypted_id)
                ->first();
            if($request->ajax())
            {
                return ($gps != null) ? Response([ 'links' => $gps->appends(['sort' => 'votes'])]) : Response([ 'links' => null]);
            }
            else
            {
                return ($gps != null) ? view('Gps::return_device_list',['gps'=>$gps]) : view('Gps::404');
            }
        }
        elseif (\Auth::user()->hasRole('sub_dealer|trader')) {
            $decrypted_id = Crypt::decrypt($request->id);
            $gps      =   Gps::withTrashed()
                ->with('device_return.servicer')
                ->where('id',$decrypted_id)
                ->first();
            if($request->ajax())
            {
                return ($gps != null) ? Response([ 'links' => $gps->appends(['sort' => 'votes'])]) : Response([ 'links' => null]);
            }
            else
            {
                return ($gps != null) ? view('Gps::return_device_list_servicer',['gps'=>$gps]) : view('Gps::404');
            }
        }
    }

    public function getReturnedGpsList(Request $request)
    {
        $gps_stock      =   (new GpsStock())->returnedGpsListFromStock();

        if(\Auth::user()->hasRole('root'))
        {
            $gps_stock  =   $gps_stock->get();
            return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('distributor', function ($gps_stock) { 
                $distributor    =   $gps_stock->dealer;
                (isset($distributor)) ? $distributor_name = $distributor->name: $distributor_name = '-NA-';
                return $distributor_name;
            })
            ->addColumn('dealer', function ($gps_stock) { 
                $dealer         =   $gps_stock->subdealer;
                (isset($dealer)) ? $dealer_name = $dealer->name: $dealer_name = '-NA-';
                return $dealer_name;
            })
            ->addColumn('sub_dealer', function ($gps_stock) { 
                $sub_dealer     =   $gps_stock->trader;
                (isset($sub_dealer)) ? $sub_dealer_name = $sub_dealer->name: $sub_dealer_name = '-NA-';
                return $sub_dealer_name;
            })
            ->addColumn('client', function ($gps_stock) { 
                $client         =   $gps_stock->client;
                (isset($client)) ? $client_name = $client->name: $client_name = '-NA-';
                return $client_name;
            })
            ->addColumn('action', function ($gps_stock) { 
            $b_url = \URL::to('/');
            return "<a href=".$b_url."/device_return_list/".Crypt::encrypt($gps_stock->gps_id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            })
            ->make();
        }
        else if(\Auth::user()->hasRole('dealer'))
        {
            $dealer_id  =   \Auth::user()->dealer->id;
            $gps_stock  =   $gps_stock->where('dealer_id',$dealer_id)->get();
            return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('dealer', function ($gps_stock) { 
                $dealer         =   $gps_stock->subdealer;
                (isset($dealer)) ? $dealer_name = $dealer->name: $dealer_name = '-NA-';
                return $dealer_name;
            })
            ->addColumn('sub_dealer', function ($gps_stock) { 
                $sub_dealer     =   $gps_stock->trader;
                (isset($sub_dealer)) ? $sub_dealer_name = $sub_dealer->name: $sub_dealer_name = '-NA-';
                return $sub_dealer_name;
            })
            ->addColumn('client', function ($gps_stock) { 
                $client         =   $gps_stock->client;
                (isset($client)) ? $client_name = $client->name: $client_name = '-NA-';
                return $client_name;
            })
            ->addColumn('action', function ($gps_stock) { 
            $b_url = \URL::to('/');
            return "<a href=".$b_url."/device_return_list/".Crypt::encrypt($gps_stock->gps_id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            })
            ->make();
        }
        else if(\Auth::user()->hasRole('sub_dealer'))
        {
            $sub_dealer_id  =   \Auth::user()->subdealer->id;
            $gps_stock      =   $gps_stock->where('subdealer_id',$sub_dealer_id)->get();
            return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('sub_dealer', function ($gps_stock) { 
                $sub_dealer     =   $gps_stock->trader;
                (isset($sub_dealer)) ? $sub_dealer_name = $sub_dealer->name: $sub_dealer_name = '-NA-';
                return $sub_dealer_name;
            })
            ->addColumn('client', function ($gps_stock) { 
                $client         =   $gps_stock->client;
                (isset($client)) ? $client_name = $client->name: $client_name = '-NA-';
                return $client_name;
            })
            ->addColumn('action', function ($gps_stock) { 
            $b_url = \URL::to('/');
            return "<a href=".$b_url."/device_return_list/".Crypt::encrypt($gps_stock->gps_id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            })
            ->make();
        }
        else if(\Auth::user()->hasRole('trader'))
        {
            $trader_id  =   \Auth::user()->trader->id;
            $gps_stock      =   $gps_stock->where('trader_id',$trader_id)->get();
            return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('client', function ($gps_stock) { 
                $client         =   $gps_stock->client;
                (isset($client)) ? $client_name = $client->name: $client_name = '-NA-';
                return $client_name;
            })
            ->addColumn('action', function ($gps_stock) { 
            $b_url = \URL::to('/');
            return "<a href=".$b_url."/device_return_list/".Crypt::encrypt($gps_stock->gps_id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            })
            ->make();
        }
        else if(\Auth::user()->hasRole('client'))
        {
            $client_id  =   \Auth::user()->client->id;
            $gps_stock      =   $gps_stock->where('client_id',$client_id)->get();
            return DataTables::of($gps_stock)
            ->addIndexColumn()
            ->addColumn('action', function ($gps_stock) { 
            $b_url = \URL::to('/');
            return "<a href=".$b_url."/device_return_list/".Crypt::encrypt($gps_stock->gps_id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
            })
            ->make();
        }
        
    }
    /**
     * esim updation
     */
    public function esimUpdation()
    {
        return view('Gps::esim-updation');
    }

    public function esimRenewal()
    {
        $devices = GpsStock::select('id', 'gps_id','dealer_id')
                        ->with('gps')
                        ->where(function ($query) {
                            $query->where('dealer_id', '=', 0)
                                ->orWhereNull('dealer_id');
                        })
                
                        ->get();
                    
        return view('Gps::esim-renewal', [ 'devices' => $devices]);
    }

    public function esimpostRenewal(Request $request)
    {
      
        $gps="";
       if($request->gps_id){
          $id=$request->gps_id;
          $gps = Gps::where('imei','LIKE',"%{$id}%")->where('pay_status','!=',1)->first();
       }
       if($request->id){
          $id=$request->id;
          $gps = Gps::where('id',$id)->where('pay_status','!=',1)->first();
      }
       if($request->vehicle_no){

         $id=$request->vehicle_no;
         $vehiles = Vehicle::where('register_number','LIKE',"%{$id}%")->first();
         if($vehiles){
            $gps = Gps::where('id',$vehiles->gps_id)->where('pay_status','!=',1)->first();
            if($gps == null){
                return view('Gps::404');
                }
         }

       }
       $plans=Plan::all();
       if($gps == null){
        return view('Gps::404');
        }else{

            $ksrtc=Vehicle::where('gps_id',$gps->id)->where('client_id',1778)->first();

            if($ksrtc){
                return view('Gps::gps-esim-update1', [ 'gps' => $gps,'plans'=>$plans]);
            }else{
                return view('Gps::gps-esim-update', [ 'gps' => $gps,'plans'=>$plans]);
            }
            
        }
      
        
    }

    //plan details

    public function fetchPlan(Request $request){
        $plans=Plan::find($request->plan_id);

        return response()->json([
            'status' => 1,
            'plan' => $plans
        ]);

    }

    /**
     * 
     * 
     */
    public function updateEsimNumbers(Request $request)
    {
       $result     = [
            'success'   => [],
            'failed'    => []
        ];  
        $items      = json_decode($request->selected_items);            
        foreach($items as $each_item)
        {
            // dd($each_item);
            $gps_details= (new Gps())->updateEsimNumbers($each_item->imsi, $each_item->msisdn) ;
            if($gps_details)
            {
                $gps_details->e_sim_number = $each_item->msisdn;
                $gps_details->save();
                array_push($result['success'], $each_item->imsi);
                (new SimActivationDetails())->updateEsimDetails($each_item,$gps_details);
            }else{
                array_push($result['failed'], $each_item->imsi);
            }        
        }
        return $result;
    }
    public function compareEsimNumbers(Request $request)
    {
        $result     = [
            "exist"     => 0,
            "new"       => 0,
            "data"      => []
        ];  
        $items      = json_decode($request->selected_items); 
      
        $new        = 0;
        $exist      = 0;           
        foreach($items as $each_item)
        {    

            $compare_exist = (new SimActivationDetails())->compareEsimDetails($each_item) ?  true : false;
            if($compare_exist){
                $exist = $exist+1;
            }else{
                $new =$new+1;
            }
            $result ['data'][]=[
                "msisdn"                => isset($each_item->msisdn)? $each_item->msisdn:""  ,
                "iccid"                 => isset($each_item->iccid)? $each_item->iccid:"",
                "imsi"                  => isset($each_item->imsi)? $each_item->imsi:"",
                "puk"                   => isset($each_item->puk)? $each_item->puk:"",
                "product_type"          => isset($each_item->product_type)? $each_item->product_type:"",                
                "product_status"        => isset($each_item->product_status)? $each_item->product_status:"",
                "activated_on"          => isset($each_item->activation_date)? $each_item->activation_date:"",
                "expire_on"             => isset($each_item->expire_on)? $each_item->expire_on:"",
                "business_unit_name"    => isset($each_item->business_unit_name)? $each_item->business_unit_name:"",
                "status"                => $compare_exist 
            ];                 
        }      
        $result ['new']     =  $new;
        $result ['exist']   =  $exist;
        return $result;
    }

    public function EsimFileExistance(Request $request)
    {
        $file_name=$request->file_name;
        $sim_upload_count= (new EsimUploadFile())->esimFilenameCount($file_name) ;       
        if($sim_upload_count==0)
        {        
            $sim_upload= (new EsimUploadFile())->esimFilenameSave($file_name) ;     
            return 'true';
        }
        else
        {
            return 'false';
        }
    }

    /**
     * @author SSK
     * 
     * redirect to device warranty entry page in operations panel
     */
    public function deviceWarranty()
    {
        $gps     = Gps::select('id','imei','serial_no')->get();
        $devices = GpsWarranty::select('id','gps_id','period_from','period_to','expired_on','expired_reason')
        ->orderBy('created_at','asc')
        ->with('gps:id,imei')
        ->get();
        return view('Gps::device-warranty', [ 'gps' => $gps, 'devices' => $devices]);
    }

    /**
     * @author SSK
     * 
     * to save device warranty
     */
    public function AddWarranty(Request $request)
    {
        // compare dates 
        if ($request->period_from <= $request->period_to) 
        {
            $device_warranty = GpsWarranty::create([
                'gps_id'=> $request->gps_id,
                'period_from' => $request->period_from,
                'period_to' => $request->period_to
            ]);
            if($device_warranty)
            {
                $request->session()->flash('message', 'Warranty added successfully!');
                $request->session()->flash('alert-class', 'alert-success');
                return redirect(route('device.warranty'));
            }
        }
        else
        {
            $request->session()->flash('message', 'Please select valid date period for warranty!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('device.warranty'));
        }
        
    }

    /**
     * @author SSK
     * 
     * to get the active warranty of device
     */
    public function getActiveWarranty(Request $request)
    {
        $active_warranty = GpsWarranty::select('id','gps_id','period_from','period_to','expired_on','expired_reason')
        ->where('gps_id',$request->gps_id)
        ->orderBy('period_from','desc')
        ->with('gps:id,imei')
        ->first();
        if($active_warranty == null)
        {
            $gps = Gps::select('id','imei')->where('id',$request->gps_id)->first();
        }
        else
        {
            $gps = '';
        }
        $data = ['active_warranty' => $active_warranty, 'gps' => $gps];
        return $data;
    }

    /**
     * @author SSK
     * 
     * to edit device warranty
     */
    public function EditWarranty(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $details = GpsWarranty::select('id','gps_id','period_from','period_to','expired_on','expired_reason')
        ->where('id',$id)
        ->first();
        $active_warranty = GpsWarranty::select('id','gps_id','period_from','period_to','expired_on','expired_reason')
        ->where('gps_id',$details->gps_id)
        ->orderBy('period_from','desc')
        ->with('gps:id,imei')
        ->first();
        return view('Gps::edit-device-warranty', [ 'details' => $details, 'active_warranty' => $active_warranty]);
    }

    /**
     * @author SSK
     * 
     * to save edited device warranty details
     */
   /* public function UpdateWarranty(Request $request)
    {
        // compare dates 
        if ($request->period_from <= $request->period_to) 
        {
            $device_warranty = GpsWarranty::find($request->id);
            $device_warranty->period_from = $request->period_from;
            $device_warranty->period_to = $request->period_to;
            $device_warranty->save();
            $request->session()->flash('message', ' Warranty details updated successfully!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('device.warranty'));
        }
        else
        {
            $decrypted_id = encrypt($request->id);
            $request->session()->flash('message', 'Please select valid date period for warranty!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('edit.warranty',$decrypted_id));  
        }
    }*/
    

    //validation for gps creation
    public function gpsCreateRules(){
        $rules = [
            'serial_no' => 'required|unique:gps',
            'manufacturing_date' => 'required',
            'e_sim_number' => 'required|string|unique:gps|min:11|max:13',
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
     //validation for gps creation
    public function gpsStockCreateRules(){
        $rules = [
            'manufacturing_date' => 'required',
            // 'e_sim_number' => 'required|string|unique:gps|min:11|max:11',
            'serial_no' => 'required|unique:gps,serial_no,',
        ];
        return  $rules;
    }

 //validation for gps creation
    public function otaCreateRules(){
        $rules = [
            'command' => 'required',
            // 'e_sim_number' => 'required|string|unique:gps|min:11|max:11',
            'gps_id' => 'required',
        ];
        return  $rules;
    }

    //validation for gps updation
    public function gpsUpdateRules($gps){
        $rules = [
            'serial_no' => 'required|unique:gps_summery,serial_no,'.$gps->id,
            'imei' => 'required|string|min:15|max:15|unique:gps_summery,imei,'.$gps->id,
            'manufacturing_date' => 'required',
            'icc_id' => 'required',
            'imsi' => 'required',
            // 'e_sim_number' => 'required|string|min:11|max:11|unique:gps,e_sim_number,'.$gps->id,
            'batch_number' => 'required',
            'employee_code' => 'required',
            'model_name' => 'required',
            'version' => 'required',
        ];
        return  $rules;
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



   
    public function UpdateWarranty(Request $request)
    {


      /*  if ($request->hasFile('products_csv')) {
           


            ini_set('max_execution_time', 300); 
            $file = $request->file('products_csv');
            $import = new KsrtcImport;
            $import->import($file);
        }*/

        $gps_id=$request->gps_id;
        $gps=Gps::find($gps_id);
        if ($request->hasFile('products_csv')) {
           


            ini_set('max_execution_time', 300); 
        
        

            $file = $request->file('products_csv');
            $originalName = $file->getClientOriginalName();
            $cleanName = preg_replace('/\s+/', '_', $originalName); // Replace spaces with _
            $cleanName = preg_replace('/[^A-Za-z0-9._-]/', '', $cleanName); // Remove special chars
    
            // Optionally add unique prefix or timestamp
             $filename = time() . '_' . $cleanName;


    // Move file to public/uploads
             $file->move(public_path('uploads'), $filename);

            //$filePath = $request->file('products_csv')->store('uploads', 'public');
            $gps->warrenty_certificate = $filename;
        }
       
        $gps->save();
        $request->session()->flash('message', ' Warranty details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        if(\Auth::user()->hasRole(['Call_Center'])){
            return redirect(route('renewed-gps'));
        }else{
            return redirect(route('gps.all'));
        }
       
       // alert()->success('Products detail added successfully.', 'Added');
       // return redirect()->route('gps.all')->withSuccess('');
    }

    //finance login details 

    public function renewalgpsList()
    {
        
    


       /* $best_performer_day =  DB::select("SELECT * FROM `gps_summery` where pay_status=1 and pay_date='2025-07-01' AND id not in (select gps_id from gps_orders)"); 
       
        foreach($best_performer_day  as $data){

        $latestOrder = GpsOrder::orderBy('ordid','DESC')->first();
        
        if( $latestOrder ){
            $ordid= $latestOrder->ordid + 1;
            $orderno = 'VIOT/2024-'.date("Y").'/'. $ordid;
           
        }else{
            $orderno = 'VIOT/2024-'.date("Y").'/1666';
        }

        $order= new GpsOrder();
        $order->order_id = $orderno;
        $order->gps_id =$data->id;
        $order->delivery_name = "";
        $order->delivery_address = "";
        $order->total_amount = $data->amount??0;
        $order->payment_status = 1;
        $order->ordid =$ordid;
        $order->save();
        }*/
        return view('Gps::renewal-gps-list');
    }

    public function getRenewalgpsList(Request $request)
    {
           $all_devices = GpsOrder::with('gps')->orderBy('created_at', 'desc')->get();
          return DataTables::of($all_devices)
       
        ->addIndexColumn()

       ->editColumn('dealer_name', function ($all_devices) {
            if($all_devices->gps->renewed_by!="Customer"){
                 return $all_devices->delivery_name??"";
            }
            else{
                return "-";
            }
           // return "No Distributor";
        })
        ->editColumn('customer_name', function ($all_devices) {
            if($all_devices->gps->renewed_by=="Customer"){
                 return $all_devices->delivery_name??"";
            }
            else{
                return "-";
            }
           // return "No Distributor";
        })   
        ->addColumn('action', function ($all_devices) {
            $b_url = \URL::to('/');$b="";
            
                $b.= "
                <a href=".$b_url."/sim/details/".Crypt::encrypt($all_devices->gps_id)." class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
             
            
            if($all_devices->gps->pay_status){
                  
                if($all_devices->gps->warrenty_certificate){

                  $b.= "<a href=".$b_url."/uploads/".$all_devices->warrenty_certificate." class='btn btn-success btn-sm' download>Download Certificate</a>";
                }
               $b.="<a href=".$b_url."/download-invoice/".$all_devices->gps_id." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Invoice'>Download Invoice </a>";
                  
                 
                   //$b.= "<a href='".$all_devices->warrenty_certificate."' class='btn btn-success btn-sm' download>Download Certificate</a>";
     
                
            }
            else{
                 return "";
            }
             return $b;
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    //view gps details
    public function simDetails(Request $request)
    {

       
        $eid=$request->id;
        $decrypted_id = Crypt::decrypt($request->id);
        $order =  GpsOrder::with('gps')->where('gps_id',$decrypted_id)->first();
        if($order == null){
            return view('Gps::404');
        }
        if($order->gps->vehicle){
            $client_id  = $order->vehicle->client->id;
            $vehicle_id = $order->gps->vehicle->id;
            if($client_id==1778){
            return view('Gps::sim-ksrtc',['gps' => $order,'eid' => $eid]);
            }else{
                return view('Gps::sim-details',['gps' => $order,'eid' => $eid]);   
            }
        }else{
            return view('Gps::sim-details',['gps' => $order,'eid' => $eid]);
        }
       
    }



    // cmc invoice 



    public function cmcParsing()
    {
       
        $today = Carbon::today();

        $data = KsrtcCmc::where('renew_date', '<=', Carbon::today())->get();
        $ordid=1666;
        $latestOrder = KsrtcRenew::orderBy('ordid','DESC')->first();
        
        if( $latestOrder ){
            $ordid= $latestOrder->ordid + 1;
            $orderno = 'VMOB/2024-'.date("Y").'/'. $ordid;
           
        }else{
            $orderno = 'VMOB/2024-'.date("Y").'/1666';
        }
        foreach ($data  as $item) {
                $new_renew_date=Carbon::parse($item->renew_date)->addMonths(6);
                if(Carbon::parse($item->renew_date)->addMonths(6)->lte($today))
                {


                    $total=$item->total_gps*600;
                    $vat=$total*0.18;
                    $item->renew_date= $new_renew_date;
                    $item->is_renewd=1;
                    $item->save();
                
                    $KsrtcRenew=new KsrtcRenew();
                
                    $KsrtcRenew->cmc_id=$item->id;
                    $KsrtcRenew->from_date=$item->renew_date;
                    $KsrtcRenew->to_date=$new_renew_date;
                    $KsrtcRenew->total_amount=$total;
                    $KsrtcRenew->gst_amount=$vat;
                    $KsrtcRenew->order_id= $orderno;
                    $KsrtcRenew->ordid=$ordid;
                    $KsrtcRenew->save();
                    

                }
            
        
        }
      


die;

        
      

/*$data = DB::table('vehicles as v')
    ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
    ->select(
        DB::raw('COUNT(v.gps_id) AS total_gps'),
        DB::raw('GROUP_CONCAT(v.gps_id) AS gps_ids'),
        DB::raw('GROUP_CONCAT(g.imei) AS imeis'),
        DB::raw('GROUP_CONCAT(v.name) AS vehicle_nos'),
        DB::raw('DATE_FORMAT(v.validity_date, "%Y-%m-%d") AS month_year')
    )
    ->where('v.client_id', 1778)
    ->whereNotNull('v.validity_date')
    ->groupBy(DB::raw('YEAR(v.validity_date), MONTH(v.validity_date)'))
    ->orderBy(DB::raw('MIN(v.validity_date)'))
    ->get();

        foreach ($data  as $record) {
            
            $ksrtc=new KsrtcCmc();
            $ksrtc->total_gps=$record->total_gps;
            $ksrtc->gps_ids=$record->gps_ids;
            $ksrtc->imeis=$record->imeis;
            $ksrtc->vehicle_nos=$record->vehicle_nos;
            $ksrtc->validity_date=$record->month_year;
            $ksrtc->renew_date=$record->month_year;
            $ksrtc->save();
        }




*/

die;

        $results = Vehicle::join('gps_summery as g', 'g.id', '=', 'vehicles.gps_id')
        ->select('vehicles.gps_id', 'g.installation_date', 'vehicles.id')
        ->where('vehicles.client_id', 1778)
        ->get();
        foreach ($results as $record) {

                $today = Carbon::today();


            $installation_date=$record->installation_date ??"";
            //return $validy;
            $previous = Carbon::parse($installation_date);
           
            $adjustedDate = $previous->copy()->addYears(2);
            $record->installation_date=$previous;
            $record->validity_date=$adjustedDate;
            $record->save();
       }

       die;


















        // Example: loop through users/customers/contracts
        $records = (new Vehicle())->getVehicleListBasedOnClient(1778);  
        
        $ordid=1666;
        $latestOrder = GpsOrder::orderBy('ordid','DESC')->first();
        
        if( $latestOrder ){
            $ordid= $latestOrder->ordid + 1;
            $orderno = 'VIOT/2024-'.date("Y").'/'. $ordid;
           
        }else{
            $orderno = 'VIOT/2024-'.date("Y").'/1666';
        }
        foreach ($records as $record) {

           

            if($record->inv_generated){
                // already generated

                $Vehicle=Vehicle::find($record->id);

                          //return $validy;
                $previous = Carbon::parse($record->next_due_date);
               
                $today = Carbon::today();
    
                $diffInMonths = $previous->diffInMonths($today, false);

                if ($diffInMonths >= 6) {

                    $halfYears = floor($diffInMonths / 6);

                    $remainingMonths = $diffInMonths % 6;
                    //
                    $uptDueDate = $adjustedDate->copy()->addMonths($diffInMonths-$remainingMonths);
                            // Next due date = today + remaining months
                    $nextDueDate =$uptDueDate->copy()->addMonths(6);
            


                    $order= new GpsOrder();
                    $order->order_id = $orderno;
                    $order->gps_id = $record->gps->id;
                    $order->delivery_name ='KSRTC';
                    $order->delivery_address = 'ksrtc';
                    $order->total_amount =  $halfYears*600;
                    $order->payment_status = 1;
                    $order->ordid =$ordid;
                 //   $order->save();
                    $Vehicle->inv_generated=1;
                    $Vehicle->next_due_date=$uptDueDate->toDateString();
                   // $Vehicle->save();

                }

            }else{
                $installation_date=optional($record->gps)->installation_date ??"";
                //return $validy;
                $previous = Carbon::parse($installation_date);
               
                $adjustedDate = $previous->copy()->addYears(2);
        
                $results = Gps::select('id', 'validity_date', 'installation_date_new', 'installation_date')
                ->whereIn('id', Vehicle::where('client_id', 1778)->pluck('gps_id'))
                ->whereNull('installation_date_new')
                ->get();
              
                if($gp->installation_date_new==null){
                    $gp->installation_date_new=$previous;
                    $gp->validity_date=$adjustedDate;
                    $gp->save();
               }
             //die;

                $today = Carbon::today();
       
        // Total difference in months
               $diffInMonths = $adjustedDate->diffInMonths($today, false);

           /* if ($diffInMonths >= 6) {

              
                //
                $remainingMonths = $diffInMonths % 6;
        //
                $uptDueDate = $adjustedDate->copy()->addMonths($diffInMonths-$remainingMonths);
                // Next due date = today + remaining months
                $nextDueDate =$uptDueDate->copy()->addMonths(6);

                $halfYears = floor($diffInMonths / 6);

                echo  $halfYears;
                $order= new GpsOrder();
                $order->order_id = $orderno;
                $order->gps_id = $record->gps->id;
                $order->delivery_name ='KSRTC';
                $order->delivery_address = 'ksrtc';
                $order->total_amount =  $halfYears*600;
                $order->payment_status = 1;
                $order->ordid =$ordid;
               // $order->save();

                $Vehicle->inv_generated=1;
                $Vehicle->next_due_date=$uptDueDate->toDateString();
                //$Vehicle->save();
            }*/
    
        // Remaining months after dividing by half-yearly (6 months)
      
         }
            // Assume record has a "previous_date" field (MM/DD/YYYY format)
           

          

        }

    }


/// recursive function



function renewCmcRecords($today = null)
{
    $today = $today ?? Carbon::today();

    $data = KsrtcCmc::where('renew_date', '<=', $today)->get();
    if ($data->isEmpty()) {
        return;
    }

    // Get or set starting order id
    $latestOrder = KsrtcRenew::orderBy('ordid', 'DESC')->first();
    $ordid = $latestOrder ? $latestOrder->ordid + 1 : 1666;
    $orderno = 'VMOB/2024-' . date("Y") . '/' . $ordid;

    foreach ($data as $item) {
        $renew_date = Carbon::parse($item->renew_date);
        $new_renew_date = $renew_date->copy()->addMonths(6);

        // If still due for renewal (<= today)
        if ($new_renew_date->lte($today)) {

            // Calculate totals
            $total = $item->total_gps * 600;
            $vat = $total * 0.18;

            // Update KsrtcCmc
            $item->renew_date = $new_renew_date;
            $item->is_renewd = 1;
            $item->save();

            // Insert into KsrtcRenew
            $KsrtcRenew = new KsrtcRenew();
            $KsrtcRenew->cmc_id = $item->id;
            $KsrtcRenew->from_date = $renew_date;
            $KsrtcRenew->to_date = $new_renew_date;
            $KsrtcRenew->total_amount = $total;
            $KsrtcRenew->gst_amount = $vat;
            $KsrtcRenew->order_id = $orderno;
            $KsrtcRenew->ordid = $ordid;
            $KsrtcRenew->save();
        }
    }

    // Recursively check again after updates
    $this->renewCmcRecords($today);
}






//returns gps as json
public function getAllCmcList(Request $request)
{
    $all_devices=[];
    if(\Auth::user()->hasRole('Driver')){
        $user_id= \Auth::user()->id;
        $vehicles = Vehicle::select('id','register_number','name','gps_id')
    ->where('driver_id',$user_id)->first();
    if($vehicles){
            $all_devices         = Gps::find($vehicles->gps_id);
        }
        
    }else{
        $all_devices = KsrtcCmc::orderBy('id')->get();  


    }
    return DataTables::of($all_devices)
   
    ->addIndexColumn()

   ->editColumn('is_renewd', function ($all_devices) {
        if($all_devices->is_renewd){
             return "Renewd";
        }
        else{
            return "Not Renewed Yet";
        }
       // return "No Distributor";
    })
    
    ->addColumn('action', function ($all_devices) {
        $b_url = \URL::to('/');$b="";
        
            if($all_devices->is_renewd){

               // $path = 'uploads/'.$all_devices->warrenty_certificate;

               $b.="<a href=".$b_url."/download-invoice/".$all_devices->id." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Invoice'>Download Invoice </a>";
              
             
               //$b.= "<a href='".$all_devices->warrenty_certificate."' class='btn btn-success btn-sm' download>Download Certificate</a>";
 
            
        }
        else{
             return "";
        }
         return $b;
    })
    ->rawColumns(['link', 'action'])
    ->make();
}




    // Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $otp = rand(100000, 999999);

        // Save OTP
        Otp::updateOrCreate(
            ['mobile' => $request->mobile],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(5)]
        );


        $message ="Your%20VST%20IOT%20login%20OTP%20is%20".$otp ;
        $template_id = "1707174143336789806";
       // $ss=$this->sendmessage($message, $request->mobile, $template_id);
        // ✅ You can integrate any SMS API here (Twilio, MSG91, etc.)
        // Example (pseudo):
        // SmsService::send($request->mobile, "Your OTP is: $otp");

        return response()->json(['success' => true, 'message' => 'OTP sent successfully!']);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6'
        ]);

        $otpData = Otp::where('mobile', $request->mobile)
                      ->where('otp', $request->otp)
                      ->first();

        if (!$otpData) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP']);
        }

        if (Carbon::now()->gt($otpData->expires_at)) {
            return response()->json(['success' => false, 'message' => 'OTP expired']);
        }

        // OTP valid → delete record
        $otpData->delete();

        return response()->json(['success' => true, 'message' => 'OTP verified successfully!']);
    }



    public function sendmessage($message,$mobile,$template_id)
    {



       
        $publicKey="82a371fc70e8d9450a2b96b35d4c2365";
       
       $url="http://login.draft4sms.com/api/smsapi?key=".$publicKey."&route=2&sender=IOTVST&number=".$mobile."&sms=".$message."&templateid=".$template_id;


        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $result = curl_exec($ch);
      //  print_r( $result);die;
        
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return  $result;



    }


    public function invisbleAPI($vehicleNo){

       $clientId="79de8680f26b4b8c4b2c2037fd32ae70:7bf6f7c13efd4b6f922b1026e7604e8e";
       $secretKey="ecjInSlBlhnAYiGdVSZtbPOTOrJzx30qxj7Dt9G5wCLspIZn1jGOLyomdZcYb5WuF";
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'clientId' =>$clientId ,
                'secretKey' => $secretKey,
            ])->post('https://api.invincibleocean.com/invincible/vehicleRegistrationV10', [
                'vehicleNumber' => $vehicleNo,
            ]);

            // Get response body
            $data = $response->json(); // or $response->body()

            return $data;

            // Optional: debug
            // dd($data);

    }
    
    public function clientrenewalreport(Request $request) {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
    
        // ---------------------------
        // ROOT USER VIEW (Vehicle list)
        // ---------------------------
        if ($user->root) {
    
            $rows = Gps::query()
                ->whereNotNull('installation_date_new')
                ->whereNotNull('vehicle_no')
                ->whereNotNull('validity_date')
                ->selectRaw('MONTH(installation_date_new) as month_no')
                ->selectRaw('COUNT(id) as total_installed')
                ->selectRaw('SUM(CASE WHEN pay_status = 1 THEN 1 ELSE 0 END) as renewed')
                ->groupBy('month_no')
                ->orderBy('month_no')
                ->get()
                ->keyBy('month_no');
    
            $serviceRows = ServiceIn::query()
                ->selectRaw('MONTH(`date`) as month_no')
                ->selectRaw('COUNT(id) as service_visits')
                ->groupBy('month_no')
                ->orderBy('month_no')
                ->get()
                ->keyBy('month_no');
    
            $totalservicevisits = $serviceRows->sum('service_visits');
    
            $baseMonths = [];
            for ($m = 1; $m <= 12; $m++) {
                $total = isset($rows[$m]) ? (int)$rows[$m]->total_installed : 0;
                $renewed = isset($rows[$m]) ? (int)$rows[$m]->renewed : 0;
                $serviceVisits = isset($serviceRows[$m]) ? (int)$serviceRows[$m]->service_visits : 0;
    
                $baseMonths[$m] = [
                    'month_no' => $m,
                    'month_name' => Carbon::createFromDate(2000, $m, 1)->format('M'),
                    'total_installed' => $total,
                    'renewed' => $renewed,
                    'not_renewed' => max(0, $total - $renewed),
                    'service_visits' => $serviceVisits,
                ];
            }
    
            $months = [];
            for ($m = 1; $m <= 12; $m++) {
    
                $installedNow = $baseMonths[$m]['total_installed'];
                $renewedNow = $baseMonths[$m]['renewed'];
                $notNow = $baseMonths[$m]['not_renewed'];
    
                $months[] = [
                    'month_no' => $m,
                    'month_name' => $baseMonths[$m]['month_name'],
    
                    'total_installed' => $installedNow,
    
                    'renewal_needed' => $installedNow,
                    'renewed' => $renewedNow,
                    'not_renewed' => $notNow,
    
                    'service_visits' => $baseMonths[$m]['service_visits'],
                ];
            }
    
            return view('Gps::root-renewal-report', compact('months', 'totalservicevisits'));
        }
    
        // ---------------------------
        // NORMAL CLIENT USER (existing report)
        // ---------------------------
        if (!$user->client) {
            abort(403, 'Unauthorized');
        }
    
        $client_id = $user->client->id;
    
        if ((int)$client_id !== 1778) {
            abort(403, 'Access denied');
        }
    
        // ---------------------------
        // 1) Install + Renewed data
        // ---------------------------
        $rows = Vehicle::query()
            ->where('vehicles.client_id', $client_id)
            ->whereNotNull('vehicles.installation_date')
            ->leftJoin('gps_summery', 'gps_summery.id', '=', 'vehicles.gps_id')
            ->selectRaw('MONTH(vehicles.installation_date) as month_no')
            ->selectRaw('COUNT(vehicles.id) as total_installed')
            ->selectRaw('SUM(CASE WHEN gps_summery.pay_status = 1 THEN 1 ELSE 0 END) as renewed')
            ->groupBy('month_no')
            ->orderBy('month_no')
            ->get()
            ->keyBy('month_no');
    
        // ---------------------------
        // 2) Service visits month-wise (ONLY for client vehicles)
        // ---------------------------
    
        $serviceRows = ServiceIn::query()
            ->from('cd_service_ins as si')
            ->join('vehicles as v', 'v.register_number', '=', 'si.vehicle_no')
            ->where('v.client_id', $client_id)
            ->selectRaw('MONTH(si.`date`) as month_no')
            ->selectRaw('COUNT(si.id) as service_visits')
            ->groupBy('month_no')
            ->orderBy('month_no')
            ->get()
            ->keyBy('month_no');
    
    
        $totalservicevisits = $serviceRows->sum('service_visits');
    
        // ---------------------------
        // 3) Base months (Jan-Dec)
        // ---------------------------
        $baseMonths = [];
        for ($m = 1; $m <= 12; $m++) {
            $total = isset($rows[$m]) ? (int)$rows[$m]->total_installed : 0;
            $renewed = isset($rows[$m]) ? (int)$rows[$m]->renewed : 0;
    
            $serviceVisits = isset($serviceRows[$m]) ? (int)$serviceRows[$m]->service_visits : 0;
    
            $baseMonths[$m] = [
                'month_no' => $m,
                'month_name' => Carbon::createFromDate(2000, $m, 1)->format('M'),
                'total_installed' => $total,
                'renewed' => $renewed,
                'not_renewed' => max(0, $total - $renewed),
                'service_visits' => $serviceVisits,
            ];
        }
    
        // ---------------------------
        // 4) Final months with renewal_needed = (month + month+6)
        // ---------------------------
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
    
            $m6 = $m + 6;
            if ($m6 > 12) {
                $m6 -= 12;
            }
    
            $installedNow = $baseMonths[$m]['total_installed'];
            $installedM6  = $baseMonths[$m6]['total_installed'];
    
            $renewedNow = $baseMonths[$m]['renewed'];
            $renewedM6  = $baseMonths[$m6]['renewed'];
    
            $notNow = $baseMonths[$m]['not_renewed'];
            $notM6  = $baseMonths[$m6]['not_renewed'];
    
            $renewalNeeded = $installedNow + $installedM6;
            $renewedTotal  = $renewedNow + $renewedM6;
            $notTotal      = $notNow + $notM6;
    
            $months[] = [
                'month_no' => $m,
                'month_name' => $baseMonths[$m]['month_name'],
    
                'total_installed' => $installedNow,
    
                'renewal_needed' => $renewalNeeded,
                'renewed' => $renewedTotal,
                'not_renewed' => $notTotal,
    
                'service_visits' => $baseMonths[$m]['service_visits'],
                'amount' => $renewalNeeded * 708,
            ];
        }
    
        return view('Gps::client-renewal-report', compact('months', 'totalservicevisits'));
    }
    
           
}