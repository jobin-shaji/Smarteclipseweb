<?php


namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Ota\Models\OtaResponse;
use App\Modules\Vehicle\Models\VehicleRoute;
use App\Modules\Route\Models\RouteArea;
use App\Modules\Vehicle\Models\DocumentType;
use App\Modules\Vehicle\Models\VehicleDriverLog;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Ota\Models\GpsOta;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Driver\Models\Driver;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsData;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

class VehicleController extends Controller {
    
    // show list page
    public function vehicleList()
    {
        
       return view('Vehicle::vehicle-list'); 
    }
   
    public function getVehicleList()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles = Vehicle::select(
                    'id',
                    'name',
                    'register_number',
                    'gps_id',
                    'e_sim_number',
                    'driver_id',
                    'vehicle_type_id',
                    'deleted_at'
                    )
            ->withTrashed()
            ->where('client_id',$client_id)
            ->with('vehicleType:id,name')
            ->with('driver:id,name')
            ->with('gps:id,name,imei')
            ->get();

        return DataTables::of($vehicles)
            ->addIndexColumn()
            ->addColumn('action', function ($vehicles) {
                if($vehicles->deleted_at == null){
                        return "
                    
                        <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/documents class='btn btn-xs btn-success' data-toggle='tooltip' title='Document'><i class='fa fa-file'></i></a>

                        <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='Edit'><i class='fa fa-edit'></i></a>

                        <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/location class='btn btn-xs btn btn-warning' data-toggle='tooltip' title='Location'><i class='fa fa-map-marker'></i></i></a>


                        <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/playback class='btn btn-xs btn btn-success' data-toggle='tooltip' title='Playback'><i class='fas fa-car'></i></a>


                         <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> </a>

                        <button onclick=deleteVehicle(".$vehicles->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> </button>"; 
                    
                }else{
                     return "<a href=/vehicles/".Crypt::encrypt($vehicles->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='Edit'><i class='fa fa-edit'></i></a>
                    <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view'><i class='fas fa-eye'></i> </a>
                    <button onclick=activateVehicle(".$vehicles->id.",".$vehicles->gps_id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i> </button>"; 
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
        $drivers=Driver::select('id','name')
                ->where('client_id',$client_id)
                ->get();
        $ota_types=OtaType::select('id','name','code','default_value')
                ->get();
        return view('Vehicle::vehicle-add',['vehicleTypes'=>$vehicleTypes,'devices'=>$devices,'ota_types'=>$ota_types,'drivers'=>$drivers]);
    }

    // save vehicle
    public function saveVehicle(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        // dd($request->register_number);
        $rules = $this->vehicleCreateRules();
        $this->validate($request, $rules);
        $vehicle = Vehicle::create([
            'name' => $request->name,
            'register_number' => $request->register_number,
            'vehicle_type_id' => $request->vehicle_type_id,
            'e_sim_number' => $request->e_sim_number,
            'gps_id' => $request->gps_id,
            'driver_id' => $request->driver_id,
            'client_id' =>$client_id,
            'status' =>1
        ]);
        if($vehicle){
            $ota_type__first_id=1;
            foreach ($request->ota as $ota_value) {
                $ota_type_id=$ota_type__first_id++;
                $gps_ota = GpsOta::create([
                    'gps_id' => $request->gps_id,
                    'ota_type_id' => $ota_type_id,
                    'value' => $ota_value
                ]);
            }
        }
        $encrypted_vehicle_id = encrypt($vehicle->id);
        $request->session()->flash('message', 'New Vehicle created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle.documents',$encrypted_vehicle_id));
    }

    // edit vehicle
    public function edit(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $client_id=\Auth::user()->client->id;
        $vehicle = Vehicle::find($decrypted_id);
        if($vehicle == null){
            return view('Vehicle::404');
        }
        $routes=Route::where('client_id',$client_id)
                        ->get();
        $drivers=Driver::select('id','name')
                ->where('client_id',$client_id)
                ->get();
        return view('Vehicle::vehicle-edit',['vehicle' => $vehicle,'routes' => $routes,'drivers' => $drivers]);
    }

    // update vehicle
    public function update(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        $old_driver=$vehicle->driver_id;
        $new_driver_id=$request->driver_id;
        if($vehicle == null){
           return view('Vehicle::404');
        }
        $rules = $this->vehicleUpdateRules($vehicle);
        $this->validate($request, $rules);
        $vehicle->e_sim_number = $request->e_sim_number;
        $vehicle->driver_id = $request->driver_id;
        $vehicle_update=$vehicle->save();
        if($vehicle_update && $request->driver_id){
                $vehicle_driver_log = VehicleDriverLog::create([
                'vehicle_id' => $vehicle->id,
                'from_driver_id' => $old_driver,
                'to_driver_id' => $new_driver_id,
                'client_id' =>$vehicle->client_id
            ]);
        }

        $encrypted_vehicle_id = encrypt($vehicle->id);
        $request->session()->flash('message', 'Vehicle details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle.edit',$encrypted_vehicle_id));  
    }
    // details page
    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle=Vehicle::find($decrypted_id);
        if($vehicle==null){
            return view('Vehicle::404');
        } 
        return view('Vehicle::vehicle-details',['vehicle' => $vehicle]);
    }

    // upload vehicle documents
    public function vehicleDocuments(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle = Vehicle::find($decrypted_id);
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
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle_doc = Document::find($decrypted_id);
        $document_type=DocumentType::select('id','name')->get();
        if($vehicle_doc == null){
            return view('Vehicle::404');
        }
        return view('Vehicle::vehicle-document-edit',['vehicle_doc' => $vehicle_doc,'document_type'=>$document_type]);
    }

    // update vehicle doc
    public function vehicleDocumentUpdate(Request $request)
    {
        $vehicle_doc = Document::find($request->id);
        if($vehicle_doc == null){
           return view('Vehicle::404');
        }
        $rules = $this->documentUpdateRules();
        $this->validate($request, $rules);

        $file=$request->path;
        if($file){
            $old_file = $vehicle_doc->path;
            $myFile = "documents/".$old_file;
            $delete_file=unlink($myFile);
            if($delete_file){
                $getFileExt   = $file->getClientOriginalExtension();
                $uploadedFile =   time().'.'.$getFileExt;
                //Move Uploaded File
                $destinationPath = 'documents';
                $file->move($destinationPath,$uploadedFile);
                $vehicle_doc->path = $uploadedFile;
            }
        }
        
        $vehicle_doc->vehicle_id = $request->vehicle_id;
        $vehicle_doc->document_type_id = $request->document_type_id;
        $vehicle_doc->expiry_date= $request->expiry_date;
        $vehicle_doc->save();

        $encrypted_vehicle_doc_id = encrypt($vehicle_doc->id);
        $request->session()->flash('message', 'Document updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle-doc.edit',$encrypted_vehicle_doc_id));  
    }

    // vehicle doc delete
    public function vehicleDocumentDelete(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle_doc=Document::find($decrypted_id);
        if($vehicle_doc == null){
           return view('Vehicle::404');
        }
        $file=$vehicle_doc->path;
        if($file){
            $old_file = $vehicle_doc->path;
            $myFile = "documents/".$old_file;
            $delete_file=unlink($myFile);
            $vehicle_doc->delete(); 
        }
        $request->session()->flash('message', 'Document deleted successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle')); 
    }

