 
<?php $__env->startSection('title'); ?>
   Update waybill details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
     <h1>Edit Waybill</h1>
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
            <i class="fa fa-edit"> Waybill details</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="<?php echo e(route('waybill.update.p',$waybills->id)); ?>">
        <?php echo e(csrf_field()); ?>

    <div class="row">
        <div class="col-md-6">
          <input type="hidden" name="code" value="<?php echo e($waybills->code); ?>"> 
          <input type="hidden" name="etm_id" value="<?php echo e($waybills->etm_id); ?>"> 
          <div class="form-group has-feedback">
            <label class="srequired">Bus</label>
            <select class="form-control selectpicker" name="vehicle_id" data-live-search="true" required>
            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($vehicle->id); ?>" <?php if($vehicle->id==$waybills->vehicle_id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($vehicle->register_number); ?>||<?php echo e($vehicle->vehicleType->name); ?></option>      
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <?php if($errors->has('vehicle_id')): ?>
            <span class="help-block">
            <strong class="error-text"><?php echo e($errors->first('vehicle_id')); ?></strong>
            </span>
          <?php endif; ?>

          <div class="form-group has-feedback">
            <label class="srequired">Conductor</label>
            <select class="form-control selectpicker" name="conductor_id" data-live-search="true" required>
            <?php $__currentLoopData = $conductors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conductor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($conductor->id); ?>" <?php if($conductor->id==$waybills->conductor_id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($conductor->name); ?>||<?php echo e($conductor->employee_code); ?></option>      
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <?php if($errors->has('conductor_id')): ?>
            <span class="help-block">
            <strong class="error-text"><?php echo e($errors->first('conductor_id')); ?></strong>
            </span>
          <?php endif; ?>

        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label class="srequired">Driver</label>
            <select class="form-control selectpicker" name="driver_id" data-live-search="true" required>
            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($driver->id); ?>" <?php if($driver->id==$waybills->driver_id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($driver->name); ?>||<?php echo e($driver->employee_code); ?></option>      
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <?php if($errors->has('driver_id')): ?>
            <span class="help-block">
            <strong class="error-text"><?php echo e($errors->first('driver_id')); ?></strong>
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

<div class="clearfix"></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>