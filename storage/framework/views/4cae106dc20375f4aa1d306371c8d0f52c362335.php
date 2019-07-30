 
<?php $__env->startSection('title'); ?>
   User details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-header">
     <h1>User details</h1>
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
            <i class="fa fa-user"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="<?php echo e(route('users.update.p',$user->id)); ?>">
        <?php echo e(csrf_field()); ?>

    <div class="row">
        <div class="col-md-6">
       
          <div class="form-group has-feedback">
            <label>User Name</label>
            <input type="text" class="form-control <?php echo e($errors->has('username') ? ' has-error' : ''); ?>" placeholder="User Name" name="username" value="<?php echo e($user->username); ?>" disabled>
          </div>
            <?php if($errors->has('username')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('username')); ?></strong>
                </span>
            <?php endif; ?>
          <div class="form-group has-feedback">
           <label>Email</label>
            <input type="email" class="form-control <?php echo e($errors->has('email') ? ' has-error' : ''); ?>" placeholder="Email" name="email" value="<?php echo e($user->email); ?>" disabled>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
            <?php if($errors->has('email')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('email')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
     
          <div class="form-group has-feedback">
            <label>Password</label>
            <input type="password" class="form-control <?php echo e($errors->has('password') ? ' has-error' : ''); ?>" placeholder="*******" name="password" disabled>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div> 
            <?php if($errors->has('password')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('password')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
   </div>
<!--  -->
    </form>
</section>
<div class="clearfix"></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>