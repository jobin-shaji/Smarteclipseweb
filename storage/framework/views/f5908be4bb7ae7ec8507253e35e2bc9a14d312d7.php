
<?php $__env->startSection('title'); ?>
  All Employee
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
        Employee
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Employee List</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Employees  
                    <a href="<?php echo e(route('employees.create')); ?>">
                    <button class="btn btn-xs btn-primary pull-right">Add new employee</button>
                    </a>
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Employee Code</th>
                              <th>Name</th>
                              <th>Designation</th>
                              <th>Address</th>
                              <th>DOB</th>
                              <th>Mobile</th>
                              <th>Blood Group</th>
                              <th>PF No.</th>
                              <th>Employement Type</th>
                              <th>Depot</th>
                              <th>Username</th>
                              <th>Password</th>
                              <th style="width:160px;">Action</th>
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
    <script src="<?php echo e(asset('js/etm/employee-list.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>