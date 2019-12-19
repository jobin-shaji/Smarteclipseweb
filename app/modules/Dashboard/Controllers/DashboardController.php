<?php
namespace App\Modules\Dashboard\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Driver\Models\Driver;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Geofence\Models\Geofence;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Operations\Models\VehicleModels;

use App\Modules\User\Models\User;
use App\Modules\Warehouse\Models\GpsStock;
use DataTables;
use DB;
use Carbon\Carbon; 
use Config;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(\Auth::user()->roles());
        if(\Auth::user()->hasRole('root')){
            return view('Dashboard::dashboard');  
        }
        else if(\Auth::user()->hasRole('dealer')){
            return view('Dashboard::dashboard');  
        }
        else if(\Auth::user()->hasRole('sub_dealer')){
            return view('Dashboard::dashboard');  
        }
        else if(\Auth::user()->hasRole('servicer')){
            return view('Dashboard::dashboard');  
        }
        else if(\Auth::user()->hasRole('school')){
           return $this->schoolIndex();            
        }
        else if(\Auth::user()->hasRole('client')){
            return $this->clientDashboardIndex();            
        }
        else{
            return view('Dashboard::dashboard');  
        }        
    }
    function schoolIndex(){
        $client_id=\Auth::user()->client->id;
        $alerts =  $this->getAlerts($client_id);      
        $vehicles = Vehicle::select('id','register_number','name','gps_id')
        ->where('client_id',$client_id)
        ->get();        
        $single_vehicle =  $this->getSingleVehicle($client_id);
        $expired_documents =  $this->getExpiredDocuments($single_vehicle);
        $expire_documents =  $this->getExpireDocuments($single_vehicle); 
        return view('Dashboard::dashboard',['alerts' => $alerts,'expired_documents' => $expired_documents,'expire_documents' => $expire_documents,'vehicles' => $vehicles]); 
    }
    function clientDashboardIndex()
    {
        $client_id=\Auth::user()->client->id;
        $alerts =  $this->getAlerts($client_id);  
        $gps_stocks = GpsStock::select('gps_id')->where('client_id',$client_id)->get(); 
        $single_gps_in_stocks=[];
        foreach ($gps_stocks as $gps) {
            $single_gps_in_stocks[]=$gps->gps_id;
        }
        $gpss = Gps::select('id')->whereNotNull('lat')->whereNotNull('lon')->get(); 
        $single_gps=[];
        foreach ($gpss as $gps) {
            $single_gps[]=$gps->id;
        }       
        $vehicles = Vehicle::select('id','register_number','name','gps_id')
        ->where('client_id',$client_id)
        ->whereIn('gps_id',$single_gps)
        ->get();
        $single_vehicle =  $this->getSingleVehicle($client_id);
        $expired_documents =  $this->getExpiredDocuments($single_vehicle);
        $expire_documents =  $this->getExpireDocuments($single_vehicle); 
        $client=Client::where('id',$client_id)->first(); 
        return view('Dashboard::dashboard',['alerts' => $alerts,'expired_documents' => $expired_documents,'expire_documents' => $expire_documents,'vehicles' => $vehicles,'client' => $client]);
    }
    function getAlerts($client_id){
        $user = \Auth::user();;
        $single_gps =  $this->getVehicleGps($client_id,$user->id);
        $userAlerts = UserAlerts::select(
            'id',
            'client_id',
            'alert_id',
            'status'
        )
        ->with('alertType:id,code,description') 
        ->where('status',1)               
        ->where('client_id',$client_id)           
        ->get();
        $alert_id=[];
        foreach ($userAlerts as $userAlert) {
              $alert_id[]=$userAlert->alert_id;
           } 
        $alerts = Alert::select(
            'id',
            'alert_type_id',
            'status',
            'gps_id',
            'created_at'
        )
        ->with('alertType:id,code,description')
        ->with('vehicle:id,name,register_number')
        ->whereIn('gps_id',$single_gps)
        ->whereIn('alert_type_id',$alert_id)
        ->whereNotIn('alert_type_id',[17,18,23,24])
        ->orderBy('id', 'desc')->take(5)
        ->get();       
        return $alerts; 
    }
    function getSingleVehicle($client_id){
        $vehicles = Vehicle::select('id','register_number','name')
        ->where('client_id',$client_id)
        ->get();
        $single_vehicle = [];
        foreach($vehicles as $vehicle){
            $single_vehicle[] = $vehicle->id;
        }
        return $single_vehicle; 
    }
    function getExpiredDocuments($single_vehicle){        
        $expired_documents=Document::select([
            'id',
            'vehicle_id',
            'document_type_id',
            'expiry_date'
        ])
        ->with('vehicle:id,name,register_number')
        ->with('documentType:id,name')
        ->whereIn('vehicle_id',$single_vehicle)
        ->whereDate('expiry_date', '<', date('Y-m-d'))
        ->get();
        return $expired_documents;        
    }
    function getExpireDocuments($single_vehicle){
        $expire_documents=Document::select([
            'id',
            'vehicle_id',
            'document_type_id',
            'expiry_date'
        ])
        ->with('vehicle:id,name,register_number')
        ->with('documentType:id,name')
        ->whereIn('vehicle_id',$single_vehicle)
        ->whereBetween('expiry_date', [date('Y-m-d'), date('Y-m-d', strtotime("+10 days"))])
        ->get();
        return $expire_documents;
    }
    public function dashCount(Request $request)
    {
        $user = $request->user();
        $dealers=Dealer::where('user_id',$user->id)->first();
        $subdealers=SubDealer::where('user_id',$user->id)->first();
        $client=Client::where('user_id',$user->id)->first(); 
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));      
        if($user->hasRole('root')){
            return $this->rootDashboardView();             
        }
        else if($user->hasRole('dealer')){
            return $this->dealerDashboardView($user); 
        }
        else if($user->hasRole('sub_dealer')){
            return $this->subDealerDashboardView($user);           
        }
        else if($user->hasRole('servicer')){
            return $this->servicerDashboardView($user);           
        }
        else if($user->hasRole('client')){
            $vehicle_status=$this->vehicleRunningStatus($client->id);
            return response()->json($vehicle_status);           
        }else if($user->hasRole('school')){
            return response()->json([
                // 'gps' => Gps::where('user_id',$user->id)->count(),
                'vehicles' => Vehicle::where('client_id',$client->id)->count(),
                'geofence' => Geofence::where('user_id',$user->id)->count(),
                'moving' => $moving,
                'idle' => $idle,
                'stop' => $stop,
                'offline' => $offline,
                'status' => 'dbcount'           
            ]);
        }else if($user->hasRole('operations')){
            return response()->json([
                'gps' => Gps::all()->count(),
                'gps_stock' => GpsStock::all()->count(),
                'gps_to_verify' => Gps::all()->count()-GpsStock::all()->count(),

                'gps_today' => Gps::WhereDate('manufacturing_date',date("Y-m-d"))->count(),
                // 'gps_add_to_stock' => GpsStock::WhereDate('created_at',date("Y-m-d"))->count(),


                'status' => 'dbcount'           
            ]);
        }            
    }
    function rootDashboardView()
    {
        $gps_manufactured = Gps::all()->count();
        $gps_nontransferred_stock = GpsStock::whereNull('dealer_id')->whereNull('subdealer_id')->whereNull('client_id')->count();
        $gps_transferred = GpsStock::whereNotNull('dealer_id')->count();
        $gps_to_be_added_to_stock = $gps_manufactured-($gps_nontransferred_stock+$gps_transferred);
        return response()->json([
            'gps_manufactured' => $gps_manufactured, 
            'gps' => $gps_nontransferred_stock, 
            'gps_transferred' => $gps_transferred, 
            'gps_to_be_added_to_stock' => $gps_to_be_added_to_stock, 
            'dealers' => Dealer::all()->count(), 
            'subdealers' => SubDealer::all()->count(),
            'clients' => Client::all()->count(),
            'vehicles' => Vehicle::all()->count(),
            'status' => 'dbcount'
        ]);
    }
    function servicerDashboardView($user)
    {
        $servicer_id=$user->servicer->id;
        return response()->json([
            
            'pending_jobs' => ServicerJob::whereNull('job_complete_date')
             ->where('servicer_id',$servicer_id)->where('job_type',1)->count(), 
             'pending_service_jobs' => ServicerJob::whereNull('job_complete_date')->where('servicer_id',$servicer_id) ->where('job_type',2)->count(), 
            'completed_jobs' => ServicerJob::whereNotNull('job_complete_date')->where('servicer_id',$servicer_id)->where('job_type',1)->where('status',3)->count(),
            'service_completed_jobs' => ServicerJob::whereNotNull('job_complete_date')->where('servicer_id',$servicer_id)->where('job_type',2)->where('status',3)->count(),
            'all_pending_jobs' => ServicerJob::where('job_date','<',date('Y-m-d H:i:s'))->where('status',2)->where('servicer_id',$servicer_id)->count(), 

            'status' => 'dbcount'
        ]);
    }
    
    function dealerDashboardView($user){
        $dealer_user_id=$user->id;
        $dealer_id=$user->dealer->id;
        $total_gps=GpsStock::where('dealer_id',$dealer_id)->whereNull('subdealer_id')->count();
        $sub_dealers_of_dealers=SubDealer::select('id')->where('dealer_id',$dealer_id)->get();
        $single_sub_dealers_array=[];
        foreach($sub_dealers_of_dealers as $sub_dealers_array){
            $single_sub_dealers_array[] = $sub_dealers_array->id;
        }
        $transferred_accepted_gps_count=GpsStock::whereIn('subdealer_id',$single_sub_dealers_array)->where('dealer_id',$dealer_id)->count();
        $transferred_gps_count=GpsStock::where('dealer_id',$dealer_id)->where('subdealer_id',0)->count();  
        $total_transferred_gps=$transferred_accepted_gps_count+$transferred_gps_count;

        $single_new_transfer_ids=[];
        $new_arrival_gps_count=0;
        $new_arrival_gps=GpsTransfer::where('to_user_id',$dealer_user_id)->whereNull('accepted_on')->get();
        if($new_arrival_gps){
            foreach ($new_arrival_gps as $new_gps) {
               $single_new_transfer_ids[] = $new_gps->id;
            }
            $new_arrival_gps_count=GpsTransferItems::whereIn('gps_transfer_id',$single_new_transfer_ids)->count();
        }


        return response()->json([
            'subdealers' => SubDealer::where('dealer_id',$dealer_id)->count(),
            'clients' => Client::whereIn('sub_dealer_id',$single_sub_dealers_array)->count(),
            'new_arrivals' => $new_arrival_gps_count,
            'total_gps' => $total_gps,
            'transferred_gps' => $total_transferred_gps,
            'status' => 'dbcount'           
        ]);
    }
    function subDealerDashboardView($user){
        $sub_dealer_user_id=$user->id;
        $sub_dealer_id=$user->subdealer->id;
        $total_gps=GpsStock::where('subdealer_id',$sub_dealer_id)->count();
        $clients_of_subdealers=Client::select('id')->where('sub_dealer_id',$sub_dealer_id)->get();
        $single_clients_array=[];
        foreach($clients_of_subdealers as $clients_array){
            $single_clients_array[] = $clients_array->id;
        }
        $transferred_gps_count=GpsStock::whereIn('client_id',$single_clients_array)->where('subdealer_id',$sub_dealer_id)->count(); 


        $single_new_transfer_ids=[];
        $new_arrival_gps_count=0;
        $new_arrival_gps=GpsTransfer::where('to_user_id',$sub_dealer_user_id)->whereNull('accepted_on')->get();
        if($new_arrival_gps){
            foreach ($new_arrival_gps as $new_gps) {
               $single_new_transfer_ids[] = $new_gps->id;
            }
            $new_arrival_gps_count=GpsTransferItems::whereIn('gps_transfer_id',$single_new_transfer_ids)->count();
        }

        return response()->json([
            'clients' => Client::where('sub_dealer_id',$sub_dealer_id)->count(),
            'new_arrivals' => $new_arrival_gps_count,
            'total_gps' => $total_gps,
            'transferred_gps' => $transferred_gps_count,
            'status' => 'dbcount'           
        ]);
    }  

    function getVehicleGps($client_id,$user_id){
        $VehicleGpss=Vehicle::select(
            'id',
            'gps_id',
            'client_id'
        )
        ->where('client_id',$client_id)
        ->get();      
        $single_vehicle_gps = [];
        foreach($VehicleGpss as $VehicleGps){
            $single_vehicle_gps[] = $VehicleGps->gps_id;
        }
        return $single_vehicle_gps; 
    }

    function offlineGpsDataBasedOnDeviceTime($single_gps_id,$oneMinute_currentDateTime){
        $device_time=Gps::select('device_time')->where('id',$single_gps_id)->first();
        if($device_time){
            if($device_time->device_time < $oneMinute_currentDateTime){
                return $single_gps_id;
            }
        }else{
            return "0";
        }
        
    }

    function onlineGpsDataBasedOnDeviceTime($single_gps_id,$oneMinute_currentDateTime){
        $device_time=Gps::select('device_time')->where('id',$single_gps_id)->first();
        if($device_time){
            if($device_time->device_time >= $oneMinute_currentDateTime){
                return $single_gps_id;
            }
        }else{
            return "0";
        }
    }

    function getMoving($single_vehicle,$oneMinut_currentDateTime){
        $user = \Auth::user();   
        if($user->hasRole('client|school')){  
            $moving=Gps::where('mode','M')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime)
            ->where('id',$single_vehicle);
            $moving=$moving->count();
        }        
        else
        { 
            $moving=Gps::where('mode','M')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime);
            $moving=$moving->count();
        }
        return $moving; 
    }
    function getOffline($single_vehicle,$oneMinut_currentDateTime){
        $user = \Auth::user();         
        if($user->hasRole('client|school')){  
            $offline=Gps::whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','<',$oneMinut_currentDateTime)
            ->where('id',$single_vehicle);
            $offline=$offline->count();
        }        
        else
        {
            $offline=Gps::whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','<',$oneMinut_currentDateTime);
            $offline=$offline->count();
        }
        return $offline; 
    }
    function getIdle($single_vehicle,$oneMinut_currentDateTime){
        $user = \Auth::user(); 
        if($user->hasRole('client|school')){  
            $idle=Gps::where('mode','H')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime)
            ->where('id',$single_vehicle);
            $idle=$idle->count();
        }        
        else
        {
            $idle=Gps::where('mode','H')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime);
            $idle=$idle->count();
        }
        return $idle;
    }
    function getStop($single_vehicle,$oneMinut_currentDateTime){
        $user = \Auth::user();
        if($user->hasRole('client|school')){  
            $sleep=Gps::where('mode','S')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime)
            ->where('id',$single_vehicle);
            $sleep=$sleep->count();
        }        
        else
        {
            $sleep=Gps::where('mode','S')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime);
            $sleep=$sleep->count();
        }
        return $sleep;
    }
    //emergency alert
    public function emergencyAlerts(Request $request)
    {
        if($request->user()->hasRole('client')){
            $client_id=\Auth::user()->client->id;
            $all_gps=GpsStock::where('client_id',$client_id)->get();
            $single_gps=[];
            foreach ($all_gps as $gps) {
                $single_gps[]=$gps->gps_id;
            }
            $alerts = Alert::select(
                'id',
                'alert_type_id',
                'gps_id',
                'latitude',
                'longitude',
                'device_time'
            )
            //->with('vehicle:id,name,register_number,driver_id')
            ->with('gps.vehicle')
            ->with('gps.vehicle.driver')
            ->whereIn('gps_id',$single_gps)
            ->where('alert_type_id',21)
            ->where('status',0)
            ->get();
            if(sizeof($alerts) == 0){
                $response=[
                    'status' => 'failed'
                ];
            }else{
                $vehicle_id=$alerts[0]->gps->vehicle->id;
                $vehicle_id = Crypt::encrypt($vehicle_id);
                $response = [
                    'status' => 'success',
                    'alerts' => $alerts,
                    'vehicle' => $vehicle_id
                ];
            }
            return response()->json($response);
        } 
    }
    // emergency alert verification
    public function verifyEmergencyAlert(Request $request)
    {
        $decrypted_vehicle_id = Crypt::decrypt($request->id); 
        $vehicle=Vehicle::find($decrypted_vehicle_id);
        $alerts = Alert::where('alert_type_id',21)
        ->where('status',0)
        ->where('gps_id',$vehicle->gps_id)
        ->get();
        if($alerts == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Alert does not exist'
            ]);
        }
        foreach ($alerts as $alert) {
            $alert->status = 1;
            $alert->save();
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert verified successfully'
        ]);
     }
    //get place namee
    public function getLocationFromLatLng(Request $request)
    {
        $latitude = $request->latitude; 
        $longitude = $request->longitude;       
        if(!empty($latitude) && !empty($longitude)){
            $address =  $this->getAddress($latitude,$longitude);           
            if(!empty($address)){
                $location=$address;
            }
            return response()->json($location); 
        }
    }
    function getAddress($latitude,$longitude){
         //Send request and receive json data by address
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing&callback=initMap'); 
        $output = json_decode($geocodeFromLatLong);         
        $status = $output->status;
        //Get address from json data
        $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        return $address; 
    }

    public function getLocation(Request $request)
    {
        $gps_data=GpsData::select([
            'latitude as latitude',
            'longitude as longitude' 
        ])                    
        ->where('vehicle_id',$request->id) 
        ->orderBy('id','desc')                 
        ->get();      
        return response()->json($gps_data); 
    }

    public function vehicleDetails(Request $request)
    {
        $user = $request->user(); 
        $address="";
        $satelite=0;
        $gps = Gps::find($request->gps_id); 
        $offline_time_difference = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        $connection_lost_time_motion = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_motion').""));
        $connection_lost_time_halt = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_halt').""));
        $connection_lost_time_sleep = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_sleep').""));
        if($gps->no_of_satellites!=null){
         $satelite=$gps->no_of_satellites;   
        }
        $network_status=$gps->gsm_signal_strength;
        $ignition=$gps->ignition;
        if($user->hasRole('root')){
            $fuel_status="0"."%";
        }      
        else if($user->hasRole('pro|superior')){
            $gps_id= $request->gps_id;
            $vehicle=Vehicle::select(
                'id',
                'gps_id',
                'model_id',
                'client_id'
            )
            ->where('gps_id',$gps_id)
            ->first(); 
            $model= $vehicle->model_id;
            $vehicle_models=VehicleModels::select(
                'id',
                'fuel_min',
                'fuel_max'
            )
            ->where('id',$model)
            ->first();

            $fuel_gps=$gps->fuel_status;
            $fuel_min=$vehicle_models->fuel_min;
            $fuel_max=$vehicle_models->fuel_max;
            $modulus=$fuel_min-$fuel_max;
            $value=$vehicle_models->fuel_min-$fuel_gps;
            $fuel=($value/$modulus)*100;
            $ruel_round=round($fuel);
            $fuel_status=$ruel_round."%";
        }
        else
        {
            $fuel_status="upgrade version";
        }
        $speed=round($gps->speed);
        $gps_meter=$gps->km;
        $gps_km=$gps_meter/1000;
        $odometer=round($gps_km);
        $mode=$gps->mode;
        $satelite=$satelite;
        $latitude=$gps->lat;
        $longitude=$gps->lon;        
        if(!empty($latitude) && !empty($longitude)){
            $address =  $this->getAddress($latitude,$longitude); 
        }
        
        $battery_status=(int)$gps->battery_status;

        if($mode=="M")
        {
            if($network_status>=19 &&  $gps->device_time >= $connection_lost_time_motion)
            {
                $net_status="Good";
            }
            else if(($network_status<19 && $network_status>=13 &&  $gps->device_time >= $connection_lost_time_motion))
            {
                $net_status="Average";
            }
            else if(($network_status<=12 && $gps->device_time >= $connection_lost_time_motion))
            {
                $net_status="Poor";
            }else{
                $net_status="Connection Lost";
            }

            if($gps->device_time >= $offline_time_difference){
                $vehcile_mode="Moving";
            }else{
                $vehcile_mode="Offline";
            }
        }
        else if($mode=="H")
        {
            if($network_status>=19 &&  $gps->device_time >= $connection_lost_time_halt)
            {
                $net_status="Good";
            }
            else if(($network_status<19 && $network_status>=13 &&  $gps->device_time >= $connection_lost_time_halt))
            {
                $net_status="Average";
            }
            else if(($network_status<=12 && $gps->device_time >= $connection_lost_time_halt))
            {
                $net_status="Poor";
            }else{
                $net_status="Connection Lost";
            }

            if($gps->device_time >= $offline_time_difference){
                $vehcile_mode="Halt";
            }else{
                $vehcile_mode="Offline";
            }
        }
        else if($mode=="S")
        {
            if($network_status>=19 &&  $gps->device_time >= $connection_lost_time_sleep)
            {
                $net_status="Good";
            }
            else if(($network_status<19 && $network_status>=13 &&  $gps->device_time >= $connection_lost_time_sleep))
            {
                $net_status="Average";
            }
            else if(($network_status<=12 && $gps->device_time >= $connection_lost_time_sleep))
            {
                $net_status="Poor";
            }else{
                $net_status="Connection Lost";
            }

            if($gps->device_time >= $offline_time_difference){
                $vehcile_mode="Sleep";
            }else{
                $vehcile_mode="Offline";
            }
        }
        else 
        {
            $net_status="Connection Lost";
            $vehcile_mode="Offline";
        }
        if($ignition == 1){
            $ignition="On";
        }else{
            $ignition="Off";
        }
        if($gps){     
            $response_data = array(
                'status'  => 'vehicle_status',
                'network_status' => $net_status,
                'fuel_status' => $fuel_status,
                'speed' => $speed.' km/h',
                'odometer' => $odometer.' km',
                'mode' => $vehcile_mode,
                'satelite' => $satelite,
                'battery_status' => $battery_status.' %',
                'ignition' => $ignition,
                'address' => $address
            );
        }
        else{
            $response_data = array(
            'status'  => 'failed',
            'message' => 'failed',
            'code'    =>0);
        }            
        return response()->json($response_data); 
    }
    public function vehicleList(Request $request)
    {
        $user = $request->user();       
        $client=Client::where('user_id',$user->id)->first();
        $query=Vehicle::select(
            'id',
            'name',
            'register_number',
            'client_id'
        )
        ->where('client_id',$client->id);
        $vehicles = $query->get();     
        return DataTables::of($vehicles)
        ->addIndexColumn()
        ->addColumn('km', function ($vehicles) {               
            return "-";               
        })
       ->make();
    }

    public function dashVehicleTrack(Request $request)
    {
        $user = $request->user(); 
        if($user->hasRole('client|school')){
            $client=Client::where('user_id',$user->id)->first();
            $response_track_data=$this->vehicleRunningDetails($client->id); 
        }else{
            $vehiles_details=Gps::Select(
                'id',
                'lat',
                'lat_dir',
                'imei',
                'lon',
                'lon_dir',
                'mode',
                'device_time'
            )
            ->whereNotNull('mode')
            ->whereNotNull('lat') 
            ->whereNotNull('lon')  
            ->orderBy('id','desc')                 
            ->get(); 
            $response_track_data=$this->vehicleDataListRoot($vehiles_details); 
        }  
        
        if($response_track_data){     
                 $response_data = array(
                'user_data'  => $response_track_data,
                'status'=>'Status'
            );
        }
        else{
                $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0);
        }
        return response()->json($response_data); 
    }

    public function vehicleRunningDetails($client_id)
    {  
        $vehicleTrackData=[];
        $last_updated_time = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        $clients_gps=Client::where('id',$client_id)
                                    ->with(['vehicles'=>function($vehicle)
                                     {$vehicle->with(['gps'=>function($item){
                                      $item->where('status',1);
                                     }]);
                                    }])->get();
        foreach ($clients_gps as $item) 
        {
            foreach($item->vehicles as $vehicle){
                if($vehicle->gps && $vehicle->gps->lat != null){
                    if($vehicle->gps->mode=="M"){
                        if($vehicle->gps->device_time >= $last_updated_time){
                            $mode="M";
                        }else{
                            $mode="O";
                        }
                    }else if($vehicle->gps->mode=="H"){
                        if($vehicle->gps->device_time >= $last_updated_time){
                            $mode="H";
                        }else{
                            $mode="O";
                        }
                    }else if($vehicle->gps->mode=="S"){
                        if($vehicle->gps->device_time >= $last_updated_time){
                            $mode="S";
                        }else{
                            $mode="O";
                        }
                    }
                    $vehicle_id=Crypt::encrypt($vehicle->id);
                    $encrypt_gps_id=Crypt::encrypt($vehicle->gps->id);
                    $vehicleTrackData[]=array(
                                        "id"=>$vehicle->gps->id,
                                        "lat"=>$vehicle->gps->lat,
                                        "lat_dir"=>$vehicle->gps->lat_dir,
                                        "lon"=>$vehicle->gps->lon,
                                        "lon_dir"=>$vehicle->gps->lon_dir,
                                        "imei"=>$vehicle->gps->imei,
                                        "mode"=>$mode,
                                        "vehicle_id"=> $vehicle_id,
                                        "encrypt_gps_id"=> $encrypt_gps_id,
                                        "vehicle_name"=>$vehicle->name,
                                        "register_number"=>$vehicle->register_number,
                                        "vehicle_svg"=>$vehicle->vehicleType->svg_icon,
                                        "vehicle_scale"=>$vehicle->vehicleType->vehicle_scale,
                                        "opacity"=>$vehicle->vehicleType->opacity,
                                        "strokeWeight"=>$vehicle->vehicleType->strokeWeight,
                                        "device_time"=>$vehicle->gps->device_time
                                        );     
                    }
            }

        }
        return $vehicleTrackData;
    }


    public function vehicleDataListRoot($vehiles_details){
        $vehicleTrackData=[];
        $last_updated_time = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        foreach ($vehiles_details as $single_gps) 
        {
            if($single_gps->lat != null){
                if($single_gps->mode=="M"){
                    if($single_gps->device_time >= $last_updated_time){
                        $mode="M";
                    }else{
                        $mode="O";
                   }
                }else if($single_gps->mode=="H"){
                    if($single_gps->device_time >= $last_updated_time){
                        $mode="H";
                    }else{
                        $mode="O";
                    }
                }else if($single_gps->mode=="S"){
                    if($single_gps->device_time >= $last_updated_time){
                        $mode="S";
                    }else{
                        $mode="O";
                    }
                }
                $gps_ecrypt_id=Crypt::encrypt($single_gps->id);
                $vehicleTrackData[]=array(
                                    "id"=>$single_gps->id,
                                    "lat"=>$single_gps->lat,
                                    "lat_dir"=>$single_gps->lat_dir,
                                    "lon"=>$single_gps->lon,
                                    "lon_dir"=>$single_gps->lon_dir,
                                    "imei"=>$single_gps->imei,
                                    "gps_encrypt_id"=>$gps_ecrypt_id,
                                    "mode"=>$mode,
                                    "vehicle_id"=>"",
                                    "vehicle_name"=>"",
                                    "register_number"=>"",
                                    "vehicle_svg"=>"M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805",
                                   "vehicle_scale"=>0.5,
                                   "opacity"=>0.5,
                                   "strokeWeight"=>0.5,
                                   "device_time"=>$single_gps->device_time
                                ); 
            }


        }
        return $vehicleTrackData;
    }

    public function vehicleTrackList(Request $request)
    {
        $gps_id=$request->gps_id;     
        $user_data=Gps::Select('lat','lat_dir','lon','lon_dir')
        ->where('id',$gps_id)                 
        ->first();
        return response()->json($user_data); 
    }
    public function vehicleMode(Request $request)
    {
        $vehicle_mode=$request->vehicle_mode;
        $user = $request->user();  
        $oneMinute_currentDateTime=date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        if($user->hasRole('client|school')){
            $client=Client::where('user_id',$user->id)->first();
            $gps_id =  $this->getVehicleGps($client->id,$user->id);      
            // userID list of vehicles
            if($vehicle_mode=='O')
            {         
                $vehiles_details=Gps::Select(
                    'id',
                    'lat',
                    'lat_dir',
                    'lon',
                    'lon_dir',
                    'imei',
                    'mode',
                    'device_time'
                  )
                ->with('vehicle:gps_id,id,name,register_number')
                ->where('device_time','<',$oneMinute_currentDateTime) 
                ->whereIn('id',$gps_id)    
                ->whereNotNull('lat') 
                ->whereNotNull('lon')         
                ->orderBy('id','desc')                 
                ->get(); 
            }
            else
            {
                $vehiles_details=Gps::Select(
                    'id',
                    'lat',
                    'lat_dir',
                    'lon',
                    'lon_dir',
                    'imei',
                    'mode',
                    'device_time'
                )
                ->with('vehicle:gps_id,id,name,register_number')
                ->where('device_time','>=',$oneMinute_currentDateTime)             
                ->where('mode',$vehicle_mode)
                ->whereIn('id',$gps_id) 
                ->whereNotNull('lat') 
                ->whereNotNull('lon')         
                ->orderBy('id','desc')                 
                ->get(); 
            }
            $response_track_data=$this->vehicleDataList($vehiles_details); 
        }
        else
        {              
            if($vehicle_mode=='O')
            {
                $vehiles_details=Gps::Select(
                    'id',
                    'lat',
                    'imei',
                    'lat_dir',
                    'lon',
                    'lon_dir',
                    'mode',
                    'device_time'
                  )
                ->where('device_time','<',$oneMinute_currentDateTime)    
                ->whereNotNull('lat') 
                ->whereNotNull('lon')                       
                ->get();  
            }
            else
            {
                $vehiles_details=Gps::Select(
                    'id',
                    'lat',
                    'lat_dir',
                    'lon',
                    'lon_dir',
                    'imei',
                    'mode',
                    'device_time'
                )           
                ->where('mode',$vehicle_mode)
                ->where('device_time','>=',$oneMinute_currentDateTime)
                ->whereNotNull('lat') 
                ->whereNotNull('lon')                         
                ->get(); 
            }
            $response_track_data=$this->vehicleDataListRoot($vehiles_details); 
        }
        
        if($response_track_data){     
                 $response_data = array(
                'user_data'  => $response_track_data,
                'status'=>'Status'
            );
        }
        else{
            $response_data = array(
            'status'  => 'failed',
            'message' => 'failed',
            'code'    =>0);
        }
        return response()->json($response_data); 
    }
    public function locationSearch(Request $request)
    {
        $lat=$request->lat;
        $lng=$request->lng; 
        $radius=$request->radius;
        $user = $request->user(); 
        $client=Client::where('user_id',$user->id)->first();
        $gps_id =  $this->getVehicleGps($client->id,$user->id);
        $vehicle_by_search=Gps::select('gps.id' ,'gps.lat','gps.lat_dir','gps.lon','gps.mode','device_time'
        ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
        * cos(radians(gps.lat)) 
        * cos(radians(gps.lon) - radians(" . $lng . ")) 
        + sin(radians(" .$lat. ")) 
        * sin(radians(gps.lat))) AS distance"))
        ->groupBy("gps.id")
        ->having('distance','<=',$radius)
        ->with('vehicle:gps_id,id,name,register_number')
        ->whereIn('id',$gps_id)    
        ->get();
        $response_track_data=$this->vehicleDataList($vehicle_by_search);        
        if($response_track_data){     
            $response_data = array(
                'user_data'  => $response_track_data,
                'status'=>'success'
            );
        }else{
                $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0);
        }
        return response()->json($response_data); 
    }

    function twoDateTimeDiffrence($date1,$date2){
        $date1 = strtotime($date1);  
        $date2 = strtotime($date2);  
        $diff = abs($date2 - $date1); 
        $minutes = round($diff/60);
        return $minutes;
    }

    public function notification(Request $request)
    {
        $user = $request->user();  
        $client=Client::where('user_id',$user->id)->first();
        $client_id=$client->id;
        $single_vehicle=  $this->getSingleVehicle($client_id);
        // $expired_documents =  $this->getExpiredDocuments($single_vehicle);
        // $expire_documents =  $this->getExpireDocuments($single_vehicle);        
        $expired_documents=Document::select([
                'id',
                'vehicle_id',
                'document_type_id',
                'expiry_date'
        ])
        ->with('vehicle:id,name,register_number')
        ->with('documentType:id,name')
        ->whereIn('vehicle_id',$single_vehicle)
        ->whereDate('expiry_date', '<', date('Y-m-d'))
        ->orderBy('expiry_date','DESC')
        ->take(3)
        ->get();    
        // dd($single_vehicle);
        $expire_documents=Document::select([
            'id',
            'vehicle_id',
            'document_type_id',
            'expiry_date'
        ])
        ->with('vehicle:id,name,register_number')
        ->with('documentType:id,name')
        ->whereIn('vehicle_id',$single_vehicle)
        ->where('expiry_date','>=', [date('Y-m-d')])
        ->orderBy('expiry_date','DESC')
        ->take(5)
        ->get();
       if($user->hasRole('client')){
            return response()->json([            
                'expired_documents' => $expired_documents,
                'expire_documents' => $expire_documents,
                'status' => 'notification'           
            ]);
        }  
    }
    public function rootGpsSale(Request $request)
    {
       
        $root_id=\Auth::user()->root->id;
        $gps_transfer_id=$this->getGpsSale($root_id);                    
        $gps=$this->getGpsTransfer($gps_transfer_id);
        $gps_month = [];
        $gps_count = [];
        foreach($gps as $gps_sale){
            $gps_count[] = $gps_sale->count;
            $gps_month[] = $gps_sale->month;
        }
        $gps_sale=array(
                    "gps_count"=>$gps_count,
                    "gps_month"=>$gps_month
                );
        return response()->json($gps_sale); 
    }
    function getGpsSale($root_id){
        $gps_transfers = GpsTransfer::select('id',
            'from_user_id',
            'to_user_id'
        )
        ->where('from_user_id', $root_id)
        ->whereNotNull('accepted_on')
        ->get();
        $gps_transfer_id = [];
        foreach($gps_transfers as $gps_transfer){
            $gps_transfer_id[] = $gps_transfer->id;
        }   
        return $gps_transfer_id;
    }
    function getGpsTransfer($gps_transfer_id){
       $gps = GpsTransferItems::select(
            'id',
            'gps_transfer_id',
            'gps_id',
            \DB::raw('date_format(created_at, "%M") as month'),
            \DB::raw('count(date_format(created_at, "%M")) as count')             
        )
        ->with('gps:id,imei')
        ->with('gpsTransfer:id,imei')
        ->whereIn('gps_transfer_id',$gps_transfer_id)
         ->orderBy("month","DESC") 
        ->groupBy("month")  
        ->get();
        return $gps;
    }
    public function rootGpsUsers(Request $request)
    {
        
        $root_id=\Auth::user()->root->id;       
        $dealer=Dealer::all()->count();
        $sub_dealer=SubDealer::all()->count();
        $client=Client::all()->count();
        $gps_user=array(
                    "dealer"=>$dealer,
                    "sub_dealer"=>$sub_dealer,
                    "client"=>$client                   
                );
        return response()->json($gps_user); 
    }

    public function dealerGpsSale(Request $request)
    {
        $user_id=\Auth::user()->id;
        $gps_transfer_id=$this->getGpsSale($user_id);                    
        $gps=$this->getGpsTransfer($gps_transfer_id);
        $gps_month = [];
        $gps_count = [];
        foreach($gps as $gps_sale){
            $gps_count[] = $gps_sale->count;
            $gps_month[] = $gps_sale->month;
        }
        $dealer_gps_sale=array(
            "gps_count"=>$gps_count,
            "gps_month"=>$gps_month
        );
        return response()->json($dealer_gps_sale); 
    }

    //////////////////////////////Dealer GPS User//////////////////////////////

    public function dealerGpsUsers(Request $request)
    {
        
        $dealer_id=\Auth::user()->dealer->id; 
        $sub_dealers = SubDealer::select('id','name')
        ->where('dealer_id',$dealer_id)
        ->get();
        $single_sub_dealer = [];
        foreach($sub_dealers as $sub_dealer){
            $single_sub_dealer[] = $sub_dealer->id;
        }
        $client = Client::select('id','name')
        ->whereIn('sub_dealer_id',$single_sub_dealer)
        ->count();         
        $dealer_gps_user=array(
                   
                    "sub_dealer"=>$sub_dealers->count(),
                    "client"=>$client                   
                );
        return response()->json($dealer_gps_user); 
    }

    ///////////////////////Sub Dealer GPS Count//////////////////////////////////
    public function subDealerGpsSale(Request $request)
    {
       
        $user_id=\Auth::user()->id;
        $gps_transfer_id=$this->getGpsSale($user_id);                    
        $gps=$this->getGpsTransfer($gps_transfer_id); 
        $gps_month = [];
        $gps_count = [];
        foreach($gps as $gps_sale){
            $gps_count[] = $gps_sale->count;
            $gps_month[] = $gps_sale->month;
        }
        $sub_dealer_gps_sale=array(
            "gps_count"=>$gps_count,
            "gps_month"=>$gps_month
        );
        return response()->json($sub_dealer_gps_sale); 
    }    
    //Sub Delaer gps users
    public function subDealerGpsUsers(Request $request)
    {       
        $sub_dealer_id=\Auth::user()->subDealer->id;
        $clients = Client::select('id','name','address','user_id')
        ->where('sub_dealer_id',$sub_dealer_id)
        ->get();
        $single_client=[];
        $single_client_name=[];
        foreach($clients as $client){
            
            $single_client[] = $client->id;
        }
        $vehicles = Vehicle::select('id','name','register_number','gps_id','client_id',
            \DB::raw('count(id) as count') )
        ->whereIn('client_id',$single_client)
        ->with('client:id,name')
        ->groupBy('client_id')
        ->get();
        $gps_count = [];
        foreach($vehicles as $gps_sale){           
                $gps_count[] = $gps_sale->count;
                $single_client_name[] = $gps_sale->client->name;
                               
        }
        $sub_dealer_gps_sale=array(
            "client"=>$single_client_name,
            "gps_count"=>$gps_count
        );
        return response()->json($sub_dealer_gps_sale); 
    }
    public function mapView()
    {
        $gps = Gps::select('id','imei')->whereNotNull('lat')->whereNotNull('lon')->get();
        return view('Dashboard::map-view',['gpss' => $gps]);
    }

     public function vehicleModeCount(Request $request)
    {
        $user = $request->user();
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        $single_vehicle=0;
            
        $moving =  $this->getMoving($single_vehicle,$oneMinut_currentDateTime);
        $offline =  $this->getOffline($single_vehicle,$oneMinut_currentDateTime);
        $idle =  $this->getIdle($single_vehicle,$oneMinut_currentDateTime);
        $stop =  $this->getStop($single_vehicle,$oneMinut_currentDateTime);           
        return response()->json([
           'moving' => $moving,
            'idle' => $idle,
            'stop' => $stop,
            'offline' => $offline,
            'status' => 'vehicleModeCount'           
        ]);     
    }


    public function vehicleRunningStatus($client_id){
        $date_before_eleven_minutes = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        $sleep=0;
        $online=0;
        $halt=0;
        $offline=0;
        $count=0;       
        $clients_gps=Client::where('id',$client_id)->with(['vehicles'=>function($vehicle)
          {$vehicle->with(['gps'=>function($item){
                          $item->where('status',1);
                         }]);
          }])->get();
        foreach ($clients_gps as $item) 
        {
            foreach($item->vehicles as $vehicle){
                if($vehicle->gps && $vehicle->gps->lat != null){
                    if($vehicle->gps->mode=="M"){
                        if($vehicle->gps->device_time  >= $date_before_eleven_minutes){
                            $online=$online+1;
                        }else{
                            $offline=$offline+1;
                        }
                    }else if($vehicle->gps->mode=="H"){
                        if($vehicle->gps->device_time  >= $date_before_eleven_minutes){
                            $halt=$halt+1;
                        }else{
                            $offline=$offline+1;
                        }
                    }else if($vehicle->gps->mode=="S"){
                        if($vehicle->gps->device_time >= $date_before_eleven_minutes){
                            $sleep=$sleep+1;
                        }else{
                            $offline=$offline+1;
                        }
                    }
                    $count++;
                }
            }
        }
        $vehicle_status=["moving"=>$online,
                          "idle"=>$halt,
                          "stop"=>$sleep,
                          "offline"=>$offline,
                          "total_vehicles"=>$count,
                          'status' => 'dbcount' 
                        ];
        return $vehicle_status;
    }

    function vehicleDataList($vehiles_details){
        $vehicleTrackData=array();
        foreach ($vehiles_details as $vehicle_data) {
            $vehicle_ecrypt_id=Crypt::encrypt($vehicle_data->vehicle->id);
            $gps_ecrypt_id=Crypt::encrypt($vehicle_data->id);
            $single_vehicle=Vehicle::find($vehicle_data->vehicle->id);
            $single_vehicle_type= $single_vehicle->vehicleType;
            $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
            if($vehicle_data->device_time >= $oneMinut_currentDateTime)
            {
                $modes=$vehicle_data->mode;
            }
            else
            {
               $modes= "O";
            }
            $vehicleTrackData[]=array(
                "id"=>$vehicle_data->id,
                "lat"=>$vehicle_data->lat,
                "lat_dir"=>$vehicle_data->lat_dir,
                "lon"=>$vehicle_data->lon,
                "lon_dir"=>$vehicle_data->lon_dir,
                "imei"=>$vehicle_data->imei,
                "mode"=>$modes,
                "vehicle_id"=>$vehicle_ecrypt_id,
                'encrypt_gps_id'=>$gps_ecrypt_id,
                "vehicle_name"=>$vehicle_data->vehicle->name,
                "register_number"=>$vehicle_data->vehicle->register_number,
                "vehicle_svg"=>$single_vehicle_type->svg_icon,
                "vehicle_scale"=>$single_vehicle_type->vehicle_scale,
                "opacity"=>$single_vehicle_type->opacity,
                "strokeWeight"=>$single_vehicle_type->strokeWeight,
                "device_time"=>$vehicle_data->device_time
                );
        }
        return $vehicleTrackData;
    }
}
