<?php
namespace App\Modules\DeviceReturn\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Modules\DeviceReturn\Models\DeviceReturn;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Trader\Models\Trader;
use DataTables;
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
     
        $client_id=\Auth::user()->client->id;
        $rules = $this->device_return_create_rules();
        $this->validate($request, $rules);
    
            $device = DeviceReturn::create([
                'gps_id' => $request->gps_id,
                'type_of_issues' => $request->type_of_issues,
                'comments' => $request->comments,
                'client_id' => $client_id,
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s')
            ]);
       
        $request->session()->flash('message', 'New Device Return registered successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('device')); 
    }
    public function DeviceReturnListPage()
    {
        if(\Auth::user()->hasRole('client')){
            return view('DeviceReturn::device-return-list');
        }
    }  
    public function getDeviceList()
    {
            $device_return = DeviceReturn::select(
                'id', 
                'gps_id',                      
                'type_of_issues',
                'comments',                                        
                'created_at',
                'client_id'
                  )
            ->with('gps:id,imei,serial_no')
            ->orderBy('id','desc');
           
            if(\Auth::user()->hasRole('client'))
            {
                $client_id=\Auth::user()->client->id;
                $device_return = $device_return->where('client_id',$client_id);
            }
            $device_return = $device_return->get();
         
            return DataTables::of($device_return)
            ->addIndexColumn()
            ->addColumn('type_of_issues', function ($device_return) { 
                if($device_return->type_of_issues==0){
                    return "Hardware";
                }
                else {
                    return "software";
                }
                })
           ->rawColumns(['link', 'action'])
            ->make();
        
    }
  
    public function device_return_create_rules()
    {
        $rules = [
            'gps_id' => 'required',       
            'type_of_issues' =>'required',
            'comments' => 'required'
                 ];
        return  $rules;
    }
   
   
}
