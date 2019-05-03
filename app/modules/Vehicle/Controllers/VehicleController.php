<?php


namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleType;
use DataTables;

class VehicleController extends Controller {
    
    // show list page
    public function vehicleList()
    {
       return view('Vehicle::vehicle-list'); 
    }

    
    // data for list page
    public function getVehicleList()
    {
      $vehicles = Vehicle::select(
                    'id',
                    'register_number',
                    'depot_id',
                    'vehicle_occupancy',
                    'speed_limit',
                    'vehicle_type_id',
                    'deleted_at'
                    )
            ->withTrashed()
            ->with('vehicleType:id,name')
            ->with('vehicleDepot:id,name,code')
            ->get();

        return DataTables::of($vehicles)
            ->addIndexColumn()
            ->addColumn('action', function ($vehicles) {
                if($vehicles->deleted_at == null){
                    return "<a href=/vehicles/".$vehicles->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/vehicles/".$vehicles->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=deleteVehicle(".$vehicles->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>"; 
                }else{
                     return "<a href=/vehicles/".$vehicles->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/vehicles/".$vehicles->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateVehicle(".$vehicles->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate </button>"; 
                }
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // create a new vehicle
    public function createVehicle()
    {
        $user_id=\Auth::user()->id;
        $vehicleTypes=VehicleType::select(
                'id','name')->get();
        $gps=Gps::select('id','name','imei')
                ->where('user_id',$user_id)
                ->get();
        return view('Vehicle::vehicle-add',['vehicleTypes'=>$vehicleTypes,'gps'=>$gps]);
    }

    // save vehicle
    public function saveVehicle(Request $request)
    {

         $rules = $this->vehicleCreateRules();
         $this->validate($request, $rules);
         $vehicle = Vehicle::create([
            'register_number' => $request->register_number,
            'vehicle_type_id' => $request->vehicle_type,
            'vehicle_occupancy' =>$request->vehicle_occupancy,
            'speed_limit' =>$request->vehicle_speed,
            'depot_id' =>$request->vehicle_depot,
            'status' =>1,
           ]);

        $request->session()->flash('message', 'New Vehicle created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 

        return redirect(route('vehicles'));
    }
    


  
   // edit vehicle
    public function edit(Request $request)
    {
      $vehicle = Vehicle::find($request->id);
      $vehicleTypes=VehicleType::select('id','name')->get();
      $vehicleDepot=Depot::select('id','name')
                    // ->where('state_id',\Auth::user()->state->id)
                    ->get();
         if($vehicle == null){
            return view('Vehicle::404');
          }
     return view('Vehicle::vehicle-edit',['vehicle' => $vehicle,'vehicleTypes'=>$vehicleTypes,'depots'=>$vehicleDepot]);
    }

    // update vehicle
    public function update(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        if($vehicle == null){
           return view('Vehicle::404');
        }
        $rules = $this->vehicleUpdateRules();
        $this->validate($request, $rules);

        $vehicle->register_number = $request->register_number;
        $vehicle->vehicle_type_id= $request->vehicle_type;
        $vehicle->vehicle_occupancy = $request->vehicle_occupancy;
        $vehicle->speed_limit = $request->vehicle_speed;
        $vehicle->depot_id = $request->vehicle_depot;
        $vehicle->save();

        $request->session()->flash('message', 'Vehicle details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle.edit',$vehicle));  
    }

    // details page
    public function details(Request $request)
    {
     $vehicle=Vehicle::find($request->id);

      if($vehicle==null){
        return view('Vehicle::404');
      } 

     return view('Vehicle::vehicle-details',['vehicle' => $vehicle]);
    }

    

    // vehicle delete
    public function deleteVehicle(Request $request)
    {
        $vehcle=Vehicle::find($request->vid);
        if($vehcle == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Vehicle does not exist'
            ]);
        }
        $vehcle->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Vehicle deleted successfully'
        ]);
     }


    // restore vehicle
    public function activateVehicle(Request $request)
    {
        $vehicle = Vehicle::withTrashed()->find($request->id);
        if($vehicle==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Vehicle does not exist'
             ]);
        }

        $vehicle->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Vehicle restored successfully'
        ]);
    }

///////////////////////// VEHICLE TYPE ///////////////////////////////////
    // vehicle type list
    public function vehicleTypeList()
    {
       return view('Vehicle::vehicle-type-list'); 
    }

    // vehicle type list data
    public function getVehicleTypeList()
    {

        $vehicle_type = VehicleType::select(
                    'id',
                    'name'
                    )
                ->get();

        return DataTables::of($vehicle_type)
            ->addIndexColumn()
            ->addColumn('action', function ($vehicle_type) {
                return "<a href=/vehicle-type/".$vehicle_type->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/vehicle-type/".$vehicle_type->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // create vehicle type
    public function createVehicleType()
    {
        return view('Vehicle::vehicle-type-add');
    }
    // save vehicle type
    public function saveVehicleType(Request $request)
    {
        $rules = $this->vehicleTypeCreateRules();
        $this->validate($request, $rules);
        $vehicle_type = VehicleType::create([
            'name' => $request->name,
            'status' =>1,
           ]);
        $request->session()->flash('message', 'New Vehicle type created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 

        return redirect(route('vehicle_type.details',$vehicle_type->id));
    }

    // vehicle type details
    public function detailsVehicleType(Request $request)
     {
        $vehicle_type=VehicleType::find($request->id);
        if($vehicle_type==null){
            return view('Vehicle::404');
        } 
        return view('Vehicle::vehicle-type-details',['vehicle_type' => $vehicle_type]);
     }
    // edit vehicle type
    public function editVehicleType(Request $request)
    {
        $vehicle_type = VehicleType::find($request->id);
        if($vehicle_type == null)
        {
            return view('Vehicle::404');
        }
        return view('Vehicle::vehicle-type-edit',['vehicle_type' => $vehicle_type]);
    }

    // update vehicle type
    public function updateVehicleType(Request $request)
    {
      $vehicle_type = VehicleType::find($request->id);
       if($vehicle_type == null){
           return view('Vehicle::404');
        }
        $rules = $this->vehicleTypeUpdateRules();
        $this->validate($request, $rules);

        $vehicle_type->name = $request->name;
        $vehicle_type->save();

        $request->session()->flash('message', 'Vehicle type details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle-type.edit',$vehicle_type));  
    }
    // delete vehicle type
     public function deleteVehicleType(Request $request)
     {
        $vehicle_type=VehicleType::find($request->uid);
        if($vehicle_type == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Bus type does not exist'
            ]);
        }
        $vehicle_type->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Bus type deleted successfully'
        ]);
        
     }
    

    // vehicle create rules
      public function vehicleCreateRules()
      {
        $rules = [
            'register_number' => 'required',
            'vehicle_type' => 'required',
            'vehicle_depot' => 'required',
            'vehicle_occupancy' => 'required|integer',
            'vehicle_speed' => 'required|integer'
        ];
        return  $rules;
       }
    // vehicle update rules
       public function vehicleUpdateRules()
       {
        $rules = [
            'register_number' => 'required',
            'vehicle_type' => 'required',
            'vehicle_depot' => 'required',
            'vehicle_occupancy' => 'required|integer',
            'vehicle_speed' => 'required|integer'
        ];
        return  $rules;  
      }
      // vehicle type create rules
      public function vehicleTypeCreateRules()
      {
        $rules = [
            'name' => 'required'
        ];
        return  $rules;
      }
      // vehicle update rules
      public function vehicleTypeUpdateRules()
      {
        $rules = [
            'name' => 'required'
        ];
        return  $rules;
      }


}
