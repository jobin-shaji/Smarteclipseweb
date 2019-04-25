

<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
</section>
<section class="content">
<div class="row">
  <?php if(auth()->check() && auth()->user()->hasRole('root')): ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <p id="users"><h3>0</h3></p>
              <p>Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/users" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
  <?php endif; ?>
  <?php if(auth()->check() && auth()->user()->hasRole('state')): ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua bxs">
            <div class="inner">
              <h3 id="employees"><div class="loader"></div></h3>
              <p>Employees</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/employees" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="vehicles"><div class="loader"></div></h3>
              <p>Vehicles</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-bus"></i>
            </div>
            <a href="/vehicles" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3 id="depots"><div class="loader"></div></h3>
              <p>Depots</p>
            </div>
            <div class="icon">
              <i class="ion ion-arrow-shrink"></i>
            </div>
            <a href="/depots" class="small-box-footer">View<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="etms"><div class="loader"></div></h3>
              <p>ETM's</p>
            </div>
            <div class="icon">
              <i class="ion ion-social-android"></i>
            </div>
            <a href="/etms" class="small-box-footer">View<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      <a href="#">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Routes</span>
              <span class="info-box-number" id="routes">--</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </a>
      <a href="/stages">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Stages</span>
              <span class="info-box-number" id="stages">--</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </a>
  <?php endif; ?>
  <?php if(auth()->check() && auth()->user()->hasRole('depot')): ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="vehicles"><div class="loader"></div></h3>
              <p>Vehicles</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-bus"></i>
            </div>
            <a href="/vehicle-list" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="employees"><div class="loader"></div></h3>
              <p>Employees</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href="/employee-list" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
       <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="collection"><div class="loader"></div></h3>
              <p>Total collection</p>
            </div>
            <div class="icon">
              <i class="ion ion-clock"></i>
            </div>
            <a href="#" class="small-box-footer">-</a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="expense"><div class="loader"></div></h3>
              <p>Total Expense</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="#" class="small-box-footer">-</a>
          </div>
        </div>
        <!-- ./col -->
      <a href="/stage-wise-report">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-ticket"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Tickets</span>
              <span class="info-box-number" id="tickets">--</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </a>

  <?php endif; ?>

    <?php if(auth()->check() && auth()->user()->hasRole('waybill')): ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="waybill"><div class="loader"></div></h3>
              <p>Active Waybills</p>
            </div>
            <div class="icon">
              <i class="ion ion-clock"></i>
            </div>
            <a href="#" class="small-box-footer">-</a>
          </div>
        </div>
        <!-- ./col -->
       <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="collection"><div class="loader"></div></h3>
              <p>Total collection</p>
            </div>
            <div class="icon">
              <i class="ion ion-clock"></i>
            </div>
            <a href="#" class="small-box-footer">-</a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="expense"><div class="loader"></div></h3>
              <p>Total Expense</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="#" class="small-box-footer">-</a>
          </div>
        </div>
        <!-- ./col -->
      <a href="/stage-wise-report">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-ticket"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Tickets</span>
              <span class="info-box-number" id="tickets">--</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </a>

  <?php endif; ?>
</div>
      
</section>
  <?php $__env->startSection('script'); ?>
      <script src="<?php echo e(asset('js/etm/dashb.js')); ?>"></script>
  <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>