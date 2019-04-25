 
<?php $__env->startSection('title'); ?>
   Update crew details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
     <h1>Edit Crew</h1>
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
            <i class="fa fa-edit"> Crew details</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="<?php echo e(route('crew.update.p',$crew->id)); ?>">
        <?php echo e(csrf_field()); ?>

    <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label class="srequired"> Crew Name</label>
            <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="crew Name" name="name" value="<?php echo e($crew->name); ?>"> 
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
          <?php if($errors->has('name')): ?>
            <span class="help-block">
            <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
            </span>
          <?php endif; ?>
        </div>
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

<form action="<?php echo e(route('crew-member.add')); ?>" method="post">
  <?php echo csrf_field(); ?>
<section class="hilite-content">
  <div class="row">
    <div class="col-xs-3">
      <h2 class="page-header">
        <i class="fa fa-plus"> Add Crew Members</i> 
      </h2>
      <div class="form-group">
        <input type="hidden" name="crew_id" id="crew_id" value="<?php echo e($crew->id); ?>">
        <label>Select Crew Type</label>
          <select class="form-control" name="designation_id" id="designation_id" required>
          <option value="">-- Select Type --</option>
          <?php $__currentLoopData = $emp_desig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($desig->id); ?>"><?php echo e($desig->designation); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
      </div>
      <div class="form-group">
        <label>Select Crew member</label>
          <select name="employee_id" class="form-control" id="employee_id" required>
          </select>
      </div>
      <div class="form-group">
        <button class="btn btn-block btn-success">Add</button>
      </div>
    </div>
  </div>
</section>
</form>

<section class="hilite-content">
  <h2>Crew Members</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $crew->employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <th><?php echo e($employee->employeeDesignation->designation); ?></th>
        <td><?php echo e($employee->name); ?> </td>
        <td>
          <form action="<?php echo e(route('crew-member.remove')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" value="<?php echo e($employee->pivot->id); ?>" name="pivot">
            <button class="btn btn-xs btn-danger">Remove</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</section>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('js/etm/crew-dependent-dropdown.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<div class="clearfix"></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>