<?php 


namespace App\Modules\Geofence\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Geofence\Models\Geofence;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGeofence;
use App\Modules\Vehicle\Models\VehicleRoute;
use App\Modules\Client\Models\Client;

use App\Modules\Ota\Models\OtaResponse;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class GeofenceController extends Controller {

    //Display all etms
	public function create(Request $request)
    {
        $user_id=\Auth::user()->id;
        $client=\Auth::user()->client;
        // $client = $request->user()->client;
        $lat=(float)$client->latitude;
        $lng=(float)$client->longitude;
        $geofence = Geofence::select(
            'id', 
            'user_id'                                  
        )  
        ->withTrashed()     
        ->where('user_id',$request->user()->id)        
        ->count(); 
        if($geofence<1){
            return view('Geofence::fence-create',['lat' => $lat,'lng' => $lng]);
        }else if($request->user()->hasRole('fundamental')&& $geofence<3) {
            return view('Geofence::fence-create',['lat' => $lat,'lng' => $lng]);
        }
        else if($request->user()->hasRole('superior')&& $geofence<6) {
            return view('Geofence::fence-create',['lat' => $lat,'lng' => $lng]);
        }
        else if($request->user()->hasRole('pro')&& $geofence<10) {
            return view('Geofence::fence-create',['lat' => $lat,'lng' => $lng]);
        }else{
            $request->session()->flash('message', 'Please upgrade your current plan for adding more geofence'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return view('Geofence::geofence-list');
        }
	}
	public function saveFence(Request $request)
    {
        if($request->polygons==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Please draw the geofence'
            ]);
        }else{
            foreach ($request->polygons as $polygon) {
                $response="";
                foreach ($polygon as $single_coordinate) {
                    $response .=$single_coordinate[0].'-'.$single_coordinate[1].'#';
                }
                $response=rtrim($response,"#");
                $last_id=Geofence::max('id');
                $code_last_id=$last_id+1;
                $code=str_pad($code_last_id, 5, '0', STR_PAD_LEFT);
                Geofence::create([
                    'user_id' => $request->user()->id,
                    'name' => $request->name,
                    'cordinates' => $polygon,
                    'response' => $response,
                    'code' => $code
                ]);
            }
            return response()->json([
                'status' => 'geofence',
                'title' => 'Success',
                'redirect' => url('geofence'),
                'message' => 'Geofence added successfully'
            ]);
        }
	}


    public function geofenceListPage()
    {
        return view('Geofence::geofence-list');
    }

     public function getGeofence()
    {
        $client_user_id=\Auth::user()->id;
        $geofence = Geofence::select(
            'id', 
            'user_id',                      
            'name',                   
            'cordinates',                                     
            'deleted_at'
        )
        ->withTrashed()
        ->where('user_id',$client_user_id)
        ->with('user:id,email,mobile')
        ->with('clients:id,user_id,name')
        ->get();  
        return DataTables::of($geofence)
        ->addIndexColumn()
        ->addColumn('action', function ($geofence) {
            $b_url = \URL::to('/');
            if($geofence->deleted_at == null){  
            return " 
             <a href=".$b_url."/geofence/".Crypt::encrypt($geofence->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'> View</i> </a>  
             <a href=".$b_url."/geofence/".Crypt::encrypt($geofence->id)."/edit class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-edit'> Redraw</i> </a>         
                           
                <button onclick=delGeofence(".$geofence->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> Deactivate </button>";
                }else{ 
                return "
                
                <button onclick=activateGeofence(".$geofence->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i> Activate</button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $geofence=Geofence::find($decrypted);
        if($geofence == null)
        {
           return view('Geofence::404');
        }
        return view('Geofence::geofence-details',['id' => $decrypted,'geofence' => $geofence]);
    }

    public function deleteGeofence(Request $request)
    {
        $geofence = Geofence::find($request->uid);
        if($geofence == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Geofence does not exist'
            ]);
        }
        $vehicle_geofences=VehicleGeofence::where('geofence_id',$geofence->id)->get();
        foreach ($vehicle_geofences as $single_geofence) {
            $single_vehicle_geofence_id=$single_geofence->id;
            $single_vehicle_geofence = VehicleGeofence::find($single_vehicle_geofence_id);
            $delete_single_true=$single_vehicle_geofence->delete();
            if($delete_single_true){
                $success=$this->geofenceResponse($single_vehicle_geofence->vehicle_id);
            } 
        } 
        $geofence->delete();   

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Geofence deleted successfully'
        ]);
    }
    // restore emplopyee
    public function activateGeofence(Request $request)
    {
        $geofence = Geofence::withTrashed()->find($request->id);
        if($geofence==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Geofence does not exist'
            ]);
        }
        $geofence->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Geofence restored successfully'
        ]);
    }


     public function geofenceShow(Request $request){  
            
            $coordinates  =  Geofence:: select(['id','cordinates','name','user_id',
                 \DB::raw('DATE(created_at) as date')])
            ->with('user:id,username')
            ->where('id',$request->id)->first();  
            
            $cordinates=$coordinates->cordinates; 

               $polygons = array();
                foreach ($cordinates as $cord) {
                    $p = new Geofence;
                    $p->lat = (float)$cord[0];
                    $p->lng = (float)$cord[1];
                     array_push($polygons,$p);
                }

            return response()->json([
                'cordinates' => $polygons,
                'geofence' => $coordinates,                
                'status' => 'cordinate'
            ]);


    }
     public function assignGeofenceList()
    {
        $user_id=\Auth::user()->id;
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        $geofence = Geofence::select('id','user_id','name','cordinates','deleted_at')
        ->where('user_id',$user_id)
        ->get();
        
         return view('Geofence::assign-geofence-vehicle-list',['vehicles'=>$vehicles,'geofences'=>$geofence]); 
    }

    public function getAssignGeofenceVehicleList(Request $request)
    {

        $client_id=\Auth::user()->client->id;
       // $client_id= $request->client;         
        $vehicle_id= $request->vehicle_id;         
        $geofence = $request->geofence_id;
        $alert_type = $request->alert_type;
        // $from_date = $request->from_date;
        // $to_date = $request->to_date;
        // $fromDate = date("Y-m-d", strtotime($from_date));
        // $toDate = date("Y-m-d", strtotime($to_date));
        if($vehicle_id!="")
        {
            $geofences = VehicleGeofence::select('id','vehicle_id','geofence_id','date_from','date_to','alert_type')
            ->where('vehicle_id',$vehicle_id)
            ->where('geofence_id',$geofence)
            ->where('alert_type',$alert_type)
            ->where('client_id',$client_id)
            // ->whereBetween('date_from',array($fromDate,$toDate))
            // ->WhereBetween('date_to',array($fromDate,$toDate))
            ->get()
            ->count();
            if($geofences==0)
            {
                $route_area = VehicleGeofence::create([
                        'geofence_id' => $geofence,
                        'vehicle_id' => $vehicle_id,
                        'alert_type' => $alert_type,
                        'client_id' => $client_id,
                        'status' => 1
                    ]);
                if($route_area)  {
                    $this->geofenceResponse($route_area->vehicle_id);
                } 
            }  
        }   
        $geofence = VehicleGeofence::select(
                    'id',
                    'vehicle_id',
                    'geofence_id',
                    'alert_type'
                    )
                ->with('vehicleGeofence:id,name')
                ->with('vehicle:id,name,register_number')
                ->where('client_id',$client_id)
                ->get();
        return DataTables::of($geofence)
            ->addIndexColumn() 
            ->addColumn('alert', function ($geofence) {  
                if($geofence->alert_type==1){
                    return "Entry";
                }else{
                    return "Exit";
                }         
            })
            ->addColumn('action', function ($geofence) {  
            $b_url = \URL::to('/');              
            return "
                <button onclick=deleteAssignedGeofence(".$geofence->id.") class='btn btn-xs btn-danger'><i class='fas fa-trash'></i> Delete </button>
                <a href=".$b_url."/geofence/".Crypt::encrypt($geofence->geofence_id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View Geofence</a> ";               
            })
            ->rawColumns(['link', 'action'])         
            ->make();
    }

    //delete assigned geofence from table
    public function deleteAssignedGeofence(Request $request)
    {
        $assigned_geofence = VehicleGeofence::find($request->id);
        if($assigned_geofence == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Geofence does not exist'
            ]);
        }
        $delete_true=$assigned_geofence->delete();
        if($delete_true){
            $this->geofenceResponse($assigned_geofence->vehicle_id);
        } 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Scheduled geofence deleted successfully'
        ]);
    }

    public function geofenceResponse($vehicle_id)
    {
        $response_string="";
        $vehicle = Vehicle::find($vehicle_id);
        $vehicle_geofences=VehicleGeofence::where('vehicle_id',$vehicle_id)->get();
        foreach ($vehicle_geofences as $single_geofence) {
            $geofence_id=$single_geofence->geofence_id;
            $geofence_details=Geofence::where('id',$geofence_id)->first();
            $response_string .=$geofence_details->code.'-'.$single_geofence->alert_type.'-'.$geofence_details->response.'&';
        }
        if($response_string==""){
            $response_string="CLR VGF";
        }else{
            $response_string="SET VGF:".$response_string;
        }
        $geofence_response= OtaResponse::create([
                    'gps_id' => $vehicle->gps_id,
                    'response' => $response_string
                ]);
        return $geofence_response;
    }


    public function alredyassigngeofenceCount(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $vehicle_id= $request->vehicle_id;           
        $geofence = $request->geofence_id;
        $alert_type = $request->alert_type;
        // $from_date = $request->from_date;
        // $to_date = $request->to_date;
        // $fromDate = date("Y-m-d", strtotime($from_date));
        // $toDate = date("Y-m-d", strtotime($to_date));
        $geofences = VehicleGeofence::select('id','vehicle_id','geofence_id','alert_type')
        ->where('vehicle_id',$vehicle_id)
        ->where('geofence_id',$geofence)
        ->where('client_id',$client_id)
        ->where('alert_type',$alert_type)
        // ->whereBetween('date_from',array($fromDate,$toDate))
        // ->WhereBetween('date_to',array($fromDate,$toDate))
        ->get()
        ->count();
        return response()->json([
            'assign_geofence_count' => $geofences            
        ]);       
    }

    public function schoolFenceCreate(Request $request)
    {
        $user_id=\Auth::user()->id;
        $client=\Auth::user()->client;
        $lat=(float)$client->latitude;
        $lng=(float)$client->longitude;       
        return view('Geofence::school-fence-create',['lat' => $lat,'lng' => $lng]);
    }
    public function saveSchoolFence(Request $request){
        $user_id=\Auth::user()->id;

        $client_id=\Auth::user()->client->id;
        if($request->polygons==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Please draw the geofence'
            ]);
        }else{ 
        foreach ($request->polygons as $polygon) {
                $response="";
                foreach ($polygon as $single_coordinate) {
                    $response .=$single_coordinate[0].'-'.$single_coordinate[1].'#';
                }
                $response=rtrim($response,"#");
                $last_id=Geofence::max('id');
                $code_last_id=$last_id+1;
                $code=str_pad($code_last_id, 5, '0', STR_PAD_LEFT);
                if(\Auth::user()->geofence)
                { 
                    $geofence  =  Geofence::where('user_id',$user_id)->first(); 
                    // dd($request->name);             
                    $geofence->name=$request->name;
                    $geofence->cordinates=$polygon;
                    $geofence->response=$response;
                    $geofence->code=$code;
                    $geofence->save();
                }
                else
                {
                  
                    Geofence::create([
                    'user_id' => $request->user()->id,
                    'name' => $request->name,
                    'cordinates' => $polygon,
                    'response' => $response,
                    'code' => $code
                ]);
                }
                
            }                             
            return response()->json([
                'status' => 'school geofence',
                'title' => 'Success',
                'redirect' => url('/home'),
                'message' => 'Geofence added successfully'
            ]);
        }
    }

      public function schoolGeofenceShow(Request $request){  
            $user_id=\Auth::user()->id;
            $coordinates  =  Geofence:: select(['id','cordinates','name','user_id',
                \DB::raw('DATE(created_at) as date')])
            ->with('user:id,username')
            ->where('user_id',$user_id)->first();
            if($coordinates)           
            {           
                 $cordinates=$coordinates->cordinates; 
                 $polygons = array();
                 foreach ($cordinates as $cord) {                    
                     $p = new Geofence;
                     $p->lat = (float)$cord[0]; 
                     $p->lng = (float)$cord[1];
                      array_push($polygons,$p);
                 }           
                 return response()->json([
                     'cordinates' => $polygons,
                     'geofence' => $coordinates,                
                     'status' => 'cordinate'
                 ]);
             }


    }
     public function editSchoolFence(Request $request){
        $user_id=\Auth::user()->id;
        $client_id=\Auth::user()->client->id;
        if($request->polygons==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Please draw the geofence'
            ]);
        }else{ 
        foreach ($request->polygons as $polygon) {
                $response="";
                foreach ($polygon as $single_coordinate) {
                    $response .=$single_coordinate[0].'-'.$single_coordinate[1].'#';
                }
                $response=rtrim($response,"#");
                $last_id=Geofence::max('id');
                $code_last_id=$last_id+1;
                // $code=str_pad($code_last_id, 5, '0', STR_PAD_LEFT);
                $geofence  =  Geofence::where('user_id',$user_id)->first(); 
                $geofence->cordinates=$polygon;
                $geofence->response=$response;
                // $geofence->code=$code;
                $geofence->save();                              
            }                             
            return response()->json([
                'status' => 'school geofence',
                'title' => 'Success',
                'redirect' => url('/client/profile'),
                'message' => 'Geofence added successfully'
            ]);
        }
    }

    public function fenceEdit(Request $request)
    {
        
        $decrypted = Crypt::decrypt($request->id);
        $user_id=\Auth::user()->id;
        $client=\Auth::user()->client;
        $lat=(float)$client->latitude;
        $lng=(float)$client->longitude; 
        $geofence = Geofence::find(decrypt($request->id));  
        if($geofence == null)
        {
           return view('Geofence::404');
        }
        return view('Geofence::fence-edit',['lat' => $lat,'lng' => $lng,'geofence_id'=>$decrypted,'geofence'=>$geofence]);        
    }


    public function updateFence(Request $request){
        $user_id=\Auth::user()->id;
        $client_id=\Auth::user()->client->id;
        $name=$request->name;
        $geofence_id=$request->geofence_id;
        $geofence  =  Geofence::where('id',$geofence_id)->first(); 
        $old_geofence_response=$geofence->response;
        $geofence->name=$name;
        if($request->polygons!=null){
        foreach ($request->polygons as $polygon) {
                $response="";
                foreach ($polygon as $single_coordinate) {
                    $response .=$single_coordinate[0].'-'.$single_coordinate[1].'#';
                }
                $response=rtrim($response,"#");
                $geofence->cordinates=$polygon;
                $geofence->response=$response;
            } 
        } 
        $geofence->save(); 
        $new_geofence_response=$geofence->response;      
        if($new_geofence_response != $old_geofence_response)  
        {
            $vehicle_geofences=VehicleGeofence::select('vehicle_id')->where('geofence_id',$geofence_id)->get();
            $vehicle_list=[];
            foreach ($vehicle_geofences as $single_vehicle_geofence) {
                $vehicle_list[]=$single_vehicle_geofence->vehicle_id;
                $vehicle_list=array_unique($vehicle_list);
            }
            foreach($vehicle_list as $single_vehicle_geofence){
                $this->geofenceResponse($single_vehicle_geofence);
            }
        }                 
        return response()->json([
            'status' => 'edit geofence',
            'title' => 'Success',
            'redirect' => url('/geofence'),
            'message' => 'Geofence added successfully'
        ]);
        
    }
}