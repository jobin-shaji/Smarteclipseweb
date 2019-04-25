 
<?php $__env->startSection('title'); ?>
    Create WayBill
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create WayBill</h1>
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
     <form  method="POST" action="<?php echo e(route('waybill.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">WayBill Number</label>
                <input type="text" class="form-control" name="waybill_number" value="<?php echo e($waybill_number); ?>" readonly> 
              </div>

              <div class="form-group has-feedback">
                <label class="srequired">From Date&Time</label>
                 <div class='input-group date'  id='from_date'>
                    <input type='text' class="form-control <?php echo e($errors->has('from_date') ? ' has-error' : ''); ?>" placeholder="Select From Date&Time" name="from_date" value="<?php echo e(old('from_date')); ?>" onkeydown="return false" autocomplete="off"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
              <?php if($errors->has('from_date')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('from_date')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Vehicle</label>
                <select class="form-control" name="vehicle_id">
                  <option selected disabled>Select Bus</option>
                  <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->register_number); ?>||<?php echo e($vehicle->vehicleType->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              <?php if($errors->has('vehicle_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('vehicle_id')); ?></strong>
                </span>
              <?php endif; ?> 

              <div class="form-group has-feedback">
                <label class="srequired">ETM</label>
                <select class="form-control" name="etm_id">
                  <option selected disabled>Select ETM</option>
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
          <div class="col-md-6">
            <div class="form-group has-feedback">
              <label class="srequired">Schedule</label>
                <select class="form-control" name="schedule_id">
                  <option selected disabled>Select Schedule</option>
                  <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($schedule->id); ?>"><?php echo e($schedule->name); ?></option>  
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php if($errors->has('schedule_id')): ?>
              <span class="help-block">
                  <strong class="error-text"><?php echo e($errors->first('schedule_id')); ?></strong>
              </span>
            <?php endif; ?>

            <div class="form-group has-feedback">
              <label class="srequired">To Date&Time</label>
                <div class='input-group date'  id='to_date'>
                  <input type='text' class="form-control <?php echo e($errors->has('to_date') ? ' has-error' : ''); ?>" placeholder="Select To Date&Time" name="to_date" value="<?php echo e(old('to_date')); ?>" onkeydown="return false" autocomplete="off"/>
                  <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
            </div>
            <?php if($errors->has('to_date')): ?>
              <span class="help-block">
                <strong class="error-text"><?php echo e($errors->first('to_date')); ?></strong>
              </span>
            <?php endif; ?>

            <div class="form-group has-feedback">
              <label class="srequired">Crew</label>
                <select class="form-control" name="crew_id">
                  <option selected disabled>Select Crew</option>
                  <?php $__currentLoopData = $crews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crew): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($crew->id); ?>"><?php echo e($crew->name); ?></option>  
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php if($errors->has('crew_id')): ?>
              <span class="help-block">
                <strong class="error-text"><?php echo e($errors->first('crew_id')); ?></strong>
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
<?php $__env->startSection('script'); ?>
    <script>
      $(document).ready(function () {
        $('#from_date').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss'
        });
        $('#to_date').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss'
        });

      });
    </script>
<?php $__env->stopSection(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>