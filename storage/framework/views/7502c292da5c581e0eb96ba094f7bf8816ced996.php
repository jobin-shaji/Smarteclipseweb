

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
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps"><div class="loader"></div></h3>
              <p>GPS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
               <h3 id="dealer"><div class="loader"></div></h3>
              <p>Dealers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="sub_dealer"><div class="loader"></div></h3>
              <p>Sub Dealers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/sub-dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="client"><div class="loader"></div></h3>
              <p>Clients</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/client" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <!-- ./col -->
        <a href="">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-blue"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Vehicle</span>
                <span class="info-box-number" id="stages">
                  <h3 id="vehicle"><div class="loader"></div></h3>
                </span>
              </div>
            </div>
            <!-- /.info-box -->
          </div>
        </a>
        <!-- ./col -->
  <?php endif; ?>

   <?php if(auth()->check() && auth()->user()->hasRole('dealer')): ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">              
              <h3 id="gps_dealer"><div class="loader"></div></h3>
              <p>GPS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps-dealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
               <h3 id="dealer_subdealer"><div class="loader"></div></h3>              
              <p>Sub Dealers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/subdealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->       
  <?php endif; ?>
   <?php if(auth()->check() && auth()->user()->hasRole('sub_dealer')): ?>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="subdealer_gps"><div class="loader"></div></h3>              
              <p>GPS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps-transfers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="subdealer_client"><div class="loader"></div></h3>  
              <p>Client</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/clients" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
   <?php endif; ?>
   <?php if(auth()->check() && auth()->user()->hasRole('client')): ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="client_gps"><div class="loader"></div></h3>
              <p>GPS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
               <h3 id="client_vehicle"><div class="loader"></div></h3>
              <p>Vehicle</p>
            </div>
            <div class="icon">
              <i class="ion ion-model-s"></i>
            </div>
            <a href="" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="geofence"><div class="loader"></div></h3>
              <p>Geofence</p>
            </div>
            <div class="icon">
              <!-- <i class="ion ion-person-add"></i> -->
            </div>
            <a href="" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="row">
          <!-- alert report-start -->
          <div class="col-xs-6">
            <div class="box box-danger">
              <div class="box-header ui-sortable-handle" style="cursor: move;">
                <i class="fa fa-bell-o"></i>
                <h3 class="box-title">Alert List</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <ul class="list-group">
                  <?php if($alerts): ?>
                    <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item">
                    <!-- drag handle -->
                    <span class="handle ui-sortable-handle">
                      <i class="fa fa-ellipsis-v"></i>
                      <i class="fa fa-ellipsis-v"></i>
                    </span>
                        
                    <!-- todo text -->
                    <span class="text"><?php echo e($alert->alertType->description); ?></span>
                    [<span class="text-primary" style="color:#000;"> <?php echo e($alert->vehicle->name); ?> - <?php echo e($alert->vehicle->register_number); ?></span>]
                        <?php 
                              $alert_time=$alert->created_at;
                              $alert_status=$alert->status;
                         ?>
                         <br>
                        <!-- Emphasis label -->
                        <small class="label label-danger" style="font-size: 13px;     margin: 0px 12px;"><i class="fa fa-clock-o"></i> <?php echo e($alert_time); ?></small>
                        <?php if($alert_status==0): ?>
                          <small class="label label-danger pull-right" style="font-size: 13px;"><?php echo "Pending"; ?></small>
                        <?php else: ?>
                          <small class="label label-success pull-right" style="font-size: 13px;"><?php echo "Success"; ?></small>
                        <?php endif; ?>
                        <!-- General tools such as edit or delete-->
                      </li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                      <h4 class="text-info"> Sorry!! waiting for alerts.....</h4>
                    <?php endif; ?>
                      
                    </ul>
                  </div>
                  <!--Alert report-end -->
                </div>
          </div>
          <div class="col-xs-6">
            <!-- documents report -start -->
            <div class="box box-danger">
                  <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="fa fa-file"></i>
                    <h3 class="box-title">Expired Documents List</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="list-group">
                      <?php if($expired_documents): ?>
                        <?php $__currentLoopData = $expired_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expired): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item">
                          <!-- drag handle -->
                          <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          
                          <!-- todo text -->
                          <span class="text-danger"><?php echo e($expired->documentType->name); ?> expired on <?php echo e($expired->expiry_date); ?></span>
                          [<span class="text-primary" style="color:#000;"><?php echo e($expired->vehicle->name); ?> - <?php echo e($expired->vehicle->register_number); ?></span>]

                          <div class="card-link pull-right">
                            <?php $id=Crypt::encrypt($expired->vehicle_id); ?>
                            <a href="<?php echo e(route('vehicle.documents',$id)); ?>" class="c-link">View
                            <i class="fa fa-angle-right"></i>
                            </a>
                            
                          </div>
                          <!-- General tools such as edit or delete-->
                        </li>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                        <h4 class="text-info"> </h4>
                      <?php endif; ?>
                      
                    </ul>
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="list-group">
                      <?php if($expire_documents): ?>
                        <?php $__currentLoopData = $expire_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expired): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item">
                          <!-- drag handle -->
                          <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          
                          <!-- todo text -->
                          <span class="text-danger"><?php echo e($expired->documentType->name); ?> will expire on <?php echo e($expired->expiry_date); ?></span>
                          [<span class="text-primary" style="color:#000;"><?php echo e($expired->vehicle->name); ?> - <?php echo e($expired->vehicle->register_number); ?></span>]

                          <div class="card-link pull-right">
                            <?php $id=Crypt::encrypt($expired->vehicle_id); ?>
                            <a href="<?php echo e(route('vehicle.documents',$id)); ?>" class="c-link">View
                            <i class="fa fa-angle-right"></i>
                            </a>
                            
                          </div>
                          <!-- General tools such as edit or delete-->
                        </li>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                        <h4 class="text-info"> </h4>
                      <?php endif; ?>
                      
                    </ul>
                  </div>
                  <!--Documents report-end -->
                </div>
          </div>
        </div>

  <?php endif; ?>

</div>
      
</section>
  <?php $__env->startSection('script'); ?>
      <script src="<?php echo e(asset('js/gps/dashb.js')); ?>"></script>
  <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.gps', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>