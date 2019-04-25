<?php $__env->startSection('title'); ?>
  Add Route
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create Route</h1>
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
            <i class="fa fa-road"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('routes.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
             
              <div class="form-group has-feedback">
                <label class="srequired">Route Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Route Name" name="name" value="<?php echo e(old('name')); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">From Location</label>
                <select class="form-control <?php echo e($errors->has('from_stage_id') ? ' has-error' : ''); ?>" placeholder="From Location" name="from_stage_id" value="<?php echo e(old('from_stage_id')); ?>" >
                  <option value="">Select From Location</option>
                  <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?> - <?php echo e($stage->code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('from_stage_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('from_stage_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">KM</label>
                <input type="text" class="form-control <?php echo e($errors->has('km') ? ' has-error' : ''); ?>" placeholder="KM" name="km" value="<?php echo e(old('km')); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('km')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('km')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">From Stage</label>
                <select class="form-control <?php echo e($errors->has('from_slab_id') ? ' has-error' : ''); ?>" placeholder="From Stage" name="from_slab_id" value="<?php echo e(old('from_slab_id')); ?>" >
                  <option value="">Select From Stage</option>
                  <?php $__currentLoopData = $fareslab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fare_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($fare_code->id); ?>"><?php echo e($fare_code->code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('from_slab_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('from_slab_id')); ?></strong>
                </span>
              <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div class="form-group has-feedback">
                <label class="srequired">Route Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('route_code') ? ' has-error' : ''); ?>" placeholder="Route code" name="route_code" value="<?php echo e(old('route_code')); ?>" required> 
              </div>
              <?php if($errors->has('route_code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('route_code')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">To Location</label>
                <select class="form-control <?php echo e($errors->has('to_stage_id') ? ' has-error' : ''); ?>" placeholder="To Location" name="to_stage_id" value="<?php echo e(old('to_stage_id')); ?>" >
                  <option value="">Select To Location</option>
                  <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?> - <?php echo e($stage->code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('to_stage_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('to_stage_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Bus Type</label>
                <select class="form-control <?php echo e($errors->has('bus_type_id') ? ' has-error' : ''); ?>" placeholder="Bus Type" name="bus_type_id" value="<?php echo e(old('bus_type_id')); ?>" >
                  <option value="">Select Bus Type</option>
                  <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('bus_type_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('bus_type_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">To Stage</label>
                <select class="form-control <?php echo e($errors->has('to_slab_id') ? ' has-error' : ''); ?>" placeholder="To Stage" name="to_slab_id" value="<?php echo e(old('to_slab_id')); ?>" >
                  <option value="">Select To Stage</option>
                  <?php $__currentLoopData = $fareslab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fare_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($fare_code->id); ?>"><?php echo e($fare_code->code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('to_slab_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('to_slab_id')); ?></strong>
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