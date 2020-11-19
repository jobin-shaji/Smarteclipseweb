<?php
namespace App\Modules\Client\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Client\Models\ClientAlertPoint;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Geofence\Models\Geofence;
use App\Modules\Vehicle\Models\VehicleGeofence;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Ota\Models\OtaResponse;
use App\Modules\Alert\Models\AlertType;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\User\Models\User;
use App\Modules\Trader\Models\Trader;
use Illuminate\Support\Facades\Crypt;
use App\Modules\TrafficRules\Models\Country;
use App\Modules\TrafficRules\Models\State;
use App\Modules\TrafficRules\Models\City;
use DB;
use App\Modules\Client\Models\Voucher;
use App\Modules\Client\Models\ClientTransaction;
use App\Modules\Subscription\Models\Plan;
use App\Modules\Subscription\Models\Subscription;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use App\Jobs\MailJob;
use App\Http\Traits\MqttTrait;
use App\Mail\UserCreated;
use App\Mail\UserCreatedWithoutEmail;
use App\Mail\UserUpdated;
use Illuminate\Support\Facades\Mail;
use App\Modules\Client\Models\OnDemandTripReportRequests;


class ClientController extends Controller {

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

    //employee creation page
    public function create()
    {
        $countries=Country::select([
            'id',
            'name'
        ])
        ->where('id',101)
        ->get();
         $url=url()->current();
        
         $rayfleet_key="rayfleet";
         $eclipse_key="eclipse";
         if (strpos($url, $rayfleet_key) == true) {  
            $default_country_id="178";
          }else if (strpos($url, $eclipse_key) == true) {
            $default_country_id="101";
          }else
          {
         $default_country_id="101";
          }
        $logged_user_id = \Auth::user()->id;
        return view('Client::client-create',['countries'=>$countries,'default_country_id'=>$default_country_id,'logged_user_id'=>$logged_user_id]);
    }
    //get state in dependent dropdown
    public function getStateList(Request $request)
    {
        $countryID=$request->countryID;
        $states = State::select(
                'id',
                'name'
                )
                ->where("country_id",$countryID)
                ->get();
        return response()->json($states);
    }
     //get state in dependent dropdown
    public function getCityList(Request $request)
    {
        $stateID=$request->stateID;
        $city = City::select(
            'id',
            'name'
        )
        ->where("state_id",$stateID)
        ->get();
        return response()->json($city);
    }
    //upload employee details to database table
    public function save(Request $request)
    {
        /**
         * getCityGeoCodes getting lat lng from city table
         */
      
        $placeLatLng            = (new City())->getCityGeoCodes($request->city_id);
        $location_lat           = $placeLatLng['latitude'];
        $location_lng           = $placeLatLng['longitude'];
        // $location=$request->search_place;
        $current_date           = date('Y-m-d H:i:s');
        if($request->user()->hasRole('sub_dealer'))
        {
            $subdealer_id       = \Auth::user()->subdealer->id;
            $url                = url()->current();
            $rayfleet_key       = "rayfleet";
            $eclipse_key        = "eclipse";

            if (strpos($url, $rayfleet_key) == true) 
            {
                 $rules         = $this->rayfleet_user_create_rules();
            }
            else if (strpos($url, $eclipse_key) == true) 
            {
                 $rules         = $this->user_create_rules();
            }
            else
            {
               $rules           = $this->user_create_rules();
            }
            $this->validate($request, $rules);
            $user               = User::create([
                                    'username' => $request->username,
                                    'email' => $request->email,
                                    'mobile' => $request->mobile_number,
                                    'status' => 1,
                                    'password' => bcrypt($request->password),
                                    'role' => 0,
                                ]);
            
            $client             =   (new Client())->createNewClientFromDealer($user->id, $subdealer_id, strtoupper($request->name), $request->address, $location_lat, $location_lng, $request->country_id, $request->state_id, $request->city_id, $current_date);
            if($client)
            {
                if($request->client_category=="school")
                {
                    User::select('id','username')->where('username', $request->username)->first()->assignRole('school');
                }else
                {
                    User::select('id','username')->where('username', $request->username)->first()->assignRole('client');
                }
                
                // ----------Create user alerts && Client alert points----------
                $alert_types = AlertType::select('id','driver_point')->get();
                foreach ($alert_types as $alert_type) 
                {
                    $user_alerts = UserAlerts::create([
                        "alert_id" => $alert_type->id,
                        "client_id" => $client->id,
                        "status" => 1
                    ]);
                    $client_alert_point     = ClientAlertPoint::create([
                        "alert_type_id"           => $alert_type->id,
                        "driver_point"            => $alert_type->driver_point,
                        "client_id"               => $client->id
                    ]);
                }

                // ----------Create user alerts && Client alert points----------

                if($user->email != null)
                {
                    Mail::to($user)->send(new UserCreated($user, $request->name, $request->password));
                }
                else
                {
                    $root = \Auth::user()->subdealer->dealer->root->id;
                    $user = User::find($root);
                    Mail::to($user)->send(new UserCreatedWithoutEmail($user, $request->name, $request->password,$request->username));
                }
            }

            
           
        }
        else if($request->user()->hasRole('trader'))
        {

            $trader_id      = \Auth::user()->trader->id;
            $url            = url()->current();
            $rayfleet_key   = "rayfleet";
            $eclipse_key    = "eclipse";
            if (strpos($url, $rayfleet_key) == true) 
            {
                $rules = $this->rayfleet_user_create_rules();
            }
            else if (strpos($url, $eclipse_key) == true) 
            {
                $rules = $this->user_create_rules();
            }
            else
            {
                $rules = $this->user_create_rules();
            }
            $this->validate($request, $rules);
            $user = User::create([
                'username'              => $request->username,
                'email'                 => $request->email,
                'mobile'                => $request->mobile_number,
                'status'                => 1,
                'password'              => bcrypt($request->password),
                'role'                  => 0,
            ]);

            $client                     =   (new Client())->createNewClientFromSubDealer($user->id, $trader_id, strtoupper($request->name), $request->address, $location_lat, $location_lng, $request->country_id, $request->state_id, $request->city_id, $current_date); 
            if($client)
            {
                if($request->client_category=="school")
                {
                    User::select('id','username')->where('username', $request->username)->first()->assignRole('school');
                }else{
                    User::select('id','username')->where('username', $request->username)->first()->assignRole('client');
                }

                // ----------Create user alerts && Client alert points----------
                $alert_types = AlertType::select(
                'id',
                'driver_point')
                ->get();
                foreach ($alert_types as $alert_type) 
                {
                    $user_alerts        = UserAlerts::create([
                        "alert_id"              => $alert_type->id,
                        "client_id"            => $client->id,
                        "status"               => 1
                    ]);
                    $client_alert_point = ClientAlertPoint::create([
                        "alert_type_id"     => $alert_type->id,
                        "driver_point"      => $alert_type->driver_point,
                        "client_id"         => $client->id
                    ]);
                }

                // ----------Create user alerts && Client alert points----------

                if($user->email != null)
                {
                    Mail::to($user)->send(new UserCreated($user, $request->name, $request->password));
                }
                else
                {
                    $root = \Auth::user()->trader->subDealer->dealer->root->id;
                    $user = User::find($root);
                    Mail::to($user)->send(new UserCreatedWithoutEmail($user, $request->name, $request->password,$request->username));
                }

            }
           
        }

        $eid= encrypt($user->id);
        return response()->json([
            'status'    => true,
            'message'   => 'New end user created successfully'
        ]);
       
    }

