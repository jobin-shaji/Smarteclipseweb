 
<?php $__env->startSection('title'); ?>
   Edit user details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
     <h1>Edit user</h1>
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
            <i class="fa fa-edit"> User details</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="<?php echo e(route('users.update.p',$user->id)); ?>">
        <?php echo e(csrf_field()); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="srequired">User Name</label>
                <input type="text" class="form-control" placeholder="user name" name="username" value="<?php echo e($user->username); ?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
           </div>
            <?php if($errors->has('username')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('username')); ?></strong>
                </span>
            <?php endif; ?>
          <div class="form-group has-feedback">
           <label class="srequired">Email</label>
            <input type="email" class="form-control <?php echo e($errors->has('email') ? ' has-error' : ''); ?>" placeholder="Email" name="email" value="<?php echo e($user->email); ?>" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
            <?php if($errors->has('email')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('email')); ?></strong>
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
<div class="clearfix"></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>