<?php
namespace App\Modules\DeviceReturn\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Modules\DeviceReturn\Models\DeviceReturn;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Trader\Models\Trader;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\VltData\Models\VltData;
use DataTables;
use DB;
class DeviceReturnController extends Controller {
    public function create()
    {
        $servicer_id=\Auth::user()->servicer->id;
        $servicer = Servicer::where('id',$servicer_id)->first();
              if($servicer->sub_dealer_id == null && $servicer->trader_id == null) 
                {
                     $client=Client::orderBy('name')->get();
            
                }
                    else if($servicer->trader_id != null&& $servicer->sub_dealer_id== null){
                    $trader_id=$servicer->trader_id;
                    $client=Client::where('trader_id',$trader_id)->get();
                    
                } else if($servicer->trader_id == null && $servicer->sub_dealer_id!= null){
                    $client=Client::where('sub_dealer_id',$servicer->sub_dealer_id)->get();
            
                }
       
        return view('DeviceReturn::device-return-create',['client'=>$client]);
    }

    public function save(Request $request)
    {
        $servicer_id=\Auth::user()->servicer->id;
        $rules = $this->device_return_create_rules();
        $this->validate($request, $rules);
    
                     $device = DeviceReturn::create([
                    'gps_id' => $request->gps_id,
                    'type_of_issues' => $request->type_of_issues,
                    'comments' => $request->comments,
                    'status' => 0,
                    'servicer_id' =>$servicer_id,
                    'created_at'=> date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ]);
         $request->session()->flash('message', 'New Device Return registered successfully!'); 
         $request->session()->flash('alert-class', 'alert-success'); 
         return redirect(route('device')); 
    }

    public function DeviceReturnListPage()
    {
       return view('DeviceReturn::device-return-list');   
    }  

