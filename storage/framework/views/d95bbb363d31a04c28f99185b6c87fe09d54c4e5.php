 
<?php $__env->startSection('title'); ?>
   Employee details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
     <h1>Employee details</h1>
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
            <i class="fa fa-user"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="#">
        <?php echo e(csrf_field()); ?>

    <div class="row">
        <div class="col-md-6">
          
          <div class="form-group has-feedback">
              <label>Employee Code</label>
              <input type="text" class="form-control <?php echo e($errors->has('employee_code') ? ' has-error' : ''); ?>" placeholder="Employee Code" name="employee_code" value="<?php echo e($employee->employee_code); ?>" disabled> 
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <label>Name</label>
            <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Name" name="name" value="<?php echo e($employee->name); ?>" disabled>
          </div>

          <div class="form-group has-feedback">
            <label class="srequired">Designation</label>
            <input type="text" class="form-control <?php echo e($errors->has('employee_designation_id') ? ' has-error' : ''); ?>" placeholder="Designation" name="employee_designation_id"
            value="<?php echo e($employee->employeeDesignation->designation); ?>" disabled> 
            <span class="glyphicon glyphicon-car form-control-feedback"></span>
          </div>
          
          <div class="form-group has-feedback">
            <label>Address</label>
            <input type="text" class="form-control <?php echo e($errors->has('address') ? ' has-error' : ''); ?>" placeholder="Address" name="address" value="<?php echo e($employee->address); ?>" disabled>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
              

          <div class="form-group has-feedback">
            <label>Date Of Birth</label>
            <input type="text" class="form-control <?php echo e($errors->has('employee_dob') ? ' has-error' : ''); ?>" placeholder="DOB" name="employee_dob" value="<?php echo e($employee->employee_dob); ?>" disabled>
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>
              

          <div class="form-group has-feedback">
            <label>Mobile No.</label>
            <input type="text" class="form-control <?php echo e($errors->has('phone_number') ? ' has-error' : ''); ?>" placeholder="Mobile" name="phone_number" value="<?php echo e($employee->phone_number); ?>" disabled>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
            
          <div class="form-group has-feedback">
            <label class="srequired">Blood Group</label>
            <input type="text" class="form-control <?php echo e($errors->has('blood_group_id') ? ' has-error' : ''); ?>" placeholder="Blood Group" name="blood_group_id" value="<?php echo e($employee->employeeBloodGroup->blood_group); ?>" disabled> 
            <span class="glyphicon glyphicon-car form-control-feedback"></span>
          </div>  

        </div>
        <div class="col-md-6">

            <div class="form-group has-feedback">
              <label>PF No.</label>
              <input type="text" class="form-control <?php echo e($errors->has('employee_pf_no') ? ' has-error' : ''); ?>" placeholder="PF No." name="employee_pf_no" value="<?php echo e($employee->employee_pf_no); ?>" disabled>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
        
            <div class="form-group has-feedback">
              <label class="srequired">Employment Type</label>
              <input type="text" class="form-control <?php echo e($errors->has('employment_type_id') ? ' has-error' : ''); ?>" placeholder="Employment Type" name="employment_type_id" value="<?php echo e($employee->employmentType->type); ?>" disabled> 
              <span class="glyphicon glyphicon-car form-control-feedback"></span>
            </div>  

            <div class="form-group has-feedback">
              <label class="srequired">Depot</label>
              <input type="text" class="form-control <?php echo e($errors->has('depot_id') ? ' has-error' : ''); ?>" placeholder="Depot" name="depot_id" value="<?php echo e($employee->employeeDepot->name); ?>" disabled> 
              <span class="glyphicon glyphicon-car form-control-feedback"></span>
            </div> 


            <div class="form-group has-feedback">
              <label>Username</label>
              <input type="text" class="form-control <?php echo e($errors->has('username') ? ' has-error' : ''); ?>" placeholder="Username" name="username" value="<?php echo e($employee->username); ?>" disabled>
              <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
             
     
            <div class="form-group has-feedback">
              <label>Password</label>
              <input type="password" class="form-control <?php echo e($errors->has('password') ? ' has-error' : ''); ?>" placeholder="*******" name="password" disabled>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div> 
            
          </div>
      </div>
<!--  -->
    </form>
</section>

<div class="clearfix"></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>