    public function clientList()
    {
        return view('Client::client-list');
    }

    public function getClientlist(Request $request)
    {
        if($request->user()->hasRole('trader')){
            $trader     =   $request->user()->trader->id;
            $client     =   (new Client())->getDetailsOfClientsUnderSubDealerWithTrashedItems($trader);
            
        }else{
            $subdealer  =   $request->user()->subdealer->id;
            $client     =   (new Client())->getDetailsOfClientsUnderDealerWithTrashedItems($subdealer);
        }

        return DataTables::of($client)
        ->addIndexColumn()
        ->addColumn('action', function ($client) {
             $b_url = \URL::to('/');
        if($client->user->deleted_at == null && $client->deleted_at == null){
            return "
            <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
             <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
              <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/change-password-subdealer class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <button onclick=delClient(".$client->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
        }else{
                return "
                <button onclick=activateClient(".$client->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function edit(Request $request)
    {     
        $decrypted = Crypt::decrypt($request->id);
        $client = (new Client())->getClientDetails($decrypted); 
        $countries = (new Country())->getCountryDetails();
        $states = (new State())->getStateDetails($client->city->state->country->id);
        $cities = (new City())->getCityDetails($client->city->state->id);         
        if($client == null)
        {
            return view('Client::404');
        }
        return view('Client::client-edit',['client' => $client,'countries'=>$countries,'states'=>$states,'cities'=>$cities]);
    }

    //update dealers details
    public function update(Request $request)
    {
        $client     =   (new Client())->checkUserIdIsInClientTable($request->id);
        if($client == null){
            return view('Client::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        if (strpos($url, $rayfleet_key) == true) {
            $rules = $this->rayfleetClientUpdateRules($client);
        }
        else
        {
            $rules = $this->clientUpdateRules($client);
        }
        $this->validate($request, $rules);
        $user = User::find($request->id);
        $did = encrypt($user->id);
        $client->city_id=$request->city_id;
        $client->state_id=$request->state_id;
        $client->country_id=$request->country_id;
        $placeLatLng = (new City())->getCityGeoCodes($request->city_id);
        $location_lat=$placeLatLng['latitude'];
        $location_lng=$placeLatLng['longitude'];
        $client->name = $request->name;
        $client->latitude= $location_lat;
        $client->longitude=$location_lng;
        $client->address=$request->address;
        $current_date=date('Y-m-d H:i:s');
        $client->latest_user_updates = $current_date;
        $client->save();
        // dd($client);
        $user->email= $request->email;
        $user->mobile = $request->mobile_number;
        $user->save();

        $request->session()->flash('message', 'End user details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client.details',$did));
    }

    //for edit page of subdealer password
    public function changePassword(Request $request)
    {
        $decrypted  =   Crypt::decrypt($request->id);
        $client     =   (new Client())->checkUserIdIsInClientTable($decrypted);
        if($client == null){
           return view('Client::404');
        }
        return view('Client::client-change-password',['client' => $client,
        'decrypted'=>$decrypted]);
    }

    //update password
    public function updatePassword(Request $request)
    {
        $client         =   \Auth::user()->sub_dealer;
        $user           =   User::find($request->id);
        $client         =   (new Client())->checkUserIdIsInClientTable($user->id);
        $current_date   =   date('Y-m-d H:i:s');
        $client->latest_user_updates = $current_date;
        $client->save();
        if($user== null){
            return view('SubDealer::404');
        }
        $did=encrypt($user->id);

        $rules=$this->updateUserPassword();
        $this->validate($request,$rules);
        $user->password=bcrypt($request->password);
        $user->save();
        $request->session()->flash('message','Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('client.change-password',$did));
    }

    public function changeClientPassword(Request $request)
    {
        $decrypted  =   Crypt::decrypt($request->id);
        $client     =   (new Client())->checkUserIdIsInClientTable($decrypted);
        $user       =   User::select('username')->where('id',$client->user_id)->first();
        if($client == null){
           return view('Client::404');
        }
        return view('Client::subdealer-client-change-password',['client' => $client,'user' => $user]);
    }

    //update password
    public function updateClientPassword(Request $request)
    {
        $client=User::find($request->id);
        if($client== null){
            return view('SubDealer::404');
        }
        $did=encrypt($client->id);
        // dd($request->password);
        $rules=$this->updateUserPasswordBySubdealer($client);
        $this->validate($request,$rules);
        $client->password=bcrypt($request->password);
        $client->username=$request->username;
        $client->save();
        if($client->email != null)
        {
            Mail::to($client)->send(new UserUpdated($client, $client->client->name, $request->password));
        }
        $request->session()->flash('message','Username & Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('client.change-password-subdealer',$did));
    }

    public function paymentsView(Request $request){
        $decrypted_plan_id = $request->plan;
        $plan_id=decrypt($decrypted_plan_id);
        $plan=Plan::find($plan_id);
        $url=url()->current();
        $rayfleet_key="rayfleet";
        if (strpos($url, $rayfleet_key) == true) {
            $subscription=Subscription::select('plan_id','country_id','amount')->where('plan_id',$plan_id)->where('country_id',178)->first();

        }else{
            $subscription=Subscription::select('plan_id','country_id','amount')->where('plan_id',$plan_id)->where('country_id',101)->first();

        }
        $amount = $subscription->amount;
        $voucher = Voucher::create([
                    'reference_id' => time().rand(1000,5000),
                    'client_id' => $request->user()->client->id,
                    'amount' => $amount,
                    'subscription' => $plan->name
                   ]);
        return view('Client::payment',['plan' => $plan->name, 'amount' => $amount, 'reference_Id' => $voucher->reference_id]);
    }

    public function paymentReview(Request $request){
        $status = $request->status;
        if($status == "success"){
            $reference_id = $request->referenceId;
            $transaction_id = $request->transactionId;
            $date_time = $request->datetime;
            $amount = $request->amount;

            $transaction = Voucher::where('reference_id',$reference_id)->first();

            if($transaction){
                if($transaction->amount == $amount){
                    ClientTransaction::create([
                        'transaction_id' => $transaction_id,
                        'reference_id' => $reference_id,
                        'amount' => $amount,
                        'status' => 1,
                        'gateway' => 'qpay',
                        'payment_date' => $date_time
                    ]);

                    ClientController::updateClientRole($transaction->subscription);
                    return view('Gps::subscription-success');
                }
            }


        }
    }

    public function updateUserPassword()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'oldpassword'=>'required',
        ];
        return $rules;
    }
    public function updateUserPasswordBySubdealer($client)
    {
        $rules=[
            'username' => 'required|unique:users,username,'.$client->id,
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }
    public function activatesubscription()
    {
        $rules=[
            'client_role' => 'required'
        ];
        return $rules;
    }

    /**
     * Client Details view
     * 
     */
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $client = (new Client())->getClientDetails($decrypted);
        if($client == null)
        {
            return view('Client::404');
        }
        return view('Client::client-details',['client' => $client]);
    }


    public function clientListPage()
    {
        return view('Client::root-client-list');
    }

    //returns employees as json
    public function getRootClient()
    {
        $client     =   (new Client())->getAllClientDetails();
        return DataTables::of($client)
        ->addIndexColumn()
        ->addColumn('working_status', function ($client) {
            $b_url = \URL::to('/');
            if($client->user->deleted_at == null && $client->deleted_at == null){
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disableEndUser(".$client->user_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
                <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/subscription class=' btn-xs btn-danger'> Subscription </a>

            ";
            }else{
            return "
                <b style='color:#FF0000';>Disabled</b>
                <button onclick=enableEndUser(".$client->user_id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Enable </button>
            ";
            }
        })
        ->addColumn('subdealer', function ($client)
        {
              if($client->trader_id)
                {
                    return $client->trader->subDealer->name;
                }
                else{
                    return $client->subdealer->name;
                }
        })
        ->addColumn('trader', function ($client)
        {

                if($client->trader_id)
                {
                    return $client->trader->name;
                }else{
                    return "--";
                }
        })

        ->rawColumns(['link','working_status'])
        ->make();
    }

    //delete client details from table
    public function disableClient(Request $request)
    {
        $client_user    =   User::find($request->id);
        $client         =   (new Client())->checkUserIdIsInClientTable($request->id); 
        if($client_user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'End user does not exist'
            ]);
        }
        $client_user->delete();
        $client->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'End user disabled successfully'
        ]);
    }

    // restore emplopyee
    public function enableClient(Request $request)
    {
        $client_user    =   User::withTrashed()->find($request->id);
        $client         =   (new Client())->checkUserIdIsInClientTableWithTrashedItems($request->id); 
        if($client_user==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'End user does not exist'
            ]);
        }
        $client_user->restore();
        $client->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'End user enabled successfully'
        ]);
    }

