<?php
namespace App\Modules\Complaint\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Complaint\Models\Complaint;
use App\Modules\Complaint\Models\ComplaintType;
use App\Modules\Gps\Models\Gps;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class ComplaintController extends Controller {

    //Display complaints details 
    public function complaintListPage()
    {
        if(\Auth::user()->hasRole('client')){
            return view('Complaint::complaint-list');
        }else if(\Auth::user()->hasRole('root')){
            return view('Complaint::complaint-list-root');
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
                'gps_id',                      
                'complaint_type_id',                   
                'discription',                                        
                'created_at',
                'status'
            )
            ->with('gps:id,name,imei')
            ->with('complaintType:id,name')
            ->where('client_id',$client_id)
            ->get();
            return DataTables::of($complaints)
            ->addIndexColumn()
            ->addColumn('status', function ($complaints) {
                if($complaints->status==0){
                    return "Solved";
                }else if($complaints->status==1){
                    return "Submitted";
                }else{
                    return "Rejected";
                }
            })
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
        }
    }

    //complaint creation page
    public function create()
    {
        $client_id=\Auth::user()->client->id;
        $client_user_id=\Auth::user()->id;
        $devices=Gps::select('id','name','imei')
                ->where('user_id',$client_user_id)
                ->get();
        $complaint_type=ComplaintType::select('id','name')
                ->get();
        return view('Complaint::complaint-create',['devices'=>$devices,'complaint_type'=>$complaint_type]);
    }

    //upload complaints to database table
    public function save(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $rules = $this->complaint_create_rules();
        $this->validate($request, $rules);
        $complaint = Complaint::create([
            'gps_id' => $request->gps_id,
            'complaint_type_id' => $request->complaint_type_id,
            'discription' => $request->discription,
            'client_id' => $client_id,
            'status' => 1
        ]);
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

    //validation for complaint creation
    public function complaint_create_rules()
    {
        $rules = [
            'gps_id' => 'required',       
            'complaint_type_id' => 'required',
            'discription' => 'nullable'
        ];
        return  $rules;
    }
    
}
