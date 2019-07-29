<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Conductor Wise Covered, Missed and Excess Kms Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Conductor Wise Covered, Missed and Excess Kms Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Conductor Wise Covered, Missed and Excess Kms Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Date</th>
                              <th>Conductor No/Name</th>
                              <th>Rotation No.</th>
                              <th>Route No.</th>
                              <th>Waybill No.</th>
                              <th>Assigned Kms</th>
                              <th>Covered Kms</th>
                              <th>Missed Kms</th>
                              <th>Revenue</th>
                              <th>EPKM</th>
                              <th>Conc/Police Amount</th>
                              <th>Gross Revenue</th>
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

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>