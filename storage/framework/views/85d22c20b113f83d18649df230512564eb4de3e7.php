<?php $__env->startSection('title'); ?>
  Route Stage
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <section class="content-header">
     <h1>Route Stage</h1>
  </section>
    <?php if(Session::has('message')): ?>
    <div class="pad margin no-print">
      <div class="callout <?php echo e(Session::get('callout-class', 'callout-success')); ?>" style="margin-bottom: 0!important;">
          <?php echo e(Session::get('message')); ?>  
      </div>
    </div>
    <?php endif; ?>  
<section class="hilite-content">
<div class="row">

<div class="col-md-6">
<form action="<?php echo e(route('route.stage.add')); ?>" method="post">
  <?php echo csrf_field(); ?>
    <div class="col-md-6">
      <div class="form-group">
        <input type="hidden" name="route_id" value="<?php echo e($id); ?>">
        <label>Add stages</label>
        <select class="form-control" name="Stage">
           <?php $__currentLoopData = $stage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php if($errors->has('Stage')): ?>
            <span class="help-block">
              <strong class="error-text"><?php echo e($errors->first('Stage')); ?></strong>
            </span>
        <?php endif; ?> 
      </div>
       <div class="form-group">
         <label> KM</label>
         <input type="text" class="form-control <?php echo e($errors->has('Kilometer') ? ' has-error' : ''); ?>" placeholder="KM" name="Kilometer" value="">  
      </div>
      <div class="form-group">
        <button class="btn btn-block btn-success">Add</button>
      </div>
      </div>
</form>
</div>
</div>
</section>

<div class="clearfix"></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>