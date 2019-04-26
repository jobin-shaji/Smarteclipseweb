<?php 


namespace App\Modules\Gps\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Depot\Models\Depot;

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