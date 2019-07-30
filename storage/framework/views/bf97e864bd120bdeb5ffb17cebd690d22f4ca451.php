<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Route Wise Conductor Comparative Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Route Wise Conductor Comparative Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Route Wise Conductor Comparative Report 
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Route No.</th>
                              <th>Route Name</th>
                              <th>Conductor Name/No</th>
                              <th>Amount</th>
                              <th>Covered KMs</th>
                              <th>EPKM</th>
                              <th>Gross EPKM</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td>--</td>
                              <td><?php echo e($item->trip_id); ?></td>
                              <td><?php echo e($item->name); ?></td>
                              <td><?php echo e($item->employee); ?></td>
                              <td><?php echo e($item->net_total_amount); ?></td>
                              <td><?php echo e($item->km); ?></td>
                              <td><?php echo e($item->epkm); ?></td>
                              <td>--</td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>