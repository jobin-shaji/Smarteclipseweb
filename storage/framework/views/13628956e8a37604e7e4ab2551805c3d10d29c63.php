

<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        State Amount Bifurcation Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">State Amount Bifurcation Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">State Amount Bifurcation Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Waybill</th>
                              <th>Conductor No/Name</th>
                              <th>CH Amount</th>
                              <th>DL Amount</th>
                              <th>HP Amount</th>
                              <th>HR Amount</th>
                              <th>JK Amount</th>
                              <th>PB Amount</th>
                              <th>RJ Amount</th>
                              <th>UK Amount</th>
                              <th>UP Amount</th>
                              <th>Total</th>
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