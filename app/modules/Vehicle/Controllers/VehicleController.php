<?php

namespace App\Modules\Vehicle\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\User\Models\User;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Ota\Models\OtaResponse;
use App\Modules\Vehicle\Models\VehicleRoute;
use App\Modules\Vehicle\Models\KmUpdate;
use App\Modules\Route\Models\RouteArea;
use App\Modules\Vehicle\Models\DocumentType;
use App\Modules\Vehicle\Models\VehicleDriverLog;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Ota\Models\GpsOta;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Driver\Models\Driver;
use App\Modules\Gps\Models\Gps;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Gps\Models\GpsData;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Vehicle\Models\DailyKm;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Configuration\Models\Configuration;
use App\Modules\Driver\Models\DriverVehicleHistory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Modules\Operations\Models\VehicleModels;
use App\Modules\Vehicle\Models\OdometerUpdate;
use App\Http\Traits\VehicleDataProcessorTrait;
use Carbon\Carbon;
use PDF;
use DataTables;
use Config;
use Intervention\Image\ImageManagerStatic as Image;

class VehicleController extends Controller
{

    CONST DAILY_KILOMETRE_RESET_VALUE = 0;


    /**
     * Response data
     */
    private $data;

    /**
     * Http response code
     */
    private $code;

    /**
     * Response status
     */
    private $success;

    /**
     * Response message
     */
    private $message;

    /**
     * Init class attributes
     */
    public function __construct()
    {
        $this->data     = [];
        $this->code     = Response::HTTP_OK;
        $this->success  = true;
        $this->message  = '';
    }

    /**
     * add geo fence
     * @author  spm
     *
     */
    use VehicleDataProcessorTrait;

    // show list page
    public function vehicleList()
    {

       return view('Vehicle::vehicle-list');
    }

