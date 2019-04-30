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


}