<?php $__env->startSection('title'); ?>
  Add Schedule
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create Schedule</h1>
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
     <form  method="POST" action="<?php echo e(route('schedule.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

     <div class="row">
        <div class="col-md-6">
             
              <div class="form-group has-feedback">
                <label class="srequired">Schedule Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Schedule Name" name="name" value="<?php echo e(old('name')); ?>" > 
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
                        <input type='text' class="form-control <?php echo e($errors->has('start') ? ' has-error' : ''); ?>" name="start" value="<?php echo e(old('start')); ?>" onkeydown="return false" autocomplete="off"/>
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
                <input type="text" class="form-control <?php echo e($errors->has('code') ? ' has-error' : ''); ?>" placeholder="Schedule Code" name="code" value="<?php echo e(old('name')); ?>" > 
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
                    <input type='text' class="form-control <?php echo e($errors->has('stop') ? ' has-error' : ''); ?>" name="stop" value="<?php echo e(old('stop')); ?>" onkeydown="return false"/>
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
         <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
       </div>
            <!-- /.col -->
    </div>
    </form>
</section>
 
<div class="clearfix"></div>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('js/etm/schedule-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>