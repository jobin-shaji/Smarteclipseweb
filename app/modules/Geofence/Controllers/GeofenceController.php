<?php 


namespace App\Modules\Geofence\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Geofence\Models\Geofence;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGeofence;
use App\Modules\Vehicle\Models\VehicleRoute;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class GeofenceController extends Controller {

    //Display all etms
	public function create()
    {
        $client=\Auth::user()->client;
        // $client = $request->user()->client;
        $lat=(float)$client->latitude;
        $lng=(float)$client->longitude;
        // return response()->json([
        //     'latitude' => (float)$client->latitude,
        //     'longitude' => (float)$client->longitude
        // ]);
		return view('Geofence::fence-create',['lat' => $lat,'lng' => $lng]);
	}
	public function saveFence(Request $request){

		foreach ($request->polygons as $polygon) {
			Geofence::create([
				'user_id' => $request->user()->id,
                'name' => $request->name,
				'cordinates' => $polygon,
				'fence_type_id' => 1
			]);
		}
// return response()->json([
//     'redirect' => url('geofence')
// ]);
        // $request->session()->flash('message', 'New geofence created successfully!'); 
        // $request->session()->flash('alert-class', 'alert-success'); 
        // return redirect(route('geofence'));
        return response()->json([
            'status' => 'geofence',
            'title' => 'Success',
            'redirect' => url('geofence'),
            'message' => 'Geofence added successfully'
        ]);
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
            'fence_type_id',                                      
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
                           
                <button onclick=delGeofence(".$geofence->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> Deactivate </button>";
                }else{ 
                return "
                <a href=".$b_url."/geofence/".Crypt::encrypt($geofence->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i> View</a>  
                <button onclick=activateGeofence(".$geofence->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i> Activate</button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
 public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        return view('Geofence::geofence-details',['id' => $decrypted]);
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
        $geofence = Geofence::select('id','user_id','name','cordinates','fence_type_id','deleted_at')
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
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $fromDate = date("Y-m-d", strtotime($from_date));
        $toDate = date("Y-m-d", strtotime($to_date));
         if($vehicle_id!="")
         {
            $geofences = VehicleGeofence::select('id','vehicle_id','geofence_id','date_from','date_to')
            ->where('vehicle_id',$vehicle_id)
            ->where('geofence_id',$geofence)
            ->where('client_id',$client_id)
            ->get()
            ->count();
            if($geofences==0)
            {
                 $route_area = VehicleGeofence::create([
                        'geofence_id' => $geofence,
                        'vehicle_id' => $vehicle_id,
                        'date_from' => $fromDate,
                        'date_to' => $toDate,
                        'client_id' => $client_id,
                        'status' => 1
                    ]);
            }  
         }      
        $geofence = VehicleGeofence::select(
                    'id',
                    'vehicle_id',
                    'geofence_id',
                    \DB::raw('DATE(date_from) as date_from'),
                    \DB::raw('DATE(date_to) as date_to')
                    // 'date_from',
                    //  'date_to'                                      
                    )
        ->with('vehicleGeofence:id,name')
       ->with('vehicle:id,name,register_number')
        ->where('client_id',$client_id)
        ->get();
        return DataTables::of($geofence)
            ->addIndexColumn() 
            ->addColumn('action', function ($geofence) {  
            $b_url = \URL::to('/');              
            return "
              <a href=".$b_url."/geofence/".Crypt::encrypt($geofence->geofence_id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View Geofence</a> ";               
             })
            ->rawColumns(['link', 'action'])         
            ->make();
    }

   

}