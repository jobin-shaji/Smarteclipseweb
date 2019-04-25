<?php 


namespace App\Modules\Alert\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Alert\Models\Alert;

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
}