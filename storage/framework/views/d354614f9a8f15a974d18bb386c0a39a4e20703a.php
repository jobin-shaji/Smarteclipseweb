 
<?php $__env->startSection('title'); ?>
    Create Employee
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create Employee</h1>
    </section>
    <?php if(Session::has('message')): ?>
    <div class="pad margin no-print">
      <div class="callout <?php echo e(Session::get('callout-class', 'callout-success')); ?>" style="margin-bottom: 0!important;">
          <?php echo e(Session::get('message')); ?>  
      </div>
    </div>
    <?php endif; ?>  

<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-user-plus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('employees.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Employee Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('employee_code') ? ' has-error' : ''); ?>" placeholder="Employee Code" name="employee_code" value="<?php echo e(old('employee_code')); ?>" required> 
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <?php if($errors->has('employee_code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('employee_code')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Name" name="name" value="<?php echo e(old('name')); ?>" required> 
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Designation</label>

                <select class="form-control <?php echo e($errors->has('employee_designation_id') ? ' has-error' : ''); ?>"  name="employee_designation_id" placeholder="Designation" value="<?php echo e(old('employee_designation_id')); ?>" required>
                  <option value="">Select</option>
                  <?php $__currentLoopData = $employeeDesignation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($designation->id); ?>"><?php echo e($designation->designation); ?></option>
                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <?php if($errors->has('employee_designation_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('employee_designation_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                    <label class="srequired">Address</label>
                    <input type="text" class="form-control <?php echo e($errors->has('address') ? ' has-error' : ''); ?>" placeholder="Address" name="address" value="<?php echo e(old('address')); ?>" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <?php if($errors->has('address')): ?>
                 <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('address')); ?></strong>
                 </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                    <label class="srequired">Date Of Birth</label>
                    <input type="date" class="form-control  <?php echo e($errors->has('employee_dob') ? ' has-error' : ''); ?>" placeholder="DOB" name="employee_dob" value="<?php echo e(old('employee_dob')); ?>" required>
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
              </div>
              <?php if($errors->has('employee_dob')): ?>
                 <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('employee_dob')); ?></strong>
                 </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                    <label class="srequired">Mobile No.</label>
                    <input type="text" class="form-control <?php echo e($errors->has('phone_number') ? ' has-error' : ''); ?>" placeholder="Mobile" name="phone_number" value="<?php echo e(old('phone_number')); ?>" required>
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
              </div>
              <?php if($errors->has('phone_number')): ?>
                 <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('phone_number')); ?></strong>
                 </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Blood Group</label>

                <select class="form-control <?php echo e($errors->has('blood_group_id') ? ' has-error' : ''); ?>"  name="blood_group_id" placeholder="Blood Group" value="<?php echo e(old('blood_group_id')); ?>" required>
                  <option value="">Select</option>
                  <?php $__currentLoopData = $employeeBloodGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($group->id); ?>"><?php echo e($group->blood_group); ?></option>
                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <?php if($errors->has('blood_group_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('blood_group_id')); ?></strong>
                </span>
              <?php endif; ?>

           </div>
            <div class="col-md-6">
                
              <div class="form-group has-feedback">
                    <label class="srequired">PF No.</label>
                    <input type="text" class="form-control <?php echo e($errors->has('employee_pf_no') ? ' has-error' : ''); ?>" placeholder="PF No." name="employee_pf_no" value="<?php echo e(old('employee_pf_no')); ?>" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <?php if($errors->has('employee_pf_no')): ?>
                 <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('employee_pf_no')); ?></strong>
                 </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Employment Type</label>

                <select class="form-control <?php echo e($errors->has('employment_type_id') ? ' has-error' : ''); ?>"  name="employment_type_id" value="<?php echo e(old('employment_type_id')); ?>" required>
                  <option value="">Select</option>
                  <?php $__currentLoopData = $employmentType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employmentType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($employmentType->id); ?>"><?php echo e($employmentType->type); ?></option>
                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <?php if($errors->has('employment_type_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('employment_type_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Depot</label>

                <select class="form-control <?php echo e($errors->has('depot_id') ? ' has-error' : ''); ?>"  name="depot_id" value="<?php echo e(old('depot_id')); ?>" required>
                  <option value="">Select</option>
                  <?php $__currentLoopData = $depots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($depot->id); ?>"><?php echo e($depot->name); ?></option>
                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <?php if($errors->has('depot_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('depot_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                    <label class="srequired">Username</label>
                    <input type="text" class="form-control <?php echo e($errors->has('username') ? ' has-error' : ''); ?>" placeholder="Username" name="username" value="<?php echo e(old('username')); ?>" required>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
              </div>
              <?php if($errors->has('username')): ?>
                 <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('username')); ?></strong>
                 </span>
              <?php endif; ?>

                <div class="form-group has-feedback">
                    <label class="srequired">Password</label>
                    <input type="password" class="form-control <?php echo e($errors->has('password') ? ' has-error' : ''); ?>" placeholder="Password" name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <label class="srequired">Confirm password</label>
                    <input type="password" class="form-control <?php echo e($errors->has('password') ? ' has-error' : ''); ?>" placeholder="Retype password" name="password_confirmation" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <?php if($errors->has('password')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('password')); ?></strong>
                </span>
                <?php endif; ?>
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
</section>
 
<div class="clearfix"></div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>