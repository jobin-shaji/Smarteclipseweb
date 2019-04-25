<?php $__env->startSection('title'); ?>
  Add Depot
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Create Depot</h1>
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
            <i class="fa fa-home"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="<?php echo e(route('depots.create.p')); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Depot Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('depot_name') ? ' has-error' : ''); ?>" placeholder="Depot Name" name="depot_name" value="<?php echo e(old('depot_name')); ?>" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('depot_name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('depot_name')); ?></strong>
                </span>
              <?php endif; ?>

               <div class="form-group has-feedback">
                <label class="srequired">Depot Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('depot_code') ? ' has-error' : ''); ?>" placeholder="Depot Code" name="depot_code" value="<?php echo e(old('depot_code')); ?>" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('depot_code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('depot_code')); ?></strong>
                </span>
              <?php endif; ?>
               <div class="form-group has-feedback">
                <label class="srequired">State</label>
                <select class="form-control <?php echo e($errors->has('disrict') ? ' has-error' : ''); ?>" id="stateData" placeholder="States" name="state" value="<?php echo e(old('state')); ?>" required>
                  <option value="">Select</option>
                  <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>
                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
              </div>
              <?php if($errors->has('state')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('district')); ?></strong>
                </span>
              <?php endif; ?>

             <div class="form-group has-feedback">
                <label class="srequired">District</label>
                <select class="form-control <?php echo e($errors->has('disrict') ? ' has-error' : ''); ?>" placeholder="Districts" id="district" name="district" value="<?php echo e(old('disrict')); ?>" required>
                  <option value="">Select</option>
                </select>
              </div>
              <?php if($errors->has('district')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('district')); ?></strong>
                </span>
              <?php endif; ?>


               <div class="form-group has-feedback">
                <label class="srequired">Email</label>
                <input type="text" class="form-control <?php echo e($errors->has('email') ? ' has-error' : ''); ?>" placeholder="Email" name="email" value="<?php echo e(old('email')); ?>" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('email')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('email')); ?></strong>
                </span>
              <?php endif; ?>


                  
       



           </div>





              <div class="col-md-6">

                <div class="form-group has-feedback">
                    <label class="srequired">User Name</label>
                    <input type="user_name" class="form-control <?php echo e($errors->has('user_name') ? ' has-error' : ''); ?>" placeholder="Username" name="user_name" value="<?php echo e(old('user_name')); ?>" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <?php if($errors->has('user_name')): ?>
                 <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('user_name')); ?></strong>
                 </span>
                <?php endif; ?>

                
                <div class="form-group has-feedback">
                    <label class="srequired">Password</label>
                    <input type="password" class="form-control <?php echo e($errors->has('password') ? ' has-error' : ''); ?>" placeholder="Password" name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <label class="srequired">Confirm password</label>
                    <input type="password" class="form-control <?php echo e($errors->has('password') ? ' has-error' : ''); ?>" placeholder="Retype password" name="password_confirmation" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <?php if($errors->has('password')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('password')); ?></strong>
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
    <script src="<?php echo e(asset('js/etm/depot-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>