    public function dealerClientListPage()
    {
        return view('Client::dealer-client-list');
    }

    //returns employees as json
    public function getDealerClient()
    {
        $dealer_id=\Auth::user()->dealer->id;
        $sub_dealers = SubDealer::select(
                'id'
                )
                ->withTrashed()
                ->where('dealer_id',$dealer_id)
                ->get();
        $single_sub_dealers = [];
        foreach($sub_dealers as $sub_dealer){
            $single_sub_dealers[] = $sub_dealer->id;
        }
        $traders = Trader::select(
            'id'
            )
            ->withTrashed()
            ->whereIn('sub_dealer_id',$single_sub_dealers)
            ->get();
        $single_traders = [];
        foreach($traders as $trader){
            $single_traders[] = $trader->id;
        }

        $client     =   (new Client())->getClientDetailsUnderDealersAndSubDealers($single_traders, $single_sub_dealers);
        return DataTables::of($client)
        ->addColumn('dealer', function ($client) {
            if($client->trader_id)
            {
                return $client->trader->subDealer->name;
            }
            else{
                return $client->subdealer->name;
            }
        })
        ->addColumn('sub_dealer', function ($client) {
            if($client->trader_id){
                return $client->trader->name;
            }else{
                return '--';
            }
        })
        ->addIndexColumn()
        ->make();
    }
//////////////////////////////////////subscription/////////////////////////////////////
    public function subscription(Request $request)
    {
        $client_user_id=Crypt::decrypt($request->id);
        $user = User::find(Crypt::decrypt($request->id));
        $roles = $user->roles;
        return view('Client::client-subscription',compact('roles'),['client_user_id'=>$request->id,'user'=>$user]);
    }

