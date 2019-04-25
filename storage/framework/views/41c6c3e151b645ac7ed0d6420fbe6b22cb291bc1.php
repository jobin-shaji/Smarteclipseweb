 
<?php $__env->startSection('title'); ?>
    Create GST
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create GST</h1>
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
            <i class="fa fa-gg"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('gst.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">

            <div class="form-group has-feedback">
                <label class="srequired">Vehicle Type</label>
                   <select class="form-control <?php echo e($errors->has('vehicle_type_id') ? ' has-error' : ''); ?>" placeholder="Vehicle Type" name="vehicle_type_id"required>
                  <option selected disabled>Select Vehicle Type</option>
                  <?php $__currentLoopData = $vehicle_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($vehicle_type->id); ?>"><?php echo e($vehicle_type->name); ?></option>  
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </select>
              </div>
              <?php if($errors->has('vehicle_type_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('vehicle_type_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">GST Percentage</label>
                <input type="text" class="form-control <?php echo e($errors->has('gst_percentage') ? ' has-error' : ''); ?>" placeholder="GST Percentage" name="gst_percentage" value="<?php echo e(old('gst_percentage')); ?>" required> 
              </div>
              <?php if($errors->has('gst_percentage')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('gst_percentage')); ?></strong>
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