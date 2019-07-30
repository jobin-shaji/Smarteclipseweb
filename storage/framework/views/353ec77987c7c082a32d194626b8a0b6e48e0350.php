<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Schedule
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Schedule</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Schedule List 
                    <a href="<?php echo e(route('schedule.create')); ?>">
                    <button class="btn btn-xs btn-primary pull-right">Add new schedule</button>
                    </a>
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Name</th>
                              <th>Code</th>
                              <th>Action</th>
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
    <script src="<?php echo e(asset('js/etm/schedule-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>