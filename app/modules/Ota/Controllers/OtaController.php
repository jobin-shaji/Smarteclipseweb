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
                    'default_value',
                    'deleted_at'
                    )
            ->withTrashed()
            ->get();
        return DataTables::of($ota_type)
            ->addIndexColumn()
            ->addColumn('action', function ($ota_type) {
                $b_url = \URL::to('/');
                if($ota_type->deleted_at == null){
                    return "

                    <a href=".$b_url."/ota-type/".Crypt::encrypt($ota_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=".$b_url."/ota-type/".Crypt::encrypt($ota_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=deleteOtaType(".$ota_type->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>"; 
                }else{
                     return "
                    <a href=".$b_url."/ota-type/".Crypt::encrypt($ota_type->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=".$b_url."/ota-type/".Crypt::encrypt($ota_type->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateOtaType(".$ota_type->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i> Activate </button>"; 
                }
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // create a new Ota type
    public function createOtaType()
    {
        return view('Ota::ota-type-create');
    }

    // save Ota type
    public function saveOtaType(Request $request)
    {
        $rules = $this->otaTypeCreateRules();
        $this->validate($request, $rules);
        $ota_type = OtaType::create([
            'name' => $request->name,
            'code' => $request->code,
            'default_value' => $request->default_value
        ]);
        $request->session()->flash('message', 'New ota type created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('ota-type'));
    }
    
    // edit Ota type
    public function editOtaType(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $ota_type = OtaType::find($decrypted_id);
        if($ota_type == null){
            return view('Ota::404');
        }
        return view('Ota::ota-type-edit',['ota_type' => $ota_type]);
    }

    // update Ota type
    public function updateOtaType(Request $request)
    {
        $ota_type = OtaType::find($request->id);
        if($ota_type == null){
           return view('Ota::404');
        }
        $rules = $this->otaTypeCreateRules();
        $this->validate($request, $rules);
        $ota_type->name = $request->name;
        $ota_type->code = $request->code;
        $ota_type->default_value = $request->default_value;
        $ota_type->save();

        $encrypted_ota_type_id = encrypt($ota_type->id);
        $request->session()->flash('message', 'Ota type updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('ota-type.edit',$encrypted_ota_type_id));  
    }

    // ot a type view page
    public function otaTypedetails(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $ota_type=OtaType::find($decrypted_id);
        if($ota_type==null){
            return view('Ota::404');
        } 
        return view('Ota::ota-type-details',['ota_type' => $ota_type]);
    }

    // OTA TYPE delete
    public function deleteOtaType(Request $request)
    {
        $ota_type=OtaType::find($request->id);
        if($ota_type == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Ota type does not exist'
            ]);
        }
        $ota_type->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Ota type deleted successfully'
        ]);
     }


    // restore ota type
    public function activateOtaType(Request $request)
    {       
        $ota_type = OtaType::withTrashed()->find($request->id);
        if($ota_type==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Ota type does not exist'
             ]);
        }

        $ota_type->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Ota type restored successfully'
        ]);
    }

    //////////////////////////////////////RULES/////////////////////////////
    // ota type create rules
    public function otaTypeCreateRules()
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'default_value' => 'nullable'
        ];
        return  $rules;
    }

}
