

<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Trip Wise Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Trip Wise Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Trip Wise Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Trip No</th>
                              <th>Trip Date</th>
                              <!-- <th>Route Details</th> -->
                              <th>KMs</th>
                              <th>No Of Full Ticket</th>
                              <th>No Of Half Ticket</th>
                              <th>No Of Luggage Ticket</th>
                              <th>No Of Prisoner Ticket</th>
                              <th>No Of Old Woman Ticket</th>
                              <th>Full Ticket Amount</th>
                              <th>Half Ticket Amount</th>
                              <th>Net Total Amount</th>
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
    <script src="<?php echo e(asset('js/etm/trips-wise-report.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>