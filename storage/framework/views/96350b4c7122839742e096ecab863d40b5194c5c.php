<?php $__env->startSection('title'); ?>
  Create Trip
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <section class="content-header">
     <h1>Create Trip</h1>
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
            <i class="fa fa-ticket"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
          <div class="col-md-6">
            <form action="<?php echo e(route('trips.create.p')); ?>" method="post">
              <?php echo csrf_field(); ?>
              <div class="form-group has-feedback">
                <label >Trip Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="trip name" name="name" value="<?php echo e(old('name')); ?>"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>      
              <div class="form-group has-feedback">
                <label >Start Time</label>
                <input type="time" class="form-control <?php echo e($errors->has('start') ? ' has-error' : ''); ?>" placeholder="start time" name="start" value="<?php echo e(old('start')); ?>"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              <?php if($errors->has('start')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('start')); ?></strong>
                </span>
              <?php endif; ?> 
              <div class="form-group has-feedback">
                <label >End Time</label>
                <input type="time" class="form-control <?php echo e($errors->has('end') ? ' has-error' : ''); ?>" placeholder="start time" name="end" value="<?php echo e(old('end')); ?>"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              <?php if($errors->has('end')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('end')); ?></strong>
                </span>
              <?php endif; ?> 
              <div class="form-group has-feedback">
                <label >Route </label>
                <select class="form-control" name="route">
                  <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($route->id); ?>"><?php echo e($route->name); ?> || <?php echo e($route->route_code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              <?php if($errors->has('route')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('route')); ?></strong>
                </span>
              <?php endif; ?> 
              <div class="form-group has-feedback">
                <label >Status </label>
                <select class="form-control" name="status">
                  <option value="1">Active</option>
                  <option value="0">InActive</option>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              <?php if($errors->has('status')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('status')); ?></strong>
                </span>
              <?php endif; ?>    
             <div class="form-group">
               <button class="btn btn-success">Create</button>
             </div>   
             </form>     
           </div>            
        </div>     
  </section>
<div class="clearfix"></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>