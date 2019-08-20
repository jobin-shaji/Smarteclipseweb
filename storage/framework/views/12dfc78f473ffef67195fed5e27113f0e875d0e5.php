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
         
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('routes.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Route Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('RouteCode') ? ' has-error' : ''); ?>" placeholder="Route code" name="routeCode" value="<?php echo e(old('RouteCode')); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('RouteCode')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('RouteCode')); ?></strong>
                </span>
              <?php endif; ?>
              <div class="form-group has-feedback">
                <label class="srequired">From Stage</label>
                  <select class="form-control selectpicker" data-live-search="true" id="Frmstage" name="Frmstage" title="Select Stage" required>
                  <?php $__currentLoopData = $stage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?></option>  
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
              </div>
              
              <?php if($errors->has('Frmstage')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('Frmstage')); ?></strong>
                </span>
              <?php endif; ?>
 
              <div class="form-group has-feedback">
                <label class="srequired">To Stage</label>
                  <select class="form-control selectpicker" title="Select Stage" data-live-search="true" name="toStage" required>

                      <?php $__currentLoopData = $tostage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toStage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($toStage->id); ?>"><?php echo e($toStage->name); ?></option>  
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              
                  </select>
              </div>

              <?php if($errors->has('toStage')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('toStage')); ?></strong>
                </span>
              <?php endif; ?>

               <div class="form-group has-feedback">
                <label class="srequired">Total KM</label>
                <input type="text" class="form-control <?php echo e($errors->has('totalkm') ? ' has-error' : ''); ?>" placeholder="Total KM" name="totalkm" value="<?php echo e(old('totalkm')); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
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