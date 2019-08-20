<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Daily Revenue Statement
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Daily Revenue Statement</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Daily Revenue Statement Report List  
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Waybill No</th>
                              <th>Code no</th>
                              <th>Psngr Amount</th>
                              <th>Lgg Amt</th>
                              <th>Old Woman</th>
                              <th>Han Cap</th>
                              <th>Total Amt</th>
                              <th colspan="6">Expenses</th>
                              <th>NET AMT</th>
                              <th>ADV BKNG</th>
                            </tr>

                                <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th>Toll Fee</th>
                                  <th>Adda Fee</th>
                                   <th>Repr Exp</th>
                                  <th>MISC exp</th>
                                   <th>TOT EXP</th>
                                  <th>Prisoner</th>
                                <th></th>
                                <th></th>

                                
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