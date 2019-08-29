<?php
namespace App\Modules\SchoolClass\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\SchoolClass\Models\SchoolClass;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class ClassController extends Controller {
   
    //class creation page
    public function create()
    {
       return view('SchoolClass::class-create');
    }
    //upload class details to database table
    public function save(Request $request)
    {    
        $client_id = \Auth::user()->client->id;
        $rules = $this->classCreateRules();
        $this->validate($request, $rules);           
        $class = SchoolClass::create([            
            'name' => $request->name,            
            'school_id' => $client_id       
        ]);
        $eid= encrypt($class->id);
        $request->session()->flash('message', 'New class created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('class'));        
    }

    //class list
    public function classList()
    {
        return view('SchoolClass::class-list');
    }

    public function getClasslist(Request $request)
    {
        $class = SchoolClass::select(
            'id', 
            'name',
            'deleted_at')
            ->withTrashed()
            ->get();
            return DataTables::of($class)
            ->addIndexColumn()
            ->addColumn('action', function ($class) {
                 $b_url = \URL::to('/');
            if($class->deleted_at == null){ 
                return "
                <button onclick=delClass(".$class->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>
                <a href=".$b_url."/class/".Crypt::encrypt($class->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                ";
            }else{                   
                return "
                <button onclick=activateClass(".$class->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Ativate</button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //edit class details
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $class = SchoolClass::find($decrypted);       
        if($class == null)
        {
           return view('SchoolClass::404');
        }
        return view('SchoolClass::class-edit',['class' => $class]);
    }

    //update class details
    public function update(Request $request)
    {
        $class = SchoolClass::where('id', $request->id)->first();
        if($class == null){
           return view('SchoolClass::404');
        } 
        $rules = $this->classUpdateRules($class);
        $this->validate($request, $rules);       
        $class->name = $request->name;
        $class->save();      
        $did = encrypt($class->id);
        $request->session()->flash('message', 'Class details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('class.edit',$did));  
    }
  
    //deactivated class details from table
    public function deleteClass(Request $request)
    {
        $class = SchoolClass::find($request->uid);
        if($class == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'class does not exist'
            ]);
        }
        $class->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'class deactivated successfully'
        ]);
    }


    // restore class
    public function activateClass(Request $request)
    {
        $class = SchoolClass::withTrashed()->find($request->id);
        if($class==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'class does not exist'
             ]);
        }

        $class->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'class activated successfully'
        ]);
    }

    public function classCreateRules()
    {
        $rules = [
            'name' => 'required|unique:school_classes' 
        ];
        return  $rules;
    }
     //validation for class updation
    public function classUpdateRules($class)
    {
        $rules = [
            'name' => 'required|unique:school_classes,name,'.$class->id
        ];
        return  $rules;
    }
}
