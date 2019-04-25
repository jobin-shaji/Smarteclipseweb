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
                <div class="row" style="margin-bottom: 13px;">
                   <div class="col-md-3">
                      <select class="form-control selectpicker" data-live-search="true" title="Select ETM No" id="etm">
                          <?php $__currentLoopData = $etm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($etm->id); ?>"><?php echo e($etm->name); ?>(<?php echo e($etm->imei); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>

                    </div> 
                    <label> From Date</label>
                  <input type="date" id="fromDate" name="fromDate">
                  <label> To date</label>
                  <input type="date" id="toDate" name="toDate">
                  <button class="btn btn-xs btn-info" onclick="check()"> <i class="fa fa-filter"></i> Filter </button>
                 <!--  <button class="btn btn-xs btn-primary pull-right" onclick="downloadSingleetmcollection()">
                    <i class="fa fa-file"></i> Download Excel</button> -->
                    </div>
                 
               
              </div>
                
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Date</th>
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
    <script src="<?php echo e(asset('js/etm/etm-single-collection.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>