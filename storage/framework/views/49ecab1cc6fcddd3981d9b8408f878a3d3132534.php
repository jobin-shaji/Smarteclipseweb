<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Bus Wise Covered, Missed and Excess Kms Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bus Wise Covered, Missed and Excess Kms Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Bus Wise Covered, Missed and Excess Kms Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Bus No</th>
                              <th>Bus Type</th>
                              <th>CNDR N0.</th>
                              <th>Rotation No.</th>
                              <th>Route No.</th>
                              <th>Revenue</th>
                              <th>Assigned Kms</th>
                              <th>Covered Kms</th>
                              <th>Missed Kms</th>
                              <th>Excess Kms</th>
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

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>