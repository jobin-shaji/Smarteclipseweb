<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Single Route Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Single Route Report</li>
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
                  <button class="btn btn-xs btn-primary pull-right" onclick="downloadSingleRoute()">
                    <i class="fa fa-file"></i> Download Excel</button>
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                  <div class="row" style="margin-bottom: 13px;">
                    <div class="col-md-3">
                      <label>Select Route:</label>
                      <select class="form-control selectpicker" data-live-search="true" title="Select Route" id="route">
                        <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($route->id); ?>"><?php echo e($route->code); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                  </div>
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Date</th>
                              <th>Covered KM</th>
                              <th>Missed KM</th>
                              <th>Collection</th>
                              <th>Advance Booking Amount</th>
                              <th>Total Collection</th>
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
    <script src="<?php echo e(asset('js/etm/single-route-report.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>