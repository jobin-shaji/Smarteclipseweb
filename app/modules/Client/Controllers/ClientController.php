<?php
namespace App\Modules\Client\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
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


class ClientController extends Controller {

    //employee creation page
    public function create()
    {
        $countries=Country::select([
            'id',
            'name'
        ])
        ->get();
        return view('Client::client-create',['countries'=>$countries]);
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
      
        $placeLatLng = (new City())->getCityGeoCodes($request->city_id);
        $location_lat=$placeLatLng['latitude'];
        $location_lng=$placeLatLng['longitude'];
        // $location=$request->search_place;
        $current_date=date('Y-m-d H:i:s');
        if($request->user()->hasRole('sub_dealer'))
        {
            $subdealer_id = \Auth::user()->subdealer->id;
            $url=url()->current();
            $rayfleet_key="rayfleet";
            $eclipse_key="eclipse";

            if (strpos($url, $rayfleet_key) == true) {
                 $rules = $this->rayfleet_user_create_rules();
            }
            else if (strpos($url, $eclipse_key) == true) {
                 $rules = $this->user_create_rules();
            }
            else
            {
               $rules = $this->user_create_rules();
            }

            $this->validate($request, $rules);
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile_number,
                'status' => 1,
                'password' => bcrypt($request->password),
                'role' => 0,
            ]);

            $client = Client::create([
                'user_id' => $user->id,
                'sub_dealer_id' => $subdealer_id,
                'name' => strtoupper($request->name),
                'address' => $request->address,
                'latitude'=>$location_lat,
                'longitude'=>$location_lng,
                'country_id'=>$request->country_id,
                'state_id'=>$request->state_id,
                'city_id'=>$request->city_id,
                'latest_user_updates'=>$current_date
            ]);
            // dd($user);
            if($request->client_category=="school"){
                User::select('id','username')->where('username', $request->username)->first()->assignRole('school');

            }else{
                User::select('id','username')->where('username', $request->username)->first()->assignRole('client');

            }
            $alert_types = AlertType::select('id','driver_point')->get();
            
