 
<?php $__env->startSection('title'); ?>
   Update fare slab details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
     <h1>Edit fare slab</h1>
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
            <i class="fa fa-edit"> Edit fare details</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="<?php echo e(route('fare-slab.update.p',$fare_slab->id)); ?>">
        <?php echo e(csrf_field()); ?>

    <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label class="srequired">Fare Slab Name</label>
            <input type="text" class="form-control <?php echo e($errors->has('fare_slab_name') ? ' has-error' : ''); ?>" placeholder="Fare Slab Name" name="fare_slab_name" value="<?php echo e($fare_slab->fare_slab_name); ?>"> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <?php if($errors->has('fare_slab_name')): ?>
            <span class="help-block">
            <strong class="error-text"><?php echo e($errors->first('fare_slab_name')); ?></strong>
            </span>
          <?php endif; ?>

          <div class="form-group has-feedback">
            <label class="srequired">Bus Type</label>
            <select class="form-control <?php echo e($errors->has('bus_type_id') ? ' has-error' : ''); ?>" placeholder="Bus Type" name="bus_type_id" value="<?php echo e(old('bus_type_id')); ?>" required>
            <option value="">Select</option>
            <?php $__currentLoopData = $busType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($type->id); ?>" <?php if($type->id==$fare_slab->bus_type_id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($type->name); ?></option>      
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <?php if($errors->has('bus_type_id')): ?>
            <span class="help-block">
            <strong class="error-text"><?php echo e($errors->first('bus_type_id')); ?></strong>
            </span>
          <?php endif; ?>
          
      </div>
    </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
</section>


<form action="<?php echo e(route('fare-slab-details.create.p')); ?>" method="post">
  <?php echo csrf_field(); ?>
<section class="hilite-content">
  <div class="row">
    <div class="col-xs-3">
      <h2 class="page-header">
        <i class="fa fa-plus"> Add Fare Slab Details</i> 
      </h2>
      <input type="hidden" name="fare_slab_id" value="<?php echo e($fare_slab->id); ?>">

              <div class="form-group has-feedback">
                <label class="srequired">Fare Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('code') ? ' has-error' : ''); ?>" placeholder="Fare Code" name="code" value="<?php echo e(old('code')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('code')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Stage ID</label>
                <input type="text" class="form-control <?php echo e($errors->has('stage_id') ? ' has-error' : ''); ?>" placeholder="Stage ID" name="stage_id" value="<?php echo e(old('stage_id')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('stage_id')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('stage_id')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">KM</label>
                <input type="text" class="form-control <?php echo e($errors->has('km') ? ' has-error' : ''); ?>" placeholder="KM" name="km" value="<?php echo e(old('km')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('km')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('km')); ?></strong>
                </span>
              <?php endif; ?>

              <div class="form-group has-feedback">
                <label class="srequired">Amount</label>
                <input type="text" class="form-control <?php echo e($errors->has('amount') ? ' has-error' : ''); ?>" placeholder="Amount" name="amount" value="<?php echo e(old('amount')); ?>" required> 
                <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
              </div>
              <?php if($errors->has('amount')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('amount')); ?></strong>
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
  <h2>Fare Details</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Fare Code</th>
        <th>Stage ID</th>
        <th>KM</th>
        <th>Amount</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $fare_slab->fareSlabDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($details->code); ?></td>
        <td><?php echo e($details->stage_id); ?></td>
        <td><?php echo e($details->km); ?> </td>
        <td><?php echo e($details->amount); ?> </td>
        <td>
          <form action="<?php echo e(route('fare-slab-details.delete')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" value="<?php echo e($details->id); ?>" name="fare_slab_detail_id">
            <button class="btn btn-xs btn-danger">Remove</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</section>


<div class="clearfix"></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>