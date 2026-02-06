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
use App\Modules\Gps\Models\GpsOrder;
use App\Modules\Gps\Models\GpsHistory;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Geofence\Models\Geofence;
use App\Modules\Complaint\Models\Complaint;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Trader\Models\Trader;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Servicer\Models\Component;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Operations\Models\VehicleModels;
use App\Modules\User\Models\User;
use App\Modules\Servicer\Models\ServiceIn;
use App\Modules\Sales\Models\SalesAssignGps;
use App\Modules\Sales\Models\GpsFollowup;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\DeviceReturn\Models\DeviceReturn;
use App\Modules\Vehicle\Models\DailyKm;
use DataTables;
use DB;
use Carbon\Carbon;
use Config;
use phpDocumentor\Reflection\Types\This;

class DashboardController extends Controller{
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
    
    public function index(){
        $user = \Auth::user()->roles;
      //print_r($user);die;
      
       
        if(\Auth::user()->hasRole('root')){
            [$rootRenewalMonths, $rootTotalServiceVisits] = $this->getRootRenewalChartData();

            $serviceCenterCounts = $this->getServiceCenterCounts();

            return view('Dashboard::dashboard', [
                'rootRenewalMonths'       => $rootRenewalMonths,
                'rootTotalServiceVisits'  => $rootTotalServiceVisits,
                'serviceCenterCounts'     => $serviceCenterCounts,
            ]);
        }
        else if(\Auth::user()->hasRole('user')){
            //file_put_contents('/var/www/smarteclipseweb/temp/log.txt', date('Y-m-d H:i:s') ."XXX2" ."user:".$user."\n", FILE_APPEND);
            return $this->GetUserDashboard();
            //return view('Dashboard::user');
        }
        else if(\Auth::user()->hasRole('dealer')){
            return view('Dashboard::dashboard');
        }
        else if(\Auth::user()->hasRole('sub_dealer')){
           
            return view('Dashboard::dashboard');
        }
        else if(\Auth::user()->hasRole('trader')){
            
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
        else if(\Auth::user()->hasRole('Driver')){
            return $this->driverDashboardIndex();
        }
        else if(\Auth::user()->hasRole('sales')){

            return $this->salesIndex();
        }

        else if(\Auth::user()->hasRole('Call_Center')){

            return $this->custmerExeIndex();
        }
        else if(\Auth::user()->hasRole('Finance')){

            return $this->FinanceExeIndex();
        }
        else{
            return view('Dashboard::dashboard');
        }
    }


    function salesIndex(){
        $salesman_id = \Auth::user()->salesman->id;
        $assigned=SalesAssignGps ::select('id')->where('assigned_by',$salesman_id)->count();
        $gpstdy=SalesAssignGps ::select('id')->where('assigned_by',$salesman_id)->whereDate('created_at', '=', date('Y-m-d'))->count();
        $gps= Gps::select('id')->where('pay_status','!=',1)->count();
        $total_renewal                  =   Gps::select('id','pay_status')->where('pay_status',1)->count();
        $todays_renewal                 =   Gps::select('id','pay_status')->where('pay_status',1)->where('pay_date',Date('Y-m-d'))->count();
     
        return view('Dashboard::dashboard',['assigned' => $assigned,'gps' => $gps,'gpstdy'=>$gpstdy,'todays_renewal'=>$todays_renewal]);
    }

    function custmerExeIndex2(){
        $call_id = \Auth::user()->callcenter->id;
        $code = \Auth::user()->callcenter->code;
        $assigned=SalesAssignGps ::select('id')->where('callcenter_id',$call_id)->count();
        $gpstdy=SalesAssignGps ::select('id')->where('callcenter_id',$call_id)->whereDate('created_at', '=', date('Y-m-d'))->count();
        $total_renewal                  =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->count();
        $todays_renewal                 =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->where('pay_date',Date('Y-m-d'))->count();
        $total_collection               =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->where('pay_date','<',Date('Y-m-d'))->count();
        $todays_collection              =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->where('pay_date',Date('Y-m-d'))->sum('amount');
        $total_month_revenew              =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->whereMonth('pay_date', Carbon::now()->month)
      ->whereYear('pay_date', Carbon::now()->year)->sum('amount');
       
       
       
        return view('Dashboard::dashboard',[
          'assigned' => $assigned,
          'gpstdy'=>$gpstdy,
          'todays_renewal'=>$todays_renewal,
          'total_renewal'=>$total_renewal,
          'total_collection'=>$total_collection,
          'todays_collection'=>$todays_collection,
          'total_month_revenew'=>$total_month_revenew
        ]);
    }
    function custmerExeIndex(){
        $call_id = \Auth::user()->callcenter->id;
        $userId = \Auth::id();
        $assigned = SalesAssignGps::where('callcenter_id',$call_id)->count();
    
        $gpstdy = SalesAssignGps::where('callcenter_id',$call_id)
                    ->whereDate('created_at', date('Y-m-d'))
                    ->count();
    
        // Total Renewals (based on orders created by this user)
        $total_renewal = GpsOrder::where('sales_by', $userId)
                        ->where('payment_status', 1)
                        ->count();
    
        // Today's Renewals
        $todays_renewal = GpsOrder::where('sales_by', $userId)
                        ->where('payment_status', 1)
                        ->whereDate('created_at', date('Y-m-d'))
                        ->count();
    
        // Total Collection (all paid orders before today)  [keeping your variable meaning]
        $total_collection = GpsOrder::where('sales_by', $userId)
                        ->where('payment_status', 1)
                        ->sum('total_amount');
    
        // Today's Collection Amount
        $todays_collection = GpsOrder::where('sales_by', $userId)
                        ->where('payment_status', 1)
                        ->whereDate('created_at', date('Y-m-d'))
                        ->sum('total_amount');
    
        // This Month Revenue
        $total_month_revenew = GpsOrder::where('sales_by', $userId)
                        ->where('payment_status', 1)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->sum('total_amount');
    
        // Follow-ups due today - GPS with next_follow_date <= today (includes overdue)
        $today = Carbon::today()->toDateString();
        $followups_due_today = GpsFollowup::where('user_id', $userId)
                        ->where('next_follow_date', '<=', $today)
                        ->whereNull('deleted_at')
                        ->distinct('gps_id')
                        ->count('gps_id');
    
        return view('Dashboard::dashboard',[
            'assigned' => $assigned,
            'gpstdy' => $gpstdy,
            'todays_renewal' => $todays_renewal,
            'total_renewal' => $total_renewal,
            'total_collection' => $total_collection,
            'todays_collection' => $todays_collection,
            'total_month_revenew' => $total_month_revenew,
            'followups_due_today' => $followups_due_today
        ]);
    }

    
    function FinanceExeIndex(){
        $finance_id = \Auth::user()->finance->id;
        $components = Component::groupBy('box_no')->havingRaw('box_no > 0')->orderby('created_at', 'desc')->get();
        return view('Dashboard::dashboard',['components' => $components]);
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
        $client_id              =   \Auth::user()->client->id;
        $alerts                 =   $this->getAlerts($client_id);
        $gps_stocks             =   GpsStock::select('id','gps_id','client_id')
                                            ->where('client_id',$client_id)
                                            ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                            })
                                            ->get();
        $single_gps_in_stocks   =   [];
        foreach ($gps_stocks as $gps) {
            $single_gps_in_stocks[] =   $gps->gps_id;
        }
        $gpss = Gps::select('id')->whereNotNull('lat')->whereNotNull('lon')->whereIn('id',$single_gps_in_stocks)->get();
        $single_gps=[];
        foreach ($gpss as $gps) {
            $single_gps[]=$gps->id;
        }
     
