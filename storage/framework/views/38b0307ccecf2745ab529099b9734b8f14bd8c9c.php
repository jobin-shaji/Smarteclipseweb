<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Stage Wise/Time Wise Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Stage Wise/Time Wise Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Stage Wise/Time Wise Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Ticket No</th>
                              <th>Date</th>
                              <th>Time</th>
                              <th>From Stage</th>
                              <th>To Stage</th>
                              <th>Full</th>
                              <th>Half</th>
                              <th>SPL</th>
                              <th>Lugg</th>
                              <th>Pass</th>
                              <th>Ticket Amount</th>
                              <th>Remarks</th>
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
    <script src="<?php echo e(asset('js/etm/stagewise-report-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>