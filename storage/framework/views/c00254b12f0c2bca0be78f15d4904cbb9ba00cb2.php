

<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        GST On AC Buses Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">GST On AC Buses Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">GST On AC Buses Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th colspan="3">KMs Covered</th>
                              <th colspan="3">Conductor No/Name</th>
                              <th colspan="3">Revenue</th>
                              <th colspan="3">SRT</th>
                              <th colspan="3">Net income(revenue-SRT)</th>
                              <th colspan="3">GST</th>
                            </tr>

                                <tr>
                                  <th></th>
                                  <th>PB</th>
                                  <th>HR</th>
                                  <th>JK</th>
                                  <th>PB</th>
                                  <th>HR</th>
                                  <th>JK</th>
                                  <th>PB</th>
                                  <th>HR</th>
                                  <th>JK</th>
                                  <th>PB</th>
                                  <th>HR</th>
                                  <th>JK</th>
                                  <th>PB</th>
                                  <th>HR</th>
                                  <th>JK</th>
                                  <th>PB</th>
                                  <th>HR</th>
                                  <th>JK</th>
                            
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