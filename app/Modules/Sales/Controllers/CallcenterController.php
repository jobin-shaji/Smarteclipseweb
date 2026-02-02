<?php
namespace App\Modules\Sales\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Sales\Models\Callcenter;
use App\Modules\User\Models\User;
use App\Modules\Gps\Models\Gps;
use App\Modules\Sales\Models\SalesAssignGps;
use App\Modules\Sales\Models\GpsFollowup;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\Department;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class CallcenterController extends Controller {


    public function create()
    {
       return view('Sales::callcenter-create');
    }
    //upload dealer details to database table
    public function saveEmployee(Request $request)
    {
        $rules = $this->user_create_rules();
        $this->validate($request, $rules);
       
        
        
        $role=Role::where('id', $dept->role_id)->first();
        User::where('username', $request->username)->first()->assignRole($role->name);
        $id= encrypt($employee->id);
        $request->session()->flash('message', 'New employee created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('employee.details',$id));        
    }
    public function save(Request $request)
    {
        $dept=Department::find('151');
        $salesman_id = \Auth::user()->salesman->id;
        if($request->user()->hasRole('sales')){
            $url=url()->current();
            $rayfleet_key="rayfleet";
            $eclipse_key="eclipse";

            if (strpos($url, $rayfleet_key) == true) {
                 $rules = $this->rayfleet_finance_create_rules();
            }
            else if (strpos($url, $eclipse_key) == true) {
                 $rules = $this->callcenter_user_create_rules();
            }
            else
            {
               $rules = $this->callcenter_user_create_rules();
            }
            $this->validate($request, $rules);
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile_number,
                'status' => 1,
                'role_id'=>$dept->role_id,
                'password' => bcrypt($request->password),
            ]);
            $callcenters = Callcenter::create([
                'user_id' => $user->id,
                'sales_id'=>$salesman_id,
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
            ]);
            $employee = Employee::create([   
                'user_id' => $user->id,  
                'username' => $request->username,       
                'name' => $request->name,
                'code' => $request->code,
                'mobile' => $request->mobile_number,
                'email' => $request->email,
                'designation_id' => '145',
                'department_id' =>$dept->id,
                'password' => bcrypt($request->password)
            ]);
            User::where('username', $request->username)->first()->assignRole('Call_Center');
        }
        $eid= encrypt($user->id);
        $request->session()->flash('message', 'New Finance person created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('callcenter'));
    }
    public function callcenterListPage()
    {
        return view('Sales::callcenter-list');
    }
    public function getcallcenter()
    {
        $finances = Callcenter::select(
            'id',
            'user_id',
            'name',
            'address',
            'deleted_at',
            'code'
        )
        ->withTrashed()
        ->with('user:id,email,mobile,deleted_at')
        ->orderBy('created_at','DESC')
        ->get();
        return DataTables::of($finances)
        ->addIndexColumn()
        ->addColumn('action', function ($finances) {
             $b_url = \URL::to('/');
            if($finances->user->deleted_at == null){
            return "
            <a href=".$b_url."/callcenter/".Crypt::encrypt($finances->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <a href=".$b_url."/callcenter/".Crypt::encrypt($finances->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=".$b_url."/callcenter/".Crypt::encrypt($finances->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
            <button onclick='deleteCallcenter(\"".$finances->user_id."\")' class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-trash'></i> Delete </button>

            ";
            }else{
            return "";
            }
        })
        ->rawColumns(['link', 'action','working_status'])
        ->make();
    }
    //sales creation page
    //sales details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $callcenters = Callcenter::where('user_id', $decrypted)->first();
        $user=User::find($decrypted);

        if($callcenters == null){
            return view('Sales::404');
        }
        return view('Sales::callcenter-details',['callcenters' => $callcenters,'user' => $user]);
    }
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $callcenters = Callcenter::where('user_id', $decrypted)->first();
       
        $user=User::find($decrypted);
        if($callcenters == null){
            return view('Sales::404');
        }
        return view('Sales::callcenter-edit',['callcenters' => $callcenters,'user' => $user]);
    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $callcenters = Callcenter::where('user_id', $request->id)->first();

        if($callcenters == null){
           return view('Sales::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->financeUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->financeUpdatesRules($user);
        }
        else
        {
           $rules = $this->financeUpdatesRules($user);
        }
        $this->validate($request, $rules);
        $callcenters->name = $request->name;
        $callcenters->address = $request->address;
        $callcenters->code= $request->code;
        $callcenters->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $did = encrypt($user->id);
        $request->session()->flash('message', 'finance details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('callcenter.edit',$did));
    }
    //for edit page of employee password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $callcenters = Callcenter::where('user_id', $decrypted)->first();
        if($callcenters == null){
           return view('Sales::404');
        }
        return view('Sales::callcenters-change-password',['callcenters' => $callcenters]);
    }
    //update password
    public function updatePassword(Request $request)
    {
        $user=User::find($request->id);
        if($user== null){
            return view('Sales::404');
        }
        $did=encrypt($user->id);
        $rules=$this->updatePasswordRule();
        $this->validate($request,$rules);
        $user->password=bcrypt($request->password);
        $user->save();
        $request->session()->flash('message','Password updated successfully');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('callcenters.change-password',$did));
    }

    //delete dealer details from table
    public function disableFinance(Request $request)
    {
        $sales_user = User::find($request->id);
        $sales = Callcenter::select('id')->where('user_id',$sales_user->id)->first();
        if($sales_user == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'finance does not exist'
            ]);
        }
        $sales_user->delete();
        $sales->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'finance disabled successfully'
        ]);
    }
    // restore emplopyee
    public function enableFinance(Request $request)
    {
        $sales_user = User::withTrashed()->find($request->id);
        $sales = Callcenter::withTrashed()->select('id')->where('user_id',$sales_user->id)->first();
        if($sales_user==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Finance does not exist'
            ]);
        }
        $sales_user->restore();
        $sales->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Finance enabled successfully'
        ]);
    }
    
    // delete call center user permanently
    public function deleteCallcenter(Request $request)
    {
        $callcenter_user = User::withTrashed()->find($request->id);
        $callcenter = Callcenter::withTrashed()->where('user_id', $callcenter_user->id)->first();
        
        if($callcenter_user == null || $callcenter == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Call center user does not exist'
            ]);
        }
        
        // Force delete (permanent deletion)
        $callcenter->forceDelete();
        $callcenter_user->forceDelete();
        
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Call center user deleted successfully'
        ]);
    }
    
    public function financeProfile()
    {
        $finance_id = \Auth::user()->finance->id;
        $finance_user_id = \Auth::user()->id;
        $finance = Callcenter::withTrashed()->where('id', $finance_id)->first();
        $user=User::find($finance_user_id);
        if($finance == null)
        {
           return view('Sales::404');
        }
        return view('Sales::finance-profile',['finance' => $finance,'user' => $user]);
    }

    public function changeProfilePassword(Request $request)
    {
         $decrypted = Crypt::decrypt($request->id);
          $trader = Trader::where('user_id', $decrypted)->first();

        if($trader == null){
           return view('Trader::404');
        }
        return view('Trader::trader-profile-change-password',['trader' => $trader]);
    }

    //for edit page of finance profile
    public function editFinanceProfile()
    {
        $finance_id=\Auth::user()->finance->id;
        $finance = Callcenter::where('id', $Finance_id)->first();
        if($finance == null){
            return view('Sales::404');
        }
        return view('Sales::finance-profile-edit',['finance' => $finance]);
    }
    //update  profile details
    public function updateFinanceProfile(Request $request)
    {
        $finance = Callcenter::find($request->id);
        $user = User::where('id', $finance->user_id)->first();
        if($finance == null){
           return view('Sales::404');
        }
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->financeProfileUpdatesRulesRayfleet($user);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->financeProfileUpdatesRules($user);
        }
        else
        {
           $rules = $this->financeProfileUpdatesRules($user);
        }
        $this->validate($request, $rules);
        $finance->name = $request->name;
        $finance->address = $request->address;
        $finance->save();
        $user->mobile = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        $request->session()->flash('message', 'Your details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('finance.profile'));
    }
  


