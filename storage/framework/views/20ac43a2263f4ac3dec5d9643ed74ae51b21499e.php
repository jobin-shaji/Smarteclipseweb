<?php $__env->startSection('title'); ?>
  All Stage
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<!--  flash message -->
 <?php if(Session::has('message')): ?>
        <div class="pad margin no-print">
          <div class="callout <?php echo e(Session::get('callout-class', 'callout-success')); ?>" style="margin-bottom: 0!important;">
            <?php echo e(Session::get('message')); ?>  
          </div>
        </div>
    <?php endif; ?>
 <!-- end flash message -->

 <section class="content-header">
      <h1>
        Stage
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Stage</li>
      </ol>
</section>

 <section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Stage List 
                    <a href="<?php echo e(route('stages.create')); ?>">
                    <button class="btn btn-xs btn-primary pull-right">Add new Stage</button>
                    </a>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                        <tr>
	                      <th>#</th>
	                      <th>Name</th>
	                      <th>Code</th>
	                      <th style="width:160px;">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('js/etm/stage-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>