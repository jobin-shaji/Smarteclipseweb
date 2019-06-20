<?php
namespace App\Modules\Complaint\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Complaint\Models\Complaint;
use App\Modules\Complaint\Models\ComplaintType;
use App\Modules\Complaint\Models\Comment;
use App\Modules\Ticket\Models\Ticket;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
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
        $rules = $this->complaint_type_create_rules();
        $this->validate($request, $rules);
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

///////////////////////////////////////////////////////////////////////////////////////

    //Display complaints details 
    public function complaintListPage()
    {
        if(\Auth::user()->hasRole('client')){
            return view('Complaint::complaint-list');
        }else if(\Auth::user()->hasRole('root')){
            return view('Complaint::complaint-list-root');
        }else if(\Auth::user()->hasRole('dealer')){
            return view('Complaint::complaint-list-dealer');
        }else if(\Auth::user()->hasRole('sub_dealer')){
            return view('Complaint::complaint-list-sub-dealer');
        }
    }
    
    //returns complaints as json 
    public function getComplaints()
    {
        if(\Auth::user()->hasRole('client'))
        {
            $client_id=\Auth::user()->client->id;
            $complaints = Complaint::select(
                'id', 
                'ticket_code',
                'gps_id',                      
                'complaint_type_id',                   
                'description',                                        
                'created_at',
                'status',
                'response_by'
            )
            ->with('gps:id,name,imei')
            ->with('complaintType:id,name')
            ->where('client_id',$client_id)
            ->get();
            return DataTables::of($complaints)
            ->addIndexColumn()
            ->addColumn('status', function ($complaints) {
                if($complaints->status==0){
                    $solved_user=$complaints->user->username;
                    return "Resolved By ".$solved_user;
                }else if($complaints->status==1){
                    return "Submitted";
                }else{
                    $solved_user=$complaints->user->username;
                    return "Accepted By ".$solved_user;
                }
            })
            ->addColumn('action', function ($complaints) {
                    return "
                        <a href=/complaint/".Crypt::encrypt($complaints->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> Complaint Details View </a>";
            })
            ->rawColumns(['link', 'action'])
            ->make();
        }else if(\Auth::user()->hasRole('root')){
            $complaints = Complaint::select(
                'id', 
                'gps_id',                      
                'complaint_type_id',                   
                'discription',                                        
                'created_at',
                'status',
                'client_id',
                'solved_or_rejected_by'
            )
            ->with('client:id,name')
            ->with('complaintType:id,name')
            ->with('gps:id,name,imei')
            ->get();

        return DataTables::of($complaints)
            ->addIndexColumn()
            ->addColumn('status', function ($complaints) {
                if($complaints->status==0){
                    $solved_user=$complaints->user->username;
                    return "Solved By ".$solved_user;
                }else if($complaints->status==1){
                    return "Received";
                }else{
                    $reject_user=$complaints->user->username;
                    return "Rejected By ".$reject_user;
                }
            })
            ->addColumn('dealer',function($complaints){
                $complaint = Complaint::find($complaints->id);
                return $complaint->client->subDealer->dealer->name;
                
            })
            ->addColumn('sub_dealer',function($complaints){
               $complaint = Complaint::find($complaints->id);
               return $complaint->client->subDealer->name;
                
            })
            ->addColumn('action', function ($complaints) {
                if($complaints->status==1){
                    return "
                        <button onclick=solveIssue(".$complaints->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Solve </button>
                        <button onclick=rejectIssue(".$complaints->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Reject </button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
        }else if(\Auth::user()->hasRole('dealer')){
            $dealer_id=\Auth::user()->dealer->id;
            $sub_dealers = SubDealer::select(
                    'id'
                    )
                    ->where('dealer_id',$dealer_id)
                    ->get();
            $single_sub_dealers = [];
            foreach($sub_dealers as $sub_dealer){
                $single_sub_dealers[] = $sub_dealer->id;
            }
            $clients = Client::select(
                    'id'
                    )
                    ->whereIn('sub_dealer_id',$single_sub_dealers)
                    ->get();
            $single_clients = [];
            foreach($clients as $client){
                $single_clients[] = $client->id;
            }
            $complaints = Complaint::select(
                'id', 
                'gps_id',                      
                'complaint_type_id',                   
                'discription',                                        
                'created_at',
                'status',
                'client_id',
                'solved_or_rejected_by'
            )
            ->whereIn('client_id',$single_clients)
            ->with('client:id,name')
            ->with('complaintType:id,name')
            ->with('gps:id,name,imei')
            ->get();

        return DataTables::of($complaints)
            ->addIndexColumn()
            ->addColumn('status', function ($complaints) {
                if($complaints->status==0){
                    $solved_user=$complaints->user->username;
                    return "Solved By ".$solved_user;
                }else if($complaints->status==1){
                    return "Received";
                }else{
                    $reject_user=$complaints->user->username;
                    return "Rejected By ".$reject_user;
                }
            })
            ->addColumn('sub_dealer',function($complaints){
               $complaint = Complaint::find($complaints->id);
               return $complaint->client->subDealer->name;
                
            })
            ->make();
        }
    }

    //complaint creation page
    public function create()
    {
        $client_id=\Auth::user()->client->id;
        $client_user_id=\Auth::user()->id;
        $last_id=Complaint::max('id');
        $ticket_code_id=$last_id+1;
        $ticket_code='C'.'0'.'0'.$ticket_code_id;
        $devices=Gps::select('id','name','imei')
                ->where('user_id',$client_user_id)
                ->get();
        $complaint_type=ComplaintType::select('id','name')
                ->get();
        return view('Complaint::complaint-create',['devices'=>$devices,'complaint_type'=>$complaint_type,'ticket_code'=>$ticket_code]);
    }

    //upload complaints to database table
    public function save(Request $request)
    {
        $user_id=\Auth::user()->id;
        $client_id=\Auth::user()->client->id;
        $rules = $this->complaint_create_rules();
        $this->validate($request, $rules);
        $ticket = Ticket::create([
            'code' => $request->ticket_code,
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
            $complaint_comment = Comment::create([
                'user_id' => $user_id,
                'comment' => "Complaint registered"
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
            'ticket_code' => 'required',
            'gps_id' => 'required',       
            'complaint_type_id' => 'required',
            'description' => 'required'
        ];
        return  $rules;
    }
    
}
