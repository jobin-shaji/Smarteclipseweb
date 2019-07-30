<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Trip wise Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Rotation No</th>
                              <th>Route No</th>
                              <th>Conductor No</th>
                              <th>Driver No</th>
                              <th>Bus No</th>
                              <th>KMs assigned</th>
                              <th>KMs covered</th>
                              <th>Revenue</th>
                              <th>Advance Booking</th>
                              <th>Total Revenue</th>
                              <th>EPKM</th>
                              <th>conce/police Amount</th>
                              <th>Gross revenue</th>
                              <th>Gross EPKM</th>
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
    <script src="<?php echo e(asset('js/etm/epkm-report-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>