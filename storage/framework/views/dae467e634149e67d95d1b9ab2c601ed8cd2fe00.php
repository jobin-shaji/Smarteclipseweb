<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Depot Wise Advance Booking Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Depot Wise Advance Booking Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Depot Wise Advance Booking Report 
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Date</th>
                              <th>Advance Booker Name/No</th>
                              <th>Bus No</th>
                              <th>Bus Type</th>
                              <th>Depot of Bus</th>
                              <th>Conductor no</th>
                              <th>route</th>
                              <th>Amount</th>
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