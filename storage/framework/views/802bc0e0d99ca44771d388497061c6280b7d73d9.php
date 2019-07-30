
<?php $__env->startSection('title'); ?>
  Depot Details
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="content-header">
    <h1>Depot Details</h1>
</section>
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
      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Depot Name</label>
                <input type="text" class="form-control <?php echo e($errors->has('depot_name') ? ' has-error' : ''); ?>" placeholder="Depot Name" name="depot_name" value="<?php echo e($depot->name); ?>" readonly> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
             

               <div class="form-group has-feedback">
                <label class="srequired">Depot Code</label>
                <input type="text" class="form-control <?php echo e($errors->has('depot_code') ? ' has-error' : ''); ?>" placeholder="Depot Code" name="depot_code" value="<?php echo e($depot->code); ?>" readonly> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              
              <div class="form-group has-feedback">
                <label class="srequired">District</label>
                <input type="text" class="form-control <?php echo e($errors->has('disrict') ? ' has-error' : ''); ?>" placeholder="District" name="disrict"  value="<?php echo e($depot->district->name); ?>" readonly> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
           </div>

        </div>
          

</section>
 
 <section class="hilite-content">
  <div class="row">
    <div class="col-xs-8">
      <div class="row">
        <div class="col-md-6">
        <h2 class="page-header">
          <i class="fa fa-plus"> Depot Users</i> 
        </h2>
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
                      </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $depot->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                          <td><?php echo e($loop->iteration); ?></td>
                          <td><?php echo e($user->username); ?></td>
                          <td><?php echo e($user->email); ?></td>
                          <td>*******<td>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
              </table>
           </div> 
    </div>
  </div>
</section>

<div class="clearfix"></div>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>