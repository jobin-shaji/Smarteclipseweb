<?php
namespace App\Modules\ClassDivision\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\ClassDivision\Models\ClassDivision;
use App\Modules\SchoolClass\Models\SchoolClass;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class DivisionController extends Controller {
   
    //division creation page
    public function create()
    {
        $classes=SchoolClass::select([
            'id',
            'name'  
        ])
        ->get();  
        return view('ClassDivision::division-create',['classes' => $classes]);
    }

    //upload division details to database table
    public function save(Request $request)
    {    
        $client_id = \Auth::user()->client->id;
        $rules = $this->divisionCreateRules();
        $this->validate($request, $rules);           
        $division = ClassDivision::create([  
            'class_id' => $request->class_id,           
            'name' => $request->name,            
            'school_id' => $client_id       
        ]);
        $eid= encrypt($division->id);
        $request->session()->flash('message', 'New division created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('division'));        
    }

    //division list
    public function divisionList()
    {
        return view('ClassDivision::division-list');
    }

    public function getDivisionlist(Request $request)
    {
        $division = ClassDivision::select(
            'id', 
            'name',
            'class_id',
            'deleted_at')
            ->withTrashed()
            ->with('class:id,name')
            ->get();
            return DataTables::of($division)
            ->addIndexColumn()
            ->addColumn('action', function ($division) {
                 $b_url = \URL::to('/');
            if($division->deleted_at == null){ 
                return "
                <button onclick=delDivision(".$division->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>
                <a href=".$b_url."/division/".Crypt::encrypt($division->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                ";
            }else{                   
                return "
                <button onclick=activateDivision(".$division->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Ativate</button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //edit division details
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $division = ClassDivision::find($decrypted); 
        $classes=SchoolClass::select([
                    'id',
                    'name'  
                ])
                ->get();      
        if($division == null)
        {
           return view('ClassDivision::404');
        }
        return view('ClassDivision::division-edit',['division' => $division,'classes' => $classes]);
    }

    //update division details
    public function update(Request $request)
    {
        $division = ClassDivision::where('id', $request->id)->first();
        if($division == null){
           return view('ClassDivision::404');
        } 
        $rules = $this->divisionUpdateRules($division);
        $this->validate($request, $rules); 
        $division->class_id = $request->class_id;      
        $division->name = $request->name;
        $division->save();      
        $did = encrypt($division->id);
        $request->session()->flash('message', 'Division details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('division.edit',$did));  
    }
  
    //deactivated division details from table
    public function deleteDivision(Request $request)
    {
        $division = ClassDivision::find($request->uid);
        if($division == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'division does not exist'
            ]);
        }
        $division->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'division deactivated successfully'
        ]);
    }

    // restore division
    public function activateDivision(Request $request)
    {
        $division = ClassDivision::withTrashed()->find($request->id);
        if($division==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'division does not exist'
             ]);
        }

        $division->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'division activated successfully'
        ]);
    }

    public function divisionCreateRules()
    {
        $rules = [
            'class_id' => 'required',
            'name' => 'required' 
        ];
        return  $rules;
    }
    
    //validation for division updation
    public function divisionUpdateRules($division)
    {
        $rules = [
            'class_id' => 'required',
            'name' => 'required' 
        ];
        return  $rules;
    }
}
