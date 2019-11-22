<?php

namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\User\Models\User;
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
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Servicer\Models\ServicerJob;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\VehicleDataProcessorTrait;
use Carbon\Carbon;
use PDF;
use DataTables;
use Config;

class VehicleController extends Controller 
{
    use VehicleDataProcessorTrait;
    
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
                    'driver_id',
                    'vehicle_type_id',
                    'deleted_at'
                    )
            ->withTrashed()
            ->where('client_id',$client_id)
            ->with('vehicleType:id,name')
            ->with('driver:id,name')
            ->with('gps:id,imei,serial_no')
            ->get();
            return DataTables::of($vehicles)
            ->addIndexColumn()
             ->addColumn('driver', function ($vehicles) {
                if($vehicles->driver_id== null || $vehicles->driver_id==0)
                {
                    return "Not assigned";
                }
                else
                {
                  return $vehicles->driver->name;
                 
                }
            })
            ->addColumn('action', function ($vehicles) {
                $b_url = \URL::to('/');
                if($vehicles->deleted_at == null){
                        return "

                        <a href=".$b_url."/vehicles/".Crypt::encrypt($vehicles->id)."/location class='btn btn-xs btn btn-warning' data-toggle='tooltip' title='Location'><i class='fa fa-map-marker'></i> Track</i></a>

                         <a href=".$b_url."/vehicles/".Crypt::encrypt($vehicles->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'>View/Edit</i> </a>"


                         ; 
                    
                }else{
                     return ""; 
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
        $devices=Gps::select('id','imei')
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
        return redirect(route('vehicles.details',$encrypted_vehicle_id));
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
        $vehicle->driver_id = $request->driver_id;
        $vehicle_update=$vehicle->save();
        if($vehicle_update && $new_driver_id && $old_driver){
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
        $user=\Auth::user();
        $user_role=$user->roles->first()->name;
        if($user_role=='client')
        {
            return redirect(route('vehicles.details',$encrypted_vehicle_id));
        }
        else
        {
            return redirect(route('servicer-vehicles.details',$encrypted_vehicle_id));
        }
        // return redirect(route('vehicles.details',$encrypted_vehicle_id));  
    }

    public function odometerUpdate(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        $encrypted_gps_id = encrypt($request->id);
        $gps = Gps::find($vehicle->gps_id);
        if($gps == null){
           return view('Vehicle::404');
        }
        $rules = $this->vehicleOdometerUpdateRules($gps);
        $this->validate($request, $rules);
        $gps->km = $request->odometer;
        $gps->save();        
        $request->session()->flash('message', 'Vehicle odometer updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicles.details',$encrypted_gps_id));
     }
    // details page
    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $client_id=\Auth::user()->client->id;
        $vehicle = Vehicle::find($decrypted_id);
        if($vehicle == null){
            return view('Vehicle::404');
        }
        $drivers=Driver::select('id','name')
                ->where('client_id',$client_id)
                ->get();
        $docTypes=DocumentType::select(
                'id','name')->whereIn('id',[2,3,4,5])->get();
        $vehicleDocs=Document::select(
                'id','vehicle_id','document_type_id','expiry_date','path')
                ->where('vehicle_id',$vehicle->id)
                ->with('documentType:id,name')
                ->get();
        return view('Vehicle::vehicle-details',['vehicle' => $vehicle,'drivers' => $drivers,'docTypes'=>$docTypes,'vehicleDocs'=>$vehicleDocs]);
    }

    //for dependent dropdown doc add
    public function findDateFieldWithDocTypeID(Request $request)
    {   
        $docTypeID=$request->docTypeID;
        return response()->json($docTypeID);
    }

    // save documents
    public function saveDocuments(Request $request)
    {
        $custom_messages = [
        'path.required' => 'File cannot be blank'
        ];
        if($request->document_type_id == 1 || $request->document_type_id == 6 || $request->document_type_id == 7 || $request->document_type_id == 8){
            $rules = $this->documentCreateRules();
            $expiry_date=null;
        }else{
            $rules = $this->customDocCreateRules();
            $expiry_date=date("Y-m-d", strtotime($request->expiry_date));
        }
     
        $this->validate($request, $rules, $custom_messages);
        $file=$request->path;
        $getFileExt   = $file->getClientOriginalExtension();
        $uploadedFile =   time().'.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $file->move($destinationPath,$uploadedFile);
        $documents = Document::create([
            'vehicle_id' => $request->vehicle_id,
            'document_type_id' => $request->document_type_id,
            'expiry_date' => $expiry_date,
            'path' => $uploadedFile,
        ]);
        $encrypted_vehicle_id = encrypt($request->vehicle_id);
        $request->session()->flash('message', 'Document stored successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        $user=\Auth::user();
        $user_role=$user->roles->first()->name;
        if($user_role=='client')
        {
            return redirect(route('vehicles.details',$encrypted_vehicle_id));
        }
        else
        {
            return redirect(route('servicer-vehicles.details',$encrypted_vehicle_id));
        }
       
    }

    // edit vehicle doc
    public function vehicleDocumentEdit(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle_doc = Document::find($decrypted_id);
        return view('Vehicle::vehicle-document-edit',['vehicle_doc' => $vehicle_doc]);
    }

    // update vehicle doc
    public function vehicleDocumentUpdate(Request $request)
    {
        $vehicle_doc = Document::find($request->id);
        if($vehicle_doc == null){
           return view('Vehicle::404');
        }
        $rules = $this->documentUpdateRules();
        $custom_messages = [
        'path.required' => 'File cannot be blank'
        ];
        $this->validate($request, $rules,$custom_messages);
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
        $vehicle_doc->expiry_date= date("Y-m-d", strtotime($request->expiry_date));
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
            // $old_file = $vehicle_doc->path;
            // $myFile = "documents/".$old_file;
            // $delete_file=unlink($myFile);
            $vehicle_doc->delete(); 
        }
        $encrypted_vehicle_id = encrypt($vehicle_doc->vehicle_id);
        $request->session()->flash('message', 'Document deleted successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        $user=\Auth::user();
        $user_role=$user->roles->first()->name;
        if($user_role=='client')
        {
            return redirect(route('vehicles.details',$encrypted_vehicle_id));
        }
        else
        {
            return redirect(route('servicer-vehicles.details',$encrypted_vehicle_id));
        }
         
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
            'message' => 'Vehicle deactivated successfully'
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
                'message' => 'Vehicle activated successfully'
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
            'client_id',
            'created_at'
        )
        ->where('client_id',$client_id)
        ->with('Fromdriver:id,name')
        ->with('Todriver:id,name')
        ->with('vehicle:id,name,register_number')        
        ->get();
// dd($vehicle_driver_log);
        return DataTables::of($vehicle_driver_log)
            ->addIndexColumn()
           ->rawColumns(['link'])
            ->make();
    }

    // vehicle documents list
    public function allVehicleDocList()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
                            ->where('client_id',$client_id)
                            ->get();
        return view('Vehicle::all-vehicle-doc-list',['vehicles'=>$vehicles]); 
    }

    // vehicle documents list data
    public function getAllVehicleDocList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $selected_vehicle_id= $request->vehicle_id; 
        $selected_status= $request->status; 
        $vehicles=Vehicle::select('id','name','register_number','client_id')
                            ->where('client_id',$client_id)
                            ->get();
        $vehicle_id=[];
        foreach ($vehicles as $vehicle) {
            $vehicle_id[]=$vehicle->id;
        }
        $vehicle_documents = Document::select(
        'vehicle_id',
        'document_type_id',
        'expiry_date',
        'path'
        )
        ->with('documentType:id,name')
        ->with('vehicle:id,name,register_number');
        if($selected_vehicle_id==null && $selected_status==null)
        { 
           $vehicle_documents =$vehicle_documents->whereIn('vehicle_id',$vehicle_id);
        }
        else if($selected_status=="valid"){
            $vehicle_documents =$vehicle_documents->where('vehicle_id',$selected_vehicle_id)
            ->where(function ($vehicle_documents) {
                $vehicle_documents->whereDate('expiry_date', '>', date('Y-m-d'))
                ->orWhereNull('expiry_date');
            });
        }
        else if($selected_status=="expiring"){
            $vehicle_documents =$vehicle_documents->where('vehicle_id',$selected_vehicle_id)
            ->whereBetween('expiry_date', [date('Y-m-d'), date('Y-m-d', strtotime("+30 days"))]);
        }
        else if($selected_status=="expired"){
            $vehicle_documents =$vehicle_documents->where('vehicle_id',$selected_vehicle_id)
            ->whereDate('expiry_date', '<', date('Y-m-d'));
        }
        else
        {
            $vehicle_documents =$vehicle_documents->where('vehicle_id',$selected_vehicle_id);
        } 
        $vehicle_documents =$vehicle_documents->get();

        return DataTables::of($vehicle_documents)
            ->addIndexColumn()
            ->addColumn('status', function ($vehicle_documents) {
                $current_date=date('Y-m-d');
                $next_month_of_current_date=date('Y-m-d', strtotime("+30 days"));
                $expiry_date=$vehicle_documents->expiry_date;
                if($expiry_date==null){
                    return "<b style='color:#008000';>Valid</b>";
                }else if($expiry_date < $current_date){
                    return "<b style='color:#FF0000';>Expired</b>";
                }else if($expiry_date >= $current_date && $expiry_date <= $next_month_of_current_date){
                    return "<b style='color:#FF8000';>Expiring</b>";
                }else{
                    return "<b style='color:#008000';>Valid</b>";
                }
             })
            ->addColumn('action', function ($vehicle_documents) {
                $b_url = \URL::to('/');
                $path = url($b_url.'/documents').'/'.$vehicle_documents->path;
                return "<a href= ".$path." download='".$vehicle_documents->path."' class='btn btn-xs btn-success'  data-toggle='tooltip'><i class='fa fa-download'></i> Download </a>";
             })
            ->rawColumns(['link', 'action','status'])
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
                $b_url = \URL::to('/');
                return "<a href=".$b_url."/vehicle-type/".Crypt::encrypt($vehicle_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=".$b_url."/vehicle-type/".Crypt::encrypt($vehicle_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
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

        // online vehicle image
        $online_vehicle=$request->online_icon;
        if($online_vehicle){
        $getFileExt   = $online_vehicle->getClientOriginalExtension();
        $online_uploadedFile =   time().'_online_vehicle.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $online_vehicle->move($destinationPath,$online_uploadedFile);
        }
        // online vehicle image
        // offline vehicle image
        $offline_vehicle=$request->offline_icon;
        if($offline_vehicle){
        $getFileExt   = $offline_vehicle->getClientOriginalExtension();
        $offline_uploadedFile =   time().'_offline_vehicle.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $offline_vehicle->move($destinationPath,$offline_uploadedFile);
        }
        // online vehicle image
         // ideal vehicle image
        $ideal_vehicle=$request->ideal_icon;
        if($ideal_vehicle){
        $getFileExt   = $ideal_vehicle->getClientOriginalExtension();
        $ideal_uploadedFile =   time().'_ideal_icon.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $ideal_vehicle->move($destinationPath,$ideal_uploadedFile);
        }
        // ideal vehicle image
        // sleep vehicle image
        $sleep_vehicle=$request->sleep_icon;
        if($sleep_vehicle){
        $getFileExt   = $sleep_vehicle->getClientOriginalExtension();
        $sleep_uploadedFile =   time().'_sleep_icon.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $sleep_vehicle->move($destinationPath,$sleep_uploadedFile);
        // sleep vehicle image
        }
        // sleep vehicle image
        $vehicle_type = VehicleType::create([
            'name' => $request->name,
            'svg_icon' => $request->svg_icon,
            'vehicle_scale' => $request->scale,
            'opacity' => $request->opacity,
            'strokeWeight' => $request->weight,
            'online_icon'=>$online_uploadedFile,
            'offline_icon'=>$offline_uploadedFile,
            'ideal_icon'=>$ideal_uploadedFile,
            'sleep_icon'=>$sleep_uploadedFile,
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

        $online_vehicle=$request->online_icon;
        if($online_vehicle){
        $getFileExt   = $online_vehicle->getClientOriginalExtension();
        $online_uploadedFile =   time().'_online_vehicle.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $online_vehicle->move($destinationPath,$online_uploadedFile);
        $vehicle_type->online_icon = $online_uploadedFile;
        }
        // online vehicle image
         // offline vehicle image
        $offline_vehicle=$request->offline_icon;
        if($offline_vehicle){
        $getFileExt   = $offline_vehicle->getClientOriginalExtension();
        $offline_uploadedFile =   time().'_offline_vehicle.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $offline_vehicle->move($destinationPath,$offline_uploadedFile);
        $vehicle_type->offline_icon = $offline_uploadedFile;
        }
        // online vehicle image
         // ideal vehicle image
        $ideal_vehicle=$request->ideal_icon;
        if($ideal_vehicle){
        $getFileExt   = $ideal_vehicle->getClientOriginalExtension();
        $ideal_uploadedFile =   time().'_ideal_icon.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $ideal_vehicle->move($destinationPath,$ideal_uploadedFile);
        $vehicle_type->ideal_icon = $ideal_uploadedFile;
        }
        // ideal vehicle image
        // sleep vehicle image
        $sleep_vehicle=$request->sleep_icon;
        if($sleep_vehicle){
        $getFileExt   = $sleep_vehicle->getClientOriginalExtension();
        $sleep_uploadedFile =   time().'_sleep_icon.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $sleep_vehicle->move($destinationPath,$sleep_uploadedFile);
        // sleep vehicle image
        $vehicle_type->sleep_icon =$sleep_uploadedFile;
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
                'vehicle_type_id',
                'client_id',
                'deleted_at'
            )
            ->with('client:id,name')
            ->with('vehicleType:id,name')
            ->with('gps:id,imei,serial_no')
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
                $b_url = \URL::to('/');
                if($vehicles->deleted_at == null){
                        return "
                        <a href=".$b_url."/vehicles/".Crypt::encrypt($vehicles->id)."/location class='btn btn-xs btn btn-warning'><i class='glyphicon glyphicon-map-marker'></i>Track</a>"; 
                }else{
                     return ""; 
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    /////////////////////////////Vehicle Tracker/////////////////////////////
    public function location(Request $request)
    {
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
            $request->session()->flash('message', 'No Data Received From GPS!!!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('vehicle'));
        }
        else if($track_data->latitude==null || $track_data->longitude==null)
        {
            $request->session()->flash('message', 'No Data Received From GPS!!!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('vehicle'));
        }
        else
        {
            $latitude=$track_data->latitude;
            $longitude= $track_data->longitude;
        }

        $snapRoute=$this->LiveSnapRoot($latitude,$longitude);
        $latitude=$snapRoute['lat'];
        $longitude=$snapRoute['lng'];


        return view('Vehicle::vehicle-tracker',['Vehicle_id' => $decrypted_id,'vehicle_type' => $vehicle_type,'latitude' => $latitude,'longitude' => $longitude] );
    }
    public function locationTrack(Request $request)
    {
        $get_vehicle=Vehicle::find($request->id);
        $currentDateTime=Date('Y-m-d H:i:s');
        $last_update_time=date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time')."")); 
        $connection_lost_time = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time').""));
        $offline="Offline";
        $signal_strength="Connection Lost";
    
        $track_data=Gps::select('lat as latitude',
                      'lon as longitude',
                      'heading as angle',
                      'mode as vehicleStatus',
                      'speed',
                      'fuel_status',
                      'battery_status as battery_percentage',
                      'device_time as dateTime',
                      'main_power_status as power',
                      'ignition as ign',
                      'id',
                      'gsm_signal_strength as signalStrength'
                    )
                    ->where('device_time', '>=',$last_update_time)
                    ->where('id',$get_vehicle->gps_id)
                    ->first();
        $minutes=0;
        if($track_data == null){
            $track_data = Gps::select('lat as latitude',
                              'lon as longitude',
                              'heading as angle',
                              'speed',
                              'fuel_status',
                              'battery_status as battery_percentage',
                              'device_time as dateTime',
                              'main_power_status as power',
                              'ignition as ign',
                              \DB::raw("'$signal_strength' as signalStrength"),
                              \DB::raw("'$offline' as vehicleStatus")
                              )
                              ->where('id',$get_vehicle->gps_id)
                              ->first();
           $minutes   = Carbon::createFromTimeStamp(strtotime($track_data->dateTime))->diffForHumans();
        }
 
        if($track_data){
            $plcaeName=$this->getPlacenameFromLatLng($track_data->latitude,$track_data->longitude);
            $snapRoute=$this->LiveSnapRoot($track_data->latitude,$track_data->longitude);
            if(\Auth::user()->hasRole('fundamental|pro|superior')){
                $fuel =$track_data->fuel_status*100/15;
                $fuel = (int)$fuel;
                $fuel_status=$fuel."%";
            }      
            else
            {
                $fuel_status="UPGRADE VERSION";
            }
           
            $reponseData=array(
                        "latitude"=>floatval($snapRoute['lat']),
                        "longitude"=>floatval($snapRoute['lng']),
                        "angle"=>$track_data->angle,
                        "vehicleStatus"=>$track_data->vehicleStatus,
                        "speed"=>round($track_data->speed),
                        "dateTime"=>$track_data->dateTime,
                        "power"=>$track_data->power,
                        "ign"=>$track_data->ign,
                        "battery_status"=>round($track_data->battery_percentage),
                        "signalStrength"=>$track_data->signalStrength,
                        "connection_lost_time"=>$connection_lost_time,
                        "last_seen"=>$minutes,
                        "fuel"=>$fuel_status,
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

    /////////////////////////////Vehicle Tracker/////////////////////////////
    public function playback(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);  
        return view('Vehicle::vehicle-playback',['Vehicle_id' => $decrypted_id] );
       
    }
    public function playbackPageInTrack(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);  
        return view('Vehicle::vehicle-playback-in-track',['vehicle_id' => $decrypted_id] );
       
    }
    public function playbackHMap(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);  
        $user=\Auth::user();
    
        $user_role=$user->roles->first()->name;
        $date_by_role=$this->playbackHistoryDataPeriod($user_role);  
        return view('Vehicle::vehicle-playback-hmap',['Vehicle_id' => $decrypted_id,'start_date'=>$date_by_role] );
    }


    public function playbackHistoryDataPeriod($role){
        if($role=="fundamental|| client"){
            $from_date=Carbon::now()->subMonth(2);
         }else if($role=="superior"){ 
            $from_date=Carbon::now()->subMonth(4);
         }else if($role=="pro"){
             $from_date=Carbon::now()->subMonth(6);
         }else{
           $from_date=Carbon::now()->subMonth(1);
         }
         return $from_date;
     }

/// invoice/////////


    public function invoice(Request $request){
        $client_id=\Auth::user()->client->id;
         $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
          
        return view('Vehicle::invoice',['vehicles'=>$vehicles] );
    }

    public function export(Request $request){
        $from = $request->fromDate;
        $to = $request->toDate;
        $vehicle = $request->vehicle;           
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
         $query =GpsData::select(
            'gps_id',
            'header',
            'vendor_id',
            'firmware_version',
            'imei',
            'update_rate_ignition_on',
            'update_rate_ignition_off',
            'battery_percentage',
            'low_battery_threshold_value',
            'memory_percentage',
            'digital_io_status',
            'analog_io_status',
            'activation_key',
            'latitude',
            'lat_dir',
            'longitude',
            'lon_dir',
            'date',
            'time',
            'speed',
            'alert_id',
            'packet_status',
            'gps_fix',
            'mcc',
            'mnc',
            'lac',
            'cell_id',
            'heading',
            'no_of_satelites',
            'hdop',
            'gsm_signal_strength',
            'ignition',
            'main_power_status',
            'vehicle_mode',
            'altitude',
            'pdop',
            'nw_op_name',
            'nmr',
            'main_input_voltage',
            'internal_battery_voltage',
            'tamper_alert',
            'digital_input_status',
            'digital_output_status',
            'frame_number',
            'checksum',            
            'gf_id',
            // 'device_time',
            \DB::raw('DATE(device_time) as date'),
            \DB::raw('sum(distance) as distance')
        )
        ->with('gps.vehicle')
        ->where('gps_id',$single_vehicle_ids)
        ->groupBy('date');                     
        if($from){
            $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)
                ->whereDate('device_time', '<=', $search_to_date);
        }
        $vehicle_invoice = $query->get();  

        $pdf = PDF::loadView('Vehicle::invoice-pdf-download',['vehicle_invoices'=> $vehicle_invoice]);
        return $pdf->download('Invoice.pdf');
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
        $from_date=$request->from_time;
        $to_date=$request->to_time;
        $user=\Auth::user();
        $user_role=$user->roles->first()->name;
        $check_role_in_playback=$this->checkRolePlayback($user_role,$from_date);
        if($check_role_in_playback=="failed"){
         $response_data = array(
            'status'  => 'wrong_date',
            'message' => 'wrong_date',
            'polyline' => "wrong_date",
            'code'    =>0
        );
         return response()->json($response_data); 
        }


        $gpsdata=GpsData::Select(
            'latitude as lat',
            'longitude as lng', 
            'heading as angle',
            'ignition as ign',
            'device_time as datetime',
            'speed',
            'time',
            'gps_fix'       
        )
        ->where('created_at', '>=',$request->from_time)
        ->where('created_at', '<=',$request->to_time)
        ->where('vehicle_id',$request->id)   
        ->where('latitude','>',0)  
        ->orderBy('created_at') 
        ->limit(145)        
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
//
    // servicer vehicle create

    public function servicercreateVehicle(Request $request)
    {
        $client_id = Crypt::decrypt($request->id);
        $servicer_id=\Auth::user()->servicer->id;
        $client = Client::select(
            'user_id'
            )
            ->where('id',$client_id)
            ->first();
            $client_user_id=$client->user_id;
        $vehicleTypes=VehicleType::select(
                'id','name')->get();
        $vehicle_device = Vehicle::select(
                'gps_id',
                'id',
                'register_number',
                'name'
                )
                ->where('client_id',$client_id)
                ->get();

        $single_gps = [];
        foreach($vehicle_device as $device){
            $single_gps[] = $device->gps_id;
        } 

        $devices=Gps::select('id','imei')
                ->where('user_id',$client_user_id)
                ->whereNotIn('id',$single_gps)
                ->get();
           // dd($client_id);
        return view('Vehicle::servicer-vehicle-add',['vehicleTypes'=>$vehicleTypes,'devices'=>$devices,'client_id'=>$request->id]);
    }

    // ---validate from date-----------------
    public function checkRolePlayback($role,$user_from_date){
       if($role=="fundamental"||"client"){
            $from_date=Carbon::now()->subMonth(2);
         }else if($role=="superior"){ 
            $from_date=Carbon::now()->subMonth(4);
         }else if($role=="pro"){
             $from_date=Carbon::now()->subMonth(6);
         }else{
           $from_date=Carbon::now()->subMonth(1);
         }
         
         if(Carbon::parse($from_date) <= Carbon::parse($user_from_date)){
            $return="Success";
         }else{
            $return="failed"; 
         }
         return $return;
    }
    // ---validate from date-----------------

 



    public function servicerVehicleList()
    {
        
       return view('Vehicle::servicer-vehicle-list'); 
    }
   
    public function getServicerVehicleList()
    {
        $servicer_id=\Auth::user()->servicer->id;
        $servicer_jobs = ServicerJob::select(
            'id',
            'servicer_id',
            'client_id',
            'gps_id'
        )
        ->withTrashed()
        ->where('servicer_id',$servicer_id)
        ->get();
        $job_id = [];
        foreach($servicer_jobs as $servicer_job){
            $job_id[] = $servicer_job->id;
        } 
        // dd($client_id);
        $vehicles = Vehicle::select(
            'id',
            'name',
            'register_number',
            'client_id',
            'gps_id',
            'driver_id',
            'vehicle_type_id',
            'deleted_at'
        )
        ->withTrashed()
        ->whereIn('servicer_job_id',$job_id)
        ->with('vehicleType:id,name')
        ->with('driver:id,name')
        ->with('client:id,name')
        ->with('gps:id,imei')
        ->get();
        return DataTables::of($vehicles)
        ->addIndexColumn()
         ->addColumn('driver', function ($vehicles) {
            if($vehicles->driver_id== null || $vehicles->driver_id==0)
            {
                return "Not assigned";
            }
            else
            {
              return $vehicles->driver->name;             
            }
        })
        ->addColumn('action', function ($vehicles) {
            $b_url = \URL::to('/');
            if($vehicles->deleted_at == null){
                    return "
                     <a href=".$b_url."/servicer-vehicles/".Crypt::encrypt($vehicles->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'> View</i> </a>
                    ";                 
            }
         })
        ->rawColumns(['link', 'action'])
        ->make();
    }

     public function servicerVehicleDetails(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $vehicle = Vehicle::find($decrypted_id);
        $client_id=$vehicle->client_id;        
        if($vehicle == null){
            return view('Vehicle::404');
        }
        $drivers=Driver::select('id','name')
                ->where('client_id',$client_id)
                ->get();
         $docTypes=DocumentType::select(
                'id','name')->whereIn('id',[1,6,7,8])->get();
       
        $vehicleDocs=Document::select(
                'id','vehicle_id','document_type_id','expiry_date','path')
                ->where('vehicle_id',$vehicle->id)
                ->with('documentType:id,name')
                ->get();
        return view('Vehicle::servicer-vehicle-details',['vehicle' => $vehicle,'drivers' => $drivers,'docTypes'=>$docTypes,'vehicleDocs'=>$vehicleDocs]);
    }

     //for dependent dropdown doc add
    public function servicerfindDateFieldWithDocTypeID(Request $request)
    {   
        $docTypeID=$request->docTypeID;
        return response()->json($docTypeID);
    }


    // --------------playback page-------------------------------------
    public function playbackPage(){ 
       return view('Vehicle::vehicle-playback-window'); 
    }
     public function playbackPageData(Request $request){ 
      $vehicle_id=$request->vehicle_id;
      $start_date=$request->start_date;
      $end_date=$request->end_date;
     
      $vehicle=Vehicle::find($vehicle_id); 
      if($vehicle==null){
             $data = array('status' => 200,
                           'message' => 'vehicle doesnot exist',
                           'code'=>0);
        return response()->json($data);
       }

        $gpsData=GpsData::select('latitude','longitude')
        ->where('gps_id',$vehicle->gps_id)
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->limit(100);
        if($start_date)
        {
            $gpsData = $gpsData->where('device_time', '>=', $start_date)
            ->where('device_time', '<=', $end_date);
        }
        $gpsData = $gpsData->orderBy('device_time','asc')
        ->get();

       if($gpsData){
          $response_data = array('status'  => 200,
                                'message' => 'success',
                                'locations'=>$gpsData,
                                'code'    =>1
                                );
          }else{
          $response_data = array('status'  => 200,
                                'message' => 'failed',
                                'code'    =>0);
          }
        
        return response()->json($response_data); 
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
            'driver_id' => 'required'
        ];
        return  $rules;
    }
    // vehicle update rules
    public function vehicleUpdateRules($vehicle)
    {
        $rules = [
            'driver_id' => 'required',
        ];
        return  $rules;  
    }
    public function vehicleOdometerUpdateRules($gps)
    {
        $rules = [
            'odometer' => 'required',
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
            'svg_icon' => 'required|max:20000',
            'weight' => 'required|numeric',
            'scale' => 'required|numeric',
            'opacity' => 'required|numeric',
            'offline_icon' => 'required',
            'ideal_icon' => 'required',
            'sleep_icon' => 'required',
            'online_icon' => 'required'
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
            'path' => 'required|mimes:jpeg,png|max:4096'

        ];
        return  $rules;
    }

    public function customDocCreateRules(){
        $rules = [
            'vehicle_id' => 'required',
            'document_type_id' => 'required',
            'expiry_date' => 'required',
            'path' => 'required|mimes:jpeg,png|max:4096'

        ];
        return  $rules;
    }

    // document update rules
    public function documentUpdateRules()
    {
        $rules = [
            'vehicle_id' => 'required',
            'expiry_date' => 'nullable',
            'path'=>'mimes:jpeg,png|max:4096'

        ];
        return  $rules;
    }
// --------------------------------------------------------------------------------
    function getPlacenameFromLatLng($latitude,$longitude){
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo'); 
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
        if($lat != null){
            $route = $lat.",".$lng;
            $url = "https://roads.googleapis.com/v1/snapToRoads?path=".$route."&interpolate=true&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo";
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
        }
        $userData = ["lat" => $lat, "lng" => $lng];
        return $userData;

    }
///////////////////API-start////////////////////////////////////////

    public function vehicleStatics(Request $request) 
    {
        $user_id = $request->userid;
        $user = User::where('id', $user_id)->first();
        if ($user == null) 
         {
            $data = array('status' => 'failed', 
                          'message' => 'user does not exist', 
                          'code' => 0
                         );
            return response()->json($data);
         }
        $client = Client::where('user_id', $user_id)->first();
        $type = $request->type;
        $custom_from_date = $request->from_date;
        $custom_to_date = $request->to_date;
        $date_and_time = $this->getDateFromType($type, $custom_from_date, $custom_to_date);
        $from_date = date('Y-m-d H:i:s', strtotime($date_and_time['from_date']));
        $to_date = date('Y-m-d H:i:s', strtotime($date_and_time['to_date']));
        $app_date = $date_and_time['appDate'];
        $vehicle_details = Vehicle::where('client_id', $client->id)
                                 ->whereNull('deleted_at')
                                 ->orderBy('id', 'desc')
                                 ->get();
        $statics = array();
        if (sizeof($vehicle_details) != 0) {
            foreach ($vehicle_details as $vehicle_data) {
                $single_vehicle_details = Vehicle::find($vehicle_data->id);
                $vehicle_profile= $this->vehicleProfile($single_vehicle_details->id,$date_and_time,$client->id);
                $get_driver = Driver::find($single_vehicle_details->driver_id);
                if($get_driver){
                 $driver_points=$get_driver->points;
                }else{
                 $driver_points=""; 
                }
                $gps_data=GpsData::where('gps_id',$single_vehicle_details->gps->id)
                                   ->where('device_time','>=', $from_date)
                                   ->where('device_time','<=', $to_date)
                                   ->get();
                               
                $maximum_speed=$gps_data->max('speed');   
                if($type==2)
                {
                  // for get single date km
                  $to_date=$from_date;
                }

                $total_km = DailyKm::where('gps_id',$single_vehicle_details->gps->id)
                                     ->whereDate('date','>=',$from_date)
                                     ->whereDate('date','<=',$to_date)
                                     ->sum('km');                   
                $statics[] = array("vehicle_number" => $single_vehicle_details->register_number, 
                                   "vehicle_id" => $single_vehicle_details->id, 
                                   "total_distance" => 0, 
                                   "total_ignition_on_time" =>$vehicle_profile['engine_on_duration'], 
                                   "total_ignition_off_time" =>$vehicle_profile['engine_off_duration'], 
                                   "total_number_of_stops" =>0, 
                                   "ac_on_time_idle" => 0, 
                                   "ac_on_time_running" =>0, 
                                   "driver_behaviour" => $driver_points, 
                                   "total_km" => $total_km, 
                                   "max_speed" => $maximum_speed ?$maximum_speed:"", 
                                   "geofence_entry_count" =>$vehicle_profile['geofence_entry'],
                                   "geofence_exit_count" =>$vehicle_profile['geofence_exit'],
                                   "overspeed_violation_count" => $vehicle_profile['over_speed'],
                                   "zig_zag_violation_count" => $vehicle_profile['zig_zag'],
                                   "accident_impact_alert_count" => $vehicle_profile['accident_impact'],
                                   "route_deviation_count" => $vehicle_profile['route_deviation'],
                                   "harsh_braking_count" => $vehicle_profile['harsh_braking'],
                                   "sudden_acceleration_count" => $vehicle_profile['sudden_acceleration'],
                                   "main_battey_disconnect_count" => $vehicle_profile['main_battery_disconnect'],


                                   "total_moving_time" => $vehicle_profile['motion'], 
                                   "total_idle_time" => $vehicle_profile['halt'],
                                   "total_sleep_time" => $vehicle_profile['sleep'],
                                   "total_offline_time" => 0, 


                                   "total_alerts" => $vehicle_profile['user_alert'],
                                   "vehicle_type" => $single_vehicle_details->vehicleType->name, 
                                   "vehicle_online" => $single_vehicle_details->vehicleType->online_icon, 
                                   "vehicle_offline" => $single_vehicle_details->vehicleType->offline_icon, 
                                   "vehicle_ideal" => $single_vehicle_details->vehicleType->ideal_icon, 
                                   "vehicle_sleep" => $single_vehicle_details->vehicleType->sleep_icon
                                  );
            }
            $response_data = array('status' => 'success', 
                                   'message' => 'success', 
                                   'code' => 1, 
                                   'vehicle_value' => $statics,
                                   'search_date'=>$app_date
                                  );
        } else {
            $response_data = array('status' => 'failed', 
                                   'message' => 'failed', 
                                   'code' => 0
                                  );
        }
        return response()->json($response_data);
    }

    public function singleVehicleReport(Request $request) 
    {
        $user_id = $request->user_id;
        $vehicle_id = $request->vehicle_id;
        $type = $request->type;
        $custom_from_date = $request->from_date;
        $custom_to_date = $request->to_date;
        $user = User::where('id', $user_id)->first();
        if ($user == null) 
        {
            $data = array('status' => 'failed', 
                          'message' => 'user does not exist', 
                          'code' => 0
                         );
            return response()->json($data);
        }
        $client = Client::where('user_id', $user_id)->first();
        $date_and_time = $this->getDateFromType($type, $custom_from_date, $custom_to_date);
        $from_date = date('Y-m-d H:i:s', strtotime($date_and_time['from_date']));
        $to_date = date('Y-m-d H:i:s', strtotime($date_and_time['to_date']));
        $app_date = $date_and_time['appDate'];
        $vehicle_details = Vehicle::where('id', $vehicle_id)
                                 ->whereNull('deleted_at')
                                 ->first();
        $statics = array();
        if($vehicle_details){
            $vehicle_profile= $this->vehicleProfile($vehicle_id,$date_and_time,$client->id);
            $get_driver = Driver::find($vehicle_details->driver_id);
            if($get_driver){
                $driver_points=$get_driver->points;
            }else{
                $driver_points=""; 
            }
            $gps_data=GpsData::where('gps_id',$vehicle_details->gps->id)
                               ->where('device_time','>=', $from_date)
                               ->where('device_time','<=', $to_date)
                               ->get();
                           
            $maximum_speed=$gps_data->max('speed');   
            if($type==2)
            {
              // for get single date km
              $to_date=$from_date;
            }

            $total_km = DailyKm::where('gps_id',$vehicle_details->gps->id)
                                 ->whereDate('date','>=',$from_date)
                                 ->whereDate('date','<=',$to_date)
                                 ->sum('km'); 
            $statics = array("vehicle_number" => $vehicle_details->register_number, 
                                   "vehicle_id" => $vehicle_details->id, 
                                   "total_distance" => strval($total_km), 
                                   "total_ignition_on_time" =>$vehicle_profile['engine_on_duration'], 
                                   "total_ignition_off_time" =>$vehicle_profile['engine_off_duration'], 
                                   "total_number_of_stops" =>0, 
                                   "ac_on_time_idle" => $vehicle_profile['ac_halt_on_duration'], 
                                   "ac_on_time_running" =>$vehicle_profile['ac_on_duration'], 
                                   "driver_behaviour" => strval($driver_points), 
                                   "total_km" => strval($total_km), 
                                   "max_speed" => $maximum_speed ?$maximum_speed:"", 
                                   "geofence_entry_count" =>$vehicle_profile['geofence_entry'],
                                   "geofence_exit_count" =>$vehicle_profile['geofence_exit'],
                                   "overspeed_violation_count" => $vehicle_profile['over_speed'],
                                   "zig_zag_violation_count" => $vehicle_profile['zig_zag'],
                                   "accident_impact_alert_count" => $vehicle_profile['accident_impact'],
                                   "route_deviation_count" => $vehicle_profile['route_deviation'],
                                   "harsh_braking_count" => $vehicle_profile['harsh_braking'],
                                   "sudden_acceleration_count" => $vehicle_profile['sudden_acceleration'],
                                   "main_battey_disconnect_count" => $vehicle_profile['main_battery_disconnect'],


                                   "total_moving_time" => $vehicle_profile['motion'], 
                                   "total_idle_time" => $vehicle_profile['halt'],
                                   "total_sleep_time" => $vehicle_profile['sleep'],
                                   "total_offline_time" => 0, 


                                   "total_alerts" => $vehicle_profile['user_alert'],
                                   "vehicle_type" => $vehicle_details->vehicleType->name, 
                                   "vehicle_online" => $vehicle_details->vehicleType->online_icon, 
                                   "vehicle_offline" => $vehicle_details->vehicleType->offline_icon, 
                                   "vehicle_ideal" => $vehicle_details->vehicleType->ideal_icon, 
                                   "vehicle_sleep" => $vehicle_details->vehicleType->sleep_icon
                                  );
                $response_data = array('status' => 'success', 
                                   'message' => 'success', 
                                   'code' => 1, 
                                   'vehicle_value' => $statics,
                                   'search_date'=>$app_date
                                  );
        }        
        else {
            $response_data = array('status' => 'failed', 
                                   'message' => 'failed', 
                                   'code' => 0
                                  );
        }
        return response()->json($response_data);
    }

    public function getVehicleTravelSummary(Request $request) {
        $user_id = $request->user_id;
        $vehicle_id = $request->vehicle_id;
        $type = $request->type;
        $custom_from_date = $request->from_date;
        $custom_to_date = $request->to_date;
        $user = User::where('id', $user_id)->first();
        if ($user == null) 
        {
            $data = array('status' => 'failed', 
                          'message' => 'user does not exist', 
                          'code' => 0
                         );
            return response()->json($data);
        }
        $client = Client::where('user_id', $user_id)->first();
        $date_and_time = $this->getDateFromType($type, $custom_from_date, $custom_to_date);
        $from_date = date('Y-m-d H:i:s', strtotime($date_and_time['from_date']));
        $to_date = date('Y-m-d H:i:s', strtotime($date_and_time['to_date']));

        $vehicle_details = Vehicle::where('id', $vehicle_id)
                                 ->whereNull('deleted_at')
                                 ->first();
        $travel_data = array();
        if($vehicle_details){
            $vehicle_profile= $this->vehicleProfile($vehicle_id,$date_and_time,$client->id);
            $gps_data=GpsData::where('gps_id',$vehicle_details->gps->id)
                               ->where('device_time','>=', $from_date)
                               ->where('device_time','<=', $to_date)
                               ->get();
            $avg_speed = $gps_data->avg('speed');
            $max_speed = $gps_data->max('speed');
            // km dummy
            if($type==2)
            {
              // for get single date km
                $to_date=$from_date;
            }

            $total_km = DailyKm::where('gps_id',$vehicle_details->gps->id)
                                 ->whereDate('date','>=',$from_date)
                                 ->whereDate('date','<=',$to_date)
                                 ->sum('km');
            $travel_duration = array("idle" =>$vehicle_profile['halt'], 
                                  "running" => $vehicle_profile['motion'],
                                  "stop" => $vehicle_profile['sleep'], 
                                  "inactive" => 0
                                 );
            $travel_speed = array("speed" =>0, 
                                  "total_km" => strval($total_km),
                                  "avg_speed" => number_format($avg_speed, 2), 
                                  "max_speed" => $max_speed ?$max_speed:""
                                 );
            $travel_data[] = array("travel_duration" => $travel_duration, 
                                   "travel_speed" => $travel_speed, 
                                   "total_alerts" => $vehicle_profile['user_alert'], 
                                   "vehicleId" => $vehicle_details->id, 
                                   "user_name" => $user->username, 
                                   "vehicle_number" => $vehicle_details->register_number, 
                                   "vehicle_type" => $vehicle_details->vehicleType->name, 
                                   "vehicle_online" => $vehicle_details->vehicleType->online_icon, 
                                   "vehicle_offline" => $vehicle_details->vehicleType->offline_icon, 
                                   "vehicle_ideal" => $vehicle_details->vehicleType->ideal_icon, 
                                   "vehicle_sleep" => $vehicle_details->vehicleType->sleep_icon
                                  );
            $response_data = array('status' => 'success', 
                                   'message' => 'success', 
                                   'code' => 1, 
                                   'user_name' => $user->username, 
                                   'travel_summary' => $travel_data,
                                   'from_date'=>$from_date,
                                   'to_date'=>$to_date
                                  );
        }else {
            $response_data = array('status' => 'failed', 'message' => 'failed', 'code' => 0);
        }
        return response()->json($response_data);
    }

    public function getTravelSummary(Request $request) {
        $user_id = $request->userid;
        $user = User::where('id', $user_id)->first();
        if ($user == null) 
        {
            $data = array('status' => 'failed', 
                          'message' => 'user does not exist', 
                          'code' => 0
                         );
            return response()->json($data);
        }
        $client = Client::where('user_id', $user_id)->first();
        $type = $request->type;
        $custom_from_date = $request->from_date;
        $custom_to_date = $request->to_date;
        $date_and_time = $this->getDateFromType($type, $custom_from_date, $custom_to_date);
        $from_date = date('Y-m-d H:i:s', strtotime($date_and_time['from_date']));
        $to_date = date('Y-m-d H:i:s', strtotime($date_and_time['to_date']));

        $user = User::find($user_id);
        $user_vehicle = Vehicle::where('client_id', $client->id)
                                ->whereNull('deleted_at')
                                ->orderBy('id', 'desc')
                                ->get();
        $travel_data = array();
        if (sizeof($user_vehicle) != 0) {
            foreach ($user_vehicle as $data) {
                $get_vehicle = Vehicle::find($data->id);
                $vehicle_profile= $this->vehicleProfile($data->id,$date_and_time,$client->id);
                $gps_data = GpsData::where('gps_id', $get_vehicle->gps_id)
                                     ->where('device_time', '>=', $from_date)
                                     ->where('device_time', '<=', $to_date)
                                     ->limit(1000)
                                     ->get();
                $avg_speed = $gps_data->avg('speed');
                $max_speed = $gps_data->MAX('speed');
                // km dummy
                if($type==2)
                {
                  // for get single date km
                    $to_date=$from_date;
                }

                $total_km = DailyKm::where('gps_id',$get_vehicle->gps->id)
                                     ->whereDate('date','>=',$from_date)
                                     ->whereDate('date','<=',$to_date)
                                     ->sum('km');
                // km dummy

                $travel_duration = array("idle" =>$vehicle_profile['halt'], 
                                      "running" => $vehicle_profile['motion'],
                                      "stop" => $vehicle_profile['sleep'], 
                                      "inactive" => 0
                                     );
                $travel_speed = array("speed" =>0, 
                                      "total_km" => $total_km,
                                      "avg_speed" => number_format($avg_speed, 2), 
                                      "max_speed" => $max_speed ?$max_speed:""
                                     );
                $travel_data[] = array("travel_duration" => $travel_duration, 
                                       "travel_speed" => $travel_speed, 
                                       "total_alerts" => $vehicle_profile['user_alert'], 
                                       "vehicleId" => $get_vehicle->id, 
                                       "user_name" => $user->username, 
                                       "vehicle_number" => $get_vehicle->register_number, 
                                       "vehicle_type" => $get_vehicle->vehicleType->name, 
                                       "vehicle_online" => $get_vehicle->vehicleType->online_icon, 
                                       "vehicle_offline" => $get_vehicle->vehicleType->offline_icon, 
                                       "vehicle_ideal" => $get_vehicle->vehicleType->ideal_icon, 
                                       "vehicle_sleep" => $get_vehicle->vehicleType->sleep_icon
                                      );
            }
            $response_data = array('status' => 'success', 
                                   'message' => 'success', 
                                   'code' => 1, 
                                   'user_name' => $user->username, 
                                   'travel_summary' => $travel_data,
                                   'from_date'=>$from_date,
                                   'to_date'=>$to_date
                                  );
        } else {
            $response_data = array('status' => 'failed', 'message' => 'failed', 'code' => 0);
        }
        return response()->json($response_data);
    }
///////////////////API-end////////////////////////////////////////


   
}