    public function addUserRole(Request $request)
    {
        $rules=$this->activatesubscription();
        $this->validate($request,$rules);
        $client_user_id=Crypt::decrypt($request->id);
        $geofences= Geofence::select('user_id','id')->where('user_id',$client_user_id)->withTrashed()->get();
        foreach ($geofences as $geofence) {
            $vehicle_geofences=VehicleGeofence::select('geofence_id')->where('geofence_id',$geofence->id)->withTrashed()->get();
            foreach ($vehicle_geofences as $vehicle_geofence) {
                // $vehicle_geofence->forceDelete();
                VehicleGeofence::where('geofence_id',$geofence->id)->forceDelete();
            }
            $geofence_cleared = $geofence->forceDelete();
        }
        $user = User::find($client_user_id);

        $vehicles= Vehicle::select('id','client_id','gps_id')->where('client_id',$user->client->id)->withTrashed()->get();
        foreach ($vehicles as $vehicle) {
            $response_string    =   "CLR VGF";
            $geofence_response  =   (new OtaResponse())->saveCommandsToDevice($vehicle->gps_id,$response_string);  
            if($geofence_response)
            {
                $gps_details                    =   (new Gps())->getGpsDetails($vehicle->gps_id);
                $is_command_write_to_device     =   (new OtaResponse())->writeCommandToDevice($gps_details->imei,$response_string);
                if($is_command_write_to_device)
                {
                    $this->topic                    =   $this->topic.'/'.$gps_details->imei;
                    $is_mqtt_publish                =   $this->mqttPublish($this->topic, $response_string);
                }
            }
        }

        if($request->client_role==6)
        {
            $user->role = 1;
        }
        else if($request->client_role==7)
        {
            $user->role = 2;
        }
        else if($request->client_role==8)
        {
            $user->role = 3;
        }
        $user->save();
        $roles = $user->roles;
        if($request->role_name!=null)
        {
            $user->removeRole($request->role_name);
        }
        $current_date   =   date('Y-m-d H:i:s');
        //update role updation date in client table
        $client_update  =   (new Client())->updateLatestUserUpdate($client_user_id, $current_date);
        $user->assignRole($request->client_role);
        $roles = $user->roles;
        $request->session()->flash('message', 'User Role added successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client.subscription',$request->id));

    }

    //delete client roles from table
    public function clientSubscriptionDelete(Request $request)
    {
        $decrypted_user_id = Crypt::decrypt($request->user_id);
        $decrypted_role_id = Crypt::decrypt($request->role_id);
        $user = User::find($decrypted_user_id);
        $geofences= Geofence::select('user_id','id')->where('user_id',$decrypted_user_id)->withTrashed()->get();
        foreach ($geofences as $geofence) {
            $vehicle_geofences=VehicleGeofence::select('geofence_id')->where('geofence_id',$geofence->id)->withTrashed()->get();
            foreach ($vehicle_geofences as $vehicle_geofence) {
                $vehicle_geofence->forceDelete();
            }
            $geofence_cleared = $geofence->forceDelete();
        }

        $vehicles= Vehicle::select('id','client_id','gps_id')->where('client_id',$user->client->id)->withTrashed()->get();
        foreach ($vehicles as $vehicle) {
            $response_string    =   "CLR VGF";
            $geofence_response  =   (new OtaResponse())->saveCommandsToDevice($vehicle->gps_id,$response_string);  
            if($geofence_response)
            {
                $gps_details                        =   (new Gps())->getGpsDetails($vehicle->gps_id);
                $is_command_write_to_device         =   (new OtaResponse())->writeCommandToDevice($gps_details->imei,$response_string);
                if($is_command_write_to_device)
                {
                    $this->topic                    =   $this->topic.'/'.$gps_details->imei;
                    $is_mqtt_publish                =   $this->mqttPublish($this->topic, $response_string);
                }
            }
        }

        $user->role = 0;
        $user->save();
        $current_date   =   date('Y-m-d H:i:s');
        //update role updation date in client table
        $client_update  =   (new Client())->updateLatestUserUpdate($decrypted_user_id, $current_date);
        $user->removeRole($decrypted_role_id);
        $roles = $user->roles;
        $request->session()->flash('message', 'User Role deleted successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client.subscription',$request->user_id));

    }

    //delete Sub Dealer details from table
    public function deleteClient(Request $request)
    {
        $client     =   (new Client())->getClientDetailsWithClientId($request->uid); 
        if($client == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'End user does not exist'
            ]);
        }
        $client->user->delete();
        $client->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'End user deactivated successfully'
        ]);
    }

    // restore emplopyee
    public function activateClient(Request $request)
    {
        $client     =   (new Client())->getClientDetailsUnderClientIdWithTrashedItems($request->id); 
        if($client==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'End user does not exist'
            ]);
        }

        $client->user->restore();
        $client->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'End user activated successfully'
        ]);
    }

