 
<?php $__env->startSection('title'); ?>
   Waybill details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
     <h1>Waybill details</h1>
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
            <i class="fa fa-list-alt"></i> 
            <div class="pull-right">
              <a href="<?php echo e(route('waybill.generate',$waybills->id)); ?>">
                <button class="btn btn-xs btn-primary ">Generate WayBill</button>
              </a>
              <?php if($waybills->has_closed): ?>
              <a href="<?php echo e(route('waybill-abstract.generate',$waybills->id)); ?>">
                <button class="btn btn-xs btn-primary ">Generate WayBill Abstract</button>
              </a>
              <?php endif; ?>
            </div>
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="#">
        <?php echo e(csrf_field()); ?>

    <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>WayBill Number</label>
            <input type="text" class="form-control" value="<?php echo e($waybills->waybill_number); ?>" disabled> 
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>From Date</label>
            <input type="text" class="form-control" value="<?php echo e($waybills->from_date); ?>" disabled> 
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>Vehicle Register Number</label>
            <input type="text" class="form-control" value="<?php echo e($waybills->vehicle->register_number); ?>||<?php echo e($waybills->vehicle->vehicleType->name); ?>" disabled> 
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>ETM</label>
            <input type="text" class="form-control" value="<?php echo e($waybills->etm->name); ?>||<?php echo e($waybills->etm->imei); ?>" disabled> 
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Schedule Name</label>
            <input type="text" class="form-control" value="<?php echo e($waybills->schedule->name); ?>" disabled> 
            <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>To Date</label>
            <input type="text" class="form-control" value="<?php echo e($waybills->to_date); ?>" disabled> 
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>Crew Name</label>
            <input type="text" class="form-control" value="<?php echo e($waybills->crew->name); ?>" disabled> 
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
          </div>
        </div>
   </div>
<!--  -->
    </form>
</section>

<div class="clearfix"></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>