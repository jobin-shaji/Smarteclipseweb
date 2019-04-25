 
<?php $__env->startSection('title'); ?>
    Create Toll Booth
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create TollBooth</h1>
    </section>
   

<section class="hilite-content">
      
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-road"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('tollbooth.create.p')); ?>">
      <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Toll Booth Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('tollbooth') ? ' has-error' : ''); ?>" placeholder="TollBooth name" name="tollbooth" value="<?php echo e(old('tollbooth')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('tollbooth')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('tollbooth')); ?></strong>
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