//////////////////////////////User Profile////////////////////////

    //user profile view
    public function userProfile()
    {
        $client_id      =   \Auth::user()->client->id;
        $client_user_id =   \Auth::user()->id;
        $client         =   (new Client())->getClientDetailsUnderClientIdWithTrashedItems($client_id);
        $user           =   User::find($client_user_id);
        if($client == null)
        {
           return view('Client::404');
        }
        return view('Client::client-profile',['client' => $client,'user' => $user]);
    }

    // update user logo
    public function saveUserLogo(Request $request)
    {
        // dd(1);
        $client     =   (new Client())->getClientDetailsWithClientId($request->id);
        if($client == null){
           return view('Client::404');
        }
        // dd($request->file('logo'));
        $rules = $this->logoUpdateRules();
        $this->validate($request, $rules);
        $file=$request->file('logo');
      
        if($file){
            $old_file = $client->logo;
            if($old_file){
                if(file_exists("logo/".$old_file)){
                    $myFile = "logo/".$old_file;
                    $delete_file=unlink($myFile);
                }
            }

            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;
            $destinationPath =  public_path('/logo');
            $img = Image::make($file->getRealPath());
            $img->resize(150, 40, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$uploadedFile);
            // $file->move($destinationPath,$uploadedFile);
            $client->logo = $uploadedFile;
            $current_date=date('Y-m-d H:i:s');
            $client->latest_user_updates = $current_date;
            $client->save();
        }
        $request->session()->flash('message', 'Logo updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client.profile'));
    }

    public function userProfileEdit()
    {
        $client_id      =   \Auth::user()->client->id;
        $client_user_id =   \Auth::user()->id;
        $client         =   (new Client())->getClientDetailsUnderClientIdWithTrashedItems($client_id); 
        $user           =   User::find($client_user_id);

        // $client=\Auth::user()->client;
        $lat=(float)$client->latitude;
        $lng=(float)$client->longitude;
        // return view('Geofence::school-fence-create',['lat' => $lat,'lng' => $lng]);
        if($client == null)
        {
           return view('Client::404');
        }

        return view('Client::client-profile-edit',['client' => $client,'user' => $user,'lat' => $lat,'lng' => $lng]);
    }

     //update dealers details
    public function profileUpdate(Request $request)
    {
        $client     =   (new Client())->checkUserIdIsInClientTable($request->id);
        if($client == null){
           return view('Client::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->rayfleetClientProfileUpdateRules($client);
        }
        else if (strpos($url, $eclipse_key) == true) {
            $rules = $this->clientProfileUpdateRules($client);
        }
        else
        {
           $rules = $this->clientProfileUpdateRules($client);
        }
         $current_date=date('Y-m-d H:i:s');
        $this->validate($request, $rules);
        $client->name = $request->name;
        $client->address = $request->address;
        $client->latest_user_updates = $current_date;
        $client->save();
        $user = User::find($request->id);
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $did = encrypt($user->id);
        // $subdealer->phone_number = $request->phone_number;
        // $did = encrypt($subdealer->id);
        $request->session()->flash('message', 'End user details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client.profile'));
    }

///////////////////////////User Change Password////////////////////

    //user change password view
    public function userPasswordChange()
    {
        $client_id      =   \Auth::user()->client->id;
        $client_user_id =   \Auth::user()->id;
        $client         =   (new Client())->getClientDetailsUnderClientIdWithTrashedItems($client_id);
        $user           =   User::find($client_user_id);
        if($client == null)
        {
           return view('Client::404');
        }
        return view('Client::client-change-password',['client' => $client,'user' => $user]);
    }

    // update change password
    public function saveUserNewPassword(Request $request)
    {
        $client     =   (new Client())->getClientDetailsWithClientId($request->id);
        if($client == null){
           return view('Client::404');
        }
        $rules = $this->logoUpdateRules();
        $this->validate($request, $rules);

        $file=$request->file('logo');
        if($file){
            $old_file = $client->logo;
            if(file_exists("logo/".$old_file)){
                $myFile = "logo/".$old_file;
                $delete_file=unlink($myFile);
            }
            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;
            //Move Uploaded File
            $destinationPath = 'logo';
            $file->move($destinationPath,$uploadedFile);
            $client->logo = $uploadedFile;
            $client->save();
        }
        $request->session()->flash('message', 'Logo updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client.profile'));
    }

    public function clientLocation(Request $request)
    {
        $client = $request->user()->client;
        return response()->json([
            'latitude' => (float)$client->latitude,
            'longitude' => (float)$client->longitude
        ]);
    }
