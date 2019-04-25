<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Concessional Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Concessional Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Concessional Report Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Waybill No.</th>
                              <th>Ticket No.</th>
                              <th>Voucher No</th>
                              <th>Category Name</th>
                              <th>From</th>
                              <th>To</th>
                              <th>No of Passenger</th>
                              <th>Actual Fare</th>
                              <th>Discount Amount</th>
                              <th>Fare Collection</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=1; ?>
                          <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concession_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <?php 
                            $actual_fare=$concession_data->actual_fare;
                            $collected_fare=$concession_data->fare_collection;
                            $discount_amount=$actual_fare-$collected_fare;
                            ?>
                            <td><?php echo e($i++); ?></td>
                            <td><?php echo e($concession_data->waybill_no); ?></td>
                            <td><?php echo e($concession_data->ticket_no); ?></td>
                            <td><?php echo e($concession_data->voucher_no); ?>-</td>
                            <td><?php echo e($concession_data->category_name); ?></td>
                            <td><?php echo e($concession_data->from); ?></td>
                            <td><?php echo e($concession_data->to); ?></td>
                            <td><?php echo e($concession_data->no_of_passenger); ?></td>
                            <td><?php echo e($actual_fare); ?></td>
                            <td><?php echo e($discount_amount); ?></td>
                            <td><?php echo e($collected_fare); ?></td>
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