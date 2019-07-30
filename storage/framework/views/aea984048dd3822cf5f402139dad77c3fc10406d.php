 
<?php $__env->startSection('title'); ?>
    Create ETM
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create ETM</h1>
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
            <i class="fa fa-tablet"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('etm.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Name" name="name" value="<?php echo e(old('name')); ?>" required> 
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
              </div>
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">IMEI</label>
                <input type="text" class="form-control <?php echo e($errors->has('imei') ? ' has-error' : ''); ?>" placeholder="IMEI" name="imei" value="<?php echo e(old('imei')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('imei')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('imei')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Purchase Date</label>
                <input type="date" class="form-control <?php echo e($errors->has('purchase_date') ? ' has-error' : ''); ?>" placeholder="Purchase Date" name="purchase_date" value="<?php echo e(old('purchase_date')); ?>" required> 
                <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
              </div>
              <?php if($errors->has('purchase_date')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('purchase_date')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Version</label>
                <input type="text" class="form-control <?php echo e($errors->has('version') ? ' has-error' : ''); ?>" placeholder="Version" name="version" value="<?php echo e(old('version')); ?>" required> 
                <span class="glyphicon glyphicon-book form-control-feedback"></span>
              </div>
              <?php if($errors->has('version')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('version')); ?></strong>
                </span>
              <?php endif; ?>


               <div class="form-group has-feedback">
                <label class="srequired">Depot</label>

                   <select class="form-control <?php echo e($errors->has('to_depot') ? ' has-error' : ''); ?>" placeholder="Depot" name="depot"required>
                  <option value="0">Select</option>
                  <?php $__currentLoopData = $depots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($depot->id); ?>"><?php echo e($depot->name); ?>||<?php echo e($depot->code); ?></option>  
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </select>
                
              </div>
              <?php if($errors->has('depot')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('depot')); ?></strong>
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