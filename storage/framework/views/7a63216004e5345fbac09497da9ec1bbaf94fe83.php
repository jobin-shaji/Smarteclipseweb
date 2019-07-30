 
<?php $__env->startSection('title'); ?>
    Create Advance Booking WayBill
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create Advance Booking WayBill</h1>
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
            <i class="fa fa-list-alt"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('agent-waybill.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">WayBill Number</label>
                <input type="text" class="form-control" name="code" value="<?php echo e($waybill_number); ?>" readonly> 
              </div>

              <div class="form-group has-feedback">
                <label class="srequired">Advance Booker</label>
                <select class="form-control selectpicker" title="Select advance booker" data-live-search="true" name="agent_id" required>
                  <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($agent->id); ?>"><?php echo e($agent->name); ?>||<?php echo e($agent->employee_code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              <?php if($errors->has('agent_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('agent_id')); ?></strong>
                </span>
              <?php endif; ?> 

          </div>
          <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="srequired">ETM</label>
                <select class="form-control selectpicker" data-live-search="true" title="Select ETM" name="etm_id" required>
                  <?php $__currentLoopData = $etms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($etm->id); ?>"><?php echo e($etm->name); ?>||<?php echo e($etm->imei); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              <?php if($errors->has('etm_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('etm_id')); ?></strong>
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