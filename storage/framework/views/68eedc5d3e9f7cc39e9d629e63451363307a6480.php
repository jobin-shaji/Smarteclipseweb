 
<?php $__env->startSection('title'); ?>
    Create State Tax
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create State Tax</h1>
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
            <i class="fa fa-dashcube"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('state-tax.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">State</label>
                  <select class="form-control <?php echo e($errors->has('state_id') ? ' has-error' : ''); ?>" placeholder="State" name="state_id"required>
                  <option value="">Select State</option>
                  <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>  
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
              </div>
              <?php if($errors->has('state_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('state_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Percentage</label>
                <input type="text" class="form-control <?php echo e($errors->has('percentage') ? ' has-error' : ''); ?>" placeholder="Percentage" name="percentage" value="<?php echo e(old('percentage')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('percentage')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('percentage')); ?></strong>
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