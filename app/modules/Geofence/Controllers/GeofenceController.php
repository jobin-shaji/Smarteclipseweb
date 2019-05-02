<?php 


namespace App\Modules\Geofence\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use DataTables;

class GeofenceController extends Controller {

    //Display all etms
	public function create()
    {
		return view('Geofence::fence-create');
	}


}