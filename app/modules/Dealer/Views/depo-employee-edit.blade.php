@extends('layouts.etm') 
@section('title')
   Update employee details
@endsection
@section('content')

    <section class="content-header">
     <h1>Edit Employee</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-edit"> Employee details</i> 
          </h2>
          <?php 
            $password=$employee->password;
             $encript=Crypt::encrypt($employee->id);
            if($password){
          ?>
          <a href="{{route('depo-employees.change-password',$encript)}}">
            <button class="btn btn-xs btn-success pull-right">Password Change</button>
          </a><?php } ?>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('depo-employees.update.p',$employee->id)}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label class="srequired">Employee Code</label>
            <input type="text" class="form-control {{ $errors->has('employee_code') ? ' has-error' : '' }}" placeholder="Employee Code" name="employee_code" value="{{ $employee->employee_code}}"> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          @if ($errors->has('employee_code'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('employee_code') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $employee->name}}"> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Designation</label>
            <select class="form-control {{ $errors->has('employee_designation_id') ? ' has-error' : '' }}" placeholder="Designation" name="employee_designation_id" value="{{ old('employee_designation_id') }}" required>
            <option value="">Select</option>
            @foreach($emp_desig as $desig)
              <option value="{{$desig->id}}" @if($desig->id==$employee->employee_designation_id){{"selected"}} @endif>{{$desig->designation}}</option>      
            @endforeach
            </select>
          </div>
          @if ($errors->has('employee_designation_id'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('employee_designation_id') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Address</label>
            <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $employee->address}}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          @if ($errors->has('address'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('address') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Date Of Birth</label>
            <input type="date" class="form-control {{ $errors->has('employee_dob') ? ' has-error' : '' }}" placeholder="DOB" name="employee_dob" value="{{ $employee->employee_dob}}">
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>
          @if ($errors->has('employee_dob'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('employee_dob') }}</strong>
            </span>
          @endif

          
      </div>
      <div class="col-md-6">
        <div class="form-group has-feedback">
          <label class="srequired">Mobile No.</label>
          <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $employee->phone_number}}">
          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        @if ($errors->has('phone_number'))
          <span class="help-block">
          <strong class="error-text">{{ $errors->first('phone_number') }}</strong>
          </span>
        @endif

        <div class="form-group has-feedback">
            <label class="srequired">Blood Group</label>
            <select class="form-control {{ $errors->has('blood_group_id') ? ' has-error' : '' }}" placeholder="Blood Group" name="blood_group_id" value="{{ old('blood_group_id') }}" required>
            <option value="">Select</option>
            @foreach($emp_blood_group as $group)
              <option value="{{$group->id}}" @if($group->id==$employee->blood_group_id){{"selected"}} @endif>{{$group->blood_group}}</option>      
            @endforeach
            </select>
          </div>
          @if ($errors->has('blood_group_id'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('blood_group_id') }}</strong>
            </span>
          @endif

        <div class="form-group has-feedback">
          <label class="srequired">PF No.</label>
          <input type="text" class="form-control {{ $errors->has('employee_pf_no') ? ' has-error' : '' }}" placeholder="PF No." name="employee_pf_no" value="{{ $employee->employee_pf_no}}" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        @if ($errors->has('employee_pf_no'))
          <span class="help-block">
          <strong class="error-text">{{ $errors->first('employee_pf_no') }}</strong>
          </span>
        @endif

        <div class="form-group has-feedback">
          <label class="srequired">Employment Type</label>
          <select class="form-control {{ $errors->has('employment_type_id') ? ' has-error' : '' }}" placeholder="Employment Type" name="employment_type_id" value="{{ old('employment_type_id') }}" required>
          <option value="">Select</option>
          @foreach($emp_type as $type)
            <option value="{{$type->id}}" @if($type->id==$employee->employment_type_id){{"selected"}} @endif>{{$type->type}}</option>      
          @endforeach
          </select>
        </div>
        @if ($errors->has('employment_type_id'))
          <span class="help-block">
          <strong class="error-text">{{ $errors->first('employment_type_id') }}</strong>
          </span>
        @endif

      
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
</section>


<!-- add depot user -->
 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
            <form  method="POST" action="{{route('depo.employees.update-password.p',$employee->id)}}">
                    {{csrf_field()}}
                  <input type="hidden" name="id" value="{{$employee->id}}"> 
                  <div class="row">
                          <div class="col-md-12">
                              <div class="form-group has-feedback">
                                <label>Old Password</label>
                                <input type="text" class="form-control {{ $errors->has('old_password') ? ' has-error' : '' }}" placeholder="Old Password" name="old_password" value="{{$employee->password}}" required> 
                                <span class="glyphicon glyphicon-car form-control-feedback"></span>
                              </div>
                              @if ($errors->has('old_password'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('old_password') }}</strong>
                                </span>
                              @endif

                              <div class="form-group has-feedback">
                                <label class="srequired">New Password</label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="New Password" name="password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                              </div>
                              <div class="form-group has-feedback">
                                <label class="srequired">Confirm password</label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                              </div>
                              @if ($errors->has('password'))
                                <span class="help-block">
                                <strong class="error-text">{{ $errors->first('password') }}</strong>
                                </span>
                              @endif
                        </div>
                    </div>
                      <div class="row">
                        <!-- /.col -->
                        <div class="col-md-3 ">
                          <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
                        </div>
                        <!-- /.col -->
                      </div>
                </form>

      </div>
    </div>
   </div>
 </div>
<!-- add depot user -->

<div class="clearfix"></div>

@endsection