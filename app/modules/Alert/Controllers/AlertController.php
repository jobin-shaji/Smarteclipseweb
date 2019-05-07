<?php 


namespace App\Modules\Alert\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\AlertType;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class AlertController extends Controller {

    //Display all etms
	public function alerts()
    {
		return view('Alert::alert-list');
	}

	//returns etm as json 
    public function alertsList()
    {
        $alert = Alert::select(
                'id',
                'message_type',
            	'message',
                'device_time',
                'vehicle_id',
                'imei',
                'waybill_id',
                'stage_id',
                'trip_no')
                ->with('vehicle:id,register_number')
                ->with('stage:id,name')
                ->with('waybill:id,code')
                ->get();
        return DataTables::of($alert)
            ->addIndexColumn()
            ->make();
    }
     //dealer creation page
    public function create()
    {
       return view('Alert::alert-type-create');
    }
     //upload dealer details to database table
    public function save(Request $request)
    {
        // \Auth::user()->root->first()->id
        $client_id=\Auth::user()->id;
        if($request->user()->hasRole('client')){
            $rules = $this->alert_rules();
            $this->validate($request, $rules);
            $alert_type = AlertType::create([
                'alert_type' => $request->alert_type,
                'description' => $request->description,               
                'status' => 1,               
            ]);
            // User::where('username', $request->username)->first()->assignRole('dealer');
        }       
        $request->session()->flash('message', 'New Alert Type created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('alert-type/create')); 
    }
     //Display employee details 
    public function alertListPage()
    {
        return view('Alert::alert-type-list');
    }
     //returns employees as json 
    public function getAlertTypes()
    {
        $alert_type = AlertType::select(
            'id', 
            'alert_type',                      
            'description',                                                                      
            'deleted_at'
        )
        ->withTrashed()        
        ->get();
        return DataTables::of($alert_type)
        ->addIndexColumn()
        ->addColumn('action', function ($alert_type) {
            if($alert_type->deleted_at == null){ 
            return "
           
            <a href=/alert-type/".Crypt::encrypt($alert_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=/alert-type/".Crypt::encrypt($alert_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
            <button onclick=delAlertType(".$alert_type->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
            }else{ 
            return "<a href=/alert-type/".Crypt::encrypt($alert_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <button onclick=activateAlertType(".$alert_type->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
     //Dealer details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        
        $alert_type = AlertType::select(
            'id', 
            'alert_type',                      
            'description',                                                                      
            'deleted_at'
        )
        ->withTrashed()
        ->where('id',$decrypted)
        ->get();
        if($alert_type == null){
            return view('Alert::404');
        }
        return view('Alert::Alert-type-details',['alert_type' => $alert_type]);
    }
    //for edit page of Alert Type
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
         $alert_type = AlertType::select(
            'id', 
            'alert_type',                      
            'description',                                                                      
            'deleted_at'
        )
        ->withTrashed()       
        ->where('id',$decrypted)
        ->get();
        if($alert_type == null){
            return view('Alert::404');
        }
        return view('Alert::alert-type-edit',['alert_type' => $alert_type]);
    }
     //update alert Type 
    public function update(Request $request)
    { 
       $alert_type = AlertType::where('id', $request->id)->first();
        if($alert_type == null){
           return view('Alert::404');
        } 
        $rules = $this->alertUpdateRules($alert_type);
        $this->validate($request, $rules);      
        $alert_type->alert_type = $request->alert_type;
        $alert_type->description = $request->description;
        $alert_type->save();
      
        $did = encrypt($alert_type->id);
        $request->session()->flash('message', 'Alert Type updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('alert.types.edit',$did));  
    }
     //delete employee details from table
    public function deleteAlertType(Request $request)
    {
        $alert_type = AlertType::find($request->uid);
        if($alert_type == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Alert Type does not exist'
            ]);
        }
        $alert_type->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert Type deleted successfully'
        ]);
    }
     // restore emplopyee
    public function activateAlertType(Request $request)
    {
        $alert_type = AlertType::withTrashed()->find($request->id);
        if($alert_type==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Dealer does not exist'
            ]);
        }
        $alert_type->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Dealer restored successfully'
        ]);
    }
     //user create rules 
    public function alert_rules(){
        $rules = [
            'alert_type' => 'required|unique:alert_types',
            'description' => 'required',
            
        ];
        return  $rules;
    }
    //validation for employee updation
    public function alertUpdateRules($alert_type)
    {
        $rules = [
            'alert_type' => 'required|unique:alert_types,alert_type,'.$alert_type->id,
            'description' => 'required'       
        ];
        return  $rules;
    }
}