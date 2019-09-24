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
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\User\Models\User;
use App\Modules\Warehouse\Models\GpsStock;
use DataTables;
use DB;
use Carbon\Carbon; 
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
        $vehicles = Vehicle::select('id','register_number','name','gps_id')
        ->where('client_id',$client_id)
        // ->with('gpsValue')
        ->get();
        $single_vehicle =  $this->getSingleVehicle($client_id);
        $expired_documents =  $this->getExpiredDocuments($single_vehicle);
        $expire_documents =  $this->getExpireDocuments($single_vehicle); 
        return view('Dashboard::dashboard',['alerts' => $alerts,'expired_documents' => $expired_documents,'expire_documents' => $expire_documents,'vehicles' => $vehicles]);
    }
    function getAlerts($client_id){
        $alerts = Alert::select(
            'id',
            'alert_type_id',
            'vehicle_id',
            'status',
            'created_at'
        )
        ->with('alertType:id,code,description')
        ->with('vehicle:id,name,register_number')
        ->where('client_id',$client_id)
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
        $currentDateTime=Date('Y-m-d H:i:s');
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));      
        if($client)
        {
            $single_vehicle =  $this->getVehicleGps($client->id,$user->id);    
            $moving =  $this->getMoving($single_vehicle,$oneMinut_currentDateTime,$currentDateTime);
            $offline =  $this->getOffline($single_vehicle,$oneMinut_currentDateTime); 
            $idle =  $this->getIdle($single_vehicle,$oneMinut_currentDateTime,$currentDateTime);
            $stop =  $this->getStop($single_vehicle,$oneMinut_currentDateTime,$currentDateTime);           
        }
        if($user->hasRole('root')){
            return $this->rootDashboardView();             
        }
        else if($user->hasRole('dealer')){
            return $this->dealerDashboardView($user);
           
        }
        else if($user->hasRole('sub_dealer')){
            return $this->subDealerDashboardView($user);           
        }
        else if($user->hasRole('client')){
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
        } else if($user->hasRole('school')){
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
        }           
    }
    function rootDashboardView()
    {
        return response()->json([
            'gps' => GpsStock::whereNull('dealer_id')->whereNull('subdealer_id')->whereNull('client_id')->count(), 
            'dealers' => Dealer::all()->count(), 
            'subdealers' => SubDealer::all()->count(),
            'clients' => Client::all()->count(),
            'vehicles' => Vehicle::all()->count(),
            'status' => 'dbcount'
        ]);
    }
    function dealerDashboardView($user){
        $dealer_user_id=$user->id;
        $dealer_id=$user->dealer->id;
        $total_gps=GpsStock::where('dealer_id',$dealer_id)->count();
        $transferred_gpss = GpsTransfer::withTrashed()->where('from_user_id',$dealer_user_id)->get();
        $single_transferred_gps = [];
        foreach($transferred_gpss as $transferred_gps){
            $single_transferred_gps[] = $transferred_gps->id;
        }
        $transferred_gps_items = GpsTransferItems::whereIn('gps_transfer_id',$single_transferred_gps)->count();            
        return response()->json([
            'subdealers' => SubDealer::where('dealer_id',$dealer_id)->count(),
            'total_gps' => $total_gps,
            'transferred_gps' => $transferred_gps_items,
            'status' => 'dbcount'           
        ]);
    }
    function subDealerDashboardView($user){
        $sub_dealer_user_id=$user->id;
        $sub_dealer_id=$user->subdealer->id;
        $total_gps=GpsStock::where('subdealer_id',$sub_dealer_id)->count();
        $transferred_gpss = GpsTransfer::withTrashed()->where('from_user_id',$sub_dealer_user_id)->get();
        $single_transferred_gps = [];
        foreach($transferred_gpss as $transferred_gps){
            $single_transferred_gps[] = $transferred_gps->id;
        }
        $transferred_gps_items = GpsTransferItems::whereIn('gps_transfer_id',$single_transferred_gps)->count();

        return response()->json([
            'clients' => Client::where('sub_dealer_id',$sub_dealer_id)->count(),
            'total_gps' => $total_gps,
            'transferred_gps' => $transferred_gps_items,
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
    function getMoving($single_vehicle,$oneMinut_currentDateTime,$currentDateTime){
        $user = \Auth::user();        
        $moving=Gps::where('mode','M')
        ->whereNotNull('lat')
        ->whereNotNull('lon')
        ->where('device_time', '>=',$oneMinut_currentDateTime)
        ->where('device_time', '<=',$currentDateTime);
        if($user->hasRole('client|school')){
            $moving=$moving->whereIn('id',$single_vehicle)->count();
        }        
        else
        {
            $moving=$moving->count();
        }
        return $moving; 
    }
    function getOffline($single_vehicle,$oneMinut_currentDateTime){
        $user = \Auth::user();         
        $offline=Gps::whereNotNull('lat')
        ->whereNotNull('lon')
        ->where('device_time', '<=',$oneMinut_currentDateTime);
        if($user->hasRole('client|school')){
            $offline=$offline->whereIn('id',$single_vehicle)->count();
        }        
        else
        {
            $offline=$offline->count();
        }
        
        return $offline; 
    }
    function getIdle($single_vehicle,$oneMinut_currentDateTime,$currentDateTime){
        $user = \Auth::user(); 
        $idle=Gps::where('mode','H')
        ->whereNotNull('lat')
        ->whereNotNull('lon')
        ->where('device_time', '>=',$oneMinut_currentDateTime)
        ->where('device_time', '<=',$currentDateTime);
        if($user->hasRole('client|school')){
            $idle=$idle->whereIn('id',$single_vehicle)->count();
        }
        else{
            $idle=$idle->count();
        }
        return $idle;
    }
    function getStop($single_vehicle,$oneMinut_currentDateTime,$currentDateTime){
        $user = \Auth::user();
        $stop=Gps::where('mode','S')
        ->whereNotNull('lat')
        ->whereNotNull('lon')
        ->where('device_time', '>=',$oneMinut_currentDateTime)
        ->where('device_time', '<=',$currentDateTime);
        if($user->hasRole('client|school')){
            $stop=$stop->whereIn('id',$single_vehicle)->count();
        }
        else
        {
            $stop=$stop->count();
        }
        return $stop;
    }
    //emergency alert
    public function emergencyAlerts(Request $request)
    {
        if($request->user()->hasRole('client')){
            $client_id=\Auth::user()->client->id;
            $alerts = Alert::select(
                'id',
                'alert_type_id',
                'vehicle_id',
                'latitude',
                'longitude',
                'device_time'
            )
            ->with('vehicle:id,name,register_number,driver_id')
            ->with('vehicle.driver')
            ->where('client_id',$client_id)
            ->where('alert_type_id',21)
            ->where('status',0)
            ->get();
            if(sizeof($alerts) == 0){
                $response=[
                    'status' => 'failed'
                ];
            }else{
                $vehicle_id = Crypt::encrypt($alerts[0]['vehicle_id']);
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
        $alerts = Alert::where('alert_type_id',21)
        ->where('status',0)
        ->where('vehicle_id',$decrypted_vehicle_id)
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
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
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

        $address="";
        $satelite=0;
        $gps = Gps::find($request->gps_id); 
        
        if($gps->satllite!=null){
         $satelite=$gps->satllite;   
        }
        $network_status=$gps->network_status;
        $fuel_status=$gps->fuel_status;
        $speed=$gps->speed;
        $odometer=$gps->odometer;
        $mode=$gps->mode;
        $satelite=$satelite;
        $latitude=$gps->lat;
        $longitude=$gps->lon;        
        if(!empty($latitude) && !empty($longitude)){
            $address =  $this->getAddress($latitude,$longitude); 
        }
        $battery_status=$gps->battery_status;
        if($network_status>=50)
        {
            $net_status="Good";
        }
        else if($network_status<50 || $network_status>=20)
        {
            $net_status="Average";
        }
        else
        {
            $net_status="poor";
        }
        if($mode=="M")
        {
            $vehcile_mode="Running";
        }
        else if($mode=="H")
        {
            $vehcile_mode="Idle";
        }
        else 
        {
            $vehcile_mode="Stopped";
        }
        if($gps){     
            $response_data = array(
                'status'  => 'vehicle_status',
                'network_status' => $net_status,
                'fuel_status' => $fuel_status.' L',
                'speed' => $speed.' Kmh',
                'odometer' => $odometer.' km',
                'mode' => $vehcile_mode,
                'satelite' => $satelite,
                'battery_status' => $battery_status.' V',
                'address' => $address
                // 'longitude' => $gps_data->longitude
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
            $gps_id =  $this->getVehicleGps($client->id,$user->id);        
            $currentDateTime=Date('Y-m-d H:i:s');
            $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));
            // userID list of vehicles
            $vehiles_details=Gps::Select(
                'id',
                'lat',
                'lat_dir',
                'lon',
                'lon_dir',
                'mode',
                'device_time'
            )
            ->with('vehicle:id,name,register_number,gps_id')
            ->whereNotNull('mode')
            ->whereIn('id',$gps_id)        
            ->orderBy('id','desc')                 
            ->get(); 
        }
        else{
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
            ->with('vehicle:id,name,register_number,gps_id')
            ->whereNotNull('mode')
            ->whereNotNull('lat') 
            ->whereNotNull('lon')  
            ->orderBy('id','desc')                 
            ->get(); 
        }  
        $response_track_data=$this->vehicleDataList($vehiles_details); 
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
    function vehicleDataList($vehiles_details){
        $vehicleTrackData=array();
        foreach ($vehiles_details as $vehicle_data) {
            // 
            $vehicle_ecrypt_id=Crypt::encrypt($vehicle_data->vehicle->id);
            $single_vehicle=Vehicle::find($vehicle_data->vehicle->id);
            $single_vehicle_type= $single_vehicle->vehicleType;
            $currentDateTime=Date('Y-m-d H:i:s');
            $device_time= $vehicle_data->device_time;
            $oneMinut_currentDateTime=date($currentDateTime,strtotime("-2 minutes"));
            $time_diff_minut=$this->twoDateTimeDiffrence($device_time,$oneMinut_currentDateTime);
            if($time_diff_minut<=2)
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
    public function vehicleTrackList(Request $request)
    {
        $gpsID=$request->gps_id;     
        $user_data=Gps::Select('lat','lat_dir','lon','lon_dir')
        ->where('id',$gpsID)                 
        ->first();
        return response()->json($user_data); 
    }
    public function vehicleMode(Request $request)
    {
        $vehicle_mode=$request->vehicle_mode;
        $user = $request->user();  
        $currentDateTime=Date('Y-m-d H:i:s');
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));
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
                ->whereIn('id',$gps_id)      
                ->whereNotNull('lat') 
                ->whereNotNull('lon')         
                ->where('device_time', '<=',$oneMinut_currentDateTime)
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
                ->whereIn('id',$gps_id)       
                ->where('device_time', '>=',$oneMinut_currentDateTime)
                ->where('device_time', '<=',$currentDateTime)        
                ->where('mode',$vehicle_mode)
                ->whereNotNull('lat') 
                ->whereNotNull('lon')         
                ->orderBy('id','desc')                 
                ->get(); 
            }
        }
        else
        {              // userID list of vehicles
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
                ->with('vehicle:gps_id,id,name,register_number')
                // ->whereIn('id',$gps_id)      
                ->whereNotNull('lat') 
                ->whereNotNull('lon')         
                ->where('device_time', '<=',$oneMinut_currentDateTime)
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
                // ->whereIn('id',$gps_id)       
                ->where('device_time', '>=',$oneMinut_currentDateTime)
                ->where('device_time', '<=',$currentDateTime)        
                ->where('mode',$vehicle_mode)
                ->whereNotNull('lat') 
                ->whereNotNull('lon')         
                ->orderBy('id','desc')                 
                ->get(); 
            }

        }
        $response_track_data=$this->vehicleDataList($vehiles_details); 
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
        $single_vehicle =  $this->getSingleVehicle($user->id);
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
        ->get();        
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
            $single_client_name[] = $client->name;
            $single_client[] = $client->id;
        }
        $vehicles = Vehicle::select('id','name','register_number','gps_id','client_id',
            \DB::raw('count(id) as count') )
        ->whereIn('client_id',$single_client)
        ->groupBy('client_id')
        ->get();
        $gps_count = [];
        foreach($vehicles as $gps_sale){           
                $gps_count[] = $gps_sale->count;                
        }
        $sub_dealer_gps_sale=array(
            "client"=>$single_client_name,
            "gps_count"=>$gps_count
        );
        return response()->json($sub_dealer_gps_sale); 
    }
    public function mapView(){
        // $gps = Vehicle::select('id','gps_id')
        // ->with('gps:id,imei')
        // ->get();
       
        $gps = Gps::select('id','imei')->whereNotNull('lat')->whereNotNull('lon')->get();
        return view('Dashboard::map-view',['gpss' => $gps]);
    }

     public function vehicleModeCount(Request $request)
    {
        $user = $request->user();
        // $dealers=Dealer::where('user_id',$user->id)->first();
        // $subdealers=SubDealer::where('user_id',$user->id)->first();
        // $client=Client::where('user_id',$user->id)->first(); 
        $currentDateTime=Date('Y-m-d H:i:s');
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));             
        $single_vehicle=0;
            
            $moving =  $this->getMoving($single_vehicle,$oneMinut_currentDateTime,$currentDateTime);
            $offline =  $this->getOffline($single_vehicle,$oneMinut_currentDateTime);
            $idle =  $this->getIdle($single_vehicle,$oneMinut_currentDateTime,$currentDateTime);
            $stop =  $this->getStop($single_vehicle,$oneMinut_currentDateTime,$currentDateTime);           
            return response()->json([
               'moving' => $moving,
                'idle' => $idle,
                'stop' => $stop,
                'offline' => $offline,
                'status' => 'vehicleModeCount'           
            ]);
                 
    }
}
