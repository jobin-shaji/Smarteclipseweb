
<?php $__env->startSection('title'); ?>
  Add Stage
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create Stage</h1>
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
            <i class="fa fa-map-marker"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('stage.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Stage Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Stage name" name="name" value="<?php echo e(old('name')); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">State</label>
                  <select class="form-control" id="depot_id" name="depot_id" required>
                  <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($state->depots->count() > 0) {?>
                  <option value="<?php echo e($state->depots->first()->id); ?>"><?php echo e($state->name); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                  <?php }?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
              </div>
              <?php if($errors->has('depot')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('depot')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Stage Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('code') ? ' has-error' : ''); ?>" placeholder="Stage code" name="code" value="<?php echo e(old('code')); ?>" required> 
                <span class="glyphicon  glyphicon-th form-control-feedback"></span>
              </div>
              <?php if($errors->has('code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('code')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Stage Category</label>
                  <select class="form-control selectpicker" title="Select Category" data-live-search="true" name="stage_category_id" required>
                  <?php $__currentLoopData = $stage_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>  
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
              </div>


            

              <?php if($errors->has('stage_category_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('stage_category_id')); ?></strong>
                </span>
              <?php endif; ?>

            </div>
            <div class="col-md-6">


           
            </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                 <input type="checkbox" name="border_status">
                 <label class="">Border Status</label>
                </div>

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
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('js/etm/stage-dependent-dropdown.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>