<?php 


namespace App\Modules\Gps\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Gps\Models\GpsLocation;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\User\Models\User;

use DataTables;

class GpsController extends Controller {

    //Display all gps
	public function gpsListPage()
    {
		return view('Gps::gps-list');
	}

	//returns gps as json 
    public function getGps()
    {
        $gps = Gps::select(
                'id',
                'name',
            	'imei',
            	'manufacturing_date',
            	'version',
                'deleted_at')
                ->withTrashed()
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->addColumn('action', function ($gps) {
                if($gps->deleted_at == null){
                    return "
                    <a href=/gps/".$gps->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/gps/".$gps->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=delGps(".$gps->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                    </button>";
                }else{
                     return "
                    <a href=/gps/".$gps->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/gps/".$gps->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateGps(".$gps->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate
                    </button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //for gps creation
    public function create()
    {
        return view('Gps::gps-create');
    }

    //upload gps details to database table
    public function save(Request $request)
    {
        $rules = $this->gpsCreateRules();
        $this->validate($request, $rules);
        $gps = Gps::create([
            'name'=> $request->name,
            'imei'=> $request->imei,
            'manufacturing_date'=> date("Y-m-d", strtotime($request->manufacturing_date)),
            'version'=> $request->version,
            'status'=>1
        ]);
        $request->session()->flash('message', 'New gps created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('gps.details',$gps->id));
    } 

    //view gps details
    public function details(Request $request)
    {
        $gps = Gps::find($request->id);
        if($gps == null){
           return view('Gps::404');
        }
       return view('Gps::gps-details',['gps' => $gps]);
    } 

    //edit gps details
    public function edit(Request $request)
    {
        $gps = Gps::find($request->id);
        if($gps == null){
           return view('Gps::404');
        }
       return view('Gps::gps-edit',['gps' => $gps]);
    }

    //update gps details to database table
    public function update(Request $request){
        $gps = Gps::find($request->id);
        if($gps == null){
           return view('Gps::404');
        }
        $rules = $this->gpsUpdateRules($gps);
        $this->validate($request, $rules);

        $gps->name = $request->name;
        $gps->imei = $request->imei;
        $gps->manufacturing_date = $request->manufacturing_date;
        $gps->version = $request->version;
        $gps->save();

        $request->session()->flash('message', ' Gps updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('gps.edit',$gps));  
    }

    //delete gps details
    public function deleteGps(Request $request){
        $gps = Gps::find($request->uid);
        if($gps == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Gps does not exist'
            ]);
        }
        $gps->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps deleted successfully'
        ]);
    }

    // restore gps 
    public function activateGps(Request $request)
    {
        $gps = Gps::withTrashed()->find($request->id);
        if($gps==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Gps does not exist'
             ]);
        }

        $gps->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Gps restored successfully'
        ]);
    }

    public function addLocation(Request $request){
        $gps = GpsLocation::create([
            'data'=> $request->data,
        ]);
    }

    //validation for gps creation
    public function gpsCreateRules(){
        $rules = [
            'name' => 'required',
            'imei' => 'required|string|min:15|unique:gps',
            'manufacturing_date' => 'required',
            'version' => 'required'
        ];
        return  $rules;
    }

    //validation for gps updation
    public function gpsUpdateRules($gps){
        $rules = [
            'name' => 'required',
            'imei' => 'required|string|min:15|unique:gps,imei,'.$gps->id,
            'manufacturing_date' => 'required',
            'version' => 'required',
        ];
        return  $rules;
    }  

    ///////////////////////////Gps Transfer////////////////////////////////

    // gps transfer list
    public function getList() 
    {
        return view('Gps::gps-transfer-list');
    }

    // gps transfer list data
    public function getListData() 
    {
 
        $gps_transfer = GpsTransfer::select('id', 'etmID', 'from_depot', 'to_depot', 'tarnferDate')
        ->with('fromDepotDetails:id,name')
        ->with('toDepotDetails:id,name')
        ->with('etmDetails:id,name')
        ->get();
        return DataTables::of($etm_transfer)
        ->addIndexColumn()
        ->make();
    }

    // create gps transfer
    public function createGpsTransfer(Request $request) 
    {
        if($request->user()->hasRole('root')){
            $devices = Gps::select('id', 'name', 'imei','dealer_id')
            ->get();
            $users = User::role('dealer')->get();
        }
        
        return view('Gps::gps-transfer', ['devices' => $devices, 'users' => $users]);
    }
    // save gps transfer
    public function saveTransfer(Request $request) 
    {
       
        $rules = $this->gpsTransferRule();
        $this->validate($request, $rules);
        $gps_transfer = GpsTransfer::create([
          "gps_id" => $request->gps_id, 
          "from_user" => $request->from_user, 
          "to_user" => $request->to_user,
          "transfer_date" => date('Y-m-d H:i:s')]
          );
        //update gps table
        $gps_id = $request->gps_id;
        $gps = Gps::find($gps_id);
        $gps->dealer_id = $request->to_user;
        $gps->save();
        $request->session()->flash('message', 'Gps Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('gps-transfers'));
    }

    // gps user details
    public function userData(Request $request) 
    {
        $gps = Gps::find($request->gpsID);    
        $dealer = $gps->dealer;     
        return response()->json(array('response' => 'success', 'gps' => $gps , 'dealer' => $dealer));
    }

    // etm transfer rule
    public function etmTransferRule() {
        $rules = [
          'gps_id' => 'required',
          'from_user' => 'nullable',
          'to_user' => 'required'];
        return $rules;
    }
}