            if($client){
                foreach ($alert_types as $alert_type) {
                    $user_alerts = UserAlerts::create([
                      "alert_id" => $alert_type->id,
                      "client_id" => $client->id,
                      "status" => 1
                    ]);
                    $client_alert_point = ClientAlertPoint::create([
                      "alert_type_id" => $alert_type->id,
                      "driver_point" => $alert_type->driver_point,
                      "client_id" => $client->id
                    ]);
                }
            }
        }else if($request->user()->hasRole('trader')){

            $trader_id = \Auth::user()->trader->id;

            $url=url()->current();
            $rayfleet_key="rayfleet";
            $eclipse_key="eclipse";

            if (strpos($url, $rayfleet_key) == true) {
                 $rules = $this->rayfleet_user_create_rules();
            }
            else if (strpos($url, $eclipse_key) == true) {
                 $rules = $this->user_create_rules();
            }
            else
            {
               $rules = $this->user_create_rules();
            }

            $this->validate($request, $rules);
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile_number,
                'status' => 1,
                'password' => bcrypt($request->password),
                'role' => 0,
            ]);
            $client = Client::create([
                'user_id' => $user->id,
                'trader_id' => $trader_id,
                'name' => strtoupper($request->name),
                'address' => $request->address,
                'latitude'=>$location_lat,
                'longitude'=>$location_lng,
                // 'location'=>$location,
                'country_id'=>$request->country_id,
                'state_id'=>$request->state_id,
                'city_id'=>$request->city_id ,
                'latest_user_updates'=>$current_date
            ]);
            if($request->client_category=="school"){
                User::select('id','username')->where('username', $request->username)->first()->assignRole('school');
            }else{
                User::select('id','username')->where('username', $request->username)->first()->assignRole('client');
            }
           
            $alert_types = AlertType::select(
                            'id',
                            'driver_point'
                            )
                            ->get();
                        
            if($client){
                foreach ($alert_types as $alert_type) {
                    $user_alerts = UserAlerts::create([
                      "alert_id" => $alert_type->id,
                      "client_id" => $client->id,
                      "status" => 1
                    ]);
                    $client_alert_point = ClientAlertPoint::create([
                      "alert_type_id" => $alert_type->id,
                      "driver_point" => $alert_type->driver_point,
                      "client_id" => $client->id
                    ]);
                }
            }
        }

        $eid= encrypt($user->id);
        // $request->session()->flash('message', 'New end user created successfully!');
        // $request->session()->flash('alert-class', 'alert-success');
        // // return redirect(route('clients'));
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
            $trader=$request->user()->trader->id;
            $client = Client::select(
            'id',
            'user_id',
            'sub_dealer_id',
            'name',
            'address',
            'created_at',
            'deleted_at'
            )
            ->withTrashed()
            ->with('user:id,email,mobile,deleted_at')
            ->where('trader_id',$trader)
            ->orderBy('created_at','DESC')
            ->get();
        }else{
            $subdealer=$request->user()->subdealer->id;
            $client = Client::select(
            'id',
            'user_id',
            'sub_dealer_id',
            'name',
            'address',
            'created_at',
            'deleted_at'
            )
            ->withTrashed()
            ->with('user:id,email,mobile,deleted_at')
            ->where('sub_dealer_id',$subdealer)
            ->orderBy('created_at','DESC')
            ->get();
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
        $client = Client::where('user_id', $request->id)->first();
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
        $user->mobile = $request->mobile_number;
        $user->save();

        $request->session()->flash('message', 'End user details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client.details',$did));
    }

    //for edit page of subdealer password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $client = Client::select('user_id')->where('user_id', $decrypted)->first();
        if($client == null){
           return view('Client::404');
        }
        return view('Client::client-change-password',['client' => $client,
        'decrypted'=>$decrypted]);
    }

    //update password
    public function updatePassword(Request $request)
    {

        $client=\Auth::user()->sub_dealer;
        $user=User::find($request->id);
        $client=Client::where('user_id',$user->id)->first();
        $current_date=date('Y-m-d H:i:s');
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
        $decrypted = Crypt::decrypt($request->id);
        $client = Client::select('user_id')->where('user_id', $decrypted)->first();
        if($client == null){
           return view('Client::404');
        }
        return view('Client::subdealer-client-change-password',['client' => $client]);
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
        $rules=$this->updateUserPasswordBySubdealer();
        $this->validate($request,$rules);
        $client->password=bcrypt($request->password);
        $client->save();
        $request->session()->flash('message','Password updated successfully');
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
    public function updateUserPasswordBySubdealer()
    {
        $rules=[
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
        $client = Client::select(
            'id',
            'user_id',
            'sub_dealer_id',
            'trader_id',
            'name',
            'address',
            'created_at',
            'deleted_at'
        )
        ->withTrashed()
        ->with('subdealer:id,user_id,name')
        ->with('trader')
        ->with('user:id,email,mobile,deleted_at')
        ->orderBy('created_at','DESC')
        ->get();
        return DataTables::of($client)
        ->addIndexColumn()
        ->addColumn('working_status', function ($client) {
            $b_url = \URL::to('/');
            if($client->user->deleted_at == null && $client->deleted_at == null){
            return "
                <b style='color:#008000';>Enabled</b>
                <button onclick=disableEndUser(".$client->user_id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Disable</button>
                <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/subscription class=' btn-xs btn-danger'> Subscription </a>

                <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <a href=".$b_url."/client/".Crypt::encrypt($client->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>

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
        $client_user = User::find($request->id);
        $client = Client::select('user_id')
                         ->where('user_id',$request->id)
                         ->first();

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
        $client_user = User::withTrashed()->find($request->id);
        $client = Client::select('user_id')
                             ->where('user_id',$request->id)
                             ->first();
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

        $client = Client::select(
            'id',
            'user_id',
            'sub_dealer_id',
            'trader_id',
            'name',
            'address',
            'deleted_at'
        )
        ->with('subdealer:id,user_id,name')
        ->with('trader')
        ->with('user:id,email,mobile')
        ->where(function ($query) use($single_traders, $single_sub_dealers) {
            $query->whereIn('trader_id', $single_traders)
            ->orWhereIn('sub_dealer_id', $single_sub_dealers);
        })
        ->get();
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
                $vehicle_geofence->forceDelete();
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
                $gps_details        =   (new Gps())->getGpsDetails($vehicle->gps_id);
                (new OtaResponse())->writeCommandToDevice($gps_details->imei,$response_string);
            }
        }

        // dd($gps_id);
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

        $current_date=date('Y-m-d H:i:s');
        $client = Client::select('user_id','latest_user_updates')->withTrashed()->where('user_id',$client_user_id)->first();
        $client->latest_user_updates = $current_date;
        $client->save();
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
                $gps_details        =   (new Gps())->getGpsDetails($vehicle->gps_id);
                (new OtaResponse())->writeCommandToDevice($gps_details->imei,$response_string);
            }
        }

        $user->role = 0;
        $user->save();
        $current_date=date('Y-m-d H:i:s');
        $client = Client::select('user_id','latest_user_updates')->withTrashed()->where('user_id',$decrypted_user_id)->first();
        $client->latest_user_updates = $current_date;
        $client->save();
        $user->removeRole($decrypted_role_id);
        $roles = $user->roles;
        $request->session()->flash('message', 'User Role deleted successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('client.subscription',$request->user_id));

    }

    //delete Sub Dealer details from table
    public function deleteClient(Request $request)
    {
        $client = Client::find($request->uid);
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
        $client = Client::withTrashed()->find($request->id);
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
        $client_id = \Auth::user()->client->id;
        $client_user_id = \Auth::user()->id;
        $client = Client::select('id','name','address','logo')->withTrashed()->where('id', $client_id)->first();
        $user=User::find($client_user_id);
        if($client == null)
        {
           return view('Client::404');
        }
        return view('Client::client-profile',['client' => $client,'user' => $user]);
    }

    // update user logo
    public function saveUserLogo(Request $request)
    {
        $client = Client::find($request->id);
        if($client == null){
           return view('Client::404');
        }
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
        $client_id = \Auth::user()->client->id;
        $client_user_id = \Auth::user()->id;
        $client = Client::select('id','latitude','longitude','name','address')->withTrashed()->where('id', $client_id)->first();
        $user=User::find($client_user_id);

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
        $client = Client::where('user_id', $request->id)->first();
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
        $client_id = \Auth::user()->client->id;
        $client_user_id = \Auth::user()->id;
        $client = Client::withTrashed()->where('id', $client_id)->first();
        $user=User::find($client_user_id);
        if($client == null)
        {
           return view('Client::404');
        }
        return view('Client::client-change-password',['client' => $client,'user' => $user]);
    }

    // update change password
    public function saveUserNewPassword(Request $request)
    {
        $client = Client::find($request->id);
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
        $user = \Auth::user();
        $root = $user->root;
        $entities = $root->dealers;
        $countries=Country::select([
            'id',
            'name'
        ])
        ->get();
        return view('Client::root-client-create',['entities' => $entities,'countries'=>$countries]);
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
            $url=url()->current();
            $rayfleet_key="rayfleet";
            $eclipse_key="eclipse";
            if (strpos($url, $rayfleet_key) == true) {
                 $rules = $this->rayfleetRootUserCreate_rules();
            }
            else if (strpos($url, $eclipse_key) == true) {
                $rules = $this->root_user_create_rules();
            }
            else
            {
               $rules = $this->root_user_create_rules();
            }
            $this->validate($request, $rules);
            $subdealer_id = $request->sub_dealer;
            $trader_id = $request->trader;
            $placeLatLng = (new City())->getCityGeoCodes($request->city_id);
            $location_lat=$placeLatLng['latitude'];
            $location_lng=$placeLatLng['longitude'];
            $current_date=date('Y-m-d H:i:s');

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile_number,
                'status' => 1,
                'password' => bcrypt($request->password),
            ]);
            $client_data=['user_id' => $user->id,
                        'name' => $request->name,
                        'address' => $request->address,
                        'latitude'=>$location_lat,
                        'longitude'=>$location_lng,
                        // 'location'=>$location,
                        'country_id'=>$request->country_id,
                        'state_id'=>$request->state_id,
                        'city_id'=>$request->city_id,
                        'latest_user_updates'=>$current_date];

                        if($trader_id == null)
                        {
                            $client_data['sub_dealer_id']=$subdealer_id;
                        }else
                        {
                            $client_data['trader_id']=$trader_id;
                        }
                        $client = Client::create($client_data);


            if($request->client_category=="school"){
                User::where('username', $request->username)->first()->assignRole('school');
            }else{
                User::where('username', $request->username)->first()->assignRole('client');
            }
            
            $alert_types = AlertType::select('id','driver_point')->get();
            if($client){
                foreach ($alert_types as $alert_type) {
                    $user_alerts = UserAlerts::create([
                      "alert_id" => $alert_type->id,
                      "client_id" => $client->id,
                      "status" => 1
                    ]);
                    $client_alert_point = ClientAlertPoint::create([
                      "alert_type_id" => $alert_type->id,
                      "driver_point" => $alert_type->driver_point,
                      "client_id" => $client->id
                    ]);
                }
            }
        }
        $eid= encrypt($user->id);
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
            'address' => 'required|string|max:150',
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
                'address' => 'required|string|max:150',
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
            'address' => 'required|string|max:150',
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
            'address' => 'required',
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
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            
            'mobile_number' => 'required|digits:10|unique:users,mobile,'.$client->user_id
              ];
        return  $rules;
    }

    public function rayfleetClientUpdateRules($client)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',

           
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
