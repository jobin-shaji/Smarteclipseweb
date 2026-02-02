<?php
namespace App\Modules\Complaint\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Complaint\Models\Complaint;
use App\Modules\Complaint\Models\ComplaintType;
use App\Modules\Complaint\Models\Comment;
use App\Modules\Ticket\Models\Ticket;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use App\Modules\Servicer\Models\FcmLog;
use App\Modules\Servicer\Models\ServicerNotification;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class ComplaintController extends Controller {

////////////////////////////COMPLAINT TYPE/////////////////////////////////////////////
    //Display complaints details 
    public function complaintTypeListPage()
    {
        return view('Complaint::complaint-type-list');
    }

    //returns complaints as json 
    public function getComplaintTypes()
    {
        $complaint_type = ComplaintType::select(
            'id', 
            'name',
            'complaint_category',
            'deleted_at'
        )
        ->withTrashed()
        ->get();
        return DataTables::of($complaint_type)
        ->addIndexColumn()
        ->addColumn('complaint_category', function ($complaint_type) {
            if($complaint_type->complaint_category==0){
                return "Hardware";
            }else{
                return "Software";
            }
        })
        ->addColumn('action', function ($complaint_type) {
            if($complaint_type->deleted_at == null){ 
                return "
                <button onclick=delComplaintType(".$complaint_type->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
            }else{                   
                return "
                <button onclick=activateComplaintType(".$complaint_type->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    //complaint creation page
    public function createComplaintType()
    {
        return view('Complaint::complaint-type-create');
    }

    //upload complaints to database table
    public function saveComplaintType(Request $request)
    {
        $custom_messages = [
        'name.required' => 'Please mention the reason'
        ];
        $rules = $this->complaint_type_create_rules();
        $this->validate($request, $rules, $custom_messages);
        $complaint_type = ComplaintType::create([
            'name' => $request->name,
            'complaint_category' => $request->complaint_category
        ]);
        
        $request->session()->flash('message', 'New Complaint type created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('complaint-type')); 
    }

    //delete complaint type from table
    public function deleteComplaintType(Request $request)
    {
        $complaint_type = ComplaintType::find($request->id);
        if($complaint_type == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Complaint Type does not exist'
            ]);
        }
        $complaint_type->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Complaint Type deleted successfully'
        ]);
    }

    // restore complaint type
    public function activateComplaintType(Request $request)
    {
        $complaint_type = ComplaintType::withTrashed()->find($request->id);
        if($complaint_type==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Complaint Type does not exist'
             ]);
        }
        $complaint_type->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Complaint Type restored successfully'
        ]);
    }
    //////////////////////////////////////////////////////////////////////////////
    //Display complaints details 
    public function complaintListPage()
    {
        if(\Auth::user()->hasRole('client|sub_dealer|root|trader')){
            return view('Complaint::complaint-list');
        }
    }    
    //returns complaints as json 
    public function getComplaints()
    {
            $complaints = Complaint::select(
                'id', 
                'ticket_id',
                'gps_id',                      
                'complaint_type_id',
                'title',                   
                'description',                                        
                'created_at',
                'client_id',
                'status',
                'servicer_id'
            )
            ->with('gps:id,imei,serial_no')
            ->with('vehicleGps.vehicle:id,name,register_number')
            ->with('ticket:id,code')
            ->with('client:id,name,sub_dealer_id')
            ->with('servicer:id,name')
            ->with('complaintType:id,name,complaint_category')
            ->orderBy('id','desc');
            // ->where('status','!=', 2);
            if(\Auth::user()->hasRole('client'))
            {
                $client_id=\Auth::user()->client->id;
                $complaints = $complaints->where('client_id',$client_id);
            }
            else if(\Auth::user()->hasRole('sub_dealer'))
            {
                $sub_dealer_id      =   \Auth::user()->subDealer->id;
                $clients            =   (new Client())->getDetailsOfClientsUnderSubDealer($sub_dealer_id); 
                $client_id = [];
                foreach($clients as $client){
                    $client_id[] = $client->id;
                }
                $complaints = $complaints->whereIn('client_id',$client_id);
            }else if(\Auth::user()->hasRole('trader')){
                $trader_id      =   \Auth::user()->trader->id;
                $clients        =   (new Client())->getDetailsOfClientsUnderTrader($trader_id);
                $client_id      =   [];
                foreach($clients as $client){
                    $client_id[] = $client->id;
                }
                $complaints = $complaints->whereIn('client_id',$client_id);  
            }
            $complaints = $complaints->get();
            return DataTables::of($complaints)
            ->addIndexColumn()
            ->addColumn('action', function ($complaints) {
                if(\Auth::user()->hasRole('client'))
                {
                    return "
                        <a href=/complaint/".Crypt::encrypt($complaints->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> Complaint Details View </a>";
                }
                else if(\Auth::user()->hasRole('sub_dealer|root|trader'))
                {
                    if($complaints->status == 0)
                    {
                        return "
                    <a href=/complaint/".Crypt::encrypt($complaints->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> Complaint Details View </a>
                    <a href=/assign-complaint/".Crypt::encrypt($complaints->id)." class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-eye-open'></i> Assign to Servicer </a>";
                    }
                    else
                    {
                        return "
                    <a href=/complaint/".Crypt::encrypt($complaints->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> Complaint Details View </a>";
                    }
                }
            })           
            ->addColumn('assigned_to', function ($complaints) { 
                if(\Auth::user()->hasRole('sub_dealer|root|trader'))
                { 
                    if($complaints->status==null||$complaints->status==0)
                    {
                        return "Not Assigned";
                    }
                    else
                    {
                        return $complaints->servicer->name;
                    }                    
                }
                
            })
            ->addColumn('status', function ($complaints) { 
                if($complaints->status==0){
                    return "Open";
                }
                else if($complaints->status==1){
                    return "In Progress";
                }
                 else if($complaints->status==2){
                    return "Closed";
                }
                                        
            })
            ->addColumn('complaint_category', function ($complaints) { 
                 if($complaints->complaintType->complaint_category==0) 
                 {
                    return "Hardware";
                 }else if($complaints->complaintType->complaint_category==1) 
                 {
                    return "Software";
                    
                 }               
            })
           
            ->rawColumns(['link', 'action'])
            ->make();
        
    }

    //complaint creation page
    public function create()
    {
        $client_id=\Auth::user()->client->id;
        // $devices=GpsStock::with('gps')->where('client_id',$client_id)->get();
        $devices=Vehicle::select('id','client_id','gps_id','register_number','is_returned')
                        ->with('gps')
                        ->where('client_id',$client_id)
                        ->get();

        $complaint_type=ComplaintType::select('id','name')
                ->get();
        return view('Complaint::complaint-create',['devices'=>$devices,'complaint_type'=>$complaint_type]);
    }

    //upload complaints to database table
    public function save(Request $request)
    {
        $user_id=\Auth::user()->id;
        $client_id=\Auth::user()->client->id;
        $last_id=Complaint::max('id');
        $ticket_code_id=$last_id+1;
        $ticket_code='C'.'0'.'0'.$ticket_code_id;
        $rules = $this->complaint_create_rules();
        $this->validate($request, $rules);
        
        $is_vehicle_returned_or_reassigned  =   (new Vehicle())->checkVehicleIsNotReturnedOrReassigned($request->gps_id);
        if($is_vehicle_returned_or_reassigned > 0)
        {
            $ticket = Ticket::create([
                'code' => $ticket_code,
                'client_id' => $client_id,
                'status' => 1
            ]);
            
            if($ticket){
                $complaint = Complaint::create([
                    'ticket_id' => $ticket->id,
                    'gps_id' => $request->gps_id,
                    'complaint_type_id' => $request->complaint_type_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'client_id' => $client_id,
                    'created_at'=> date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ]);
            }
            $request->session()->flash('message', 'New Complaint registered successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('complaint')); 
        }
        else
        {
            $request->session()->flash('message', 'Selected vehicle is already returned or reassigned!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('complaint.create')); 
        }

    }

    // solve complaint
    public function solveComplaint(Request $request)
    {
        $user_id=\Auth::user()->id;
        $complaint=Complaint::find($request->id);
        if($complaint == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Complaint does not exist'
            ]);
        }
        $complaint->status = 0;
        $complaint->solved_or_rejected_by = $user_id;
        $complaint->save();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Complaint solved successfully'
        ]);
    }

    // reject complaint
    public function rejectComplaint(Request $request)
    {
        $user_id=\Auth::user()->id;
        $complaint=Complaint::find($request->id);
        if($complaint == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Complaint does not exist'
            ]);
        }
        $complaint->status = 2;
        $complaint->solved_or_rejected_by = $user_id;
        $complaint->save();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Complaint rejected successfully'
        ]);
    }

    //for dependent dropdown 
    public function findComplaintTypeWithCategory(Request $request)
    {   
        $categoryID=$request->categoryID;
        $complaint_type = ComplaintType::select(
                'id', 
                'name'
            )
            ->where('complaint_category',$categoryID)
            ->get();
        return response()->json($complaint_type);
    }

    //complaint details view
    public function view(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $complaint=Complaint::find($decrypted); 
        $complaint_comments=Comment::get();
        if($complaint == null){
           return view('Complaint::404');
        }

        return view('Complaint::complaint-view',['complaint' => $complaint,'complaint_comments' => $complaint_comments]);
    }

    //complaint details view
    public function assignComplaint(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $complaint=Complaint::find($decrypted); 
        $complaint_comments=Comment::get();
        $servicer = Servicer::select('id','name','type','status','user_id','deleted_by')
        // ->where('user_id',$user_id)
        ->where('status',0);
        if(\Auth::user()->hasRole('sub_dealer'))
        {
            $sub_dealer_id      =   \Auth::user()->SubDealer->id;
            $clients            =   (new Client())->getDetailsOfClientsUnderSubDealer($sub_dealer_id);
            $client_id          =   [];
            foreach($clients as $client){
                $client_id[] = $client->id;
            }
            $servicer =$servicer->where('sub_dealer_id',$sub_dealer_id)
            ->where('type',2);
        }
        else  if(\Auth::user()->hasRole('root'))
        {
            $clients            =  (new Client())->getDetailsOfAllClients();            
            $servicer           =   $servicer->where('type',1);
        }else
        {
            $trader_id          =   \Auth::user()->trader->id;
            $clients            =   (new Client())->getDetailsOfClientsUnderTrader($trader_id);  
            $client_id          =   [];
            foreach($clients as $client){
                $client_id[] = $client->id;
            }
             $servicer =$servicer->where('trader_id',$trader_id)
             ->where('type',3); 
        }

        $servicer =$servicer->get();
        if($complaint == null){
           return view('Complaint::404');
        }

        return view('Complaint::assign-complaint-to-servicer',['complaint' => $complaint,'complaint_comments' => $complaint_comments,'servicers'=>$servicer,'client'=>$clients]);
    }

    public function assignComplaintToServicer(Request $request)
    {
        $user_id=\Auth::user()->id;
     
        $complaint = Complaint::where('id', $request->id)->first();
        if($complaint == null){
           return view('Complaint::404');
        } 
        $rules = $this->assignComplantRules($complaint);
        $this->validate($request, $rules);              
        $complaint->servicer_id=$request->servicer;
        $complaint->assigned_by=$user_id;
        $complaint->status=1;
        $complaint->save();  

        $gps        =   Gps::select('id')->where('imei', $request->imei)->first();
        $client     =   (new Client())->getClientDetailsWithClientId($request->client_id);
        $role       =   User::select('role')->where('id', $client->user_id)->first();
        if($role == null || $role == '')
        {
            $role = 1;
        }
        $job_date=date("Y-m-d H:i:s", strtotime($request->job_date));
        $servicer = ServicerJob::create([
            'servicer_id' => $request->servicer,
            'client_id' => $client->id,
            'complaint_id' => $request->complaint_id,
            'job_id' => str_pad(mt_rand(0, 999999), 5, '0', STR_PAD_LEFT),
            'job_type' => 2,
            'start_code' => str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT),
            'user_id' => $user_id,
            'description' => $request->description,
            'role' => $request->plan,
            'job_date' => $job_date,
            'gps_id' => $gps->id,
            'status' => 1, //ASSIGN STATUS
            'location'=>$request->search_place,
            'job_status'=>0
        ]);
        $servicer->save(); 

        //push notification
        $title   = "New Service Job"; 
        $message = ['job_id'  => $servicer->job_id,
                    'title'   => $title,
                    'content' => $request->description,
                    'type'    => "SERVICE",
                    'date'    => date('Y-m-d H:i:s')
                    ];
        ServicerNotification::create([
                                        'servicer_id'       => $request->servicer,
                                        'service_job_id'    =>$servicer->id,
                                        'title'             => $title,
                                        'data'              => json_encode($message,true)
                                    ]);
        $servicer = Servicer::find($request->servicer);      
        $devices  = $servicer->devices;
        foreach ($devices as $device) {
            $this->fcmPushNotification($device->firebase_token,$title,$message);
        }
        //push notification

         $did = encrypt($complaint->id);
         $request->session()->flash('message', 'New Complaint successfully Assigned!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('complaint'));  
    }
    public function complaintList()
    {
        return view('Complaint::servicer-complaint-list');
    }

    //returns complaints as json 
    public function getServicerComplaints()
    {        
        $servicer_id=\Auth::user()->servicer->id;
        $complaints = Complaint::select(
            'id', 
            'ticket_id',
            'gps_id',                      
            'complaint_type_id',
            'title',              
            'description',                                        
            'created_at',
            'client_id',
            'assigned_by',
            'status',
            'servicer_id'
        )
        ->with('gps:id,imei')
        ->with('ticket:id,code')
        ->with('client:id,name,sub_dealer_id')
        ->with('servicer:id,name')
         ->with('assignedBy:id,username')
        ->with('complaintType:id,name')
        ->where('status',1)
        ->where('servicer_id',$servicer_id)
        ->get();
        return DataTables::of($complaints)
        ->addIndexColumn()
        ->addColumn('action', function ($complaints) {                
            $b_url = \URL::to('/');
            return "
            <a href=".$b_url."/assign-complaint/".Crypt::encrypt($complaints->id)."/details class='btn btn-xs btn-info'>Complaint completion</a>";           
        })           
        ->addColumn('assigned_by', function ($complaints) { 
            return $complaints->assignedBy->username;
        })
        ->rawColumns(['link', 'action'])
        ->make();        
    }
    public function complaintDetails(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $complaints = Complaint::select(
            'id', 
            'ticket_id',
            'gps_id',                      
            'complaint_type_id',
            'title',                   
            'description',                                        
            'created_at',
            'client_id',
            'assigned_by',
            'status',
            'servicer_id'
        )
        ->with('gps:id,imei')
        ->with('ticket:id,code')
        ->with('client:id,name,sub_dealer_id')
        ->with('servicer:id,name')
         ->with('assignedBy:id,username')
        ->with('complaintType:id,name')
        ->where('id',$decrypted)
        ->first();      
       if($complaints == null){
           return view('Complaint::404');
        }
        return view('Complaint::complaint-details',['complaints'=>$complaints]);
    }
    public function completeComplaintSave(Request $request)
    { 
        // dd($request->id)
        $rules = $this->complaintcompleteRules();
        $this->validate($request,$rules);      
        $complaint_completed_date=date("Y-m-d"); 
        $complaint = Complaint::find($request->id);
        $complaint->closed_on = $complaint_completed_date;
        $complaint->servicer_comment = $request->comment;
         $complaint->status = 2;
        $complaint->save();
        $complaint_id=Crypt::encrypt($complaint->id);
        $request->session()->flash('message', 'Complaint  completed successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('servicer.complaint.list'));  
       }
    public function complaintHistoryList()
    {
        return view('Complaint::complaint-history-list');
    }
      //returns complaints as json 
    public function getComplaintsHistoryList()
    {        
        
        $complaints = Complaint::select(
            'id', 
            'ticket_id',
            'gps_id',                      
            'complaint_type_id', 
            'title',                  
            'description',                                        
            'created_at',
            'client_id',
            'assigned_by',
            'status',
            'servicer_id',
            'closed_on'
        )
        ->with('gps:id,imei')
        ->with('ticket:id,code')
        ->with('client:id,name,sub_dealer_id')
        ->with('servicer:id,name')
        ->with('assignedBy:id,username')
        ->with('complaintType:id,name')
        ->where('status',2);
        if(\Auth::user()->hasRole('servicer'))
        {
            $servicer_id=\Auth::user()->servicer->id;
            $complaints=$complaints->where('servicer_id',$servicer_id);
        }
        else if(\Auth::user()->hasRole('sub_dealer|trader|root'))
        {
            $logged_user_id=\Auth::user()->id;
            $complaints=$complaints->where('assigned_by',$logged_user_id);
        }
        $complaints=$complaints->get();
        return DataTables::of($complaints)
        ->addIndexColumn()
        ->addColumn('action', function ($complaints) {                
            $b_url = \URL::to('/');
            return "
            <a href=".$b_url."/assign-complaint/".Crypt::encrypt($complaints->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>";           
        })           
        ->addColumn('assigned_by', function ($complaints) { 
            return $complaints->assignedBy->username;
        })
        ->rawColumns(['link', 'action'])
        ->make();        
    }
    public function assignComplantRules($complaint)
    {
        $rules = [
            'servicer' => 'required',                        
        ];
        return  $rules;
    }


    public function complaint_type_create_rules()
    {
        $rules = [
            'name' => 'required',  
            'complaint_category' => 'required'
        ];
        return  $rules;
    }

    //validation for complaint creation
    public function complaint_create_rules()
    {
        $rules = [
            'gps_id' => 'required',       
            'complaint_type_id' => 'required',
            'title' => 'required',
            'description' => 'required'
        ];
        return  $rules;
    }
     public function complaintcompleteRules()
    {
        $rules = [                      
            'comment' => 'required'
        ];
        return  $rules;
    }


       public static function fcmPushNotification($device_id,$tttle,$message)
    {
        $api_key = 'AAAAgmOkdoQ:APA91bE2v6k93s_cXtcscgODZkDBFT2_D-6DpY_aPt_pwpvKJBHjSURcHrxh4TJfPoNPAOjmp8J7AEVQsNd7eAjr1HHSZ5quR4mz6JRgQtfaE47BYwrwrlVuTp8fJgfLDbmjWumfmVdF';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $title = $tttle;
        $body = json_encode($message,true);
        $n = [
            "to"=> $device_id,
            "data" => [
                "title" => $title,
                "content" => $body,
            ]
        ];
   
        $fields = array (
                'registration_ids' => array (
                        $device_id
                ),
                'data' => array (
                        "message" => $message
                )
        );
        $fields = json_encode ( $fields );
    
        $headers = array (
                'Authorization: key=' . $api_key,
                'Content-Type: application/json'
        );
    
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($n) );
    
        $result = curl_exec ( $ch );
        // echo $result;
        curl_close ( $ch );

        FcmLog::create([
            'user_device_id' => $device_id,
            'body' => $fields,
            'response' => $result
        ]);
    
    }

    
}
