<?php 


namespace App\Modules\Etm\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Etm\Models\Etm;
use App\Modules\Depot\Models\Depot;

use DataTables;

class EtmController extends Controller {

    //Display all etms
	public function etmListPage()
    {
		return view('Etm::etm-list');
	}

	//returns etm as json 
    public function getEtms()
    {
        $etm = Etm::select(
                'id',
                'name',
            	'imei',
            	'purchase_date',
            	'version',
                'depot_id',
                'deleted_at')
                ->withTrashed()
                ->with('depot:id,name')
                ->with('deviceInfo')
                ->get();
        return DataTables::of($etm)
            ->addIndexColumn()
            ->addColumn('battery_percentage',function($etm){
                $info = $etm->deviceInfo->first();
                if($info){
                    return $info->battery_percentage;
                }else{
                    return "Unavailable";
                }
            })
            ->addColumn('button_count',function($etm){
                $info = $etm->deviceInfo->first();
                if($info){
                    return $info->button_count;
                }else{
                    return "Unavailable";
                }
            })
            ->addColumn('device_status',function($etm){
                $info = $etm->deviceInfo->first();
                if($info){
                    $online_time=$info->created_at;
                    $check_time = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -02 minutes"));
                    if($online_time >= $check_time){
                        return "Online";
                    }else{
                        return "offline";
                    }
                }else{
                    return "Unavailable";
                }
            })
            ->addColumn('action', function ($etm) {
                if($etm->deleted_at == null){
                    return "
                    <a href=/etm/".$etm->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/etm/".$etm->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=delEtm(".$etm->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                    </button>";
                }else{
                     return "
                    <a href=/etm/".$etm->id."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/etm/".$etm->id."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateEtm(".$etm->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate
                    </button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //for etm creation
    public function create()
    {
        $depots=Depot::select([
            'id',
            'name',
            'code'
            ])
            ->get();
        return view('Etm::etm-create',['depots'=>$depots]);
    }

    //upload etm details to database table
    public function save(Request $request)
    {
        $rules = $this->etmCreateRules();
        $this->validate($request, $rules);
        $etm = Etm::create([
            'name'=> $request->name,
            'imei'=> $request->imei,
            'purchase_date'=> date("Y-m-d", strtotime($request->purchase_date)),
            'version'=> $request->version,
            'depot_id'=>$request->depot,
            'status'=>1
        ]);
        $request->session()->flash('message', 'New etm created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('etm.details',$etm->id));
    } 

    //view etm details
    public function details(Request $request)
    {
        $etm = Etm::find($request->id);
        if($etm == null){
           return view('Etm::404');
        }
       return view('Etm::etm-details',['etm' => $etm]);
    } 

    //edit etm details
    public function edit(Request $request)
    {
        $etm = Etm::find($request->id);
        if($etm == null){
           return view('Etm::404');
        }
       return view('Etm::etm-edit',['etm' => $etm]);
    }

    //update etm details to database table
    public function update(Request $request){
        $etm = Etm::find($request->id);
        if($etm == null){
           return view('Etm::404');
        }
        $rules = $this->etmUpdateRules($etm);
        $this->validate($request, $rules);

        $etm->name = $request->name;
        $etm->imei = $request->imei;
        $etm->purchase_date = $request->purchase_date;
        $etm->version = $request->version;
        $etm->save();

        $request->session()->flash('message', ' ETM updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('etm.edit',$etm));  
    }

    //delete etm details
    public function deleteEtm(Request $request){
        $etm = Etm::find($request->uid);
        if($etm == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'ETM does not exist'
            ]);
        }
        $etm->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'ETM deleted successfully'
        ]);
    }

    // restore etm 
    public function activateEtm(Request $request)
    {
        $etm = Etm::withTrashed()->find($request->id);
        if($etm==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Etm does not exist'
             ]);
        }

        $etm->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Etm restored successfully'
        ]);
    }

    //validation for etm creation
    public function etmCreateRules(){
        $rules = [
            'name' => 'required',
            'imei' => 'required|string|min:15|unique:etms',
            'purchase_date' => 'required',
            'version' => 'required',
            'depot' => 'required'
        ];
        return  $rules;
    }

    //validation for etm updation
    public function etmUpdateRules($etm){
        $rules = [
            'name' => 'required',
            'imei' => 'required|string|min:15|unique:etms,imei,'.$etm->id,
            'purchase_date' => 'required',
            'version' => 'required',
        ];
        return  $rules;
    }  
}