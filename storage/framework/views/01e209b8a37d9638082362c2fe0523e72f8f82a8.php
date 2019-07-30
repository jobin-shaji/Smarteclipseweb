<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        State Wise Fare Report 
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">State Wise Fare Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Bus Type</th>
                              <th>State</th>
                              <th>Plain FPKM</th>
                              <th>Hill FPKM</th>
                              <th>Minimum Fare</th>
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
    <script src="<?php echo e(asset('js/etm/state-wise-report-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>