////////////////////////Sales Profile-end////////////////

     public function updatePasswordRule()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }
 
    //validation for employee updation
    public function financeUpdatesRules($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
        ];
        return  $rules;
    }
    public function financeUpdatesRulesRayfleet($user)
    {
        $rules = [
            'name' => 'required',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
        ];
        return  $rules;
    }

    public function financeProfileUpdatesRules($user){
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|string|min:10|max:10|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }

    public function financeProfileUpdatesRulesRayfleet($user){
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile_number' => 'required|string|min:11|max:11|unique:users,mobile,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ];
        return  $rules;

    }
    public function passwordUpdateRules()
    {
        $rules=[
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/'
        ];
        return $rules;
    }
    //user create rules
    public function callcenter_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile_number' => 'required|string|unique:users,mobile|min:10|max:10',
        ];
        return  $rules;
    }

    public function callcenter_user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile_number' => 'required|string|unique:users,mobile|min:10|max:10'
        ];
        return  $rules;
    }



    public function getAssignedGps(Request $request)
    {

         $type=$request->type??"";
      // DB::table('gps_history')->truncate();
//die;
        return view('Sales::callcenter-assigned-list',['type'=>$type]);
    }
    public function getAssignedGpsList(Request $request)
    {
        $callcenter=[];
         if(\Auth::user()->hasRole(['Call_Center'])){
             $call_id = \Auth::user()->callcenter->id;
            $type=$request->type??"";
            if($type)
            {
               $today = Carbon::today()->toDateString();

            // Subquery to get latest GpsFollowup per GPS where next_follow_date = today
           /* $latestFollowups = DB::table('gps_followup as gf1')
                ->select('gf1.*')
                ->join(DB::raw('(
                    SELECT MAX(id) as id
                    FROM gps_followup
                    WHERE next_follow_date = "'.$today.'" and user_id="'.\Auth::user()->id.'"
                    GROUP BY gps_id
                ) as gf2'), 'gf1.id', '=', 'gf2.id');

            $callcenter= SalesAssignGps::select(
                    'sales_imei_assign.id',
                    'sales_imei_assign.gps_id',
                    'gf.*' // fields from the gps_followup table
                )
                ->withTrashed()
                ->with([
                    'callcenter:id,name',
                    'gps:id,serial_no,imei,imsi,icc_id,icc_id1,e_sim_number1,validity,provider1,provider2,e_sim_number,pay_status,validity_date,installation_date_new'
                ])
                ->leftJoinSub($latestFollowups, 'gf', function($join) {
                    $join->on('sales_imei_assign.gps_id', '=', 'gf.gps_id');
                })
                ->where('sales_imei_assign.callcenter_id', $call_id)
                ->orderBy('sales_imei_assign.created_at', 'DESC')
                ->get();*/



                 $callcenter = SalesAssignGps::select(
                'id',
                'gps_id',
                'callcenter_id'
            )
            ->withTrashed()
            ->with('callcenter')
            ->with('gps:id,serial_no,imei,imsi,icc_id,icc_id1,e_sim_number1,validity,provider1,provider2,e_sim_number,pay_status,validity_date,installation_date_new')
            ->orderBy('created_at','DESC')
            ->where('callcenter_id',$call_id)
            ->get();

               

            }else{
               
                 $callcenter = SalesAssignGps::select(
                'id',
                'gps_id',
                'callcenter_id'
            )
            ->withTrashed()
            ->with('callcenter')
            ->with('gps:id,serial_no,imei,imsi,icc_id,icc_id1,e_sim_number1,validity,provider1,provider2,e_sim_number,pay_status,validity_date,installation_date_new')
            ->orderBy('created_at','DESC')
            ->where('callcenter_id',$call_id)
            ->get();

            }
           
         }else{
              $salesman_id = \Auth::user()->salesman->id;
               $callcenter = SalesAssignGps::select(
                'id',
                'gps_id',
                'callcenter_id'
            )
            ->withTrashed()
            ->with('callcenter')
            ->with('gps:id,serial_no,imei,imsi,icc_id,icc_id1,e_sim_number1,validity,provider1,provider2,e_sim_number,pay_status,validity_date,installation_date_new')
             ->where('assigned_by',$salesman_id)
            ->orderBy('created_at','DESC')
             ->get();

         }
        return DataTables::of($callcenter)
        ->addIndexColumn()

        ->addColumn('vehicle', function ($callcenter) {
             if(optional($callcenter->gps)->vehicle){
            return ($callcenter->gps)->vehicle->name;
               
            }else{
           return "No Vehicle added";
            }
        })
         ->addColumn('callcenter', function ($callcenter) {
          // $cals= Callcenter::find($callcenter->callcenter_id);
            $cc = Callcenter::withTrashed()->find($callcenter->callcenter_id);
            return $cc ? $cc->name : 'Deleted User';
        })

        ->addColumn('action', function ($callcenter) {
             $b_url = \URL::to('/');
            if(optional($callcenter->gps)->pay_status !=1){
                $a="";
               
                 if(\Auth::user()->hasRole('Call_Center')){
                     $a.="<a href=".$b_url."/vehicles/".Crypt::encrypt($callcenter->id)."/sendSms class='btn btn-xs btn-warning' data-toggle='tooltip' title='View'>send sms </a>";
                        $a.="<a href=".$b_url."/complaint/create class='btn btn-xs btn-warning' data-toggle='tooltip' title='Register A Complaint'>Register A Complaint </a>";
                   
                    
                     if(optional($callcenter->gps)->pay_status && optional($callcenter->gps)->warrenty_certificate){
                         $a.="<a href=".$b_url."/uploads/".$callcenter->gps->warrenty_certificate." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Certificate' download>Download Certificate </a>";
               
                      }
                      else if(optional($callcenter->gps)->pay_status){
                        $a.="<a href='#' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Certificate' download> Certificate Not Uploaded </a>";
              
                     } 
                      else{
                        $a.="<a href=".$b_url." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Call'>Call </a>";
                        $a.="<a href=".$b_url." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Whatsapp'>Whatsapp</a>";
               
                        $a.="<a href=".$b_url.'/gps-followup/'.optional($callcenter->gps)->id." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Certificate'>Follow Up</a>";
               
                         $a.= "<form  method='POST' action='/esim-post-renewal'>".csrf_field()."
                             <input type='hidden'  name='id' value='".$callcenter->gps_id."'>
                             <button type='submit' class='btn btn-primary address_btn'>Renew </button>
                         </form>"; 
                      }
                    
                 }
                 return $a;
            }else{
            
            
             $a="";
           
             if(\Auth::user()->hasRole('Call_Center')){
                 $a.="<a href=".$b_url."/vehicles/".Crypt::encrypt($callcenter->id)."/sendSms class='btn btn-xs btn-warning' data-toggle='tooltip' title='View'>send sms </a>";
                    $a.="<a href=".$b_url."/complaint/create class='btn btn-xs btn-warning' data-toggle='tooltip' title='Register A Complaint'>Register A Complaint </a>";
               
                
                 if(optional($callcenter->gps)->pay_status && optional($callcenter->gps)->warrenty_certificate){
                     $a.="<a href=".$b_url."/uploads/".$callcenter->gps->warrenty_certificate." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Certificate' download>Download Certificate </a>";
           
                  }
                  else if(optional($callcenter->gps)->pay_status){
                    $a.="<a href='#' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Certificate' download> Certificate Not Uploaded </a>";
          
                 } 
                  else{
                    $a.="<a href=".$b_url." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Call'>Call </a>";
                    $a.="<a href=".$b_url." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Whatsapp'>Whatsapp</a>";
           
                    $a.="<a href=".$b_url.'/gps-followup/'.optional($callcenter->gps)->id." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Certificate'>Follow Up</a>";
           
                     $a.= "<form  method='POST' action='/esim-post-renewal'>".csrf_field()."
                         <input type='hidden'  name='id' value='".$callcenter->gps_id."'>
                         <button type='submit' class='btn btn-primary address_btn'>Renew </button>
                     </form>"; 
                  }
                
             }
             return $a;           
            }
        })
        ->rawColumns(['link', 'action','working_status'])
        ->make();
    }

    public function getfollowGps(request $request){


         $gps=Gps::where('id',$request->id)->first();
         $gpsfollow=GpsFollowup::where('gps_id', $request->id)->get();

         return view('Sales::esim-followup',['followup' => $gpsfollow,'gps'=>$gps,'gps_id'=>$request->id]);


    }

    public function saveFollowGps(request $request){

        $gps=new GpsFollowup();
        $gps->gps_id=$request->id;
        $gps->description=$request->description;
         $dateString = $request->next_follow_date; // '15-10-2025'
        $mysqlDate = Carbon::createFromFormat('d-m-Y', $dateString)->format('Y-m-d');
        $gps->next_follow_date=$mysqlDate;
        $gps->user_id=\Auth::user()->id;
        $gps->status=1;
        $gps->save();
        return redirect(route('assigned-gps'));
      }

    /**
     * Show follow-ups due today for call center user
     */
    public function getFollowupsDueToday()
    {
        $userId = \Auth::id();
        $today = Carbon::today()->toDateString();
        
        // Get latest follow-up per GPS where next_follow_date <= today (includes overdue)
        $followups = GpsFollowup::with(['gps:id,serial_no,imei,validity_date,pay_status,vehicle_no'])
            ->where('user_id', $userId)
            ->where('next_follow_date', '<=', $today)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('gps_id'); // Get only one per GPS (latest)
        
        return view('Sales::followups-due-today', ['followups' => $followups]);
    }

    public function getCallcenterReport()
    {

        $call_id = \Auth::user()->callcenter->id;
        $code = \Auth::user()->callcenter->code;
        $assigned=SalesAssignGps ::select('id')->where('callcenter_id',$call_id)->count();
        $gpstdy=SalesAssignGps ::select('id')->where('callcenter_id',$call_id)->whereDate('created_at', '=', date('Y-m-d'))->count();
        $total_renewal                  =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->count();
        $todays_renewal                 =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->where('pay_date',Date('Y-m-d'))->count();
        $total_collection               =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->sum('amount');
        $todays_collection              =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->where('pay_date',Date('Y-m-d'))->sum('amount');
        $total_month_revenew              =   Gps::select('id','pay_status')->where('pay_status',1)->where('employee_code',$code)->whereMonth('pay_date', Carbon::now()->month)
      ->whereYear('pay_date', Carbon::now()->year)->sum('amount');
       
       
       
        return view('Sales::callcenter-report',['assigned' => $assigned,'gpstdy'=>$gpstdy,'todays_renewal'=>$todays_renewal,
    'total_renewal'=>$total_renewal,'total_collection'=>$total_collection,'todays_collection'=>$todays_collection,'total_month_revenew'=>$total_month_revenew
]);

    }




 public function getRenewedGps()
    {
        return view('Sales::callcenter-renewed-list');
    }
    public function getRenewedGpsList()
    {
        $call_id = \Auth::user()->callcenter->id;
                $callcenter =$data = DB::table('gps_summery as g')
            ->join('sales_imei_assign as s', 'g.id', '=', 's.gps_id')
            ->where('g.pay_status', 1)
            ->where('callcenter_id',$call_id)
            ->orderBy('g.pay_date','DESC')
            ->select('g.*', 's.*')
            ->get();
        return DataTables::of($callcenter)
        ->addIndexColumn()

         ->addColumn('pay_status', function ($callcenter) {
            return "Renewed";
        })

          ->addColumn('mob_app', function ($callcenter) {
            
            if($callcenter->mob_app)
            {
                return "Mobile User";
                    }else{
                 return "Not a Mobile User ";
                    }
             
        })
        ->addColumn('action', function ($all_devices) {
            $b_url = \URL::to('/');$b="";
           
            
            if($all_devices->pay_status){
              
                if($all_devices->warrenty_certificate){

                   // $path = 'uploads/'.$all_devices->warrenty_certificate;

                   $b.= "<a href=".$b_url."/uploads/".$all_devices->warrenty_certificate." class='btn btn-success btn-sm' download>Download Certificate</a>";
                   $b.="<a href=".$b_url."/download-invoice/".$all_devices->id." class='btn btn-xs btn-warning' data-toggle='tooltip' title='Download Invoice'>Download Invoice </a>";
                  
                 
                   //$b.= "<a href='".$all_devices->warrenty_certificate."' class='btn btn-success btn-sm' download>Download Certificate</a>";
     
                }else{
                      $b.= "<a href='#' data-id='".$all_devices->gps_id."' data-toggle='modal' data-target='#stockModal' class='btn btn-success btn-sm'>Attach Certificate</a>";
                }
            }
            else{
                 return "";
            }
             return $b;
        })
        ->rawColumns(['link', 'action'])   
        ->make();
    }
}
