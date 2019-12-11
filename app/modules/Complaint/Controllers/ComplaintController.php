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
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
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
        if(\Auth::user()->hasRole('client|sub_dealer|root')){
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
                'description',                                        
                'created_at',
                'client_id',
                'status',
                'servicer_id'
            )
            ->with('gps:id,imei')
            ->with('ticket:id,code')
            ->with('client:id,name,sub_dealer_id')
            ->with('servicer:id,name')
            ->with('complaintType:id,name,complaint_category');
            // ->where('status','!=', 2);
            if(\Auth::user()->hasRole('client'))
            {
                $client_id=\Auth::user()->client->id;
                $complaints = $complaints->where('client_id',$client_id);
            }
            else if(\Auth::user()->hasRole('sub_dealer'))
            {
                $sub_dealer_id=\Auth::user()->subDealer->id;
                $clients= Client::select('id', 'name','sub_dealer_id')->where('sub_dealer_id',$sub_dealer_id)->get();
                $client_id = [];
                foreach($clients as $client){
                    $client_id[] = $client->id;
                }
                $complaints = $complaints->whereIn('client_id',$client_id);
            }
            $complaints = $complaints->get();
            // dd($complaints);
            return DataTables::of($complaints)
            ->addIndexColumn()
            ->addColumn('action', function ($complaints) {
                if(\Auth::user()->hasRole('client'))
                {
                    return "
                        <a href=/complaint/".Crypt::encrypt($complaints->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> Complaint Details View </a>";
                }
                else if(\Auth::user()->hasRole('sub_dealer|root'))
                {
                    return "
                    <a href=/complaint/".Crypt::encrypt($complaints->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> Complaint Details View </a>
                    <a href=/assign-complaint/".Crypt::encrypt($complaints->id)." class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-eye-open'></i> Assign to Servicer </a>";
                }
            })           
            ->addColumn('assigned_to', function ($complaints) { 
                if(\Auth::user()->hasRole('sub_dealer|root'))
                { 
                    if($complaints->status==null||$complaints->status==0)
                    {
                        return "not assigned";
                    }
                    else
                    {
                        return $complaints->servicer->name;
                    }                    
                }
                
            })
            ->addColumn('status', function ($complaints) { 
                if($complaints->status==0){
                    return "Not Assigned";
                }
                else if($complaints->status==1){
                    return "Assigned";
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
        $devices=GpsStock::with('gps')->where('client_id',$client_id)->get();

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
                'description' => $request->description,
                'client_id' => $client_id
            ]);
        }
        $request->session()->flash('message', 'New Complaint registered successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('complaint')); 
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
            $sub_dealer_id=\Auth::user()->SubDealer->id;
            $servicer =$servicer->where('sub_dealer_id',$sub_dealer_id)
            ->where('type',2);
        }
        else  if(\Auth::user()->hasRole('root'))
        {
            $servicer =$servicer->where('type',1);
        }
        $servicer =$servicer->get();
        if($complaint == null){
           return view('Complaint::404');
        }

        return view('Complaint::assign-complaint-to-servicer',['complaint' => $complaint,'complaint_comments' => $complaint_comments,'servicers'=>$servicer]);
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
        else if(\Auth::user()->hasRole('sub_dealer|root'))
        {
            $sub_dealer_id=\Auth::user()->id;
            $complaints=$complaints->where('assigned_by',$sub_dealer_id);
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
    
}