    // Vehicle OTA
    public function vehicleOta(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_id=$decrypted_id;
        $gps_ota=GpsOta::where('gps_id',$decrypted_id)
                                ->get();
        if($gps_ota == null){
            return view('Vehicle::404');
        }
        return view('Vehicle::vehicle-ota',['gps_ota' => $gps_ota,'gps_id' => $gps_id ]);
    }

    // update vehicle ota
    public function updateOta(Request $request)
    {
        $ota_type__first_id=1;
        $gps_id=$request->id;
        $ota_array=[];
        foreach ($request->ota as $ota_value) {
            $ota_type_id=$ota_type__first_id++;
            $gps_ota = GpsOta::select('id','gps_id','ota_type_id','value')
                            ->where('gps_id',$gps_id)
                            ->where('ota_type_id',$ota_type_id)
                            ->first();
            if($gps_ota->value != $ota_value){
                $ota_type=OtaType::select('id','name','code','default_value')
                                    ->where('id',$ota_type_id)
                                    ->first();
                $string=$ota_type->code.":".$ota_value;
                array_push($ota_array,$string);
            }
            $gps_ota->value = $ota_value;
            $gps_ota->save();
        }
        $ota_string = implode( ",", $ota_array );
        $final_ota_string="SET ".$ota_string;
        if($ota_string){
            //add response to ota response table-start
            $ota = new OtaResponse();
            $ota->gps_id = $gps_id;
            $ota->response = $final_ota_string;
            $ota->created_at = now();
            $ota->updated_at = null;
            $ota->save();
            //add response to ota response table-end 
        }
        
        $request->session()->flash('message', 'OTA details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle'));  
    }

    // save vehicle route
    public function saveVehicleRoute(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $rules = $this->vehicleRouteCreateRules();
        $this->validate($request, $rules);
        $vehicle_route = VehicleRoute::create([
            'vehicle_id' => $request->vehicle_id,
            'route_id' => $request->route_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'client_id' => $client_id,
            'status' =>1,
        ]);
        $request->session()->flash('message', 'Vehicle Route scheduled successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 

        return redirect(route('vehicle.edit',Crypt::encrypt($vehicle_route->vehicle_id)));
    }

    // edit vehicle route
    public function editVehicleRoute(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $client_id=\Auth::user()->client->id;
        $vehicle_route = VehicleRoute::find($decrypted_id);
        if($vehicle_route == null){
            return view('Vehicle::404');
        }
        $routes=Route::where('client_id',$client_id)
                        ->get();
        return view('Vehicle::vehicle-route-edit',['vehicle_route' => $vehicle_route,'routes' => $routes]);
    }

    // update vehicle route
    public function updateVehicleRoute(Request $request)
    {
        $vehicle_route = VehicleRoute::find($request->id);
        if($vehicle_route == null){
           return view('Vehicle::404');
        }
        $rules = $this->vehicleRouteUpdateRules();
        $this->validate($request, $rules);

        $vehicle_route->route_id = $request->route_id;
        $vehicle_route->date_from = $request->date_from;
        $vehicle_route->date_to = $request->date_to;
        $vehicle_route->save();

        $encrypted_vehicle_route_id = encrypt($vehicle_route->id);
        $request->session()->flash('message', 'Vehicle route details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle-route.edit',$encrypted_vehicle_route_id));  
    }

    // view page
    public function viewVehicleRoute(Request $request)
    {
        $decrypted_route_id = Crypt::decrypt($request->id);
        $route=Route::find($decrypted_route_id);
        if($route==null){
            return view('Route::404');
        } 
        $route_area=RouteArea::select('route_id','latitude','longitude')
                                        ->where('route_id',$decrypted_route_id)
                                        ->get();
        return view('Route::route-details',['route' => $route,'route_area' => $route_area]);
    }

    // update vehicle route
    public function deleteVehicleRoute(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle_route = VehicleRoute::find($decrypted_id);
        if($vehicle_route == null){
           return view('Vehicle::404');
        }
        $vehicle_route->delete();

        $encrypted_vehicle_route_id = encrypt($vehicle_route->id);
        $request->session()->flash('message', 'Vehicle Route deleted successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle.edit',Crypt::encrypt($vehicle_route->vehicle_id)));
    }
    
    // vehicle delete
    public function deleteVehicle(Request $request)
    {
        $vehicle=Vehicle::find($request->vid);
        if($vehicle == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Vehicle does not exist'
            ]);
        }
        $vehicle->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Vehicle deleted successfully'
        ]);
     }


    // restore vehicle
    public function activateVehicle(Request $request)
    {       
        $vehicles = Vehicle::where('gps_id', $request->gps_id)->first();        
        if($vehicles== null)
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
        return response()->json([
            'status' => 0,
            'title' => 'Error',
            'message' => 'gps already asigned'
        ]);
    }

    // vehicle drivers list
    public function vehicleDriverLogList()
    {
        
       return view('Vehicle::vehicle-driver-log-list'); 
    }

    // vehicle drivers list data
    public function getVehicleDriverLogList()
    {
        $client_id=\Auth::user()->client->id;
        $vehicle_driver_log = VehicleDriverLog::select(
                                'vehicle_id',
                                'from_driver_id',
                                'to_driver_id',
                                'created_at'
                                )
                                ->where('client_id',$client_id)
                                ->with('Fromdriver:id,name')
                                ->with('Todriver:id,name')
                                ->with('vehicle:id,name,register_number')
                                ->get();

        return DataTables::of($vehicle_driver_log)
            ->addIndexColumn()
            ->make();
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
                    'name',
                    'vehicle_scale',
                    'opacity',
                    'strokeWeight'
                    )
                ->get();

        return DataTables::of($vehicle_type)
            ->addIndexColumn()
            ->addColumn('action', function ($vehicle_type) {
                return "<a href=/vehicle-type/".Crypt::encrypt($vehicle_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/vehicle-type/".Crypt::encrypt($vehicle_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
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
            'svg_icon' => $request->svg_icon,
            'vehicle_scale' => $request->scale,
            'opacity' => $request->opacity,
            'strokeWeight' => $request->weight,
            'status' =>1,
           ]);
        $request->session()->flash('message', 'New Vehicle type created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 

        return redirect(route('vehicle_type.details',Crypt::encrypt($vehicle_type->id)));
    }

    // vehicle type details
    public function detailsVehicleType(Request $request)
     {
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle_type=VehicleType::find($decrypted_id);
        if($vehicle_type==null){
            return view('Vehicle::404');
        } 
        return view('Vehicle::vehicle-type-details',['vehicle_type' => $vehicle_type]);
     }
    // edit vehicle type
    public function editVehicleType(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle_type = VehicleType::find($decrypted_id);
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
        $vehicle_type->svg_icon = $request->svg_icon;

        $vehicle_type->vehicle_scale = $request->scale;
        $vehicle_type->opacity = $request->opacity;
        $vehicle_type->strokeWeight = $request->weight;

        $vehicle_type->save();

        $encrypted_vehicle_type_id = encrypt($vehicle_type->id);
        $request->session()->flash('message', 'Vehicle type details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle-type.edit',$encrypted_vehicle_type_id));  
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
            ->addColumn('action', function ($vehicles) {
                $gps_id=$vehicles->gps_id;
                if($vehicles->deleted_at == null){
                    $gps_data_count = GpsData::where('gps_id',$gps_id)->count('id');
                    if($gps_data_count!=0){
                        return "
                        <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/location class='btn btn-xs btn btn-warning'><i class='glyphicon glyphicon-map-marker'></i>Track</a>"; 
                    }
                }else{
                     return ""; 
                }
            })
            ->rawColumns(['link', 'action'])
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
            ->addColumn('action', function ($vehicles) {
                $gps_id=$vehicles->gps_id;
                if($vehicles->deleted_at == null){
                    $gps_data_count = GpsData::where('gps_id',$gps_id)->count('id');
                    if($gps_data_count!=0){
                        return "
                        <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/location class='btn btn-xs btn btn-warning'><i class='glyphicon glyphicon-map-marker'></i>Track</a>"; 
                    }
                }else{
                     return ""; 
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }
    /////////////////////////////Vehicle Tracker/////////////////////////////
    public function location(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);
        $get_vehicle=Vehicle::find($decrypted_id);
        $vehicle_type=VehicleType::find($get_vehicle->vehicle_type_id);  
        $track_data=Gps::select('lat as latitude',
                              'lon as longitude'
                              )         
                              ->where('id',$get_vehicle->gps_id)
                              ->first();   
        if($track_data==null)
        {
            return view('Vehicle::location-error');
        }
        else if($track_data->latitude==null || $track_data->longitude==null)
        {
            return view('Vehicle::location-error');
        }
        else
        {
            $latitude=$track_data->latitude;
            $longitude= $track_data->longitude;
        }
        return view('Vehicle::vehicle-tracker',['Vehicle_id' => $decrypted_id,'vehicle_type' => $vehicle_type,'latitude' => $latitude,'longitude' => $longitude] );
    }
    public function locationTrack(Request $request)
    {
        $get_vehicle=Vehicle::find($request->id);
        $currentDateTime=Date('Y-m-d H:i:s');
        $oneMinut_currentDateTime=date('Y-m-d H:i:s',strtotime("-2 minutes"));
        $offline="Offline";
        $track_data=Gps::select('lat as latitude',
                      'lon as longitude',
                      'heading as angle',
                      'mode as vehicleStatus',
                      'speed',
                      'device_time as dateTime',
                      'main_power_status as power',
                      'ignition as ign',
                      'gsm_signal_strength as signalStrength'
                      )
                    ->where('device_time', '>=',$oneMinut_currentDateTime)
                    ->where('device_time', '<=',$currentDateTime)
                    ->where('id',$get_vehicle->gps_id)
                    ->first();
        $minutes=0;
        if($track_data == null){
            $track_data = Gps::select('lat as latitude',
                              'lon as longitude',
                              'heading as angle',
                              'speed',
                              'device_time as dateTime',
                              'main_power_status as power',
                              'ignition as ign',
                              'gsm_signal_strength as signalStrength',
                              \DB::raw("'$offline' as vehicleStatus")
                              )
                              ->where('id',$get_vehicle->gps_id)
                              ->first();
            $minutes   = Carbon::createFromTimeStamp(strtotime($track_data->dateTime))->diffForHumans();
        }

        if($track_data){

            $plcaeName=$this->getPlacenameFromLatLng($track_data->latitude,$track_data->longitude);
            $snapRoute=$this->LiveSnapRoot($track_data->latitude,$track_data->longitude);
            $reponseData=array(
                        "latitude"=>$snapRoute['lat'],
                        "longitude"=>$snapRoute['lng'],
                        "angle"=>$track_data->angle,
                        "vehicleStatus"=>$track_data->vehicleStatus,
                        "speed"=>$track_data->speed,
                        "dateTime"=>$track_data->dateTime,
                        "power"=>$track_data->power,
                        "ign"=>$track_data->ign,
                        "signalStrength"=>$track_data->signalStrength,
                        "last_seen"=>$minutes,
                        "fuel"=>"",
                        "ac"=>"",
                        "place"=>$plcaeName,
                        "fuelquantity"=>""
                      );


            $response_data = array('status'  => 'success',
                           'message' => 'success',
                           'code'    =>1,
                           'vehicle_type' => $get_vehicle->vehicleType->name,
                           'client_name' => $get_vehicle->client->name,
                           'vehicle_reg' => $get_vehicle->register_number,
                           'vehicle_name' => $get_vehicle->name,
                           'liveData' => $reponseData
                            );

        }else{
            $response_data = array('status'  => 'failed',
                           'message' => 'failed',
                            'code'    =>0);
        }
             // dd($response_data['liveData']['ign']);
        return response()->json($response_data); 
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
            ->addColumn('action', function ($vehicles) {
                $gps_id=$vehicles->gps_id;
                if($vehicles->deleted_at == null){
                    $gps_data_count = GpsData::where('gps_id',$gps_id)->count('id');
                    if($gps_data_count!=0){
                        return "
                        <a href=/vehicles/".Crypt::encrypt($vehicles->id)."/location class='btn btn-xs btn btn-warning'><i class='glyphicon glyphicon-map-marker'></i>Track</a>"; 
                    }
                }else{
                     return ""; 
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

     /////////////////////////////Vehicle Tracker/////////////////////////////
    public function playback(Request $request){
       
         $decrypted_id = Crypt::decrypt($request->id);  
          
        return view('Vehicle::vehicle-playback',['Vehicle_id' => $decrypted_id] );
       
    }
    public function playbackHMap(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);            
        return view('Vehicle::vehicle-playback-hmap',['Vehicle_id' => $decrypted_id] );
    }
    // public function locationPlayback(Request $request){
    //     $gpsdata=GpsData::Select(
    //         'latitude as lat',
    //         'longitude as lng', 
    //         'heading as angle',
    //         'speed'       
    //     )
    //     ->where('device_time', '>=',$request->from_time)
    //     ->where('device_time', '<=',$request->to_time)
    //     ->where('vehicle_id',$request->id)                
    //     ->get();    
    //     $playback=array();
    //     $gps_playback=array();
    //     if($gpsdata){
    //         foreach ($gpsdata as $data) {
    //             $playback[]=array(
    //                 "lat"=>(float)$data->lat,
    //                 "lng"=>(float)$data->lng
    //             ); 
    //             $gps_playback[]=array(
    //                 "angle"=>$data->angle,
    //                 "speed"=>$data->speed
    //             );            
    //         }
    //         $response_data = array(
    //             'status'  => 'success',
    //             'message' => 'success',
    //             'code'    =>1,                              
    //             'polyline' => $playback,
    //             'marker' => $gps_playback
    //         );
    //     }else{
    //         $response_data = array(
    //             'status'  => 'failed',
    //             'message' => 'failed',
    //             'code'    =>0
    //         );
    //     }
    //     return response()->json($response_data); 
    // }


    public function locationPlayback(Request $request){
 
     $gpsdata=GpsData::Select(
            'latitude as lat',
            'longitude as lng', 
            'heading as angle',
            'ignition as ign',
            'device_time as datetime',
            'speed'       
        )
        ->where('device_time', '>=',$request->from_time)
        ->where('device_time', '<=',$request->to_time)
        ->where('vehicle_id',$request->id)                
        ->get();    
        $playback=array();
       $playbackData=array();
        if($gpsdata){
            foreach ($gpsdata as $data) {

                if($data->ign==1){
                    $ignitionData="ON";
                }else{
                    $ignitionData="Off";
                }
                $playback[]=array(
                    "lat"=>(float)$data->lat,
                    "lng"=>(float)$data->lng
                    // "Speed"=>$data->speed,
                    //  "Ignition"=>$ignitionData,
                    // "DateTime"=>$data->datetime
                ); 
                
            }
        }
         $gpsvdata=GpsData::Select(
            'latitude as lat',
            'longitude as lng', 
            'heading as angle',
            'ignition as ign',
            'device_time as datetime',
            'speed'       
        )
        ->where('device_time', '>=',$request->from_time)
        ->where('device_time', '<=',$request->to_time)
        ->where('vehicle_id',$request->id) 
        // ->orderBy('id','desc')               
        ->get(); 
        if($gpsvdata)
        {


            $vstartLat=(float)$gpsvdata[0]->lat;
            $vstartLng=(float)$gpsvdata[0]->lng;
            foreach ($gpsvdata as $vdata) {
            $vlat=(float)$vdata->lat;
            $vlng=(float)$vdata->lat;
            $caluculate_distance_between_latlng=$this->distanceCalculation($vlat,$vlng,$vstartLat,$vstartLat);
            // dd(MARKER_SELECT_POINT_DISTANCE);
              // if($caluculate_distance_between_latlng >= MARKER_SELECT_POINT_DISTANCE){
                $vehicle_status="Running";
                if($vdata->ign==1){
                    $ignitionData="ON";
                }else{
                    $ignitionData="Off";
                }
                $playbackData[]=array(
                    
                    "lat"=>(float)$vdata->lat,
                    "lng"=>(float)$vdata->lng,
                    "angle"=>$vdata->angle,
                    "Speed"=>$vdata->speed,
                    "DateTime"=>$vdata->datetime,
                    "Ignition"=>$ignitionData
                ); 
                $startLat=(float)$vdata->lat;
                $startLng=(float)$vdata->lng;
            // }
            }           
            $response_data = array(
                'status'  => 'success',
                'message' => 'success',
                'code'    =>1,                              
                'polyline' => $playback,
                'markers' => $playbackData,
                
            );
        }else{
            $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'code'    =>0
            );
        }

    
    return response()->json($response_data); 
}







    public function hmapLocationPlayback(Request $request)
    { 
        $gpsdata=GpsData::Select(
            'latitude as lat',
            'longitude as lng', 
            'heading as angle',
            'ignition as ign',
            'device_time as datetime',
            'speed',
            'time'       
        )
        ->where('device_time', '>=',$request->from_time)
        ->where('device_time', '<=',$request->to_time)
        ->where('vehicle_id',$request->id)                
        ->get();
        $playback=array();
        $playback_point= array();
        $playback_round=array();
        $playbackData=array();
        $length=0;
        $counts=0;
        $count=0;       
        if($gpsdata){
            $length=$gpsdata->count(); 
            if($length!=0)
            {   
                // $counts=$length;            
                if($length>=150)
                {
                    $counts=$length/90;                    
                }
                else
                {
                    $counts=$length;
                }                               
                $round_value=round($counts);             
                $startLat=(float)$gpsdata[0]->lat;
                $startLng=(float)$gpsdata[0]->lng; 
                for($i=0;$i<$round_value; $i++)
                {                
                    $playback_round[]=$gpsdata[$i];
                } 
                $playback_point[]=array(
                    "lat"=>(float)$gpsdata[0]->lat,
                    "lng"=>(float)$gpsdata[0]->lng                    
                );    
                // dd($playback_round);
                foreach ($playback_round as $data) {
                    // dd($data->lat);
                    $playback[]=array(
                        "lat"=>(float)$data->lat,
                        "lng"=>(float)$data->lng ,
                        "speed"=>(float)$data->speed, 
                        "datetime"=>$data->datetime,                    
                    );                   
                    $startLat=(float)$data->lat;
                    $startLng=(float)$data->lng; 
                }
            }
            else
            {
                $playback="empty";
            }
            // dd($playback);
            $response_data = array(
                'status'  => 'success',
                'message' => 'success',
                'code'    =>1,                              
                'polyline' => $playback,
                'firstpoint' => $playback_point,
            );
        }
        else
        {
            $response_data = array(
                'status'  => 'failed',
                'message' => 'failed',
                'polyline' => "empty",
                'code'    =>0
            );
        }    
        return response()->json($response_data); 
    }
public function playBackForLine($vehicleID,$fromDate,$toDate){

    $playBackDataList=array();
    $playback=array();

    $gpsdata=GpsData::Select(
            'latitude as lat',
            'longitude as lng', 
            'heading as angle',
            'gps_fix as gps',
            'ignition as ign',
            'speed'       
        )
        // ->where('device_time', '>=',$fromDate)
        // ->where('device_time', '<=',$toDate)
        ->where('created_at', '>=',$fromDate)
        ->where('created_at', '<=',$toDate)
        ->where('gps_fix',1)

        ->where('vehicle_id',$vehicleID)                
        ->get(); 
        $startLat=(float)$gpsdata[0]->lat;
    $startLng=(float)$gpsdata[0]->lng;
    if($gpsdata){
        foreach ($gpsdata as $data) {
                $playback[]=array(
                    "lat"=>(float)$data->lat,
                    "lng"=>(float)$data->lng
                ); 
        }
             $response_data = array(
                'status'  => 'success',
                'message' => 'success',
                'code'    =>1,                              
                'polyline' => $playback
                
            );
    }
    return response()->json($response_data); 
     // return json_encode($playback);
       // return response()->json($playback); 
   }

    public function playBackForMark_Route($vehicleID,$fromDate,$toDate){
        $playBackDataList=array();
        $playback = array();   
        $gpsdata=GpsData::Select(
            'latitude as lat',
            'longitude as lng', 
            'heading as angle',
            'speed',                 
            'main_power_status as power',
            'gps_fix as gps',
            'ignition as ign',
            'gsm_signal_strength as signalStrength'
        )
        ->where('device_time', '>=',$fromDate)
        ->where('device_time', '<=',$toDate)
        ->where('vehicle_id',$vehicleID)                
        ->get(); 
    $vehicle_status="Running";    
    $startLat=(float)$gpsdata[0]->lat;
    $startLng=(float)$gpsdata[0]->lng;
   
    if($gpsdata)
    {
        foreach ($gpsdata as $vdata) {
            $lat=(float)$vdata->lat;
            $lng=(float)$vdata->lat;
            $caluculate_distance_between_latlng=$this->distanceCalculation($lat,$lng,$startLat,$startLng);
            // dd($caluculate_distance_between_latlng);
            // if($caluculate_distance_between_latlng >= MARKER_SELECT_POINT_DISTANCE){
            $vehicle_status="Running";
            if($vdata->ign==1){
                $ignitionData="ON";
            }else{
                $ignitionData="Off";
            }
           
            $playback[]=array(
                "lat"=>$startLat,
                "lng"=>$startLng,
                "angle"=>$vdata->angle,
                "Speed"=>$vdata->speed,
                "Ignition"=>$ignitionData
            ); 
            $startLat=$vdata->lat;
            $startLng=$vdata->lng;
        // }
        }
    }
    return json_encode($playback);
    }
    function distanceCalculation($lat1, $lon1, $lat2, $lon2) {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      return ($miles * 1.609344);
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
            'driver_id' => 'required',
            'e_sim_number' => 'required|numeric'
        ];
        return  $rules;
    }
    // vehicle update rules
    public function vehicleUpdateRules($vehicle)
    {
        $rules = [
            'e_sim_number' => 'required|numeric',
            'driver_id' => 'required',
        ];
        return  $rules;  
    }

    // vehicle route create rules
    public function vehicleRouteCreateRules()
    {
        $rules = [
            'vehicle_id' => 'required',
            'route_id' => 'required',
            'date_from' => 'required',
            'date_to' => 'required'
        ];
        return  $rules;
    }

    // vehicle route update rules
    public function vehicleRouteUpdateRules()
    {
        $rules = [
            'route_id' => 'required',
            'date_from' => 'required',
            'date_to' => 'required'
        ];
        return  $rules;
    }

    // vehicle type create rules
    public function vehicleTypeCreateRules()
    {
        $rules = [
            'name' => 'required',
            'svg_icon' => 'required',
            'weight' => 'required',
            'scale' => 'required',
            'opacity' => 'required'
        ];
        return  $rules;
    }
    // vehicle update rules
    public function vehicleTypeUpdateRules()
    {
        $rules = [
            'name' => 'required',
            'svg_icon' => 'required',
            'weight' => 'required',
            'scale' => 'required',
            'opacity' => 'required'
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

    // document update rules
    public function documentUpdateRules()
    {
        $rules = [
            'vehicle_id' => 'required',
            'document_type_id' => 'required',
            'expiry_date' => 'nullable'

        ];
        return  $rules;
    }
// --------------------------------------------------------------------------------
    function getPlacenameFromLatLng($latitude,$longitude){
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyCAcRaVEtvX5mdlFqLafvVd20LIZbPKNw4'); 
            $output = json_decode($geocodeFromLatLong);
         
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude
            if(!empty($address)){
                return $address;
            }else{
                return false;
            }
        }else{
            return false;   
        }
    }
/////////////// snap root for live data///////////////////////////////////
    function LiveSnapRoot($b_lat, $b_lng) {
        $lat = $b_lat;
        $lng = $b_lng;
        $route = $lat . "," . $lng;
        $url = "https://roads.googleapis.com/v1/snapToRoads?path=" . $route . "&interpolate=true&key=AIzaSyCAcRaVEtvX5mdlFqLafvVd20LIZbPKNw4";
        $geocode_stats = file_get_contents($url);
        $output_deals = json_decode($geocode_stats);
        if (isset($output_deals->snappedPoints)) {
            $outPut_snap = $output_deals->snappedPoints;
            // var_dump($output_deals);
            if ($outPut_snap) {
                foreach ($outPut_snap as $ldata) {
                    $lat = $ldata->location->latitude;
                    $lng = $ldata->location->longitude;
                }
            }
        }
        $userData = ["lat" => $lat, "lng" => $lng];
        return $userData;

    }
/////////////// snap root for live data///////////////////////////////////

}