/////////////////////////////Root Client Create/////////////////////////////
    public function clientCreate()
    {
        $user           = \Auth::user();
        $root           = $user->root;
        $entities       = $root->dealers;
        $countries      = Country::select([
                            'id',
                            'name'
                        ])
                        ->where('id',101)
                        ->get();
        $url            = url()->current();
        $rayfleet_key = "rayfleet";
        $eclipse_key  = "eclipse";

        if (strpos($url, $rayfleet_key) == true) 
        {  
        $default_country_id="178";
        }else if (strpos($url, $eclipse_key) == true) 
        {
        $default_country_id="101";
        }else
        {
        $default_country_id="101";
        }
        //for logged in user
        $logged_user_id = \Auth::user()->id;
        return view('Client::root-client-create',[
            'entities'              => $entities,
            'countries'             => $countries,
            'default_country_id'    => $default_country_id,
            'logged_user_id'        => $logged_user_id
        ]);
    }


    public function selectSubdealer(Request $request)
    {
        $user = \Auth::user();
        $dealer_id=$request->dealer;
        $sub_dealers=SubDealer::select([
            'id',
           'user_id',
           'dealer_id',
           'name'
        ])
        ->where('dealer_id', $dealer_id)
        ->get();
        if($user->hasRole('root')){
            return response()->json([
                'sub_dealers' => $sub_dealers
                // 'status' => 'root_subdealer'
            ]);
        }
    }

