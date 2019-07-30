<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Advance Booker Wise
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Advance Booker Wise</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Advance Booker Wise 
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Advance Booker No</th>
                              <th>Advance Booker Name</th>
                              <th>Bus Stand</th>
                              <th>Ordinary/HVAC/Mini Bus Amount</th>
                              <th>Ordinary/HVAC/Mini Commission</th>
                              <th>Integral Coach Buses Amount</th>
                              <th>Integral Coach Buses Commission</th>
                              <th>Total Advance Booking</th>
                              <th>No of Days Working</th>
                              <th>No of Buses</th>
                              <th>Avg per day</th>
                              <th>Total Commission</th>
                              <th>Recovery if any</th>
                              <th>TDS</th>
                              <th>Net Payable Amount</th>
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