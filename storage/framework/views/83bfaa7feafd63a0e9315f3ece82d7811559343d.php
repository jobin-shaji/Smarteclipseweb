<?php $__env->startSection('title'); ?>
  Route Edit
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Edit Route</h1>
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
            <i class="fa fa-road"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('route.update.p',$route->id)); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
             
              <div class="form-group has-feedback">
                <label class="srequired">Route Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="Route Name" name="name" value="<?php echo e($route->name); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">From Location</label>
                <select class="form-control <?php echo e($errors->has('from_stage_id') ? ' has-error' : ''); ?>" placeholder="From Location" name="from_stage_id" value="<?php echo e(old('from_stage_id')); ?>" >
                  <option value="">Select From Location</option>
                  <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($stage->id); ?>"  <?php if($route->from_stage_id==$stage->id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($stage->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('from_stage_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('from_stage_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">KM</label>
                <input type="text" class="form-control <?php echo e($errors->has('km') ? ' has-error' : ''); ?>" placeholder="KM" name="km" value="<?php echo e($route->km); ?>" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('km')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('km')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">From Stage</label>
                <select class="form-control <?php echo e($errors->has('from_slab_id') ? ' has-error' : ''); ?>" placeholder="From Stage" name="from_slab_id" value="<?php echo e(old('from_slab_id')); ?>" >
                  <option value="">Select From Stage</option>
                  <?php $__currentLoopData = $fareslab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fare_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($fare_code->id); ?>"  <?php if($route->from_slab_id==$fare_code->id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($fare_code->code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('from_slab_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('from_slab_id')); ?></strong>
                </span>
              <?php endif; ?>

            </div>
            <div class="col-md-6">
                <div class="form-group has-feedback">
                <label class="srequired">Route Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('route_code') ? ' has-error' : ''); ?>" value="<?php echo e($route->route_code); ?>" placeholder="Route code" name="route_code" value="<?php echo e(old('route_code')); ?>" required> 
                <span class="glyphicon  glyphicon-th form-control-feedback"></span>
              </div>
              <?php if($errors->has('route_code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('route_code')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">To Location</label>
                <select class="form-control <?php echo e($errors->has('to_stage_id') ? ' has-error' : ''); ?>" placeholder="To Location" name="to_stage_id" value="<?php echo e(old('to_stage_id')); ?>" >
                  <option value="">Select To Location</option>
                  <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($stage->id); ?>"  <?php if($route->to_stage_id==$stage->id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($stage->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('to_stage_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('to_stage_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Bus Type</label>
                <select class="form-control <?php echo e($errors->has('bus_type_id') ? ' has-error' : ''); ?>" placeholder="Bus Type" name="bus_type_id" value="<?php echo e(old('bus_type_id')); ?>" >
                  <option value="">Select</option>
                  <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($type->id); ?>"  <?php if($route->bus_type_id==$type->id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($type->name); ?></option>
                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('bus_type_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('bus_type_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">To Stage</label>
                <select class="form-control <?php echo e($errors->has('to_slab_id') ? ' has-error' : ''); ?>" placeholder="To Stage" name="to_slab_id" value="<?php echo e(old('to_slab_id')); ?>" >
                  <option value="">Select To Stage</option>
                  <?php $__currentLoopData = $fareslab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fare_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($fare_code->id); ?>"  <?php if($route->to_slab_id==$fare_code->id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($fare_code->code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('to_slab_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('to_slab_id')); ?></strong>
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

<form action="<?php echo e(route('route-stage.create.p')); ?>" method="post">
  <?php echo csrf_field(); ?>
<section class="hilite-content">
  <div class="row">
    <div class="col-xs-3">
      <h2 class="page-header">
        <i class="fa fa-plus"> Add Stage Details</i> 
      </h2>
      <input type="hidden" name="route_id" value="<?php echo e($route->id); ?>">

              <div class="form-group has-feedback">
                <label class="srequired">Location</label>
                <select class="form-control <?php echo e($errors->has('stage_id') ? ' has-error' : ''); ?>" placeholder="To Location" name="stage_id" value="<?php echo e(old('stage_id')); ?>" >
                  <option value="">Select To Location</option>
                  <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?> - <?php echo e($stage->code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('stage_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('stage_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">KM</label>
                <input type="text" class="form-control <?php echo e($errors->has('km_from_start') ? ' has-error' : ''); ?>" placeholder="KM" name="km_from_start" value="<?php echo e(old('km_from_start')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('km_from_start')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('km_from_start')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Fareslab Code</label>
                <select class="form-control <?php echo e($errors->has('fareslab_detail_id') ? ' has-error' : ''); ?>" placeholder="To Stage" name="fareslab_detail_id" value="<?php echo e(old('fareslab_detail_id')); ?>" >
                  <option value="">Select Code</option>
                  <?php $__currentLoopData = $fareslab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fare_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($fare_code->id); ?>"><?php echo e($fare_code->code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('fareslab_detail_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('fareslab_detail_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Boarding Time</label>
                  <div class='input-group date'  id='boarding_time1'>
                    <input type='text' class="form-control <?php echo e($errors->has('boarding_time') ? ' has-error' : ''); ?>" placeholder="Select boarding time" name="boarding_time" value="<?php echo e(old('boarding_time')); ?>" onkeydown="return false" autocomplete="off"/>
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
              </div>
              <?php if($errors->has('boarding_time')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('boarding_time')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Ending Time</label>
                  <div class='input-group date'  id='ending_time1'>
                    <input type='text' class="form-control <?php echo e($errors->has('ending_time') ? ' has-error' : ''); ?>" placeholder="Select ending time" name="ending_time" value="<?php echo e(old('ending_time')); ?>" onkeydown="return false" autocomplete="off"/>
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
              </div>
              <?php if($errors->has('ending_time')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('ending_time')); ?></strong>
                </span>
              <?php endif; ?>

      <div class="form-group">
        <button class="btn btn-block btn-success">Add</button>
      </div>
    </div>
  </div>
</section>
</form>

<section class="hilite-content">
  <h2>Stage Details</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Location</th>
        <th>KM</th>
        <th>Fareslab Code</th>
        <th>Boarding Time</th>
        <th>Ending Time</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $route->RouteDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($details->stageDetails->name); ?></td>
        <td><?php echo e($details->km_from_start); ?></td>
        <td><?php echo e($details->fareSlab->code); ?> </td>
        <td><?php echo e($details->boarding_time); ?> </td>
        <td><?php echo e($details->ending_time); ?> </td>
        <td>
          <form action="<?php echo e(route('route-stage.delete')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" value="<?php echo e($details->id); ?>" name="route_stage_id">
            <button class="btn btn-xs btn-danger">Remove</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</section>

<div class="clearfix"></div>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('js/etm/route-create.js')); ?>"></script>
    <script>
    $(document).ready(function () {
 $('#boarding_time1').datetimepicker({
    format: ' HH:mm:ss'
 });
 $('#ending_time1').datetimepicker({
     format: ' HH:mm:ss'
 });

});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>