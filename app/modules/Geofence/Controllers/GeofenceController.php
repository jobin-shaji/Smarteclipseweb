<?php 


namespace App\Modules\Geofence\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Geofence\Models\Geofence;


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
        ->get();
        return DataTables::of($geofence)
        ->addIndexColumn()
        ->addColumn('action', function ($dealers) {
            if($geofence->deleted_at == null){ 
            return "
            <a href=/dealers/".Crypt::encrypt($geofence->user_id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
            <a href=/dealers/".Crypt::encrypt($geofence->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <a href=/dealers/".Crypt::encrypt($geofence->user_id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
            <button onclick=delDealers(".$geofence->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
            }else{ 
            return "<a href=/dealers/".Crypt::encrypt($geofence->user_id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <button onclick=activateDealer(".$geofence->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
}