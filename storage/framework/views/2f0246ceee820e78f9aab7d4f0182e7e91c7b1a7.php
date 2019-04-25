<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        ETM Collection Report
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ETM Collection Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">
                  <label> from Date</label>
                  <input type="date" id="fromDate" name="fromDate">
                  <label> to date</label>
                  <input type="date" id="toDate" name="toDate">
                  <button class="btn btn-xs btn-info" onclick="check()"> <i class="fa fa-filter"></i> Filter </button>

                 <button class="btn btn-xs btn-primary pull-right" onclick="downloadetmcollection()">
                <i class="fa fa-file"></i> Download Excel</button>
              </div>

                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>ETM</th>
                              <th>Way Bill</th>        
                              <th>Total Amount</th>
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
    <script src="<?php echo e(asset('js/etm/etmCollection-report-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>