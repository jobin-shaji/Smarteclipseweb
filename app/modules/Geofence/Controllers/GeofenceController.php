<?php 


namespace App\Modules\Geofence\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Geofence\Models\Geofence;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Client\Models\Client;
use App\Modules\User\Models\User;
use DataTables;

class GeofenceController extends Controller {

    //Display all etms
	public function create()
    {
		return view('Geofence::fence-create');
	}

    public function test(){
        $fence = Geofence::find(1);
        $cordinates = $fence->cordinates;
        $polygons = array();
        foreach ($cordinates as $cord) {
            $p = new Geofence;
            $p->lat = (float)$cord[0];
            $p->lng = (float)$cord[1];
         array_push($polygons,$p);

        }

        return json_encode($polygons);

    }


	public function saveFence(Request $request){

		foreach ($request->polygons as $polygon) {
			Geofence::create([
				'user_id' => $request->user()->id,
				'cordinates' => $polygon,
				'fence_type_id' => 1

			]);
		}

		return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Geofence added successfully'
        ]);

	}
 public function geofenceListPage()
    {
        return view('Geofence::geofence-list');
    }

     public function getGeofence()
    {
        $geofence = Geofence::select(
            'id', 
            'user_id',                      
            'name',                   
            'cordinates',  
            'fence_type_id',                                      
            'deleted_at'
        )
        ->withTrashed()
        ->with('user:id,email,mobile')
        ->with('clients:id,user_id,name')
       ->get();  
        return DataTables::of($geofence)
        ->addIndexColumn()
        ->addColumn('action', function ($geofence) {
            if($geofence->deleted_at == null){  
            return "          
	               <button onclick=showMap(".$geofence->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </button>          
	            <button onclick=delGeofence(".$geofence->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
	            }else{ 
	            return "
	            <a href=/geofence/".Crypt::encrypt($geofence->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>  
	            <button onclick=activateGeofence(".$geofence->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function details(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $geofence = Geofence::where('id',$decrypted)->first();
        // dd($geofence->cordinates);
        if($geofence == null)
        {
           return view('Geofence::404');
        }
        return view('Geofence::geofence-details',['geofence' => $geofence]);
    }
    //delete employee details from table
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
}