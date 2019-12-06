<?php
namespace App\Modules\Driver\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Models\ClientAlertPoint;
use App\Modules\Subdealer\Models\Subdealer;
use App\Modules\Driver\Models\Driver;
use App\Modules\Driver\Models\DriverBehaviour;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
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
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->rayfleetDriverCreateRules();
        }
        else if (strpos($url, $eclipse_key) == true) {
            $rules = $this->driver_create_rules();
        }
        else
        {
           $rules = $this->driver_create_rules();
        }
        
        $this->validate($request, $rules);           
        $client = Driver::create([            
            'name' => $request->name,            
            'address' => $request->address,
            'mobile' => $request->mobile,
            'client_id' => $client_id, 
            'points' => 100          
        ]);
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
            'mobile' => 'required|string|min:10|max:10|unique:drivers',
            
        ];
        return  $rules;
    }
    public function rayfleetDriverCreateRules()
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|string|min:11|max:11|unique:drivers',
            
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
             $b_url = \URL::to('/');
        if($driver->deleted_at == null){ 
            if(\Auth::user()->hasRole('fundamental|superior|pro')){
                // <a href=".$b_url."/driver/".Crypt::encrypt($driver->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view!'><i class='fas fa-eye'></i> View</a>
                return "
                <a href=".$b_url."/driver/".Crypt::encrypt($driver->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                <a href=".$b_url."/single-drivers-score/".Crypt::encrypt($driver->id)." class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'>Driver Score </a>
                
                <button onclick=delDriver(".$driver->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>";
            }else{
                return "
                <a href=".$b_url."/driver/".Crypt::encrypt($driver->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                <button onclick=delDriver(".$driver->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>";
            }
            
        }else{                   
            return "
          
            <button onclick=activateDriver(".$driver->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Activate</button>";
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
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->rayfleetDriverUpdateRules($driver);
        }
        else if (strpos($url, $eclipse_key) == true) {
            $rules = $this->driverUpdateRules($driver);
        }
        else
        {
           $rules = $this->driverUpdateRules($driver);
        }

        
        $this->validate($request, $rules);       
        $driver->name = $request->name;
        $driver->address = $request->address;
        $driver->mobile = $request->mobile;
        $driver->save();      
        $did = encrypt($driver->id);
        $request->session()->flash('message', 'Driver details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('driver.details',$did));  
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

    /// performance score history
    public function performanceScoreHistory()
    {
        // $client =\Auth::user()->client;
        $client_id=\Auth::user()->client->id;
       $drivers = Driver::select('id','name')
                    ->where('client_id',$client_id)
                    ->get();
       return view('Driver::performance-score-history',['drivers' => $drivers]);
    }

    public function performanceScoreHistoryList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $driver_id= $request->driver_id;            
        $from = $request->from_date;
        $to = $request->to_date;
        // dd($driver_id);
        $drivers = Driver::where('client_id',$client_id)->get();
        $single_drivers = [];
        foreach($drivers as $driver){
            $single_drivers[] = $driver->id;
        }
        $vehicles = Vehicle::where('client_id',$client_id)->whereIn('driver_id',$single_drivers)->get();
        $single_vehicle = [];
        foreach($vehicles as $vehicle){
            $single_vehicle[] = $vehicle->id;
        }
        $performance_Score = DriverBehaviour::select(
                'id',
                'vehicle_id',
                'driver_id',
                'gps_id',
                'alert_id',
                'points',                
                'created_at'
            )               
            ->with('alert:id,alert_type_id')
            ->with('driver:id,name')
            ->with('vehicle:id,name,register_number')
            ->with('gps:id,imei,serial_no'); 
            if($driver_id==null && $from==null && $to==null)
            {
                 $performance_Score = $performance_Score->whereIn('vehicle_id',$single_vehicle);
            }
            else if($driver_id!=null && $from==null && $to==null)
            {
                $performance_Score = $performance_Score->whereIn('vehicle_id',$single_vehicle)
                ->where('driver_id',$driver_id);
            }
            else
            {
                $performance_Score = $performance_Score->whereIn('vehicle_id',$single_vehicle)
                ->where('driver_id',$driver_id);
                if($from){
                  $search_from_date=date("Y-m-d", strtotime($from));
                  $search_to_date=date("Y-m-d", strtotime($to));
                  $performance_Score = $performance_Score->whereDate('created_at', '>=', $search_from_date)
                  ->whereDate('created_at', '<=', $search_to_date);
                }
            }       
            $performance_Score = $performance_Score->get();
            return DataTables::of($performance_Score)
            ->addIndexColumn()
            ->addColumn('description', function ($performance_Score) {
                $description=$performance_Score->alert->alertType->description;
                return $description;                    
            })  
            ->addColumn('date', function ($performance_Score) {
                $date=date("H:i:s d-m-y", strtotime($performance_Score->created_at));
                return $date;                    
            })            
        ->rawColumns(['link', 'action'])
        ->make();
    }
    //driver score page
    public function driverScorePage()
    {
        $client_id=\Auth::user()->client->id;         
        $drivers = Driver::select(
            'id',
            'name',
            'points'
        )
        ->where('client_id',$client_id)
        ->get();
       return view('Driver::driver-score',['drivers' => $drivers]);
    }


    public function singleDriverScorePage(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $driver = Driver::find($decrypted);       
        if($driver == null)
        {
           return view('Driver::404');
        }
        return view('Driver::single-driver-score',['id' => $decrypted]);
        // return view('Driver::driver-score',['id' => $request->id]);

    }

    //driver score
    public function driverScore(Request $request)
    {
        $driver=$request->driver;
       
        // if($driver){
        //     $driver_id=$request->driver;
        // }
        // else
        // {
        //    $driver_id=0; 
        // }
        $client_id=\Auth::user()->client->id;
        $drivers = Driver::select(
            'id',
            'name',
            'points'
        )
        ->where('client_id',$client_id);
        if($driver)
        {
          $drivers=$drivers->where('id',$driver);  
        }
        $drivers=$drivers->get();
        $single_driver_name = [];
        $single_driver_point = [];
        foreach($drivers as $driver){
            $single_driver_name[] = $driver->name;
            $single_driver_point[] = $driver->points;
        }
        $score=array(
                    "drive_data"=>$single_driver_name,
                    "drive_score"=>$single_driver_point
                );
        return response()->json($score); 
    }

    //driver score alerts
    public function driverScoreAlerts(Request $request)
    {
        $client_driver=$request->driver;
        if($client_driver){
            $driver_id=$request->driver;
        }
        else
        {
           $driver_id=0; 
        }
        $client_id=\Auth::user()->client->id;
        $gps_stocks = GpsStock::where('client_id',$client_id)->get();
        $single_gps_stock=[];
        foreach ($gps_stocks as $gps_stock) {
            $single_gps_stock[] = $gps_stock->gps_id;
        }
        $harsh_braking_alerts=Alert::where('alert_type_id',1)->whereIn('gps_id',$single_gps_stock)->get();
        $single_harsh_braking_alerts = [];
        foreach($harsh_braking_alerts as $harsh_braking_alert){
            $single_harsh_braking_alerts[] = $harsh_braking_alert->id;
        }
        $over_speed_alerts=Alert::where('alert_type_id',12)->whereIn('gps_id',$single_gps_stock)->get();
        $single_over_speed_alerts = [];
        foreach($over_speed_alerts as $over_speed_alert){
            $single_over_speed_alerts[] = $over_speed_alert->id;
        }
        $tilt_alerts=Alert::where('alert_type_id',13)->whereIn('gps_id',$single_gps_stock)->get();
        $single_tilt_alerts = [];
        foreach($tilt_alerts as $tilt_alert){
            $single_tilt_alerts[] = $tilt_alert->id;
        }
        $impact_alerts=Alert::where('alert_type_id',14)->whereIn('gps_id',$single_gps_stock)->get();
        $single_impact_alerts = [];
        foreach($impact_alerts as $impact_alert){
            $single_impact_alerts[] = $impact_alert->id;
        }
        $over_speed_gf_entry_alerts=Alert::where('alert_type_id',15)->whereIn('gps_id',$single_gps_stock)->get();
        $single_over_speed_gf_entry_alerts = [];
        foreach($over_speed_gf_entry_alerts as $over_speed_gf_entry_alert){
            $single_over_speed_gf_entry_alerts[] = $over_speed_gf_entry_alert->id;
        }
        $over_speed_gf_exit_alerts=Alert::where('alert_type_id',16)->whereIn('gps_id',$single_gps_stock)->get();
        $single_over_speed_gf_exit_alerts = [];
        foreach($over_speed_gf_exit_alerts as $over_speed_gf_exit_alert){
            $single_over_speed_gf_exit_alerts[] = $over_speed_gf_exit_alert->id;
        }
        // $driver=$request->driver;
        $drivers = Driver::where('client_id',$client_id);
        if($client_driver){
            $drivers = $drivers->where('id',$driver_id);
        }
        $drivers = $drivers->get();
        $score=[];
        foreach($drivers as $driver){
            $harsh_breaking_count=DriverBehaviour::where('driver_id',$driver->id)->whereIn('alert_id',$single_harsh_braking_alerts)->count();
            $overspeed_count=DriverBehaviour::where('driver_id',$driver->id)->whereIn('alert_id',$single_over_speed_alerts)->count();
            $tilt_count=DriverBehaviour::where('driver_id',$driver->id)->whereIn('alert_id',$single_tilt_alerts)->count();
            $impact_count=DriverBehaviour::where('driver_id',$driver->id)->whereIn('alert_id',$single_impact_alerts)->count();
            $overspeed_gf_entry_count=DriverBehaviour::where('driver_id',$driver->id)->whereIn('alert_id',$single_over_speed_gf_entry_alerts)->count();
            $overspeed_gf_exit_count=DriverBehaviour::where('driver_id',$driver->id)->whereIn('alert_id',$single_over_speed_gf_exit_alerts)->count();
            $background_border_color='rgba('.rand(1,255).','.rand(1,255).','.rand(1,255);
            $score[]=array(
                    'label' => $driver->name,    
                    'data'=>[$harsh_breaking_count, 
                            $overspeed_count,
                            $tilt_count,
                            $impact_count,       
                            $overspeed_gf_entry_count,
                            $overspeed_gf_exit_count
                            ],
                    'backgroundColor' => [$background_border_color.',.2)'],
                    'borderColor'=> [$background_border_color.',.7)'],
                    'borderWidth'=> 2
                    );
        }
        return response()->json($score); 
    }


    //Client Driver Create
    public function clientDriverCreate(Request $request)
    {

        $servicer_job_id= $request->servicer_job_id;         
        $driver_name= $request->driver_name;         
        $mobile = $request->mobile;
        $address = $request->address;
        $client_id = $request->client_id;
        $driver_mobile = Driver::select(
            'name',
            'mobile'               
        )               
        ->where('mobile',$mobile)
        ->count();
        if($driver_mobile==0)
        {
            if($driver_name!=null)
            {
                $create_driver= Driver::create([
                    'name' => $driver_name,
                    'mobile' => $mobile,
                    'address' => $address,
                    'points' => 100,
                    'client_id' => $client_id                    
                ]);                
            } 
            $driver_id=$create_driver->id;               
            return response()->json([
                'driver_id'=>$driver_id,
                'driver_name'=>$driver_name,
                'status' => 'driver'           
            ]);
        }
        else
        {
             return response()->json([               
                'status' => 'mobile_already'           
            ]);
        }
       
      
    }

     //validation for employee updation
    public function driverUpdateRules($driver)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|string|min:10|max:10|unique:drivers,mobile,'.$driver->id
            
        ];
        return  $rules;
    }
     //validation for employee updation
    public function rayfleetDriverUpdateRules($driver)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|string|min:11|max:11|unique:drivers,mobile,'.$driver->id
            
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
                'message' => 'Driver does not exist'
            ]);
        }
        $driver_delete=$driver->delete();
        if($driver_delete){
            $vehicle = Vehicle::where('driver_id', $driver->id)->first();
            if ($vehicle != null) {
                $vehicle->driver_id = null;
                $vehicle->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Driver deactivated successfully'
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
                'message' => 'Driver does not exist'
             ]);
        }

        $driver->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Driver activated successfully'
        ]);
    }
}
