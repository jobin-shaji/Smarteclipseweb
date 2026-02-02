<?php
namespace App\Modules\Employee\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\Role;
use App\Modules\Employee\Models\Department;
use App\Modules\Employee\Models\Designation;
use App\Modules\Sales\Models\Callcenter;
use Illuminate\Support\Facades\Crypt;
use App\Modules\User\Models\User;
use DataTables;

class EmployeeController extends Controller {
   
    //employee creation page
    public function createEmployee()
    {
        $department = Department::orderby('created_at', 'desc')->get();
        $designation = Designation::orderby('created_at', 'desc')->get();
        return view('Employee::employee-create',['department'=>$department,'designation'=>$designation]);
    }

    //upload employee details to database table
    public function saveEmployee2(Request $request)
    { 
        
        $rules = $this->user_create_rules();
        $this->validate($request, $rules);
       
        $dept=Department::find($request->department_id);
      //  print_r($dept);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile_number,
            'status' => 1,
            'role_id'=>$dept->role_id,
            'password' => bcrypt($request->password),
        ]);           
        $employee = Employee::create([   
            'user_id' => $user->id,  
            'username' => $request->username,       
            'name' => $request->name,  
            'code' => $request->code,           
            'mobile' => $request->mobile,  
            'email' => $request->email,  
            'designation_id' => $request->designation_id,  
            'department_id' => $request->department_id,
            'password' => bcrypt($request->password)
        ]);
       
        $role=Role::where('id', $dept->role_id)->first();
        User::where('username', $request->username)->first()->assignRole($role->name);
        $id= encrypt($employee->id);
        $request->session()->flash('message', 'New employee created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('employee.details',$id));        
    }
    public function saveEmployee(Request $request)
    {
        $rules = $this->user_create_rules();
        $this->validate($request, $rules);
    
        $department = Department::findOrFail($request->department_id);
    
        $user = User::create([
            'username'  => $request->username,
            'email'     => $request->email,
            'mobile'    => $request->mobile,
            'status'    => 1,
            'role_id'   => $department->role_id,
            'password'  => bcrypt($request->password),
        ]);
    
        $employee = Employee::create([
            'user_id'        => $user->id,
            'username'       => $request->username,
            'name'           => $request->name,
            'code'           => $request->code,
            'mobile'         => $request->mobile,
            'email'          => $request->email,
            'designation_id' => $request->designation_id,
            'department_id'  => $request->department_id,
            'password'       => bcrypt($request->password),
        ]);
    
        Callcenter::create([
            'user_id' => $user->id,
            'name'    => $request->name,
            'code'    => $request->code,
            'sales_id'=> '5',
            'address' => 'eroor',
        ]);
    
        $role = Role::find($department->role_id);
        if ($role) {
            $user->assignRole($role->name);
        }
    
        $encryptedId = encrypt($employee->id);
    
        $request->session()->flash('message', 'Call Center user created successfully!');
        $request->session()->flash('alert-class', 'alert-success');
    
        return redirect(route('employee.details', $encryptedId));
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
            'department_id',
            'name',
            'code',
            'email',               
            'mobile',
            'designation_id',
            'deleted_at')
            ->with('user:id,email,mobile,deleted_at')
            ->with('department:id,name')
            ->with('designation:id,name')
            ->withTrashed()
            ->get();
            return DataTables::of($employee)
            ->addIndexColumn()
            ->addColumn('department_id', function ($employee) {
                return $employee->department->name;
            })
            ->addColumn('designation', function ($employee) {
                if($employee->designation_id){
                    return $employee->designation->name;
                }else{
                    return '';
                }
                
            })
            
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
        $department = Department::orderby('created_at', 'desc')->get();
        $designation = Designation::orderby('created_at', 'desc')->get();
        $decrypted = Crypt::decrypt($request->id); 
        $employee = Employee::find($decrypted);       
        if($employee == null)
        {
           return view('Employee::404');
        }
        return view('Employee::employee-edit',['employee' => $employee,'department'=>$department,'designation'=>$designation]);
    }

    //update employee details
    public function updateEmployee(Request $request)
    {
        $employee = Employee::where('id', $request->id)->first();
    //    print_r(  $employee);die;
       if($employee == null){
           return view('Employee::404');
        } 
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";

        if (strpos($url, $rayfleet_key) == true) {
             $rules = $this->employeeUpdateRulesRayfleet($employee);
        }
        else if (strpos($url, $eclipse_key) == true) {
             $rules = $this->employeeUpdateRules($employee);
        }
        else
        {
           $rules = $this->employeeUpdateRules($employee);
        }
        $this->validate($request, $rules); 
        $employee->code = $request->code;      
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->mobile = $request->mobile;
        $employee->save();      
        $id = encrypt($employee->id);

        /*$user=User::find($employee->user_id);
        $user->password=bcrypt(123456);
        $user->save();*/
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

    public function employeeCreateRulesRayfleet()
    {
        $rules = [
            'name' => 'required',
            'code' => 'required|unique:employees',
            'mobile' => 'required|string|min:11|max:11|unique:employees',  
            'email' => 'email|required|unique:employees',
            'username' => 'required|unique:employees',
            'password' => 'required',
        ];
        return  $rules;
    }

     //validation for employee updation
     public function user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile' => 'required|string|unique:users,mobile|min:10|max:10',
        ];
        return  $rules;
    }

    public function rayfleet_user_create_rules(){
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$/',
            'mobile' => 'required|string|unique:users,mobile|min:10|max:10'
        ];
        return  $rules;
    }
}
