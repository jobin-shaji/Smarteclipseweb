<?php
namespace App\Modules\Operations\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Operations\Models\Operations;
use App\Modules\Operations\Models\VehicleMake;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class VehicleMakeController extends Controller {
    public function create()
    {
       return view('Operations::vehicle-make-create');
    }
    public function save(Request $request)
    {
        $rules = $this->vehicle_make_rules();
        $this->validate($request, $rules);       
        $vehicle = VehicleMake::create([
            'name' => $request->name
        ]);
        $request->session()->flash('message', 'created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle.make.create')); 
    }
    public function vehicleMakeListPage()
    {
        return view('Operations::vehicle-make-list');
    }
    public function getVehicleMake()
    {
        $vehicle_make = VehicleMake::select(
            'id', 
            'name',                                                           
            'deleted_at'
        )
        ->withTrashed()
        ->get();
        return DataTables::of($vehicle_make)
        ->addIndexColumn()
        ->addColumn('action', function ($vehicle_make) {
             $b_url = \URL::to('/');
            if($vehicle_make->deleted_at == null){ 
            return "           
            <a href=".$b_url."/vehicle-make/".Crypt::encrypt($vehicle_make->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
           
            ";
            }else{ 
            return "";
            }
        })
        ->rawColumns(['link', 'action','working_status'])
        ->make();
    }
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $vehicle_make = VehicleMake::where('id', $decrypted)->first();        
        if($vehicle_make == null){
            return view('Operations::404');
        }
        return view('Operations::vehicle-make-edit',['vehicle_make' => $vehicle_make]);
    }
    public function update(Request $request)
    {  
        $vehicle_make = VehicleMake::where('id', $request->id)->first();
        if($vehicle_make == null){
           return view('Operations::404');
        } 
        $rules = $this->vehicleMakeUpdatesRules($vehicle_make);
        $this->validate($request, $rules);   
        $vehicle_make->name = $request->name;
        $vehicle_make->save();
        $did = encrypt($vehicle_make->id);
        $request->session()->flash('message', 'vehicle make details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('vehicle.make.edit',$did));  
    }
    
    public function disableVheicleMake(Request $request)
    {
        $vehicle_make = VehicleMake::find($request->id);       
        if($vehicle_make == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'vehicle make does not exist'
            ]);
        }
        $vehicle_make->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Vehicle make disabled successfully'
        ]);
    }
    public function enableVheicleMake(Request $request)
    {
        $vehicle_make = VehicleMake::withTrashed()->find($request->id);
        if($vehicle_make==null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Vehicle make does not exist'
            ]);
        }
        $vehicle_make->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Vehicle make enabled successfully'
        ]);
    }
    public function vehicleMakeUpdatesRules($vehicle_make)
    {
        $rules = [
            'name' => 'required'
        ];
        return  $rules;
    }
    public function vehicle_make_rules(){
        $rules = [
            'name' => 'required'
        ];
        return  $rules;
    }
}
