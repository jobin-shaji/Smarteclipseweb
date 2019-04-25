 
<?php $__env->startSection('title'); ?>
    Create Toll Fee Slab
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create Toll Fee Slab</h1>
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
     <form  method="POST" action="<?php echo e(route('tollfee-slab.create.p')); ?>">
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
                <label class="srequired">Minimum Limit</label>
                <input type="text" class="form-control <?php echo e($errors->has('min_limit') ? ' has-error' : ''); ?>" placeholder="Minimum Limit" name="min_limit" value="<?php echo e(old('min_limit')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('min_limit')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('min_limit')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Maximum Limit</label>
                <input type="text" class="form-control <?php echo e($errors->has('max_limit') ? ' has-error' : ''); ?>" placeholder="Maximum Limit" name="max_limit" value="<?php echo e(old('max_limit')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('max_limit')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('max_limit')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Amount</label>
                <input type="text" class="form-control <?php echo e($errors->has('amount') ? ' has-error' : ''); ?>" placeholder="Amount" name="amount" value="<?php echo e(old('amount')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('amount')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('amount')); ?></strong>
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