<?php


namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Vehicle\Models\Vehicle;
use DataTables;

class VehicleDepoController extends Controller {
    
    // show list page
    public function vehicleList()
    {
       return view('Vehicle::vehicleDepo-list'); 
    }
    
    // data for list page
    public function getVehicleList(Request $request)
    {
         $depot=$request->data['depot'];
         $buses = Vehicle::select(
                    'id',
                    'register_number',
                    'depot_id',
                    'vehicle_occupancy',
                    'speed_limit',
                    'vehicle_type_id'
                    )
            ->with('vehicleType:id,name')
            ->with('vehicleDepot:id,name,code')
            ->where('depot_id',$depot)
            ->get();

        return DataTables::of($buses)
            ->addIndexColumn()
            ->make();
    }

}
