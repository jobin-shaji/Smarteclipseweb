 
<?php $__env->startSection('title'); ?>
   State tax details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
     <h1>State tax details</h1>
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
            <i class="fa fa-dashcube"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="#">
        <?php echo e(csrf_field()); ?>

    <div class="row">
        <div class="col-md-6">

          <div class="form-group has-feedback">
            <label>State</label>
            <input type="text" class="form-control"  value="<?php echo e($state_tax->state->name); ?>" disabled> 
          </div>

          <div class="form-group has-feedback">
            <label>Percentage</label>
            <input type="text" class="form-control"  value="<?php echo e($state_tax->percentage); ?>" disabled> 
          </div>
        </div>
   </div>
<!--  -->
    </form>
</section>

<div class="clearfix"></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>