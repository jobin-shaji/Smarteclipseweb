<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Conductor WayBill Abstract Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Conductor WayBill Abstract Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>WayBill Number</th>
                              <th>Bus</th>
                              <th>Driver</th>
                              <th>Conductor</th>
                              <th>Etm</th>
                              <th>Count of Assigned Trips</th>
                              <th>Assigned km</th>
                              <th>Date</th>
                              <th style="width:160px;">Action</th>
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
    <script src="<?php echo e(asset('js/etm/conductor-waybill-abstract-report.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>