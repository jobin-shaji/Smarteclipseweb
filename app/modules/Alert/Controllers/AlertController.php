<?php 


namespace App\Modules\Alert\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\AlertType;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use Illuminate\Support\Facades\DB;
use DataTables;

class AlertController extends Controller {

    //Display all alerts
	public function alerts()
    {
        
		return view('Alert::alert-list');
	}

	//returns alerts as json 
    public function alertsList()
    {
        $client_id=\Auth::user()->client->id;
        $alert = Alert::select(
                'id',
                'alert_type_id',
                'device_time',
                'vehicle_id',
                'gps_id',
                'client_id',
                'latitude',
                'longitude',
                'status',
                'created_at')
                ->with('alertType:id,code,description')
                ->with('vehicle:id,name,register_number')
                ->with('gps:id,name,imei')
                ->with('client:id,name')
                ->where('client_id',$client_id)
                ->where('status',0)
                ->get();
        return DataTables::of($alert)
            ->addIndexColumn()
        //      ->addColumn('address', function ($alert) {
        //          $latitude=$alert->latitude;
        //         $longitude=$alert->longitude;
        //     if(!empty($latitude) && !empty($longitude)){
        //     //Send request and receive json data by address
        //     $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
        //     $output = json_decode($geocodeFromLatLong);         
        //     $status = $output->status;
        //     //Get address from json data
        //     $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        // }


        //     return  $address ;
        // })
            ->addColumn('action', function ($alert) {
            return "<button onclick=VerifyAlert(".$alert->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-ok'></i> Verify </button>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // alert verification
    public function verifyAlert(Request $request)
    {
        $alert = Alert::find($request->id);
        if($alert == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Alert does not exist'
            ]);
        }
        $alert->status = 1;
        $alert->save();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Alert verified successfully'
        ]);
     }


    

     //alert creation page
    public function create()
    {
       return view('Alert::alert-type-create');
    }
     //upload alert details to database table
    public function save(Request $request)
    {
        $rules = $this->alert_rules();
        $this->validate($request, $rules);
        $file=$request->path;
        $getFileExt   = $file->getClientOriginalExtension();
        $uploadedFile =   time().'.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'alerts';
        $file->move($destinationPath,$uploadedFile);



        $alert_type = AlertType::create([
            'code' => $request->code,
            'description' => $request->description,  
            'path' => $uploadedFile,             
            'status' => 1,               
        ]);

        $request->session()->flash('message', 'New Alert Type created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('alert-type/create')); 
    }
     //Display alert details 
    public function alertListPage()
    {
        return view('Alert::alert-type-list');
    }
     //returns alert as json 
    public function getAlertTypes()
    {
        $alert_type = AlertType::select(
            'id', 
            'code',                      
            'description',
            'path',       
            'deleted_at'
        )
        ->withTrashed()        
        ->get();
        return DataTables::of($alert_type)
        ->addIndexColumn()
        ->addColumn('image', function ($alert_type) {
            return "
           <img src='alerts/".$alert_type->path."' alt='Logo' style='height: 100px; width: 100px;' > ";          
        })
        ->addColumn('action', function ($alert_type) {
            if($alert_type->deleted_at == null){ 
            return "
           
            <a href=/alert-type/".Crypt::encrypt($alert_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=/alert-type/".Crypt::encrypt($alert_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
            <button onclick=delAlertType(".$alert_type->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
            }else{ 
            return "
            <button onclick=activateAlertType(".$alert_type->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link','image', 'action'])
        ->make();
    }
     //alert details view
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);   
        
        $alert_type = AlertType::select(
            'id', 
            'code',                      
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
            'code',                      
            'description',
            'path',                                                       
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
        $file=$request->path;
        if($file!=null)
        {
            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;      
            $destinationPath = 'alerts';
            $file->move($destinationPath,$uploadedFile);
            $alert_type->path = $uploadedFile;
        }
        $alert_type->code = $request->code;
        $alert_type->description = $request->description;
        $alert_type->save();      
        $did = encrypt($alert_type->id);
        $request->session()->flash('message', 'Alert Type updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('alert-types')); 
       
        // return redirect(route('alert.types.edit',$did));  
    }
     //delete alert details from table
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
     // restore alert
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
    }//



       //Display all alerts
    public function packet()
    {
        $devices=Gps::select('id','name','imei')                
                ->get();
       
        return view('Alert::packet-list',['devices'=>$devices]);
    }
     //alert create rules 
    public function alert_rules(){
        $rules = [
            'code' => 'required|unique:alert_types',
            'description' => 'required',
            'path' => 'required'
            
        ];
        return  $rules;
    }
    //validation for alert updation
    public function alertUpdateRules($alert_type)
    {
        $rules = [
            'code' => 'required|unique:alert_types,code,'.$alert_type->id,
            'description' => 'required'      
        ];
        return  $rules;
    }
}