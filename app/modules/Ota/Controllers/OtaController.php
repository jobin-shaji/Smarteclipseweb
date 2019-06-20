<?php


namespace App\Modules\Ota\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Ota\Models\OtaType;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use DataTables;

class OtaController extends Controller {
    
    
///////////////////////// OTA TYPE ////////////////////////////////////////////////

    // show list page
    public function otaTypeList()
    {
       return view('Ota::ota-type-list'); 
    }

    // data for list page
    public function getOtaTypeList()
    {
        $ota_type = OtaType::select(
                    'id',
                    'name',
                    'code',
                    'deleted_at'
                    )
            ->withTrashed()
            ->get();
        return DataTables::of($ota_type)
            ->addIndexColumn()
            ->addColumn('action', function ($ota_type) {
                if($ota_type->deleted_at == null){
                    return "

                    <a href=/ota-type/".Crypt::encrypt($ota_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/ota-type/".Crypt::encrypt($ota_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=deleteOtaType(".$ota_type->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>"; 
                }else{
                     return "
                    <a href=/ota-type/".Crypt::encrypt($ota_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/ota-type/".Crypt::encrypt($ota_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateOtaType(".$ota_type->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate </button>"; 
                }
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // create a new Ota
    // public function createOtaType()
    // {
    //     $client_id=\Auth::user()->client->id;
    //     $client_user_id=\Auth::user()->id;
    //     $vehicleTypes=VehicleType::select(
    //             'id','name')->get();
    //     $vehicle_device = Vehicle::select(
    //             'gps_id'
    //             )
    //             ->where('client_id',$client_id)
    //             ->get();
    //     $single_gps = [];
    //     foreach($vehicle_device as $device){
    //         $single_gps[] = $device->gps_id;
    //     }
    //     $devices=Gps::select('id','name','imei')
    //             ->where('user_id',$client_user_id)
    //             ->whereNotIn('id',$single_gps)
    //             ->get();
    //     return view('Vehicle::vehicle-add',['vehicleTypes'=>$vehicleTypes,'devices'=>$devices]);
    // }

    // // save Ota
    // public function saveOtaType(Request $request)
    // {
    //     $client_id=\Auth::user()->client->id;
    //     $rules = $this->vehicleCreateRules();
    //     $this->validate($request, $rules);
    //     $vehicle = Vehicle::create([
    //         'name' => $request->name,
    //         'register_number' => $request->register_number,
    //         'vehicle_type_id' => $request->vehicle_type_id,
    //         'e_sim_number' => $request->e_sim_number,
    //         'gps_id' => $request->gps_id,
    //         'client_id' =>$client_id,
    //         'status' =>1
    //     ]);
    //     if($vehicle){
    //         $vehicle_ota = VehicleOta::create([
    //             'client_id' => $client_id,
    //             'vehicle_id' => $vehicle->id,
    //             'PU' => "",
    //             'EU' => "",
    //             'EM' => "",
    //             'EO' => "",
    //             'ED' => "",
    //             'APN' => "",
    //             'ST' => "",
    //             'SL' => "",
    //             'HBT' => "",
    //             'HAT' => "",
    //             'RTT' => "",
    //             'LBT' => "",
    //             'VN' => "",
    //             'UR' => "",
    //             'URS' => "",
    //             'URE' => "",
    //             'URF' => "",
    //             'URH' => "",
    //             'VID' => "",
    //             'FV' => "",
    //             'DSL' => "",
    //             'HT' => "",
    //             'M1' => "",
    //             'M2' => "",
    //             'M3' => "",
    //             'GF' => "",
    //             'OM' => "",
    //             'OU' => ""
    //         ]);
    //     }
    //     $request->session()->flash('message', 'New Vehicle created successfully!'); 
    //     $request->session()->flash('alert-class', 'alert-success'); 
    //     return redirect(route('vehicle'));
    // }
    
    // // edit Ota
    // public function editOtaType(Request $request)
    // {
    //     $decrypted_id = Crypt::decrypt($request->id);
    //     $client_id=\Auth::user()->client->id;
    //     $vehicle = Vehicle::find($decrypted_id);
    //     if($vehicle == null){
    //         return view('Vehicle::404');
    //     }
    //     $routes=Route::where('client_id',$client_id)
    //                     ->get();
    //     return view('Vehicle::vehicle-edit',['vehicle' => $vehicle,'routes' => $routes]);
    // }

    // // update Ota
    // public function updateOtaType(Request $request)
    // {
    //     $vehicle = Vehicle::find($request->id);
    //     if($vehicle == null){
    //        return view('Vehicle::404');
    //     }
    //     $rules = $this->vehicleUpdateRules($vehicle);
    //     $this->validate($request, $rules);
    //     $vehicle->e_sim_number = $request->e_sim_number;
    //     $vehicle->save();

    //     $encrypted_vehicle_id = encrypt($vehicle->id);
    //     $request->session()->flash('message', 'Vehicle details updated successfully!'); 
    //     $request->session()->flash('alert-class', 'alert-success'); 
    //     return redirect(route('vehicle.edit',$encrypted_vehicle_id));  
    // }
    // // details page
    // public function otaTypedetails(Request $request)
    // {
    //     $decrypted_id = Crypt::decrypt($request->id);
    //     $vehicle=Vehicle::find($decrypted_id);
    //     if($vehicle==null){
    //         return view('Vehicle::404');
    //     } 
    //     return view('Vehicle::vehicle-details',['vehicle' => $vehicle]);
    // }

    // // vehicle delete
    // public function deleteOtaType(Request $request)
    // {
    //     $vehicle=Vehicle::find($request->vid);
    //     if($vehicle == null){
    //        return response()->json([
    //             'status' => 0,
    //             'title' => 'Error',
    //             'message' => 'Vehicle does not exist'
    //         ]);
    //     }
    //     $vehicle->delete(); 
    //     return response()->json([
    //         'status' => 1,
    //         'title' => 'Success',
    //         'message' => 'Vehicle deleted successfully'
    //     ]);
    //  }


    // // restore vehicle
    // public function activateOtaType(Request $request)
    // {       
    //     $vehicles = Vehicle::where('gps_id', $request->gps_id)->first();        
    //     if($vehicles== null)
    //     {
    //         $vehicle = Vehicle::withTrashed()->find($request->id);  
    //         if($vehicle==null){
    //             return response()->json([
    //                 'status' => 0,
    //                 'title' => 'Error',
    //                 'message' => 'Vehicle does not exist'
    //             ]);
    //         }
    //         $vehicle->restore();
    //         return response()->json([
    //             'status' => 1,
    //             'title' => 'Success',
    //             'message' => 'Vehicle restored successfully'
    //         ]);
    //     }
    //     return response()->json([
    //         'status' => 0,
    //         'title' => 'Error',
    //         'message' => 'gps already asigned'
    //     ]);
    // }

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
            'e_sim_number' => 'required|numeric'
        ];
        return  $rules;  
    }

    

}
