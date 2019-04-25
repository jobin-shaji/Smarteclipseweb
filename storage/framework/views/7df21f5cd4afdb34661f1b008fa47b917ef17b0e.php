
<?php $__env->startSection('title'); ?>
  concession edit
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <section class="content-header">
     <h1>Edit Concession</h1>
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
            <i class="fa fa-ticket"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
          <div class="col-md-6">
            <form action="<?php echo e(route('concession.update',$concession->id)); ?>" method="post">
              <?php echo csrf_field(); ?>
              <div class="form-group has-feedback">
                <label >Concession Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('name') ? ' has-error' : ''); ?>" placeholder="concession Name" name="name" value="<?php echo e($concession->name); ?>"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>   
              <?php if($errors->has('name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('name')); ?></strong>
                </span>
              <?php endif; ?>       
              <div class="form-group has-feedback">
                <label >Concession Short Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('short_name') ? ' has-error' : ''); ?>" placeholder="concession Name" name="short_name" value="<?php echo e($concession->short_name); ?>"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>   
              <?php if($errors->has('short_name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('short_name')); ?></strong>
                </span>
              <?php endif; ?>   
              <div class="form-group has-feedback">
                <label class="srequired">Concession Category</label>
                <select class="form-control <?php echo e($errors->has('ticket_category_id') ? ' has-error' : ''); ?>" placeholder="Concession Category" name="ticket_category_id" value="<?php echo e(old('ticket_category_id')); ?>" required>
                <option value="">Select</option>
                <?php $__currentLoopData = $ticket_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($category->id); ?>" <?php if($category->id==$concession->ticket_category_id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($category->name); ?></option>      
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <?php if($errors->has('ticket_category_id')): ?>
                <span class="help-block">
                <strong class="error-text"><?php echo e($errors->first('ticket_category_id')); ?></strong>
                </span>
              <?php endif; ?>
               <div class="form-group has-feedback">
                <label >Reduction percentage</label>
                <input type="text" class="form-control <?php echo e($errors->has('reduction_percentage') ? ' has-error' : ''); ?>" placeholder="concession percentage" name="reduction_percentage" value="<?php echo e($concession->reduction_percentage); ?>"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>  
              <?php if($errors->has('reduction_percentage')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('reduction_percentage')); ?></strong>
                </span>
              <?php endif; ?>         
              <div class="form-group has-feedback">
                <label >Status</label>
                 <select class="form-control" name="status">
                  <option value="1" 
                  <?php
                    if($concession->status == 1){
                      echo "selected";
                    }
                  ?>
                  >Active</option>
                  <option value="0"
                  <?php
                    if($concession->status == 0){
                      echo "selected";
                    }
                  ?>
                  >InActive</option>
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>   
              <?php if($errors->has('status')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('status')); ?></strong>
                </span>
              <?php endif; ?> 
             <div class="form-group">
               <button class="btn btn-info">Update</button>
             </div>   
             </form>     
           </div>            
        </div>     
</section>
<form action="<?php echo e(route('concession.vehicle.add')); ?>" method="post">
  <?php echo csrf_field(); ?>
<section class="hilite-content">
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <input type="hidden" name="concession" value="<?php echo e($concession->id); ?>">
        <label>Add new vehicle Type</label>
        <select class="form-control" name="vehicle_type">
          <?php $__currentLoopData = $vehicle_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php if($errors->has('vehicle_type')): ?>
            <span class="help-block">
              <strong class="error-text"><?php echo e($errors->first('vehicle_type')); ?></strong>
            </span>
        <?php endif; ?>  
      </div>
      <div class="form-group">
        <button class="btn btn-block btn-success">Add</button>
      </div>
    </div>
  </div>
</section>
</form>
<section class="hilite-content">
  <h2>Applicable vehicle types</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $concession->vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($vehicle_type->name); ?></td>
        <td>
          <form action="<?php echo e(route('concession.vehicle.remove')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" value="<?php echo e($vehicle_type->pivot->id); ?>" name="pivot">
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