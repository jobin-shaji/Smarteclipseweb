<?php
namespace App\Modules\Driver\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Models\ClientAlertPoint;
use App\Modules\Subdealer\Models\Subdealer;
use App\Modules\Driver\Models\Driver;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class DriverController extends Controller {
   
    //employee creation page
    public function create()
    {
       return view('Driver::driver-create');
    }
    //upload employee details to database table
    public function save(Request $request)
    {    
        $client_id=\Auth::user()->client->id; 
        if($request->user()->hasRole('client')){
            $rules = $this->driver_create_rules();
            $this->validate($request, $rules);           
            $client = Driver::create([            
                'name' => $request->name,            
                'address' => $request->address,
                'mobile' => $request->mobile,
                'client_id' => $client_id, 
                'points' => 100          
            ]);

            // User::where('username', $request->username)->first()->assignRole('client');
        }
        $eid= encrypt($client->id);
        $request->session()->flash('message', 'New Driver created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
         return redirect(route('drivers'));        
    }
    public function driverList()
    {
        return view('Driver::driver-list');
    }
    public function driver_create_rules()
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|unique:drivers',
            
        ];
        return  $rules;
    }
    public function getDriverlist(Request $request)
    {
        $client_id=\Auth::user()->client->id;

        $driver = Driver::select(
        'id', 
        'name',                   
        'address',
        'mobile',
        'client_id',
        'deleted_at')
        ->withTrashed()
        ->where('client_id',$client_id)
        ->get();
        return DataTables::of($driver)
        ->addIndexColumn()
        ->addColumn('action', function ($driver) {
        if($driver->deleted_at == null){ 
            return "
            <a href=/driver/".Crypt::encrypt($driver->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> </a>
             <a href=/driver/".Crypt::encrypt($driver->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view!'><i class='fas fa-eye'></i></a>
            <button onclick=delDriver(".$driver->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> </button>";
        }else{                   
                return "
              
                <a href=/driver/".Crypt::encrypt($driver->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View!'><i class='fas fa-eye'></i> </a>
                <button onclick=activateDriver(".$driver->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $driver = Driver::find($decrypted);       
        if($driver == null)
        {
           return view('Driver::404');
        }
        return view('Driver::driver-edit',['driver' => $driver]);
    }

    //update dealers details
    public function update(Request $request)
    {
        $driver = Driver::where('id', $request->id)->first();
        if($driver == null){
           return view('Driver::404');
        } 
        $rules = $this->driverUpdateRules($driver);
        $this->validate($request, $rules);       
        $driver->name = $request->name;
        $driver->address = $request->address;
        $driver->mobile = $request->mobile;
        $driver->save();      
        $did = encrypt($driver->id);
        $request->session()->flash('message', 'Driver details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('driver.edit',$did));  
    }

    public function performanceScore()
    {
        $client =\Auth::user()->client;
        $driver_points = $client->driver_points;
       return view('Driver::driver-alert-type-score',['driver_points' => $driver_points,'client_id' => $client->id]);
    }

    // update alert type point
    public function updatePerformanceScore(Request $request)
    {
        $alert_type__first_id=1;
        $client_id=$request->id;
        $alert_type_point = ClientAlertPoint::select('id','alert_type_id','driver_point','client_id')
                    ->where('client_id',$client_id)
                    ->where('alert_type_id',1)
                    ->first();
         $alert_type_point->driver_point = $request->harsh_braking;
         $alert_type_point->save();
         $alert_type_point = ClientAlertPoint::select('id','alert_type_id','driver_point','client_id')
                    ->where('client_id',$client_id)
                    ->where('alert_type_id',12)
                    ->first();
         $alert_type_point->driver_point = $request->over_speed;
         $alert_type_point->save();
          $alert_type_point = ClientAlertPoint::select('id','alert_type_id','driver_point','client_id')
                    ->where('client_id',$client_id)
                    ->where('alert_type_id',13)
                    ->first();
         $alert_type_point->driver_point = $request->tilt;
         $alert_type_point->save();
         $alert_type_point = ClientAlertPoint::select('id','alert_type_id','driver_point','client_id')
                    ->where('client_id',$client_id)
                    ->where('alert_type_id',14)
                    ->first();
         $alert_type_point->driver_point = $request->impact;
         $alert_type_point->save();
         $alert_type_point = ClientAlertPoint::select('id','alert_type_id','driver_point','client_id')
                    ->where('client_id',$client_id)
                    ->where('alert_type_id',15)
                    ->first();
         $alert_type_point->driver_point = $request->over_speed_gf_entry;
         $alert_type_point->save();
         $alert_type_point = ClientAlertPoint::select('id','alert_type_id','driver_point','client_id')
                    ->where('client_id',$client_id)
                    ->where('alert_type_id',16)
                    ->first();
         $alert_type_point->driver_point = $request->over_speed_gf_exit;
         $alert_type_point->save();
        $request->session()->flash('message', 'Performance score updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('performance-score'));  
    }

     //validation for employee updation
    public function driverUpdateRules($driver)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric'
            
        ];
        return  $rules;
    }
    
    // details page
    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $driver=Driver::find($decrypted_id);
        if($driver==null){
            return view('Driver::404');
        } 
        return view('Driver::driver-details',['driver' => $driver]);
    }

  
     //delete Sub Dealer details from table
    public function deleteDriver(Request $request)
    {
        $driver = Driver::find($request->uid);
        if($driver == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'driver does not exist'
            ]);
        }
        $driver->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'driver deleted successfully'
        ]);
    }


    // restore emplopyee
    public function activateDriver(Request $request)
    {
        $driver = Driver::withTrashed()->find($request->id);
        if($driver==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'driver does not exist'
             ]);
        }

        $driver->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Driver restored successfully'
        ]);
    }
//update driver performance


     public function driverUpdateperformanceRules($driver)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric'
            
        ];
        return  $rules;
    }
}