        $vehicles = Vehicle::select('id','register_number','name','gps_id')
                            ->where('client_id',$client_id)
                           // ->whereIn('gps_id',$single_gps)
                            ->where(function ($query) {
                                $query->where('is_returned', '=', 0)
                                ->orWhere('is_returned', '=', NULL);
                            })
                            ->get();

                          //  print_r( $vehicles);die;
                        
        $single_vehicle     =   $this->getSingleVehicle($client_id);
        $expired_documents  =   $this->getExpiredDocuments($single_vehicle);
        $expire_documents   =   $this->getExpireDocuments($single_vehicle);
        $client             =   (new Client())->getClientDetailsWithClientId($client_id);
        return view('Dashboard::dashboard',['alerts' => $alerts,'expired_documents' => $expired_documents,'expire_documents' => $expire_documents,'vehicles' => $vehicles,'client' => $client]);
    }


    // 12/03/2025
    //driver dashboard

    function driverDashboardIndex(){
        $client_id              =   \Auth::user()->id;
        $alerts                 =   $this->getAlerts($client_id);
        $gps_stocks             =   Vehicle::select('id','gps_id')
                                            ->where('driver_id',$client_id)
                                           
                                            ->get();
        $single_gps_in_stocks   =   [];
        foreach ($gps_stocks as $gps) {
            $single_gps_in_stocks[] =   $gps->gps_id;
        }
        $gpss = Gps::select('id')->whereNotNull('lat')->whereNotNull('lon')->whereIn('id',$single_gps_in_stocks)->get();
        $single_gps=[];
        foreach ($gpss as $gps) {
            $single_gps[]=$gps->id;
        }
     
        $vehicles = Vehicle::select('id','register_number','name','gps_id')
                            ->where('driver_id',$client_id)
                           // ->whereIn('gps_id',$single_gps)
                            ->where(function ($query) {
                                $query->where('is_returned', '=', 0)
                                ->orWhere('is_returned', '=', NULL);
                            })
                            ->get();

                          //  print_r( $vehicles);die;
        $single_vehicle = [];
        foreach($vehicles as $vehicle){
                              $single_vehicle[] = $vehicle->id;
        }             
        //$single_vehicle     =   $this->getSingleVehicle($client_id);
        $expired_documents  =   $this->getExpiredDocuments($single_vehicle);
        $expire_documents   =   $this->getExpireDocuments($single_vehicle);
        $client             =   (new Client())->getClientDetailsWithClientId($client_id);
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
    public function dashCount(Request $request){
        $user                       =   $request->user();
        $dealers                    =   Dealer::where('user_id',$user->id)->first();
        $subdealers                 =   SubDealer::where('user_id',$user->id)->first();
        $client                     =   (new Client())->checkUserIdIsInClientTable($user->id);
        $oneMinut_currentDateTime   =   date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        if($user->hasRole('root')){
            return $this->rootDashboardView();
        }
        else if($user->hasRole('dealer')){
            return $this->dealerDashboardView($user);
        }
        else if($user->hasRole('sub_dealer')){
            return $this->subDealerDashboardView($user);
        }
        else if($user->hasRole('trader')){
            return $this->traderDashboardView($user);
        }
        else if($user->hasRole('servicer')){
            return $this->servicerDashboardView($user);
        }
        else if($user->hasRole('client')){
            $vehicle_status=$this->vehicleRunningStatus($client->id);
            return response()->json($vehicle_status);
        }
        else if($user->hasRole('Driver')){
            $vehicle_status=$this->vehicleRunningStatus($client->id);
            return response()->json($vehicle_status);
        }
        else if($user->hasRole('school')){
            return response()->json([
                // 'gps' => Gps::where('user_id',$user->id)->count(),
                'vehicles' => Vehicle::select('id','client_id')->where('client_id',$client->id)->count(),
                'geofence' => Geofence::select('id','user_id')->where('user_id',$user->id)->count(),
                'moving' => $moving,
                'idle' => $idle,
                'stop' => $stop,
                'offline' => $offline,
                'status' => 'dbcount'
            ]);
        }else if($user->hasRole('operations')){
            return response()->json([
                'gps'               => Gps::select('id')->count(),
                'gps_stock'         => GpsStock::select('id')->count(),
                'gps_to_verify'     => Gps::select('id')->count()-GpsStock::select('id')->count(),
                'gps_today'         => Gps::select('manufacturing_date')->WhereDate('manufacturing_date',date("Y-m-d"))->count(),
                // 'gps_add_to_stock' => GpsStock::WhereDate('created_at',date("Y-m-d"))->count(),
                'status'            => 'dbcount'
            ]);
        }
    }
    protected function getRootRenewalChartData(){
        $rows = Gps::query()
            ->whereNotNull('installation_date_new')
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

        $totalServiceVisits = $serviceRows->sum('service_visits');

        $baseMonths = [];
        for ($m = 1; $m <= 12; $m++) {
            $total = isset($rows[$m]) ? (int) $rows[$m]->total_installed : 0;
            $renewed = isset($rows[$m]) ? (int) $rows[$m]->renewed : 0;
            $serviceVisits = isset($serviceRows[$m]) ? (int) $serviceRows[$m]->service_visits : 0;

            $baseMonths[$m] = [
                'month_no'        => $m,
                'month_name'      => Carbon::createFromDate(2000, $m, 1)->format('M'),
                'total_installed' => $total,
                'renewed'         => $renewed,
                'not_renewed'     => max(0, $total - $renewed),
                'service_visits'  => $serviceVisits,
            ];
        }

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = [
                'month_no'        => $m,
                'month_name'      => $baseMonths[$m]['month_name'],
                'total_installed' => $baseMonths[$m]['total_installed'],
                'renewal_needed'  => $baseMonths[$m]['total_installed'],
                'renewed'         => $baseMonths[$m]['renewed'],
                'not_renewed'     => $baseMonths[$m]['not_renewed'],
                'service_visits'  => $baseMonths[$m]['service_visits'],
            ];
        }

        return [$months, $totalServiceVisits];
    }

    function rootDashboardView(){        
       
        $gps_manufactured           =   (new Gps())->manufacturedDeviceCount();
        $gps_already_added_to_stock =   (new GpsStock())->manufacturedDevicesAddedToStockCount();
        $refurbished_devices        =   (new Gps())->refurbishedDevicesInAllDevices();
    
        $gps_nontransferred_stock   =   GpsStock::select('id','dealer_id','subdealer_id','client_id','is_returned')
                                                ->whereNull('dealer_id')->whereNull('subdealer_id')->whereNull('client_id')
                                                ->where('refurbished_status',0)
                                                ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                                })->count();
        $gps_refurbished_stock      =   GpsStock::select('id','dealer_id','subdealer_id','client_id','is_returned')
                                                ->whereNull('dealer_id')->whereNull('subdealer_id')->whereNull('client_id')
                                                ->where('refurbished_status',1)
                                                ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                                })->count();
        $gps_transferred            =   GpsStock::select('id','dealer_id')->whereNotNull('dealer_id')->count();
        $gps_returned               =   Gps::select('id','is_returned')->where('is_returned',1)->count();
       
        $best_performer                 =  DB::select("select name from employees where code in ( SELECT employee_code  FROM `gps_summery` 
where pay_status=1  group by employee_code order by employee_code desc) limit 1;"); 
       // Gps::select('id','is_returned')->where('is_returned',1)->count();
        $total_renewal                  =   Gps::select('id','pay_status')->where('pay_status',1)->count();
        $todays_renewal                 =   Gps::select('id','pay_status')->where('pay_status',1)->where('pay_date',Date('Y-m-d'))->count();
        $ksrtc_count                 =  DB::select("SELECT count(*) as total FROM `gps_summery` where id in (select gps_id from vehicles where  client_id=1778) AND pay_status=1 AND  pay_date='".Date('Y-m-d')."';"); 
      //  echo "SELECT count(*) FROM `gps_summery` where id in (select gps_id from vehicles where  client_id=1778) AND pay_status=1 AND  pay_date='".Date('Y-m-d')."'";die;
       
      $best_performer_day                =  DB::select("select name from employees where code in ( SELECT employee_code  FROM `gps_summery` 
      where pay_status=1  AND  pay_date='".Date('Y-m-d')."' group by employee_code order by employee_code desc) limit 1;"); 
       
      $deviceIn_count                 =  DB::select("SELECT count(*) as total FROM `cd_service_ins` where  date='".Date('Y-m-d')."';"); 
      


      $total_collection                  =   Gps::select('id','pay_status')->where('pay_status',1)->sum('amount');
      $todays_collection                 =   Gps::select('id','pay_status')->where('pay_status',1)->where('pay_date',Date('Y-m-d'))->sum('amount');
   
      $total_collection                  =   Gps::select('id','pay_status')->where('pay_status',1)->sum('amount');
      $todays_collection                 =   Gps::select('id','pay_status')->where('pay_status',1)->where('pay_date',Date('Y-m-d'))->sum('amount');
   
      $devices_in                  =   ServiceIn::select('id','status')
                                        ->where('status', '!=', 'cancelled')
                                        ->count();
                                        
      $devices_out                 =   ServiceIn::select('id','status')
                                        ->where('status', '=', 'delivered')
                                        ->count();
                                        
      $devices_pending             =   ServiceIn::select('id','status')
                                        ->where('status', '!=', 'cancelled')
                                        ->where('status', '!=', 'delivered')
                                        ->count();
     
     $todaydevices_in                  =   ServiceIn::select('id','status')->where('status', '!=', 'cancelled')->where('date',Date('Y-m-d'))->count();
     $todaydevices_out                 =   ServiceIn::select('id','status')->where('status', '=', 'delivered')->where('date',Date('Y-m-d'))->count();
     $todaydevices_pending             =   ServiceIn::select('id','status')->where('status', '!=', 'cancelled')->where('status', '!=', 'delivered')->where('date',Date('Y-m-d'))->count();
  
        $gps_to_be_added_to_stock   =   $gps_manufactured-$gps_already_added_to_stock;
        if( $gps_to_be_added_to_stock < 0 )
        {
            $gps_to_be_added_to_stock = 0;
        } 
        return response()->json([
            'gps_manufactured'          =>  $gps_manufactured, 
            'gps'                       =>  $gps_nontransferred_stock, 
            'gps_refurbished_stock'     =>  $gps_refurbished_stock,
            'refurbished_devices'       =>  $refurbished_devices,
            'gps_transferred'           =>  $gps_transferred, 
            'gps_to_be_added_to_stock'  =>  $gps_to_be_added_to_stock, 
            'gps_returned'              =>  $gps_returned, 
            'gps_returned_request'      =>  DeviceReturn::select('id')->where('status',0)->count(), 
            'dealers'                   =>  Dealer::select('id')->count(), 
            'subdealers'                =>  SubDealer::select('id')->count(),
            'clients'                   =>  (new Client())->getCountOfAllClients(),
            'vehicles'                  =>  Vehicle::select('id')->count(),
            'status'                    =>  'dbcount',
            "best_performer"            =>($best_performer)?$best_performer[0]->name:"",
            "best_performer_day"        =>($best_performer_day)?$best_performer_day[0]->name:"",
            "total_renewal"             =>$total_renewal,
            "todays_renewal"            =>$todays_renewal,

            "total_collection"             =>$total_collection,
            "todays_collection"            =>$todays_collection,

            "devices_in"             =>$devices_in,
            "devices_out"            =>$devices_out,
            "devices_pending"        =>$devices_pending,
            "todaydevices_in"             =>$todaydevices_in,
            "todaydevices_out"            =>$todaydevices_out,
            "todaydevices_pending"        =>$todaydevices_pending,
            "ksrtc_count"=> $ksrtc_count[0]->total 
        ]);
    }

    /**
     * Aggregate ServiceIn counts grouped by service_center_id for root dashboard.
     * Device In: status != 'cancelled'
     * Device Out: status = 'delivered'
     * Pending: status != 'delivered' and status != 'cancelled'
     */
    protected function getServiceCenterCounts()
    {
        $rows = DB::table('cd_service_ins')
            ->select('service_center_id',
                DB::raw("SUM(CASE WHEN status != 'cancelled' THEN 1 ELSE 0 END) as device_in"),
                DB::raw("SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as device_out"),
                DB::raw("SUM(CASE WHEN status != 'delivered' AND status != 'cancelled' THEN 1 ELSE 0 END) as pending")
            )
            ->groupBy('service_center_id')
            ->get();

        $ids = $rows->pluck('service_center_id')->filter()->unique()->toArray();
        $centers = [];
        if (!empty($ids)) {
            $centers = \App\Modules\Servicer\Models\ServiceCenter::whereIn('id', $ids)->pluck('name', 'id')->toArray();
        }

        $result = [];
        foreach ($rows as $r) {
            $id = $r->service_center_id;
            $name = $id ? ($centers[$id] ?? 'Unknown') : 'Not Assigned';
            $result[] = [
                'service_center_id' => $id,
                'name' => $name,
                'device_in' => (int) $r->device_in,
                'device_out' => (int) $r->device_out,
                'pending' => (int) $r->pending,
            ];
        }

        return $result;
    }
    function servicerDashboardView($user)
    {
        $servicer_id=$user->servicer->id;
        return response()->json([
                'new_installation_jobs' => (new ServicerJob())->getNewInstallationJobCount( $servicer_id), 
                'on_progress_installation_jobs' =>(new ServicerJob())->getOnProgressJobCount( $servicer_id), 
                'completed_jobs' =>(new ServicerJob())->getCompletedJobCount( $servicer_id), 
                'new_reinstallation_jobs' => (new ServicerJob())->getNewReInstallationJobCount( $servicer_id), 
                'on_progress_reinstallation_jobs' =>(new ServicerJob())->getOnProgressReInstallationJobCount( $servicer_id), 
                'completed_reinstallation_jobs' =>(new ServicerJob())->getReInstallationCompletedJobCount( $servicer_id), 
                'pending_service_jobs' =>(new ServicerJob())->getPendingServiceJobCount( $servicer_id),
                'servicer_all_pending_jobs' =>(new ServicerJob())->getProgressServiceJobCount( $servicer_id),
                'service_completed_jobs' =>(new ServicerJob())->getCompletedServiceJobCount( $servicer_id),
                'status' => 'dbcount'
        ]);
    }
    
    function dealerDashboardView($user){
        $dealer_user_id             =   $user->id;
        $dealer_id                  =   $user->dealer->id;
        $in_stock_gps_dealer        =   GpsStock::select('dealer_id','subdealer_id')->where('dealer_id',$dealer_id)->whereNull('subdealer_id')->count();
        $sub_dealers_of_dealers     =   SubDealer::select('id','dealer_id')->where('dealer_id',$dealer_id)->withTrashed()->get();
        $single_sub_dealers_array   =   [];
        foreach($sub_dealers_of_dealers as $sub_dealers_array){
            $single_sub_dealers_array[] = $sub_dealers_array->id;
        }
        $traders_of_sub_dealers     = Trader::select(
            'id','sub_dealer_id'
            )
            ->withTrashed()
            ->whereIn('sub_dealer_id',$single_sub_dealers_array)
            ->get();
        $single_traders             = [];
        foreach($traders_of_sub_dealers as $trader){
            $single_traders[]       = $trader->id;
        }
        $end_users_count            =   (new Client())->getCountOfClientsUnderDistributor($single_traders, $single_sub_dealers_array);
        $transferred_accepted_gps_count     =   GpsStock::select('subdealer_id','dealer_id')->whereIn('subdealer_id',$single_sub_dealers_array)->where('dealer_id',$dealer_id)->count();
        $transferred_gps_awaiting           =   GpsStock::select('dealer_id','subdealer_id')->where('dealer_id',$dealer_id)->where('subdealer_id',0)->count();  

        $single_new_transfer_ids            =   [];
        $new_arrival_gps_count              =   0;
        $new_arrival_gps                    =   GpsTransfer::select('to_user_id','accepted_on','id')->where('to_user_id',$dealer_user_id)->whereNull('accepted_on')->get();
        if($new_arrival_gps)
        {
            foreach ($new_arrival_gps as $new_gps) 
            {
                $single_new_transfer_ids[]  =   $new_gps->id;
            }
            $new_arrival_gps_count          =   GpsTransferItems::select('gps_transfer_id')->whereIn('gps_transfer_id',$single_new_transfer_ids)->count();
        }
        $gps_returned                       =   GpsStock::select('id','dealer_id','is_returned')->where('dealer_id',$dealer_id)->where('is_returned',1)->count();

        return response()->json([
            'subdealers'                =>  SubDealer::select('dealer_id')->where('dealer_id',$dealer_id)->count(),
            'clients'                   =>  $end_users_count,
            'gps_returned'              =>  $gps_returned,
            'traders'                   =>  Trader::select('sub_dealer_id')->whereIn('sub_dealer_id',$single_sub_dealers_array)->count(),
            'new_arrivals'              =>  $new_arrival_gps_count,
            'in_stock_gps_dealer'       =>  $in_stock_gps_dealer,
            'transferred_gps'           =>  $transferred_accepted_gps_count,
            'transferred_gps_awaiting'  =>  $transferred_gps_awaiting,
            'status'                    =>  'dbcount'           
        ]);
    }
    function subDealerDashboardView($user){
        $sub_dealer_user_id                     =   $user->id;
        $sub_dealer_id                          =   $user->subdealer->id;
        $total_gps                              =   GpsStock::select('id','subdealer_id')->where('subdealer_id',$sub_dealer_id)->count();
        $gps_in_stock                           =   GpsStock::select('id','subdealer_id','trader_id','client_id')->where('subdealer_id',$sub_dealer_id)->whereNull('trader_id')->whereNull('client_id')->count();
        $gps_awaiting_confirmation_from_trader  =   GpsStock::select('id','subdealer_id','trader_id','client_id')->where('subdealer_id',$sub_dealer_id)->where('trader_id',0)->whereNull('client_id')->count();
        $clients_of_subdealers                  =   (new Client())->getDetailsOfClientsUnderDealerWithTrashedItems($sub_dealer_id);
        $traders_of_subdealers                  =   Trader::select('id','sub_dealer_id')->where('sub_dealer_id',$sub_dealer_id)->withTrashed()->get();
        $single_clients_array                   =   [];
        foreach($clients_of_subdealers as $clients_array){
            $single_clients_array[]             =   $clients_array->id;
        }
        $single_traders_array                   =   [];
        foreach($traders_of_subdealers as $traders_array){
            $single_traders_array[]             =   $traders_array->id;
        }
        $dealer_to_trader_transferred_gps_count =   GpsStock::select('id','trader_id','subdealer_id')->whereIn('trader_id',$single_traders_array)->where('subdealer_id',$sub_dealer_id)->count(); 
        $dealer_to_client_transferred_gps_count =   GpsStock::select('id','client_id','subdealer_id')->whereIn('client_id',$single_clients_array)->where('subdealer_id',$sub_dealer_id)->count(); 
        
        $single_new_transfer_ids                =   [];
        $new_arrival_gps_count                  =   0;
        $new_arrival_gps                        =   GpsTransfer::select('to_user_id','id','accepted_on')->where('to_user_id',$sub_dealer_user_id)->whereNull('accepted_on')->get();
        if($new_arrival_gps)
        {
            foreach ($new_arrival_gps as $new_gps) 
            {
                $single_new_transfer_ids[]      =   $new_gps->id;
            }
            $new_arrival_gps_count              =   GpsTransferItems::select('gps_transfer_id')->whereIn('gps_transfer_id',$single_new_transfer_ids)->count();
        }

        $gps_returned                           =   GpsStock::select('id','subdealer_id','is_returned')->where('subdealer_id',$sub_dealer_id)->where('is_returned',1)->count();

        $new_complaints_count_of_sub_dealer     =   (new Complaint())->getCountOfComplaintsWithOpenStatus($single_clients_array);

        return response()->json([
            'clients'                                   =>  (new Client())->getCountOfClientsUnderDealer($sub_dealer_id),
            'traders'                                   =>  Trader::select('sub_dealer_id')->where('sub_dealer_id',$sub_dealer_id)->count(),
            'new_arrivals'                              =>  $new_arrival_gps_count,
            'total_gps'                                 =>  $total_gps,
            'gps_in_stock'                              =>  $gps_in_stock,
            'gps_returned'                              =>  $gps_returned,
            'subdealer_complaints'                      =>  $new_complaints_count_of_sub_dealer,
            'gps_awaiting_confirmation_from_trader'     =>  $gps_awaiting_confirmation_from_trader,
            'dealer_to_trader_transferred_gps_count'    =>  $dealer_to_trader_transferred_gps_count,
            'dealer_to_client_transferred_gps_count'    =>  $dealer_to_client_transferred_gps_count,
            'status' => 'dbcount'           
        ]);
    } 
    
    function traderDashboardView($user){
        $trader_user_id                             =   $user->id;
        $trader_id                                  =   $user->trader->id;
        $total_gps                                  =   GpsStock::select('id','trader_id')->where('trader_id',$trader_id)->count();
        $gps_in_stock_trader                        =   GpsStock::select('id','trader_id','client_id')->where('trader_id',$trader_id)->whereNull('client_id')->count();
        $clients_of_traders                         =   (new Client())->getDetailsOfClientsUnderSubDealerWithTrashedItems($trader_id);
        $single_clients_array                       =   [];
        foreach($clients_of_traders as $clients_array){
            $single_clients_array[]                 =   $clients_array->id;
        }
        $trader_to_client_transferred_gps_count     =   GpsStock::select ('client_id','trader_id')->whereIn('client_id',$single_clients_array)->where('trader_id',$trader_id)->count(); 
        
        $single_new_transfer_ids                    =   [];
        $new_arrival_gps_count                      =   0;
        $new_arrival_gps                            =   GpsTransfer::select('to_user_id','id','accepted_on')->where('to_user_id',$trader_user_id)->whereNull('accepted_on')->get();
        if($new_arrival_gps){
            foreach ($new_arrival_gps as $new_gps) {
                $single_new_transfer_ids[]          =   $new_gps->id;
            }
            $new_arrival_gps_count                  =   GpsTransferItems::select('gps_transfer_id')->whereIn('gps_transfer_id',$single_new_transfer_ids)->count();
        }
        $gps_returned                               =   GpsStock::select('id','trader_id','is_returned')->where('trader_id',$trader_id)->where('is_returned',1)->count();
        $new_complaints_count_of_trader             =   (new Complaint())->getCountOfComplaintsWithOpenStatus($single_clients_array);

        return response()->json([
            'clients'                                   =>  (new Client())->getCountOfClientsUnderSubDealer($trader_id),
            'new_arrivals'                              =>  $new_arrival_gps_count,
            'total_gps'                                 =>  $total_gps,
            'gps_in_stock_trader'                       =>  $gps_in_stock_trader,
            'gps_returned'                              =>  $gps_returned,
            'trader_complaints'                         =>  $new_complaints_count_of_trader,
            'trader_to_client_transferred_gps_count'    =>  $trader_to_client_transferred_gps_count,
            'status'                                    =>  'dbcount'           
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
            $moving=Gps::select('mode','lat','lon','device_time','id')->where('mode','M')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime)
            ->where('id',$single_vehicle);
            $moving=$moving->count();
        }
        else
        {
            $moving=Gps::select('id','lat','lon','device_time')->where('mode','M')
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
            $offline=Gps::select('id','lat','lon','device_time','id')->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','<',$oneMinut_currentDateTime)
            ->where('id',$single_vehicle);
            $offline=$offline->count();
        }
        else
        {
            $offline=Gps::select('id', 'lat','lon','device_time')->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','<',$oneMinut_currentDateTime);
            $offline=$offline->count();
        }
        return $offline;
    }
    function getIdle($single_vehicle,$oneMinut_currentDateTime){
        $user = \Auth::user();
        if($user->hasRole('client|school')){
            $idle=Gps::select('mode','lat','lon','device_time','id')->where('mode','H')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime)
            ->where('id',$single_vehicle);
            $idle=$idle->count();
        }
        else
        {
            $idle=Gps::select('mode','lat','lon','device_time','id')->where('mode','H')
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
            $sleep=Gps::select('mode','lat','lon','device_time','id')->where('mode','S')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->where('device_time','>=',$oneMinut_currentDateTime)
            ->where('id',$single_vehicle);
            $sleep=$sleep->count();
        }
        else
        {
            $sleep=Gps::select('id','mode','lat','lon','device_time')->where('mode','S')
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
            $all_gps=GpsStock::select('client_id','gps_id')->where('client_id',$client_id)->get();
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
    public function verifyEmergencyAlert(Request $request){
        // $decrypted_vehicle_id = Crypt::decrypt($request->id);
        // $vehicle=Vehicle::find($decrypted_vehicle_id);
        // $alerts = Alert::where('alert_type_id',21)
        // ->where('status',0)
        // ->where('gps_id',$vehicle->gps_id)
        // ->get();

        // if($alerts == null){
        //     return response()->json([
        //         'status' => 0,
        //         'title' => 'Error',
        //         'message' => 'Alert does not exist'
        //     ]);
        // }
        // $confirm_alerts =Alert::where('alert_type_id',21)->where('gps_id', $vehicle->gps_id)->where('status', 0)->update(['status'=> 1]);

        // return response()->json([
        //     'status' => 1,
        //     'title' => 'Success',
        //     'message' => 'Alert verified successfully'
        // ]);
        $alert_id   =   $request->id;
        $alert      =   Alert::find($alert_id);
        if($alert == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Alert does not exist'
            ]);
        }
        $alert->status  =   1;
        $alert->save();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert verified successfully'
        ]);
     }
    //get place name
    // public function getLocationFromLatLng(Request $request)
    // {
    //     $latitude = $request->latitude;
    //     $longitude = $request->longitude;
    //     if(!empty($latitude) && !empty($longitude)){
    //         $address =  $this->getAddress($latitude,$longitude);
    //         if(!empty($address)){
    //             $location=$address;
    //         }
    //         return response()->json($location);
    //     }
    // }
    public function getAddress(Request $request){
        //Send request and receive json data by address
         $address="No Address";
        if(!empty($request->lat)&& !empty($request->lng))
        {
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($request->lat).','.trim($request->lng).'&sensor=false&key='.config('eclipse.keys.googleMap').'&libraries=drawing&callback=initMap');
            $output = json_decode($geocodeFromLatLong);
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[0]->formatted_address:'';
            if($address)
            {
                return $address;
            }
            else{
                return "No Address";
            }
        }
        else{
            return "No Address";
        }      
    }

    // hide for remove 
    // 2020-05-18
    // public function getLocation(Request $request)
    // {
    //     $gps_data=GpsData::select([
    //         'latitude as latitude',
    //         'longitude as longitude'
    //     ])
    //     ->where('vehicle_id',$request->id)
    //     ->orderBy('id','desc')
    //     ->get();
    //     return response()->json($gps_data);
    // }
    // hide for remove 
    // 2020-05-18
    public function vehicleDetails(Request $request){
        $user = $request->user();
        // $address="";
        $satelite=0;
       // $gps = GpsHistory::where('gps_id',$request->gps_id)->first();
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
            $fuel_status=$gps->fuel_status;
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
            $fuel_status=$gps->fuel_status;
        }
        else
        {
            $fuel_status="upgrade version";
        }
        $speed=round($gps->speed);
        //get daily km
        //$daily_km = (new DailyKm)->getDailyKmBasedOnDateAndGps([$gps->id], date('Y-m-d'));
        //get odometer reading from gps table and convert it to km
        $gps_km_in_meter    = (isset($gps->km)) ? $gps->km : 0; 
        $gps_km             = $gps_km_in_meter/1000;
        $odometer           = round($gps_km);
        (isset($odometer)) ? $odometer = $odometer : $odometer = 0;
        $mode=$gps->mode;
        $satelite=$satelite;
        $latitude=$gps->lat;
        $longitude=$gps->lon;
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
                'latitude' => $latitude,
                'longitude' => $longitude
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
        $user       =   $request->user();
        $client     =   (new Client())->checkUserIdIsInClientTable($user->id);
        $query      =   Vehicle::select(
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
        $user       =   $request->user();
        if($user->hasRole('client|school')){
            $client                 =   (new Client())->checkUserIdIsInClientTable($user->id);
            $response_track_data    =   $this->vehicleRunningDetails($client->id);
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
            ->where(function ($query) {
                    $query->where('is_returned', '=', 0)
                    ->orWhere('is_returned', '=', NULL);
                    })
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
        $clients_gps=Client:: select('id')->where('id',$client_id)
                                    ->with(['vehicles'=>function($vehicle)
                                     {$vehicle->with(['gps'=>function($item){
                                      $item->where('status',1)
                                           ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                            });
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
        $user_data=Gps::Select('id','lat','lat_dir','lon','lon_dir')
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
            $client     =   (new Client())->checkUserIdIsInClientTable($user->id);
            $gps_id     =   $this->getVehicleGps($client->id,$user->id);
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
                ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                                })
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
                ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                                })
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
                ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                                })
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
                ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                                })
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
        $lat        =   $request->lat;
        $lng        =   $request->lng;
        $radius     =   $request->radius;
        $user       =   $request->user();
        $client     =   (new Client())->checkUserIdIsInClientTable($user->id);
        $gps_id     =   $this->getVehicleGps($client->id,$user->id);
        $vehicle_by_search=Gps::select('gps.id' ,'gps.lat','gps.lat_dir','gps.lon','gps.mode','device_time'
        ,DB::raw("6371 * acos(cos(radians(" . $lat . "))
        * cos(radians(gps.lat))
        * cos(radians(gps.lon) - radians(" . $lng . "))
        + sin(radians(" .$lat. "))
        * sin(radians(gps.lat))) AS distance"))
        ->groupBy("gps.id")
        ->having('distance','<=',$radius)
        ->with('vehicle:gps_id,id,name,register_number')
        ->where(function ($query) {
                $query->where('is_returned', '=', 0)
                ->orWhere('is_returned', '=', NULL);
                })
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
        $user           =   $request->user();
        $client         =   (new Client())->checkUserIdIsInClientTable($user->id);
        $client_id      =   $client->id;
        $single_vehicle =   $this->getSingleVehicle($client_id);
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
        $root_id    =   \Auth::user()->root->id;
        $dealer     =   Dealer::select('id')->count();
        $sub_dealer =   SubDealer::select('id')->count();
        $client     =   (new Client())->getCountOfAllClients(); 
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
            ->withTrashed()
            ->where('dealer_id',$dealer_id)
            ->get();
        $single_sub_dealer = [];
        foreach($sub_dealers as $sub_dealer){
            $single_sub_dealer[] = $sub_dealer->id;
        }
        $traders = Trader::select(
            'id'
            )
            ->withTrashed()
            ->whereIn('sub_dealer_id',$single_sub_dealer)
            ->get();
        $single_traders = [];
        foreach($traders as $trader){
            $single_traders[] = $trader->id;
        }
        $client = Client::select('trader_id','sub_dealer_id')->where(function ($query) use($single_traders, $single_sub_dealer) {
            $query->whereIn('trader_id', $single_traders)
            ->orWhereIn('sub_dealer_id', $single_sub_dealer);
        })->count();
        $dealer_gps_user=array(
                    "sub_dealer"=>SubDealer::select('dealer_id')->where('dealer_id',$dealer_id)->count(),
                    "trader"=>Trader::select('sub_dealer_id')->whereIn('sub_dealer_id',$single_sub_dealer)->count(),
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
        #file_put_contents('/var/www/smarteclipseweb/temp/log1.txt', date('Y-m-d H:i:s') . "In mapView"."\n", FILE_APPEND);

        $gps = Gps::select('id','imei')->whereNotNull('lat')->whereNotNull('lon')
            ->with('vehicle:id,name,gps_id')
            ->get();
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


    public function vehicleRunningStatus($client_id)
    {
        $date_before_eleven_minutes = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        $sleep              = 0;
        $online             = 0;
        $halt               = 0;
        $offline            = 0;
        $count              = 0;
        $clients_gps        = Client::where('id',$client_id)
                              ->with(['vehicles'=>function($vehicle)
                                    {

                                        $vehicle->with(['gps'=>function($item){
                                        $item->where('status',1)
                                             ->where(function ($query) {
                                                $query->where('is_returned', '=', 0)
                                                ->orWhere('is_returned', '=', NULL);
                                                });
                                    }]);
                                }])->get();
                               
                              //   print_r($clients_gps );die;

        foreach ($clients_gps as $item)
        {
            foreach($item->vehicles as $vehicle)
            {
                if($vehicle->gps && $vehicle->gps->lat != null)
                {
                    if($vehicle->gps->mode=="M"){
                        if($vehicle->gps->device_time  >= $date_before_eleven_minutes)
                        {
                            $online=$online+1;
                        }else
                        {
                            $offline=$offline+1;
                        }
                    }else if($vehicle->gps->mode=="H")
                    {
                        if($vehicle->gps->device_time  >= $date_before_eleven_minutes){
                            $halt=$halt+1;
                        }else{
                            $offline=$offline+1;
                        }
                    }else if($vehicle->gps->mode=="S")
                    {
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
  
        $vehicle_status=["moving"           => $online,
                          "idle"            => $halt,
                          "stop"            => $sleep,
                          "offline"         => $offline,
                          "total_vehicles"  => $count,
                          'status'          => 'dbcount'
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
    public function rootGpsClientSale(Request $request)
    {

        $root_id=\Auth::user()->root->id;
        $gps=$this->getGpsClientSale();
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
     function getGpsClientSale(){
       $gps = Gps::select(
            'id',
            \DB::raw('date_format(login_on, "%M") as month'),
            \DB::raw('count(date_format(login_on, "%M")) as count')
        )
       ->whereNotNull('login_on')
        ->orderBy("month","DESC")
        ->groupBy("month")
        ->get();
        return $gps;
    }
    public function dealerGpsClientSale(Request $request)
    {
        $dealer_id                  =   \Auth::user()->dealer->id;
        $sub_dealers_of_dealers     =   SubDealer::select('id','dealer_id')->where('dealer_id',$dealer_id)->withTrashed()->get();
        $single_sub_dealers_array   =   [];
        foreach($sub_dealers_of_dealers as $sub_dealers_array){
            $single_sub_dealers_array[] = $sub_dealers_array->id;
        }
        $single_gps_id=$this->getClientGpsId($single_sub_dealers_array);       
        $gps=$this->getDealerGpsClientSale($single_gps_id);
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
    public function subDealerGpsClientSale(Request $request)
    {
        $sub_dealer_id                  =   \Auth::user()->subdealer->id;       
        $single_gps_id=$this->getClientGpsId($sub_dealer_id);
        $gps=$this->getDealerGpsClientSale($single_gps_id);
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
     function getDealerGpsClientSale($single_gps_id){
       $gps = Gps::select(
            'id',
            \DB::raw('date_format(login_on, "%M") as month'),
            \DB::raw('count(date_format(login_on, "%M")) as count')
        )
       ->whereIn('id',$single_gps_id)
       ->whereNotNull('login_on')
        ->orderBy("month","DESC")
        ->groupBy("month")
        ->get();
        return $gps;
    }
    function getClientGpsId($sub_dealer_ids){
       
        $user = \Auth::user();
        $traders_of_sub_dealers     = Trader::select(
            'id','sub_dealer_id'
            )
            ->withTrashed();
        if($user->hasRole('dealer')){
            $traders_of_sub_dealers     = $traders_of_sub_dealers->whereIn('sub_dealer_id',$sub_dealer_ids);
         }
         else{
            $traders_of_sub_dealers     = $traders_of_sub_dealers->where('sub_dealer_id',$sub_dealer_ids);
         }
        $traders_of_sub_dealers     = $traders_of_sub_dealers->get();
        $single_traders             = [];
        foreach($traders_of_sub_dealers as $trader){
            $single_traders[]       = $trader->id;
        }
        if($user->hasRole('dealer')){
        $end_users            =   Client::select('id','trader_id','sub_dealer_id')->where(function ($query) use($single_traders, $sub_dealer_ids) {
            $query->whereIn('trader_id', $single_traders)
            ->orWhereIn('sub_dealer_id', $sub_dealer_ids);
            })->get();
        }else{
            $end_users            =   Client::select('id','trader_id','sub_dealer_id')->where(function ($query) use($single_traders, $sub_dealer_ids) {
            $query->whereIn('trader_id', $single_traders)
            ->orWhere('sub_dealer_id', $sub_dealer_ids);
            })->get();
        }
            $single_client             = [];
            foreach($end_users as $end_user){
                $single_client[]       = $end_user->id;
            }
        $vehicles     = Vehicle::select(
        'id','gps_id','client_id'
        )
        ->withTrashed()
        ->whereIn('client_id',$single_client)
        ->get();
        $single_gps_id             = [];
        foreach($vehicles as $vehicle){
            $single_gps_id[]       = $vehicle->gps_id;
        }
        return $single_gps_id;
    }
    //______________________________________________Eugene
        //eugene
    public function dashVehicleUserTrack(Request $request)
    {
            $vehicles = DB::select('select register_number,imei,_gps_summery.updated_at,lat,lon,speed from tbl_user_vs_vehicles link
    left join vehicles as _vehicles on _vehicles.register_number=link.register_number_vehicles
    left join gps_summery as _gps_summery on _gps_summery.id=_vehicles.gps_id
    where id_user= ?', [auth()->id()]);
    
            return response()->json($vehicles);
    }
    public function GetEugInfoView(Request $request)
    {
            $imei = $request->input('imei');
            $html="";
            $info = DB::select("select register_number,client_id,_gps_summery.updated_at,username,email,mobile from gps_summery _gps_summery 
    left join vehicles as _vehicles on _vehicles.gps_id=_gps_summery.id
    left join users as _users on _users.id=_vehicles.client_id
    where imei=?",[$imei]);
    
            if (!empty($info)) {
                foreach ($info as $record) {
                    $register_number = $record->register_number;
                    $updated_at = $record->updated_at;
    
                    //$html = "Register Number: $register_number, Updated At: $updated_at<br>";
                    $html="<div>
            <table><tbody>
            <tr><td>Reg.No.</td><td style='font-weight:bold;'>$register_number</td></tr>
            <tr><td>IMEI</td><td>$imei</td></tr>
            <tr><td>Client</td><td style='font-weight:bold;'>$record->username</td></tr>
            <tr><td>email</td><td>$record->email</td></tr>
            <tr><td>mobile</td><td>$record->mobile</td></tr>
            <tr><td colspan=2 style='border-bottom:1px solid #666;'></td></tr>
            <tr><td colspan=2>Last update at $record->updated_at</td></tr>
            </tbody></table>
            </div>";
    
                }
            } else {
                echo "No records found.";
            }
    
            return $html;
    }
    //eugene
    public function mapUserView()
    {
        file_put_contents('/var/www/smarteclipseweb/temp/log1.txt', date('Y-m-d H:i:s') . "mapUserView"."\n", FILE_APPEND);

        /*
        $gps = Gps::select('id','imei')->whereNotNull('lat')->whereNotNull('lon')
            ->with('vehicle:id,name,gps_id')
            ->get();
        return view('Dashboard::map-user-view',['gpss' => $gps]);
        */
        #file_put_contents('/var/www/smarteclipseweb/temp/log1.txt', date('Y-m-d H:i:s') . "Point 1"."\n", FILE_APPEND);

        $vehicles = DB::select("select register_number,imei,_gps_summery.updated_at,lat,lon,speed from tbl_user_vs_vehicles link
left join vehicles as _vehicles on REPLACE(REPLACE(_vehicles.register_number, ' ', ''), '-', '')=REPLACE(REPLACE(link.register_number_vehicles, ' ', ''), '-', '')
left join gps_summery as _gps_summery on _gps_summery.id=_vehicles.gps_id
where id_user= ?", [auth()->id()]);

        
        return view('Dashboard::map-user-view',['vehicles' => $vehicles]);
    }    

    private function GetUserDashboard(){
        /*// Will the details using local ajax
        //$userid = $request->input('userid');
        $vehicles = DB::select('select register_number,imei,_gps_summery.updated_at,lat,lon from tbl_user_vs_vehicles link
        left join vehicles as _vehicles on _vehicles.register_number=link.register_number_vehicles
        left join gps_summery as _gps_summery on _gps_summery.id=_vehicles.gps_id
        where id_user= ?', [auth()->id()]);
        return view('Dashboard::user',['vehicles' => $vehicles]);
        */
        return view('Dashboard::user-dashboard');
    }
    public function GetDashVehiclesView(Request $request){
        $userid = $request->input('userid');
        $mode = $request->input('mode');
        
        $vehicles = DB::select("select imei, register_number,imei,lat,lon, _gps_summery.updated_at,speed,username,client_id 
        from tbl_user_vs_vehicles link
left join vehicles as _vehicles on REPLACE(REPLACE(_vehicles.register_number, ' ', ''), '-', '')=REPLACE(REPLACE(link.register_number_vehicles, ' ', ''), '-', '')
left join users as _users on _users.id=_vehicles.client_id
left join gps_summery as _gps_summery on _gps_summery.id=_vehicles.gps_id
where id_user=?", [$userid]);
        

        return view('Dashboard::vehicleview',['vehicles' => $vehicles,'mode'=>$mode]);
    }
    
    
    public function AddVehicle(Request $request){
        $regnoRaw = trim($request->input('regno'));
        $userid = $request->input('userid');
        $mode = $request->input('mode');
        $otp = $request->input('otp');

        $exists=0;
        $client_id="";
        $regno = str_replace([' ', '-'], '', $regnoRaw);
        if(strlen($regno)<3){
            return response()->json(['mess' => 'Invalid Register Number','color'=>'red']);
        }
        $mess="";
        $gps_id="";

        if(strlen($regno)===15){// its IMEI
            $result = DB::select("select id from gps_summery where imei=?", [$regno]);
            if (empty($result)) {
                return response()->json(['mess' => 'No such imei entry available','color'=>'red']);
            }
            $gps_id=$result[0]->id;
            $mess.="GPS Available. ";
            //return response()->json(['mess' => 'gps_id '.$gps_id.' exists','color'=>'blue']);
        }        

        if($mode==="check"){
            $exists=0;

            if($regno!==15){
                $regnoRetrived="";
                if(strlen($gps_id)>0){
                    $result = DB::select("select client_id,register_number  from vehicles where gps_id=?", [$gps_id]);
                    if (!empty($result)) {
                        foreach ($result as $vehicle) {
                            $exists=1;
                            $client_id=$vehicle->client_id;
                            $regnoRetrived=$vehicle->register_number;
                        }
                    }
                }else{
                    $result = DB::select("select client_id,register_number  from vehicles where REPLACE(REPLACE(register_number, ' ', ''), '-', '')=?", [$regno]);
                    if (!empty($result)) {
                        foreach ($result as $vehicle) {
                            $exists=1;
                            $client_id=$vehicle->client_id;
                            $regnoRetrived=$vehicle->register_number;
                        }
                    }
                }
                if($exists===1){

                    $exists=0;
                    $result = DB::select("select m_id from tbl_user_vs_vehicles where REPLACE(REPLACE(register_number_vehicles , ' ', ''), '-', '')=? and id_user=?",
                    [$regnoRetrived,$userid]);
        
                    if (!empty($result)) {
                        foreach ($result as $vehicle) {
                            $exists=1;
                        }
                    }


                    if($exists===1){
                        return response()->json(['mess' => $mess . 'Vehicle exists in your login ('.$regnoRetrived.')','color'=>'blue']);
                    }else{
                        return response()->json(['mess' => $mess . 'Vehicle exists  ('.$regnoRetrived.')','color'=>'blue']);
                    }
                    
                }else{
                    return response()->json(['mess' => $mess . 'No such vehicle exists','color'=>'red']);
                }
            }else{

            }
        }else if($mode==="add"){
            $exists=0;
            /*
            $result = DB::select("select client_id from vehicles where REPLACE(REPLACE(register_number, ' ', ''), '-', '')=?", [$regno]);
            if (!empty($result)) {
                foreach ($result as $vehicle) {
                    $exists=1;
                    $client_id=$vehicle->client_id;
                }
            }
                */
            if(strlen($gps_id)>0){
                $result = DB::select("select client_id,register_number  from vehicles where gps_id=?", [$gps_id]);
                if (!empty($result)) {
                    foreach ($result as $vehicle) {
                        $exists=1;
                        $client_id=$vehicle->client_id;
                        $regnoRetrived=$vehicle->register_number;
                    }
                }
            }else{
                $result = DB::select("select client_id,register_number  from vehicles where REPLACE(REPLACE(register_number, ' ', ''), '-', '')=?", [$regno]);
                if (!empty($result)) {
                    foreach ($result as $vehicle) {
                        $exists=1;
                        $client_id=$vehicle->client_id;
                        $regnoRetrived=$vehicle->register_number;
                    }
                }
            }

            if($exists===0){
                return response()->json(['mess' => 'No such vehicle exists','color'=>'red']);
            }


            $exists=0;
            $result = DB::select("select m_id from tbl_user_vs_vehicles where REPLACE(REPLACE(register_number_vehicles , ' ', ''), '-', '')=? and id_user=?",
            [$regnoRetrived,$userid]);

            if (!empty($result)) {
                foreach ($result as $vehicle) {
                    $exists=1;
                }
            }
            if($exists===1){
                return response()->json(['mess' => 'Vehicle already exists in your login','color'=>'red']);
            }
            if($otp!=="abcd"){
                return response()->json(['mess' => 'Invalid OTP','color'=>'red']);
            }

            $inserted = DB::insert("insert into tbl_user_vs_vehicles (register_number_vehicles,id_user) values (?,?)",
            [$regnoRetrived,$userid]);
            if ($inserted) {
                return response()->json(['mess' => 'Vehicle inserted in your login','color'=>'blue']);
            } else {
                return response()->json(['mess' => 'Failed to insert this vehicle','color'=>'red']);
            }
        }else if($mode==="delete"){
            $deleted = DB::delete("delete from tbl_user_vs_vehicles where REPLACE(REPLACE(register_number_vehicles , ' ', ''), '-', '')=?",
            [$regno]);
            if ($deleted) {
                return response()->json(['mess' => 'Vehicle removed from your login','color'=>'blue']);
            } else {
                return response()->json(['mess' => 'Failed to removed this vehicle','color'=>'red']);
            }
        }else{
            return response()->json(['mess' => 'Got '.$regno.' and '.$userid.'. Record='.$exists . '. client_id='.$client_id]);
        }
    }
    public function UserActivities(Request $request){
        $user = trim($request->input('user'));
        $userid = $request->input('userid');
        $mode = $request->input('mode');
        $pass = $request->input('pass');
        $mess="";
        if($mode==='search' || $mode==='activate' || $mode==='password'){
            $modelType1 = 'App\\Models\\User';
            $modelType2 = 'App\\Modules\\User\\Models\\User';
            $result = DB::select("select id,mobile,email,username,role from users where id=? or username=? or mobile=? or email=?",
            [$user,$user,$user,$user]);

            if($mode==='activate'){
                $model11 = DB::select("select * from model_has_roles where model_type=? and model_id=?", [$modelType1,$result[0]->id]);
                if(empty($model11)){
                    DB::insert("insert into model_has_roles (role_id,model_type ,model_id) values (20,?,?)",[$modelType1,$result[0]->id]);
                    $mess="Account Activated. ";
                }else{
                    DB::update("update model_has_roles set role_id=20 where model_type=? and model_id=?",[$modelType1,$result[0]->id]);
                }

                $model22 = DB::select("select * from model_has_roles where model_type=? and model_id=?", [$modelType2,$result[0]->id]);
                if(empty($model22)){
                    DB::insert("insert into model_has_roles (role_id,model_type ,model_id) values (20,?,?)",[$modelType2,$result[0]->id]);
                    $mess="Account Activated. ";
                }else{
                    DB::update("update model_has_roles set role_id=20 where model_type=? and model_id=?",[$modelType2,$result[0]->id]);
                }
                //____________Ensure that all this users vehicles are addeded to his login
                $hisVehicles = DB::select("select * from vehicles where client_id=?", [$result[0]->id]);
                $vehicleCount=0;
                $addedCount=0;
                if (!empty($hisVehicles)) {
                    foreach ($hisVehicles as $vehicle) {
                        $vehicleCount++;
                        $hisVehicle = DB::select("select * from tbl_user_vs_vehicles where id_user=? and register_number_vehicles=?",
                         [$result[0]->id,$vehicle->register_number]);
                         if (empty($hisVehicle)) {
                            $res = DB::insert("insert into tbl_user_vs_vehicles (id_user,register_number_vehicles) values (?,?)",
                            [$result[0]->id,$vehicle->register_number]);
                            if($res){
                                $addedCount++;
                            }
                         }
                    }
                    $mess.=$addedCount ." out of ".$vehicleCount. " vehicles added. ";
                }else{
                    $mess.="Has no own vehicles. ";
                    
                }
            }
            if($mode==='password'){
                    if(strlen($pass)<4)$mess.="Small password. ";
                    $passEncrypted="";
                    $passEncrypted = password_hash($pass, PASSWORD_BCRYPT);
                    $up = DB::update("update users set password=? where id=?",[$passEncrypted,$result[0]->id]);
                    if($up){
                        $mess.="Password updated. ";
                    }else{
                        $mess.="Nothing is done. ";
                    }
            }

            if ($result) {
                $vehicles = DB::select("select count(client_id) as cnt from vehicles where client_id=?",[$result[0]->id]);
                $others = DB::select("select count(id_user) as cnt from tbl_user_vs_vehicles where id_user=?",[$result[0]->id]);
                $model1 = DB::select("select * from model_has_roles where model_type=? and model_id=?", [$modelType1,$result[0]->id]);
                $model2 = DB::select("select * from model_has_roles where model_id=? and model_type=?", [$result[0]->id,$modelType2]);
                $model="";
                if(!empty($model1) && !empty($model2)){
                    $model=1;
                }
                $mess.='Data received';
                return response()->json(['mess' => $mess,'color'=>'blue','data'=>$result,'vehicles'=>$vehicles,
                'others'=>$others,'model'=>$model]);
            }else{
                return response()->json(['mess' => 'No data available','color'=>'red','data'=>$result]);
            }
        }else{
            return response()->json(['mess' => 'Unknown request','color'=>'red']);
        }
    }
    public function AdminListVehicles(Request $request){
        $search = trim($request->input('search'));
        $user = \Auth::user();
        $search = '%'.$search.'%';
        $sqlbit=" and client_id=? ";
        if($user->id==806063){$sqlbit="";}

        $sql ="select imei, register_number,imei,lat,lon, _gps_summery.updated_at,speed,username,client_id 
        from vehicles _vehicles
        left join tbl_user_vs_vehicles link on link.register_number_vehicles=_vehicles.register_number
        left join users as _users on _users.id=_vehicles.client_id
        left join gps_summery as _gps_summery on _gps_summery.id=_vehicles.gps_id
        where (imei like ? or register_number like ?) ".$sqlbit." order by username";

  
        $vehicles = DB::select($sql, [$search,$search,$user->id]);

        $viewString = view('Dashboard::vehicleadmin', ['mode' => '', 'vehicles' => $vehicles])->render();

        return response()->json(['mess' => count($vehicles).' vehicles listed','color'=>'blue','html'=>$viewString]);
    }
    
    public function AdminListUsers(Request $request){
        $search = trim($request->input('search'));
        $search = '%'.$search.'%';
        $user = \Auth::user();
        if($user->id==806063){
            //left join tbl_user_vs_vehicles link on link.register_number_vehicles=_vehicles.register_number
            //left join users as _users on _users.id=_vehicles.client_id
            //left join gps_summery as _gps_summery on _gps_summery.id=_vehicles.gps_id        

            $users = DB::select("select username,mobile,email
                from users _users
                where username like ? or email like ? or mobile like ? order by username", [$search,$search,$search]);

            $viewString = view('Dashboard::usersadmin', ['mode' => '', 'users' => $users])->render();
            return response()->json(['mess' => count($users).' users listed','color'=>'blue','html'=>$viewString]);
        }else{
            return response()->json(['mess' => 'No users listed','color'=>'red','html'=>"Not authorized"]);
        }
    }

}
