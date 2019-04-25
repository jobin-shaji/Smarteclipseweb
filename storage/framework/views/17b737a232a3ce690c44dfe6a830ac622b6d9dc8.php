<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
       Route Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Routes</li>
      </ol>
</section>


<section class="content ">

<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-body h4"> <span class="label label-danger"> #<?php echo e($route->code); ?> </span> &nbsp; <span class="label label-primary"> <?php echo e($route->fromStage->name); ?> to <?php echo e($route->toStage->name); ?> </span> &nbsp; <span class="label label-warning"> <?php echo e($route->total_km); ?> KM's </span></div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
        <div class="form-group">
          <select class="form-control">
            <option selected disabled>Choose Vehicle Type</option>
            <?php $__currentLoopData = $vehicle_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="form-group">
          <button class="btn btn-success btn-block" onclick="downloadFareSlab(<?php echo e($route->id); ?>)">Download Fare Slab</button>
        </div>
    </div>
  </div>
</div>


<div class="col-sm-2"></div>
  <div class="container">
    <div class="row col-md-6">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Stage</th>
            <th>Depot</th>
            <th>State</th>
            <th>KM</th>
            <th>Toll</th>
            <th>Border</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $route->stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td><?php echo e($stage->name); ?></td>
            <td><?php echo e($stage->depot->name); ?></td>
            <td><?php echo e($stage->depot->state->name); ?></td>
            <td><?php echo e($stage->pivot->km); ?></td>
            <?php $toll = ($stage->toll ? 'Yes' : 'No')?>
            <td><?php echo e($toll); ?></td>
            <?php $border = ($stage->border_status ? 'Yes' : 'No')?>
            <td><?php echo e($border); ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>