    public function getVehicleList()
    {
        $client_id          =   \Auth::user()->client->id;
        $vehicles           =   (new Vehicle())->getVehicleListBasedOnClient($client_id);  
        return DataTables::of($vehicles)
        ->addIndexColumn()
        ->addColumn('driver', function ($vehicles) 
        {
            if($vehicles->driver_id== null || $vehicles->driver_id==0)
            {
                return "Not assigned";
            }
            else
            {
                return $vehicles->driver->name;

            }
        })
        ->addColumn('action', function ($vehicles) 
        {
            $b_url = \URL::to('/');
            if($vehicles->deleted_at == null)
            {
                if($vehicles->is_returned == 1)
                {
                    return "
                    <b style='color:#FF0000';>GPS Returned</b>";

                }else{
                    return "
                    <a href=".$b_url."/vehicles/".Crypt::encrypt($vehicles->id)."/location class='btn btn-xs btn btn-warning' data-toggle='tooltip' title='Location'><i class='fa fa-map-marker'></i> Track</i></a>
                    <a href=".$b_url."/vehicles/".Crypt::encrypt($vehicles->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'>View/Edit</i> </a>"
                    ;
                }
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
        $vehicle_device = Vehicle::select('id',
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
        // if same driver updated no insertion
        if($old_driver != $new_driver_id)
        {
            if($vehicle_update && $new_driver_id && $old_driver){
                    $vehicle_driver_log = VehicleDriverLog::create([
                    'vehicle_id' => $vehicle->id,
                    'from_driver_id' => $old_driver,
                    'to_driver_id' => $new_driver_id,
                    'client_id' =>$vehicle->client_id
                ]);
                $driver_vehicle_history_log = DriverVehicleHistory::where('vehicle_id',$vehicle->id)->where('driver_id',$old_driver)->update(['to_date'=>date('Y-m-d')]);
                $vehicle_driver_history = DriverVehicleHistory::create([
                    'vehicle_id' => $vehicle->id,
                    'driver_id' => $new_driver_id,
                    'from_date' =>date('Y-m-d')
                ]);
            }
        }
        $encrypted_vehicle_id = encrypt($vehicle->id);
        $request->session()->flash('message', 'Driver updated successfully!');
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

    public function regupdate(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        if($vehicle == null){
           return view('Vehicle::404');
        }
        $vehicle->register_number = $request->register_number;
        $vehicle->is_registernumber_updated = 1;
        $vehicle->save();
        $encrypted_vehicle_id = encrypt($vehicle->id);
        $request->session()->flash('message', 'Register number updated successfully!');
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
        //dd($request->reset_daily_km);
        $vehicle = Vehicle::find($request->id);
        $encrypted_gps_id = encrypt($request->id);
        $gps = Gps::find($vehicle->gps_id);
        if($gps == null){
           return view('Vehicle::404');
        }
        $old_odometer=$gps->km;
        //  $custom_messages = [
        // 'name.required' => 'Please mention the reason'
        // ];
        $rules = $this->vehicleOdometerUpdateRules($gps);
        $this->validate($request, $rules);
        $odometer_in_km=$request->odometer;
        $odometer_in_meter=round($odometer_in_km*1000);
        $gps->km = $odometer_in_meter;
        $save_update = $gps->save();
        if($save_update)
        {
            $odometer_update = OdometerUpdate::create([
                'vehicle_id' => $request->id,
                'gps_id' => $vehicle->gps_id,
                'old_odometer' => $old_odometer,
                'new_odometer' => $odometer_in_meter,
                'edited_at' => date('Y-m-d H:i:s') ,
                'updated_by' => $vehicle->client_id
            ]);

            if( ($odometer_update) && ($request->reset_daily_km == '1') )
            {
                $this->updateVehicleDailyKilometre($vehicle->gps_id, self::DAILY_KILOMETRE_RESET_VALUE);
            }
        }
        $request->session()->flash('message', 'Vehicle odometer updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('vehicles.details',$encrypted_gps_id));
    }

    public function updateVehicleDailyKilometre($gps_id, $value)
    {
        return (new DailyKm())->updateDailyKilometre($gps_id, $value);
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
        $vehicle_models = VehicleModels::select('id','name')->get();
        return view('Vehicle::vehicle-details',['vehicle' => $vehicle,'drivers' => $drivers,'docTypes'=>$docTypes,'vehicleDocs'=>$vehicleDocs,'vehicle_models'=>$vehicle_models]);
    }

    //for dependent dropdown doc add
    public function findDateFieldWithDocTypeID(Request $request)
    {
        $docTypeID=$request->docTypeID;
        return response()->json($docTypeID);
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
        $messages = [
            'path.uploaded' => "The file size should be less than 2MB",
            'path.max' => 'The file size should be less than 2MB'
        ];
        $this->validate($request, $rules,$messages);
        $file=$request->path;
        if($file){
            // $old_file = $vehicle_doc->path;
            // $myFile = "documents/vehicledocs/".$old_file;
            // $delete_file=unlink($myFile);
            // if($delete_file){
            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;
            //Move Uploaded File
            $destinationPath = 'documents/vehicledocs';
            $file->move($destinationPath,$uploadedFile);
            $vehicle_doc->path = $uploadedFile;
            // }
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
            // $myFile = "documents/vehicledocs/".$old_file;
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
            return redirect()->back();
        }
        else
        {
            return redirect(route('servicer-vehicles.details',$encrypted_vehicle_id));
        }

    }

    // vehicle doc delete from all vehicle list
    public function deleteFromAllDocList(Request $request)
    {
        $vehicle_doc=Document::find($request->id);
        if($vehicle_doc == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Document does not exist'
            ]);
        }
        $file=$vehicle_doc->path;
        if($file){
            // $old_file = $vehicle_doc->path;
            // $myFile = "documents/vehicledocs/".$old_file;
            // $delete_file=unlink($myFile);
            $vehicle_doc->delete();
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Document deleted successfully!'
        ]);

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
        $vehicles = Vehicle::select('gps_id','id')->where('gps_id',$request->gps_id)->first();
       
        if($vehicles== null)
        {
            
            $vehicle=Vehicle::select('id','gps_id')
                                     ->where('id',$request->id)
                                     ->withTrashed()
                                     ->first();
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

    //critical alert
    public function continuousAlerts(Request $request)
    {
        $vehicle_id=$request->vehicle_id;
        $client_id=\Auth::user()->client->id;
        $last_alert_time = date('Y-m-d H:i:s',strtotime("-10 minutes"));
        $vehicle=Vehicle::find($vehicle_id);
        $alerts = Alert::select(
            'id',
            'alert_type_id',
            'gps_id',
            'latitude',
            'longitude',
            'device_time'
        )
        ->with('gps.vehicle')
        ->with('alertType')
        ->where('gps_id',$vehicle->gps_id)
        //->where('device_time','>=',$last_alert_time)
        ->whereIn('alert_type_id',[10,13])
        ->where('status',0)
        ->get();

        if(sizeof($alerts) == 0){
            $response=[
                'status' => 'failed'
            ];
        }else{
            $vehicle_id=$alerts[0]->gps->vehicle->id;
            $vehicle_id = Crypt::encrypt($vehicle_id);
            $response = [
                'status' => 'success',
                'alerts' => $alerts,
                'vehicle' => $vehicle_id
            ];
        }
        return response()->json($response);
    }

    // critical alert verification
    public function verifyContinuousAlert(Request $request)
    {
        $data = [
            'status'    => 0,
            'title'     => 'Failed',
            'message'   => 'Alert does not exist'
        ];
        $decrypted_vehicle_id   = Crypt::decrypt($request->id);
        $alert_id               = $request->alert_id;
        $vehicle                = Vehicle::find($decrypted_vehicle_id);
        $alerts                 = Alert::select('id','alert_type_id','status','gps_id')->where('alert_type_id',$alert_id)
            ->where('status',0)
            ->where('gps_id',$vehicle->gps_id)
            ->count();
        if($alerts > 0)
        {
            $updated = DB::statement("UPDATE alerts SET STATUS = 1 WHERE alert_type_id ='$alert_id' AND gps_id='$vehicle->gps_id' AND status=0");
            if($updated)
            {
                $data = [
                    'status'    => 1,
                    'title'     => 'Success',
                    'message'   => 'Alert verified successfully'
                ];
            }
        }
        return response()->json($data);
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
            // \DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as created_at')
        )
        ->where('client_id',$client_id)
        ->with('Fromdriver:id,name')
        ->with('Todriver:id,name')
        ->with('vehicle:id,name,register_number')
        ->orderBy('id','desc')
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
        // dd($client_id);
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
            'id',
            'vehicle_id',
            'document_type_id',
            'expiry_date',
            \DB::raw('DATE_FORMAT(expiry_date, "%d-%m-%Y") as updated_expiry_date'),
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
                $vehicle_documents->whereDate('expiry_date', '>=', date('Y-m-d'))
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
                $document_type_id=$vehicle_documents->document_type_id;
                $path = url($b_url.'/documents/vehicledocs').'/'.$vehicle_documents->path;

                if($document_type_id==2 || $document_type_id==3 || $document_type_id==4 || $document_type_id==5)
               {
                    return "<a href= ".$path." download='".$vehicle_documents->path."' class='btn btn-xs btn-success'  data-toggle='tooltip'><i class='fa fa-download'></i> Download </a>
                <button onclick=deleteDocumentFromAllDocumentList(".$vehicle_documents->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Delete </button>";

               }
               else
               {
                return "<a href= ".$path." download='".$vehicle_documents->path."' class='btn btn-xs btn-success'  data-toggle='tooltip'><i class='fa fa-download'></i> Download </a>
                    ";

               }
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


        ///Web online icon
        $web_online_vehicle=$request->web_online_icon;
        if($web_online_vehicle){
            $getFileExt   = $web_online_vehicle->getClientOriginalExtension();
            $web_online_uploadedFile =   time().'_web_online_vehicle.'.$getFileExt;
            //Move Uploaded File
            $destinationPath = 'documents';
            $web_online_vehicle->move($destinationPath,$web_online_uploadedFile);
        }
         // offline vehicle image
        $web_offline_vehicle=$request->web_offline_icon;
        if($web_offline_vehicle){
            $getFileExt   = $web_offline_vehicle->getClientOriginalExtension();
            $web_offline_uploadedFile =   time().'_web_offline_vehicle.'.$getFileExt;
            //Move Uploaded File
            $destinationPath = 'documents';
            $web_offline_vehicle->move($destinationPath,$web_offline_uploadedFile);
        }
         // ideal vehicle image
        $web_idle_vehicle=$request->web_idle_icon;
        if($web_idle_vehicle){
            $getFileExt   = $web_idle_vehicle->getClientOriginalExtension();
            $web_idle_uploadedFile =   time().'_web_idle_icon.'.$getFileExt;
            //Move Uploaded File
            $destinationPath = 'documents';
            $web_idle_vehicle->move($destinationPath,$web_idle_uploadedFile);
        }
        // sleep vehicle image
        $web_sleep_vehicle=$request->web_sleep_icon;
        if($web_sleep_vehicle){
            $getFileExt   = $web_sleep_vehicle->getClientOriginalExtension();
            $web_sleep_uploadedFile =   time().'_web_sleep_icon.'.$getFileExt;
            $destinationPath = 'documents';
            $web_sleep_vehicle->move($destinationPath,$web_sleep_uploadedFile);
            // sleep vehicle image
        }
        // sleep vehicle image
        $name = $request->name;
        $name = str_replace(' ', '_', $name);//replace spaces with underscore
        $name = strtolower($name); //convert string to lowercase
        $vehicle_type = VehicleType::create([
            'name' => $name,
            'svg_icon' => $request->svg_icon,
            'vehicle_scale' => $request->scale,
            'opacity' => $request->opacity,
            'strokeWeight' => $request->weight,
            'online_icon'=>$online_uploadedFile,
            'offline_icon'=>$offline_uploadedFile,
            'ideal_icon'=>$ideal_uploadedFile,
            'sleep_icon'=>$sleep_uploadedFile,

            'web_online_icon'=>$web_online_uploadedFile,
            'web_offline_icon'=>$web_offline_uploadedFile,
            'web_idle_icon'=>$web_idle_uploadedFile,
            'web_sleep_icon'=>$web_sleep_uploadedFile,
            'status' =>1,
           ]);
        $this->updateVehicleTypeApiResponse();
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
            $destinationPath =  public_path('/documents');
            $online_vehicle = Image::make($online_vehicle->getRealPath());
            $online_vehicle->resize(250,250, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$online_uploadedFile);
            $vehicle_type->online_icon = $online_uploadedFile;
        }
        // online vehicle image
         // offline vehicle image
        $offline_vehicle=$request->offline_icon;
        if($offline_vehicle){
            $getFileExt   = $offline_vehicle->getClientOriginalExtension();
            $offline_uploadedFile =   time().'_offline_vehicle.'.$getFileExt;
            //Move Uploaded File
            // $destinationPath = 'documents';
            // $offline_vehicle->move($destinationPath,$offline_uploadedFile);
            $destinationPath =  public_path('/documents');
            $offline_vehicle = Image::make($offline_vehicle->getRealPath());
            $offline_vehicle->resize(250,250, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$offline_uploadedFile);
            $vehicle_type->offline_icon = $offline_uploadedFile;
        }
        // online vehicle image
         // ideal vehicle image
        $ideal_vehicle=$request->ideal_icon;
        if($ideal_vehicle){
            $getFileExt   = $ideal_vehicle->getClientOriginalExtension();
            $ideal_uploadedFile =   time().'_ideal_icon.'.$getFileExt;
            //Move Uploaded File
            // $destinationPath = 'documents';
            // $ideal_vehicle->move($destinationPath,$ideal_uploadedFile);
            $destinationPath =  public_path('/documents');
            $ideal_vehicle = Image::make($ideal_vehicle->getRealPath());
            $ideal_vehicle->resize(250,250, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$ideal_uploadedFile);
            $vehicle_type->ideal_icon = $ideal_uploadedFile;
        }
        // ideal vehicle image
        // sleep vehicle image
        $sleep_vehicle=$request->sleep_icon;
        if($sleep_vehicle){
            $getFileExt   = $sleep_vehicle->getClientOriginalExtension();
            $sleep_uploadedFile =   time().'_sleep_icon.'.$getFileExt;
            //Move Uploaded File
            // $destinationPath = 'documents';
            // $sleep_vehicle->move($destinationPath,$sleep_uploadedFile);
            $destinationPath =  public_path('/documents');
            $sleep_vehicle = Image::make($sleep_vehicle->getRealPath());
            $sleep_vehicle->resize(250,250, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$sleep_uploadedFile);
            // sleep vehicle image
            $vehicle_type->sleep_icon =$sleep_uploadedFile;
        }


        $web_online_vehicle=$request->web_online_icon;
        if($web_online_vehicle){

        $getFileExt   = $web_online_vehicle->getClientOriginalExtension();
        $web_online_uploadedFile =   time().'_web_online_vehicle.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $web_online_vehicle->move($destinationPath,$web_online_uploadedFile);
        $vehicle_type->web_online_icon = $web_online_uploadedFile;
        }


        // online vehicle image
         // offline vehicle image
        $web_offline_vehicle=$request->web_offline_icon;
        if($web_offline_vehicle){
        $getFileExt   = $web_offline_vehicle->getClientOriginalExtension();
        $web_offline_uploadedFile =   time().'_web_offline_vehicle.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $web_offline_vehicle->move($destinationPath,$web_offline_uploadedFile);
        $vehicle_type->web_offline_icon = $web_offline_uploadedFile;
        }
        // online vehicle image
         // ideal vehicle image
        $web_idle_vehicle=$request->web_idle_icon;
        if($web_idle_vehicle){
        $getFileExt   = $web_idle_vehicle->getClientOriginalExtension();
        $web_idle_uploadedFile =   time().'_web_idle_icon.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $web_idle_vehicle->move($destinationPath,$web_idle_uploadedFile);
        $vehicle_type->web_idle_icon = $web_idle_uploadedFile;
        }
        // ideal vehicle image
        // sleep vehicle image
        $web_sleep_vehicle=$request->web_sleep_icon;
        if($web_sleep_vehicle){
        $getFileExt   = $web_sleep_vehicle->getClientOriginalExtension();
        $web_sleep_uploadedFile =   time().'_web_sleep_icon.'.$getFileExt;
        //Move Uploaded File
        $destinationPath = 'documents';
        $web_sleep_vehicle->move($destinationPath,$web_sleep_uploadedFile);
        // sleep vehicle image
        $vehicle_type->web_sleep_icon =$web_sleep_uploadedFile;
        }
        $rules = $this->vehicleTypeUpdateRules();
        $this->validate($request, $rules);
        $name = $request->name;
        $name = str_replace(' ', '_', $name);//replace spaces with underscore
        $name = strtolower($name); //convert string to lowercase
        $vehicle_type->name = $name;
        $vehicle_type->svg_icon = $request->svg_icon;

        $vehicle_type->vehicle_scale = $request->scale;
        $vehicle_type->opacity = $request->opacity;
        $vehicle_type->strokeWeight = $request->weight;
        $vehicle_type->save();
 // dd($request->svg_icon);
        $this->updateVehicleTypeApiResponse();

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
            ->with('gps:id,imei,serial_no');
            // ->get();
            return DataTables::of($vehicles)
            ->addIndexColumn()
            ->addColumn('dealer',function($vehicles){
                $vehicle = Vehicle::find($vehicles->id);
                return ( isset($vehicle->client->subdealer) ) ? $vehicle->client->subdealer->dealer->name : '';
               // return $vehicle->client->subdealer->dealer->name;

            })
            ->addColumn('sub_dealer',function($vehicles){
               $vehicle = Vehicle::find($vehicles->id);
                  if($vehicle->client->trader_id)
                 {
                     return $vehicle->client->trader->subDealer->name;
                 }
                 else{
                    return $vehicle->client->subdealer->name;
                 }
            })
             ->addColumn('trader',function($vehicles){
               $vehicle = Vehicle::find($vehicles->id);
               return ( isset($vehicle->client->trader) ) ? $vehicle->client->trader->name : '';
             })
             ->addColumn('serial_no',function($vehicles){
                return    $vehicles->gps->serial_no ?? '' ;
            })
            ->addColumn('vehicle_type_name',function($vehicles){
                return    $vehicles->vehicleType->name ?? '' ;
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
            ->make(true);
    }

    /////////////////////////////Vehicle Tracker/////////////////////////////
    public function location(Request $request)
    {
        $user=\Auth::user();
        $user_role=$user->roles->first()->name;
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
            if($user_role=='client')
            {
                return redirect(route('vehicle'));
            }
            else if($user_role=='root'){
                return redirect(route('vehicle-root'));
            }
        }
        else if($track_data->latitude==null || $track_data->longitude==null)
        {
            $request->session()->flash('message', 'No Data Received From GPS!!!');
            $request->session()->flash('alert-class', 'alert-success');
             if($user_role=='client')
            {
                return redirect(route('vehicle'));
            }
            else if($user_role=='root'){
                return redirect(route('vehicle-root'));
            }
        }
        else
        {
            $latitude=$track_data->latitude;
            $longitude= $track_data->longitude;
        }

        $snapRoute=$this->LiveSnapRoot($latitude,$longitude);
        $latitude=$snapRoute['lat'];
        $longitude=$snapRoute['lng'];

        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        if (strpos($url, $rayfleet_key) == true) {
                return view('Vehicle::vehicle-tracker-rayfleet',['Vehicle_id' => $decrypted_id,'vehicle_type' => $vehicle_type,'latitude' => $latitude,'longitude' => $longitude] );
        }
        else if (strpos($url, $eclipse_key) == true) {
            return view('Vehicle::vehicle-tracker',['Vehicle_id' => $decrypted_id,'vehicle_type' => $vehicle_type,'latitude' => $latitude,'longitude' => $longitude] );
        }
        else
        {
            return view('Vehicle::vehicle-tracker',['Vehicle_id' => $decrypted_id,'vehicle_type' => $vehicle_type,'latitude' => $latitude,'longitude' => $longitude] );
        }



    }
    public function locationTrack(Request $request)
    {
        $get_vehicle=Vehicle::find($request->id);
        $currentDateTime=Date('Y-m-d H:i:s');
        $last_update_time=date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.offline_time').""));
        $connection_lost_time_motion = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_motion').""));
        $connection_lost_time_halt = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_halt').""));
        $connection_lost_time_sleep = date('Y-m-d H:i:s',strtotime("".Config::get('eclipse.connection_lost_time_sleep').""));
        $offline="Offline";
        $signal_strength="Connection Lost";

        $track_data=Gps::select('lat as latitude',
                      'lon as longitude',
                      'heading as angle',
                      'mode as vehicleStatus',
                      'ac_status',
                      'speed',
                      'km',
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
                              'ac_status',
                              'fuel_status',
                              'km',
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
            //$connection_lost_time_minutes   = Carbon::createFromTimeStamp(strtotime($track_data->dateTime))->diffForHumans();
            $connection_lost_time_minutes = date('d-m-Y h:i:s a', strtotime($track_data->dateTime));
            $plcaeName=$this->getPlacenameFromLatLng($track_data->latitude,$track_data->longitude);
            $snapRoute=$this->LiveSnapRoot($track_data->latitude,$track_data->longitude);
            if(\Auth::user()->hasRole('pro|superior')){
                $gps_id= $get_vehicle->gps_id;

                $vehicle=Vehicle::select(
                    'id',
                    'gps_id',
                    'model_id',
                    'client_id'
                )
                ->where('gps_id',$gps_id)
                ->first();
                $model= $vehicle->model_id;
                $vehicle_models=VehicleModels::select(
                    'id',
                    'fuel_min',
                    'fuel_max'
                )
                ->where('id',$model)
                ->first();
                $fuel_status=$track_data->fuel_status;
            }
            else
            {
                $fuel_status="UPGRADE VERSION";
            }
            if(\Auth::user()->hasRole('fundamental|pro|superior')){
                $ac_status =$track_data->ac_status;
                if($ac_status == 1){
                    $ac_status="ON";
                }else{
                    $ac_status="OFF";
                }
            }
            else
            {
                $ac_status="UPGRADE VERSION";
            }
            $last_seen=date('d-m-Y h:i:s a', strtotime($track_data->dateTime));

            $gps_meter=$track_data->km;
            $gps_km=$gps_meter/1000;
            $odometer=round($gps_km);
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
                        "connection_lost_time_motion"=>$connection_lost_time_motion,
                        "connection_lost_time_halt"=>$connection_lost_time_halt,
                        "connection_lost_time_sleep"=>$connection_lost_time_sleep,
                        // "last_seen"=>$minutes,
                        "last_seen"=>$last_seen,
                        "connection_lost_time_minutes"=>$connection_lost_time_minutes,
                        "fuel"=>$fuel_status,
                        "ac"=>$ac_status,
                        "place"=>$plcaeName,
                        "fuelquantity"=>"",
                        "odometer"=>$odometer
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

    public function locationFirebase(Request $request)
    {
        $decrypted_vehicle_id   =   Crypt::decrypt($request->id);
        $vehicle_details        =   Vehicle::find($decrypted_vehicle_id);
        $vehicle_type_details   =   VehicleType::find($vehicle_details->vehicle_type_id);
        return view('Vehicle::vehicle-tracker-firebase',['vehicle_details' => $vehicle_details,'vehicle_type_details' => $vehicle_type_details]);
    }

    public function locationFirebaseHmapNew(Request $request)
    {
        $decrypted_vehicle_id   =   Crypt::decrypt($request->id);
        $vehicle_details        =   Vehicle::find($decrypted_vehicle_id);
        $vehicle_type_details   =   VehicleType::find($vehicle_details->vehicle_type_id);
        $track_data=Gps::select('lat as latitude',
                              'lon as longitude'
                              )
                              ->where('id',$vehicle_details->gps_id)
                              ->first();
        return view('Vehicle::vehicle-tracker-hmap-new',['vehicle_details' => $vehicle_details,'vehicle_type_details' => $vehicle_type_details,'latlong' => $track_data]);
    }
    /////////////////////////////Vehicle Tracker/////////////////////////////
    public function playback(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);
        return view('Vehicle::vehicle-playback',['Vehicle_id' => $decrypted_id] );

    }
     public function playbackB(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);
        $get_vehicle=Vehicle::find($decrypted_id);
        $vehicle_type=VehicleType::find($get_vehicle->vehicle_type_id);
        return view('Vehicle::playbak-second',['Vehicle_id' => $decrypted_id,'vehicle_type' =>$vehicle_type] );

    }

    public function playbackPageInTrack(Request $request){
        $decrypted_id = Crypt::decrypt($request->id);
         $get_vehicle=Vehicle::find($decrypted_id);
        $vehicle_type=VehicleType::find($get_vehicle->vehicle_type_id);
        return view('Vehicle::vehicle-playback-in-track',['vehicle_id' => $decrypted_id,'vehicle_type' =>$vehicle_type,'vehicle'=>$get_vehicle] );
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

    /*
    #HIDE

    public function export(Request $request){
        $from = $request->fromDate;
        $to = $request->toDate;
        $vehicle = $request->vehicle;
        if($vehicle!=0)
        {
            
            $vehicle_details=Vehicle::select('id','gps_id')
                                ->where('id',$vehicle)
                                ->withTrashed()
                                ->first();
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

    */

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

    /*
    #HIDE


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
*/

    /*
    #HIDE

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
    */
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
        $playBackDataList  = array();
        $playback          = array();
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
   /*
   #HIDE
    public function playbackPage(){
       return view('Vehicle::vehicle-playback-window');
    }
    */
    /*
   #HIDE
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
    */

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
            'odometer' => 'required|numeric|digits_between:0,7',
        ];
        return  $rules;
    }
    public function vehicleModelUpdateRules($vehicle)
    {
        $rules = [
            'model' => 'required',
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
            'path' => 'required|mimes:jpeg,jpg,png|max:2000'

        ];
        return  $rules;
    }

    public function customDocCreateRules(){
        $rules = [
            'vehicle_id' => 'required',
            'document_type_id' => 'required',
            'expiry_date' => 'required',
            'path' => 'required|mimes:jpeg,jpg,png|max:2000'

        ];
        return  $rules;
    }

    // document update rules
    public function documentUpdateRules()
    {
        $rules = [
            'vehicle_id' => 'required',
            'expiry_date' => 'required',
            'path'=>'max:2000|mimes:jpeg,jpg,png'

        ];
        return  $rules;
    }
// --------------------------------------------------------------------------------
    function getPlacenameFromLatLng($latitude,$longitude){
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.config('eclipse.keys.googleMap'));
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
        // if($lat != null){
        //     $route = $lat.",".$lng;
        //     $url = "https://roads.googleapis.com/v1/snapToRoads?path=".$route."&interpolate=true&key=".config('eclipse.keys.googleMap');
        //     $geocode_stats = file_get_contents($url);
        //     $output_deals = json_decode($geocode_stats);
        //     if (isset($output_deals->snappedPoints)) {
        //         $outPut_snap = $output_deals->snappedPoints;
        //         // var_dump($output_deals);
        //         if ($outPut_snap) {
        //             foreach ($outPut_snap as $ldata) {
        //                 $lat = $ldata->location->latitude;
        //                 $lng = $ldata->location->longitude;
        //             }
        //         }
        //     }
        // }
        $userData = ["lat" => $lat, "lng" => $lng];
        return $userData;

    }

/*
-------unsnapped location points-------------*/
     /*function LiveSnapRoot($b_lat, $b_lng) {
        $lat = $b_lat;
        $lng = $b_lng;

        $userData = ["lat" => $lat, "lng" => $lng];
        return $userData;

    }*/

    public function modelUpdate(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        $encrypted_gps_id = encrypt($request->id);
        // $gps = Gps::find($vehicle->gps_id);
        if($vehicle == null){
           return view('Vehicle::404');
        }
        $rules = $this->vehicleModelUpdateRules($vehicle);
        $this->validate($request, $rules);
        $vehicle->model_id = $request->model;
        $vehicle->save();
        $request->session()->flash('message', 'Vehicle model updated successfully!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('vehicles.details',$encrypted_gps_id));
    }

    public function fuelTrack(Request $request)
    {
        $gps_id=1;
        $gps_fuel=Gps::select('id','fuel_status')
        ->where('id',$gps_id)
        ->first();

        $vehicle=Vehicle::select(
            'id',
            'gps_id',
            'model_id',
            'client_id'
        )
        ->where('gps_id',$gps_id)
        ->first();
        $model= $vehicle->model_id;
        $vehicle_models=VehicleModels::select(
            'id',
            'fuel_min',
            'fuel_max'
        )
        ->where('id',$model)
        ->first();
        $fuel_status=$gps_fuel->fuel_status;
        // return response()->json($response_data);
    }


    public function updateVehicleTypeApiResponse(){
        $vehicle_types=VehicleType::all();
        $vehicle_type_list=[];
        foreach ($vehicle_types as $vehicle_type)
        {

           $vehicle_type_list[]=[
                                  "type"  => $vehicle_type->name,
                                  "icon"  =>[
                                    'online'=>$vehicle_type->online_icon,
                                    'offline'=>$vehicle_type->offline_icon,
                                    'ideal'=>$vehicle_type->ideal_icon,
                                    'sleep'=>$vehicle_type->sleep_icon,
                                  ]

                                ];
        }

        $vehicle_type_configration=Configuration::where('code','vehicle')->first();
        $vehicle_type_configration->value=json_encode($vehicle_type_list);
        $vehicle_type_configration->version=$vehicle_type_configration->version+0.1;
        return $vehicle_type_configration->save();
    }



    public function vehiclePlayback(Request $request)
    {
        $vehicleid           =   $request->vehicleid;
        $from_date           =   date("Y-m-d H:i:s", strtotime($request->fromDateTime));
        $to_date             =   date("Y-m-d H:i:s", strtotime($request->toDateTime));
        $get_vehicle         =   Vehicle::find($vehicleid);
        $gps_in_vehicle      =   [];
        $get_gps_in_vehicle  =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithSingleDate($vehicleid,date("Y-m-d", strtotime($request->fromDateTime)));
        foreach($get_gps_in_vehicle as $each_data)
        {
            $gps_in_vehicle[]   =   $each_data->gps_id;
        }
        $offset              =   $request->offset;
        if ($get_vehicle == null)
        {
            return response()->json([
                'status' => 'failed',
                'message' => 'vehicle is not activated',
                'code' => 0
            ]);
        }
        if ($offset == 0 || $offset == null)
        {
            $start_offset = 0;
            $limit = 30;
        }
        else
        {
            $limit = 30;
            $start_offset = $offset * $limit;
        }
        $gps_data_table                 =   "gps_data_".date("Ymd",strtotime($from_date));
        $is_table_exist_in_database     =   (new GpsData())->checkIfTableExistInDataBase($gps_data_table);
        if($is_table_exist_in_database)
        {
            $count_of_gpsdata               =   (new GpsData())->getCountGpsData($from_date,$to_date,$gps_in_vehicle,$gps_data_table);                  
            $total_index                    =   ceil($count_of_gpsdata / 30);
            $track_data                     =   (new GpsData())->getTrackData($from_date,$to_date,$gps_in_vehicle,$start_offset,$limit,$gps_data_table);
    
            
            $alerts_list            =   [];
            if($track_data->count() > 0)
            {
                $from_date_time   = $track_data->first()->dateTime;
                $last_date_time   = $track_data[$track_data->count()-1]->dateTime;
                $alerts_list      = Alert::select('device_time','gps_id','alert_type_id','latitude','longitude')->where('device_time', '>=' ,$from_date_time)
                                            ->where('device_time', '<=' ,$last_date_time)
                                            ->whereIn('gps_id',$gps_in_vehicle)
                                            ->whereNotIn('alert_type_id',[17,18,23,24])
                                            ->with('alertType')
                                            ->get();
                $km_updates       = KmUpdate::select('device_time','gps_id','km')
                                            ->where('device_time', '>=' ,$from_date_time)
                                            ->where('device_time', '<=' ,$last_date_time)
                                            ->whereIn('gps_id',$gps_in_vehicle)
                                            ->get();
                $response_data = array(
                                    'status'       => 'success',
                                    'message'      => 'success',
                                    'code'         => 1,
                                    'vehicle_type' => $get_vehicle->vehicleType->name,
                                    'total_offset' => $total_index,
                                    'playback'     => $track_data,
                                    'km_updates'   => $km_updates,
                                    'alerts'       => $alerts_list
                                    );
            }
            else
            {
                $response_data = array(
                    'status'    => 'failed',
                    'message'   => 'failed',
                    'code'      => 0
                );
            }
        }
        else
        {
            $response_data = array(
                'status'    => 'failed',
                'message'   => 'failed',
                'code'      => 0
            );
        }
        
        return response()->json($response_data);
    }

     /////////////////////////////Vehicle Tracker/////////////////////////////
    // public function vehicleLocationTrack(Request $request)
    // {
    //     $decrypted_id = Crypt::decrypt($request->id);
    //     $get_vehicle=Vehicle::find($decrypted_id);
    //     $vehicle_type=VehicleType::find($get_vehicle->vehicle_type_id);
    //     $track_data=Gps::select('lat as latitude',
    //                           'lon as longitude'
    //                           )
    //                           ->where('id',$get_vehicle->gps_id)
    //                           ->first();
    //     if($track_data==null)
    //     {
    //         $request->session()->flash('message', 'No Data Received From GPS!!!');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('vehicle'));
    //     }
    //     else if($track_data->latitude==null || $track_data->longitude==null)
    //     {
    //         $request->session()->flash('message', 'No Data Received From GPS!!!');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('vehicle'));
    //     }
    //     else
    //     {
    //         $latitude=$track_data->latitude;
    //         $longitude= $track_data->longitude;
    //     }

    //     $snapRoute=$this->LiveSnapRoot($latitude,$longitude);
    //     $latitude=$snapRoute['lat'];
    //     $longitude=$snapRoute['lng'];


    //     return view('Vehicle::vehicle-tracker-second',['Vehicle_id' => $decrypted_id,'vehicle_type' => $vehicle_type,'latitude' => $latitude,'longitude' => $longitude] );
    // }




    public function saveUploadDocuments(Request $request)
    {
        $messages = [
            'path.uploaded' => "The file size should be less than 2MB",
            'path.max' => 'The file size should be less than 2MB'
        ];
        if($request->document_type_id == 6 || $request->document_type_id == 7 || $request->document_type_id == 8)
        {
            $validator = Validator::make($request->all(), $this->documentCreateRules(),$messages);
            $expiry_date=null;
            if ($validator->fails())
            {
                $error = [];
                foreach($validator->getMessageBag()->toArray() as $key => $each_error)
                {
                    $error[$key] = $each_error[0];
                }
                $response = [
                    'count' => 0,
                    'data'  => [],
                    'error' => $error
                ];
            }
            else
            {
                $documents_count = Document::where('vehicle_id',$request->vehicle_id)->where('document_type_id',$request->document_type_id)->get();
                $data=[
                    'vehicle_id' => $request->vehicle_id,
                    'document_type_id' => $request->document_type_id,
                    'expiry_date' => $expiry_date,
                    'path'=>$request->path
                ];
                $file = $request->file('path');
                $getFileExt   = $file->getClientOriginalExtension();
                $uploadedFile =   time().'.'.$getFileExt;
                $destinationPath = 'documents/vehicledocs';

                if($documents_count->count()<2)
                {
                    $file->move($destinationPath,$uploadedFile);
                    $documents = Document::create([
                        'vehicle_id' => $request->vehicle_id,
                        'document_type_id' => $request->document_type_id,
                        'expiry_date' => $expiry_date,
                        'path' => $uploadedFile
                    ]);
                    $response = [
                        'count'=>$documents_count->count(),
                        'data'=>$data
                    ];
                }
                else
                {
                    $response = [
                        'count'=>3,
                        'data'=>$data
                    ];
                }
            }
        }
        else
        {
            $messages = [
                'path.uploaded' => "The file size should be less than 2MB",
                'path.max' => 'The file size should be less than 2MB'
            ];
            $validator = Validator::make($request->all(), $this->customDocCreateRules(),$messages);
            $expiry_date=date("Y-m-d", strtotime($request->expiry_date));
            if ($validator->fails())
            {
                $error = [];
                foreach($validator->getMessageBag()->toArray() as $key => $each_error)
                {
                    $error[$key] = $each_error[0];
                }
                $response = [
                    'count' => 0,
                    'data'  => [],
                    'error' => $error
                ];
            }
            else
            {
                $documents_count = Document::where('vehicle_id',$request->vehicle_id)->where('document_type_id',$request->document_type_id)->get();
                $data=[
                    'vehicle_id' => $request->vehicle_id,
                    'document_type_id' => $request->document_type_id,
                    'expiry_date' => $expiry_date,
                    'path'=>$request->path
                ];
                $file = $request->file('path');
                $getFileExt   = $file->getClientOriginalExtension();
                $uploadedFile =   time().'.'.$getFileExt;
                $destinationPath = 'documents/vehicledocs';

                if($documents_count->count()<2)
                {
                    if($documents_count->count()==0){

                        $file->move($destinationPath,$uploadedFile);
                        $documents = Document::create([
                            'vehicle_id' => $request->vehicle_id,
                            'document_type_id' => $request->document_type_id,
                            'expiry_date' => $expiry_date,
                            'path' => $uploadedFile
                        ]);
                        $response = [
                            'count'=>$documents_count->count(),
                            'data'=>$data
                        ];
                    }
                    else if($documents_count->first()->expiry_date==$expiry_date)
                    {
                        $file->move($destinationPath,$uploadedFile);
                        $documents = Document::create([
                            'vehicle_id' => $request->vehicle_id,
                            'document_type_id' => $request->document_type_id,
                            'expiry_date' => $expiry_date,
                            'path' => $uploadedFile
                        ]);
                        $response = [

                            'count'=>$documents_count->count(),
                            'data'=>$data
                        ];
                    }
                    else{
                        $response = [
                            'count'=>4,
                            'data'=>$data
                        ];
                    }
                }
                else
                {
                    $response = [
                        'count'=>3,
                        'data'=>$data
                    ];
                }
            }
        }

        return response()->json($response);
    }

    public function saveUploads(Request $request)
    {
        $expiry_date=date("Y-m-d", strtotime($request->expiry_date));
        $documents_to_delete = Document::where('vehicle_id',$request->vehicle_id)->where('document_type_id',$request->document_type_id)->get();
        foreach ($documents_to_delete as $document_to_delete) {
            $delete_document = Document::find($document_to_delete->id);
            $delete_document->delete();
        }
        $file = $request->file('path');
        $getFileExt   = $file->getClientOriginalExtension();
        $uploadedFile =   time().'.'.$getFileExt;
        $destinationPath = 'documents/vehicledocs';
        $file->move($destinationPath,$uploadedFile);
        $documents = Document::create([
            'vehicle_id' => $request->vehicle_id,
            'document_type_id' => $request->document_type_id,
            'expiry_date' => $expiry_date,
            'path' => $uploadedFile
        ]);
        $response = [
            'status' => 'success',
            'alerts' => $documents
        ];
        return response()->json($response);
    }


    public function saveEditUploadDocuments(Request $request)
    {
        $expiry_date=date("Y-m-d", strtotime($request->expiry_date));
        $documents = Document::where('id',$request->id)->first();
         if($request->path){
            $messages = [
                'path.uploaded' => "The file size should be less than 2MB",
                'path.max' => 'The file size should be less than 2MB'
            ];
            $validator = Validator::make($request->all(), $this->customDocCreateRules(),$messages);
            if ($validator->fails())
            {
                $error = [];
                foreach($validator->getMessageBag()->toArray() as $key => $each_error)
                {
                    $error[$key] = $each_error[0];
                }
                $response = [
                    'count' => 0,
                    'data'  => []
                ];
            }
            else{
                $documents_count = Document::where('vehicle_id',$request->vehicle_id)->where('document_type_id',$request->document_type_id)->get();
            if($documents_count->count()>=1){
                    if($documents_count->first()->expiry_date==$expiry_date)
                    {
                        $file = $request->file('path');
                        if($file){
                            $getFileExt   = $file->getClientOriginalExtension();
                            $uploadedFile =   time().'.'.$getFileExt;
                            $destinationPath = 'documents/vehicledocs';
                            // dd($request->id);
                            $file->move($destinationPath,$uploadedFile);
                            $documents->path=$uploadedFile;
                        }

                        $documents->expiry_date=$expiry_date;
                        $documents->save();
                        $response = [
                            'count'=>$documents_count->count(),
                            // 'data'=>$data
                        ];
                    }
                    else
                    {
                        $response = [
                            'count'=>3,
                            // 'data'=>$data
                        ];
                    }
                }

            }


        }

            else
            {

                $documents_count = Document::where('vehicle_id',$request->vehicle_id)->where('document_type_id',$request->document_type_id)->get();

                if($documents_count->count()>=1){
                    if($documents_count->first()->expiry_date==$expiry_date)
                    {
                        $documents->expiry_date=$expiry_date;
                        $documents->save();
                        $response = [
                            'count'=>$documents_count->count(),
                            // 'data'=>$data
                        ];
                    }
                    else
                    {
                        $response = [
                            'count'=>3,
                            // 'data'=>$data
                        ];
                    }
                }

        }

        return response()->json($response);
    }


    public function saveEditUploads(Request $request)
    {
        $expiry_date=date("Y-m-d", strtotime($request->expiry_date));
        $documents_to_delete = Document::where('vehicle_id',$request->vehicle_id)->where('document_type_id',$request->document_type_id)->get();
        foreach ($documents_to_delete as $document_to_delete) {
            $delete_document = Document::find($document_to_delete->id);
            $delete_document->expiry_date=$expiry_date;
            $delete_document->save();
        }
        $file = $request->file('path');
        $documents = Document::find($request->id);
        if($file){
            $getFileExt   = $file->getClientOriginalExtension();
            $uploadedFile =   time().'.'.$getFileExt;
            $destinationPath = 'documents/vehicledocs';
            $file->move($destinationPath,$uploadedFile);

            $documents->path=$uploadedFile;
            $documents->save();
        }
        $response = [
            'status' => 'success',
            'alerts' => $documents
        ];
        return response()->json($response);
    }

    public function Playbackkm(Request $request)
    {

        $response = KmUpdate::select('km')->where('gps_id',$request->gps)->where('lat',$request->lat)->where('lng',$request->lng);
        // dd($response)
        
        return $response;
    }




}
