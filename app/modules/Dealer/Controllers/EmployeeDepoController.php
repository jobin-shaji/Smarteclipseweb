<?php

namespace App\Modules\Employee\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\EmployeeDesignation;
use App\Modules\Employee\Models\EmploymentType;
use App\Modules\Employee\Models\BloodGroup;
use App\Modules\Depot\Models\Depot;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Stage\Models\Stage;
use DataTables;

class EmployeeDepoController extends Controller {



     public function create()
    {
          $employeeDesignation=employeeDesignation::select(
            'id','designation')->get();
        $employmentType=EmploymentType::select(
            'id','type')->get();
        $vehicleDepot=Depot::select('id','name')
            ->get();
              $stages=Stage::select('id','name')
            ->get();
        $employeeBloodGroup=BloodGroup::select('id','blood_group')->get();

        return view('Employee::depo-employee-create',['employeeDesignation'=>$employeeDesignation,'employmentType'=>$employmentType,'depots'=>$vehicleDepot,'employeeBloodGroup'=>$employeeBloodGroup,'stages'=>$stages]);
    }

     //upload employee details to database table
    public function store(Request $request)
    {
        $depot_id=\Auth::user()->depot->first()->id;
        $rules = $this->employeeCreateRules();
        $this->validate($request, $rules);
        $employee = Employee::create([
            'employee_code'=> $request->employee_code,
            'name' => $request->name,
            'employee_designation_id' => $request->employee_designation_id,
            'address' => $request->address,
            'employee_dob' => date("Y-m-d", strtotime($request->employee_dob)),
            'phone_number' => $request->phone_number,
            'blood_group_id' => $request->blood_group_id,
            'employee_pf_no' => $request->employee_pf_no,
            'employment_type_id' => $request->employment_type_id,
            'depot_id' => $depot_id,
            'stage_id'=>$request->stage,    
            'username' => $request->username,
            'status'=>1,
            'password' => $request->password,
            'created_by' => \Auth::user()->id
        ]);


      $eid= encrypt($employee->id);

        $request->session()->flash('message', 'New employee created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('depo-employees.details',$eid));
    }

 //employee details view
    public function details(Request $request)
    {
        $decrpt= decrypt($request->id);
        $employee = Employee::find($decrpt);
        if($employee == null){
           return view('Employee::404');
        }
       return view('Employee::employee-details',['employee' => $employee]);
    }



//for edit page of employee
    public function edit(Request $request)
    {
        $decrpt= decrypt($request->id);
        $employee = Employee::find($decrpt);
        $emp_desig=EmployeeDesignation::select('id','designation')->get();
        $emp_type=EmploymentType::select('id','type')->get();
        $emp_depot=Depot::select('id','name')
            ->get();
        $emp_blood_group=BloodGroup::select('id','blood_group')->get();
        if($employee == null){
           return view('Employee::404');
        }
       return view('Employee::depo-employee-edit',['employee' => $employee,'emp_desig' => $emp_desig,'emp_type' => $emp_type,'emp_depot' => $emp_depot,'emp_blood_group' => $emp_blood_group]);
    }

     //update employees details
    public function update(Request $request)
    {
        $employee = Employee::find($request->id);
        if($employee == null){
           return view('Employee::404');
        }
        $rules = $this->employeeUpdateRules($employee);
        $this->validate($request, $rules);
        $employee->employee_code = $request->employee_code;
        $employee->name = $request->name;
        $employee->employee_designation_id = $request->employee_designation_id;
        $employee->address = $request->address;
        $employee->employee_dob = date("Y-m-d", strtotime($request->employee_dob));
        $employee->phone_number = $request->phone_number;
        $employee->blood_group_id = $request->blood_group_id;
        $employee->employee_pf_no = $request->employee_pf_no;
        $employee->employment_type_id = $request->employment_type_id;
        // $employee->depot_id = $request->depot_id;
        $employee->save();
        $eid=encrypt($employee->id);
        $request->session()->flash('message', 'Employee details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('depo-employees.edit',$eid));  
    }

     //for edit page of employee password
    public function changePassword(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id);
        $employee = Employee::find($decrypted);
        if($employee == null){
           return view('Employee::404');
        }
       return view('Employee::depo-employee-change-password',['employee' => $employee]);
    }

    //Display employee details 
    public function employeeListPage()
    {
        return view('Employee::employee-depo-list');
    }

    //returns employees as json 
    public function getEmployees(Request $request)
    {
       $depot=$request->data['depot'];
        // $depot=\Auth::user()->depot->first()->id;
        $employees = Employee::select(
                    'id',
                    'employee_code',
                    'name',
                    'employee_designation_id',
                    'address',
                    'employee_dob',
                    'phone_number',
                    'blood_group_id',
                    'employee_pf_no',
                    'employment_type_id',
                    'depot_id',
                    'username',
                    'password',
                    'deleted_at'
                )
                    ->withTrashed()
                    ->with('employeeDesignation:id,designation')
                    ->with('employmentType:id,type')
                    ->with('depot:id,name')
                    ->with('employeeBloodGroup:id,blood_group')
                    ->where('depot_id',$depot)
                    ->get();
                    
                    return DataTables::of($employees)
                    ->addIndexColumn()
                    ->addColumn('action', function ($employees) {
                    if($employees->deleted_at == null){
                    return "
                    <a href=/depo/employees/".encrypt($employees->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/depo/employees/".encrypt($employees->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=delEmployee(".$employees->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
                }else{
                    return "
                    <a href=/depo/employees/".encrypt($employees->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                    <a href=/depo/employees/".encrypt($employees->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateEmployee(".$employees->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
                }
            })
             ->rawColumns(['link', 'action'])
            ->make();
    }


    //validation for employee creation
    public function employeeCreateRules()
    {
        $rules = [
            'employee_code'=> 'required|string|unique:employees',
            'name' => 'required',
            'employee_designation_id' => 'required',
            'address' => 'required',
            'employee_dob' => 'required',
            'phone_number' => 'required|numeric',
            'blood_group_id' => 'required',
            'employee_pf_no' => 'required',
            'employment_type_id' => 'required',           
            'username' => 'nullable|string|max:20|unique:employees',
            'password' => 'nullable|string|min:6|confirmed',
        ];
        return  $rules;
    }

     //validation for employee updation
    public function employeeUpdateRules($employee)
    {
        $rules = [
            'employee_code'=> 'required|string|unique:employees,employee_code,'.$employee->id,
            'name' => 'required',
            'employee_designation_id' => 'required',
            'address' => 'required',
            'employee_dob' => 'required',
            'phone_number' => 'required|numeric',
            'blood_group_id' => 'required',
            'employee_pf_no' => 'required',
            'employment_type_id' => 'required'
            
        ];
        return  $rules;
    }

     //delete employee details from table
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
            'message' => 'Employee deleted successfully'
        ]);
    }

    // restore emplopyee
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
            'message' => 'Employee restored successfully'
        ]);
    }


 //update password
    public function updatePassword(Request $request)
    {
        $employee = Employee::find($request->id);
        $eid = encrypt($employee->id);
        if($employee == null){
           return view('Employee::404');
        }
        $rules = $this->passwordUpdateRules();
        $this->validate($request, $rules);
        $old_password=$employee->password;
        $entered_old_password=$request->old_password;
        if($old_password==$entered_old_password){
            $employee->password = $request->password;
            $employee->save();
            $eid = encrypt($employee->id);
            $request->session()->flash('message', 'Password updated successfully!');
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('depo-employees.edit',$eid));   
        }else{
            $request->session()->flash('message', 'Old password is incorrect!');
            $request->session()->flash('alert-class', 'alert-danger'); 
            return redirect(route('depo-employees.change-password',$eid));
        }
         
    }
/////////////////////////////////////////////////////////////////////////
      public function passwordUpdateRules(){
        $rules=[
            'password' => 'required|string|min:6|confirmed'
        ];
        return $rules;
  }

}