public function selectTrader(Request $request)
    {

        $sub_dealer_id=$request->dealer_id;
        $traders=Trader::select([
            'id',
           'user_id',
           'sub_dealer_id',
           'name'
        ])
        ->where('sub_dealer_id', $sub_dealer_id)
        ->get();

         if($traders== null){
            return response()->json([
                 'traders' => '',
                'message' => 'dealer doesnot have any sub dealers'
            ]);
        }else
        {
        // if($user->hasRole('root')){
            return response()->json([
                'traders' => $traders,

            ]);
        // }
        }
    }

    //upload employee details to database table
    public function clientSave(Request $request)
    {
        if($request->user()->hasRole('root'))
        {
            $url            = url()->current();
            $rayfleet_key   = "rayfleet";
            $eclipse_key    = "eclipse";
            if (strpos($url, $rayfleet_key) == true) 
            {
                 $rules     = $this->rayfleetRootUserCreate_rules();
            }
            else if (strpos($url, $eclipse_key) == true) 
            {
                $rules      = $this->root_user_create_rules();
            }
            else
            {
               $rules       = $this->root_user_create_rules();
            }
            $this->validate($request, $rules);
            $subdealer_id   = $request->sub_dealer;
            $trader_id      = $request->trader;
            $placeLatLng    = (new City())->getCityGeoCodes($request->city_id);
            $location_lat   = $placeLatLng['latitude'];
            $location_lng   = $placeLatLng['longitude'];
            $current_date   = date('Y-m-d H:i:s');
            $user = User::create([
                'username'      => $request->username,
                'email'         => $request->email,
                'mobile'        => $request->mobile_number,
                'status'        => 1,
                'password'      => bcrypt($request->password),
                'role'          => 0,
            ]);

            if($trader_id == null)
            {
                $client     =   (new Client())->createNewClientFromDealer($user->id, $subdealer_id, strtoupper($request->name), $request->address, $location_lat, $location_lng, $request->country_id, $request->state_id, $request->city_id, $current_date);

            }else
            {
                $client     =   (new Client())->createNewClientFromSubDealer($user->id, $trader_id, strtoupper($request->name), $request->address, $location_lat, $location_lng, $request->country_id, $request->state_id, $request->city_id, $current_date);
            }

            if($request->client_category=="school")
            {
                User::where('username', $request->username)->first()->assignRole('school');
            }else
            {
                User::where('username', $request->username)->first()->assignRole('client');
            }
            // create alert amanager and client alert type
            $alert_types    = AlertType::select('id','driver_point')->get();
            if($client)
            {
                foreach ($alert_types as $alert_type) 
                {
                    $user_alerts = UserAlerts::create([
                      "alert_id"        => $alert_type->id,
                      "client_id"       => $client->id,
                      "status"          => 1
                    ]);
                    $client_alert_point = ClientAlertPoint::create([
                      "alert_type_id"   => $alert_type->id,
                      "driver_point"    => $alert_type->driver_point,
                      "client_id"       => $client->id
                    ]);
                }
            }
            // create alert amanager and client alert type

            if($user->email != null)
            {
                Mail::to($user)->send(new UserCreated($user, $request->name, $request->password));
            }
            else
            {
                $user = \Auth::user();
                Mail::to($user)->send(new UserCreatedWithoutEmail($user, $request->name, $request->password,$request->username));
            }
           
        }
        $eid                            = encrypt($user->id);
        $request->session()->flash('message', 'New End user created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client'));
    }
 public function getOldPasswordMessage(Request $request)
    {
        $user_id = $request->user_id;
        $password=$request->user_typed_older_password;
        $user = User::where('id', $user_id)->first();

             if (Hash::check($password, $user->password))
              {
                return response()->json([
                'status' => 1,
                'title' => 'Success',
                'message' => 'Password is Correct'
            ]);
            }else
            {
               return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Incorrect Password'
            ]);
            }
    }
     /**
     * 
     * save report request generation
     * 
     */
    public function saveReportRequest(Request $request)
    {
        $rules = $this->report_request_create_rules();
        $this->validate($request, $rules);
        $client_id        = \Auth::user()->client->id;
        $vehicle_id       =  $request->vehicle_id;
        $trip_report_date = $request->trip_report_date;
        $vehicle = Vehicle::select([
            'id',
            'gps_id'
        ])
        ->where('id',$vehicle_id )
        ->first();
        $gps_id             =  $vehicle->gps_id;
        $add_report_request  =  (new OnDemandTripReportRequests())->createNewTripRequest($client_id,$vehicle_id,$gps_id,$trip_report_date); 
        $request->session()->flash('message', 'New Request created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('ondemandreportlist'));
    }
    /**
     * 
     * list of demand reports
     * 
     */
    public function OnDemandReportList(Request $request)
    {
        $client_id                      =   \Auth::user()->client->id;
        $devices                        =    Vehicle::select('id','client_id','gps_id','register_number','is_returned')
                                            ->where('client_id',$client_id)
                                            ->get();    
    	$vehicles                       =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
       return view('Client::client-ondemand-report-list',['vehicles'=>$vehicles,'devices'=>$devices]);
    }
    /**
     * 
     * get on demand report details
     * 
     */
    public function getOnDemandReportDetails(Request $request)
    {
        
       
        $from       = $request->data['from_date'];
        $to         = $request->data['to_date'];
        $vehicle_id = $request->data['vehicle'];
        $client_id  = \Auth::user()->client->id;
        $tripreportdetails = OnDemandTripReportRequests::select(
                            'id', 
                            'vehicle_id',
                            'gps_id',                      
                            'trip_report_date',
                            'job_submitted_on', 
                            'job_attended_on' ,
                            'job_completed_on', 
                            'client_id',
                            'report_type',
                            'is_job_failed',
                            'download_link'          
                            )
                        ->with('vehicle:id,register_number')
                        ->orderBy('id','desc')
                        ->where('client_id',$client_id);
                        
                        if($from)
                        {
                           if($vehicle_id == 0)
                            {

                             $search_from_date  =   date("Y-m-d", strtotime($from));
                             $search_to_date    =   date("Y-m-d", strtotime($to));
                             $tripreportdetails =   $tripreportdetails->whereDate('trip_report_date', '>=', $search_from_date)
                            ->whereDate('trip_report_date', '<=', $search_to_date);
                            }
                            else
                            {
                             $search_from_date  =   date("Y-m-d", strtotime($from));
                             $search_to_date    =   date("Y-m-d", strtotime($to));
                             $tripreportdetails =   $tripreportdetails->whereDate('trip_report_date', '>=', $search_from_date)
                            ->whereDate('trip_report_date', '<=', $search_to_date)
                            ->where('vehicle_id',$vehicle_id); 
                            }
                        }
                        $tripreportdetails=$tripreportdetails->get(); 
      
            return DataTables::of($tripreportdetails)
            ->addIndexColumn()
            ->addColumn('status', function ($tripreportdetails) { 
            
                    if(!empty($tripreportdetails->job_submitted_on)&& empty($tripreportdetails->job_attended_on) && empty($tripreportdetails->job_completed_on)) {
                        return "Pending";
                    }
                    else if(!empty($tripreportdetails->job_submitted_on) && !empty($tripreportdetails->job_attended_on) && empty($tripreportdetails->job_completed_on)){
                            return "In Progress";
                    }
                    else if(!empty($tripreportdetails->job_submitted_on) && !empty($tripreportdetails->job_attended_on)&& !empty($tripreportdetails->job_completed_on) &&($tripreportdetails->is_job_failed == 0)){
                            return "Completed";
                    }   
                    else if(!empty($tripreportdetails->job_submitted_on) && !empty($tripreportdetails->job_attended_on)&& !empty($tripreportdetails->job_completed_on) &&($tripreportdetails->is_job_failed == 1)){
                        return "Failed";
                }                 
            })
           ->addColumn('action', function ($tripreportdetails) {
               $b_url = \URL::to('/');
               if(!empty($tripreportdetails->job_submitted_on)&& empty($tripreportdetails->job_attended_on) && empty($tripreportdetails->job_completed_on)) {
                return "
                  
                    <button class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-ok'></i> Generate</button>
                ";
                }else if(!empty($tripreportdetails->job_submitted_on) && !empty($tripreportdetails->job_attended_on) && empty($tripreportdetails->job_completed_on)){
                return "
                    
                    <button  class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Download </button>
                ";
                }else if(!empty($tripreportdetails->job_completed_on) &&($tripreportdetails->is_job_failed ==0)){
                     if($tripreportdetails->download_link)
                     {
                         
                     return "<a href= ".$tripreportdetails->download_link." download='".$tripreportdetails->download_link."' class='btn btn-xs btn-success'  data-toggle='tooltip'><i class='fa fa-download'></i> Download </a>
                     ";
                     }
                     else{
                         return "
                    
                        <button  class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> No Trip </button>
                         "; 
                     }
               } else if(!empty($tripreportdetails->job_completed_on) &&($tripreportdetails->is_job_failed ==1)){
                return "
                    
                <button  class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i>Failed</button>
                 "; 
               }
           })
        ->rawColumns(['link', 'action'])
        ->make();
    }



/////////////////////////Update client role-start//////////

    public static function updateClientRole($new_role)
    {

        $user = \Auth::user();
        $roles =  $user->roles->where('name','!=','client');
        foreach ($roles as $role) {
            $user->removeRole($role->name);
        }
        $user->assignRole($new_role);
        return true;
    }

////////////////////////////////////Update client role-end//////////////////////////

///////////////////////////////////////////////////////////////////////////////////////

    public function passwordUpdateRules()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }

    // logo update rules
    public function logoUpdateRules()
    {
        $rules = [
            'logo' => 'mimes:png|required|max:2000'


        ];
        return  $rules;
    }
    #####################################
    public function kmCalculation(){
     $data='<?xml version="1.0"?>
        <gpx version="1.0"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns="http://www.topografix.com/GPX/1/0"
        xsi:schemaLocation="http://www.topografix.com/GPX/1/0 http://www.topografix.com/GPX/1/0/gpx.xsd">
          <trk>
            <trkseg>
              <trkpt lat="51.10177" lon="0.39349"/>
              <trkpt lat="51.10181" lon="0.39335"/>
              <trkpt lat="51.10255" lon="0.39366"/>
              <trkpt lat="51.10398" lon="0.39466"/>
              <trkpt lat="51.10501" lon="0.39533"/>
            </trkseg>
          </trk>
        </gpx>';
     $encoded_data=base64_encode($data);
     $send_request=$this->getKmRequest($encoded_data);
     echo $send_request;

    }
    ######################################
    function getKmRequest($encoded_data){
      $app_id="pTDh57IDvFztTZUGw15X";
      $app_code="673-fZdOmD_oJnCMZ_ko-g";
      $routemode="car";
      $file=$encoded_data;

        $post = array(
               'app_id' => $app_id,
               'app_code'=> $app_code,
               'routemode' =>$routemode,
               'file'=>$file
              );
            $data_string = json_encode($post);
            $ch = curl_init('https://rme.api.here.com/2/matchroute.json');                              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );
        $result = curl_exec($ch);
        echo $result;


    }
   ########################################
    public function user_create_rules()
    {
        $rules = [
            'name' => 'required',
            // 'search_place'=>'required',
            // 'address' => 'required|string|max:150',
            'client_category' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'username' => 'required|unique:users',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
        ];
        return  $rules;
    }

     public function rayfleet_user_create_rules()
        {
            $rules = [
                'name' => 'required',
                // 'search_place'=>'required',
                // 'address' => 'required|string|max:150',
                'client_category' => 'required',
                'country_id' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'username' => 'required|unique:users',
                'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile',
                'email' => 'nullable|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            ];
            return  $rules;
        }


    ###############################################################################

    // root create client validation
    public function root_user_create_rules()
    {
        $rules = [
             'trader' => 'nullable',
            'sub_dealer' => 'required',
            'name' => 'required',
            // 'address' => 'required|string|max:150',
            'client_category' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            // 'search_place'=>'required',
            'username' => 'required|unique:users',
            'mobile_number' => 'required|digits:10|unique:users,mobile',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
        ];
        return  $rules;
    }
    public function rayfleetRootUserCreate_rules()
    {
        $rules = [
            'trader' => 'nullable',
            'sub_dealer' => 'required',
            'name' => 'required',
            // 'address' => 'required',
            'client_category' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            // 'search_place'=>'required',
            'username' => 'required|unique:users',
            'mobile_number' => 'required|digits:11|unique:users,mobile',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
        ];
        return  $rules;
    }

    //validation for client updation
    public function clientUpdateRules($client)
    {
        $rules = [
            'name' => 'required',
            // 'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'email' => 'nullable|string|email|max:255|unique:users,email,'.$client->user_id,
            'mobile_number' => 'required|digits:10|unique:users,mobile,'.$client->user_id,
              ];
        return  $rules;
    }

    public function rayfleetClientUpdateRules($client)
    {
        $rules = [
            'name' => 'required',
            // 'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'email' => 'nullable|string|email|max:255|unique:users,email,'.$client->user_id,
            'mobile_number' => 'required|digits:11|unique:users,mobile,'.$client->user_id
              ];
        return  $rules;
    }


    public function clientProfileUpdateRules($client)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$client->user_id,
            'email' => 'nullable|string|unique:users,email,'.$client->user_id


        ];
        return  $rules;
    }
    public function report_request_create_rules()
    {
        $rules = [
            'vehicle_id' => 'required',
            'trip_report_date' => 'required',

        ];
         return  $rules;
    }
    public function rayfleetClientProfileUpdateRules($client)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$client->user_id,
            'email' => 'nullable|string|unique:users,email,'.$client->user_id


        ];
        return  $rules;
    }

  #####################################################
}