    public function getDeviceList()
    {
            $device_return = DeviceReturn::select(
                    'id', 
                    'gps_id',                      
                    'type_of_issues',
                    'comments',                                        
                    'created_at',
                    'servicer_id','status'
                )
            ->with('gps:id,imei,serial_no')
            ->orderBy('id','desc');
            $servicer_id=\Auth::user()->servicer->id;
            $device_return = $device_return->where('servicer_id',$servicer_id)->get();
            
            return DataTables::of($device_return)
            ->addIndexColumn()
            ->addColumn('comments', function ($device_return) { 
            $str = mb_strimwidth("$device_return->comments", 0, 20, "...");
                       return $str;
              
                     })
            ->addColumn('type_of_issues', function ($device_return) { 
                if($device_return->type_of_issues==0){
                    return "Hardware";
                }
                else 
                {
                    return "software";
                }
                })
            ->addColumn('status', function ($device_return) { 
                
                    if($device_return->status==1){
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
                
                ->addColumn('action', function ($device_return) 
                {
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
    public function selectVehicle(Request $request)
    {
        $client_id=$request->client_id;

        $devices=DeviceReturn::all();
        $device_gps_id=[];
        foreach($devices as $device)
        {
            $device_gps_id[]= $device->gps_id;
        }

        $vehicle=GpsStock::select(
            'gps_id',
            'client_id'
        )
        ->with('gps')
        ->where('client_id',$client_id)
        // ->whereNotIn('gps_id',$device_gps_id)
        ->with('deviceReturn:gps_id,status')
        ->get();
    //  dd( $vehicle);
       
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
  
    //cancel device return
    public function cancelDeviceReturn(Request $request)
    {
        $device_return = DeviceReturn::find($request->id);
        $servicer_id=\Auth::user()->servicer->id;

                if($device_return->servicer_id  != $servicer_id){
                    return response()->json([
                        'status' => 0,
                        'title' => 'Error',
                        'message' => 'not a logged in servicer'
                    ]);
                }else{
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
     //accept device return
    public function acceptDeviceReturn(Request $request)
    {
                $device_return = DeviceReturn::find($request->id);
                $device_return->status=2;
                $device_return->save();
                $gps_data           = Gps::find($device_return->gps_id);
                $gps_data_in_stock  = GpsStock::where('gps_id',$device_return->gps_id)
                                        ->first();
                //old data stored in a variable for creating new row
                $imei =$gps_data->imei;
                $serial_no= $gps_data->serial_no;
                $manufacturing_date= $gps_data->manufacturing_date;
                $icc_id=$gps_data->icc_id;
                $imsi= $gps_data->imsi;
                $e_sim_number = $gps_data->e_sim_number;
                $batch_number= $gps_data->batch_number;
                $employee_code= $gps_data->employee_code;
                $model_name=$gps_data->model_name;
                $version= $gps_data->version;
                     
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
                 //To update imei in gps data
                
                 $gps_data=GpsData::where('imei',$imei)->update([
                    'imei' =>  $imei_incremented,
                     ]);
                     
                //To update imei in vlt data
                
                 $Vlt_Data=VltData::where('imei',$imei)->update([
                    'imei' =>  $imei_incremented,
                     ]);
                //To update imei in vlt data
                DB::table('vlt_data_archived')->where('imei',$imei)
                  ->update([
                    'imei' =>  $imei_incremented,
                     ]);

                //to create new row with returend gps
                $gps        = Gps::create([
                                'serial_no'=>$serial_no,
                                'icc_id'=>$icc_id,
                                'imsi'=>$imsi,
                                'imei'=>$imei,
                                'manufacturing_date'=>$manufacturing_date,
                                'e_sim_number'=>$e_sim_number,
                                'batch_number'=>$batch_number,
                                'model_name'=>$model_name,
                                'version'=>$version,
                                'employee_code'=>$employee_code,
                                'status'=>1
                            ]); 
                //to get user id of manufacture
                $root_id    =\Auth::user()->id;
                $gps_stock  = GpsStock::create([
                                    'gps_id'=> $gps->id,
                                    'inserted_by' => $root_id
                            ]); 
    
                
                return response()->json([
                    'status' => 1,
                    'title' => 'Success',
                    'message' => 'Device return Accepted successfully'
                    ]);
                
    }
    // for device return list in root
    public function deviceReturnRootHistoryList()
    {
              return view('DeviceReturn::device-return-root-history-list');
    }
    public function getdeviceReturnRootHistoryList()
    {
            $device_return = DeviceReturn::select(
                    'id', 
                    'gps_id',                      
                    'type_of_issues',
                    'comments',                                        
                    'created_at',
                    'servicer_id',
                    'status')
            ->with('gps:id,imei,serial_no')
            ->with('servicer:id,name')
            -> where('status', '!=' , 1)
            ->orderBy('id','desc');
            $device_return = $device_return->get();
            return DataTables::of($device_return)
            ->addIndexColumn()
            ->addColumn('comments', function ($device_return) { 
                $str = mb_strimwidth("$device_return->comments", 0, 20, "...");
                         return $str;
                
                       })
             ->addColumn('status', function ($device_return) { 
                
                if($device_return->status==1){
                    return "Cancelled";
                }
               else if($device_return->status==0){
                    return "Submitted";
                }
                else{
                    return "Accepted";
                }
                        
                })
            ->addColumn('type_of_issues', function ($device_return) { 
                if($device_return->type_of_issues==0){
                    return "Hardware";
                }
                else 
                {
                    return "Software";
                }
                })
            ->addColumn('action', function ($device_return) { 
               return "
                <a href=/device-return-detail-view/".Crypt::encrypt($device_return->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
               
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }
    
    //device return details view
    public function deviceReturnDetailview(Request $request)
    {
            $decrypted = Crypt::decrypt($request->id); 
            $device_return_details=DeviceReturn::find($decrypted); 
            if($device_return_details == null)
                {
                return view('DeviceReturn::404');
                }
            return view('DeviceReturn::device-return-view',['device_return_details' => $device_return_details]);
     }

    public function device_return_create_rules()
    {
                $rules = [
                    'gps_id' => 'required',       
                    'type_of_issues' =>'required',
                    'comments' => 'required|max:500'
                        ];
                return  $rules;
    }
      
   
   
}
