<?php
namespace App\Modules\Employee\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class EmployeeController extends Controller {
   
    //employee creation page
    public function createEmployee()
    {
       return view('Employee::employee-create');
    }

    //upload employee details to database table
    public function saveEmployee(Request $request)
    {    
        $rules = $this->employeeCreateRules();
        $this->validate($request, $rules);           
        $employee = Employee::create([            
            'name' => $request->name,  
            'code' => $request->code,           
            'mobile' => $request->mobile,  
            'email' => $request->email,  
            'username' => $request->username,  
            'password' => bcrypt($request->password)
        ]);
        $id= encrypt($employee->id);
        $request->session()->flash('message', 'New employee created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('employee.details',$id));        
    }

    //helper list
    public function employeeList()
    {
        return view('Employee::employee-list');
    }

    public function getEmployeelist(Request $request)
    {
        $employee = Employee::select(
            'id', 
            'name',
            'code',
            'email',               
            'mobile',
            'deleted_at')
            ->withTrashed()
            ->get();
            return DataTables::of($employee)
            ->addIndexColumn()
            ->addColumn('action', function ($employee) {
                 $b_url = \URL::to('/');
            if($employee->deleted_at == null){ 
                return "
                <button onclick=delEmployee(".$employee->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>
                <a href=".$b_url."/employee/".Crypt::encrypt($employee->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                 <a href=".$b_url."/employee/".Crypt::encrypt($employee->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view!'><i class='fas fa-eye'></i> View</a>
                ";
            }else{                   
                return "
                <button onclick=activateEmployee(".$employee->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Ativate</button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //edit employee details
    public function editEmployee(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $employee = Employee::find($decrypted);       
        if($employee == null)
        {
           return view('Employee::404');
        }
        return view('Employee::employee-edit',['employee' => $employee]);
    }

    //update employee details
    public function updateEmployee(Request $request)
    {
        $employee = Employee::where('id', $request->id)->first();
        if($employee == null){
           return view('Employee::404');
        } 
        $rules = $this->employeeUpdateRules($employee);
        $this->validate($request, $rules); 
        $employee->code = $request->code;      
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->mobile = $request->mobile;
        $employee->save();      
        $id = encrypt($employee->id);
        $request->session()->flash('message', 'Employee details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('employee.edit',$id));  
    }

    // details page
    public function detailsEmployee(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $employee=Employee::find($decrypted_id);
        if($employee==null){
            return view('Employee::404');
        } 
        return view('Employee::employee-details',['employee' => $employee]);
    }

    //deactivated employee details from table
    public function deleteEmployee(Request $request)
    {
        $employee = Employee::find($request->uid);
        if($employee == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Employee does not exist'
            ]);
        }
        $employee->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Employee deactivated successfully'
        ]);
    }


    // restore helper
    public function activateEmployee(Request $request)
    {
        $employee = Employee::withTrashed()->find($request->id);
        if($employee==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Employee does not exist'
             ]);
        }

        $employee->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Employee activated successfully'
        ]);
    }

    public function employeeCreateRules()
    {
        $rules = [
            'name' => 'required',
            'code' => 'required|unique:employees',
            'mobile' => 'required|string|min:10|max:10|unique:employees',  
            'email' => 'email|required|unique:employees',
            'username' => 'required|unique:employees',
            'password' => 'required',
        ];
        return  $rules;
    }
     //validation for employee updation
    public function employeeUpdateRules($employee)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required|unique:employees,code,'.$employee->id,
            'mobile' => 'required|string|min:10|max:10|unique:employees,mobile,'.$employee->id,
            'email' => 'email|required|unique:employees,email,'.$employee->id,
        ];
        return  $rules;
    }
}
