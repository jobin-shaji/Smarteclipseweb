<?php
namespace App\Modules\School\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\School\Models\School;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class SchoolController extends Controller {
   
    //school creation page
    public function create()
    {
       return view('School::school-create');
    }
    //upload school details to database table
    public function save(Request $request)
    {    
        $rules = $this->schoolCreateRules();
        $this->validate($request, $rules);           
        $school = School::create([            
            'name' => $request->name,            
            'address' => $request->address,
            'mobile' => $request->mobile,        
        ]);
        $eid= encrypt($school->id);
        $request->session()->flash('message', 'New school created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('school'));        
    }

    //school list
    public function schoolList()
    {
        return view('School::school-list');
    }

    public function getSchoollist(Request $request)
    {
        $school = School::select(
            'id', 
            'name',                   
            'address',
            'mobile',
            'deleted_at')
            ->withTrashed()
            ->get();
            return DataTables::of($school)
            ->addIndexColumn()
            ->addColumn('action', function ($school) {
                 $b_url = \URL::to('/');
            if($school->deleted_at == null){ 
                return "
                <button onclick=delSchool(".$school->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>
                <a href=".$b_url."/school/".Crypt::encrypt($school->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                 <a href=".$b_url."/school/".Crypt::encrypt($school->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view!'><i class='fas fa-eye'></i> View</a>
                ";
            }else{                   
                return "
                <button onclick=activateSchool(".$school->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Ativate</button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //EDIT SCHOOL DETAILS
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $school = School::find($decrypted);       
        if($school == null)
        {
           return view('School::404');
        }
        return view('School::school-edit',['school' => $school]);
    }

    //update school details
    public function update(Request $request)
    {
        $school = School::where('id', $request->id)->first();
        if($school == null){
           return view('School::404');
        } 
        $rules = $this->schoolUpdateRules($school);
        $this->validate($request, $rules);       
        $school->name = $request->name;
        $school->address = $request->address;
        $school->mobile = $request->mobile;
        $school->save();      
        $did = encrypt($school->id);
        $request->session()->flash('message', 'School details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('school.edit',$did));  
    }

    
    // details page
    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $school=School::find($decrypted_id);
        if($school==null){
            return view('School::404');
        } 
        return view('School::school-details',['school' => $school]);
    }

  
    //deactivated school details from table
    public function deleteSchool(Request $request)
    {
        $school = School::find($request->uid);
        if($school == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'school does not exist'
            ]);
        }
        $school->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'School deactivated successfully'
        ]);
    }


    // restore school
    public function activateSchool(Request $request)
    {
        $school = School::withTrashed()->find($request->id);
        if($school==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'school does not exist'
             ]);
        }

        $school->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'School restored successfully'
        ]);
    }

    public function schoolCreateRules()
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|string|min:10|max:10|unique:schools',
            
        ];
        return  $rules;
    }
     //validation for school updation
    public function schoolUpdateRules($school)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|string|min:10|max:10|unique:schools,mobile,'.$school->id
            
        ];
        return  $rules;
    }
}
