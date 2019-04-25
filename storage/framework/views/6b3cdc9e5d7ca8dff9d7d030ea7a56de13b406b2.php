
<?php $__env->startSection('title'); ?>
  Edit Stage
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Edit Stage</h1>
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
     <form  method="POST" action="<?php echo e(route('stages.update.p',$stage->id)); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Stage Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" name="name" value="<?php echo e($stage->name); ?>" > 
                <span class="glyphicon glyphicon-th form-control-feedback"></span>
              </div>
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Stage Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('vehicle_occupancy') ? ' has-error' : ''); ?>" name="code" value="<?php echo e($stage->code); ?>" required> 
                <span class="glyphicon  glyphicon-th form-control-feedback"></span>
              </div>
              <?php if($errors->has('code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('code')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Stage Category</label>
                <select class="form-control <?php echo e($errors->has('stage_category_id') ? ' has-error' : ''); ?>" name="stage_category_id" value="<?php echo e(old('stage_category_id')); ?>" required>
                <option selected disabled>Select Stage Category</option>
                  <?php $__currentLoopData = $stage_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php if($category->id==$stage->stage_category_id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($category->name); ?></option>      
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
              <div class="form-group has-feedback">
                <label class="srequired">State</label>
                <select class="form-control selectpicker" data-live-search="true" id="state_id" name="state_id" title="Select State" required>
                  <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($state->id); ?>" <?php if($state->id==$stage->depot->state->id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($state->name); ?></option>      
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <?php if($errors->has('state_id')): ?>
                <span class="help-block">
                <strong class="error-text"><?php echo e($errors->first('state_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">District</label>
                <select class="form-control" id="district_id" name="district_id" required>
                <option selected><?php echo e($stage->depot->district->name); ?></option>
                </select>
              </div>

              <div class="form-group has-feedback">
                <label class="srequired">Depot</label>
                <select class="form-control" id="depot_id" name="depot_id" required>
                <option value="<?php echo e($stage->depot->id); ?>" selected><?php echo e($stage->depot->name); ?></option>
                </select>
              </div>
              
            </div>

        </div>
        <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                 <input type="checkbox" name="border_status" <?php if($stage->border_status==1): ?><?php echo e("checked"); ?> <?php endif; ?>>
                 <label class="">Border Status</label>
                </div>

               </div>
            </div>
              <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                 <input type="checkbox" name="toll_status" <?php if($stage->toll==1): ?><?php echo e("checked"); ?> <?php endif; ?>>
                 <label class="">Toll Status</label>
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