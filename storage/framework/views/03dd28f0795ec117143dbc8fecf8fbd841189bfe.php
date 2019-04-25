<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Waybill wise trip
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Waybill wise trip</li>
      </ol>
</section>


<section class="content">
  <div class="row" >
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Waybill wise trip
                    
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                  <div class="row" style="margin-bottom: 13px;">
                   <div class="col-md-3">
                      <select class="form-control selectpicker" data-live-search="true" title="Select Waybill No" id="waybill">
                        <?php $__currentLoopData = $waybills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waybill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($waybill->id); ?>"><?php echo e($waybill->code); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                    </div>
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">

                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>TripID</th>
                              <th>Route Name</th>
                              <th>Number Of Tickets</th>
                              <th>Total Amount</th>
                              <th>EPKM</th>
                            </tr>
                        </thead>
                    </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('js/etm/waybill-wise-trip-report.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>