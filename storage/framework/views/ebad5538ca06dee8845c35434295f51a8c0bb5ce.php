
<?php $__env->startSection('title'); ?>
  Edit Depot
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>Edit Depot</h1>
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
     <form  method="POST" action="<?php echo e(route('depots.update.p',$depot->id)); ?>">
        <?php echo e(csrf_field()); ?>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Depot Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('depot_name') ? ' has-error' : ''); ?>" placeholder="Depot Name" name="depot_name" value="<?php echo e($depot->name); ?>" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('depot_name')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('depot_name')); ?></strong>
                </span>
              <?php endif; ?>

               <div class="form-group has-feedback">
                <label class="srequired">Depot Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('depot_code') ? ' has-error' : ''); ?>" placeholder="Depot Code" name="depot_code" value="<?php echo e($depot->code); ?>" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              <?php if($errors->has('depot_code')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('depot_code')); ?></strong>
                </span>
              <?php endif; ?>


              <div class="form-group has-feedback">
                <label class="srequired">District</label>
                <select class="form-control <?php echo e($errors->has('disrict') ? ' has-error' : ''); ?>" placeholder="Districts" name="district" value="<?php echo e(old('disrict')); ?>" required>
                  <option value="">Select</option>
                  <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option  value="<?php echo e($district->id); ?>" <?php if($district->id==$depot->district_id): ?><?php echo e("selected"); ?> <?php endif; ?>><?php echo e($district->name); ?></option>
                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
              </div>
              <?php if($errors->has('district')): ?>
                <span class="help-block">
                    <strong class="error-text"><?php echo e($errors->first('district')); ?></strong>
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

<section class="hilite-content">
  <div class="row">
    <div class="col-xs-8">
      <div class="row">
        <div class="col-md-6">
        <h2 class="page-header">
          <i class="fa fa-plus"> Depot Users</i> 
        </h2>
        </div>
        <div class="col-md-6">
        <div class="clearfix"></div>
           <a href="#" class='btn btn-xs btn-success pull-right' data-toggle="modal" data-target="#myModal"><i class='glyphicon glyphicon-user'></i> Add User </a>

        </div>
      </div>
         <div class="panel-body">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                  <thead>
                      <tr>
                          <th>sl</th>
                          <th>username</th>
                          <th>Email</th>
                          <th>Password</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                      <tr>
                          <td><?php echo e($loop->iteration); ?></td>
                          <td><?php echo e($user->depotUser->username); ?></td>
                          <td><?php echo e($user->depotUser->email); ?></td>
                          <td>*******</td>
                          <td>
                             <a href="/depots-user/<?php echo e($user->user_id); ?>/change-password" class='btn btn-xs btn-warning'><i class='glyphicon glyphicon-cog'></i> Change password </a>

                            <a href="/depots-user/<?php echo e($user->user_id); ?>/edit" class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                            
                             <a href="/depots-user/<?php echo e($user->id); ?>/delete" class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-trash'></i> Delete</a>

                          </td>
                      </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
              </table>
           </div> 
    </div>
  </div>
</section>


<!-- add depot user -->
 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Depot User</h4>
      </div>
      <div class="modal-body">
            <form  method="POST" action="<?php echo e(route('depots-user.create.p')); ?>">
                    <?php echo e(csrf_field()); ?>

                  <input type="hidden" name="depot" value="<?php echo e($depot->id); ?>"> 
                  <div class="row">
                          <div class="col-md-12">
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

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
   </div>
 </div>
<!-- add depot user -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>