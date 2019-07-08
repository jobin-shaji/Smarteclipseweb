<?php 


namespace App\Modules\Geofence\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Geofence\Models\Geofence;
use Illuminate\Support\Facades\Crypt;

use DataTables;

class GeofenceController extends Controller {

    //Display all etms
	public function create()
    {
		return view('Geofence::fence-create');
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
            if($geofence->deleted_at == null){  
            return " 
             <a href=/geofence/".Crypt::encrypt($geofence->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> </a>           
                           
                <button onclick=delGeofence(".$geofence->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> </button>";
                }else{ 
                return "
                <a href=/geofence/".Crypt::encrypt($geofence->id)."/details class='btn btn-xs btn-info'><i class='fas fa-eye' data-toggle='tooltip' title='View'></i></a>  
                <button onclick=activateGeofence(".$geofence->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i>  </button>";
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
            
            $geofence  =  Geofence:: select(['cordinates'])->where('id',$request->id)->first();  
            $cordinates=$geofence->cordinates; 

               $polygons = array();
                foreach ($cordinates as $cord) {
                    $p = new Geofence;
                    $p->lat = (float)$cord[0];
                    $p->lng = (float)$cord[1];
                     array_push($polygons,$p);
                }

            return response()->json([
                'cordinates' => $polygons,                
                'status' => 'cordinate'
            ]);

    }

   

}