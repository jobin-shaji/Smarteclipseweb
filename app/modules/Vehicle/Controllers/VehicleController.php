<?php


namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Vehicle\Models\DocumentType;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Gps\Models\Gps;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
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
        $client_id=\Auth::user()->client->id;
        $vehicles = Vehicle::select(
                    'id',
                    'name',
                    'register_number',
                    'gps_id',
                    'e_sim_number',
                    'vehicle_type_id',
                    'deleted_at'
                    )
            ->withTrashed()
            ->where('client_id',$client_id)
            ->with('vehicleType:id,name')
            ->with('gps:id,name,imei')
            ->get();

        return DataTables::of($vehicles)
            ->addIndexColumn()
            ->addColumn('action', function ($vehicles) {
                if($vehicles->deleted_at == null){
                    return "
                    <a href=/vehicles/".$vehicles->id."/documents class='btn btn-xs btn-success'><i class='glyphicon glyphicon-file'></i> Docs. </a>
                    <a href=/vehicles/".$vehicles->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
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
        $client_id=\Auth::user()->client->id;
        $client_user_id=\Auth::user()->id;
        $vehicleTypes=VehicleType::select(
                'id','name')->get();
        $vehicle_device = Vehicle::select(
                'gps_id'
                )
                ->where('client_id',$client_id)
                ->get();
        $single_gps = [];
        foreach($vehicle_device as $device){
            $single_gps[] = $device->gps_id;
        }
        $devices=Gps::select('id','name','imei')
                ->where('user_id',$client_user_id)
                ->whereNotIn('id',$single_gps)
                ->get();
        return view('Vehicle::vehicle-add',['vehicleTypes'=>$vehicleTypes,'devices'=>$devices]);
    }

    // save vehicle
    public function saveVehicle(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $rules = $this->vehicleCreateRules();
        $this->validate($request, $rules);
        $vehicle = Vehicle::create([
            'name' => $request->name,
            'register_number' => $request->register_number,
            'vehicle_type_id' => $request->vehicle_type_id,
            'e_sim_number' => $request->e_sim_number,
            'gps_id' => $request->gps_id,
            'client_id' =>$client_id,
            'status' =>1

        ]);
        $request->session()->flash('message', 'New Vehicle created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle'));
    }
    
    // edit vehicle
    public function edit(Request $request)
    {
        $client_id=\Auth::user()->id;
        $vehicle = Vehicle::find($request->id);
        $vehicleTypes=VehicleType::select('id','name')->get();
        $devices=Gps::select('id','name','imei')
                ->where('user_id',$client_id)
                ->get();
        if($vehicle == null){
            return view('Vehicle::404');
        }
        return view('Vehicle::vehicle-edit',['vehicle' => $vehicle,'vehicleTypes'=>$vehicleTypes,'devices'=>$devices]);
    }

    // update vehicle
    public function update(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        if($vehicle == null){
           return view('Vehicle::404');
        }
        $rules = $this->vehicleUpdateRules($vehicle);
        $this->validate($request, $rules);

        $vehicle->name = $request->name;
        $vehicle->register_number = $request->register_number;
        $vehicle->vehicle_type_id= $request->vehicle_type_id;
        $vehicle->e_sim_number = $request->e_sim_number;
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

    // upload vehicle documents
    public function vehicleDocuments(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        $docTypes=DocumentType::select(
                'id','name')->get();
        $vehicleDocs=Document::select(
                'id','vehicle_id','document_type_id','expiry_date','path')
                ->where('vehicle_id',$vehicle->id)
                ->with('documentType:id,name')
                ->get();
        return view('Vehicle::vehicle-documents',['vehicle' => $vehicle,'docTypes'=>$docTypes,'vehicleDocs'=>$vehicleDocs]);
    }

    // save documents
    public function saveDocuments(Request $request)
    {
        $rules = $this->documentCreateRules();
        $this->validate($request, $rules);
        $file=$request->path;
        $getFileExt   = $file->getClientOriginalExtension();
        $uploadedFile =   time().'.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $file->move($destinationPath,$uploadedFile);
        $documents = Document::create([
            'vehicle_id' => $request->vehicle_id,
            'document_type_id' => $request->document_type_id,
            'expiry_date' => $request->expiry_date,
            'path' => $uploadedFile,
        ]);
        $request->session()->flash('message', 'Document stored successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle'));
    }

    // edit vehicle doc
    public function vehicleDocumentEdit(Request $request)
    {
        $vehicle_doc = Document::find($request->id);
        $document_type=DocumentType::select('id','name')->get();
        if($vehicle_doc == null){
            return view('Vehicle::404');
        }
        return view('Vehicle::vehicle-document-edit',['vehicle_doc' => $vehicle_doc,'document_type'=>$document_type]);
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
    
    /////////////////////////////Vehicle Root List//////////////////////////
    // show list page
    public function vehicleRootList()
    {
       return view('Vehicle::vehicle-root-list'); 
    }

    // data for list page
    public function getVehicleRootList()
    {
        $vehicles = Vehicle::select(
                    'id',
                    'name',
                    'register_number',
                    'gps_id',
                    'e_sim_number',
                    'vehicle_type_id',
                    'client_id',
                    'deleted_at'
                    )
            ->withTrashed()
            ->with('client:id,name')
            ->with('vehicleType:id,name')
            ->with('gps:id,name,imei')
            ->get();

        return DataTables::of($vehicles)
            ->addIndexColumn()
            ->addColumn('dealer',function($vehicles){
                $vehicle = Vehicle::find($vehicles->id);
                return $vehicle->client->subDealer->dealer->name;
                
            })
            ->addColumn('sub_dealer',function($vehicles){
               $vehicle = Vehicle::find($vehicles->id);
               return $vehicle->client->subDealer->name;
                
            })
            ->make();
    }

    /////////////////////////////Vehicle Dealer List//////////////////////////
    // show list page
    public function vehicleDealerList()
    {
       return view('Vehicle::vehicle-dealer-list'); 
    }

    // data for list page
    public function getVehicleDealerList()
    {
        $dealer_id=\Auth::user()->dealer->id;
        $sub_dealers = SubDealer::select(
                'id'
                )
                ->where('dealer_id',$dealer_id)
                ->get();
        $single_sub_dealers = [];
        foreach($sub_dealers as $sub_dealer){
            $single_sub_dealers[] = $sub_dealer->id;
        }
        $clients = Client::select(
                'id'
                )
                ->whereIn('sub_dealer_id',$single_sub_dealers)
                ->get();
        $single_clients = [];
        foreach($clients as $client){
            $single_clients[] = $client->id;
        }

        $vehicles = Vehicle::select(
                    'id',
                    'name',
                    'register_number',
                    'gps_id',
                    'e_sim_number',
                    'vehicle_type_id',
                    'client_id',
                    'deleted_at'
                    )
            ->withTrashed()
            ->whereIn('client_id',$single_clients)
            ->with('client:id,name')
            ->with('vehicleType:id,name')
            ->with('gps:id,name,imei')
            ->get();

        return DataTables::of($vehicles)
            ->addIndexColumn()
            ->addColumn('sub_dealer',function($vehicles){
               $vehicle = Vehicle::find($vehicles->id);
               return $vehicle->client->subDealer->name;
                
            })
            ->make();
    }

    /////////////////////////////Vehicle Sub Dealer List/////////////////////
    // show list page
    public function vehicleSubDealerList()
    {
       return view('Vehicle::vehicle-sub-dealer-list'); 
    }

    // data for list page
    public function getVehicleSubDealerList()
    {
        $sub_dealer_id=\Auth::user()->subdealer->id;
        $clients = Client::select(
                'id'
                )
                ->where('sub_dealer_id',$sub_dealer_id)
                ->get();
        $single_clients = [];
        foreach($clients as $client){
            $single_clients[] = $client->id;
        }

        $vehicles = Vehicle::select(
                    'id',
                    'name',
                    'register_number',
                    'gps_id',
                    'e_sim_number',
                    'vehicle_type_id',
                    'client_id',
                    'deleted_at'
                    )
            ->withTrashed()
            ->whereIn('client_id',$single_clients)
            ->with('client:id,name')
            ->with('vehicleType:id,name')
            ->with('gps:id,name,imei')
            ->get();

        return DataTables::of($vehicles)
            ->addIndexColumn()
            ->make();
    }

    //////////////////////////////////////RULES/////////////////////////////
    // vehicle create rules
    public function vehicleCreateRules()
    {
        $rules = [
            'name' => 'required',
            'register_number' => 'required|unique:vehicles',
            'vehicle_type_id' => 'required',
            'gps_id' => 'required',
            'e_sim_number' => 'required|numeric'
        ];
        return  $rules;
    }
    // vehicle update rules
    public function vehicleUpdateRules($vehicle)
    {
        $rules = [
            'name' => 'required',
            'register_number' => 'required|unique:vehicles,register_number,'.$vehicle->id,
            'vehicle_type_id' => 'required',
            'gps_id' => 'required',
            'e_sim_number' => 'required|numeric'
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

    // document create rules
    public function documentCreateRules()
    {
        $rules = [
            'vehicle_id' => 'required',
            'document_type_id' => 'required',
            'expiry_date' => 'nullable',
            'path' => 'required'

        ];
        return  $rules;
    }



}
