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
        $root_id=\Auth::user()->id;
        $rules = $this->gpsCreateRules();
        $this->validate($request, $rules);
        $gps = Gps::create([
            'name'=> $request->name,
            'imei'=> $request->imei,
            'manufacturing_date'=> date("Y-m-d", strtotime($request->manufacturing_date)),
            'version'=> $request->version,
            'user_id' => $root_id,
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


    //////////////////////////GPS DEALER///////////////////////////////////

    //Display all dealer gps
    public function gpsDealerListPage()
    {
        return view('Gps::gps-dealer-list');
    } 

    //returns gps as json 
    public function getDealerGps()
    {
        $dealer_id=\Auth::user()->id;
        $gps = Gps::select(
                'id',
                'name',
                'imei',
                'deleted_at')
                ->withTrashed()
                ->where('user_id',$dealer_id)
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->make();
    }

    //////////////////////////GPS SUB DEALER///////////////////////////////////

    //Display all dealer gps
    public function gpsSubDealerListPage()
    {
        return view('Gps::gps-sub-dealer-list');
    } 

    //returns gps as json 
    public function getSubDealerGps()
    {
        $sub_dealer_id=\Auth::user()->id;
        $gps = Gps::select(
                'id',
                'name',
                'imei',
                'deleted_at')
                ->withTrashed()
                ->where('user_id',$sub_dealer_id)
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->make();
    }

    //////////////////////////GPS SUB DEALER///////////////////////////////////

    //Display all dealer gps
    public function gpsClientListPage()
    {
        return view('Gps::gps-client-list');
    } 

    //returns gps as json 
    public function getClientGps()
    {
        $client_id=\Auth::user()->id;
        $gps = Gps::select(
                'id',
                'name',
                'imei',
                'deleted_at')
                ->withTrashed()
                ->where('user_id',$client_id)
                ->get();
        return DataTables::of($gps)
            ->addIndexColumn()
            ->make();
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
        $user_id=\Auth::user()->id;
        $gps_transfer = GpsTransfer::select('id', 'gps_id', 'from_user_id', 'to_user_id', 'transfer_date')
        ->with('fromUser:id,username')
        ->with('toUser:id,username')
        ->with('gps:id,name,imei')
        ->where('from_user_id',$user_id)
        ->get();
        return DataTables::of($gps_transfer)
        ->addIndexColumn()
        ->make();
    }

    // create gps transfer
    public function createGpsTransfer(Request $request) 
    {
        if($request->user()->hasRole('root')){
            $user = \Auth::user();
            $root = $user->root;
            $devices = Gps::select('id', 'name', 'imei','user_id')
                            ->where('user_id',$user->id)
                            ->get();
            $entities = $root->dealers;
        }else if($request->user()->hasRole('dealer')){
            $user = \Auth::user();
            $dealer = $user->dealer;
            $devices = Gps::select('id', 'name', 'imei','user_id')
                            ->where('user_id',$user->id)
                            ->get();
            $entities = $dealer->subDealers;
        }else if($request->user()->hasRole('sub_dealer')){
            $user = \Auth::user();
            $sub_dealer=$user->subdealer;
            $devices = Gps::select('id', 'name', 'imei','user_id')
                            ->where('user_id',$user->id)
                            ->get();
            $entities = $sub_dealer->clients;
        }
        
        return view('Gps::gps-transfer', ['devices' => $devices, 'entities' => $entities]);
    }
    // save gps transfer
    public function saveGpsTransfer(Request $request) 
    {
        $rules = $this->gpsTransferRule();
        $this->validate($request, $rules);
        $gps_id = $request->gps_id;
        $from_user_id = $request->from_user_id;
        $to_user_id = $request->to_user_id;
        $gps_transfer = GpsTransfer::create([
          "gps_id" => $gps_id, 
          "from_user_id" => $from_user_id, 
          "to_user_id" => $to_user_id,
          "transfer_date" => date('Y-m-d H:i:s')]
          );
        //update gps table
        $gps_id = $request->gps_id;
        $gps = Gps::find($gps_id);
        $gps->user_id = $request->to_user_id;
        $gps->save();
        $request->session()->flash('message', 'Gps Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('gps-transfers'));
    }

    // gps user details
    public function userData(Request $request) 
    {
        $gps = Gps::find($request->gpsID);    
        $user = $gps->user;     
        return response()->json(array('response' => 'success', 'gps' => $gps , 'user' => $user));
    }

    // gps transfer rule
    public function gpsTransferRule() {
        $rules = [
          'gps_id' => 'required',
          'from_user_id' => 'nullable',
          'to_user_id' => 'required'];
        return $rules;
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
}