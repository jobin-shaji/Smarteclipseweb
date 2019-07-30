<?php $__env->startSection('title'); ?>
  Edit Schedule
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Edit Schedule</h1>
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
            <i class="fa fa-calendar"></i>
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('schedule.update.p',$schedule->id)); ?>">
        <?php echo e(csrf_field()); ?>

     <div class="row">
        <div class="col-md-6">
             
              <div class="form-group has-feedback">
                <label class="srequired">Schedule Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Schedule Name" name="name" value="<?php echo e($schedule->name); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>

                <div class="form-group has-feedback">
                <label class="srequired">Start Time</label>
                 <div class='input-group date'  id='datetimepicker1'>
                        <input type='text' class="form-control <?php echo e($errors->has('start') ? ' has-error' : ''); ?>" name="start" value="<?php echo e($schedule->start); ?>" onkeydown="return false" autocomplete="off"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
              </div>
              <?php if($errors->has('start')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('start')); ?></strong>
                </span>
              <?php endif; ?>


          </div>
        <div class="col-md-6">

               <div class="form-group has-feedback">
                <label class="srequired">Schedule Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Schedule Code" name="code" value="<?php echo e($schedule->code); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('code')); ?></strong>
                </span>
              <?php endif; ?>

               <div class="form-group has-feedback">
                <label class="srequired">Expire Time</label>
                <div class='input-group date'  id='datetimepicker2'>
                    <input type='text' class="form-control <?php echo e($errors->has('stop') ? ' has-error' : ''); ?>" name="stop" value="<?php echo e($schedule->end); ?>" onkeydown="return false" autocomplete="off" onkeydown="return false" autocomplete="off" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
              <?php if($errors->has('stop')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('stop')); ?></strong>
                </span>
              <?php endif; ?>



        </div>
      </div>     

      <div class="row">
            <!-- /.col -->
       <div class="col-md-3 ">
         <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
       </div>
            <!-- /.col -->
    </div>
    </form>
</section>

<section class="hilite-content">
  <h2>Schedule Trip</h2>
  <form action="<?php echo e(route('schedule.trip.add')); ?>" method="post">
  <?php echo csrf_field(); ?>
<section class="hilite-content">
  <div class="row">
    <div class="col-xs-5">
      <h2 class="page-header">
        <i class="fa fa-plus"> Add Trip</i> 
      </h2>
      <div class="form-group">
        <input type="hidden" name="schedule" value="<?php echo e($schedule->id); ?>">
        <label>Trips</label>
          <select class="form-control" name="trip">
          <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($trip->id); ?>"><?php echo e($trip->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
      </div>
      <div class="form-group">
        <button class="btn btn-block btn-success">Add</button>
      </div>
    </div>
  </div>
</section>
</form>
</section>



<section class="hilite-content">
  <div class="row">
    <div class="col-xs-10">
      <h2 class="page-header">Selected Trips</h2>

   <table class="table table-striped">
    <thead>
      <tr>
        <th>Trips</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th></th>
      </tr>
    </thead>

        
         <tbody>
      <?php $__currentLoopData = $selectedTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheduleTrip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
       <td><?php echo e($scheduleTrip->tripDetails->name); ?></td>
       <td><?php echo e($scheduleTrip->tripDetails->start); ?></td>
       <td><?php echo e($scheduleTrip->tripDetails->end); ?></td>

        <td>
          <form action="<?php echo e(route('scheduled.trip.remove')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" value="<?php echo e($scheduleTrip->id); ?>" name="pivot">
            <button class="btn btn-xs btn-danger">Remove</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>

      
  </table>

    </div>
  </div>
</section>
</form>
</section>


 
<div class="clearfix"></div>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('js/etm/schedule-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>